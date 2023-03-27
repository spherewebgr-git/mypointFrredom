<?php

use App\Http\Controllers\NotificationsController;
use Illuminate\Support\Facades\Route;

Route::name('notification.')->prefix('/')->group(function () {
    Route::get('/send-notification/{type}/{hashID}', [NotificationsController::class, 'send'])->name('send');

});
