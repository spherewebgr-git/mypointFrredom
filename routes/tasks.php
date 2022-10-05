<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasksController;


// Tasks Route
Route::name('tasks.')->prefix('/')->group(function () {
    Route::get('/tasks', [TasksController::class, 'index'])->name('list');
    Route::get('/store-task', [TasksController::class, 'store'])->name('store');
    Route::get('/create-task', [TasksController::class, 'store'])->name('create');
    Route::post('/change-task-state/{task}', [TasksController::class, 'setState'])->name('state');
    Route::get('/change-task-state/{task}', [TasksController::class, 'destroy'])->name('delete');
});
