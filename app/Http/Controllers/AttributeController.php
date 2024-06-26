<?php

namespace App\Http\Controllers;

use App\Enums\DataType;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Attribute::query();
        if (request('search')) {
            $query->where('name', 'ilike', '%' . request('search') . '%');
        }

        $attributes = $query->paginate(15);

        return view('attribute.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('attribute.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:attributes,name',
            'type' => [new Enum(DataType::class)],
        ]);

        $attribute = Attribute::create([
            'name' => $validated['name'],
            'type' => $validated['type'],
        ]);

        $attribute->save();

        return redirect('/attributes')->with('success', __('attribute-page.messages.created', ['name' => $attribute->name]));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attribute $attribute)
    {
        Gate::authorize('redactor');
        return view('attribute.edit', compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attribute $attribute)
    {
        Gate::authorize('redactor');

        $validated = $request->validate([
            'name' => ['required', 'max:255', Rule::unique('attributes')->ignore($attribute->id)],
            'type' => [new Enum(DataType::class)],
        ]);

        $attribute->updateOrFail($validated);
        return redirect('/attributes')->with('success', __('attribute-page.messages.updated', ['name' => $attribute->name]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attribute $attribute)
    {
        Gate::authorize('admin');

        if ($attribute->concepts()->count() > 0) {
            return redirect()->back()->with('error', __('attribute-page.messages.delete-error', ['name' => $attribute->name]));
        }
        // Нужно проверить когда добавлю функционал добавления атрибутов.
        $attribute->delete();
        return redirect('/attributes')->with('success', __('attribute-page.messages.deleted', ['name' => $attribute->name]));
    }
}
