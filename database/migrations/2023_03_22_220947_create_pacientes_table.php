<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pacientes', function (Blueprint $table) {
            // $table->id();
            // $table->string('nombre');
            // $table->string('apellido_paterno');
            // $table->string('apellido_materno');
            // // $table->date('f_nacimiento');
            // $table->integer('edad');
            // // $table->string('genero');
            // $table->integer('telefono');
            // // $table->string('direccion'); poner una relacion con otra tabla que indique el domicilio
            // // colonia, localidad, nombre_calle, CPostal
            // // $table->string('representante'); hacer una relacion con una tabla de representantes
            // $table->string('direccion');
            // $table->timestamps();


            $table->id();
            $table->string('edad');
            $table->string('nombre');
            $table->string('apellidoP')->nullable();
            $table->string('apellidoM')->nullable();
            $table->string('expediente');
            $table->string('tipoABC');
            $table->string('sexo');
          //  $table->string('');//campo pendiente
          //  $table->string('');//campo pendiente
            $table->string('direccion');
            $table->string('patologia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
