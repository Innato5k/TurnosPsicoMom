<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNuevosPacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nuevos_pacientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('apellido',100);
            $table->string('nombre',100);
            $table->string('telefono_celular',50)->nullable();
            $table->string('email',100)->nullable();
            $table->integer('cobertura')->nullable();
            $table->string('observaciones',100)->nullable();
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
        Schema::dropIfExists('nuevos_pacientes');
    }
}
