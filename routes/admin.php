<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\DoctorManageController;
use Illuminate\Support\Facades\Route;

Route::get('/login',[AdminController::class, 'login'])->name('login');
Route::post('/system/login',[AdminController::class, 'systemLogin'])->name('system.login');

Route::prefix('admin')->middleware(['super_admin'])->group(function(){
    Route::get('/dashboard',[AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/logout',[AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::controller(DoctorManageController::class)->group(function(){
     Route::get('/doctor/list','doctorList')->name('doctor.list');
     Route::get('/doctor/form','createdocForm')->name('doctor.form');
     Route::post('/Add/doctor','AddDoctor')->name('AddDoctor');
    });
});
