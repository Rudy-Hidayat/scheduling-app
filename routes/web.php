<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/schedule-form', function () {
    return view('schedule-form');
})->name('schedule-form');

Route::get('/status', function () {
    return view('status');
})->name('status');

Route::get('/schedule-calendar', function () {
    return view('schedule-calendar');
})->name('schedule-calendar');

Route::get('/admin', function(){
    return view('admin');
})->name('admin');





