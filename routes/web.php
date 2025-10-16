<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::prefix('admin')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.pages.dashboard');
    })->name('admin.pages.dashboard');
    Route::get('/rto', function () {
        return view('admin.pages.add_rto');
    })->name('admin.pages.add_rto');

    Route::get('/login', function () {
        return view('admin.auth.login');
    })->name('admin.login');

    Route::get('/students', function () {
        return view('admin.pages.students');
    })->name('admin.students');
    Route::get('/courses', function () {
        return view('admin.pages.courses');
    })->name('admin.courses');
        Route::get('/Industries', function () {
        return view('admin.pages.Industries');
    })->name('admin.Industries');
         Route::get('/Coordinator', function () {
        return view('admin.pages.Coordinator');
    })->name('admin.Coordinator');
});