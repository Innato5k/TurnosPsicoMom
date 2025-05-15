@extends('layouts.app')
@section('content')
<div class="container">
<h2>Localidades</h2>

<button class="btn btn-primary" onclick="navega('/localidades/nueva')">Nueva</button><br><br>
<div class="table-responsive">
	<form class="form-inline" method="post" action="/localidades/buscar">
		{{ csrf_field() }}
	<label class="label-form" for="frase">Filtro</label>
	<input class="form-control has-warning" name="frase" required size="30" maxlength="30">
	<button class="btn btn-small btn-warning">Buscar</button>
</form>
<table class="table">
	<thead>
		<tr class="bg-primary"><th>Id</th><th>Descripción</th><th>Provincia</th><th>Código Postal</th><th>Acciones</th></tr>
	</thead>
	
	<tbody>	
    @foreach($localidades as $item)
	  <tr><td>{{$item->id}}</td><td>{{ $item->descripcion }}</td><td>{{ $item->provincia }}</td><td>{{$item->codigo_postal}}</td><td><a class="btn btn-warning" title="Editar" href="/localidades/editar/{{ $item->id}}">Editar</a>&nbsp;
	  	<a class="btn btn-small btn-danger" title="Eliminar" href="/localidades/eliminar/{{ $item->id}}">Eliminar</a></td></tr>
    @endforeach
</tbody>
</table>
</div>
</div>

@endsection
