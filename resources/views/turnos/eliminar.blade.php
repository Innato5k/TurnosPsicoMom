@extends('layouts.app')
@section('content')
<div class="container">
<h2>Eliminar Situación de Revista</h2>
<form class="form" method="post" action="/s_revistas/eliminar">
	{{ csrf_field() }}
	{{ $situacion->descripcion }}<br>
	<p class="text-primary">Si no estás seguro de Eliminar esta Situación de Revista, presioná (atrás)</p>
	<p class="text-warning">Al presionar (Eliminar) se eliminará definitivamente esta Situación de Revista</p>
	
	<input hidden name="id" value="{{ $situacion->id }}">
	<button class="form-control btn-danger" type="submit">Eliminar</button>
</form>
</div>
@endsection