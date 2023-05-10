<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Spatie\DbDumper\Databases\MySql;

use App\Console\Commands\DatabaseBackup;

class BackupController extends Controller
{
    // Esta funcion se puede hacer desde aquí, pero la quise llamar desde el otro archivo  de DataBaseBackup.php
    // Simplemente parr utilizar la funcino "Artisan::" y poder implementar  "Artisan::call('backup:basededatos');"
    // e implementar el llamado del comando  php artisan backup:nombreDelaFuncion
    public function crearRespaldoManual(Request $request){
        // $rutaGuardado='C:\Users\yerem\Desktop\respaldo_bd.sql';
        // $filename = '\backup_'.env('DB_DATABASE').'_'.date('Y').''.date('m').''.date('d').'_'.date('H').'_'.date('i').'_'.date('s').'.sql';
        // try {
        //     // File::put("dump.sql", '');
        //     MySql::create()
        //         ->setDbName(env('DB_DATABASE'))
        //         ->setUserName(env('DB_USERNAME'))
        //         ->setPassword(env('DB_PASSWORD'))
        //         ->setHost(env('DB_HOST'))
        //         ->setPort(env('DB_PORT'))
        //         // ->dumpToFile($rutaGuardado);
        //         ->dumpToFile($rutaGuardado.''.$filename);

        // } catch (\Exception $e) {
        //     return response()->json([
        //         'mensaje' => 'Error al realizar el respaldo de la BD: ' . $e->getMessage(),
        //     ], 500);
        // }

        // return response()->json([
        //     'mensaje'=>'Respaldo de BD exitoso :D'
        // ],200);


        // Artisan::call('backup:basededatos');
        // return response()->json(
        //     "Base de datos guardada con exito :D"
        // );

        //                  FUNCIONA, Version1//                  FUNCIONA, Version1//                  FUNCIONA, Version1//                  FUNCIONA, Version1

        // if(Artisan::call('backup:basededatos')){
        //     return response()->json(
        //         "Base de datos guardada con exito :D",
        //     );
        // }
        //                  FUNCIONA, Version1//                  FUNCIONA, Version1//                  FUNCIONA, Version1//                  FUNCIONA, Version1

        // Este comando es para verificar que el usuario actual tiene un token, además de que se verifica antes si cuenta con uno atravez 
        // del sanctum. :D
        $token = request()->user()->currentAccessToken()->token;
        $bandera = false;
        $output = '';
        Artisan::call('backup:basededatos', [], $output);
        if (strpos($output, 'successfully') === false) {
            return response()->json([
                'mensaje'=>"Base de datos guardada con exito :D",
                'ok'=> !$bandera,
            ]);

            

        } else {
            return response()->json([
                // "Hubo un error al guardar la base de datos"
                'mensaje'=>"Hubo un error al guardar la base de datos",
                'ok'=> $bandera,
            ]);
        }

    }



    public function respaldo(Request $request){
        $token = request()->user()->currentAccessToken()->token;
        $bandera = false;
        $output = '';
        $rutaGuardado = $request->input('rutaGuardado');
        // $rutaGuardado = request()->query('rutaGuardado');
        Artisan::call('backup:basededatos', [ 'rutaGuardado' => $rutaGuardado], $output);
        if (strpos($output, 'successfully') === false) {
            return response()->json([
                'mensaje'=>"Base de datos guardada con exito :D",
                'ok'=> !$bandera,
            ]);
        } else {
            return response()->json([
                'mensaje'=>"Hubo un error al guardar la base de datos",
                'ok'=> $bandera,
            ]);
        }
    }

    public function respaldoFecha(){

    }
}
