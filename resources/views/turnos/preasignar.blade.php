@extends('layouts.app')
@section('content')
<div class="container">
<h2>Asignar un turno</h2>	
<h3>{{$fecha->dia_semana}} {{ffec($turno->fecha)}} a las {{substr($turno->hora,0,5)}} hs.</h3>

<form class="form" method="get" onsubmit="return false">
	{{ csrf_field() }}
	<div class="form-group has-warning">
		<label class="label-form" for="paciente">Paciente</label>
		<input class="form-control" name="paciente" id="paciente" maxlength="
		30"  required>
	</div>
	<input hidden name="id" value="{{ $turno->id }}">
	<button class="btn-success" onclick="llena_tabla()">Consultar</button>
</form>		
<div class="table-responsive">
	<table class="table">
		<thead>
			<tr class="bg-primary"><th>Paciente</th><th>Cobertura</th><th>Seleccionar</th></tr>
			</thead>
			<tbody id="tabla">
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
		document.getElementById("paciente").focus();
	}

function Chequea(){
    resp=ejec_sq("/turnos/actual");
    if(resp!=""){document.getElementById("notificaciones").innerHTML=resp;};
}
function confirmar(id){
    ejec_sq("/turnos/asistencia/"+id);
    document.getElementById("notificaciones").innerHTML="";   
}
function llena_tabla(){
		document.getElementById("tabla").innerHTML=ejec_sq("/pacientes/traer/"+document.getElementById('paciente').value);
}
function asigna(paciente){
	navega("/turnos/asignar/{{$turno->id}}/"+paciente);
}
</script>
@endsection
<?php
	function ffec($f){
		return substr($f,-2)."/".substr($f,5,2)."/".substr($f,0,4);
	}
	function cobertura($c){
		if($c==1){return "Particular";};
		if($c==2){return "CM Matanza";};
	}
?>