<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fechas extends Model
{
    protected $table='fechas';
    protected $primaryKey = 'id';
    public $incrementing=true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = ['fecha','dia_semana','laborable','observaciones'];
}

