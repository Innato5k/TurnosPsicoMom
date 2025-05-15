@extends('layouts.app')
@section('content')
<div class="container">
<h2>Provincias</h2>

<button class="btn btn-primary" onclick="navega('/provincias/nueva')">Nueva</button><br><br>
<div class="table-responsive">
<table class="table">
	<thead>
		<tr class="bg-primary"><th>Id</th><th>Descripcion</th><th>Acciones</th></tr>
	</thead>
	
	<tbody>	
    @foreach($provincias as $item)
	  <tr><td>{{$item->id}}</td><td>{{ $item->descripcion }}</td><td><a class="btn btn-small btn-warning" title="Editar" href="/provincias/editar/{{ $item->id}}">Editar</a>&nbsp;<a class="btn btn-small btn-danger" title="Eliminar" href="/provincias/eliminar/{{ $item->id}}">Eliminar</a></td></tr>
    @endforeach
</tbody>
</table>
</div>
</div>
@endsection
