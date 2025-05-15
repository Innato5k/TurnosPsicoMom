<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePadronsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('padrons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('apellido',100);
            $table->string('nombre',100);
            $table->integer('dni')->nullable();
            $table->string('sexo',1)->nullable();
            $table->string('genero',1)->nullable();
            $table->string('cuil',11)->nullable();
            $table->string('estado',1)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('domicilio_calle',60)->nullable();
            $table->integer('domicilio_numero')->nullable();
            $table->string('domicilio_piso',10)->nullable();
            $table->string('domicilio_departamento',10)->nullable();
            $table->integer('localidad')->nullable();
            $table->string('domicilio_codigopostal',15)->nullable();
            $table->string('telefono_celular',50)->nullable();
            $table->string('email',100)->nullable();
            $table->integer('cobertura')->nullable();
            $table->string('plan',30)->nullable();
            $table->string('afiliado',30)->nullable();
            $table->integer('discapacidad')->default(0);
            $table->string('iva',1)->nullable();
            $table->string('ds_1',10)->nullable();
            $table->time('hora_1')->nullable();
            $table->string('ds_2',10)->nullable();
            $table->time('hora_2')->nullable();
            $table->integer('copago_2')->default(0);
            $table->integer('modalidad')->nullable();
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
        Schema::dropIfExists('padrons');
    }
}
