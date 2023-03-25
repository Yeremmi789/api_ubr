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
        // validacion
        $request->validate([
            "name"=>'required|min:3',
            "email"=> 'required|email|unique:users',
            "password"=> 'required|min:8|confirmed',
            // "roles_id"=>'required',
        ]);
        // alta de los datos
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        // $user->roles_id =$request->roles_id;
        $user->roles_id =2;
        $user->save();

        // respuesta

        // return response()->json([
        //     "message"=> "metodo GET"
        // ]);
        return response($user, Response::HTTP_CREATED);

    }
    public function login(Request $request){
      $bandera = false;

        $credenciales = $request->validate([
            // 'email'=>['required', 'email'],
            'name'=>['required'],
            'password'=>['required'],
        ]);

        // $correo_buscar = $request->email;
        $nombre_buscar = $request->name;

        if(Auth::attempt($credenciales)){

            // $users = User::all()->where('email', $correo_buscar)->first();
            $users = User::all()->where('name', $nombre_buscar)->first();

            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;

            // $resultadoToken = $token->token;
            // if (request('remember_me')) {
            //   $resultadoToken->expires_at = Carbon::now()->addWeeks(1);
            // }
            // $cookie = cookie('cookie_token',$token, 60*24);
            // $resultadoToken->save();
            return response(["token"=>$token,
            "mssg" => "credenciales correctas",
            "ok" => !$bandera,

            "id"=>$users->id,
            "name"=>$users->name,
            "email"=>$users->email

          // ], Response::HTTP_OK)->withoutCookie(($cookie));
        ], 200);
        }else{
            // // return response(["message"=> "credenciales incorrectas"], Response::HTTP_UNAUTHORIZED);
            // // return response(["mssg"=> "false"], Response::HTTP_UNAUTHORIZED);
            // return response(["mssg"=> "credenciales incorrectas",
            // "ok" => $bandera
            // ], Response::HTTP_UNAUTHORIZED);
            return response()->json([
              "mssg"=> "credenciales incorrectas",
              "ok" => $bandera
            ],401);
        }

        // return response()->json([
        //     "message"=> "metodo login OK"
        // ]);
    }

    public function userProfile(){
        return response()->json([
            "message"=> "userProfile OK",
            "userData" => auth()->user()
        ], Response::HTTP_OK);
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
    //
    // public function refreshToken(){
    //   return $this->respondWithToken(auth()->refresh());
    // }
    //
    // // public function logout(Request $request){
    // //     $cookie = Cookie::forget('cookie_token');
    // //     return response(["message"=> "Cierre de sesion OK"], Response::HTTP_OK)->withCookie(($cookie));
    // // }
    //
    // public function logout() {
    //     $cookie = Cookie::forget('cookie_token');
    //     return response(["message"=>"Cierre de sesión OK"], Response::HTTP_OK)->withCookie($cookie);
    // }
    //
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
      // $personal = User::findOrFail($id);
      // return response()->json($personal);
      // $user = User::findOrFail($id);
    
      // $users = User::all()->where('id',$id)->get();
      // $users = User::all()->where('id', $id);
      $users = User::all()->where('id', $id)->first();
      // $users = DB::table('users')->all()->where('id', $id);
      // $users = User::all();
    
      // $usuarios = json_decode($users);
    
      // return response()->json([
      //   "respuesta"=> true,
      //   // "Usuario"=> $id
      //   // "Usuario"=> $users
      //   "Usuario"=> $usuarios
      // ]);
    
      return response()->json($users);
      // return response()->json_encode($usuarios);
       // return json_encode($users);
    
    }


}
