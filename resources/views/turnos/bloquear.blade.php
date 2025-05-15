@extends('layouts.app')
@section('content')
<div class="container">
<h2>Bloquear horarios desde {{$fecha->dia_semana}} {{ffec($turno->fecha)}} a las {{substr($turno->hora,0,5)}} hs.</h2>
<form class="form" method="post" action="/turnos/bloquear">
	{{ csrf_field() }}
	<div class="form-group has-warning">
		<label class="label-form" for="motivo_bloqueo">Motivo Bloqueo</label>
		<input class="form-control" name="motivo_bloqueo" id="motivo_bloqueo" maxlength="
		30" required>
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="hasta">Bloquear hasta (indicar media hora antes)</label>
		<input class="form-control" type="time" name="hasta" id="hasta">
	</div>
	
	<input hidden name="id" value="{{ $turno->id }}">
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
		document.getElementById("motivo_bloqueo").focus();
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