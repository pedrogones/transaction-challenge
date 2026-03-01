<?php

use App\Http\Controllers\Admin\ArchiveController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Api\TransactionController as ApiTransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('archives', ArchiveController::class)->only(['index']);
    Route::get('ajax-show-transaction', [TransactionController::class, 'show'])->name('ajax-show-transaction');
});
//Route::prefix('api')
//    ->middleware(['web', 'auth'])
//    ->group(function () {
//        Route::apiResource('transactions', ApiTransactionController::class);
//    });
require __DIR__.'/auth.php';
