<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::middleware('authCheck')->group(function () {

    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::get('/categories', [CategoryController::class, 'index'])->name('category');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('category-store');
    Route::post('/categories/update', [CategoryController::class, 'update'])->name('category-update');
    Route::post('/categories/{id}/delete', [CategoryController::class, 'destroy'])->name('category-destroy');
    Route::post('/categories/update-category-status', [CategoryController::class, 'updateCategoryStatus'])->name('update-category-status');

    Route::get('/brands', [BrandController::class, 'index'])->name('brand');
    Route::post('/brands/store', [BrandController::class, 'store'])->name('brand-store');
    Route::post('/brands/update', [BrandController::class, 'update'])->name('brand-update');
    Route::post('/brands/{id}/delete', [BrandController::class, 'destroy'])->name('brand-destroy');
    Route::post('/brands/update-brand-status', [BrandController::class, 'updateBrandStatus'])->name('update-brand-status');

    Route::get('/products', [ProductController::class, 'index'])->name('product');
    Route::post('/products/store', [ProductController::class, 'store'])->name('product-store');
    Route::post('/products/update', [ProductController::class, 'update'])->name('product-update');
    Route::post('/products/{id}/delete', [ProductController::class, 'destroy'])->name('product-destroy');
    Route::post('/products/update-product-status', [ProductController::class, 'updateProductStatus'])->name('update-product-status');
    Route::get('/products-search', [ProductController::class, 'search'])->name('product-search');
    Route::get('/products-filter', [ProductController::class, 'filter'])->name('product-filter');


    Route::middleware('adminCheck')->group(function () {
        Route::get('users', [UserController::class, 'index'])->name('user');
        Route::post('/users/store', [UserController::class, 'store'])->name('user-store');
        Route::post('/users/update', [UserController::class, 'update'])->name('user-update');
        Route::post('/users/{id}/delete', [UserController::class, 'destroy'])->name('user-destroy');
        Route::post('/users/update-user-status', [UserController::class, 'updateUserStatus'])->name('update-user-status');
        Route::get('/users-search', [UserController::class, 'search'])->name('user-search');
        Route::get('/users-filter', [UserController::class, 'filter'])->name('user-filter');
    });
});


Route::middleware('loggedIn')->group(function () {
    Route::view('/', 'auth.login')->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('user-login');
});

Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::view('forgot-password', 'auth.forgot-password')->name('forgot-password');
Route::post('forgot-password', [AuthController::class, 'sendEmail'])->name('send-email');

Route::view('verification','auth.verification')->name('verification');
Route::post('verify', [AuthController::class, 'verify'])->name('verify');


Route::view('reset-password','auth.reset-password')->name('reset-password');
Route::post('reset', [AuthController::class, 'reset'])->name('reset');
