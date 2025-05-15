<?php

namespace App\Http\Controllers;

use App\Tablas;
use Illuminate\Http\Request;

class TablasController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

     public function opciones($tipo){
        $tablas=Tablas::where('tipo',$tipo)->orderBy('descripcion','asc')->get();
        $opciones="";
        foreach($tablas as $item){
            $opciones=$opciones."<option value='".$item->valor."'>".$item->descripcion."</option>";
        };    
        return $opciones;
    }

    public function descripcion($tipo,$valor){
        $tablas=Tablas::where([['tipo',$tipo],['valor',$valor]])->get();
        return $tablas[0]->descripcion;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tablas  $tablas
     * @return \Illuminate\Http\Response
     */
    public function show(Tablas $tablas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tablas  $tablas
     * @return \Illuminate\Http\Response
     */
    public function edit(Tablas $tablas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tablas  $tablas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tablas $tablas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tablas  $tablas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tablas $tablas)
    {
        //
    }
}
