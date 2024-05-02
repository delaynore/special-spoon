<?php

namespace App\Http\Controllers;

use App\Models\Concept;
use App\Models\ConceptAttribute;
use App\Http\Requests\StoreConceptAttributeRequest;
use App\Http\Requests\UpdateConceptAttributeRequest;
use App\Models\Dictionary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConceptAttributeController extends Controller
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
    public function create(string $dictionary, string $concept)
    {
        return view('concept-attribute.create', compact('dictionary', 'concept'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Dictionary $dictionary,Concept $concept)
    {


        $validated = $request->validate([
            'attribute' => 'required|uuid|exists:attributes,id'
        ]);

        $conceptAttribute = ConceptAttribute::create([
            'fk_concept_id' => $concept->id,
            'fk_attribute_id' => $validated['attribute'],
        ]);

        $conceptAttribute->saveOrFail();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(ConceptAttribute $conceptAttribute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ConceptAttribute $conceptAttribute)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConceptAttributeRequest $request, ConceptAttribute $conceptAttribute)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ConceptAttribute $conceptAttribute)
    {
        //
    }
}
