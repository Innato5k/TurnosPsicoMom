@extends('layouts.app')
@section('content')
<div class="container">
<h2>Eliminar Provincia</h2>
<form class="form" method="post" action="/provincias/eliminar">
	{{ csrf_field() }}
	{{ $provincia->descripcion }}<br>
	<p class="text-primary">Si no estás seguro de Eliminar esta Provincia, presioná (atrás)</p>
	<p class="text-warning">Al presionar (Eliminar) se eliminará definitivamente esta Provincia</p>
	
	<input hidden name="id" value="{{ $provincia->id }}">
	<button class="form-control btn-danger" type="submit">Eliminar</button>
</form>
</div>
@endsection