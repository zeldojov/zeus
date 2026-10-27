<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['web', 'auth', 'verified'])->group(function () {
    Route::get('/home', function () {
        return view('welcome');
    });
});
