@extends('layouts.app')
@section('content')
<div class="container">
<h2>Registrar Rápidamente un Pago</h2>
<form class="form" method="post" onsubmit="return false">
	{{ csrf_field() }}
	<div class="form-group has-warning">
		<label class="label-form" for="paciente">Paciente</label>
		<input class="form-control" name="paciente" id="paciente" maxlength="
		30"  required>
	</div>
	<button class="btn-success" onclick="llena_tabla()">Consultar</button>
	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr class="bg-primary"><th>Paciente</th><th>Fecha</th><th>Hora</th><th>Cobertura</th><th>Seleccionar</th></tr>
			</thead>
			<tbody id="tabla">
			</tbody>	
		</table>	
	</div>	
	
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
        document.getElementById("paciente").focus();
	}
	function Chequea(){
    resp=ejec_sq("/turnos/actual");
    if(resp!=""){document.getElementById("notificaciones").innerHTML=resp;};
	}
	function confirmar(id){
    	ejec_sq("/turnos/asistencia/"+id);
    	document.getElementById("notificaciones").innerHTML="";   
	}

	function llena_tabla(){
		document.getElementById("tabla").innerHTML=ejec_sq("/turnos/buscapagos/"+document.getElementById('paciente').value);
	}
	function paga(id){
		ejec_sq("/turnos/pago3/"+id);
		llena_tabla();
	}
</script>
@endsection
<?php
	function ffec($f){
		return substr($f,-2)."/".substr($f,5,2)."/".substr($f,0,4);
	}
?>