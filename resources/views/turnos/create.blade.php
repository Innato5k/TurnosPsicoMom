@extends('layouts.app')
@section('content')
<div class="container">
<h2>Generación de Turnos</h2>
<p class="text-warning">Este proceso crea los horarios para un nuevo mes. Para aquellos pacientes que tienen horarios habituales, también asigna los turnos correspondientes.<br> Se recomienda generar turnos a lo sumo para el próximo mes</p>
<form class="form-inline" method="post" action="/turnos/generar">
	{{ csrf_field() }}
	<div class="form-group has-warning">
		<label class="label-form">Año</label>
		<input class="form-control" name="anio" type="number" min="2023" max="2033" value="{{$anio}}" required autofocus>
	</div>
	&nbsp;&nbsp;	
	<div class="form-group has-warning">
		<label class="label-form">Mes</label>
		<select class="form-control" name="mes" id="mes">
			<option value="1">Enero</option>
			<option value="2">Febrero</option>
			<option value="3">Marzo</option>
			<option value="4">Abril</option>
			<option value="5">Mayo</option>
			<option value="6">Junio</option>
			<option value="7">Julio</option>
			<option value="8">Agosto</option>
			<option value="9">Septiembre</option>
			<option value="10">Octubre</option>
			<option value="11">Noviembre</option>
			<option value="12">Diciembre</option>
		</select>	
	</div>
	<button class="btn-primary">Generar</button>
	</form>	
</div>
<script>
	window.onload = function() {
		seleccionar("mes","{{$mes+1}}");
	}	
</script>
@endsection
