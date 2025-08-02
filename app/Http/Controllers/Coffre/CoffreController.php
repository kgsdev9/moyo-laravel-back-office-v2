<?php

namespace App\Http\Controllers\Coffre;

use App\Http\Controllers\Controller;
use App\Services\CoffreService;
use Illuminate\Http\Request;

class CoffreController extends Controller
{
    protected $coffreService;

    public function __construct(CoffreService $coffreService)
    {
        $this->coffreService = $coffreService;
    }

    public function getSoldeByUserId($user_id)
    {
        $result = $this->coffreService->getSoldeByUserId($user_id);

        if (!$result) {
            return response()->json(['message' => 'Coffre non trouvé'], 404);
        }

        return response()->json($result);
    }

    public function creditOrDebit(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'montant' => 'required|numeric|min:1',
            'type'    => 'required|in:credit,debit',
        ]);

        $result = $this->coffreService->creditOrDebit($request->only('user_id', 'montant', 'type'));

        return response()->json($result, $result['code']);
    }
}
