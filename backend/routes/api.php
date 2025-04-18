<?php

use App\Http\Controllers\Api\ApiSectionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiArticleController;
use App\Http\Controllers\Api\ApiCommentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/articles', [ApiArticleController::class ,'index']);
Route::post('/comments', [ApiCommentController::class ,'sendComment']);
Route::get('/sections', [ApiSectionController::class, 'index']);