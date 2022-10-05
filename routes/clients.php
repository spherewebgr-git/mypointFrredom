<?php

use App\Http\Controllers\ClientsController;
use Illuminate\Support\Facades\Route;

// Clients Routes
Route::name('client.')->prefix('/')->group(function () {
    Route::get('/clients', [ClientsController::class, 'index'])->name('list');
    Route::get('/view-client/{hashID}', [ClientsController::class, 'view'])->name('view');
    Route::get('/add-client', [ClientsController::class, 'new'])->name('add');
    Route::post('/store-client', [ClientsController::class, 'store'])->name('store');
    Route::get('/edit-client/{vat}', [ClientsController::class, 'edit'])->name('edit');
    Route::post('/update-client/{client}', [ClientsController::class, 'update'])->name('update');
    Route::get('/delete-client/{hashID}', [ClientsController::class, 'softDelete'])->name('delete');
    Route::get('/enable-client/{vat}', [ClientsController::class, 'enable'])->name('enable');
});
