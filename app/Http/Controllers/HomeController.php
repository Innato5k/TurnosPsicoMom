<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Procesos;
use App\Exports\CumplesExport;
use App\Exports\TurnosExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CancelacionesExport;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      	$usua=User::find(auth()->user()->id);
        $procesos=Procesos::whereraw('datediff(curdate(),ultima_ejecucion)>=1')->get();
        if(count($procesos)>0){ return redirect($procesos[0]->ruta);};
        return view('home',compact('usua'));
    }
    
    public function index_mantenimiento()
    {
        $usua=User::find(auth()->user()->id);
        return view('home_mantenimiento',compact('usua'));
    }
    
    public function index_reportes()
    {
        $usua=User::find(auth()->user()->id);
        return view('home_reportes',compact('usua'));
    }
    
    public function cumples(){
        $usua=User::find(auth()->user()->id);
        return view('reportes/cumples',compact('usua'));
    }
 
    public function cumples_do(Request $request){
        $objeto=new CumplesExport;
        $objeto->set_mes($request->mes);
        return Excel::download($objeto, 'cumpleaños.xlsx');
    }
    public function asistencia(){
        $data = DB::select( DB::raw('SELECT year(NOW()) AS anio, month(NOW()) as mes') );
        $anio=$data[0]->anio;
        $mes=$data[0]->mes;
        $tipo="General";
        return view('reportes/asistencia',compact('tipo','anio','mes'));
    }

    public function asistencia_matanza(){
        $data = DB::select( DB::raw('SELECT year(NOW()) AS anio, month(NOW()) as mes') );
        $anio=$data[0]->anio;
        $mes=$data[0]->mes;
        $tipo="CMMatanza - No Discapacidad";
        return view('reportes/asistencia',compact('tipo','anio','mes'));
    }

    public function asistencia_discapacidad(){
        $data = DB::select( DB::raw('SELECT year(NOW()) AS anio, month(NOW()) as mes') );
        $anio=$data[0]->anio;
        $mes=$data[0]->mes;
        $tipo="CMMatanza - Discapacidad";
        return view('reportes/asistencia',compact('tipo','anio','mes'));
    }

    public function asistencia_particular(){
        $data = DB::select( DB::raw('SELECT year(NOW()) AS anio, month(NOW()) as mes') );
        $anio=$data[0]->anio;
        $mes=$data[0]->mes;
        $tipo="Particular";
        return view('reportes/asistencia',compact('tipo','anio','mes'));
    }

    public function asistencia_do(Request $request){
        $objeto=new TurnosExport;
        $objeto->set_tipo($request->tipo);
        $objeto->set_anio($request->anio);
        $objeto->set_mes($request->mes);
        if($request->tipo=="General"){
            $nombre="asist_general.xlsx";
        };
        if($request->tipo=="CMMatanza - No Discapacidad"){
            $nombre="asist_cmmatanza-ndis.xlsx";
        };
        if($request->tipo=="CMMatanza - Discapacidad"){
            $nombre="asist_cmmatanza-disc.xlsx";
        };
        if($request->tipo=="Particular"){
            $nombre="asist_particular.xlsx";
        };
        
        return Excel::download($objeto, $nombre);   
    }
    
    public function cancelaciones(){
        $data = DB::select( DB::raw('SELECT year(NOW()) AS anio, month(NOW()) as mes') );
        $anio=$data[0]->anio;
        $mes=$data[0]->mes;
        return view('reportes/cancelaciones',compact('anio','mes'));
    }

    public function cancelaciones_do(Request $request){
        $objeto=new CancelacionesExport;
        $objeto->set_anio($request->anio);
        $objeto->set_mes($request->mes);
        $nombre="cancelaciones.xlsx";
        return Excel::download($objeto, $nombre);   
    }

    public function enviar($numero,$texto){
        return view('mensajes/enviar')->with(['numero'=>$numero,'texto'=>$texto]);
    }
    
    
            
}