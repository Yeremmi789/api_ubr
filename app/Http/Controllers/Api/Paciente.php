<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pacientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;


class Paciente extends Controller
{
    //

    public function registrar(Request $request)
    {
        $request->validate([
            "nombre" => 'required',
            "apellido_paterno" => 'required',
            "apellido_materno" => 'required',
            "edad" => 'required|numeric|min:1|max:99',
            "telefono" => 'required|numeric|min:10',
            "direccion" => 'required',
        ]);

        $pacient = new Pacientes();
        $pacient->nombre = $request->nombre;
        $pacient->apellido_paterno = $request->apellido_paterno;
        $pacient->apellido_materno = $request->apellido_materno;
        $pacient->edad = $request->edad;
        $pacient->telefono = $request->telefono;
        $pacient->direccion = $request->direccion;
        $pacient->save();

        return response($pacient, Response::HTTP_CREATED);
    }

    public function mostrarTodo(Request $request)
    {

        // $user = Auth::user();
        // $x = $user->currentAccessToken()->token;
        $token = request()->user()->currentAccessToken()->token;

        // $request->bearerToken();
        // $user = Auth::user();

        $pacientes = Pacientes::all();

        // return response()->json([
        //     // "message"=> "userProfile OK",
        //     // "Pacientes"=>$pacientes,
        //     $pacientes,
        //     // "xd"=> $request,
        //     // "token "=>$token,
        // ], Response::HTTP_OK);

        return response()->json(
            // "message"=> "userProfile OK",
            // "Pacientes"=>$pacientes,
            $pacientes,
            // "xd"=> $request,
            // "token "=>$token,
        );
    }

    public function buscarPaciente($id)
    {
        $token = request()->user()->currentAccessToken()->token;
        $paciente = Pacientes::all()->where('id', $id)->first();

        return response()->json(
            $paciente
        );
    }

    public function eliminar($id)
    {
        $pacient = Pacientes::find($id);
        $pacient->delete();
        return redirect()->back()->with('success', 'paciente eliminado/eliminada');
    }
}
