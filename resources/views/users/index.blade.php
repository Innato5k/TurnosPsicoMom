@extends('layouts.app')
@section('content')

<div class="container">
<h2>Usuarios</h2>
<button class="btn btn-primary" onclick="navega('register')">Nuevo</button><br><br>
<div class="table-responsive">
<table class="table">
	<thead>
		<tr class="bg-primary"><th>Apellido y Nombre</th><th>CUIL</th><th>Tipo Usuario</th><th>Acciones</th></tr>
	</thead>
	<tbody>	
    @foreach($usuarios as $item)
    <?php
     switch ($item->tipo) {
      case 1:
        $d_tipo="Final";
        break;
      case 3:
        $d_tipo="Administrador";
        break; 
     };
     ?>
     <tr><td>{{ $item->name }}</td><td>{{ $item->cuil }}</td><td>{{ $d_tipo }}</td><td><a class="btn btn-warning" title="Editar" href="usuarios/editar/{{ $item->id }}">Editar</a>&nbsp;<a class="btn btn-danger" title="Eliminar" href="usuarios/eliminar/{{ $item->id }}">Eliminar</a>&nbsp;</td></tr>
@endforeach
</tbody>
</table>
</div>
</div>
@endsection