<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group.
|
*/

// Guest Routes
Route::get('/', [LoginController::class, 'index']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm']);


// Logged in User - Global Routes
Route::group(['middleware' => 'auth'], function() {
    // Global Routes
    Route::get('/signout', [LoginController::class, 'signOut'])->name('signOut');
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');

});

Auth::routes(['verify' => true]);
