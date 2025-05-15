<?php

namespace App\Http\Controllers;

use App\Procesos;
use App\Turnos;
use App\Fechas;
use App\Padron;
use DB;
use Illuminate\Http\Request;
use App\Mail\Recordatorio;
use Illuminate\Support\Facades\Mail;

class ProcesosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function recordatorio()
    {
        $turnos=Turnos::leftJoin('fechas','turnos.fecha','fechas.fecha')->
        leftJoin('padrons','paciente','padrons.id')->
        whereraw('notificacion_2=0 and turnos.fecha>curdate() and paciente>0 and ( (dayofweek(curdate()) in (1,2,3,4,7) and datediff(turnos.fecha,curdate())=2) or (dayofweek(curdate())=6 and datediff(turnos.fecha,curdate())=4) or (dayofweek(curdate())=5 and datediff(turnos.fecha,curdate())=4)) ')->select('turnos.id','turnos.fecha','dia_semana','hora','paciente','padrons.apellido','padrons.nombre','turnos.modalidad','padrons.email','padrons.telefono_celular as pac_celular')->orderBy('turnos.fecha','asc')->orderBy('turnos.hora','asc')->get();
            if(count($turnos)==0){
                $data = DB::select( DB::raw('SELECT NOW() AS fecha') );
                $hoy=$data[0]->fecha;
                Procesos::find(1)->update(['ultima_ejecucion'=>$hoy]);
                return view('/home');
            }
            else{
                return view('/recordatorio/index',compact('turnos'));
            };    
     }
     public function recordatorio_mail($id){
          $turno=Turnos::find($id);
          $paci=Padron::find($turno->paciente);
          if(false && $paci->id>0){
            $paciente=$paci->apellido.", ".$paci->nombre;
            $direccion=$paci->email;
            Mail::to($direccion)->send(new Recordatorio($id,$paciente));
            return "OK";
          };
          return "ERR";
     }

     public function recordatorio_finalizar($fecha){   
        Turnos::whereRaw("fecha='".$fecha."' and paciente>0")->update(['notificacion_2' => '1']);   
        $data = DB::select( DB::raw('SELECT NOW() AS fecha') );
        $hoy=$data[0]->fecha;
        Procesos::find(1)->update(['ultima_ejecucion'=>$hoy]);
        return view('/home');
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Procesos  $procesos
     * @return \Illuminate\Http\Response
     */
    public function show(Procesos $procesos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Procesos  $procesos
     * @return \Illuminate\Http\Response
     */
    public function edit(Procesos $procesos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Procesos  $procesos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Procesos $procesos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Procesos  $procesos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Procesos $procesos)
    {
        //
    }
}
