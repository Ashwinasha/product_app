<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// Set the index page as the home page
Route::get('/', [ProductController::class, 'index'])->name('home');

// Routes for products management
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

// Ensure index route is defined
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Route to delete an image
Route::delete('/products/{id}/delete-image', [ProductController::class, 'deleteImage'])->name('products.deleteImage');

// Route to update an image
Route::post('/products/{id}/update-image', [ProductController::class, 'updateImage'])->name('products.updateImage');

// Route to update an image
