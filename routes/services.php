<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServicesController;

// Services Routes
Route::name('service.')->prefix('/')->group(function () {
    Route::post('/store-service/{client:hashID}', [ServicesController::class, 'storeService'])->name('store');
    Route::post('/create-invoice-service/{client:hashID}', [ServicesController::class, 'addToInvoice'])->name('invoice');
});
