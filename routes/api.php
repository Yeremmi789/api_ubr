<?php

// use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;

use App\Http\Middleware\EnsureTokenIsValid;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::apiResource(name: 'personal', controller: PersonalController::class);

// Route::post(uri:'/register', [AuthController::class, 'register']);
// Route::post(uri:'/register', controller:AuthController::class, function: 'register');


// Route::post('/register',[AuthController::class,'register']);

// Route::apiResource(name: 'registro', controller:AuthController::class);

// Route::get('/users',[AuthController::class,'users']);
// Route::post('/login',[AuthController::class,'login']);
// Route::post('/signUp',[AuthController::class,'signUp']);

Route::post('registro', [AuthController::class, 'registro']);

Route::post('login', [AuthController::class, 'login']);

// Route::group(['middleware' => ['auth:sanctum']], function () {
//     // Route::get('user-profile', [AuthController::class, 'userProfile']);
//     Route::get('user_profile', [AuthController::class, 'userProfile']);
//     Route::post('logout', [AuthController::class, 'logout']);
// });

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get('userprofile', [AuthController::class, 'userProfile']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('users', [AuthController::class, 'allUsers']);
    // Route::post('validarToken', [AuthController::class, 'validarToken']);
    // Route::get('buscar', [AuthController::class, 'buscar']);
    Route::get('validarToken', [AuthController::class, 'validarTokens']);
    //
    // Route::get('token', [AuthController::class, 'obt_token']);
});

// Route::get('users', [AuthController::class, 'allUsers']);

Route::get('buscar_trabajador/{id}', [AuthController::class, 'buscarUsuario']);
