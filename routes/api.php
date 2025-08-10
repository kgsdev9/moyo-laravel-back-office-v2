<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Modereglement\ModereglementController;
use App\Http\Controllers\Solde\SoldeController;
use App\Http\Controllers\Transactions\TransactionController;
use App\Http\Controllers\CategorySchoolController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Cagnote\CagnoteController;
use App\Http\Controllers\Coffre\CoffreController;
use App\Http\Controllers\Commune\CommuneController;
use App\Http\Controllers\EcoleController;
use App\Http\Controllers\Scolarite\ScolariteController;
use App\Http\Controllers\Service\ServiceController;
use App\Http\Controllers\Specialite\SpecialiteController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\UpdateProfilCompteController;
use App\Http\Controllers\Ville\VilleController;

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
Route::post('/maj/profile', [AuthController::class, 'setSecret']);
Route::post('/user/update-password', [AuthController::class, 'updatePassword']);


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
    Route::post('/update-or-create-profil', [UpdateProfilCompteController::class, 'updateOrCreateProfil']);
    Route::post('/profile/verify-documents', [UpdateProfilCompteController::class, 'verifyDocuments']);
    Route::get('/coffre/solde/{user_id}', [CoffreController::class, 'getSoldeByUserId']);
    Route::post('/coffre/transaction', [CoffreController::class, 'creditOrDebit']);
    Route::post('/cagnotes/participer', [CagnoteController::class, 'participer']);
    Route::resource('cagnotes', CagnoteController::class);
    Route::apiResource('communes', CommuneController::class);
    Route::apiResource('villes', VilleController::class);
    Route::apiResource('services', ServiceController::class);
    Route::apiResource('specialites', SpecialiteController::class);
    Route::get('/coffres/{user_id}/solde', [CoffreController::class, 'getSoldeByUserId']);
    Route::post('/coffre/operation', [CoffreController::class, 'creditOrDebit']);


});


Route::get('/categories', [CategorySchoolController::class, 'index']);
Route::get('/ecoles', [EcoleController::class, 'index']);
Route::post('/payer-scolarite', [ScolariteController::class, 'payer']);
Route::post('/create-payment-intent', [StripeController::class, 'createPaymentIntent']);



Route::post('/auth/verify-password', [AuthController::class, 'verifyPassword']);
Route::post('/auth/update-pin', [AuthController::class, 'updatePin']);
