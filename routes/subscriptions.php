<?php

use App\Http\Controllers\SubscriptionsController;
use Illuminate\Support\Facades\Route;


// Settings Routes
Route::name('subscriptions.')->prefix('/')->group(function () {
    Route::get('/services', [SubscriptionsController::class, 'index'])->name('view');
    Route::post('/update-subscription/{subscription}', [SubscriptionsController::class, 'update'])->name('update');
    Route::post('/store-subscription', [SubscriptionsController::class, 'store'])->name('store');
    Route::get('/new-subscription', [SubscriptionsController::class, 'new'])->name('new');
    Route::get('/edit-subscription/{service:hashID}', [SubscriptionsController::class, 'edit'])->name('edit');
});
