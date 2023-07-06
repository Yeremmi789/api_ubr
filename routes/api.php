<?php

// use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BackupController;
use App\Http\Controllers\Api\CitaController;
use App\Http\Controllers\Api\NuevaContraseñaController;
use App\Http\Controllers\Api\Paciente;
use App\Http\Controllers\Api\PreguntaController;
use App\Http\Controllers\Api\RollController;
use App\Http\Controllers\Api\TerapiaController;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\CitasController;
use App\Http\Middleware\EnsureTokenIsValid;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('registro', [AuthController::class, 'registro']);
Route::post('login', [AuthController::class, 'login']);

// TERAPIAS


Route::group(['middleware' => 'auth:sanctum'], function(){
    //PERSONAL
    Route::get('misDatos', [AuthController::class, 'userProfile']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('users', [AuthController::class, 'allUsers']);
    Route::get('validarToken', [AuthController::class, 'validarTokens']);
    Route::get('buscar_trabajador/{id}', [AuthController::class, 'buscarUsuario']);
    Route::get('MisRoles', [AuthController::class, 'misRoles']);
    //PERSONAL
    // PACIENTES
    Route::get('Allpacientes', [Paciente::class, 'mostrarTodo']);
    // Route::post('registrarPaciente', [Paciente::class, 'registrar']);
    Route::get('buscarPaciente/{id}', [Paciente::class, 'buscarPaciente']);
    Route::post('borrarPaciente/{id}', [Paciente::class, 'eliminar']);
    // Route::get('editarPaciente', [Paciente::class, 'editar']); A este le falta tener mas tablas relacionadas como el representante, dirección etc etc
    // PACIENTES

    // ROLES
    Route::get('Allroles', [RollController::class, 'mostrarTodo']);
    // ROLES
    
    //RESPALDOS BASE DE DATOS
    Route::post('respaldoManual', [BackupController::class, 'crearRespaldoManual']);
    
    Route::post('respaldo', [BackupController::class, 'respaldo']);
    // Route::get('respaldo', [BackupController::class, 'respaldo']);
    //RESPALDOS BASE DE DATOSaw
    
    // USUARIOS
    
    Route::get('AllUsuarios', [UsuarioController::class, 'allUsers']);
    Route::get('editUsuario/{id}', [UsuarioController::class, 'buscarUsuario']);
    // Route::get('editUsuario/{id}', [UsuarioController::class, 'obtener']);
    // USUARIOS

    // CITAS
    
    // Route::get('allTerapeutas', [CitaController::class, 'mostrarTerapeutas']);
    // CITAS


    // Global
    // Route::get('verfiPaciente', [Paciente::class, 'verficarPaciente']);
    // Global
});
    // Route::get('verfiPaciente', [Paciente::class, 'verficarPaciente']);
    Route::post('verEnfermo', [Paciente::class, 'vPaciente']);
    Route::post('addCitas', [CitaController::class, 'addCita']);

Route::get('allTerapeutas', [CitaController::class, 'mostrarTerapeutas']);

Route::post('registrarPaciente', [Paciente::class, 'registrar']);

Route::get('allTerapias', [TerapiaController::class, 'mostrarTerapias']);


// Recuperar Contraseña
Route::get('preguntas', [PreguntaController::class, 'mostrar']);
Route::post('verificar', [PreguntaController::class, 'correo']); ///*
Route::post('verificarRespuesta', [PreguntaController::class, 'busPalabra']);///*
Route::post('pedir', [PreguntaController::class, 'Pedircorreo']);///*
Route::post('newContrasena', [PreguntaController::class, 'nuevaContrasena']);///*
// Recuperar Contraseña