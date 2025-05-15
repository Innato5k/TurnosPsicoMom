@extends('layouts.app')
@section('content')
<div class="container">
<h2>Seleccionar Mes</h2>
<form class="form" method="post" action="/padron/cumples">
	{{ csrf_field() }}
	<div class="form-group has-warning">
		<label class="label-form" for="mes">Mes</label>
		<select class="form-control" name="mes" id="mes" required autofocus>
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
			<option value="12">Diciembr</option>
		</select>
	</div>
	
	<button class="form-control btn-primary" type="submit">Consultar</button>
</form>
</div>
@endsection
