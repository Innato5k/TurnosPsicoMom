<div class="container">
<h4>Listado Pacientes {{ffec($hoy)}}</h4>
<div class="table-responsive">
<table class="table">
	<thead>
		<tr class="bg-primary"><th>id</th><th>Apellidos</th><th>Nombres</th><th>Fecha_Nacimiento</th><th>Edad</th><th>Sexo</th><th>DNI</th><th>CUIL/CUIT</th><th>dom_calle</th><th>dom_nro</th><th>dom_piso</th><th>dom_dto</th><th>dom_cPostal</th><th>dom_localidad</th><th>dom_provincia</th><th>te_celular</th><th>e_mail</th><th>Cobertura</th><th>Plan</th><th>Afiliado</th><th>Discapacidad</th><th>Modalidad</th><th>DSemana1</th><th>Hora1</th><th>DSemana2</th><th>Hora2</th><th>Iva</th><th>Observaciones</th><th>Estado</th></tr>
	</thead>
	
	<tbody>	
    @foreach($registros as $item)
	  <tr><td>{{$item->id}}</td><td>{{$item->apellido}}</td><td>{{ $item->nombre }}</td><td>{{ ffec($item->fecha_nacimiento) }}</td><td>{{edad($item->fecha_nacimiento,$hoy)}}</td><td>{{ $item->sexo }}</td><td>{{ $item->dni }}</td><td>{{ $item->cuil }}</td><td>{{$item->domicilio_calle}}</td><td>{{$item->domicilio_numero}}</td><td>{{$item->domicilio_piso}}</td><td>{{$item->domicilio_departamento}}</td><td>{{$item->domicilio_codigopostal}}</td><td>{{$item->dlocalidad}}</td><td>{{$item->dprovincia}}</td><td>{{$item->telefono_celular}}</td><td>{{$item->email}}</td><td>{{cobertura($item)}}</td><td>{{$item->plan}}</td><td>{{$item->afiliado}}</td><td>{{discapacidad($item)}}</td><td>{{modalidad($item)}}</td><td>{{$item->ds_1}}</td><td>{{$item->hora_1}}</td><td>{{$item->ds_2}}</td><td>{{$item->hora_2}}</td><td>{{iva($item)}}</td><td>{{$item->observaciones}}</td><td>{{estado($item)}}</td></tr>
    @endforeach
</tbody>
</table>
</div>
</div>
<?php
function ffec($f){
	return substr($f,-2)."/".substr($f,5,2)."/".substr($f,0,4);
}
function modalidad($i){
	if($i->modalidad==1){return "Presencial";};
	if($i->modalidad==2){return "Virtual";};
	return "";
}
function cobertura($i){
	if($i->cobertura==1){return "Particular";};
	if($i->cobertura==2){return "Obra Social";};
	if($i->cobertura==3){return "Copago";};
}
function discapacidad($i){
	if($i->discapacidad==1){return "Discapacidad";};
	if($i->discapacidad==2){return "";};
}
function iva($i){
	if($i->iva=='C') {return "Consumidor Final";};
	if($i->iva=='I') {return "IVA Inscripto";};
	if($i->iva=='E') {return "IVA Exento";};
	return "";
}
function estado($e){
	if($e->estado=="1") {return 'Activo frecuencia semanal';};
	if($e->estado=="3") {return 'Activo frecuencia quincenal';};
	if($e->estado=="2") {return 'Inactivo';};
	return 'desconocido';
	
}
function edad($f,$hoy){
	$anio=substr($f,0,4);
	$mes=substr($f,5,2);
	$dia=substr($f,-2);
	$anio_hoy=substr($hoy,0,4);
	$mes_hoy=substr($hoy,5,2);
	$dia_hoy=substr($hoy,-2);
	$eda=$anio_hoy-$anio;
	if($mes>$mes_hoy){$eda=$eda-1;};
	if($mes==$mes_hoy && $dia>$dia_hoy){$eda=$eda-1;};
	
	return $eda;
}

?>