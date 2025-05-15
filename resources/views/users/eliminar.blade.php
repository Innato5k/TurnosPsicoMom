@extends('layouts.app')
@section('content')
<div class="container">
<h2>Eliminar Usuario</h2>
<form class="form" method="post" action="/usuarios/eliminar_do">
	{{ csrf_field() }}
	{{ $usuario->name }}<br>
	<p class="text-primary">Si no estás seguro de Eliminar este Usuario, presioná (atrás)</p>
	<p class="text-warning">Al presionar (Eliminar) se eliminará definitivamente este Usuario</p>
	
	<input hidden name="id" value="{{ $usuario->id }}">
	<button class="form-control btn-danger" type="submit">Eliminar</button>
</form>
</div>
@endsection