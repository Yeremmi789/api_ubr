<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            // 'email' => 'required|string|max:255',
            'password' => 'required|string|max:8'
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password']
        ]);

        // $user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => $request->password
        // ]);

        // $token = $user->createToken('auth_token')->plainTextToken;
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            // 'access_token' => $token,
            'access_token' => $token->accessToken,
            'token_type' => 'Bearer',

        ]);
    }


    public function users(Request $request)
    {

        if ($request->has('active')) {
            $users = User::where('active', true)->get();
        } else {
            $users = User::all();
        }


        return response()->json($users);
    }



    // public function login(Request $request){

    //     $response = ["status"=>0,"msg"=>""];

    //     $data = json_decode($request->getContent());

    //     $user = User::where('email',$data->email)->first();

    //     if($user){

    //         if(Hash::check($data->password,$user->password)){

    //             $token = $user->createToken("example");

    //             $response["status"] = 1;
    //             $response["msg"] = $token->plainTextToken;

    //         }else{
    //             $response["msg"] = "Credenciales incorrectas.";
    //         }

    //     }else{
    //         $response["msg"] = "Usuario no encontrado.";
    //     }

    //     return response()->json($response);        
    // }



    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ]);
    }

    public function signUp(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }
}
