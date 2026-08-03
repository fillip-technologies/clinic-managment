<?php

use App\Http\Controllers\Admin\RoomCreateController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\DoctorManageController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Patient\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AdminController::class, 'login'])->name('login');
Route::post('/system/login', [AdminController::class, 'systemLogin'])->name('system.login');

Route::prefix('admin')->middleware(['super_admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::controller(DoctorManageController::class)->group(function () {
        Route::get('/doctor/list', 'doctorList')->name('doctor.list');
        Route::get('/doctor/form', 'createdocForm')->name('doctor.form');
        Route::delete('doctor/delete/{id}', 'DeleteDoctor')->name('doctor.delete');
        Route::get('/edit/doctor/{id}', 'editDoctor')->name('doctor.edit');
        Route::post('/appoinmentstore', 'appoinmentstore')->name('appoinmentstore');
        Route::get('/listappoinment', 'listappoinment')->name('listappoinment');
        Route::post('/update/doctor/{id}', 'UpdateDoctor')->name('doctor.update');
        Route::post('/Add/doctor', 'AddDoctor')->name('AddDoctor');
    });

    Route::controller(PatientController::class)->group(function () {
        Route::get('/patient/list', 'patientList')->name('list.patient');
        Route::get('/patient/form', 'createPatient')->name('patient.form');
        Route::post('/store/patient', 'store')->name('store.patient');
        Route::post('/patient/update/{id}', 'update')->name('patient.update');
        Route::get('/addnewReport/{id}', 'addnewReport')->name('addnewReport');
        Route::post('/createNewRecord/{id}', 'createNewRecord')->name('createNewRecord');
        Route::get('/single/patient/{id}', 'edit')->name('patient.edit');
        Route::delete('/delete/patient/{id}', 'destroy')->name('patient.delete');
        Route::get('/analytics/disease','diseaseAnalytics')->name('analytics.disease');
    });

    Route::controller(ReportController::class)->group(function () {
        Route::get('/obesity/report', 'obesityReport')->name('report.obesityReport');
        Route::get('/diabetes/report', 'diabetesReport')->name('report.diabetesReport');
        Route::get('/hypertensio/report', 'hypertensioReport')->name('report.hypertensioReport');
        Route::get('/Infection/report', 'InfectionReport')->name('report.InfectionReport');
    });

    Route::controller(RoomCreateController::class)->group(function () {
        Route::get('/edit/room/{id}', 'roomEdit')->name('room.edit');
        Route::get('/listing/room/data', 'roomListing')->name('room.list');
        Route::post('/create/room/data', 'roomStore')->name('room.store');
        Route::post('/update/room/{id}', 'roomUpdated')->name('room.update');
        Route::get('/delete/room/{id}', 'roomDelete')->name('room.delete');
        Route::get('/member/index/{id}/{index}','indexmember')->name('indexmember');
    });
});
