<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Models\Category;
use App\Models\Post;
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

// Route::get('/', [CategoryController::class, 'index'])->name('posts.index');

// Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

Route::prefix( '/posts')->name('posts.')->controller(PostController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/new', 'create')->name('create');
    Route::post('/new', 'store');
    Route::get('/{post}/edit', 'edit')->where([
        'post' => '[0-9]+',
    ])->name('edit');
    Route::post('/{post}/edit', 'update')->name('update');
    
    Route::get('/{post}', 'show')->where([
        'post' => '[0-9]+',
    ])->name('show');
});