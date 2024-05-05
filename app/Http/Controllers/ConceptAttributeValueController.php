<?php

namespace App\Http\Controllers;

use App\Enums\DataType;
use App\Models\Concept;
use App\Models\ConceptAttributeValue;
use App\Http\Requests\StoreConceptAttributeValueRequest;
use App\Http\Requests\UpdateConceptAttributeValueRequest;
use App\Models\ConceptAttribute;
use Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConceptAttributeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Concept $concept)
    {
        // $concept = Concept::findOrFail($conceptId);

        if ($concept->attributes()->count() == 0) {
            return redirect()->back()
                ->with(
                    'error',
                    'Для создания экзмепляра необходимо добавить атрибуты в словарь'
                );
        }

        $dictionary = $concept->dictionary()->get()->first();

        return view("concept-attribute-value.create", compact('dictionary', 'concept'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Concept $concept)
    {
        $conceptAttr = $concept->attributes()->get();

        $exampleNumber = (Concept::where('concepts.id', $concept->id)
            ->join('concept_attributes', 'concepts.id', '=', 'concept_attributes.fk_concept_id')
            ->join('concept_attribute_values', 'concept_attributes.id', '=', 'concept_attribute_values.fk_concept_attribute_id')
            ->selectRaw('MAX(concept_attribute_values.example_number)')
            ->groupBy('concepts.name')
            ->first()->max ?? 0) + 1;

        foreach ($conceptAttr as $attr) {
            $value = $request->get($attr->id);
            $attribute = \App\Models\Attribute::find($attr->id);

            if ($attribute->type == DataType::BOOLEAN) {
                $value = $value == 'true' ? true : false;
            }

            $now = $conceptAttr->where('id', $attr->id)->first()->conceptAttributes()->where('fk_concept_id', $concept->id)->get()->first();
            $conceptAttributeValue = ConceptAttributeValue::create([
                'fk_concept_attribute_id' => $now->id,
                'value' => $value,
                'example_number' => $exampleNumber,
            ]);
            $conceptAttributeValue->saveOrFail();
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(ConceptAttributeValue $conceptAttributeValue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Concept $concept, string $exampleNumber)
    {
        // Получаем экземпляры - их цифры
        $exampleNumbers = ConceptAttributeValue::join('concept_attributes', 'concept_attribute_values.fk_concept_attribute_id', '=', 'concept_attributes.id')
            ->join('concepts', 'concept_attributes.fk_concept_id', '=', 'concepts.id')
            ->where('concept_attributes.fk_concept_id', $concept->id)
            ->selectRaw('concept_attribute_values.example_number')
            ->groupBy('concept_attribute_values.example_number')
            ->orderBy('concept_attribute_values.example_number')
            ->pluck('example_number');

        // Проверяем есть ли экземпляр с такой цифрой
        if (!$exampleNumbers->contains($exampleNumber)) {
            return abort(404);
        }

        $exampleAttributes = $results = ConceptAttributeValue::join('concept_attributes', 'concept_attribute_values.fk_concept_attribute_id', '=', 'concept_attributes.id')
            ->join('concepts', 'concept_attributes.fk_concept_id', '=', 'concepts.id')
            ->join('attributes', 'concept_attributes.fk_attribute_id', '=', 'attributes.id')
            ->where('concept_attributes.fk_concept_id', $concept->id)
            ->where('concept_attribute_values.example_number', $exampleNumber)
            ->selectRaw('attributes.name, attributes.type, concept_attribute_values.value, concept_attribute_values.id')
            ->orderBy('concept_attribute_values.example_number')
            ->orderBy('concept_attributes.created_at')
            ->get();
        // example {
        // attribute->name
        // attribute->type
        // value
        //}

        $dictionary = $concept->dictionary()->get()->first();
        return view('concept-attribute-value.edit', compact('dictionary', 'concept', 'exampleNumber', 'exampleAttributes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Concept $concept, int $exampleNumber)
    {
        // Нет пока проверки на пустые значения и вообще валидации.
        foreach ($request->all() as $id => $newValue) {
            if (str_starts_with($id, '_')) {
                continue;
            }
            $conceptAttributeValue = ConceptAttributeValue::find($id);
            if (!$conceptAttributeValue || $conceptAttributeValue->example_number != $exampleNumber) {
                return redirect()->back()->with('error', 'Такого атрибута не существует');
            }
            $conceptAttributeValue->value = $newValue;
            $conceptAttributeValue->saveOrFail();
        }
        $dictionary = $concept->dictionary()->get()->first();
        return redirect(route('concept.examples', [$dictionary, $concept]))->with('success', 'Экземпляр обновлен');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Concept $concept, int $exampleNumber)
    {
        ConceptAttributeValue::join('concept_attributes', 'concept_attribute_values.fk_concept_attribute_id', '=', 'concept_attributes.id')
            ->where('concept_attributes.fk_concept_id', $concept->id)
            ->where('concept_attribute_values.example_number', $exampleNumber)
            ->delete();

        return redirect()->back()->with('error', 'Экземпляр удален');
    }
}
