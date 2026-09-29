<?php

use App\Http\Controllers\Admin\RoomCreateController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\DoctorManageController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Patient\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AdminController::class, 'login'])->name('login');
Route::post('/system/login', [AdminController::class, 'systemLogin'])->name('system.login');

// Super admin only (not delegable)
Route::prefix('admin')->middleware(['super_admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::controller(DoctorManageController::class)->group(function () {
        Route::get('/doctor/list', 'doctorList')->name('doctor.list');
        Route::get('/doctor/form', 'createdocForm')->name('doctor.form');
        Route::delete('doctor/delete/{id}', 'DeleteDoctor')->name('doctor.delete');
        Route::get('/edit/doctor/{id}', 'editDoctor')->name('doctor.edit');
        Route::post('/update/doctor/{id}', 'UpdateDoctor')->name('doctor.update');
        Route::post('/Add/doctor', 'AddDoctor')->name('AddDoctor');
    });
});

// Super admin + staff, gated per tab by users.permissions (super_admin always passes)
Route::prefix('admin')->middleware(['admin_or_staff'])->group(function () {
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/password/update', [AdminController::class, 'updatePassword'])->name('admin.password.update');
    Route::post('/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');

    Route::middleware('permission:patients')->controller(PatientController::class)->group(function () {
        Route::get('/patient/list', 'patientList')->name('list.patient');
        Route::get('/patient/form', 'createPatient')->name('patient.form');
        Route::post('/store/patient', 'store')->name('store.patient');
        Route::post('/patient/update/{id}', 'update')->name('patient.update');
        Route::get('/addnewReport/{id}', 'addnewReport')->name('addnewReport');
        Route::post('/createNewRecord/{id}', 'createNewRecord')->name('createNewRecord');
        Route::get('/patient/details/{id}', 'show')->name('patient.show');
        Route::get('/patient/export/{id}', 'exportPatientRecords')->name('patient.export');
        Route::get('/single/patient/{id}', 'edit')->name('patient.edit');
        Route::delete('/delete/patient/{id}', 'destroy')->name('patient.delete');
        Route::get('/patient/attachment/{id}', 'viewAttachment')->name('patient.attachment');
    });

    Route::controller(DoctorManageController::class)->group(function () {
        Route::middleware('permission:appointments')->group(function () {
            Route::get('/listappoinment', 'listappoinment')->name('listappoinment');
            Route::get('/appointment/export', 'exportAppointments')->name('appointment.export');
        });

        Route::middleware('permission:onsite_appointments')->group(function () {
            Route::get('/on_site_appointment', 'onSiteAppointments')->name('on_site_appointment');
            Route::get('/on-site-appointment', 'onSiteAppointments')->name('appointment.onsite');
        });

        // Actions shared by both appointment pages
        Route::middleware('permission:appointments,onsite_appointments')->group(function () {
            Route::post('/appoinmentstore', 'appoinmentstore')->name('admin.appoinmentstore');
            Route::post('/appointment/schedule/{id}', 'scheduleAppointment')->name('appointment.schedule');
            Route::post('/appointment/{id}/toggle-done', 'toggleDone')->name('appointment.toggleDone');
            Route::get('/appointment/get-available-slots', 'getAvailableSlots')->name('appointment.getAvailableSlots');
            Route::delete('/appointment/delete/{id}', 'deleteAppointment')->name('appointment.delete');
        });
    });

    Route::middleware('permission:reports')->controller(ReportController::class)->group(function () {
        Route::get('/obesity/report', 'obesityReport')->name('report.obesityReport');
        Route::get('/diabetes/report', 'diabetesReport')->name('report.diabetesReport');
        Route::get('/hypertensio/report', 'hypertensioReport')->name('report.hypertensioReport');
        Route::get('/Infection/report', 'InfectionReport')->name('report.InfectionReport');
    });

    Route::middleware('permission:rooms')->controller(RoomCreateController::class)->group(function () {
        Route::get('/edit/room/{id}', 'roomEdit')->name('room.edit');
        Route::get('/listing/room/data', 'roomListing')->name('room.list');
        Route::post('/create/room/data', 'roomStore')->name('room.store');
        Route::post('/update/room/{id}', 'roomUpdated')->name('room.update');
        Route::get('/delete/room/{id}', 'roomDelete')->name('room.delete');
        Route::get('/member/index/{id}/{index}', 'indexmember')->name('indexmember');
        Route::get('/delete/room-file/{id}/{index}', 'deleteRoomFile')->name('room.file.delete');
    });

    Route::middleware('permission:analytics')->controller(PatientController::class)->group(function () {
        Route::get('/analytics/disease', 'diseaseAnalytics')->name('analytics.disease');
        Route::get('/analytics/disease/export', 'exportDiseaseAnalytics')->name('analytics.disease.export');
    });
});
