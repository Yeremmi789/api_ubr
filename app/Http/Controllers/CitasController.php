<?php

namespace App\Http\Controllers;

use App\Models\Citas;
use Illuminate\Http\Request;

class CitasController extends Controller
{

    public function registrar(Request $request){

        $citas = new Citas();
        $citas->paciente_id = $request->paciente_id; 
        $citas->asunto = $request->asunto; 
        $citas->descripcion = $request->descripcion; 
        $citas->fecha = $request->fecha; 
        $citas->terapeuta_id = $request->teapeuta; 
        $citas->save();
        $data=[
            'message' => 'cita registrada satisfactoriamente',
            'paciente'=>$citas
        ];
        return response()->json($data);
    }
    public function index()
    {
        $citas = citas::all();
        return response()->json($citas);
    }
    public function store(Request $request)
    {
        $citas = new citas;
        
        $citas->id_paciente = $request->id_paciente; 
        $citas->fecha = $request->fecha; 
        $citas->teapeuta = $request->teapeuta; 
        $citas->save();
        $data=[
            'message' => 'cita registrada satisfactoriamente',
            'paciente'=>$citas
        ];
        return response()->json($data);
    }

    public function show(citas $citas)
    {
        return response()->json($citas);
        
    }
    public function update(Request $request, citas $citas)
    {
        $citas->id_paciente = $request->id_paciente; 
        $citas->Fecha = $request->fecha; 
        $citas->Terapeuta = $request->terapeuta; 
        $citas->save();
        $data=[
            'message' => 'cita actualizada satisfactoriamente',
            'paciente'=>$citas
        ];
        return response()->json($data);
    }

    
    public function destroy(citas $citas)
    {
        $citas->delete();
        $data=[
            'message' => 'cita eliminado satisfactoriamente',
            'cliente' => $citas
        ];
        return response()->json($data);
    }
}
