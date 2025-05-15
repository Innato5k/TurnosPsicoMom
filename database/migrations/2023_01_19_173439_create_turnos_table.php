<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTurnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turnos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('fecha');
            $table->time('hora');
            $table->integer('bloqueado')->nullable();
            $table->string('motivo_bloqueo',30)->nullable();
            $table->integer('paciente')->nullable();
            $table->integer('nuevo_paciente')->nullable();
            $table->integer('modalidad')->nullable();
            $table->integer('cobertura')->nullable();
            $table->integer('asistencia')->nullable();
            $table->integer('pago')->nullable();
            $table->integer('notificacion_1')->default(0);
            $table->integer('notificacion_2')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('turnos');
    }
}
