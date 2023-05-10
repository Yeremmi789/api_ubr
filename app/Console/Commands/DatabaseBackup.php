<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Spatie\DbDumper\Databases\MySql;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:database-backup';
    // protected $signature = 'backup:database';

    /**
     * The console command description.
     *
     * @var string
     */
    // protected $description = 'Command description';
    // protected $description = 'Restaurando la base de datos';


    protected $signature = 'backup:basededatos';
    protected $description = 'Create a backup of the database.';

    /**
     * Execute the console command.
     */
    // public function handle(): void
    public function handle()
    {

        // COMANDO PARA HACER UNA COPIA DE BASE DE DATOS, PORMEDIO DE la terminal Y ejecutando php artisan backup:nombredelComando

        // $backupPath = 'C:\Users\yerem\Desktop\mysqldump.sql';
        // //
        // File::put("dump.sql",'');
        // MySql::create()->setDbName(env('DB_DATABASE'))
        // ->setUserName(env('DB_USERNAME'))
        // ->setPassword(env('DB_PASSWORD'))
        // ->setHost(env('DB_HOST'))
        // ->setPort(env('DB_PORT'))
        // // ->dumpToFile(base_path('dump.sql'));
        // // ->dumpToFile('C:\Users\yerem\Desktop'('dump.sql'));
        // ->dumpToFile($backupPath);
        // $this->info('Guardado de Base de datos exitosamente :D');

// COMANDO PARA HACER UNA COPIA DE BASE DE DATOS, PORMEDIO DE la terminal Y ejecutando php artisan backup:nombredelComando




        // // $rutaGuardado='C:\Users\yerem\Desktop\respaldo_bd.sql';
        // $rutaGuardado = 'C:\Users\yerem\Documents';
        // $filename = '\backup_'.env('DB_DATABASE').'_'.date('Y').''.date('m').''.date('d').'_'.date('H').'_'.date('i').'_'.date('s').'.sql';
        // // try {
        //     // File::put("dump.sql", '');
        //     MySql::create()
        //         // ->setDumpBinaryPath(env('DUMP_BINARY_PATH'))
        //         ->setDbName(env('DB_DATABASE'))
        //         ->setUserName(env('DB_USERNAME'))
        //         ->setPassword(env('DB_PASSWORD'))
        //         ->setHost(env('DB_HOST'))
        //         ->setPort(env('DB_PORT'))
        //         ->dumpToFile($rutaGuardado);
        //         // ->dumpToFile($rutaGuardado.''.$filename);

        // // } catch (\Exception $e) {
        // //     return response()->json([
        // //         'mensaje' => 'Error al realizar el respaldo de la BD: ' . $e->getMessage(),
        // //     ], 500);
        // // }
    
        // // return response()->json([
        // //     'mensaje'=>'Respaldo de BD exitoso :D'
        // // ],200);
        // if (file_exists($rutaGuardado)) {
        //     return response()->json([
        //         'mensaje'=>'Respaldo de BD exitoso :D'
        //     ],200);
        // } else {
        //     return response()->json([
        //         'mensaje'=>'Hubo un error al crear el respaldo de BD :('
        //     ],500);
        // }


        // $rutaGuardado = 'C:\Users\yerem\Documents';
        $rutaGuardado = 'C:\Users\yerem\Documents\BackupUBR';
        
        // $ruta= $this->argument('rutaGuardado');
        
    $filename = 'backup_'.env('DB_DATABASE').'_'.date('Y-m-d_H-i-s').'.sql';
    $output = '';
    $command = sprintf(
        'mysqldump --user=%s --password=%s --host=%s --port=%s %s > %s',
        env('DB_USERNAME'),
        env('DB_PASSWORD'),
        env('DB_HOST'),
        env('DB_PORT'),
        env('DB_DATABASE'),
        $rutaGuardado . DIRECTORY_SEPARATOR . $filename,
        // $ruta . DIRECTORY_SEPARATOR . $filename
        // $filename

    );
    exec($command, $output, $return_var);
    
    

    // if ($return_var === 1) {
    //     return response()->json([
    //         // 'mensaje'=>'Respaldo de BD exitoso :D'
    //         $bandera =true,
    //     ],200);
    //     // return response()->json([
    //     //     'mensaje'=>'Algo salió mal :('
    //     // ]);
    // }
    // else{
        
    //     return response()->json([
    //         'mensaje'=>'Algo salió mal :('
    //     ],500);
    // }



    // if (file_exists($rutaGuardado . DIRECTORY_SEPARATOR . $filename)) {
    //     return response()->json([
    //         'mensaje'=>'Respaldo de BD exitoso :D'
    //     ],200);
    // } else {
    //     return response()->json([
    //         'mensaje'=>'Hubo un error al crear el respaldo de BD :('
    //     ],500);
    // }


        
    
        
    }


    


    
}
