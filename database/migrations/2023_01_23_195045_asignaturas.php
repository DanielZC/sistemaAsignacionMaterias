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
        Schema::create('asignaturas', function(Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profesor_id')->index()->nullable();
            $table->string('nombre')->unique();
            $table->text('descripcion');
            $table->string('creditos');
            $table->string('areaConocimiento');
            $table->enum('tipo', ['Electiva', 'Obligatoria']);
            $table->json('estudiantes')->nullable();
            $table->timestamp('creado');
            $table->timestamp('actualizado')->nullable();

            $table->foreign('profesor_id')->references('id')->on('profesores')
            ->onDelete('set null')->onUpdate('cascade');
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
