<?php

use App\Http\Controllers\Api\ApiSectionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiArticleController;
use App\Http\Controllers\Api\ApiCommentController;
use App\Http\Controllers\Api\AuthFrontEndController;


Route::post('/login', [AuthFrontEndController::class, 'login']);
Route::post('/logout', [AuthFrontEndController::class, 'logout']);
Route::post('/register', [AuthFrontEndController::class, 'register']);
// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('/articles', [ApiArticleController::class ,'index']);
Route::get('/articles/{id}', [ApiArticleController::class ,'show']);
Route::get('/articles/{id}/comments', [ApiCommentController::class, 'getByArticle']);
// Route::get('/comments', [ApiCommentController::class ,'index']);
Route::post('/comments', [ApiCommentController::class ,'addComment']);
Route::get('/sections', [ApiSectionController::class, 'index']);
Route::post('/comments/flag', [ApiCommentController::class, 'flagComment']);