<?php

namespace App\Http\Controllers;

use App\Enums\Visibility;
use App\Models\Concept;
use App\Models\Dictionary;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
        $dictionary = Dictionary::where('fk_user_id', '=', auth()->user()->id)->findOrFail($id);

        return view('dictionary.show',
            ['dictionary' => $dictionary,
        'concepts' => $dictionary->rootConcepts()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) : View
    {
        return view('dictionary.edit',
            ['dictionary' => Dictionary::where('fk_user_id', '=', auth()->user()->id)->findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $dictionaryId) : RedirectResponse
    {
        $dictionary = Dictionary::where('fk_user_id', '=', auth()->user()->id)->findOrFail($dictionaryId);

        $validated = $request->validate([
            'name' => ['required', 'max:50'],
            'description' => 'max:500',
            'visibility' => [new Enum(Visibility::class)],
        ]);

        $dictionary->name = $validated['name'];
        $dictionary->description = $validated['description'];
        $dictionary->visibility = $validated['visibility'];
        $dictionary->updateOrFail($validated);

        return redirect(route('my'));
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

    public function export(string $id)
    {
        $dictionary = Dictionary::where('fk_user_id', '=', auth()->user()->id)->findOrFail($id);
        $concepts = $dictionary->concepts()->pluck('name');
        $conceptsString = '';
        foreach ($concepts as $concept) {
            $conceptsString .= $concept . "\n";
        }
        $fileContent = $conceptsString;
        $fileName = Str::random(5);
        Storage::disk('local')->put($fileName.'.txt', $fileContent);
        /// файл сохраняется на диске, как то подумать надо его удалением
        // потому что он может делаться часто и захламлять диск
        // либо же перезаписывать и гдето хранить информацию поменялся ли список концептов
        return Storage::download($fileName.'.txt');
    }
}
