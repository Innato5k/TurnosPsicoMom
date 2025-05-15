<?php

namespace App\Exports;

use App\Turnos;
use App\Padron;
use App\Cancelaciones;
use DB;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class InformesExport implements FromView, ShouldAutoSize
{
    
    public $paciente;
    
    public function set_paciente($vpaciente){
        $this->paciente=$vpaciente;
    }

    

    public function view():View
    {
            $paciente=Padron::find($this->paciente);   
            $turnos=Turnos::where('paciente',$this->paciente)->select(DB::raw("'t' as tipo"),'fecha','hora','modalidad','cobertura',DB::raw('null as reprogramado'),'asistencia','pago');
            $registros=Cancelaciones::where('paciente',$this->paciente)->select(DB::raw("'r' as tipo"),'fecha','hora','modalidad','cobertura','reprogramado',DB::raw('null as asistencia'),DB::raw('null as pago'))->union($turnos)->orderby('fecha','asc')->orderby('hora','asc')->get();
        return view('exports/informes',compact('registros','paciente'));
    }
}
