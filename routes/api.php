<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/all-user', function (Request $request) {
    return $request->user()->all();
})->middleware('auth:sanctum');

//login
Route::post('/login', [ApiController::class, 'login']);
//register
Route::post('/register', [ApiController::class, 'register']);
