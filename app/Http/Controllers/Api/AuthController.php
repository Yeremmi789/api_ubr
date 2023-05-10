<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
// use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    //
    public function registro(Request $request){

      $bandera = false;
        // validacion
        $request->validate([
            "name"=>'required|min:3',
            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'required|string|max:50',

            
            'edad' => 'required|numeric|min:18|max:65',
            "email"=> 'required|email|unique:users',
            "password"=> 'required|min:8|confirmed',



            'terapia_id' => 'required',
            // 'roles_id' => 'required', //El ROLL no se pide, debido a que obligatoriamente se ale asignará un dos como usuario normal
            // 'pregunta_id' => 'required'
        ]);
        // alta de los datos
        $user = new User();
        $user->name = $request->name;

        $user->apellido_paterno = $request->apellido_paterno;
        $user->apellido_materno = $request->apellido_materno;
        $user->edad = $request->edad;

        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->respuesta = $request->respuesta;
        // $user->roles_id =$request->roles_id;
        $user->roles_id =2;
        $user->terapia_id = $request->terapia_id;
        $user->pregunta_id = $request->pregunta;
        $user->save();

        // return response($user, Response::HTTP_CREATED);
        return response()->json([
          $user,
          "ok" => !$bandera,
        ], Response::HTTP_CREATED);

    }
    public function login(Request $request){
      $bandera = false;

        $credenciales = $request->validate([
            // 'email'=>['required', 'email'],
            'name'=>['required'],
            'password'=>['required'],
        ]);
        $nombre_buscar = $request->name;


        if(Auth::attempt($credenciales)){
            // $users = User::join('roles','users.roles_id', '=', 'roles.id')
            // ->where('users.name', $nombre_buscar)->first();
            $users = User::join('roles','users.roles_id', '=', 'roles.id')
            ->join('tipos_terapias','users.terapia_id', '=', 'tipos_terapias.id')
            ->select('users.*', 'roles.nombre', 'tipos_terapias.nombre as terapia')
            ->where('users.name', $nombre_buscar)->first();

            // return response()->json("hola");
            // $area = User::join('tipos_terapias','users.terapia_id', '=', 'tipos_terapias.id')
            // ->select('tipos_terapias.nombre as terapia')
            // ->where('users.name', $nombre_buscar)->first();

            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            return response(["token"=>$token,
            "mssg" => "credenciales correctas",
            "ok" => !$bandera,
            "id"=>$users->id,
            "name"=>$users->name,
            "email"=>$users->email,
            "role" =>$users->nombre,
            
            // "area" =>$area,
            // $area,
            "area" =>$users->terapia,
            
        ], 200);
        }else{
            return response()->json([
              "mssg"=> "credenciales incorrectas",
              "ok" => $bandera
            ],401);
        }

    }

    public function userProfile(){
        return response()->json([
            "message"=> "userProfile OK",
            "userData" => auth()->user()
        ], Response::HTTP_OK);
    }

    public function misRoles(){
      $misDatos = auth()->user();
      return response()->json($misDatos);
    }

    public function validarToken(Request $request){
      $userss = Auth::user();
      $token = $userss->currentAccessToken()->token;

      $user = Auth::user();
      $x = $user->currentAccessToken()->token;
      $token = request()->user()->currentAccessToken()->token;
      
      $request->bearerToken();

        return response()->json([
            "message"=> "userProfile OK",
            "userData" => auth()->user(),
            // "xd" => auth()->user()->currentAccessToken()->plainTextToken,
            "xd"=> $request,
            "token "=>$token,
        ], Response::HTTP_OK);
    }

    // public function buscar(){
    //   $tok = Auth::personal_access_tokens();
    //   return response()->json([
    //       "message"=> "userProfile OK",
    //       "userData" => auth()->personal_access_tokens(),
    //       // "xd" => auth()->user()->currentAccessToken()->plainTextToken,
    //       "xd"=> $x,
    //   ], Response::HTTP_OK);
    // }
    // public function obt_token(){
    //   $user = Auth::user();
    //   $token = $user->tokens()->where('personal_access_tokens.name', 'token')->first();
    //   return response()->json([
    //     'xddddd'=> $token
    //   ],200);
    // }
    public function validarTokens(){
      return response()->json(auth()->user());
    }

    public function logout(Request $request) {
      $bandera = false;

        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message'=>'Usuario DesLogeado',
            "ok" => !$bandera,
        ], Response::HTTP_OK);
    }
    //
    public function allUsers() {
        $users = User::all();
        return response()->json([
        "users" => $users
        ]);
    }
    //
    //
    public function buscarUsuario($id){
      $users = User::all()->where('id', $id)->first();
      return response()->json($users);
    }


}
