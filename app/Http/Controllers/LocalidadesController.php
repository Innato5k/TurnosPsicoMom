<?php

namespace App\Http\Controllers;

use App\Localidades;
use App\Provincias;
use Illuminate\Http\Request;

class LocalidadesController extends Controller
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
    public function index()
    {
        //
        $localidades=Localidades::join('provincias','localidades.provincia','provincias.id')->orderBy('localidades.descripcion','asc')->orderBy('provincias.descripcion')->
            select('localidades.id','localidades.descripcion','provincias.descripcion as provincia', 'codigo_postal')->offset(0)->limit(20)->get();
        return view('/localidades/index',compact('localidades'));
   
    }

    public function buscar(Request $request){
        $localidades=Localidades::join('provincias','localidades.provincia','provincias.id')->
        where('localidades.descripcion','like','%'.$request->frase.'%')->orderBy('localidades.descripcion','asc')->orderBy('provincias.descripcion')->
            select('localidades.id','localidades.descripcion','provincias.descripcion as provincia', 'codigo_postal')->offset(0)->limit(20)->get();
        return view('/localidades/index',compact('localidades'));
   
    }
    public function opciones($provincia){
        $localidades=Localidades::where('provincia',$provincia)->orderBy('descripcion','asc')->orderBy('codigo_postal')->get();
        $opciones="";
        foreach($localidades as $item){
            $opciones=$opciones."<option value='".$item->id."'>".$item->descripcion." CP:".$item->codigo_postal."</option>";
        };    
        return $opciones;
   
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $provincias=Provincias::orderBy('descripcion','asc')->get();
        return view('/localidades/create',compact('provincias'));
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
        Localidades::create($request->all());
        return redirect('/localidades');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Localidades  $localidades
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $localidad=Localidades::find($id);
        // IMPORTANTE: FALTA CONTROLAR QUE NO SE USE EN EL PADRON
        return view('/localidades/eliminar',compact('localidad'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Localidades  $localidades
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $localidad=Localidades::find($id);
        $provincias=Provincias::orderBy('descripcion','asc')->get();
        return view('/localidades/edit',compact('localidad','provincias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Localidades  $localidades
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Localidades $localidades)
    {
        //
        Localidades::find($request->id)->update(["descripcion" => $request->descripcion,"provincia"=>$request->provincia,"codigo_postal"=>$request->codigo_postal]);
        return redirect('/localidades');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Localidades  $localidades
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        Localidades::find($request->id)->delete();
        return redirect('/localidades');
    }
}
