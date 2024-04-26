<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// User routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/all-user', function (Request $request) {
        return $request->user()->all();
    });
});

// Item routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/create-item', [ApiController::class, 'createItem']);
    Route::get('/all-items', [ApiController::class, 'allItems']);
});

//login
Route::post('/login', [ApiController::class, 'login']);
//register
Route::post('/register', [ApiController::class, 'register']);
