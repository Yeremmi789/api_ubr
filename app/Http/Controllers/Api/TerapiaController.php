<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Terapias;
use App\Models\Tipos_terapias;
use Illuminate\Http\Request;

class TerapiaController extends Controller
{
    public function mostrarTerapias(Request $request)
    {
        
        $terapias = Tipos_terapias::all();
        return response()->json(
            $terapias
        );
    }
}
