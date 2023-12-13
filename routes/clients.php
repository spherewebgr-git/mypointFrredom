<?php

use App\Http\Controllers\ClientsController;
use Illuminate\Support\Facades\Route;

// Clients Routes
Route::name('client.')->prefix('/')->group(function () {
    Route::get('/clients', [ClientsController::class, 'index'])->name('list');
    Route::get('/view-client/{hashID}', [ClientsController::class, 'view'])->name('view');
    Route::get('/add-client', [ClientsController::class, 'new'])->name('add');
    Route::post('/store-client', [ClientsController::class, 'store'])->name('store');
    Route::post('/check-afm', [ClientsController::class, 'vatCheck'])->name('vatCheck');
    Route::get('/edit-client/{hashID}', [ClientsController::class, 'edit'])->name('edit');
    Route::post('/update-client/{client}', [ClientsController::class, 'update'])->name('update');
    Route::get('/delete-client/{hashID}', [ClientsController::class, 'softDelete'])->name('delete');
    Route::get('/enable-client/{hashID}', [ClientsController::class, 'enable'])->name('enable');
    Route::post('/delete-address-ajax', [ClientsController::class, 'deleteAddress'])->name('delete-address');
    Route::post('/client-address-ajax', [ClientsController::class, 'getAddress'])->name('get-addresses');
    Route::post('/client-search-ajax', [ClientsController::class, 'search'])->name('search');
    Route::post('/client-invoices-search-ajax', [ClientsController::class, 'invoices'])->name('search.invoices');
});
