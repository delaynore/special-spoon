<?php

namespace App\Http\Controllers;

use App\Models\Concept;
use App\Models\Dictionary;
use Illuminate\Http\Request;
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

        if($dictionary->fk_user_id != auth()->user()->id) {
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
        $request->validate([
            'name' => ['required', 'max:50', Rule::notIn(Dictionary::find($dictionaryId)->concepts()->pluck('name'))],
            'description' => 'max:500',
            'fk_parent_concept_id' => ['uuid',Rule::in(Dictionary::find($dictionaryId)->concepts()->pluck('id'))],
        ]);

        $concept = new Concept([
            'name' => $request->name,
            'definition' => $request->definition,
            'fk_dictionary_id' => $dictionaryId,
            'fk_parent_concept_id' =>  $request->fk_parent_concept_id,
        ]);

        $concept->saveOrFail();

        return redirect()->route('dictionary.show', $dictionaryId);
    }

    /**
     * Display the specified resource.
     */
    public function show(Concept $concept)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Concept $concept)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Concept $concept)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,string $id)
    {
        dd($request);
        $concept = Concept::findOrFail($id);
        $dict = $concept->fk_dictionary_id;

        $concept->delete();
        $concept->saveOrFail();

        return redirect(route('dictionary.show'), $dict);
    }
}
