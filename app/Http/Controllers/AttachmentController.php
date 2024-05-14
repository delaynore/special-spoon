<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Enums\AttachmentType;
use App\Http\Requests\StoreAttachmentRequest;
use App\Http\Requests\UpdateAttachmentRequest;
use App\Models\Concept;
use App\Models\Dictionary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AttachmentController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Dictionary $dictionary, Concept $concept)
    {
        return view('attachment.create', compact('dictionary', 'concept'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Dictionary $dictionary, Concept $concept)
    {
        Gate::authorize('must-be-owner', $dictionary);

        $validated = $request->validate([
            'name' => 'sometimes|required|alpha_num|max:255',
            'file' => 'required|mimes:png,jpg,jpeg,mp3,mp4|max:10240',
        ]);

        $file = $request->file('file');

        $extension = $file->extension();
        $fileName = ($validated['name'] ?? $file->getClientOriginalName()) . '.' . $extension;

        $path = public_path('storage/attachments/' . $concept->id);
        $publicPath = 'attachments/' . $concept->id;
        $file->move($path, $fileName);
        if ($extension == 'mp3') {
            $type = AttachmentType::AUDIO;
        } else if ($extension == 'mp4') {
            $type = AttachmentType::VIDEO;
        } else {
            $type = AttachmentType::IMAGE;
        }

        Storage::setVisibility($path, 'public');

        $attachment = Attachment::create([
            'name' => $validated['name'] ?? $file->getClientOriginalName(),
            'path' => $publicPath . '/' . $fileName,
            'type' => $type,
            'fk_user_id' => $request->user()->id,
            'fk_concept_id' => $concept->id,
        ]);

        $attachment->saveOrFail();

        return redirect()->back()
            ->with(
                'success',
                __('shared.entity.created', ['entity' => Str::lower(__('entities.attachment.singular'))])
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(Attachment $attachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attachment $attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttachmentRequest $request, Attachment $attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dictionary $dictionary, Concept $concept, Attachment $attachment)
    {
        Gate::authorize('must-be-owner', $attachment->concept->dictionary);

        $attachment->deleteOrFail();

        return redirect()->back()
            ->with(
                'success',
                __('shared.entity.deleted', ['entity' => Str::lower(__('entities.attachment.singular'))])
            );
    }
}
