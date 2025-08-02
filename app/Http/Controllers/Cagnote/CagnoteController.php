<?php

namespace App\Http\Controllers\Cagnote;

use App\Http\Controllers\Controller;
use App\Services\CagnoteService;
use Illuminate\Http\Request;

class CagnoteController extends Controller
{
    protected $cagnoteService;

    public function __construct(CagnoteService $cagnoteService)
    {
        $this->cagnoteService = $cagnoteService;
    }

    public function index()
    {
        $cagnotes = $this->cagnoteService->getAll();

        return response()->json([
            'cagnotes' => $cagnotes,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'description' => 'nullable|string',
            'montant_objectif' => 'required|numeric|min:1',
            'date_limite' => 'nullable|date',
            'user_id' => 'required|exists:users,id',
        ]);

        $cagnote = $this->cagnoteService->create($request->all());

        return response()->json([
            'message' => 'Cagnotte créée avec succès.',
            'cagnotte' => $cagnote,
        ], 201);
    }

    public function show(int $id)
    {
        $cagnote = $this->cagnoteService->getById($id);

        if (!$cagnote) {
            return response()->json(['message' => 'Cagnotte introuvable'], 404);
        }

        return response()->json(['cagnote' => $cagnote]);
    }

    public function participer(Request $request)
    {
        $request->validate([
            'cagnotte_id' => 'required|exists:cagnotes,id',
            'user_id' => 'required|exists:users,id',
            'montant' => 'required|numeric|min:1',
        ]);

        $result = $this->cagnoteService->participer($request->only('cagnotte_id', 'user_id', 'montant'));

        return response()->json($result, $result['code']);
    }
}
