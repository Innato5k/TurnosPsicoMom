<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cancelaciones extends Model
{
    protected $table='cancelaciones';
    protected $primaryKey = 'id';
    public $incrementing=true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = ['fecha','hora','paciente','modalidad','cobertura','motivo','reprogramado'];
}
