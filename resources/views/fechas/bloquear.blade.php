@extends('layouts.app')
@section('content')
<div class="container">
<h2>Bloquear fecha {{$fecha->dia_semana}} {{ffec($fecha->fecha)}}</h2>
<form class="form" method="post" action="/calendario/bloquear">
	{{ csrf_field() }}
	<div class="form-group has-warning">
		<label class="label-form" for="observaciones">Observaciones</label>
		<input class="form-control" name="observaciones" id="observaciones" maxlength="
		30" required>
	</div>
	
	<input hidden name="id" value="{{ $fecha->id }}">
	<button class="form-control btn-primary" type="submit">Bloquear</button>
</form>
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
		document.getElementById("observaciones").focus();
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