<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Tag::query();

        if (request('search')) {
            $query->where('name', 'ilike', '%' . request('search') . '%');
        }

        $tags = $query->paginate(15);

        return view('tag.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tag.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:tags|max:50',
        ]);

        Tag::create($validated);

        return redirect(route('tag.index'))
            ->with(
                'success',
                __('shared.entity.created', ['entity' => __('entities.tag.singular')])
            );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        Gate::authorize('redactor');
        return view('tag.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        Gate::authorize('redactor');

        $validated = $request->validate([
            'name' => 'required|unique:tags,name,' . $tag->id . '|max:50',
        ]);

        $tag->updateOrFail($validated);

        return redirect(route('tag.index'))
            ->with(
                'success',
                __('shared.entity.updated', ['entity' => __('entities.tag.singular')])
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        Gate::authorize('admin');

        $tag->deleteOrFail();

        return redirect()->back()
            ->with(
                'success',
                __(
                    'shared.entity.deleted',
                    ['entity' => __('entities.tag.singular')]
                )
            );
    }
}
