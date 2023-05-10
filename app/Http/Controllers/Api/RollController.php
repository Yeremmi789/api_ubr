<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pacientes;
use Illuminate\Http\Request;
use App\Models\Rol;
use App\Models\Roles;
use Symfony\Component\HttpFoundation\Response;

class RollController extends Controller
{
    //

    public function mostrarTodo(Request $request)
    {

        $token = request()->user()->currentAccessToken()->token;

        $roles = Roles::all();

            
        return response()->json(

            $roles

        );
    }
}
