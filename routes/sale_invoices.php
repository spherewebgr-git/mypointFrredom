<?php

use App\Http\Controllers\SaleInvoicesController;
use App\Http\Controllers\GoodsController;
use Illuminate\Support\Facades\Route;

//Invoice Routes
Route::name('sale_invoice.')->prefix('/')->group(function () {
    Route::get('/sale-invoices', [SaleInvoicesController::class, 'index'])->name('list');
//    Route::post('/filter-invoices', [InvoicesController::class, 'filter'])->name('filter');
    Route::get('/create-sale-invoice', [SaleInvoicesController::class, 'new'])->name('create');
    Route::post('/store-sale-invoice', [SaleInvoicesController::class, 'store'])->name('store');
    Route::post('/update-invoice/{invoice:hashID}', [SaleInvoicesController::class, 'update'])->name('update');
//    Route::get('/view-invoice/{invoice:hashID}', [InvoicesController::class, 'view'])->name('view');
//    Route::get('/save-invoice/{invoiceID}', [InvoicesController::class, 'save'])->name('save');
//    Route::get('/edit-invoice/{invoice}', [InvoicesController::class, 'edit'])->name('edit');
//    Route::get('/delete-invoice/{invoice::hashID}', [InvoicesController::class, 'delete'])->name('delete');
//    Route::get('/download-invoice/{invoice:hashID}', [InvoicesController::class, 'download'])->name('download');
//    Route::get('/myData-invoice/{invoiceID}', [InvoicesController::class, 'sendInvoice'])->name('mydata');
//    Route::post('/myData-invoices-multiple', [InvoicesController::class, 'sendMyDataInvoices'])->name('mydata.multiple');
//    Route::post('/last-invoice-ajax', [InvoicesController::class, 'lastInvoiceAjax'])->name('last-retail');
});
