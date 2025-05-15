@extends('layouts.app')
@section('content')
<div class="container">
<h2>Recordatorios de Turnos</h2>
<div class="table-responsive">
	<table class="table">
		<tr class="bg-primary"><th>Apellido y Nombre</th><th>Teléfono</th><th>Fecha</th><th>Hora</th><th>Modalidad</th><th>Enviar</th></tr>
@foreach($turnos as $item)
	<tr><td>{{apynom($item)}}</td><td>{{telefono($item)}}</td><td>{{ffec($item->fecha)}}</td><td>{{substr($item->hora,0,5)}}</td><td>{{modalidad($item)}}</td><td><button class="btn-sm btn-success" onclick='nn("{{not_url($item)}}","{{not_tex($item)}}")'>Enviar</button></td></tr>
@endforeach
</table>
</div>
<hr>
<div class="row">
	<div class="md-3"></div>
	<div class="md-6">
	<var class="form-control" id="notificaciones"></var>
	</div>	

</div>
<?php 
function not_url($i){
	if($i->paciente>0){
		$url="https://wa.me?phone=".$i->pac_telefono;
	}
	else{
		$url="https://wa.me?phone=".$i->npac_telefono;
	};
	return $url;
}	
function not_tex($i){
	$t="Estimado/a ".apynom($i).": le recuerdo que tenemos un turno agendado para una sesión ".modalidad($i)." el próximo ".$i->dia_semana." ".ffec($i->fecha).
        "  a las ".substr($i->hora,0,5)." Saludos. Lic. Graciela Careri";
    return $t;     
}

function apynom($i){
	if($i->paciente>0){return $i->apellido.", ".$i->nombre;};
	return "S/D";
}
function telefono($i){
	if($i->paciente>0){return $i->telefono;};
	return "";
}

function modalidad($i){
	if($i->modalidad==1){return "Presencial";};
	if($i->modalidad==2){return "Virtual";};
}
function ffec($f){
		return substr($f,-2)."/".substr($f,5,2)."/".substr($f,0,4);
	}
?>
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