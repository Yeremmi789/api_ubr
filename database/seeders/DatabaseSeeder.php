<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'yeremmi',
        //     'email' => 'yeremmi@gmail.com',
        //     'password' => '123456789',
        //     'role_id'=> 1,
        // ]);

        // \App\Models\Rol::factory()->create([
        //     'name' => 'Admin',
        // ]);
        // \App\Models\Rol::factory()->create([
        //     'name' => 'User',
        // ]);


        DB::table('roles')->insert([
            'nombre' => 'Admin',
        ]);

        DB::table('roles')->insert([
            'nombre' => 'Users',
        ]);

        // DB::table('users')->insert([
        //     'name' => 'yeremmi',
        //     'email' => 'yeremmi@gmail.com',
        //     'password' => Hash::make('123456789'),
        //     'roles_id'=>1,
        // ]);

        DB::table('preguntas')->insert([
            'pregunta' => '¿Cuál fue el nombre de tu primera mascota?',
        ]);

        DB::table('preguntas')->insert([
            'pregunta' => '¿Cuál fue el nombre de tu escuela primaria?',
            
        ]);

        DB::table('preguntas')->insert([
            'pregunta' => '¿Cuál fue tu primer trabajo?',
            
        ]);

        DB::table('preguntas')->insert([
            'pregunta' => '¿Cuál es el nombre de tu amigo/a de la infancia?',
            
        ]);

        DB::table('preguntas')->insert([
            'pregunta' => '¿Cuál fue el nombre de tu primer amor?',
            
        ]);

        DB::table('preguntas')->insert([
            'pregunta' => '¿Cuál es el nombre de tu primer jefe?',
            
        ]);

        DB::table('preguntas')->insert([
            'pregunta' => '¿Cuál fue el modelo de tu primer coche?',
            
        ]);

        DB::table('preguntas')->insert([
            'pregunta' => '¿Cuál es el nombre de tu profesor favorito de la escuela secundaria?',
            
        ]);

        DB::table('tipos_terapias')->insert([
            'nombre' => 'Auditiva',
            'descripcion' => 'aaaaaaaa',
            
        ]);

        DB::table('tipos_terapias')->insert([
            'nombre' => 'Familiar',
            'descripcion' => 'bbbbbbbb',
            
        ]);

        DB::table('tipos_terapias')->insert([
            'nombre' => 'Fisica',
            'descripcion' => 'cccccccc',
            
        ]);

        DB::table('tipos_terapias')->insert([
            'nombre' => 'Lenguaje',
            'descripcion' => 'ddddddddd',
            
        ]);

        DB::table('tipos_terapias')->insert([
            'nombre' => 'Psicológica',
            'descripcion' => 'eeeeeeeee',
            
        ]);

        DB::table('users')->insert([
            'name' => 'admin',
            'apellido_paterno'=>'admin',
            'apellido_materno'=>'admin',
            'edad'=>40,
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456789'),
            'respuesta' => 'admin',
            'terapia_id' => 2,
            'roles_id'=>1,
            'pregunta_id'=>3,
        ]);

        DB::table('users')->insert([
            'name' => 'user',
            'apellido_paterno'=>'user',
            'apellido_materno'=>'user',
            'edad'=>40,
            'email' => 'user@gmail.com',
            'password' => Hash::make('123456789'),
            'respuesta' => 'user',
            'terapia_id' => 2,
            'roles_id'=>2,
            'pregunta_id'=>3,
        ]);

        // NOTA: Para poder hacer las migraciones aun cuando suceden errores, hay que hacer

        // php artisan migrate:fresh    //Para limpiar las tablas que tiene registros
        // php artisan migrate:rollback //Para retirar las migraciones (deshacer)
        // php artisan migrate --seed   //para registrar este archivo automatizamente a la BD

        // ULTIMA NOTA:
        // Para que funcione correctamente este archivo, es necesario poner al ùltimo aquellos usuario a quienees se les atribuirán las
        // demás tablas al usuario por medio de su ID

        
    }
}
