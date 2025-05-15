@extends('layouts.app')
@section('content')
<div class="container">
<h2>Eliminar Localidad</h2>
<form class="form" method="post" action="/localidades/eliminar">
	{{ csrf_field() }}
	{{ $localidad->descripcion }}<br>
	<p class="text-primary">Si no estás seguro de Eliminar esta Localidad, presioná (atrás)</p>
	<p class="text-warning">Al presionar (Eliminar) se eliminará definitivamente esta Localidad</p>
	<p class="text-danger">Por el momento el sistema no valida si la localidad está o no en uso</p>
	
	<input hidden name="id" value="{{ $localidad->id }}">
	<button class="form-control btn-danger" type="submit">Eliminar</button>
</form>
</div>
@endsection