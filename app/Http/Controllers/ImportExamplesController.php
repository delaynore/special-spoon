<?php

namespace App\Http\Controllers;

use App\Enums\DataType;
use App\Models\Concept;
use App\Models\ConceptAttribute;
use App\Models\ConceptAttributeValue;
use App\Models\Dictionary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\File;

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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Dictionary $dictionary, Concept $concept)
    {

        $validated = $request->validate([
            'file' => ['required', File::types(['txt', 'csv'])
                ->max(3 * 1024),],
        ]);

        $file = $request->file('file');

        $fileContent = $file->get();

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
            $words = preg_split("/;/", $line);
            if (count($words) != count($conceptAttributes)) {
                return redirect()->back()->with("error", "Неверное количество столбцов в строке $currentLine. Ожидалось " . count($conceptAttributes) . " столбцов, получено " . count($words));
            }
            $allExamples[$currentLine] = [];
            foreach ($words as $k => $word) {
                if($word == '') {
                    return redirect()->back()->with("error", "Столбец $k в строке $currentLine пустой");
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
                    $column = $k + 1;
                    return redirect()->back()->with("error", "Неверный тип данных в строке $currentLine, столбце $column");
                }
            }

            $currentExampleNumber++;
            $currentLine++;
        }
        foreach ($allExamples as $example) {
            foreach ($example as $value) {
                $value->save();
            }
        }

        return redirect()->back()->with("success", "Успешно добавлено " . count($allExamples) . " экземпляров");
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
                return (int)$s;
            case DataType::DOUBLE:
            case DataType::DECIMAL:
                return (float)($s);
            case DataType::BOOLEAN:
                return $s;
            case DataType::STRING:
                return $s;
            default:
                return $s;
        }
    }
}
