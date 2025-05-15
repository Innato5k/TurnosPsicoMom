<?php

namespace App\Http\Controllers;

use App\Padron;
use App\Turnos;
use App\Localidades;
use App\Provincias;

use Illuminate\Http\Request;
use DB;
class PadronController extends Controller
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
    public function index(Request $request)
    {
        //
        $registros=Padron::whereraw("concat(apellido,' ',nombre,' ',telefono_celular) like '%".$request->texto."%'")->
        orderBy('apellido','asc')->orderBy('nombre','asc')->get();
       
       return view('/padron/index',compact('registros'));
    }

    
    public function buscar()
    {
        return view('/padron/buscar');
    }

    public function porcuil($cuil){
        $padron=Padron::where('cuil',$cuil)->get();
        if(count($padron)==1){return $padron[0]->apellido.", ".$padron[0]->nombre;};
        return "";
    }
    public function pordocumento($documento){
        $padron=Padron::where('documento_numero',$documento)->get();
        if(count($padron)==1){return $padron[0]->apellido.", ".$padron[0]->nombre;};
        return "";
    }
    public function porid($id){
        $padron=Padron::where('id',$id)->get();
        if(count($padron)==1){return $padron[0]->apellido.", ".$padron[0]->nombre;};
        return "";
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('padron/nuevo');
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
        $provincias=Provincias::orderBy('descripcion','asc')->get();
        $padron=Padron::where('dni',$request->documento_numero)->
        where('fecha_nacimiento',$request->fecha_nacimiento)->get();
        if(count($padron)==0){
            $padron=new Padron;
            $padron->apellido=$request->apellido;
            $padron->nombre=$request->nombre;
            $padron->dni=$request->dni;
            $padron->fecha_nacimiento=$request->fecha_nacimiento;
            $padron->sexo=$request->sexo;
            $padron->telefono_celular=$request->telefono_celular;
            $padron->email=$request->email;
            $padron->save();
            if($padron->cuil=="" && $padron->sexo!="" && $padron->dni!=""){
                $padron->update(['cuil' => $this->generacuil($padron->dni,$padron->sexo)]);
            };
            return view('padron/nuevo2',compact('padron','provincias'));
        }
        else {
            return redirect('/padron/editar/'.$padron[0]->id);
        };
        return true;
       
    }
    public function store2(Request $request)
    {
        //
        Padron::find($request->id)->update(['cuil' => $request->cuil,'estado' => $request->estado,'domicilio_calle' => $request->domicilio_calle,'domicilio_numero' => $request->domicilio_numero,'domicilio_piso' => $request->domicilio_piso, 'domicilio_departamento' => $request->domicilio_departamento, 'localidad' => $request->localidad,'domicilio_codigopostal' => $request->domicilio_codigopostal]);
         $padron=Padron::find($request->id);
        return view('padron/nuevo3',compact('padron'));   
    }
    public function store3(Request $request)
    {
        //

        $paciente=Padron::find($request->id); 
        $paciente->update(['cobertura' => $request->cobertura,'plan' => $request->plan,'afiliado' => $request->afiliado, 'iva' => $request->iva, 'observaciones' => $request->observaciones,'estado' => '1', 'ds_1' => $request->ds_1, 'hora_1' => $request->hora_1,'ds_2' => $request->ds_2, 'hora_2' => $request->hora_2,'modalidad' => $request->modalidad]);
        if($request->discapacidad=="on"){$paciente->update(['discapacidad' => 1]);};

        
        return redirect('/pacientes');   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Padron  $padron
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $padron=Padron::find($id);
        if($padron->localidad>0){
            $localidad=Localidades::find($padron->localidad);
            $loc_descripcion=$localidad->descripcion;
            $prov_descripcion=Provincias::find($localidad->provincia)->descripcion;
        } else {
        $loc_descripcion="";
        $prov_descripcion="";    
        };
        
        return view('/padron/ver',compact('padron','loc_descripcion','prov_descripcion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Padron  $padron
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $padron=Padron::find($id);
        return view('/padron/editar',compact('padron'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Padron  $padron
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $padron=Padron::find($request->id);
        $padron->update(['apellido' => $request->apellido,'nombre' => $request->nombre,'dni' => $request->dni, 'fecha_nacimiento' => $request->fecha_nacimiento, 'cuil' => $request->cuil, 'sexo' => $request->sexo,'telefono_celular' => $request->telefono_celular, 'email' => $request->email]);
            if($request->cuil=="" && $request->sexo!="" && $padron->dni!=""){
                $padron->update(['cuil' => $this->generacuil($request->dni,$request->sexo)]);
            };
        return redirect('/padron/editar2/'.$request->id);
    }
    public function generacuil($doc,$sex){
        $tipo="20";
        if($sex=="F"){$tipo="27";};
        $ndoc=substr("00000000".trim($doc),-8);
        $numero=$tipo.$ndoc;
        $d=$this->generadigito($numero);
        if($d==10){
            $numero="23".$ndoc;
            $d=$this->generadigito($numero);
        };
        return $numero.$d;
    }

    public function generadigito($n){
        $suma_p=0;
        $mult=[2,3,4,5,6,7,2,3,4,5];
        for($i=0;$i<=9;$i++){
            $suma_p=$suma_p+$mult[$i]*substr($n,9-$i,1);
        };
        $suma_mod11=$suma_p % 11;
        $oncemenos=11-$suma_mod11;
        if($oncemenos==11){ return 0;};
        return $oncemenos;
    }

    public function edit2($id)
    {
        //
        $provincias=Provincias::orderBy('descripcion','asc')->get();
        $padron=Padron::find($id);
        if($padron->localidad>0){
        $provincia=Localidades::find($padron->localidad)->provincia;}
        else{$provincia=1;}
        return view('/padron/editar2',compact('padron','provincias','provincia'));
    }

    public function update2(Request $request)
    {
        //

        Padron::find($request->id)->update(['domicilio_calle' => $request->domicilio_calle,'domicilio_numero' => $request->domicilio_numero,'domicilio_piso' => $request->domicilio_piso, 'domicilio_departamento' => $request->domicilio_departamento, 'domicilio_pais' => $request->domicilio_pais,'localidad' => $request->localidad,'domicilio_codigopostal' => $request->domicilio_codigopostal]);
        return redirect('padron/editar3/'.$request->id);   
    }

    public function edit3($id)
    {
        //
        $padron=Padron::find($id);
        return view('/padron/editar3',compact('padron'));
    }

     public function update3(Request $request)
    {
        //
        $paciente=Padron::find($request->id);
        $paciente->update(['cobertura' => $request->cobertura,'plan' => $request->plan,'afiliado' => $request->afiliado, 'iva' => $request->iva, 'estado' => $request->estado,'observaciones' => $request->observaciones,'ds_1'=>$request->ds_1, 'hora_1' => $request->hora_1, 'ds_2'=>$request->ds_2, 'hora_2' => $request->hora_2,'modalidad' => $request->modalidad]);
        if($request->discapacidad=="on"){$paciente->update(['discapacidad' => 1]);};
        
        return redirect('/pacientes');   
    }

    public function traer(string $texto){
        $pacientes=Padron::whereRaw("estado=1 and (apellido like'".$texto."%' or nombre like '".$texto."%')")->select('id','apellido','nombre','cobertura')->orderBy('apellido','asc')->orderBy('nombre','asc')->get();
        $t="";
        foreach($pacientes as $item){
            $t=$t."<tr><td>".$item->apellido.", ".$item->nombre."</td><td>";
            if($item->cobertura=="1"){$t=$t."Particular";} else {$t=$t."CMMatanza";};
            $t=$t."</td><td><input class='form-control' type='checkbox' id='".$item->id."' onclick='asigna(this.id)'></td></tr>";
        };
        return $t;
    }    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Padron  $padron
     * @return \Illuminate\Http\Response
     */
    public function destroy(Padron $padron)
    {
        //
    }

}
