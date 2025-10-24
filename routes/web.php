<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController; 

// Rotas públicas
Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [UserController::class, 'register'])->name('register');

Route::get('/login', [UserController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [UserController::class, 'login'])->name('login');


Route::middleware('auth')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    
    Route::resource('products', ProductController::class);

   
    Route::get('/reports/products', [ReportController::class, 'productsReport'])->name('reports.products');
    Route::get('/reports/users', [ReportController::class, 'usersReport'])->name('reports.users');
});

