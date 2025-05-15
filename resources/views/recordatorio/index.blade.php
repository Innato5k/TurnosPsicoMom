@extends('layouts.app')
@section('content')
<div class="container">
<h2>Recordatorios de Turnos</h2>
<div class="table-responsive">
	<table class="table">
		<thead>	
		<tr class="bg-primary"><th>Apellido y Nombre</th><th>Email</th><th>Celular</th><th>Fecha</th><th>Hora</th><th>Modalidad</th><th>WhatsApp</th><th>Email</th><th>Estado</th></tr>
	</thead>
	<tbody id="tabla">
@foreach($turnos as $item)
	<tr><td>{{apynom($item)}}</td><td>{{email($item)}}</td><td>{{telefono($item)}}</td><td>{{$item->dia_semana." ".ffec($item->fecha)}}</td><td>{{substr($item->hora,0,5)}}</td><td>{{modalidad($item)}}</td><td><input class="checkbox" type="checkbox" id="w{{$item->id}}"></td><td><input class="checkbox" type="checkbox" id="m{{$item->id}}"></td><td></td></tr>

@endforeach

</tbody>
</table>
</div>
<button class="btn-success" onclick="procesar()">Procesar Notificaciones Seleccionadas</button>
<br>
<button class="btn-primary" onclick="finalizar()" disabled id="fina">Dar los turnos como notificados</button>
<hr>
<div class="row">
	<div class="md-3"></div>
	<div class="md-6">
	<var class="form-control" id="notificaciones"></var>
	</div>	

</div>
<?php 




function apynom($i){
	if($i->paciente>0){return $i->apellido.", ".$i->nombre;};
	return "S/D";
}
function email($i){
	if($i->paciente>0){return $i->email;};
	return "";
}
function telefono($i){
	if($i->paciente>0){return $i->celular;};
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
function procesar(){
	tabla=document.getElementById('tabla');
	for(i=0;i<tabla.rows.length;i++){
		celdas=tabla.rows[i].cells;
		twapp=celdas[6].innerHTML;
		tmail=celdas[7].innerHTML;
		id1wapp=twapp.indexOf("id=");
		id2wapp=twapp.indexOf(" class=");
		id1mail=tmail.indexOf("id=");
		id2mail=tmail.indexOf(" class=");
		idwapp=twapp.substr(id1wapp+4,id2wapp-id1wapp-5);
		idmail=tmail.substr(id1mail+4,id2mail-id1mail-5);
		if(document.getElementById(idwapp).checked){
			telefono=celdas[2].innerHTML;
			url="https://wa.me?phone="+telefono;
			tex="Estimado/a "+celdas[0].innerHTML+": le recuerdo que tenemos un turno agendado para una sesión "+celdas[5].innerHTML+" el próximo "+celdas[3].innerHTML+"  a las "+celdas[4].innerHTML;
			nn(url,tex);
			celdas[8].innerHTML="Wapp listo para enviar";	
		};
		if(document.getElementById(idmail).checked){
			email=celdas[1].innerHTML;
			if(email!=""){
				celdas[8].innerHTML=celdas[8].innerHTML+" - Mail "+ejec_sq("/recordatoriomail/ "+idmail.substr(1,10));
			}
		};
	};
	document.getElementById("fina").disabled=false;
}
function finalizar(){
	tabla=document.getElementById('tabla');
	celdas=tabla.rows[0].cells;
	fecha=celdas[3].innerHTML.substr(-10);
	fecha_ord=fecha.substr(-4)+fecha.substr(3,2)+fecha.substr(0,2);
	navega('/recordatorio/finalizar/'+fecha_ord);
}	
</script>

</div>
@endsection