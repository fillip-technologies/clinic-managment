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

Route::get('/services/neurology', function () {
    return view('neurology');
});

Route::get('/services/orthopedics', function () {
    return view('orthopedics');
});

Route::get('/services/general-surgery', function () {
    return view('general-surgery');
});
