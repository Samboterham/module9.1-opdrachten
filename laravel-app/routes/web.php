<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('posts.index');
});

Route::get('/post', function () {
    return view('posts.show');
})->name('posts.show');
