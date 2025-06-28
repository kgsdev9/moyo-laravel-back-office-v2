<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\TransactionService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class TransactionController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function getByPhone(Request $request)
    {
        $phone = $request->query('phone');
        return $this->transactionService->getByPhone($phone);
    }

    public function store(Request $request)
    {
        try {
            $transaction = $this->transactionService->createTransaction($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Transaction enregistrée avec succès.',
                'data' => $transaction,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Transaction échouée : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show(int $id)
    {
        try {
            $transaction = $this->transactionService->getTransactionById($id);
            return response()->json([
                'success' => true,
                'data' => $transaction,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur serveur : ' . $e->getMessage(),
            ], 500);
        }
    }
}
