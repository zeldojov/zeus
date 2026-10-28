<?php

use App\Http\Controllers\UserSessionController;
use App\Http\Controllers\UserSettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware(['auth', 'verified'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/home', function () {
            return view('home');
        })->name('home');

        Route::get('/settings', UserSettingsController::class)->name('settings');
        Route::delete('/sessions', [UserSessionController::class, 'destroy'])->name('sessions.destroy');
        Route::delete('/sessions/others', [UserSessionController::class, 'destroyOthers'])->name('sessions.destroy-others');
    });
