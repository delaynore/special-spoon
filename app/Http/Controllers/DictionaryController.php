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
    public function index(): View
    {
        $dictionaries = Dictionary::where('fk_user_id', auth()->user()->id);
        if (request('search')) {
            $dictionaries = $dictionaries->where('name', 'ilike', '%' . request('search') . '%');
        }
        $visibility = request()->input('visibility', []);
        if (count($visibility) != 2 && count($visibility) != 0) {
            $dictionaries = $dictionaries->where('visibility', request('visibility')[0]);
        }
        return view('dictionary.index', ['dictionaries' => $dictionaries->orderBy('updated_at', 'desc')->paginate(15)]);
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
    public function store(Request $request): RedirectResponse
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
    public function show(string $id): View
    {

        $dictionary = Dictionary::findOrFail($id);

        if($dictionary->visibility == Visibility::PRIVATE && $dictionary->fk_user_id !== auth()->user()->id) {
            return abort(404);
        }

        return view(
            'dictionary.show',
            [
                'dictionary' => $dictionary,
                'concepts' => $dictionary->rootConcepts()
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        return view(
            'dictionary.edit',
            ['dictionary' => Dictionary::where('fk_user_id', '=', auth()->user()->id)->findOrFail($id)]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $dictionaryId): RedirectResponse
    {
        $dictionary = Dictionary::where('fk_user_id', '=', auth()->user()->id)->findOrFail($dictionaryId);

        $validated = $request->validate([
            'name' => ['required', 'max:50', Rule::notIn(Dictionary::where('fk_user_id', '=', auth()->user()->id)->pluck('name'))],
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
    public function destroy(string $id): RedirectResponse
    {
        $dictionary = Dictionary::where('fk_user_id', '=', auth()->user()->id)->findOrFail($id);

        $dictionary->delete();

        return redirect('/my');
    }

    public function export(string $id)
    {
        $dictionary = Dictionary::where('fk_user_id', '=', auth()->user()->id)->findOrFail($id);
        $concepts = $dictionary->concepts()->pluck('name');
        if (count($concepts) == 0) {
            return redirect()->back()->with('export.error', 'В словаре нет понятий');
        }
        $conceptsString = '';
        foreach ($concepts as $concept) {
            $conceptsString .= $concept . "\n";
        }
        $fileContent = $conceptsString;
        $fileName = $dictionary->name . '-concepts.txt';
        Storage::disk('local')->put($fileName, $fileContent);

        return response()
            ->download(Storage::disk('local')->path($fileName), $fileName, ['Content-Type' => 'text/plain'])
            ->deleteFileAfterSend(true);
    }
}
