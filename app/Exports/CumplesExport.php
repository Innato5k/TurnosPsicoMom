<?php
namespace App\Exports;
use App\Padron;
use App\Localidades;
use App\Provincias;
use App\User;
use DB; 


use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
//use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CumplesExport implements FromView,ShouldAutoSize 
{	public $mes;
	public function set_mes($vmes){
		$this->mes=$vmes;
	}
    public function view():View
    {   
        $data = DB::select( DB::raw('SELECT year(NOW()) AS anio') );
        $anio=$data[0]->anio;
        $meses=['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    	$registros=Padron::whereRaw('month(fecha_nacimiento)='.$this->mes)->
        orderBy('apellido','asc')->orderBy('nombre','asc')->
        select('apellido','nombre','fecha_nacimiento','telefono_celular','email')->get();
        return view('exports/cumples', compact('registros','anio'))->with(['mes'=>$meses[$this->mes-1]]);
    }
    
 }
?>