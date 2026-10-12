<?php

use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BlogController::class, 'index'])->name('posts.index');
Route::get('/post/{slug}', [BlogController::class, 'show'])->name('posts.show');
