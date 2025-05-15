@extends('layouts.app')
@section('content')
<div class="container">
<h2>Exportar el Padrón a Excel</h2>
<form class="form col-md-6" method="post" action="/padron/exportar">
	{{ csrf_field() }}
	<div class="form-check mb-2 has-warning">
		<label class="label-form" for="bajas">Incluir Bajas</label>
		<input class="form-control" type="checkbox" name="bajas" id="bajas">
	</div>
	<button class="form-control btn-success" type="submit">Exportar</button>
</form>
</div>
@endsection
