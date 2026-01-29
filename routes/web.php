<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\FavoriteController;

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

Route::get('/', [AnimeController::class, 'index'])->name('home');

Auth::routes();

// Protected routes for authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [AnimeController::class, 'index'])->name('dashboard');
    Route::resource('favorites', FavoriteController::class);
});

// Public routes for anime
Route::get('/anime', [AnimeController::class, 'index'])->name('anime.index');
Route::get('/anime/genre', [AnimeController::class, 'genreList'])->name('anime.genre.list');
Route::get('/anime/genre/{id}', [AnimeController::class, 'byGenre'])->name('anime.by.genre');
Route::get('/anime/all', [AnimeController::class, 'all'])->name('anime.all');
Route::get('/anime/search', [AnimeController::class, 'search'])->name('anime.search');
Route::get('/anime/{id}', [AnimeController::class, 'show'])->name('anime.show');
