<?php

namespace App\Http\Controllers;

use App\Turnos;
use App\Fechas;
use App\Padron;
use App\Cancelaciones;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
   
use App\Mail\Notificacion;
use App\Mail\Cancelacion;
use Illuminate\Support\Facades\Mail;

class TurnosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $fec=Fechas::find($id);
        $fecha=$fec->fecha;
        $ds=$fec->dia_semana;
        $data = DB::select( DB::raw('SELECT NOW() AS fecha') );
        $hoy=$data[0]->fecha;
        $turnos=Turnos::leftJoin('padrons','paciente','padrons.id')->
        whereDate('fecha',$fecha)->orderby('hora')->select('turnos.id','turnos.fecha','turnos.hora','turnos.bloqueado','turnos.motivo_bloqueo','padrons.apellido','padrons.nombre','padrons.telefono_celular as celular','turnos.paciente','turnos.modalidad','turnos.cobertura','turnos.asistencia','turnos.pago')->get();
        return view('turnos/index',compact('turnos','fecha','ds','hoy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = DB::select( DB::raw('SELECT year(NOW()) AS anio') );
        $anio=$data[0]->anio;
        $data = DB::select( DB::raw('SELECT month(NOW()) AS mes') );
        $mes=$data[0]->mes;
        return view('turnos/create')->with(['anio' => $anio, 'mes' => $mes]);
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cantidad=Turnos::whereRaw('year(fecha)='.$request->anio.' and month(fecha)='.$request->mes)->count();
        if($cantidad==0){
          
            $fechas=Fechas::whereYear('fecha',$request->anio)->whereMonth('fecha',$request->mes)->orderby('fecha','asc')->get();
              foreach($fechas as $fec){
                $ds=$fec["dia_semana"];
                $f=$fec["fecha"];
                for($h=8;$h<=22;$h++){
                    $hora=substr("0".$h,-2).":00";
                    $turno=new Turnos;
                    $turno->fecha=$f;
                    $turno->hora=$hora;
                    $turno->bloqueado=0;
                    // recorre pacientes para ver si hay alguno con ese día de semana y hora
                    $paciente=Padron::whereraw("ds_1='".$ds."' and left(hora_1,5)='".$hora."'")->get();
                    if (count($paciente)==1){
                        $turno->paciente=$paciente[0]->id;
                        $turno->cobertura=$paciente[0]->cobertura;
                        $turno->modalidad=$paciente[0]->modalidad;
                     } 
                     else{
                        $paciente=Padron::whereraw("ds_2='".$ds."' and left(hora_2,5)='".$hora."'")->get();
                        if(count($paciente)==1){
                            $turno->paciente=$paciente[0]->id;
                            $turno->cobertura=1;
                            $turno->modalidad=$paciente[0]->modalidad;
                        };
                    };
                    $turno->save();
                    $hora=substr("0".$h,-2).":30";
                    $turno=new Turnos;
                    $turno->fecha=$f;
                    $turno->hora=$hora;
                    $turno->bloqueado=0;
                    // recorre pacientes para ver si hay alguno con ese día de semana y hora
                    $paciente=Padron::whereraw("ds_1='".$ds."' and left(hora_1,5)='".$hora."'")->get();
                    if (count($paciente)==1){
                        $turno->paciente=$paciente[0]->id;
                        $turno->cobertura=$paciente[0]->cobertura;
                        $turno->modalidad=$paciente[0]->modalidad;
                     } 
                     else{
                        $paciente=Padron::whereraw("ds_2='".$ds."' and left(hora_2,5)='".$hora."'")->get();
                        if(count($paciente)==1){
                            $turno->paciente=$paciente[0]->id;
                            $turno->cobertura=1;
                            $turno->modalidad=$paciente[0]->modalidad;
                        };
                    };
                    $turno->save();
                }
            };
        };
        return redirect('/home');    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Turnos  $turnos
     * @return \Illuminate\Http\Response
     */
    public function disponibles()
    {
        return view('turnos/buscar');
    }

    public function disponibles_do(Request $request)
    {
        $turnos=Turnos::leftJoin('fechas','turnos.fecha','fechas.fecha')->whereraw("paciente is null and hora between '".$request->desde."' and '".$request->hasta."' and turnos.fecha>curdate() and bloqueado=0 and laborable=1")->select('turnos.id','fechas.dia_semana','turnos.fecha','turnos.hora')->orderBy('turnos.fecha','asc')->orderBy('turnos.hora','asc')->get();
        return view('turnos/disponibles',compact('turnos'));
    }

    public function preasignar($id){
        $turno=Turnos::find($id);
        $fechas=Fechas::where('fecha',$turno->fecha)->get();
        $fecha=$fechas[0];
        return view('turnos/preasignar',compact('turno','fecha'));
    }

    public function asignar($id,$pacienteid){
        $turno=Turnos::find($id);
        $fechas=Fechas::where('fecha',$turno->fecha)->get();
        $fecha=$fechas[0];
        $paciente=Padron::find($pacienteid);
        return view('turnos/asignar',compact('turno','fecha','paciente'));
    }

   
    public function update(Request $request)
    {
        $turno=Turnos::find($request->id);
        $turno->paciente=$request->paciente;
        $turno->modalidad=$request->modalidad;
        $turno->cobertura=$request->cobertura;
        $turno->save();
        $fecha=$turno->fecha;
        $diasem=Fechas::where('fecha',$fecha)->get();
        $ds=$diasem[0]->dia_semana;
        $idfecha=$diasem[0]->id;
        if(isset($request->copago)){
               $hora=substr($turno->hora,0,5);
               if(substr($hora,-2)=="00"){
                $nueva_hora=substr($hora,0,3)."30:00";
               }
               else{
                $hora_numero=intval(substr($hora,0,2))+1;
                $nueva_hora=substr("0".strval($hora_numero),-2).":00:00";
               }; 

               $turno2=Turnos::whereraw("bloqueado=0 and fecha='".$fecha."' and hora='".$nueva_hora."' and paciente is null")->get();
               if(count($turno2)==1){
                    $turno2[0]->paciente=$request->paciente;
                    $turno2[0]->modalidad=$request->modalidad;
                    $turno2[0]->cobertura=1;
                    $turno2[0]->save();
               };
        };    
        if(isset($request->replicar)){
                $turnos=Turnos::whereraw("bloqueado=0 and paciente is null and fecha>'".$turno->fecha."' and hora='".$turno->hora."'")->get();
                foreach($turnos as $item){
                    $diasem=Fechas::where('fecha',$item->fecha)->get();
                    $dsi=$diasem[0]->dia_semana;
                    if($ds==$dsi){
                        $item->paciente=$request->paciente;
                        $item->modalidad=$request->modalidad;
                        $item->cobertura=$request->cobertura;
                        $item->save();
                    };    
                };
                if(isset($request->copago)){
                    if(count($turno2)==1){
                        $turnos=Turnos::whereraw("bloqueado=0 and paciente is null and fecha>'".$turno->fecha."' and hora='".$turno2[0]->hora."'")->get();
                            foreach($turnos as $item){
                                $diasem=Fechas::where('fecha',$item->fecha)->get();
                                $dsi=$diasem[0]->dia_semana;
                                if($ds==$dsi){
                                    $item->paciente=$request->paciente;
                                    $item->modalidad=$request->modalidad;
                                    $item->cobertura=1;
                                    $item->save();
                                };    
                            };      
                    };    
                };       
        };

        if(isset($request->habitual)){
                // antes de asignar el dia y hora de semana 1 borra ese horario en cualquier otro paciente
                Padron::where([['ds_1','=',$ds],['hora_1','=',$turno->hora]])->update(['ds_1' => null,'hora_1' => null]);
                Padron::where([['ds_2','=',$ds],['hora_2','=',$turno->hora]])->update(['ds_2' => null,'hora_2' => null]);
                Padron::find($request->paciente)->update(['ds_1'=>$ds,'hora_1' => $turno->hora,'modalidad'=>$request->modalidad]);
                if(isset($request->copago)){
                    if(count($turno2)==1){
                        Padron::where([['ds_1','=',$ds],['hora_1','=',$turno2[0]->hora]])->update(['ds_1' => null,'hora_1' => null]);
                        Padron::where([['ds_2','=',$ds],['hora_2','=',$turno2[0]->hora]])->update(['ds_2' => null,'hora_2' => null]);
                        Padron::find($request->paciente)->update(['ds_2'=>$ds,'hora_2' => $turno2[0]->hora]);
                    };    
                };
            };
        return redirect('/turnos/notifica/'.$turno->id);
        
    }
    
    public function bloquear($id){
        $turno=Turnos::find($id);
        $fechas=Fechas::where('fecha',$turno->fecha)->get();
        $fecha=$fechas[0];
        return view('turnos/bloquear',compact('turno','fecha'));
    }
    
    public function bloquear_do(Request $request)
    {
        
        $turno=Turnos::find($request->id);
        $fecha=$turno->fecha;
        $hora=$turno->hora;
        $hasta=$request->hasta;
        $motivo=$request->motivo_bloqueo;
        $turnos=Turnos::whereraw("fecha='".$fecha."' and hora>='".$hora."' and hora<='".$hasta."' and bloqueado=0")->get();
        foreach($turnos as $item){
            if(!$item->paciente>0){
                $item->bloqueado=1;
                $item->motivo_bloqueo=$motivo;
                $item->save();
            }
        }
        $fec=Fechas::where('fecha',$fecha)->get();
        $idfecha=$fec[0]->id;
        return redirect('/turnos/consultar/'.$idfecha);
    }

    public function liberar($id){
        $turno=Turnos::find($id);
        $turno->bloqueado=0;
        $turno->motivo_bloqueo=null;
        $turno->save();
        $fec=Fechas::where('fecha',$turno->fecha)->get();
        $idfecha=$fec[0]->id;
        return redirect('/turnos/consultar/'.$idfecha);   
    }
    public function asistencia($id){
        $turno=Turnos::find($id);
        if($turno->asistencia==1){$turno->asistencia="0";}
        else{$turno->asistencia="1";};
        $turno->save();
        $fec=Fechas::where('fecha',$turno->fecha)->get();
        $idfecha=$fec[0]->id;
        return redirect('/turnos/consultar/'.$idfecha);      
    }
    
    public function asistencia2($id){
        $turno=Turnos::find($id);
        if($turno->asistencia==1){$turno->asistencia="0";}
        else{$turno->asistencia="1";};
        $turno->save();
        $fec=Fechas::where('fecha',$turno->fecha)->get();
        $idfecha=$fec[0]->id;
        return redirect('/turnos/repaso/'.$idfecha);      
    }

    public function pago($id){
        $turno=Turnos::find($id);
        if($turno->pago==1){$turno->pago="0";}
        else{$turno->pago="1";};
        $turno->save();
        $fec=Fechas::where('fecha',$turno->fecha)->get();
        $idfecha=$fec[0]->id;
        return redirect('/turnos/consultar/'.$idfecha);      
    }
    
    public function pago2($id){
        $turno=Turnos::find($id);
        if($turno->pago==1){$turno->pago="0";}
        else{$turno->pago="1";};
        $turno->save();
        $fec=Fechas::where('fecha',$turno->fecha)->get();
        $idfecha=$fec[0]->id;
        return redirect('/turnos/repaso/'.$idfecha);      
    }
    
    public function pago3($id){
        $turno=Turnos::find($id);
        if($turno->pago==1){$turno->pago="0";}
        else{$turno->pago="1";};
        $turno->save();
        return true;      
    }
    
    public function pago4($id){
        $turno=Turnos::find($id);
        if($turno->pago==1){$turno->pago="0";}
        else{$turno->pago="1";};
        $turno->save();
        return redirect('/turnos/impagos/');      
    }
        
    public function cancelar($id){
        $turno=Turnos::find($id);
        $fec=Fechas::where('fecha',$turno->fecha)->get();
        $dia_semana=$fec[0]->dia_semana;
        $paciente=Padron::find($turno->paciente);
        $apynomb=$paciente->apellido.", ".$paciente->nombre;
        $telefono=$paciente->telefono_celular;
        $turnos=Turnos::leftJoin('padrons','paciente','padrons.id')->leftJoin('fechas','turnos.fecha','fechas.fecha')->where('turnos.fecha','>',$turno->fecha)->select('turnos.id','fechas.dia_semana','turnos.fecha','turnos.hora','bloqueado','motivo_bloqueo','paciente','padrons.apellido','padrons.nombre')->orderby('fecha','asc')->orderby('hora','asc')->get();
        return view('turnos/cancelar',compact('turno','turnos','apynomb','telefono','dia_semana'));
    }
    public function cancelar_do(Request $request){
        // nuevo:: si está definida la variable reprogramar, cancela el turno y asigna el nuevo y notifica ambas cosas. Finalmente vuelve a turnos del día.
        // si no está definida, solo cancela el turno

        $turno=Turnos::find($request->id);
        // en cualquier caso, registra la cancelacion
        $cancelacion= new Cancelaciones;
        $cancelacion->fecha=$turno->fecha;
        $cancelacion->hora=$turno->hora;
        $cancelacion->paciente=$turno->paciente;
        $cancelacion->modalidad=$turno->modalidad;
        $cancelacion->cobertura=$turno->cobertura;
        $cancelacion->motivo=$request->motivo;
        $cancelacion->reprogramado=0;
        $cancelacion->save();

        $paciente=$turno->paciente;
        $modalidad=$turno->modalidad;
        $cobertura=$turno->cobertura;
        if(isset($request->reprogramar)){
            $cancelacion->update(['reprogramado' => 1]);
            // asigna el nuevo turno
            $nuevo_turno=Turnos::find($request->reprogramar);
            $nuevo_turno->update(['paciente'=>$paciente,'modalidad'=>$modalidad,'cobertura'=>$cobertura]);

            // notifica la cancelación del anterior
            $paciente=Padron::find($turno->paciente);
            $direccion=$paciente->email;
            if($direccion==null || $direccion==''){$direccion='lic_graciela_careri@misdatos.ar';};  
            $nombre=$paciente->apellido.", ".$paciente->nombre;
            //-----Mail::to($direccion)->send(new Cancelacion($request->id,$nombre));    
            $paciente=$turno->paciente;
            $fecha=$turno->fecha;
            $fechas=Fechas::where('fecha',$fecha)->get();
            $idfecha=$fechas[0]->id;
            $hora=substr($turno->hora,0,5);
            if(substr($hora,-2)=="00"){
                $nueva_hora=substr($hora,0,3)."30:00";
            }
            else{
                $horaval=intval(substr($hora,0,2))+1;
                $nueva_hora=substr("0".$horaval,-2).":00:00";
            };

            // disponibiliza turno en agenda
            $turno->update(['paciente'=>null,'modalidad' => null, 'cobertura' => null,'notificacion_1'=>0,'notificacion_2'=>0]);
            // revisa si la próxima media hora también está asignada al mismo paciente
                $turnos2=Turnos::where([['fecha','=',$fecha],['hora','=',$nueva_hora],['paciente','=',$paciente]])->get();
                if(count($turnos2)==1){
                    // lo disponibiliza
                    $turno=$turnos2[0];
                    $turno->update(['paciente'=>null,'modalidad' => null, 'cobertura' => null,'notificacion_1'=>0,'notificacion_2'=>0]);    
                    // asigna el nuevo turno
                    $hora=substr($nuevo_turno->hora,0,5);
                    if(substr($hora,-2)=="00"){
                        $nueva_hora=substr($hora,0,3)."30:00";
                    }
                    else{
                        $horaval=intval(substr($hora,0,2))+1;
                        $nueva_hora=substr("0".$horaval,-2).":00:00";
                    };
                    $nuevos=Turnos::whereRaw('paciente is null and fecha='.str_replace("-", "", $nuevo_turno->fecha)." and hora='".$nueva_hora."'")->get();
                    
                    if(count($nuevos)==1){
                        Turnos::find($nuevos[0]->id)->update(['paciente'=>$paciente,'modalidad'=>$modalidad,'cobertura'=>$cobertura]);
                    } 
                    else{
                        //die($nuevo_turno->fecha."*".$nueva_hora);
                    };
                };
                
               return redirect("/turnos/notifica/".$nuevo_turno->id);
        }
        else{    
            // solo cancela el turno
                 $turno=Turnos::find($request->id);
                // notifica la cancelación 
                $paciente=Padron::find($turno->paciente);
                $direccion=$paciente->email;
                if($direccion==null || $direccion==''){$direccion='lic_graciela_careri@misdatos.ar';};  
                $nombre=$paciente->apellido.", ".$paciente->nombre;
                //----Mail::to($direccion)->send(new Cancelacion($request->id,$nombre));    
                
                $paciente=$turno->paciente;
                $fecha=$turno->fecha;
                $fechas=Fechas::where('fecha',$fecha)->get();
                $idfecha=$fechas[0]->id;
                $hora=substr($turno->hora,0,5);
                if(substr($hora,-2)=="00"){
                    $nueva_hora=substr($hora,0,3)."30:00";
                }
                else{
                    $horaval=intval(substr($hora,0,2))+1;
                    $nueva_hora=substr("0".$horaval,-2).":00:00";
                };

                // disponibiliza el turno en agenda
                $turno->update(['paciente'=>null,'modalidad' => null, 'cobertura' => null]);
                
                // revisa si la próxima media hora también está asignada al mismo paciente

                $turnos2=Turnos::where([['fecha','=',$fecha],['hora','=',$nueva_hora],['paciente','=',$paciente]])->get();
                if(count($turnos2)==1){
                    //lo disponibiliza
                    $turno=$turnos2[0];
                    $turno->update(['paciente'=>null,'modalidad' => null, 'cobertura' => null]);    
                };
                return Redirect("/turnos/consultar/".$idfecha);    
        };
        
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Turnos  $turnos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Turnos $turnos)
    {
        //
    }
    
    public function notificar($id){
        $turno=Turnos::find($id);
        $paciente=Padron::find($turno->paciente);
        $direccion=$paciente->email;
        if($direccion==null || $direccion==''){$direccion='lic_graciela_careri@misdatos.ar';};  
        $nombre=$paciente->apellido.", ".$paciente->nombre;
        //---Mail::to($direccion)->send(new Notificacion($id,$nombre));
        $turno->update(['notificacion_1'=>'1']);
        // revisa si había una cancelación reciente y si la encuentra pregunta
        $cancelaciones=Cancelaciones::where([['paciente','=',$turno->paciente],['fecha','<',$turno->fecha],['reprogramado','=','0']])->orderBy('fecha','desc')->get();
        if(count($cancelaciones)>0){
            $idturno=$turno->id;
            $idcancelacion=$cancelaciones[0]->id;
            return redirect('turnos/escancelacion/'.$idturno.'/'.$idcancelacion);
        }
        else{
            $fec=Fechas::where('fecha',$turno->fecha)->get();
            $idfecha=$fec[0]->id;
            return redirect('turnos/consultar/'.$idfecha);
        };    
    }

    public function escancelacion($idturno,$idcancelacion){
        $turno=Turnos::find($idturno);
        $ente=Padron::find($turno->paciente);
        $paciente=$ente->apellido.", ".$ente->nombre;
        $cancelacion=Cancelaciones::find($idcancelacion);
        $fec=Fechas::where('fecha',$turno->fecha)->get();
        $ds_turno=$fec[0]->dia_semana;
        $fec_can=Fechas::where('fecha',$cancelacion->fecha)->get();
        $ds_cancelacion=$fec_can[0]->dia_semana;
        return view('cancelaciones/confirmar',compact('turno','cancelacion','ds_turno','ds_cancelacion','paciente'));
    }
    public function escancelacion_do(Request $request){
        $turno=Turnos::find($request->idturno);
        $cancelacion=Cancelaciones::find($request->idcancelacion);
        if(isset($request->confirmar)){
            
            $cancelacion->update(['reprogramado' => 1 ]);
            
        };
        $fec=Fechas::where('fecha',$turno->fecha)->get();
        $idfecha=$fec[0]->id;
        return redirect('turnos/consultar/'.$idfecha);
    }
    public function actual(){
        $horahoy=substr(Carbon::now(),11,8);
        $turnos=Turnos::whereRaw("paciente>0  and fecha=curdate() and hora<='".$horahoy."' and timediff('".$horahoy."',hora)<'00:30' and (asistencia=0 or asistencia is null)")->get();
        if (count($turnos)>0) {
            $turno=Turnos::find($turnos[0]->id);
            $paciente=Padron::find($turno->paciente);
            $npac=$paciente->apellido.", ".$paciente->nombre;
            $modalidad="Presencial";
            if($turno->modalidad==2){$modalidad="Virtual";};
            $hora=substr($turno->hora,0,5);
            return $hora.":".$npac." - ".$modalidad." <a onclick='confirmar(".$turno->id.")'>Confirmar Asistencia</a>";
        }
            else{return "";};
    }
    public function impagos_get(){
        $data = DB::select( DB::raw('SELECT NOW() AS fecha') );
        $hoy=substr($data[0]->fecha,0,10);
        $fechas=Turnos::whereraw("paciente>0 and asistencia=1 and (pago is null or pago=0)")->selectraw("min(fecha) as fecha")->get();
        $fecha=$fechas[0]->fecha;
        $turnos=Turnos::leftJoin('padrons','paciente','padrons.id')->
        leftJoin('fechas','turnos.fecha','fechas.fecha')->
        whereraw("paciente>0 and asistencia=1 and (pago is null or pago=0)")->orderby('hora')->select('turnos.id','turnos.fecha','turnos.hora','padrons.apellido','padrons.nombre','padrons.telefono_celular as celular','turnos.paciente','turnos.cobertura','fechas.dia_semana')->get();
        return view('/turnos/impagos',compact('turnos'))->with(['fecha'=>$fecha,'hoy'=>$hoy]);
    }
    public function impagos_post(Request $request){
        $data = DB::select( DB::raw('SELECT NOW() AS fecha') );
        $hoy=substr($data[0]->fecha,0,10);
        $turnos=Turnos::leftJoin('padrons','paciente','padrons.id')->
        leftJoin('fechas','turnos.fecha','fechas.fecha')->
        whereraw("turnos.fecha>='".$request->fecha."' and paciente>0 and asistencia=1 and (pago is null or pago=0)")->orderby('apellido')->orderby('nombre')->orderby('fecha')->orderby('hora')->select('turnos.id','turnos.fecha','turnos.hora','padrons.apellido','padrons.nombre','padrons.telefono_celular as celular','turnos.paciente','turnos.cobertura','fechas.dia_semana')->get();
        
        return view('/turnos/impagos',compact('turnos'))->with(['fecha'=>$request->fecha,'hoy'=>$hoy]);
    }    
    
    public function repaso_get(){
        $data = DB::select( DB::raw('SELECT NOW() AS fecha') );
        $hoy=substr($data[0]->fecha,0,10);
        $turnos=Turnos::leftJoin('padrons','paciente','padrons.id')->
        whereraw("fecha='".$hoy."' and paciente>0")->orderby('hora')->select('turnos.id','turnos.hora','padrons.apellido','padrons.nombre','padrons.telefono_celular as celular','turnos.paciente','turnos.modalidad','turnos.cobertura','turnos.asistencia','turnos.pago')->get();
        return view('/turnos/repaso',compact('turnos'))->with(['fecha'=>$hoy,'hoy'=>$hoy]);
    }

    public function repaso_post(Request $request){
        $data = DB::select( DB::raw('SELECT NOW() AS fecha') );
        $hoy=substr($data[0]->fecha,0,10);
        $turnos=Turnos::leftJoin('padrons','paciente','padrons.id')->
        whereraw("fecha='".$request->fecha."' and paciente>0 ")->orderby('hora')->select('turnos.id','turnos.hora','padrons.apellido','padrons.nombre','padrons.telefono_celular as celular','turnos.paciente','turnos.modalidad','turnos.cobertura','turnos.asistencia','turnos.pago')->get();

        
        return view('/turnos/repaso',compact('turnos'))->with(['fecha'=>$request->fecha,'hoy'=>$hoy]);
    }    
    public function repaso($id){
        $data = DB::select( DB::raw('SELECT NOW() AS fecha') );
        $hoy=substr($data[0]->fecha,0,10);
        $fecha=Fechas::find($id)->fecha;
        $turnos=Turnos::leftJoin('padrons','paciente','padrons.id')->
        whereDate('fecha',$fecha)->whereraw('paciente>0')->orderby('hora')->select('turnos.id','turnos.hora','padrons.apellido','padrons.nombre','padrons.telefono_celular','turnos.paciente','turnos.modalidad','turnos.cobertura','turnos.asistencia','turnos.pago')->get();

        
        return view('/turnos/repaso',compact('turnos'))->with(['fecha'=>$fecha,'hoy'=>$hoy]);
    }
    public function pagorapido(){
        return view('turnos/pago');
    } 
    public function buscapagos(string $texto){
        $turnos=Turnos::leftJoin('padrons','paciente','padrons.id')->whereraw("asistencia=1 and (pago is null or pago=0) and (apellido like'".$texto."%' or nombre like '".$texto."%')")->select('turnos.id','fecha','hora','turnos.cobertura','padrons.apellido','padrons.nombre')->orderBy('apellido','asc','nombre','asc','fecha','asc','hora','asc')->get();
        $t="";
        foreach($turnos as $item){
            $t=$t."<tr><td>".$item->apellido.", ".$item->nombre."</td><td>".substr($item->fecha,8,2)."/".substr($item->fecha,5,2)."/".substr($item->fecha,0,4)."</td><td>".substr($item->hora,0,5)."</td><td>";
            if($item->cobertura=="1"){$t=$t."Particular";} else {$t=$t."CMMatanza";};
            $t=$t."</td><td><input class='form-control' type='checkbox' id='".$item->id."' onclick='paga(this.id)'></td></tr>";
        };
        return $t;
    }   
    public function porpaciente($id){
        $paciente=Padron::find($id);
        $turnos=Turnos::leftjoin('padrons','paciente','padrons.id')->leftJoin('fechas','turnos.fecha','fechas.fecha')->whereRaw('paciente='.$id.' and turnos.fecha>curdate()')->orderby('turnos.fecha','asc','hora','asc')->select('dia_semana','turnos.fecha','turnos.hora','turnos.modalidad','turnos.cobertura')->get();
        return view('turnos/porpaciente',compact('turnos','paciente'));
    }
}
