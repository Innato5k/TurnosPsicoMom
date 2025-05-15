<?php

namespace App\Http\Controllers;

use App\Provincias;
use Illuminate\Http\Request;

class ProvinciasController extends Controller
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
        $provincias=Provincias::orderBy('descripcion','asc')->get();
        return view('/provincias/index',compact('provincias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('/provincias/create');
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
         //
        $provincia=Provincias::create($request->all());
        return redirect('/provincias');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Provincias  $provincias
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $provincia=Provincias::find($id);
        return view('/provincias/eliminar',compact('provincia'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Provincias  $provincias
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $provincia=Provincias::find($id);
        return view('/provincias/edit',compact('provincia'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Provincias  $provincias
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        Provincias::find($request->id)->update(["descripcion" => $request->descripcion]);
        return redirect('/provincias');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provincias  $provincias
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        Provincias::find($request->id)->delete();
        return redirect('/provincias');
        
    }
}
