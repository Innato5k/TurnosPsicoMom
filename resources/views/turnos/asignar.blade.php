@extends('layouts.app')
@section('content')
<div class="container">
<h2>Asignar un turno</h2>	
<h3>{{$fecha->dia_semana}} {{ffec($turno->fecha)}} a las {{substr($turno->hora,0,5)}} hs.</h3>

@if($ant!=null)
  <p class='text-warning'><strong>Atención. Turno habitual de {{$ant->apellido.", ".$ant->nombre}}</strong></p>
@endif
<h3>Paciente: {{$paciente->apellido.", ".$paciente->nombre." ".estado($paciente->estado)}}</h3>
	<form class="form" method="post" action="/turnos/asignar">
	{{ csrf_field() }}
	<div class="form-group has-warning">
		<label class="label-form" for="modalidad">Modalidad de Atención</label>
		<select class="form-control" id="modalidad" name="modalidad" required>
			<option value="1">Presencial</option>
			<option value="2">Virtual</option>		
		</select>
	</div>
	
	
	
	<div class="form-group has-warning">
		<label class="label-form" for="cobertura">Cobertura</label>
		<select class="form-control" id="cobertura" name="cobertura" required>
			<option value="1">Particular</option>
			<option value="2">O.Social</option>
		</select>
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="copago">Desea Reservar Próxima Media Hora también?</label>
		<input class="form-control" type="checkbox" name="copago">
	</div>	
	<div class="form-group has-warning">
		<label class="label-form" for="replicar">Desea Replicar en el Mes?</label>
		<input class="form-control" type="checkbox" {{esconder($paciente->estado,$ant)}} name="replicar">
	</div>	
	<div class="form-group has-warning">
		<label class="label-form" for="habitual">Desea Registrar este horario como Turno Habitual</label>
		<input class="form-control" type="checkbox" name="habitual" {{esconder($paciente->estado,$ant)}}>
	</div>	
	<input hidden name="id" value="{{ $turno->id }}">
	<input hidden name="paciente" value="{{ $paciente->id }}">
	<button class="form-control btn-primary" type="submit">Asignar</button>
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
        seleccionar("cobertura","{{$paciente->cobertura}}");
		document.getElementById("modalidad").focus();
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
	function cobertura($c){
		if($c==1){return "Particular";};
		if($c==2){return "CM Matanza";};
	}
	function esconder($e,$ant){
		if($e!=1 && $e!=3) {return "disabled";};
		if($ant!=null) {return "disabled";};
		return "";
	}
	function estado($e){
		if($e==1){return "Frec.Semanal";};
		if($e==2){return "Inactivo";};
		if($e==3){return "Frec.Quincenal";};
	}
?>