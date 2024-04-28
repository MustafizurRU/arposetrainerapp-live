<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserInformationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::view('/', 'auth.login')->name('');

Route::get('/test', [TestController::class, 'calculateUserStats'])->name('test.calculate');

Route::middleware(['auth', 'verified'])->group(function () {
    //super admin routes
    Route::get('/dashboard', [AdminController::class,'index'])->name('dashboard');
    //all user routes
    Route::get('/users', [AdminController::class, 'alluser'])->name('users');
    //search user
    Route::get('/search', [AdminController::class, 'search'])->name('search');
    //overall performance search
    //user view
    Route::get('/user/{id}', [UserInformationController::class, 'show'])->name('user.view');
    //user edit
    Route::get('/user/{id}/edit', [UserInformationController::class, 'edit'])->name('user.edit');
    //user update
    Route::put('/user/{id}', [UserInformationController::class, 'update'])->name('user.update');
    //user delete
    Route::delete('/user/{id}', [UserInformationController::class, 'destroy'])->name('user.destroy');

});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
