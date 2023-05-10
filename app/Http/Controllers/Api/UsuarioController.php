<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    //

    public function allUsers()
    {
        $users = User::join('roles','users.roles_id', '=', 'roles.id')
            ->join('tipos_terapias','users.terapia_id', '=', 'tipos_terapias.id')
            // ->select('users.*', 'roles.nombre', 'tipos_terapias.nombre as terapia')
            ->select('users.name', 'users.apellido_paterno', 'users.apellido_materno',
            'users.edad', 'roles.nombre as rol', 'tipos_terapias.nombre as terapia')
            ->get();
            // ->where('users.name', $nombre_buscar)->first();

        $token = request()->user()->currentAccessToken()->token;
        // $users = User::all();
        return response()->json($users);
    }
    
    //
    //
    public function buscarUsuario($id)
    {
        $users = User::all()->where('id', $id)->first();
        return response()->json($users);
    }
}
