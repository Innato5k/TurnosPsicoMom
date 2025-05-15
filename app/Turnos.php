<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turnos extends Model
{
    protected $table='turnos';
    protected $primaryKey = 'id';
    public $incrementing=true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = ['fecha','hora','bloqueado','motivo_bloqueo','paciente','modalidad','cobertura','asistencia','pago','notificacion_1','notificacion_2'];

}
