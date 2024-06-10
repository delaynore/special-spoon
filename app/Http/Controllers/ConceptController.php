<?php

namespace App\Http\Controllers;

use App\Models\Concept;
use App\Models\ConceptRelation;
use App\Models\Dictionary;
use App\Models\RelationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ConceptController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create(Dictionary $dictionary)
    {

        Gate::authorize("must-be-owner", $dictionary);

        if (request()->get('parentId') == null) {
            return view('concept.create', compact('dictionary'));
        }


        $parent = Concept::findOrFail(request()->get('parentId'));
        if (request()->get('brotherId') == null) {
            return view('concept.create', compact('dictionary', 'parent'));
        }

        $brother = Concept::findOrFail(request()->get('brotherId'));
        return view('concept.create', compact('dictionary', 'parent', 'brother'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $dictionaryId)
    {
        $dictionary = Dictionary::findOrFail($dictionaryId);
        Gate::authorize('must-be-owner', $dictionary);
        $validated = $request->validate([
            'name' => ['required', 'max:255'],
            'definition' => 'max:10000',
            'fk_parent_concept_id' => ['uuid', Rule::in(Dictionary::find($dictionaryId)->concepts()->pluck('id'))],
        ]);

        $concept = new Concept([
            'name' => $validated['name'],
            'definition' => $request['definition'],
            'fk_dictionary_id' => $dictionaryId,
            'fk_parent_concept_id' =>  $request['fk_parent_concept_id'],
        ]);

        $concept->saveOrFail();

        return redirect()->route('dictionary.show', $dictionaryId);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $dictionary, string $concept, int $page = 0)
    {
        $concept = Concept::findOrFail($concept);
        $dictionary = Dictionary::findOrFail($dictionary);
        $concepts = $dictionary->rootConcepts();

        $query = ConceptRelation::where('fk_concept_1_id', $concept->id)->orWhere('fk_concept_2_id', $concept->id);
        $conceptRelationTypes = $query->distinct('fk_relation_type_id')->get('fk_relation_type_id')->pluck('fk_relation_type_id')->reverse();

        $conceptRelations = [];

        foreach ($conceptRelationTypes as $conceptRelationType) {

            $relatedConcepts1 = DB::table('concept_relations')
                ->join('concepts as concept_1', 'concept_relations.fk_concept_1_id', '=', 'concept_1.id')
                ->join('concepts as concept_2', 'concept_relations.fk_concept_2_id', '=', 'concept_2.id')
                ->join('relation_types', 'concept_relations.fk_relation_type_id', '=', 'relation_types.id')
                ->select(
                    'concept_relations.id as relation_id',
                    'concept_2.id AS concept_id',
                    'concept_2.name AS concept_name'
                )
                ->where('concept_1.id', '=', $concept->id)
                ->where('concept_relations.fk_relation_type_id', '=', $conceptRelationType)
                ->get();

            $relatedConcepts2 = DB::table('concept_relations')
                ->join('concepts as concept_1', 'concept_relations.fk_concept_1_id', '=', 'concept_1.id')
                ->join('concepts as concept_2', 'concept_relations.fk_concept_2_id', '=', 'concept_2.id')
                ->join('relation_types', 'concept_relations.fk_relation_type_id', '=', 'relation_types.id')
                ->select(
                    'concept_relations.id as relation_id',
                    'concept_1.id AS concept_id',
                    'concept_1.name AS concept_name'
                )
                ->where('concept_2.id', '=', $concept->id)
                ->where('concept_relations.fk_relation_type_id', '=', $conceptRelationType)
                ->get();


            $merged = array_merge($relatedConcepts1->toArray(), $relatedConcepts2->toArray());
            array_push($conceptRelations, [
                RelationType::find($conceptRelationType),
                $merged
            ]);
        }

        return view('concept.show', compact('concept', 'dictionary', 'concepts', 'conceptRelations', 'page'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dictionary $dictionary, Concept $concept)
    {
        Gate::authorize('must-be-owner', $concept->dictionary);
        return view('concept.edit', compact('dictionary', 'concept'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dictionary $dictionary, Concept $concept)
    {
        Gate::authorize('must-be-owner', $concept->dictionary);
        $validated = $request->validate([
            'name' => ['required', 'max:255'],
            'definition' => 'max:10000',
            'parent' => [Rule::excludeIf(empty($request->input('parent'))), 'uuid', Rule::in($dictionary->concepts->pluck('id'))],
        ]);

        if (in_array('parent', $validated)) {
            $children = $concept->allChildren();
            $searchId = $validated['parent'];
            $filtered = array_filter($children, function ($child) use ($searchId) {
                return $child->id === $searchId;
            });

            $foundChild = current($filtered);

            if ($foundChild) {
                foreach ($concept->children()->get() as $child) {
                    $child->updateOrFail([
                        'fk_parent_concept_id' => $concept->fk_parent_concept_id
                    ]);
                }
            }
        }


        $concept->updateOrFail([
            'name' => $validated['name'],
            'definition' => $validated['definition'],
            'fk_parent_concept_id' => $validated['parent'] ?? null,
        ]);


        return redirect(route('concept.show', compact('dictionary', 'concept')))->with('success', "Понятие успешно изменено!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $dictionaryId, string $conceptId)
    {
        $concept = Concept::findOrFail($conceptId);
        Gate::authorize('must-be-owner', $concept->dictionary);

        $concept->deleteOrFail();

        return redirect()->back()->with('success', 'Concept deleted.');
    }

    public function examples(string $dictionary, string $concept)
    {
        $concepts = Dictionary::findOrFail($dictionary)->rootConcepts();
        $concept = Concept::findOrFail($concept);
        $dictionary = Dictionary::findOrFail($dictionary);
        return view('concept.examples', compact('dictionary', 'concept', 'concepts'));
    }

    public function attachments(string $dictionary, string $concept)
    {
        $concepts = Dictionary::findOrFail($dictionary)->rootConcepts();
        $concept = Concept::findOrFail($concept);
        $dictionary = Dictionary::findOrFail($dictionary);
        $attachments = $concept->attachements()->get();
        return view('components.dashboard.tabs.attachments', compact('dictionary', 'concept', 'concepts', 'attachments'));
    }
}
