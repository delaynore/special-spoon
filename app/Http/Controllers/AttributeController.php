<?php

namespace App\Http\Controllers;

use App\Enums\DataType;
use App\Models\Attribute;
use App\Http\Requests\StoreAttributeRequest;
use App\Http\Requests\UpdateAttributeRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request('search')) {
            $attributes = Attribute::where('name', 'ilike', '%' . request('search') . '%')->get();
        } else {
            $attributes = Attribute::all();
        }

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

        return redirect('/attributes')->with('attribute.create.success', "{$attribute->name} создан.");
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attribute $attribute)
    {
        return view('attribute.edit', compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attribute $attribute)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:255', Rule::unique('attributes')->ignore($attribute->id)],
            'type' => [new Enum(DataType::class)],
        ]);

        $attribute->updateOrFail($validated);
        return redirect('/attributes')->with('attribute.update.success', "Атрибут - '{$attribute->name}' обновлен.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attribute $attribute)
    {
        if ($attribute->concepts()->count() > 0) {
            return redirect()->back()->with('attribute.delete.error', 'Атрибут не может быть удален, так как он используется в словарях. Удалите его из словарей');
        }
        // Нужно проверить когда добавлю функционал добавления атрибутов.
        $attribute->delete();
        return redirect('/attributes')->with('attribute.delete.success', "{$attribute->name} удален.");
    }
}
