<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincias extends Model
{
    //
    protected $table='provincias';
    protected $primaryKey = 'id';
    public $incrementing=true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = ['descripcion'];
}
