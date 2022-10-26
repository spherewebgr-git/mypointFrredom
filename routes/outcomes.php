<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OutcomesController;

// Outcomes Routes
Route::name('outcome.')->prefix('/')->group(function () {
    Route::get('/outcomes', [OutcomesController::class, 'index'])->name('list');
    Route::get('/create-outcome', [OutcomesController::class, 'new'])->name('create');
    Route::post('/store-outcome', [OutcomesController::class, 'store'])->name('store');
    Route::get('/download-outcome/{outcome:hashID}', [OutcomesController::class, 'download'])->name('download');
    Route::get('/delete-outcome/{outcome:hashID}', [OutcomesController::class, 'destroy'])->name('delete');
    Route::get('/edit-outcome/{outcome:hashID}', [OutcomesController::class, 'edit'])->name('edit');
    Route::post('/update-outcome/{outcome:hashID}', [OutcomesController::class, 'update'])->name('update');
    Route::post('/filter-outcomes', [OutcomesController::class, 'filter'])->name('filter');
    Route::post('/outcome-send-classifications/{outcome:hashID}', [OutcomesController::class, 'sendClassifications'])->name('classifications');
    Route::post('/update-classifications/{outcome:hashID}', [OutcomesController::class, 'updateClassifications'])->name('classifications.update');
    Route::post('/send-classifications/MyData', [OutcomesController::class, 'sendClassificationsMyData'])->name('mydata');
    Route::get('/getExpenses/MyData', [OutcomesController::class, 'requestExpenses'])->name('getExpenses');
    Route::post('/ajax-delete-classification', [OutcomesController::class, 'deleteClassification'])->name('deleteClassification');
});
