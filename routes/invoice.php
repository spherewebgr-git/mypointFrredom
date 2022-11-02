<?php

use App\Http\Controllers\InvoicesController;
use Illuminate\Support\Facades\Route;

//Invoice Routes
Route::name('invoice.')->prefix('/')->group(function () {
    Route::get('/invoices', [InvoicesController::class, 'index'])->name('list');
    Route::post('/filter-invoices', [InvoicesController::class, 'filter'])->name('filter');
    Route::get('/create-invoice', [InvoicesController::class, 'new'])->name('create');
    Route::post('/store-invoice', [InvoicesController::class, 'store'])->name('store');
    Route::get('/view-invoice/{invoice:hashID}', [InvoicesController::class, 'view'])->name('view');
    Route::get('/save-invoice/{invoiceID}', [InvoicesController::class, 'save'])->name('save');
    Route::get('/edit-invoice/{invoice}', [InvoicesController::class, 'edit'])->name('edit');
    Route::get('/delete-invoice/{invoice::hashID}', [InvoicesController::class, 'delete'])->name('delete');
    Route::post('/update-invoice/{invoice:hashID}', [InvoicesController::class, 'update'])->name('update');
    Route::get('/download-invoice/{invoice:hashID}', [InvoicesController::class, 'download'])->name('download');
    Route::get('/myData-invoice/{invoice:hashID}', [InvoicesController::class, 'sendInvoice'])->name('mydata');
    Route::post('/myData-invoices-multiple', [InvoicesController::class, 'sendMyDataInvoices'])->name('mydata.multiple');
    Route::post('/last-invoice-ajax', [InvoicesController::class, 'lastInvoiceAjax'])->name('last-retail');
});
