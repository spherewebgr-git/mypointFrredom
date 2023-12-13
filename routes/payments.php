<?php

use App\Http\Controllers\PaymentsController;
use Illuminate\Support\Facades\Route;

// Payments Routes
Route::name('payment.')->prefix('/')->group(function () {
    Route::get('/payments', [PaymentsController::class, 'index'])->name('list');
    Route::get('/download-payment/{payment:hashID}', [PaymentsController::class, 'view'])->name('view');
    Route::get('/add-payment', [PaymentsController::class, 'new'])->name('add');
    Route::post('/store-payment', [PaymentsController::class, 'store'])->name('store');
    Route::get('/edit-payment/{payment:hashID}', [PaymentsController::class, 'edit'])->name('edit');
    Route::post('/update-payment/{payment:hashID}', [PaymentsController::class, 'update'])->name('update');
    Route::get('/delete-payment/{payment:hashID}', [PaymentsController::class, 'softDelete'])->name('delete');
    Route::get('/download-payment/{payment:paymentHash}', [PaymentsController::class, 'download'])->name('download');
    //Route::get('/enable-provider/{vat}', [ProvidersController::class, 'enable'])->name('enable');
    //Route::post('/provider-search-ajax', [ProvidersController::class, 'search'])->name('search');
    //Route::post('/provider-check-vat', [ProvidersController::class, 'checkVat'])->name('vies');
});
