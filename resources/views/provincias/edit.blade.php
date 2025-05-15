@extends('layouts.app')
@section('content')
<div class="container">
<h2>Editar Provincia</h2>
<form class="form" method="post" action="/provincias/editar">
	{{ csrf_field() }}
	<div class="form-group has-warning">
		<label class="label-form" for="descripcion">Descripción</label>
		<input class="form-control" size="100" maxlength="100" name="descripcion" id="descripcion" value="{{ $provincia->descripcion }}" required autofocus>
	</div>
	<input hidden name="id" value="{{ $provincia->id }}">
	<button class="form-control btn-primary" type="submit">Modificar</button>
</form>
</div>
@endsection