<?php

namespace App\Http\Controllers;

use App\Models\ConceptAttribute;
use App\Http\Requests\StoreConceptAttributeRequest;
use App\Http\Requests\UpdateConceptAttributeRequest;

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
    public function store(StoreConceptAttributeRequest $request)
    {
        //
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
