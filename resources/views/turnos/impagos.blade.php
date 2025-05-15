@extends('layouts.app')
@section('content')
<div class="container">
<h2>Consultas Impagas</h2>
<form class="form-inline" method="post" action="/turnos/impagos">
	{{ csrf_field() }}
	<div class="form-group has-warning">
		<label class="label-form">Desde la Fecha</label>
		<input class="form-control" type="date" value="{{$fecha}}" name="fecha">
	</div>
	<button class="btn-primary">Consultar</button>
</form>	
<hr>	
<div class="table-responsive">
<table class="table table-bordered">
	<thead>
		<tr class="bg-primary"><th>Fecha</th><th>Hora</th><th>Paciente</th><th>Celular</th><th>Cobertura</th><th>Acciones</th></tr>
	</thead>
	
	<tbody>	
	@foreach($turnos as $item)
      
     <tr><td>{{$item->dia_semana." ".ffec($item->fecha)}}</td><td>{{substr($item->hora,0,5)}}</td><td>{{apynom($item)}}</td><td>{{$item->celular}}</td><td>{{cobertura($item)}}</td>
     <td>
	  	@if($item->fecha>$hoy)
	  	@else
	  	       <?php
	  	        $apynom=apynom($item);
	  	        $celular="549".$item->celular;
	  	        $fech=$item->dia_semana.' '.ffec($item->fecha);
	  	        $hora=substr($item->hora,0,5);
	  	       ?>
	  	  		<button class="btn-success btn-sm" onclick="navega('/turnos/pago4/{{$item->id}}')">Pagó</button>
	  	  		<button class="btn-warning btn-sm" onclick='notifica("{{$apynom}}","{{$celular}}","{{$fech}}","{{$hora}}")'>Notificar</button>
	    @endif
	  </td></tr>
    @endforeach
    
</tbody>
</table>
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
function notifica(apynomb,celular,fecha,hora){
	t="Estimado/a "+apynomb+":  Solicito tenga a bien enviar el comprobante de pago de sesión  realizada el día "+fecha+"  a las "+hora+" hs. Saludos. Lic.Graciela Careri";
	nn_null("https://wa.me?phone="+celular,t);
}
</script>
<hr>
<div class="row">
	<div class="md-3"></div>
	<div class="md-6">
	<var class="form-control" id="notificaciones"></var>
	</div>	

</div>
</div>

<?php 
function apynom($i){
	if($i->paciente>0){return $i->apellido.", ".$i->nombre;};
	return "S/D";
}


function cobertura($i){
	if($i->cobertura==1){return "Particular";};
	if($i->cobertura==2){return "CM Matanza";};
}

function ffec($f){
		return substr($f,-2)."/".substr($f,5,2)."/".substr($f,0,4);
	}
?>
@endsection