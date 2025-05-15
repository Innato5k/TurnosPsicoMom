<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Localidades extends Model
{
    //
    protected $table='localidades';
    protected $primaryKey = 'id';
    public $incrementing=true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = ['descripcion','provincia','codigo_postal'];
}

