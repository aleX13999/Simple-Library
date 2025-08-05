<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(base_path('routes/api_v1.php'));

Route::post('/register', [AuthController::class, 'register']);
Route::post('/register/admin', [AuthController::class, 'adminAuthor'])->middleware(['auth:sanctum', 'role:admin']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
