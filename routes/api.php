<?php

use App\Http\Controllers\NoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/notes', [NoteController::class, 'index']);
Route::post('/notes', [NoteController::class, 'store']);
Route::get('/notes/{id}', [NoteController::class, 'show']);
Route::put('/notes/{id}', [NoteController::class, 'update']);
Route::delete('/notes/{id}', [NoteController::class, 'destroy']);
Route::put('/notes/{id}/restore', [NoteController::class, 'restore']);

// Favorite / Unfavorite
Route::put('/notes/{id}/favorite', [NoteController::class, 'favorite']);
Route::put('/notes/{id}/unfavorite', [NoteController::class, 'unfavorite']);
