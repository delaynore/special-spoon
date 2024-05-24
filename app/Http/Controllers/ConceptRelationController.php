<?php

namespace App\Http\Controllers;

use App\Models\Concept;
use App\Models\ConceptRelation;
use App\Models\Dictionary;
use App\Models\RelationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class ConceptRelationController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create(Dictionary $dictionary, Concept $concept)
    {
        $relationTypes = RelationType::all();
        $concepts = $dictionary->concepts()->orderBy('name')->get();
        return view('concept-relation.create', compact('dictionary','concept', 'relationTypes', 'concepts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Dictionary $dictionary, Concept $concept)
    {
        $validated = $request->validate([
            'fk_concept_1_id' => 'required|uuid|exists:concepts,id',
            'fk_concept_2_id' => 'required|uuid|exists:concepts,id|different:fk_concept_1_id',
            'fk_relation_type_id'=> 'required|uuid|exists:relation_types,id',
        ]);
        $sameRelation = ConceptRelation::where('fk_relation_type_id', $validated['fk_relation_type_id'])->where('fk_concept_1_id', $validated['fk_concept_1_id'])
        ->where('fk_concept_2_id', $validated['fk_concept_2_id'])
        ->orWhere('fk_concept_2_id', $validated['fk_concept_1_id'])->where('fk_concept_1_id', $validated['fk_concept_2_id']);
        if ($sameRelation->count() > 0) {
            $messages = ['max' => __('dashboard.relation.create.errors.exist')];
            Validator::validate($request->all(), [
                'fk_relation_type_id' => 'max:0'
            ], $messages);
        }
        ConceptRelation::create($validated);

        return redirect()->route('concept.show', compact('dictionary', 'concept'))->with('success', __('dashboard.relation.messages.created'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $dictionary, string $concept, string $conceptRelation)
    {
        $dictionary = Dictionary::findOrFail($dictionary);
        Gate::authorize('must-be-owner', $dictionary);

        $relationTypes = RelationType::all();
        $concepts = $dictionary->concepts()->orderBy('name')->get();
        $conceptRelation = ConceptRelation::findOrFail($conceptRelation);
        $concept = Concept::findOrFail($concept);
        return view('concept-relation.edit', compact('dictionary', 'concept', 'conceptRelation', 'relationTypes', 'concepts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $dictionary, string $concept, string $conceptRelation)
    {
        $dictionary = Dictionary::findOrFail($dictionary);
        Gate::authorize('must-be-owner', $dictionary);

        $validated = $request->validate([
            'fk_concept_1_id' => 'required|uuid|exists:concepts,id',
            'fk_concept_2_id' => 'required|uuid|exists:concepts,id|different:fk_concept_1_id',
            'fk_relation_type_id'=> 'required|uuid|exists:relation_types,id',
        ]);
        $sameRelation = ConceptRelation::where('fk_relation_type_id', $validated['fk_relation_type_id'])->where('fk_concept_1_id', $validated['fk_concept_1_id'])
        ->where('fk_concept_2_id', $validated['fk_concept_2_id'])
        ->orWhere('fk_concept_2_id', $validated['fk_concept_1_id'])->where('fk_concept_1_id', $validated['fk_concept_2_id']);
        if ($sameRelation->count() > 1) {
            $messages = ['max' => __('dashboard.relation.create.errors.exist')];
            Validator::validate($request->all(), [
                'fk_relation_type_id' => 'max:0'
            ], $messages);
        }

        $conceptRelation = ConceptRelation::findOrFail($conceptRelation);
        $conceptRelation->updateOrFail($validated);
        return redirect()->route('concept.show', compact('dictionary', 'concept'))->with('success',__('dashboard.relation.messages.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $dictionary, string $concept, string $conceptRelation)
    {
        $dictionary = Dictionary::findOrFail($dictionary);
        Gate::authorize('must-be-owner', $dictionary);

        $conceptRelation = ConceptRelation::findOrFail($conceptRelation);

        $conceptRelation->delete();

        return redirect()->back()->with('error',__('dashboard.relation.messages.deleted'));
    }
}
