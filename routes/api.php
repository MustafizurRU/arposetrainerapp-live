<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// User routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        $user = $request->user();
        return response()->json(['status' => 'success',  'message' => 'User information retrieved successfully', 'user' => $user], 200);
    });

    Route::get('/all-user', function (Request $request) {
        $users = $request->user()->all();
        return response()->json(['status' => 'success', 'message' => 'All users retrieved successfully', 'users' => $users], 200);
    });
});

// Item routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/create-item', [ApiController::class, 'createItem']);
    Route::get('/all-items', [ApiController::class, 'allItems']);
    //update item
    Route::put('/update-item/{id}', [ApiController::class, 'updateItem']);
    //levelWise user level Data
    Route::get('/level-wise-data', [ApiController::class, 'levelWiseUserData']);
});

//login
Route::post('/login', [ApiController::class, 'login']);
//register
Route::post('/register', [ApiController::class, 'register']);

//upload image
Route::post('/upload-image', [ApiController::class, 'uploadImage']);
//update image
Route::put('/update-image/{id}', [ApiController::class, 'updateImage']);
