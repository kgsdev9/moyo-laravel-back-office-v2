<?php

namespace App\Http\Controllers\Modereglement;

use App\Http\Controllers\Controller;
use App\Models\ModeReglement;

class ModereglementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modereglements = ModeReglement::all();
        
        return response()->json($modereglements);
    }


}
