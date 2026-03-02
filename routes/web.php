<?php

use App\Http\Controllers\Central\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Central\DashboardController;
use App\Http\Controllers\Central\TenantController;
use App\Http\Middleware\EnsureCentralAuthenticated;
use App\Http\Middleware\EnsureCentralDomain;
use Illuminate\Support\Facades\Route;

Route::middleware(EnsureCentralDomain::class)->group(function () {
    Route::prefix('admin')->name('central.')->group(function () {
        Route::get('/', function () {
            return auth()->check()
                ? redirect()->route('central.dashboard')
                : redirect()->route('central.login');
        })->name('home');

        Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

        Route::middleware(EnsureCentralAuthenticated::class)->group(function () {
            Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::resource('tenants', TenantController::class)->names('tenants');
        });
    });
});
