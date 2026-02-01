<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Favorite;
use App\Models\Tag;

Route::get('/test-db', function () {
    $users = User::all();
    $favorites = Favorite::all();
    $tags = Tag::all();
    
    return view('test-db', compact('users', 'favorites', 'tags'));
});