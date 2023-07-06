<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pacientes;
use App\Policies\Permisos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;



class Paciente extends Controller
{
    //

    // public function registrar(Request $request)
    // {
    //     $request->validate([
    //         "nombre" => 'required',
    //         "apellido_paterno" => 'required',
    //         "apellido_materno" => 'required',
    //         "edad" => 'required|numeric|min:1|max:99',
    //         "telefono" => 'required|numeric|min:10',
    //         "direccion" => 'required',
    //     ]);

    //     $pacient = new Pacientes();
    //     $pacient->nombre = $request->nombre;
    //     $pacient->apellido_paterno = $request->apellido_paterno;
    //     $pacient->apellido_materno = $request->apellido_materno;
    //     $pacient->edad = $request->edad;
    //     $pacient->telefono = $request->telefono;
    //     $pacient->direccion = $request->direccion;
    //     $pacient->save();

    //     return response($pacient, Response::HTTP_CREATED);
    // }    

    public function registrar(Request $request)
    {

        $paciente = new pacientes;
        $paciente->edad = $request->edad;
        $paciente->nombre = $request->nombre;
        $paciente->apellidoP = $request->apellidoP;
        $paciente->apellidoM = $request->apellidoM;
        $paciente->expediente = $request->expediente;
        $paciente->tipoABC = $request->tipoABC;
        $paciente->sexo = $request->sexo;
        $paciente->direccion = $request->direccion;
        $paciente->patologia = $request->patologia;
        $paciente->save();
        $data = [
            'message' => 'paciente registrado satisfactoriamente',
            'paciente' => $paciente
        ];
        return response()->json($data);
    }

    public function mostrarTodo(Request $request)
    {
        $token = request()->user()->currentAccessToken()->token;
        $pacientes = Pacientes::all();
        return response()->json(
            $pacientes,
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

    public function vPaciente(Request $request)
    {
        $consulta = $request->input('consulta');
        $pacientes = Pacientes::where('nombre', 'like', '%' . $consulta . '%')
            ->orWhere('apellidoP', 'like', '%' . $consulta . '%')
            ->orWhere('apellidoM', 'like', '%' . $consulta . '%')
            ->select('nombre', 'apellidoP', 'apellidoM')
            ->get();

        return response()->json($pacientes);
    }

}
