<?php

namespace App\Http\Controllers\Scolarite;

use App\Http\Controllers\Controller;
use App\Services\ScolariteService;
use Illuminate\Http\Request;

class ScolariteController extends Controller
{
    protected $scolariteService;

    public function __construct(ScolariteService $scolariteService)
    {
        $this->scolariteService = $scolariteService;
    }

    public function payer(Request $request)
    {
        $request->validate([
            'user_id'   => 'required|exists:users,id',
            'montant'   => 'required|numeric|min:1',
            'school_id' => 'required|exists:ecoles,id',
        ]);

        $result = $this->scolariteService->payerScolarite($request->only('user_id', 'montant', 'school_id'));

        return response()->json($result, $result['code']);
    }
}
