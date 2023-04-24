<?php

use App\Http\Controllers\ShopConnectController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoodsController;

// Products Routes
Route::name('products.')->prefix('/')->group(function () {
    Route::get('/products', [GoodsController::class, 'index'])->name('index');
    Route::get('/add-product', [GoodsController::class, 'create'])->name('create');
    Route::get('/update-storage', [GoodsController::class, 'viewStorage'])->name('storage');
    Route::post('/update-products-storage', [GoodsController::class, 'addToStorage'])->name('update-products');
    Route::post('/store-product', [GoodsController::class, 'store'])->name('store');
    Route::post('/update-product', [GoodsController::class, 'update'])->name('update');
    Route::get('/edit-product/{product_number}', [GoodsController::class, 'edit'])->name('edit');
});
// Store Connection Routes
Route::name('shop.')->prefix('/')->group(function () {
    Route::get('/get-product-image/{product_id}', [ShopConnectController::class, 'getProductImage'])->name('product.image');
    Route::get('/update-eshop-storage', [ShopConnectController::class, 'updateEshopStorage'])->name('storage.update');
});
