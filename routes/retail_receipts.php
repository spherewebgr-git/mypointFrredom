<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RetailReceiptsController;

// Retail Receipts Routes
Route::name('retail-receipts.')->prefix('/')->group(function () {
    Route::get('/retail-receipts', [RetailReceiptsController::class, 'index'])->name('list');
    Route::get('/create-retail-receipt', [RetailReceiptsController::class, 'new'])->name('create');
    Route::post('/store-retail-receipt', [RetailReceiptsController::class, 'store'])->name('store');
    Route::get('/view-retail-receipt/{retailID}', [RetailReceiptsController::class, 'view'])->name('view');
    Route::get('/save-retail-receipt/{retailID}', [RetailReceiptsController::class, 'save'])->name('save');
    Route::get('/edit-retail-receipt/{invoice}', [RetailReceiptsController::class, 'edit'])->name('edit');
    Route::get('/delete-retail-receipt/{retail::hashID}', [RetailReceiptsController::class, 'delete'])->name('delete');
    Route::post('/update-retail-receipt/{retail:hashID}', [RetailReceiptsController::class, 'update'])->name('update');
    Route::get('/download-retail-receipt/{retail:hashID}', [RetailReceiptsController::class, 'download'])->name('download');
    Route::get('/myData-retail-receipt/{retailID}', [RetailReceiptsController::class, 'sendInvoice'])->name('mydata');
});
