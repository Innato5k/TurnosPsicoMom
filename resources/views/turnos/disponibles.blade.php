@extends('layouts.app')
@section('content')
<div class="container">
<h2>Turnos Disponibles</h2>


<div class="table-responsive">
<table class="table">
	<thead>
		<tr class="bg-primary"><th>Día Semana</th><th>Fecha</th><th>Hora</th><th>Habitual de Quincenal</th><th>Acciones</th></tr>
	</thead>
	
	<tbody>	
    @foreach($turnos as $item)
    <tr><td>{{$item->dia_semana}}</td><td>{{ffec($item->fecha)}}</td> <td>{{substr($item->hora,0,5)}}</td><td>{{$item->quincenal}}</td><td>
	  		<button class="btn-success" onclick="navega('/turnos/preasignar/{{$item->id}}')">Asignar</button>
	  		<button class="btn-danger" onclick="navega('/turnos/bloquear/{{$item->id}}')">Bloquear</button></td></tr>
    @endforeach
</tbody>
</table>
</div>
<hr>
<div class="row">
	<div class="md-3"></div>
	<div class="md-6">
	<var class="form-control" id="notificaciones"></var>
	</div>	
</div>	
</div>
<script type="text/javascript">
	window.onload=function(){
		var myVar=setInterval(function(){Chequea()},10000);
        document.getElementById("datos_pr").innerHTML=ejec_sq('/tablas/descripcion/DATOS_PROF/1')+" - "+ejec_sq('/tablas/descripcion/DATOS_PROF/2');
	}
	function Chequea(){
    resp=ejec_sq("/turnos/actual");
    if(resp!=""){document.getElementById("notificaciones").innerHTML=resp;};
}
function confirmar(id){
    ejec_sq("/turnos/asistencia/"+id);
    document.getElementById("notificaciones").innerHTML="";   
}
</script>

@endsection
<?php 
function ffec($f){
		return substr($f,-2)."/".substr($f,5,2)."/".substr($f,0,4);
	}
?>