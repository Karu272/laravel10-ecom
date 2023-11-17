<?php

use App\Http\Controllers\Admin\AdminController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('admin')->group(function () {

    Route::match(['get', 'post'], 'login', [AdminController::class, 'login']);

    Route::middleware(['admin'])->group(function (){
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('logout', [AdminController::class,'logout'])->name('admin.login');
        /* ========== Admin Setup ========== */
        Route::get('update-password', [AdminController::class,'updatePassword'])->name('admin.update_password');
        Route::post('check-current-password', [AdminController::class, 'checkCurrentPassword']);
    });

});
