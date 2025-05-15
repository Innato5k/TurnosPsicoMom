<?php

namespace App\Exports;

use App\Cancelaciones;
use App\Padron;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class CancelacionesExport implements FromView, ShouldAutoSize
{
    
    public $anio;
    public $mes;
   

    public function set_anio($vanio){
        $this->anio=$vanio;
    }

    public function set_mes($vmes){
        $this->mes=$vmes;
    }

   

    public function view():View
    {
        $turnos=Cancelaciones::leftJoin('tablas',function($join){
            $join->on('cancelaciones.motivo','tablas.valor')->where('tablas.tipo','MOT_CANC');
        })
            ->leftJoin('padrons','paciente','padrons.id')->whereraw('month(fecha)='.$this->mes.' and year(fecha)='.$this->anio.' and paciente>0')->orderby('fecha','asc')->orderby('hora','asc')->select('fecha','hora','paciente','apellido' ,'nombre','discapacidad','cancelaciones.cobertura','cancelaciones.modalidad','tablas.descripcion as dmotivo','reprogramado')->get();
                    
        $meses=['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        $mes=$meses[$this->mes-1];
        $anio=$this->anio;
        return view('exports/cancelaciones',compact('turnos'))->with(['mes'=>$mes,'anio'=>$anio]);
    }
}
