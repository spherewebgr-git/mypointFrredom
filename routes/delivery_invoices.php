<?php

use App\Http\Controllers\DeliveryInvoicesController;
use Illuminate\Support\Facades\Route;

//Invoice Routes
Route::name('delivery_invoice.')->prefix('/')->group(function () {
    Route::get('/delivery-invoices', [DeliveryInvoicesController::class, 'index'])->name('list');
//    Route::post('/filter-invoices', [InvoicesController::class, 'filter'])->name('filter');
    Route::get('/create-delivery-invoice', [DeliveryInvoicesController::class, 'new'])->name('create');
    Route::post('/store-sale-invoice', [DeliveryInvoicesController::class, 'store'])->name('store');
    Route::post('/update-sale-invoice/{invoice:hashID}', [DeliveryInvoicesController::class, 'update'])->name('update');
    Route::get('/view-sale_invoice/{invoice:hashID}', [DeliveryInvoicesController::class, 'view'])->name('view');
    Route::get('/save-sale_invoice/{invoiceID}', [DeliveryInvoicesController::class, 'save'])->name('save');
    Route::get('/edit-sale_invoice/{invoice}', [DeliveryInvoicesController::class, 'edit'])->name('edit');
//    Route::get('/delete-invoice/{invoice::hashID}', [DeliveryInvoicesController::class, 'delete'])->name('delete');
    Route::get('/download-sale_invoice/{invoice:hashID}', [DeliveryInvoicesController::class, 'download'])->name('download');
    Route::get('/myData-sale_invoice/{invoice:hashID}', [DeliveryInvoicesController::class, 'sendInvoice'])->name('mydata');
//    Route::post('/myData-invoices-multiple', [DeliveryInvoicesController::class, 'sendMyDataInvoices'])->name('mydata.multiple');
//    Route::post('/last-invoice-ajax', [DeliveryInvoicesController::class, 'lastInvoiceAjax'])->name('last-retail');
});
