<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoodsController;

// Services Routes
Route::name('products.')->prefix('/')->group(function () {
    Route::get('/products', [GoodsController::class, 'index'])->name('index');
    Route::get('/add-product', [GoodsController::class, 'create'])->name('create');
    Route::post('/store-product', [GoodsController::class, 'store'])->name('store');
    Route::post('/update-product', [GoodsController::class, 'update'])->name('update');
    Route::get('/edit-product/{product_number}', [GoodsController::class, 'edit'])->name('edit');
});
