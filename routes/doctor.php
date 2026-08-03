<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Patient\ReportController;
use Illuminate\Support\Facades\Route;

Route::prefix('doctor')->middleware(['doctor'])->group(function(){
    Route::get('/dashboard',[AdminController::class, 'dashboard'])->name('doctor.dashboard');
    Route::controller(ReportController::class)->group(function(){
    Route::get('/doctor/report/form','doctorReportform')->name('doctor.report.form');
    Route::get('/doctor/repor/list','doctorReporlist')->name('doctorReporlist');
    Route::get('/editdocrep/{id}','editDocRep')->name('editDocRep.edit');
    Route::post('/docRepstore','docRepstore')->name('docRepstore.store');
    Route::post('/doc/rep/update/{id}','DocRepupdate')->name('DocRepupdate.update');
    Route::delete('/doc/repo/destroy/{id}','DocRepodestroy')->name('DocRepodestroy.delete');
    });
    Route::post('/logout',[AdminController::class, 'doctorLogout'])->name('doctor.logout');
});
