<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudiantes', function(Blueprint $table) {
            $table->id();
            $table->string('documento')->unique();
            $table->string('nombre');
            $table->string('telefono');
            $table->string('email');
            $table->string('direccion');
            $table->string('ciudad');
            $table->string('semestre');
            $table->json('asignaturas');
            $table->timestamp('creado');
            $table->timestamp('actualizado')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
