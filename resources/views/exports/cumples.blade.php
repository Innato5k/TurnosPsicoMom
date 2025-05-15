<div class="container">
<h2>Cumpleaños Mes {{$mes}}</h2>
<div class="table-responsive">
<table class="table">
	<thead>
		<tr class="bg-primary"><th>Apellido</th><th>Nombre</th><th>F.Nacimiento</th><th>Años</th><th>Teléfono Celular</th><th>Email</th></tr>
	</thead>
	
	<tbody>	
    @foreach($registros as $item)
	  <tr><td>{{ $item->apellido }}</td><td>{{ $item->nombre }}</td><td>{{ffec($item->fecha_nacimiento)}}</td><td>{{edad($item->fecha_nacimiento,$anio)}}</td><td>{{$item->telefono_celular}}</td><td>{{$item->email}}</td></tr>
    @endforeach
</tbody>
</table>
</div>
</div>
<?php
function ffec($f){
	return substr($f,-2)."/".substr($f,5,2)."/".substr($f,0,4);
}
function edad($fn,$anio){
	return (intval($anio)-intval(substr($fn,0,4)));
}
?>