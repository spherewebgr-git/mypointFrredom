<?php

use App\Http\Controllers\ProvidersController;
use Illuminate\Support\Facades\Route;

// Providers Routes
Route::name('provider.')->prefix('/')->group(function () {
    Route::get('/providers', [ProvidersController::class, 'index'])->name('list');
    Route::get('/view-provider/{vat}', [ProvidersController::class, 'view'])->name('view');
    Route::get('/add-provider', [ProvidersController::class, 'new'])->name('add');
    Route::post('/store-provider', [ProvidersController::class, 'store'])->name('store');
    Route::get('/edit-provider/{vat}', [ProvidersController::class, 'edit'])->name('edit');
    Route::post('/update-provider/{provider}', [ProvidersController::class, 'update'])->name('update');
    Route::get('/delete-provider/{vat}', [ProvidersController::class, 'softDelete'])->name('delete');
    Route::get('/enable-provider/{vat}', [ProvidersController::class, 'enable'])->name('enable');
    Route::post('/provider-search-ajax', [ProvidersController::class, 'search'])->name('search');
});
