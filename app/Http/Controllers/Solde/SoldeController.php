<?php

namespace App\Http\Controllers\Solde;

use App\Http\Controllers\Controller;
use App\Services\SoldeService;
use Illuminate\Http\Request;

class SoldeController extends Controller
{
    protected $soldeService;

    public function __construct(SoldeService $soldeService)
    {
        $this->soldeService = $soldeService;
    }

    public function getSolde(Request $request)
    {
        $id = $request->query('id');

        $result = $this->soldeService->getSoldeByUserId($id);

        if (!$result) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        return response()->json($result);
    }
}
