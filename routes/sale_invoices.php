<?php

use App\Http\Controllers\SaleInvoicesController;
use App\Http\Controllers\GoodsController;
use Illuminate\Support\Facades\Route;

//Invoice Routes
Route::name('sale_invoice.')->prefix('/')->group(function () {
    Route::get('/sale-invoices', [SaleInvoicesController::class, 'index'])->name('list');
    Route::post('/filter-sale-invoices', [SaleInvoicesController::class, 'filter'])->name('filter');
    Route::get('/create-sale-invoice', [SaleInvoicesController::class, 'new'])->name('create');
    Route::post('/store-sale-invoice', [SaleInvoicesController::class, 'store'])->name('store');
    Route::post('/update-sale-invoice/{invoice:hashID}', [SaleInvoicesController::class, 'update'])->name('update');
    Route::get('/view-sale_invoice/{invoice:hashID}', [SaleInvoicesController::class, 'view'])->name('view');
    Route::get('/save-sale_invoice/{invoiceID}', [SaleInvoicesController::class, 'save'])->name('save');
    Route::get('/edit-sale_invoice/{invoice}', [SaleInvoicesController::class, 'edit'])->name('edit');
    Route::get('/delete-sale-invoice/{invoice::hashID}', [SaleInvoicesController::class, 'delete'])->name('delete');
    Route::get('/download-sale_invoice/{invoice:hashID}', [SaleInvoicesController::class, 'download'])->name('download');
    Route::get('/myData-sale_invoice/{invoice:hashID}', [SaleInvoicesController::class, 'sendInvoice'])->name('mydata');
    Route::get('/sale_invoice/send-email/{invoice:hashID}', [SaleInvoicesController::class, 'sendInvoiceEmail'])->name('mail');
//    Route::post('/myData-invoices-multiple', [SaleInvoicesController::class, 'sendMyDataInvoices'])->name('mydata.multiple');
    Route::post('/last-saleInvoice-ajax', [SaleInvoicesController::class, 'lastInvoiceAjax'])->name('last-seira');
});
