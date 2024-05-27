<?php

namespace App\Http\Controllers;

use App\Models\Concept;
use App\Models\ConceptAttribute;
use App\Http\Requests\UpdateConceptAttributeRequest;
use App\Models\ConceptAttributeValue;
use App\Models\Dictionary;
use Illuminate\Http\Request;

class ConceptAttributeController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $dictionary, string $concept)
    {
        return view('concept-attribute.create', compact('dictionary', 'concept'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Dictionary $dictionary, Concept $concept)
    {


        $validated = $request->validate([
            'attribute' => 'required|uuid|exists:attributes,id'
        ]);

        $conceptAttribute = ConceptAttribute::create([
            'fk_concept_id' => $concept->id,
            'fk_attribute_id' => $validated['attribute'],
        ]);

        $conceptAttribute->saveOrFail();

        if ($concept->attributes()->count() > 1) {

            $exampleNumbers = ConceptAttributeValue::join('concept_attributes', 'concept_attribute_values.fk_concept_attribute_id', '=', 'concept_attributes.id')
                ->join('concepts', 'concept_attributes.fk_concept_id', '=', 'concepts.id')
                ->where('concept_attributes.fk_concept_id', $concept->id)
                ->selectRaw('concept_attribute_values.example_number')
                ->groupBy('concept_attribute_values.example_number')
                ->orderBy('concept_attribute_values.example_number')
                ->pluck('example_number');
            foreach ($exampleNumbers as $exampleNumber) {
                ConceptAttributeValue::create([
                    'fk_concept_attribute_id' => $conceptAttribute->id,
                    'example_number' => $exampleNumber,
                    'value' => ''
                ])->saveOrFail();
            }
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dictionary $dictionary, Concept $concept, string $conceptAttribute)
    {
        $conceptAttribute = ConceptAttribute::findOrFail($conceptAttribute);
        $conceptAttribute->deleteOrFail();
        return redirect()->back();
    }
}
