<?php

namespace App\Http\Controllers;

use App\Models\Concept;
use App\Models\Dictionary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ConceptController extends Controller
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
    public function create(Dictionary $dictionary)
    {

        if ($dictionary->fk_user_id != auth()->user()->id) {
            return abort(404);
        }
        if (request()->get('parentId') == null) {
            return view('concept.create', compact('dictionary'));
        }

        $parent = Concept::findOrFail(request()->get('parentId'));
        return view('concept.create', compact('dictionary', 'parent'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $dictionaryId)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:50', Rule::notIn(Dictionary::find($dictionaryId)->concepts()->pluck('name'))],
            'definition' => 'max:1000',
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
    public function show(string $dictionary, string $concept)
    {
        $concept = Concept::findOrFail($concept);
        $dictionary = Dictionary::findOrFail($dictionary);
        $concepts = $dictionary->rootConcepts();
        return view('concept.show', compact('concept', 'dictionary', 'concepts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dictionary $dictionary, Concept $concept)
    {
        return view('concept.edit', compact('dictionary', 'concept'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dictionary $dictionary, Concept $concept)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:50', Rule::notIn($dictionary->concepts->where('id', '!=', $concept->id)->pluck('name'))],
            'definition' => 'max:1000',
            'parent' => [Rule::excludeIf(empty($request->input('parent'))), 'uuid', Rule::in($dictionary->concepts->pluck('id'))],
        ]);

        if ($validated['parent']) {
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
        //Gate::authorize('delete', [Auth::user(), $concept]);

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
}
