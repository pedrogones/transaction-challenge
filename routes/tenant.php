<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\ArchiveController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Api\TransactionController as ApiTransactionController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        return auth()->check()
            ? redirect()->route('transactions.index')
            : redirect()->route('login');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::resource('dashboard', DashboardController::class)->only(['index']);
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        Route::resource('transactions', TransactionController::class);
        Route::get('ajax-show-transaction', [TransactionController::class, 'show'])->name('ajax-show-transaction');
        Route::resource('archives', ArchiveController::class)->only(['index']);
    });

    require __DIR__ . '/auth.php';
});

Route::prefix('api')->middleware([
    'api',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::post('/login', function (Request $request) {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Credenciais invalidas'], 401);
        }

        return response()->json([
            'message' => 'Logado com sucesso!',
            'token' => $user->createToken('postman')->plainTextToken,
        ], 200);
    });

    Route::get('/auth/check', function (Request $request) {
        $user = $request->user('sanctum');

        return response()->json([
            'authenticated' => (bool) $user,
            'user' => $user ? [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ] : null,
        ]);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('transactions-api', ApiTransactionController::class);
    });
});
