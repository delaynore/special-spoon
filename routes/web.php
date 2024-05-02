<?php

use App\Http\Controllers\AttributeController;
use App\Http\Controllers\ConceptAttributeController;
use App\Http\Controllers\ConceptController;
use App\Http\Controllers\DictionaryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use App\Models\Concept;
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

Route::get("/home", function () {
    return view("components.pages.home");
})->name('home');
Route::get('/', function () {
    return view('components.pages.home');
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
    ->name('index', 'my')
    ->name('store', 'dictionary.store')
    ->name('edit', 'dictionary.edit')
    ->name('destroy', 'dictionary.destroy')
    ->name('update', 'dictionary.update')
    ->name('show', 'dictionary.show');

Route::get('/my/{dictionary}/dashboard', [DictionaryController::class, 'show'])
    ->name('dictionary.show')
    ->middleware(['auth', 'verified']);

Route::resource('/my/{dictionary}/concept/', ConceptController::class)
    ->middleware(['auth', 'verified'])
    ->name('create', 'concept.create')
    ->name('store', 'concept.store')
    ->name('destroy', 'concept.destroy')
    ->middleware(['auth', 'verified']);

Route::get('/my/{dictionary}/dashboard/{concept}/', [ConceptController::class, 'show'])
    ->name('concept.show')
    ->middleware(['auth', 'verified']);
Route::delete('/my/{dictionary}/concept/{concept}', [ConceptController::class, 'destroy'])
    ->middleware(['auth', 'verified']);
Route::get('/my/{dictionary}/examples/{concept}', [ConceptController::class, 'examples'])->name('concept.examples')
    ->middleware(['auth', 'verified']);

//Route::name("dictionary")->get('/dictionary', [DictionaryController::class, 'index']);

Route::get('/tags', [TagController::class, 'index']);


Route::prefix('my/{dictionary}')->group(function () {
    Route::get('/export', [DictionaryController::class, 'export'])->name('dictionary.export');

    Route::resource('concept/{concept}/attributes', ConceptAttributeController::class)->only(['create', 'store'])
        ->names([
            'create' => 'concept.attribute.create',
            'store' => 'concept.attribute.store',
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
]);

require __DIR__ . '/auth.php';
