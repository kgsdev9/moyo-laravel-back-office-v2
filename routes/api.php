<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Modereglement\ModereglementController;
use App\Http\Controllers\Solde\SoldeController;
use App\Http\Controllers\Transactions\TransactionController;
use App\Http\Controllers\API\CategorySchoolController;
use App\Http\Controllers\API\EcoleController;
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
Route::post('/login', [AuthController::class, 'login']);
Route::post('/send-code', [AuthController::class, 'sendCode']);
Route::post('/verify-code', [AuthController::class, 'verifyCode']);
Route::middleware('auth:sanctum')->post('/maj/profile', [AuthController::class, 'setSecret']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'me']);
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Déconnexion réussie']);
    });
    Route::post('/transactions', [TransactionController::class, 'store']);
    Route::get('/transactions', [TransactionController::class, 'getByPhone']);
    Route::get('/user/transactions/{id}', [TransactionController::class, 'getTransactionByUser']);
    Route::get('/transactions/{id}', [TransactionController::class, 'show']);
    Route::get('/solde', [SoldeController::class, 'getSolde']);
    Route::post('/transactions', [TransactionController::class, 'store']);
    Route::get('/modereglements', [ModereglementController::class, 'index']);
});



Route::get('/categories', [CategorySchoolController::class, 'index']);
Route::get('/ecoles', [EcoleController::class, 'index']);
