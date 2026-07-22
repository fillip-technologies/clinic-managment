<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/clinics', function () {
    return view('clinics');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/services', function () {
    return view('services');
});

Route::get('/services/diabetes-care', function () {
    return view('diabetes-care');
});

Route::get('/services/hypertension-obesity', function () {
    return view('hypertension-obesity');
});

Route::get('/services/ultrasonology-investigations', function () {
    return view('ultrasonology-investigations');
});
