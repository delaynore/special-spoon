<?php

namespace App\Http\Controllers;

use App\Enums\Visibility;
use App\Models\Dictionary;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
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
        Gate::authorize('index-dictionary');

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
        Gate::authorize('create-dictionary');

        return view('dictionary.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('store-dictionary');

        $validated = $request->validate([
            'name' => ['required', 'max:50', Rule::unique('dictionaries', 'name')->where(function ($query) {
                return $query->where('fk_user_id', auth()->user()->id);
            })],
            'description' => 'max:500',
            'visibility' => [new Enum(Visibility::class)],
            'tags' => 'array',
            'tags.*' => 'uuid|exists:tags,id',
        ]);

        $dictionary = Dictionary::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'visibility' => $validated['visibility'],
            'fk_user_id' => $request->user()->id,
        ]);
        $dictionary->save();
        if (!empty($validated['tags'])) {
            foreach ($validated['tags'] as $tag) {
                $tagModel = Tag::find($tag);
                $dictionary->tags()->attach($tagModel->id, ['id' => Str::uuid()]);
            }
        }


        return redirect(route('my'))
            ->with(
                'success',
                __('shared.entity.created', ['entity' => __('entities.dictionary.singular')])
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(Dictionary $dictionary): View
    {
        Gate::authorize('show-dictionary', $dictionary);

        if ($dictionary->visibility == Visibility::PRIVATE && $dictionary->fk_user_id !== auth()->user()->id) {
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
    public function edit(string $dictionaryId): View
    {
        $dictionary = Dictionary::find($dictionaryId);
        Gate::authorize('edit-dictionary', $dictionary);

        return view(
            'dictionary.edit',
            compact('dictionary')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $dictionaryId): RedirectResponse
    {
        $dictionary = Dictionary::find($dictionaryId);
        Gate::authorize('update-dictionary', $dictionary);

        $validated = $request->validate([
            'name' => ['required', 'max:50', Rule::unique('dictionaries', 'name')->where(function ($query) {
                return $query->where('fk_user_id', auth()->user()->id);
            })->ignore($dictionary->id)],
            'description' => 'max:500',
            'visibility' => [new Enum(Visibility::class)],
            'tags' => 'array',
            'tags.*' => 'uuid|exists:tags,id',
        ]);
        $dictionary->name = $validated['name'];
        $dictionary->description = $validated['description'];
        $dictionary->visibility = $validated['visibility'];

        if (!empty($validated['tags'])) {
            $dictionaryTags = $dictionary->tags()->pluck('tags.id')->toArray();
            foreach ($dictionaryTags as $id) {
                if (!in_array($id, $validated['tags'])) {
                    $dictionary->tags()->detach($id);
                }
            }
            foreach ($validated['tags'] as $tagId) {
                if (!in_array($tagId, $dictionaryTags)) {
                    $dictionary->tags()->attach($tagId, ['id' => Str::uuid()]);
                }
            }
        }

        $dictionary->updateOrFail($validated);

        return redirect(route('my'))->with('success', 'Словарь обновлен');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $dictionaryId): RedirectResponse
    {
        $dictionary = Dictionary::find($dictionaryId);
        Gate::authorize('destroy-dictionary', $dictionary);

        $dictionary->delete();

        return redirect('/my');
    }

    public function export(string $id)
    {
        $dictionary = Dictionary::find($id);
        Gate::authorize('export-dictionary', $dictionary);

        $concepts = $dictionary->concepts()->pluck('name');
        if (count($concepts) == 0) {
            return redirect()->back()->with('error', 'В словаре нет понятий');
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
