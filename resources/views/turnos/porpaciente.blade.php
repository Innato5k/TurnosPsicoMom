@extends('layouts.app')
@section('content')
<div class="container">
<h2>Turnos del Paciente</h2>
<h3>{{$paciente->apellido.", ".$paciente->nombre}}</h3>

<div class="table-responsive">
<table class="table">
	<thead>
		<tr class="bg-primary"><th>Día Semana</th><th>Fecha</th><th>Hora</th><th>Modalidad</th><th>Cobertura</th></tr>
	</thead>
	
	<tbody>	
    @foreach($turnos as $item)
    <tr><td>{{$item->dia_semana}}</td><td>{{ffec($item->fecha)}}</td> <td>{{substr($item->hora,0,5)}}</td><td>{{modalidad($item)}}</td><td>{{cobertura($item)}}</td></tr>
	  		
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


<?php 
function ffec($f){
		return substr($f,-2)."/".substr($f,5,2)."/".substr($f,0,4);
	}
function cobertura($i){
	if($i->cobertura==1){return "Particular";};
	if($i->cobertura==2){return "CM Matanza";};
}
function modalidad($i){
	if($i->modalidad==1){return "Presencial";};
	if($i->modalidad==2){return "Virtual";};
}	
?>
@endsection