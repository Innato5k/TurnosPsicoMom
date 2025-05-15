@extends('layouts.app')
@section('content')
<div class="container">
<h2>Nueva Provincia</h2>
<form class="form" method="post" action="/provincias/nueva">
	{{ csrf_field() }}
	<div class="form-group has-warning">
		<label class="label-form" for="descripcion">Descripción</label>
		<input class="form-control" size="100" maxlength="100" name="descripcion" id="descripcion" required autofocus>
	</div>
	<button class="form-control btn-primary" type="submit">Crear</button>
</form>
</div>
@endsection
