<?php

use App\Http\Controllers\Backend\AdminController;
use Illuminate\Support\Facades\Route;

Route::prefix('doctor')->middleware(['doctor'])->group(function(){
    Route::get('/dashboard',[AdminController::class, 'dashboard'])->name('doctor.dashboard');
    Route::post('/logout',[AdminController::class, 'doctorLogout'])->name('doctor.logout');
});
