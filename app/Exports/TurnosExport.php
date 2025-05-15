<?php

namespace App\Exports;

use App\Turnos;
use App\Padron;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class TurnosExport implements FromView, ShouldAutoSize
{
    
    public $anio;
    public $mes;
    public $tipo;

    public function set_anio($vanio){
        $this->anio=$vanio;
    }

    public function set_mes($vmes){
        $this->mes=$vmes;
    }

    public function set_tipo($vtipo){
        $this->tipo=$vtipo;
    }


    public function view():View
    {
        if($this->tipo=="General"){
            $turnos=Turnos::leftJoin('padrons','paciente','padrons.id')->whereraw('month(fecha)='.$this->mes.' and year(fecha)='.$this->anio.' and paciente>0')->orderby('fecha','asc')->orderby('hora','asc')->select('fecha','hora','paciente','afiliado','plan','discapacidad','padrons.apellido','padrons.nombre','turnos.cobertura','turnos.modalidad','asistencia','pago')->get();
        };
        if($this->tipo=="CMMatanza - No Discapacidad"){
            $turnos=Turnos::leftJoin('padrons','paciente','padrons.id')->whereraw('month(fecha)='.$this->mes.' and year(fecha)='.$this->anio.' and paciente>0 and turnos.cobertura=2 and asistencia=1 and discapacidad=0')->orderby('fecha','asc')->orderby('hora','asc')->select('fecha','hora','paciente','afiliado','plan','discapacidad','padrons.apellido','padrons.nombre','turnos.cobertura','turnos.modalidad','asistencia','pago')->get();
        };
        
        if($this->tipo=="CMMatanza - Discapacidad"){
            $turnos=Turnos::leftJoin('padrons','paciente','padrons.id')->whereraw('month(fecha)='.$this->mes.' and year(fecha)='.$this->anio.' and paciente>0 and turnos.cobertura=2 and asistencia=1 and discapacidad=1')->orderby('fecha','asc')->orderby('hora','asc')->select('fecha','hora','paciente','afiliado','plan','discapacidad','padrons.apellido','padrons.nombre','turnos.cobertura','turnos.modalidad','asistencia','pago')->get();
        };
        if($this->tipo=="Particular"){
            $turnos=Turnos::leftJoin('padrons','paciente','padrons.id')->whereraw('month(fecha)='.$this->mes.' and year(fecha)='.$this->anio.' and paciente>0 and turnos.cobertura=1 and asistencia=1')->orderby('fecha','asc')->orderby('hora','asc')->select('fecha','hora','paciente','afiliado','plan','discapacidad','padrons.apellido','padrons.nombre','turnos.cobertura','turnos.modalidad','asistencia','pago')->get();
        };
            
        $meses=['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        $mes=$meses[$this->mes-1];
        $anio=$this->anio;
        $tipo=$this->tipo;
        return view('exports/turnos',compact('turnos'))->with(['mes'=>$mes,'anio'=>$anio,'tipo'=>$tipo]);
    }
}
