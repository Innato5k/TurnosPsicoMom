@extends('layouts.app')
@section('content')
<div class="container">
<h2>Repaso de Turnos</h2>
<form class="form-inline" method="post" action="/turnos/repaso">
	{{ csrf_field() }}
	<div class="form-group has-warning">
		<label class="label-form">Fecha</label>
		<input class="form-control" type="date" value="{{$fecha}}" name="fecha">
	</div>
	<button class="btn-primary">Consultar</button>
</form>	
<hr>	
<div class="table-responsive">
<table class="table table-bordered">
	<thead>
		<tr class="bg-primary"><th>Hora</th><th>Paciente</th><th>Modalidad</th><th>Cobertura</th><th>Asistió</th><th>Pagó</th><th>Acciones</th></tr>
	</thead>
	
	<tbody>	
	@if($fecha>$hoy)
		<tr><td></td><td>Fecha No Alcanzada</td></tr>	
	@else	
    @foreach($turnos as $item)
      
     <tr><td>{{substr($item->hora,0,5)}}</td><td>{{apynom($item)}}</td><td>{{modalidad($item)}}</td><td>{{cobertura($item)}}</td>
     @if($item->asistencia==1)
     	<td class="bg-success"><strong>A S I S T I Ó</strong></td>
     @else
         <td class="bg-danger"><strong>NO ASISTIÓ</strong></td>
     @endif
     
     @if($item->pago==1)	
     	<td class="bg-success"><strong>P A G Ó</strong></td>
     @else
        <td class="bg-danger"><strong>NO PAGÓ</strong></td>
     @endif	

     </td><td>
	  	@if($item->fecha>$hoy)
	  	@else
	  	    @if($item->asistencia=="1")
	  	    	<button class="btn-primary btn-sm" onclick="navega('/turnos/asistencia2/{{$item->id}}')">Rectificar. No Asistió</button>&nbsp;&nbsp;
	  	    @else
	  	  		<button class="btn-success btn-sm" onclick="navega('/turnos/asistencia2/{{$item->id}}')">Asistió</button>&nbsp;&nbsp;
	  	  	@endif	
	  	    @if($item->pago=="1")
	  	    	<button class="btn-primary btn-sm" onclick="navega('/turnos/pago2/{{$item->id}}')">Rectificar. No Pagó.</button>
	  	    @else	
	  	  		<button class="btn-success btn-sm" onclick="navega('/turnos/pago2/{{$item->id}}')">Pagó</button>
	  	  	@endif	
	  @endif
	  </td></tr>
    @endforeach
    @endif
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

function modalidad($i){
	if($i->modalidad==1){return "Presencial";};
	if($i->modalidad==2){return "Virtual";};
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