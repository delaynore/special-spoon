<?php

namespace App\Http\Controllers;

use App\Models\RelationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RelationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = RelationType::query();
        if (request('search')) {
            $query->where('name', 'ilike', '%' . request('search') . '%');
        }

        $relationTypes = $query->paginate(15);

        return view("relation-type.index", compact('relationTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('redactor');

        return view('relation-type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('redactor');

        $validated = $this->validate($request, [
            'name' => 'required|string|unique:relation_types,name|unique:relation_types,name_plural',
            'description' => 'nullable|string',
            'name_plural' => 'nullable|string|unique:relation_types,name|unique:relation_types,name_plural'
        ]);

        if($validated['name_plural'] == null) {
            $validated['name_plural'] = $validated['name'];
        }

        RelationType::create($validated);

        return redirect()->route('relation-type.index')
            ->with(
                'success',
                __('relation-type-page.messages.created')
            );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $relationType)
    {
        Gate::authorize('redactor');
        $relationType = RelationType::findOrFail($relationType);

        return view('relation-type.edit', compact('relationType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $relationType)
    {
        Gate::authorize('redactor');
        $validated = $this->validate($request, [
            'name' => 'required|string|unique:relation_types,name,' . $relationType.'|unique:relation_types,name_plural,'. $relationType,
            'description' => 'nullable|string',
            'name_plural' => 'nullable|string|unique:relation_types,name_plural,'. $relationType.'|unique:relation_types,name,' . $relationType
        ]);

        RelationType::findOrFail($relationType)->update($validated);

        return redirect()->route('relation-type.index')
            ->with(
                'success',
                __('relation-type-page.messages.updated')
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $relationType)
    {
        Gate::authorize('admin');
        RelationType::findOrFail($relationType)->delete();
        return redirect()->route('relation-type.index')
            ->with(
                'success',
                __('relation-type-page.messages.deleted')
            );
    }
}
