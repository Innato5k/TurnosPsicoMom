<div class="container">
<h4>Cancelaciones de Turnos {{$mes." ".$anio}}</h4>
<div class="table-responsive">
<table class="table">
	<thead>
		<tr class="bg-primary"><th>Fecha</th><th>Hora</th><th>Paciente</th><th>Modalidad</th><th>Cobertura</th><th>Discapacidad</th><th>Motivo</th><th>Reprogramado</th></tr>
	</thead>
	
	<tbody>	
    @foreach($turnos as $item)
	  <tr><td>{{ffec(substr($item->fecha,0,10))}}</td><td>{{substr($item->hora,0,5)}}</td><td>{{paciente($item)}}</td><td>{{modalidad($item)}}</td><td>{{cobertura($item)}}</td><td>{{discapacidad($item)}}</td><td>{{ $item->dmotivo}}</td><td>{{ sino($item->reprogramado)}}</td></tr>
    @endforeach
</tbody>
</table>
</div>
</div>
<?php
function ffec($f){
	return substr($f,-2)."/".substr($f,5,2)."/".substr($f,0,4);
}
function sino($n){
	if($n=="1"){return "SI";};
	return "NO";
}
function paciente($i){
	if($i->paciente>'0') {return $i->apellido.", ".$i->nombre;};
	return "S/D";
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
function discapacidad($i){
	if($i->discapacidad==1){return "Discapacidad";};
	return "";
}
?>