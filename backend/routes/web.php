<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::resource('articles', ArticleController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
});

Route::middleware('auth')->group(function () {
    Route::resource('tags', TagController::class);
    /*

    Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
    
    Route::delete('/tags{id}', [TagController::class, 'destroy'])->name('tags.destroy');
    Route::get('/tags/{id}', [TagController::class, 'edit'])->name('tags.edit');
    Route::patch('/tags{id}', [TagController::class, 'update'])->name('tags.update');
    */
});

require __DIR__.'/auth.php';
