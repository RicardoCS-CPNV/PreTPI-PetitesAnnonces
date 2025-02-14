<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::delete('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::post('/login', [AuthController::class, 'doLogin']);

Route::post('/signup', [AuthController::class, 'store']);
Route::get('/signup', function () {
    return view('auth.signup');
})->name('auth.signup');

Route::get('/update', [AuthController::class,'edit'])->name('auth.update')->middleware('auth');
Route::post('/update', [AuthController::class,'update']);