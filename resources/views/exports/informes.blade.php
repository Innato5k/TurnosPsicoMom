<div class="container">
<h4>Informe {{$paciente->apellido.", ".$paciente->nombre}}</h4>
<div class="table-responsive">
<table class="table">
	<thead>
		<tr class="bg-primary"><th>Tipo</th><th>Fecha</th><th>Hora</th><th>Modalidad</th><th>Cobertura</th><th>Asistencia</th><th>Pago</th><th>Reprogramado</th></tr>
	</thead>
	
	<tbody>	
    @foreach($registros as $item)
	  <tr><td>{{tipo($item)}}</td><td>{{ffec(substr($item->fecha,0,10))}}</td><td>{{substr($item->hora,0,5)}}</td><td>{{modalidad($item)}}</td><td>{{cobertura($item)}}</td><td>{{ asistencia($item)}}</td><td>{{pago( $item) }}</td><td>{{repro($item)}}</td></tr>
    @endforeach
</tbody>
</table>
</div>
</div>
<?php
function ffec($f){
	return substr($f,-2)."/".substr($f,5,2)."/".substr($f,0,4);
}
function tipo($i){
	if($i->tipo=='r') {return "Cancelación";};
	if($i->tipo=='t') {return "Turno";};
	return "";
}

function modalidad($i){
	if($i->modalidad==1){return "Presencial";};
	if($i->modalidad==2){return "Virtual";};
	return "";
}

function cobertura($i){
	if($i->cobertura==1){return "Particular";};
	if($i->cobertura==2){return "CM Matanza";};
	if($i->cobertura==3){return "Copago";};
}

function asistencia($i){
	if($i->asistencia==1){return "Asistió";};
	return "";
}
function pago($i){
	if($i->pago==1){return "¨Pagó";};
	return "";
}
function repro($i){
	if($i->tipo=='r' && $i->reprogramado=="1"){return "Sí";};
	if($i->tipo=='r' && $i->reprogramado=="0"){return "No";};
	return "";
}
?>