@extends('layouts.app')
@section('content')
<div class="container">
<h2>Turnos del día {{$ds}} {{ffec($fecha)}}</h2>


<div class="table-responsive">
<table class="table">
	<thead>
		<tr class="bg-info"><th>Hora</th><th>Estado</th><th>Paciente</th><th>Modalidad</th><th>Cobertura</th><th>Asistió</th><th>Pagó</th><th>Acciones</th></tr>
	</thead>
	
	<tbody>	
    @foreach($turnos as $item)
      @if($item->bloqueado)
      	<tr class="bg-danger text-danger">
      @elseif($item->paciente>0)
        <tr class="bg-info text-danger">
      @elseif($item->quincenal!="")
        	<tr class="bg-success text-danger">
      @else
	  <tr class="bg-primary">
	  @endif	

	  <td>{{substr($item->hora,0,5)}}</td><td>{{estado($item)}}</td><td>{{apynom($item)}}</td><td>{{modalidad($item)}}</td><td>{{cobertura($item)}}</td><td>{{asistio($item,$hoy)}}</td><td>{{pago($item,$hoy)}}</td><td>
	  	@if($item->fecha." ".$item->hora>=$hoy)
	  		
	  	 @if($item->bloqueado=='0' && $item->paciente=='')
	  		<button class="btn-success" onclick="navega('/turnos/preasignar/{{$item->id}}')">Asignar</button>
	  		<button class="btn-danger" onclick="navega('/turnos/bloquear/{{$item->id}}')">Bloquear</button>
	  	 @endif
	  	 @if($item->bloqueado=='1') 
	  		<button class="btn-primary" onclick="navega('/turnos/liberar/{{$item->id}}')">Liberar</button>
	  	 @endif
	  	 @if($item->bloqueado==0 && $item->paciente>0 )
	  	 		<button class="btn-warning" onclick="navega('/turnos/cancelar/{{$item->id}}')">Cancelar</button>
	  	 @endif
	  	@else
	  	  @if($item->paciente>0)
	  	  	<button class="btn-info btn-sm" onclick="navega('/turnos/asistencia/{{$item->id}}')">Asistencia</button>
	  	  		<button class="btn-warning btn-sm" onclick="navega('/turnos/pago/{{$item->id}}')">Pago</button>
	  	  	
	  	  @endif
      @endif
	  </td></tr>
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

</div>
@endsection
<?php 

function apynom($i){
	if($i->paciente>0){return $i->apellido.", ".$i->nombre;};
	if($i->quincenal!=""){return $i->quincenal;};
	return "";
}

function estado($i){
	if($i->paciente>0) {return "Asignado";};
	if($i->bloqueado==0 && $i->quincenal==""){ return "D I S P O N I B L E";};
	if($i->bloqueado==0 && $i->quincenal!=""){ return "DISPONIBLE - QUINCENAL ";};
	if($i->bloqueado==1){ return $i->motivo_bloqueo;};
}
function modalidad($i){
	if($i->modalidad==1){return "Presencial";};
	if($i->modalidad==2){return "Virtual";};
}
function cobertura($i){
	if($i->cobertura==1){return "Particular";};
	if($i->cobertura==2){return "CM Matanza";};
	if($i->cobertura==3){return "Copago";};
}
function asistio($i,$hoy){
	if($i->asistencia==1){return "Sí";};
	if($i->fecha<$hoy && $i->paciente>0){return "No";};
	return "";
}
function pago($i,$hoy){
	if($i->pago==1){return "Sí";};
	if($i->fecha<$hoy && $i->paciente>0 ){return "No";};
	return "";
}

function ffec($f){
		return substr($f,-2)."/".substr($f,5,2)."/".substr($f,0,4);
	}
?>