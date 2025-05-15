<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Procesos extends Model
{
    protected $table='procesos';
    protected $primaryKey = 'id';
    public $incrementing=true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = ['descripcion','ruta','ultima_ejecucion'];
}
