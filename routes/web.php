<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\ConceptAttributeController;
use App\Http\Controllers\ConceptAttributeValueController;
use App\Http\Controllers\ConceptController;
use App\Http\Controllers\ConceptRelationController;
use App\Http\Controllers\DictionaryController;
use App\Http\Controllers\ImportExamplesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RelationTypeController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::view('contact', 'components.pages.contact')->name('contact');
Route::view('about', 'components.pages.about')->name('about');

Route::redirect('/home', '/');

Route::get('/', function (Request $request) {
    if (request('search')) {
        $dictionaries = \App\Models\Dictionary::where('visibility', '=', 'public')->where('name', 'ilike', '%' . request('search') . '%')->paginate(15);
    } else {
        $dictionaries = \App\Models\Dictionary::allAvailable()->paginate(15);
    }

    return view('components.pages.home', compact('dictionaries'));
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['verified'])->group(function () {
        Route::resource('my', DictionaryController::class)->names([
            'index' => 'my',
            'create' => 'dictionary.create',
            'store' => 'dictionary.store',
            'edit' => 'dictionary.edit',
            'destroy' => 'dictionary.destroy',
            'update' => 'dictionary.update',
            'show' => 'dictionary.show',
        ]);

        Route::get('my/{dictionary}/dashboard', [DictionaryController::class, 'show'])->name('dictionary.show');

        Route::prefix('my/{dictionary}')->group(function () {
            Route::resource('concept', ConceptController::class)->only(['create', 'store', 'destroy'])->names([
                'create' => 'concept.create',
                'store' => 'concept.store',
                'destroy' => 'concept.destroy',
            ]);

            // import
            Route::get('concept/{concept}/import', [ImportExamplesController::class, 'create'])->name('import.create');
            Route::post('concept/{concept}/import', [ImportExamplesController::class, 'store'])->name('import.store');

            Route::put('concept/{concept}', [ConceptController::class, 'update'])->name('concept.update');
            Route::get('concept/{concept}', [ConceptController::class, 'edit'])->name('concept.edit');
            Route::get('dashboard/{concept}', [ConceptController::class, 'show'])->name('concept.show');
            Route::delete('concept/{concept}', [ConceptController::class, 'destroy'])->name('concept.destroy');
            Route::get('examples/{concept}', [ConceptController::class, 'examples'])->name('concept.examples');
            Route::get('attachments/{concept}', [ConceptController::class, 'attachments'])->name('concept.attachments');

            // Attachments for concept
            Route::post('attachments/{concept}', [AttachmentController::class, 'store'])->name('attachment.store');
            Route::get('attachments/{concept}/create', [AttachmentController::class, 'create'])->name('attachment.create');
            Route::delete('attachments/{concept}/{attachment}', [AttachmentController::class, 'destroy'])->name('attachment.destroy');

            Route::get('export', [DictionaryController::class, 'export'])->name('dictionary.export');

            Route::resource('concept/{concept}/attributes', ConceptAttributeController::class)->only(['create', 'store', 'destroy'])->names([
                'create' => 'concept.attribute.create',
                'store' => 'concept.attribute.store',
                'destroy' => 'concept.attribute.destroy',
            ]);
            Route::get('concept/{concept}/relation/create', [ConceptRelationController::class, 'create'])->name('concept.relation.create');
            Route::get('concept/{concept}/relation/{relation}', [ConceptRelationController::class, 'edit'])->name('concept.relation.edit');
            Route::post('concept/{concept}/relation', [ConceptRelationController::class, 'store'])->name('concept.relation.store');
            Route::delete('concept/{concept}/relation/{relation}', [ConceptRelationController::class, 'destroy'])->name('concept.relation.destroy');
            Route::put('concept/{concept}/relation/{relation}', [ConceptRelationController::class, 'update'])->name('concept.relation.update');
        });
    });

    Route::resource('attributes', AttributeController::class)->names([
        'create' => 'attribute.create',
        'store' => 'attribute.store',
        'destroy' => 'attribute.destroy',
        'update' => 'attribute.update',
        'edit' => 'attribute.edit',
        'show' => 'attribute.show',
        'index' => 'attribute.index',
    ]);

    Route::delete('concept/{concept}/examples/{exampleNumber}', [ConceptAttributeValueController::class, 'destroy'])->name('concept.example.destroy');
    Route::get('concept/{concept}/examples/{exampleNumber}', [ConceptAttributeValueController::class, 'edit'])->name('concept.example.edit');
    Route::put('concept/{concept}/examples/{exampleNumber}', [ConceptAttributeValueController::class, 'edit'])->name('concept.example.update');

    Route::resource('concept/{concept}/example', ConceptAttributeValueController::class)->only(['store', 'update', 'create'])->names([
        'create' => 'concept.example.create',
        'store' => 'concept.example.store',
        'update' => 'concept.example.update',
        'edit' => 'concept.example.edit',
    ]);

    Route::resource('tags', TagController::class)->names([
        'create' => 'tag.create',
        'store' => 'tag.store',
        'destroy' => 'tag.destroy',
        'update' => 'tag.update',
        'edit' => 'tag.edit',
        'index' => 'tag.index',
    ]);

    Route::resource('relations', RelationTypeController::class)->names([
        'create' => 'relation-type.create',
        'store' => 'relation-type.store',
        'destroy' => 'relation-type.destroy',
        'update' => 'relation-type.update',
        'edit' => 'relation-type.edit',
        'index' => 'relation-type.index',
    ]);
});

Route::fallback(function () {
    return view('errors.404');
});

require __DIR__ . '/auth.php';
