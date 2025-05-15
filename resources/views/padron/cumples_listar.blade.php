@extends('layouts.app')
@section('content')
<div class="container">
<h2>Cumpleaños Mes {{$mes}}</h2>
<button class="btn btn-success" onclick="navega('/cumples/descargar/{{$mes}}')">Excel</button>
<div class="table-responsive">
<table class="table">
	<thead>
		<tr class="bg-primary"><th>Grado</th><th>Apellido</th><th>Nombre</th><th>F.Nacimiento</th><th>Años</th><th>Teléfono Fijo</th><th>Teléfono Celular</th><th>Email</th></tr>
	</thead>
	
	<tbody>	
    @foreach($registros as $item)
	  <tr><td>{{ grado($item->jerarquia,$item->sit_revista)}}</td><td>{{ $item->apellido }}</td><td>{{ $item->nombre }}</td><td>{{ffec($item->nacimiento_fecha)}}</td><td>{{$item->anios}}</td><td>{{$item->telefono_fijo}}</td><td>{{$item->telefono_celular}}</td><td>{{$item->email}}</td></tr>
    @endforeach
</tbody>
</table>
</div>
</div>
<?php
function ffec($f){
	return substr($f,-2)."/".substr($f,5,2)."/".substr($f,0,4);
}
function grado($j,$s){
	$grado=$j;
	if($s!='NO CORRESPONDE'){$grado=$grado.' ('.$s.')';};
	return $grado;
}
?>
@endsection