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
    Route::get('/{article}/edit', 'edit')->name('edit');
    Route::post('/{article}/edit', 'update');
    
    Route::get('/{slug}-{article}', 'show')->where([
        'article' => '[0-9]+',
        'slug' => '[a-z0-9\-]+'
    ])->name('show');
});