<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\FavoriteController;

/*
|--------------------------------------------------------------------------
| Rute Web
|--------------------------------------------------------------------------
|
| Di sinilah Anda dapat mendaftarkan rute web untuk aplikasi Anda. Rute-rute
| ini dimuat oleh RouteServiceProvider dan semua rute akan ditetapkan ke grup
| middleware "web". Buat sesuatu yang hebat!
|
*/

Route::get('/', [AnimeController::class, 'index'])->name('home');

Auth::routes();

// Rute yang dilindungi untuk pengguna yang sudah login
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [AnimeController::class, 'index'])->name('dashboard');
    Route::resource('favorites', FavoriteController::class);
});

// Rute publik untuk anime
Route::get('/anime', [AnimeController::class, 'index'])->name('anime.index');
Route::get('/anime/genre', [AnimeController::class, 'genreList'])->name('anime.genre.list');
Route::get('/anime/genre/{id}', [AnimeController::class, 'byGenre'])->name('anime.by.genre');
Route::get('/anime/all', [AnimeController::class, 'all'])->name('anime.all');
Route::get('/anime/search', [AnimeController::class, 'search'])->name('anime.search');
Route::get('/anime/{id}', [AnimeController::class, 'show'])->name('anime.show');
