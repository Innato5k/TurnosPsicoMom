@extends('layouts.app')
@section('content')
<div class="container">
<h2>Buscar Turnos Disponibles</h2>
<form class="form-inline" method="post" action="/turnos/disponibles">
	{{ csrf_field() }}
	<div class="form-group has-warning">
		<label class="label-form">Desde hora</label>
		<input class="form-control" name="desde" type="time" required>
	</div>
	&nbsp;&nbsp;	
	<div class="form-group has-warning">
		<label class="label-form">Hasta hora</label>
		<input class="form-control" name="hasta" type="time" required>
	</div>
	
	<button class="btn-primary">Buscar</button>
	</form>
	<hr>
<div class="row">
	<div class="md-3"></div>
	<div class="md-6">
	<var class="form-control" id="notificaciones"></var>
	</div>	
</div>		
</div>
<script>
	window.onload = function() {
		var myVar=setInterval(function(){Chequea()},10000);
        document.getElementById("datos_pr").innerHTML=ejec_sq('/tablas/descripcion/DATOS_PROF/1')+" - "+ejec_sq('/tablas/descripcion/DATOS_PROF/2');
		

		document.getElementById('desde').focus();
	}	
</script>
@endsection
