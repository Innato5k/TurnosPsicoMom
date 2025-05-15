<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tablas extends Model
{
    protected $table='tablas';
    protected $primaryKey = 'id';
    public $incrementing=true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = ['tipo','descripcion','valor'];
}
