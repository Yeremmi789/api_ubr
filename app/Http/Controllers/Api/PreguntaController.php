<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Preguntas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cookie;
class PreguntaController extends Controller
{
    //

    public function mostrar()
    {
        $preguntas = Preguntas::all();
        return response()->json(
            $preguntas
        );
    }

    // Si quiero aplicar lo que pensé en la anterior, necesito hacer esto en el ANGULAR, para poder comparar la respuesta
    // o talvez no?

    public function correo(Request $request){
        $solicitud = $request->email;
        $correo = User::select('id','email')->where('email', $solicitud)->first();
        $bandera = false;

        if ($correo) {
           return response() ->json([
            "Msg" => "Encontrado",
            "ok" => !$bandera,
            "id" => $correo->id,
            "correo" => $correo->email,
           ],200);
        }else{
            return response()->json([
                "Msg" => "No encontrado",
                "ok" => $bandera,
            ],500);
        }
    }

    public function busPalabra(Request $request){
        $solicitud = $request->respuesta;
        $resp = User::select('id','respuesta')->where('respuesta', $solicitud)->first();
        $bandera = false;

        if ($resp) {
           return response() ->json([
            "Mensage" => "Encontrado",
            "okay" => !$bandera,
            "numerador" => $resp->id,
            // "respuesta" => $resp->respuesta,
           ],200);
        }else{
            return response()->json([
                "Mensage" => "No encontrado",
                "okay" => $bandera,
            ],500);
        }
    }



// Esta funcion "PedirCorreo" lo tendrá Angular (mostrará solamente la pregunta y la respuesta estará almacenada pero no se mostrará)
// Entonces, la respuesta solamente para comparar si la respuesta es la misma.
    public function Pedircorreo(Request $request)
    {
        $solicitud = $request->email;
        $correo = User::select('email')->where('email', $solicitud)->first();
        $bandera = false;
        if ($correo) {
            $SeleccionarCorreo = $correo->email;
            $resultado = User::join('preguntas', 'users.pregunta_id', '=', 'preguntas.id')
                ->select('preguntas.pregunta', 'users.respuesta', 'users.id')
                // ->select('users.respuesta','preguntas.pregunta')
                ->where('email', $SeleccionarCorreo)
                ->first();
// ----------------------------------------------------------------
//LAS TRES RESPUESTAS ESTÁN CORRECTAS- solamente que aquí se obtiene el "nombreCampo" : "datoDelCampo"
            // return response()->json(
            //     $resultado, //Esta consulta ya trae los dos datos que pongo en el select

            // );
// ----------------------------------------------------------------
            return response()->json([
                "pregunta" => $resultado->pregunta, //a diferencia de la de arriba y la de abajo, a esta le puedo poner el
                "respuesta" => $resultado->respuesta, //mensaje que quiero que se muestre como el "ok" y poder hacer mas facil el metodo post
                "id" => $resultado->id, //mensaje que quiero que se muestre como el "ok" y poder hacer mas facil el metodo post
                "ok" => !$bandera,
                "Msg" => "Encontrado",
            ]);
// ----------------------------------------------------------------
            // AMBAS RESPUESTAS ESTÁN CORRECTAS- solamente que aquí se obtiene directamente el dato que estoy pidiendo, sin necesidad de
            // mostrarme el nombre del campo que contiene esos datos.
            // return response()->json([
            //     $resultado->pregunta,
            //     $resultado->respuesta
            // ]);
        } else {
            return response([
                "Msg" => 'Correo no encontrado',
                "no" => $bandera,
            ], 500);
        }
    }

    public function nuevaContrasena(Request $request){

        $solicitud = $request->password;
        // $correo = $request->email;
        $bandera = true;
        $id = $request->id;
        // $correo = $request->input('email');
        $correo = $request->email;
        // $usuario = User::find($id);
        // return response()->json($solicitud);
        $usuario = User::where('email', $correo)->first();
        // return response()->json($usuario);

        // $usuario->password = $solicitud;
        $usuario->password = Hash::make($solicitud);
        // $usuario->save();
        //
        // $usuario = User::find($correo);

        if(!$usuario){
            return response()->json([
                "men" => "Ocurrio un erro en la operación",
            ]);
        }else{
            // $usuario->password
            $usuario->save();
            return response()->json([
                "men" => "Se actualizó la Contraseña",
            ]);
        }
    }


    // public function cambiarPassword(){

    // }

    // public function Pedircorreo(Request $request)
    // {
    //     // $correo = User::select('email')->where('email',$request)->first();
    //     // $solicitud = $request->email; //solicitar el dato que está en el input de correo (email) del formulario
    //     $solicitud = $request->email;
    //     // $solicitud = $request;
    //     $correo = User::select('email')->where('email', $solicitud)->first();
    //     $bandera = false;

    //     // $correo = User::all()->where('email', $solicitud)->first();

    //     // return response()->json($solicitud);
    //     // return response()->json($correo);

    //     if ($correo) {
    //         // $pregunta = User::select('pregunta_id');
    //         // $pregunta = User::join('preguntas', 'users.pregunta_id', '=', 'preguntas.id')
    //         //     ->select('preguntas.pregunta')
    //         //     ->where('email', $correo->email)
    //         //     ->first();
    //         // return response()->json([
    //         //     "Msg" => "Correo encontrado",
    //         //     // "pregunta" => $pregunta,
    //         //     $pregunta,
    //         //     "ok" => !$bandera,
    //         // ], 200);

    //         $SeleccionarCorreo = $correo->email;
    //         $pregunta = User::join('preguntas', 'users.pregunta_id', '=', 'preguntas.id')
    //             ->select('preguntas.pregunta')
    //             ->where('email', $SeleccionarCorreo)
    //             ->first();
    //         return response()->json(
    //             // "Msg" => "Correo encontrado",
    //             // "pregunta" => $pregunta,
    //             $pregunta,

    //         );
    //     } else {
    //         return response([
    //             "Msg" => 'Correo no encontrado',
    //             "ok" => $bandera,
    //         ], 500);
    //     }

    //     // $pregunta = User::join('preguntas', 'users.pregunta_id', '=', 'preguntas.id')
    //     //         ->select('preguntas.pregunta')
    //     //         ->where('email', $correo)
    //     //         ->first();
    //     //         return response()->json([
    //     //             "Msg" => "Correo encontrado",
    //     //             "pregunta" => $pregunta,
    //     //             "ok" => !$bandera,
    //     //         ], 200);


    // }



}
