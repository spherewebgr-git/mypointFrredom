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
    Route::post('/update-sale-invoice/{invoice:hashID}', [SaleInvoicesController::class, 'update'])->name('update');
    Route::get('/view-sale-invoice/{invoice:hashID}', [SaleInvoicesController::class, 'view'])->name('view');
//    Route::get('/save-invoice/{invoiceID}', [SaleInvoicesController::class, 'save'])->name('save');
    Route::get('/edit-sale_invoice/{invoice}', [SaleInvoicesController::class, 'edit'])->name('edit');
//    Route::get('/delete-invoice/{invoice::hashID}', [SaleInvoicesController::class, 'delete'])->name('delete');
//    Route::get('/download-invoice/{invoice:hashID}', [SaleInvoicesController::class, 'download'])->name('download');
    Route::get('/myData-sale_invoice/{invoice:hashID}', [SaleInvoicesController::class, 'sendInvoice'])->name('mydata');
//    Route::post('/myData-invoices-multiple', [SaleInvoicesController::class, 'sendMyDataInvoices'])->name('mydata.multiple');
//    Route::post('/last-invoice-ajax', [SaleInvoicesController::class, 'lastInvoiceAjax'])->name('last-retail');
});
