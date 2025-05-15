<?php

namespace App\Http\Controllers;

use App\Fechas;
use DB;
use Illuminate\Http\Request;

class FechasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
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
    public function generar()
    {
        $data = DB::select( DB::raw('SELECT year(NOW())+1 AS anio') );
        $anio=$data[0]->anio;
        $cantidad= Fechas::whereRaw('year(fecha)='.$anio)->count();
        if($cantidad==0){
            $mes="01";
            for($d=1;$d<=31;$d++){
                $dia=substr("0".$d,-2);
                $fec=$anio.$mes.$dia;
                $fecha=new Fechas;
                $fecha->fecha=$fec;
                $fecha->dia_semana='';
                $fecha->laborable=0;
                $fecha->save();    
            };
            $mes="02";
            for($d=1;$d<=28;$d++){
                $dia=substr("0".$d,-2);
                $fec=$anio.$mes.$dia;
                $fecha=new Fechas;
                $fecha->fecha=$fec;
                $fecha->dia_semana='';
                $fecha->laborable=0;
                $fecha->save();    
            };
            $mes="03";
            for($d=1;$d<=31;$d++){
                $dia=substr("0".$d,-2);
                $fec=$anio.$mes.$dia;
                $fecha=new Fechas;
                $fecha->fecha=$fec;
                $fecha->dia_semana='';
                $fecha->laborable=0;
                $fecha->save();    
            };
            $mes="04";
            for($d=1;$d<=30;$d++){
                $dia=substr("0".$d,-2);
                $fec=$anio.$mes.$dia;
                $fecha=new Fechas;
                $fecha->fecha=$fec;
                $fecha->dia_semana='';
                $fecha->laborable=0;
                $fecha->save();    
            };
            $mes="05";
            for($d=1;$d<=31;$d++){
                $dia=substr("0".$d,-2);
                $fec=$anio.$mes.$dia;
                $fecha=new Fechas;
                $fecha->fecha=$fec;
                $fecha->dia_semana='';
                $fecha->laborable=0;
                $fecha->save();    
            };
            $mes="06";
            for($d=1;$d<=30;$d++){
                $dia=substr("0".$d,-2);
                $fec=$anio.$mes.$dia;
                $fecha=new Fechas;
                $fecha->fecha=$fec;
                $fecha->dia_semana='';
                $fecha->laborable=0;
                $fecha->save();    
            };
            $mes="07";
            for($d=1;$d<=31;$d++){
                $dia=substr("0".$d,-2);
                $fec=$anio.$mes.$dia;
                $fecha=new Fechas;
                $fecha->fecha=$fec;
                $fecha->dia_semana='';
                $fecha->laborable=0;
                $fecha->save();    
            };
            $mes="08";
            for($d=1;$d<=31;$d++){
                $dia=substr("0".$d,-2);
                $fec=$anio.$mes.$dia;
                $fecha=new Fechas;
                $fecha->fecha=$fec;
                $fecha->dia_semana='';
                $fecha->laborable=0;
                $fecha->save();    
            };
            $mes="09";
            for($d=1;$d<=30;$d++){
                $dia=substr("0".$d,-2);
                $fec=$anio.$mes.$dia;
                $fecha=new Fechas;
                $fecha->fecha=$fec;
                $fecha->dia_semana='';
                $fecha->laborable=0;
                $fecha->save();    
            };
            $mes="10";
            for($d=1;$d<=31;$d++){
                $dia=substr("0".$d,-2);
                $fec=$anio.$mes.$dia;
                $fecha=new Fechas;
                $fecha->fecha=$fec;
                $fecha->dia_semana='';
                $fecha->laborable=0;
                $fecha->save();    
            };
            $mes="11";
            for($d=1;$d<=30;$d++){
                $dia=substr("0".$d,-2);
                $fec=$anio.$mes.$dia;
                $fecha=new Fechas;
                $fecha->fecha=$fec;
                $fecha->dia_semana='';
                $fecha->laborable=0;
                $fecha->save();    
            };
            $mes="12";
            for($d=1;$d<=31;$d++){
                $dia=substr("0".$d,-2);
                $fec=$anio.$mes.$dia;
                $fecha=new Fechas;
                $fecha->fecha=$fec;
                $fecha->dia_semana='';
                $fecha->laborable=0;
                $fecha->save();    
            };
            Fechas::whereYear('fecha',$anio)->whereRaw('dayofweek(fecha)=1')->update(['dia_semana' =>'Domingo', 'laborable'=> '0']);
            Fechas::whereYear('fecha',$anio)->whereRaw('dayofweek(fecha)=2')->update(['dia_semana' =>'Lunes', 'laborable'=> '1']);
            Fechas::whereYear('fecha',$anio)->whereRaw('dayofweek(fecha)=3')->update(['dia_semana' =>'Martes', 'laborable'=> '1']);
            Fechas::whereYear('fecha',$anio)->whereRaw('dayofweek(fecha)=4')->update(['dia_semana' =>'Miércoles', 'laborable'=> '1']);
            Fechas::whereYear('fecha',$anio)->whereRaw('dayofweek(fecha)=5')->update(['dia_semana' =>'Jueves', 'laborable'=> '1']);
            Fechas::whereYear('fecha',$anio)->whereRaw('dayofweek(fecha)=6')->update(['dia_semana' =>'Viernes', 'laborable'=> '1']);
            Fechas::whereYear('fecha',$anio)->whereRaw('dayofweek(fecha)=7')->update(['dia_semana' =>'Sábado', 'laborable'=> '0']);
              
        };
        return Redirect('/home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Fechas  $fechas
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $data = DB::select( DB::raw('SELECT NOW() AS fecha') );
        $hoy=$data[0]->fecha;
        $fechas=Fechas::whereYear('fecha',$request->anio)->whereMonth('fecha',$request->mes)->orderBy('fecha','asc')->select('id','fecha','dia_semana','laborable','observaciones',DB::raw('(select count(*) from turnos where turnos.fecha=fechas.fecha and turnos.paciente>0) as cantidad'))->get();
        return view('fechas/calendario',compact('fechas'))->with(['anio' => $request->anio, 'mes' => $request->mes,'hoy' => $hoy]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Fechas  $fechas
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $data = DB::select( DB::raw('SELECT NOW() AS fecha') );
        $hoy=$data[0]->fecha;
        $data = DB::select( DB::raw('SELECT year(NOW()) AS anio') );
        $anio=$data[0]->anio;
        $data = DB::select( DB::raw('SELECT month(NOW()) AS mes') );
        $mes=$data[0]->mes;
        $fechas=Fechas::whereYear('fecha',$anio)->whereMonth('fecha',$mes)->orderBy('fecha','asc')->select('id','fecha','dia_semana','laborable','observaciones',DB::raw('(select count(*) from turnos where turnos.fecha=fechas.fecha and turnos.paciente>0 ) as cantidad'))->get();
        return view('fechas/calendario',compact('fechas'))->with(['anio' => $anio, 'mes' => $mes, 'hoy' => $hoy]);
    }
    
    public function bloquear($id){
        $fecha=Fechas::find($id);
        return view('fechas/bloquear',compact('fecha'));
    }
    public function bloquear_do(Request $request){
        $fecha=Fechas::find($request->id);
        $observaciones=$request->observaciones;
        $fecha->laborable='0';
        $fecha->observaciones=$observaciones;
        $fecha->save();
        return redirect('/calendario');
    }
    public function liberar($id){
        $fecha=Fechas::find($id);
        $fecha->laborable='1';
        $fecha->observaciones=null;
        $fecha->save();
        return redirect('/calendario');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Fechas  $fechas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fechas $fechas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Fechas  $fechas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fechas $fechas)
    {
        //
    }
}
