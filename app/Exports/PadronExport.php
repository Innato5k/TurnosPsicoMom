<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use App\Padron;
use App\Localidades;
use App\Provincias;
use DB;

class PadronExport implements FromView, ShouldAutoSize
{
    
    public function view():View
    {

        $data = DB::select( DB::raw('SELECT NOW() AS hoy') );        
        $hoy=substr($data[0]->hoy,0,10);
    	$registros=Padron::leftjoin('localidades','padrons.localidad','=','localidades.id')
        ->leftjoin('provincias','localidades.provincia','=','provincias.id')
                ->orderBy('apellido','asc')
        ->orderBy('nombre','asc')
        ->select('padrons.*','localidades.descripcion as dlocalidad','provincias.descripcion as dprovincia')->get();
        return view('exports.padron',compact('registros','hoy'));
  		

    }
}
