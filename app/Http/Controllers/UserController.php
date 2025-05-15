<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
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
        $usuarios=User::orderBy('name','asc')->get();
        return view('users/index',compact('usuarios'));
    }

   /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
       $usuario=User::find($id);
       return view('users/edit',compact('usuario'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        User::where('id',$request->id)->update(["name" => $request->name,"email" => $request->email,"cuil" => $request->cuil, "tipo" => $request->tipo,]);
        return redirect('/usuarios/');
   
    }

    public function eliminar($id){
        $usuario=User::find($id);
        return view("users/eliminar",compact('usuario'));
    }

    public function destroy(Request $request)
    {
        //
        User::find($request->id)->delete();
        return redirect('/usuarios/');
    }
}
