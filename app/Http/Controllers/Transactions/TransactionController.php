<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */




    public function getByPhone(Request $request)
    {
        $phone = $request->query('phone');

        $user  = User::where('phone', $phone)->first();

        if (!$phone) {
            return response()->json([
                'error' => 'Le numéro de téléphone est requis.'
            ], 400);
        }

        $transactions = Transaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($transactions);
    }


    public function post(Request $request)
    {
        $phone = $request->query('phone');

        $user  = User::where('phone', $phone)->first();

        if (!$phone) {
            return response()->json([
                'error' => 'Le numéro de téléphone est requis.'
            ], 400);
        }

        $transactions = Transaction::where('id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($transactions);
    }




}
