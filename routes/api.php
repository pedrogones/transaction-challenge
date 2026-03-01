<?php
use App\Http\Controllers\Api\TransactionController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('transactions-api', TransactionController::class);
});

Route::post('/login', function (Request $request) {

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Credenciais inválidas'], 401);
    }

    return response()->json(['message' => 'Logado com sucesso!', 'toke', 'tokenn' => $user->createToken('postman')->plainTextToken], 200);
});
