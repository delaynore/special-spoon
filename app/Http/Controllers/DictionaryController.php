<?php

namespace App\Http\Controllers;

use App\Enums\Visibility;
use App\Models\Dictionary;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Illuminate\View\View;

class DictionaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : \Illuminate\Contracts\View\View
    {
        $dictionaries = Dictionary::where('fk_user_id', '=', auth()->user()->id)->orderBy('updated_at', 'desc')->get();
        return view('dictionary.index', ['dictionaries' => $dictionaries]);
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50',
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('dictionary.edit',
            ['dict' => Dictionary::where('fk_user_id', '=', auth()->user()->id)->findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:50',
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
    public function destroy(string $id)
    {
        return redirect('/my');
    }
}
