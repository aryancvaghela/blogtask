<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [HomeController::class, 'showLogin'])->name('login');
Route::post('/login', [HomeController::class, 'doLogin'])->name('login.post');

Route::get('/register', [HomeController::class, 'showRegister'])->name('register');
Route::post('/register', [HomeController::class, 'doRegister'])->name('register.post');

Route::post('/logout', [HomeController::class, 'logout'])->name('logout');
Route::middleware('auth')->group(function () {

    Route::get('/user', [HomeController::class, 'getUsersData'])->name('users.data');
    Route::get('/users/{id}/edit', [HomeController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [HomeController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [HomeController::class, 'destroy'])->name('users.destroy');

    Route::resource('blogs', BlogController::class);
    Route::get('get-blogs', [BlogController::class, 'getBlogs'])->name('blogs.get');
});
