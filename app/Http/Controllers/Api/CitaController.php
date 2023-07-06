<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Citas;
use App\Models\Pacientes;
use App\Models\User;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function addCita(Request $request){
        
        $request->validate([
            'asunto' => 'required',
            'apellidoPaterno' => 'required',
            'apellidoMaterno' => 'required',
            'fecha' => 'required',
            'hora' => 'required',
        ]);

        $titulo = $request->asunto;
        $desc = $request->descripcion;
        $nombre = $request->paciente;
        $apellidoP = $request->apellidoPaterno;
        $apellidoM = $request->apellidoMaterno;
        $fechas = $request->fecha;
        $horas = $request->hora;
        $terapeuta_id = $request->terapia_id;

        $pacienteID = Pacientes::select('id')
        ->where('nombre',$nombre)
        ->where('apellidoP',$apellidoP)
        ->where('apellidoM', $apellidoM)
        ->first();
        
        // return $pacienteID;
        $id = $pacienteID->id;


        if($pacienteID){
            $citas = new Citas();
            $citas->asunto = $titulo;
            $citas->descripcion = $desc;
            // $citas->paciente_id = $pacienteID;
            $citas->paciente_id = $id;
            $citas->fecha = $fechas;
            $citas->hora = $horas;
            $citas->terapeuta_id = $terapeuta_id;
            $citas->save();

            return response()->json([
                'Mensaje' => 'Cita registrada',
                $citas
            ]);
        }else{
            return response()->json('Paciente no encontrado');
        }
    }


    public function mostrarTerapeutas()
    {
        // $token = request()->user()->currentAccessToken()->token;
        $users = User::join('tipos_terapias', 'users.terapia_id', '=', 'tipos_terapias.id')
            ->select(
                'users.id',
                'users.name',
                'users.apellido_paterno',
                'users.apellido_materno',
                'users.edad',
                'tipos_terapias.nombre as terapia'
            )
            ->orderBy('users.name', 'asc')
            ->get();

        $terapeutas = [];

        foreach ($users as $user) {
            $nombreCompleto = ucfirst(strtolower($user->name)) . " " .
                ucfirst(strtolower($user->apellido_paterno)) . " " .
                ucfirst(strtolower($user->apellido_materno));

            $terapeuta = [
                'id' => $user->id,
                'nombre' => $nombreCompleto,
            ];

            $terapeutas[] = $terapeuta;
        }

        return response()->json($terapeutas);
    }
}
