<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Modereglement\ModereglementController;
use App\Http\Controllers\Solde\SoldeController;
use App\Http\Controllers\Transactions\TransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login-pin', [AuthController::class, 'loginWithPin']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'me']);
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Déconnexion réussie']);
    });

    Route::get('/transactions', [TransactionController::class, 'getByPhone']);
    Route::get('/solde', [SoldeController::class, 'getSolde']);
    Route::post('/transactions', [TransactionController::class, 'store']);
    Route::get('/modereglements', [ModereglementController::class, 'index']);
});
