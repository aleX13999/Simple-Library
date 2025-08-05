<?php

use App\Http\Controllers\Api\Admin\AuthorController;
use App\Http\Controllers\Api\Admin\BookController;
use App\Http\Controllers\Api\Admin\GenreController;
use App\Http\Controllers\Api\Author\AuthorBookController;
use App\Http\Controllers\Api\Author\AuthorProfileController;
use App\Http\Controllers\Api\PublicApiController;
use Illuminate\Support\Facades\Route;

Route::get('books', [PublicApiController::class, 'books']);
Route::get('books/{book}', [PublicApiController::class, 'book']);
Route::get('authors', [PublicApiController::class, 'authors']);
Route::get('authors/{author}', [PublicApiController::class, 'author']);
Route::get('genres', [PublicApiController::class, 'genres']);

// Автор (role: author)
Route::middleware(['auth:sanctum', 'role:author'])->prefix('author')->group(function () {
    Route::patch('profile', [AuthorProfileController::class, 'update']);
    Route::patch('books/{book}', [AuthorBookController::class, 'update']);
    Route::delete('books/{book}', [AuthorBookController::class, 'destroy']);
});

// Админ (role: admin)
Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    Route::apiResource('books', BookController::class);
    Route::apiResource('authors', AuthorController::class);
    Route::apiResource('genres', GenreController::class);
});
