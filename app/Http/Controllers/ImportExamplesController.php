<?php

namespace App\Http\Controllers;

use App\Enums\DataType;
use App\Models\Attribute;
use App\Models\Concept;
use App\Models\ConceptAttribute;
use App\Models\ConceptAttributeValue;
use App\Models\Dictionary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use SplFileObject;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ImportExamplesController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create(Dictionary $dictionary, Concept $concept)
    {
        Gate::authorize('must-be-owner', $dictionary);

        $conceptAttributes = ConceptAttribute::join('attributes', 'attributes.id', '=', 'concept_attributes.fk_attribute_id')
            ->select('attributes.name', 'attributes.type', 'concept_attributes.id')
            ->where('concept_attributes.fk_concept_id', $concept->id)
            ->orderBy('concept_attributes.created_at', 'asc')
            ->get();

        if ($conceptAttributes->count() == 0) {
            return redirect()->back()->with('error', __('import.messsages.no-attributes'));
        }

        return view('import-examples.create', compact('dictionary', 'concept', 'conceptAttributes'));
    }

    public function export(Dictionary $dictionary, Concept $concept)
    {
        Gate::authorize('export-dictionary', $dictionary);

        $attributes = Attribute::join('concept_attributes', 'attributes.id', '=', 'concept_attributes.fk_attribute_id')
            ->where('concept_attributes.fk_concept_id', $concept->id)
            ->selectRaw('attributes.name')
            ->orderBy('concept_attributes.created_at')
            ->get();

        $attributesCount = $attributes->count();

        $fileName = $concept->name . '-examples.csv';
        $file = fopen(Storage::disk('local')->path($fileName), 'w');

        $header = "";
        foreach ($attributes as $n => $attribute) {
            $header .= $attribute->name;
            if ($n != $attributesCount - 1) {
                $header .= ";";
            }
        }
        $header .= "\n";
        fwrite($file, $header);

        $exampleNumbers = ConceptAttributeValue::join('concept_attributes', 'concept_attribute_values.fk_concept_attribute_id', '=', 'concept_attributes.id')
            ->join('concepts', 'concept_attributes.fk_concept_id', '=', 'concepts.id')
            ->where('concept_attributes.fk_concept_id', $concept->id)
            ->selectRaw('concept_attribute_values.example_number')
            ->groupBy('concept_attribute_values.example_number')
            ->orderBy('concept_attribute_values.example_number')
            ->pluck('example_number');

        foreach ($exampleNumbers as $exampleNumber) {
            ConceptAttributeValue::join('concept_attributes', 'concept_attribute_values.fk_concept_attribute_id', '=', 'concept_attributes.id')
                ->join('concepts', 'concept_attributes.fk_concept_id', '=', 'concepts.id')
                ->join('attributes', 'concept_attributes.fk_attribute_id', '=', 'attributes.id')
                ->where('concept_attributes.fk_concept_id', $concept->id)
                ->where('concept_attribute_values.example_number', $exampleNumber)
                ->selectRaw('concept_attribute_values.value')
                ->orderBy('concept_attribute_values.example_number')
                ->orderBy('concept_attributes.created_at')
                ->chunk(100, function ($results) use (&$file, $attributesCount) {
                    $line = "";
                    foreach ($results as $ex => $value) {
                        $line .= $value->value;
                        if ($ex != $attributesCount - 1) {
                            $line .= ";";
                        }
                    }
                    $line .= "\n";
                    fwrite($file, $line);
                });
        }

        fclose($file);

        return response()
            ->download(Storage::disk('local')->path($fileName), $fileName, ['Content-Type' => 'text/plain'])
            ->deleteFileAfterSend(true);
    } 
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Dictionary $dictionary, Concept $concept)
    {

        $validated = $request->validate([
            'file' => [
                'required',
                File::types(['txt', 'csv'])
                    ->max(10 * 1024),
            ],
        ]);

        $file = $request->file('file');

        $fileContent = $file->get();

        if ($fileContent == '') {
            return redirect()->back()->with('error', __('import.messsages.empty-file'));
        }

        $currentExampleNumber = (Concept::where('concepts.id', $concept->id)
            ->join('concept_attributes', 'concepts.id', '=', 'concept_attributes.fk_concept_id')
            ->join('concept_attribute_values', 'concept_attributes.id', '=', 'concept_attribute_values.fk_concept_attribute_id')
            ->selectRaw('MAX(concept_attribute_values.example_number)')
            ->groupBy('concepts.name')
            ->first()->max ?? 0) + 1;

        $conceptAttributes = ConceptAttribute::join('attributes', 'attributes.id', '=', 'concept_attributes.fk_attribute_id')
            ->select('attributes.name', 'attributes.type', 'concept_attributes.id')
            ->where('concept_attributes.fk_concept_id', $concept->id)
            ->orderBy('concept_attributes.created_at', 'asc')
            ->get();
        $currentLine = 1;
        $allExamples = [];
        foreach (preg_split("/\r\n|\n|\r/", $fileContent) as $line) {
            if ($line == '') {
                $currentLine++;
                continue;
            }
            $words = preg_split("/;/", $line);
            if (count($words) != count($conceptAttributes)) {
                return redirect()->back()->with(
                    "error",
                    __(
                        'import.messsages.invalid-amount-columns',
                        [
                            'line' => $currentLine,
                            'expected' => count($conceptAttributes),
                            'actual' => count($words)
                        ]
                    )
                );
            }
            $allExamples[$currentLine] = [];
            foreach ($words as $k => $word) {
                if ($word === '') {
                    return redirect()->back()->with(
                        "error",
                        __(
                            'import.messsages.empty-column',
                            [
                                'column' => $k + 1,
                                'line' => $currentLine
                            ]
                        )
                    );
                }

                $type = DataType::from($conceptAttributes[$k]->type);
                if ($this->isParsableTo($word, $type)) {
                    $parsed = $this->parseTo($word, $type);
                    $allExamples[$currentLine][$k] = new ConceptAttributeValue([
                        'fk_concept_attribute_id' => $conceptAttributes[$k]->id,
                        'value' => $parsed,
                        'example_number' => $currentExampleNumber
                    ]);
                } else {
                    return redirect()->back()->with("error", __('import.messsages.invalid-column', ['column' => $k + 1, 'line' => $currentLine]));
                }
            }

            $currentExampleNumber++;
            $currentLine++;
        }

        if (count($allExamples) === 0) {
            return redirect()->back()->with('error', __('import.messsages.no-valid-rows'));
        }

        DB::transaction(function () use ($allExamples) {
            foreach ($allExamples as $example) {
                foreach ($example as $value) {
                    $value->save();
                }
            }
        });

        return redirect()->back()->with("success", __('import.messsages.success', ['count' => count($allExamples)]));
    }

    function isParsableTo(string $s, DataType $type): bool
    {
        switch ($type) {
            case DataType::INTEGER:
                return ctype_digit($s);
            case DataType::DOUBLE:
            case DataType::DECIMAL:
                return is_numeric($s);
            case DataType::BOOLEAN:
                return in_array(strtolower($s), ['true', 'false'], true);
            case DataType::STRING:
                return true;
            default:
                return false;
        }
    }

    function parseTo(string $s, DataType $type): mixed
    {
        switch ($type) {
            case DataType::INTEGER:
                return (int) $s;
            case DataType::DOUBLE:
            case DataType::DECIMAL:
                return (float) ($s);
            case DataType::BOOLEAN:
                return $s;
            case DataType::STRING:
                return $s;
            default:
                return $s;
        }
    }
}
