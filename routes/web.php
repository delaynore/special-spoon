<?php

use App\Http\Controllers\DictionaryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
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
    ->name('update', 'dictionary.update');

//Route::name("dictionary")->get('/dictionary', [DictionaryController::class, 'index']);

Route::get('/tags', [TagController::class,'index']);

require __DIR__.'/auth.php';
