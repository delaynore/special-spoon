<?php

namespace App\Http\Controllers;

use App\Enums\Visibility;
use App\Models\Concept;
use App\Models\Dictionary;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\View\View;

class DictionaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {

        $dictionaries = Dictionary::where('fk_user_id', '=', auth()->user()->id);
        if (isset($_REQUEST['search'])) {
            $dictionaries = $dictionaries->where('name', 'like', '%' . $_REQUEST['search'] . '%');
        }
        return view('dictionary.index', ['dictionaries' => $dictionaries->orderBy('updated_at', 'desc')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('dictionary.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'max:50', Rule::notIn(Dictionary::where('fk_user_id', '=', auth()->user()->id)->pluck('name'))],
            'description' => 'max:500',
            'visibility' => [new Enum(Visibility::class)],
        ]);

        $dictionary = Dictionary::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'visibility' => $validated['visibility'],
            'fk_user_id' => $request->user()->id,
        ]);

        $dictionary->save();

        return redirect('/my');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) : View
    {
        $dict = Dictionary::where('fk_user_id', '=', auth()->user()->id)->findOrFail($id);
        return view('dictionary.show',
            ['dict' => $dict,
        'concept' => $dict->rootConcept()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) : View
    {
        return view('dictionary.edit',
            ['dict' => Dictionary::where('fk_user_id', '=', auth()->user()->id)->findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) : RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'max:50', Rule::notIn(Dictionary::where('fk_user_id', '=', auth()->user()->id)->pluck('name'))],
            'description' => 'max:500',
            'visibility' => [new Enum(Visibility::class)],
        ]);

        $dictionary = Dictionary::where('fk_user_id', '=', auth()->user()->id)->findOrFail($id);

        $dictionary->name = $validated['name'];
        $dictionary->description = $validated['description'];
        $dictionary->visibility = $validated['visibility'];

        $dictionary->save();

        return redirect('/my');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) : RedirectResponse
    {
        $dictionary = Dictionary::findOrFail($id);

        $dictionary->delete();

        return redirect('/my');
    }
}
