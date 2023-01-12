<?php

use App\Http\Controllers\ForeignProvidersController;
use Illuminate\Support\Facades\Route;

// Foreign Providers Routes
Route::name('foreign-provider.')->prefix('/')->group(function () {
    Route::get('/foreign-providers', [ForeignProvidersController::class, 'index'])->name('list');
    Route::get('/view-foreign-provider/{vat}', [ForeignProvidersController::class, 'view'])->name('view');
    Route::get('/add-foreign-provider', [ForeignProvidersController::class, 'new'])->name('add');
    Route::post('/store-foreign-provider', [ForeignProvidersController::class, 'store'])->name('store');
    Route::get('/edit-foreign-provider/{vat}', [ForeignProvidersController::class, 'edit'])->name('edit');
    Route::post('/update-foreign-provider/{provider}', [ForeignProvidersController::class, 'update'])->name('update');
    Route::get('/delete-foreign-provider/{vat}', [ForeignProvidersController::class, 'softDelete'])->name('delete');
    Route::get('/enable-foreign-provider/{vat}', [ForeignProvidersController::class, 'enable'])->name('enable');
});
