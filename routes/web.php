<?php

use App\Http\Controllers\AttributeController;
use App\Http\Controllers\ConceptAttributeController;
use App\Http\Controllers\ConceptAttributeValueController;
use App\Http\Controllers\ConceptController;
use App\Http\Controllers\DictionaryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use App\Models\Concept;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("contact", function () {
    return view("components.pages.contact");
})->name('contact');

Route::get("/about", function () {
    return view("components.pages.about");
})->name('about');

Route::redirect("/home", "/");

Route::get('/', function (Request $request) {
    if (request('search')) {
        $dictionaries = \App\Models\Dictionary::where('visibility', '=', 'public')->where('name', 'ilike', '%' . request('search') . '%')->paginate(15);
    } else {
        $dictionaries = \App\Models\Dictionary::allAvailable()->paginate(15);
    }

    return view('components.pages.home', compact('dictionaries'));
})->name('home');


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('/my', DictionaryController::class)
    ->middleware(['auth', 'verified'])
    ->names([
        'index' => 'my',
        'create' => 'dictionary.create',
        'store' => 'dictionary.store',
        'edit' => 'dictionary.edit',
        'destroy' => 'dictionary.destroy',
        'update' => 'dictionary.update',
        'show' => 'dictionary.show',
    ]);

Route::get('/my/{dictionary}/dashboard', [DictionaryController::class, 'show'])
    ->name('dictionary.show')
    ->middleware(['auth', 'verified']);

Route::resource('/my/{dictionary}/concept/', ConceptController::class)
    ->middleware(['auth', 'verified'])
    ->names([
        'create' => 'concept.create',
        'destroy' => 'concept.destroy',
        'store' => 'concept.store',
    ]);
Route::put('/my/{dictionary}/concept/{concept}', [ConceptController::class, 'update'])
    ->name('concept.update')
    ->middleware(['auth', 'verified']);
Route::get('/my/{dictionary}/concept/{concept}', [ConceptController::class, 'edit'])
    ->name('concept.edit')
    ->middleware(['auth', 'verified']);

Route::get('/my/{dictionary}/dashboard/{concept}/', [ConceptController::class, 'show'])
    ->name('concept.show')
    ->middleware(['auth', 'verified']);

Route::delete('/my/{dictionary}/concept/{concept}', [ConceptController::class, 'destroy'])
    ->middleware(['auth', 'verified']);

Route::get('/my/{dictionary}/examples/{concept}', [ConceptController::class, 'examples'])->name('concept.examples')
    ->middleware(['auth', 'verified']);

Route::get('/tags', [TagController::class, 'index']);


Route::prefix('my/{dictionary}')->group(function () {
    Route::get('/export', [DictionaryController::class, 'export'])->name('dictionary.export');

    Route::resource('concept/{concept}/attributes', ConceptAttributeController::class)->only(['create', 'store', 'destroy'])
        ->names([
            'create' => 'concept.attribute.create',
            'store' => 'concept.attribute.store',
            'destroy' => 'concept.attribute.destroy',
        ]);
});

Route::resource('attributes', AttributeController::class)
    ->names([
        'create' => 'attribute.create',
        'store' => 'attribute.store',
        'destroy' => 'attribute.destroy',
        'update' => 'attribute.update',
        'edit' => 'attribute.edit',
        'show' => 'attribute.show',
        'index' => 'attribute.index',
    ])
    ->middleware(['auth', 'verified']);

Route::delete('concept/{concept}/examples/{exampleNumber}', [ConceptAttributeValueController::class, 'destroy'])
    ->name('concept.example.destroy')->middleware(['auth', 'verified']);
Route::get('concept/{concept}/examples/{exampleNumber}', [ConceptAttributeValueController::class, 'edit'])
    ->name('concept.example.edit')->middleware(['auth', 'verified']);
Route::put('concept/{concept}/examples/{exampleNumber}', [ConceptAttributeValueController::class, 'edit'])
    ->name('concept.example.update')->middleware(['auth', 'verified']);

Route::resource('concept/{concept}/example', ConceptAttributeValueController::class)->only(['store', 'update', 'create'])->middleware(['auth', 'verified'])
    ->names([
        'create' => 'concept.example.create',
        'store' => 'concept.example.store',
        'update' => 'concept.example.update',
        'edit' => 'concept.example.edit',
    ]);

Route::resource('tags', TagController::class)
    ->names([
        'create' => 'tag.create',
        'store' => 'tag.store',
        'destroy' => 'tag.destroy',
        'update' => 'tag.update',
        'edit' => 'tag.edit',
        'index' => 'tag.index',
    ])
    ->middleware(['auth', 'verified']);


Route::fallback(function () {
    return view('errors.404');
});

require __DIR__ . '/auth.php';
