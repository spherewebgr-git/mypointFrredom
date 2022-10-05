<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingsController;


// Settings Routes
Route::name('settings.')->prefix('/')->group(function () {
    Route::get('/application-settings', [SettingsController::class, 'index'])->name('view');
    Route::post('/update-settings/{form}', [SettingsController::class, 'update'])->name('update');
});
