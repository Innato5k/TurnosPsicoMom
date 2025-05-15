@extends('layouts.app')
@section('content')
<div class="container">
	<form class="form-inline" method="post" action="/reportes/cumples">
	{{ csrf_field() }}
	<div class="form-group has-warning">
		<label class="label-form">Mes</label>
		<select class="form-control" name="mes" id="mes">
			<option value="01">Enero</option>
			<option value="02">Febrero</option>
			<option value="03">Marzo</option>
			<option value="04">Abril</option>
			<option value="05">Mayo</option>
			<option value="06">Junio</option>
			<option value="07">Julio</option>
			<option value="08">Agosto</option>
			<option value="09">Septiembre</option>
			<option value="10">Octubre</option>
			<option value="11">Noviembre</option>
			<option value="12">Diciembre</option>
		</select>	
	</div>
	<button class="btn-success">Excel</button>
	</form>	
</div>
<script>
	window.onload = function() {
		document.getElementById('mes').focus();
	}	
</script>
@endsection
