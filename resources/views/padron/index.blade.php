@extends('layouts.app')
@section('content')
<div class="container">
<h2>Resultado de la Búsqueda</h2>
<?php
	$anio_hoy=anio_hoy();
	$mes_hoy=mes_hoy();
	$dia_hoy=dia_hoy();

?>
<button class="btn btn-primary" onclick="navega('/padron/nuevo')">Nuevo</button><br><br>
<div class="table-responsive">
	
<table class="table">
	<thead>
		<tr class="bg-primary"><th>Id</th><th>Apellido</th><th>Nombre</th><th>DNI</th><th>Edad</th><th>Teléfono</th><th>Email</th><th>Cobertura</th><th>Estado</th><th>Acciones</th></tr>
	</thead>
	
	<tbody>	
    @foreach($registros as $item)
	  @if($item->estado=="2")
	  	<tr class="bg-danger">
	  @else
	  	<tr>		
	  @endif
	  <td>{{$item->id}}</td><td>{{ $item->apellido }}</td><td>{{ $item->nombre }}</td><td>{{$item->dni}}</td><td>{{edad($item->fecha_nacimiento)}}</td>
	  <td>{{$item->telefono_celular}}</td><td>{{$item->email}}</td>
	  <td>{{cobertura($item)}}</td><td>{{estado($item)}}</td>
	  <td><a class="btn-sm btn-success" title="Ver" href="/padron/ver/{{ $item->id}}">Ver</a>&nbsp;
	  	<a class="btn-sm btn-warning" title="Editar" href="/padron/editar/{{ $item->id}}">Editar</a>&nbsp;
	  	<a class="btn-sm btn-info" title="Informe" href="/padron/informe/{{ $item->id}}">Informe</a>&nbsp;
	    <a class="btn-sm btn-primary" title="Turnos" href="/padron/turnos/{{ $item->id}}">Turnos</a>&nbsp;
	  
	  </td></tr>
	  	
    @endforeach
</tbody>
</table>
</div>
</div>
<?php
function edad($f){
	$anio=substr($f,0,4);
	$mes=substr($f,5,2);
	$eda=anio_hoy()-$anio;
	$dia=substr($f,-2);
	if($mes>mes_hoy()){$eda=$eda-1;};
	if($mes==mes_hoy() && $dia>dia_hoy()){$eda=$eda-1;};
	return $eda;
}
function anio_hoy(){
	$data = DB::select( DB::raw('SELECT year(NOW()) AS anio') );
	return $data[0]->anio;
}
function mes_hoy(){
	$data = DB::select( DB::raw('SELECT month(NOW()) AS mes') );
	return $data[0]->mes;
}
function dia_hoy(){
	$data = DB::select( DB::raw('SELECT day(NOW()) AS dia') );
	return $data[0]->dia;
}
function cobertura($i){
	if($i->cobertura==1){return "Particular";};
	if($i->cobertura==2){return "CM Matanza";};
}
function estado($i){
	if($i->estado==1){return "Frec.Semanal";};
	if($i->estado==2){return "Inactivo";};
	if($i->estado==3){return "Frec.Quincenal";};
}
?>
@endsection