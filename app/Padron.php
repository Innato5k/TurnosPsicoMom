<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Padron extends Model
{
    //
    protected $table='padrons';
    protected $primaryKey = 'id';
    public $incrementing=true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = ['apellido','nombre','fecha_nacimiento','dni',
    'sexo','cuil','estado','genero','domicilio_calle','domicilio_numero','domicilio_piso','domicilio_departamento','localidad','domicilio_codigopostal','telefono_celular','email','cobertura','afiliado','plan','discapacidad','iva','observaciones','ds_1','hora_1','ds_2','hora_2','modalidad'];
}

