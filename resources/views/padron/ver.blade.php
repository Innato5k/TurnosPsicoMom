@extends('layouts.app')
@section('content')
<div class="container">
	<h2>{{$padron->apellido.', '.$padron->nombre}}</h2>
	<div class="row ">
		<div class="col-md-4">DNI <strong>{{$padron->dni}}</strong><br>CUIL <strong>{{fcuil($padron->cuil)}}</strong></div>
		<div class="col-md-4">Nacimiento <strong>{{ffec($padron->fecha_nacimiento)}}</strong></div>
		<div class="col-md-4">Sexo <strong>{{sexo($padron->sexo)}}</strong></div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-4">Domicilio</div>
	</div>
	
	<div class="row">	
		<div class="col-md-4">Calle <strong>{{$padron->domicilio_calle}}</strong><br>Número <strong>{{$padron->domicilio_numero}}</strong> Piso <strong>{{$padron->domicilio_piso}}</strong> Depto <strong>{{$padron->domicilio_departamento}}</strong></div>
		<div class="col-md-4">Localidad <strong>{{$loc_descripcion}}</strong><br>Provincia <strong> {{$prov_descripcion}}</strong></div>
		<div class="col-md-4">Cód.Postal <strong>{{$padron->domicilio_codigopostal}}</div>
	</div>	
	<br>
	<div class="row">
		<div class="col-md-4">Contacto</div>
	</div>
	<div class="row">	
		<div class="col-md-4">Teléfono Celular <strong>{{$padron->telefono_celular}}</strong></div><div class="col-md-4">Email <strong>{{$padron->email}}</strong></div>
	</div>
	<hr>
	<div class="row">	
		<div class="col-md-4">Cobertura <strong>{{cobertura($padron->cobertura)}}</strong><br>Plan <strong>{{$padron->plan}}</strong> Afiliado Nro. <strong>{{$padron->afiliado}}</strong></div>
		<div class="col-md-4">Horario 1 <strong>{{$padron->ds_1." ".substr($padron->hora_1,0,5)}}</strong> </div>	
		<div class="col-md-4">Horario 2 <strong>{{$padron->ds_2." ".substr($padron->hora_2,0,5)}}</strong> </div>
	</div>	
	<br>
	<div class="row">	
		<div class="col-md-4">IVA <strong>{{iva($padron->iva)}}</strong><br>Observaciones <strong>{{$padron->observaciones}}</strong> </div>
		<div class="col-md-4">Estado <strong>{{estado($padron->estado)}}</strong><br>Modalidad <strong>{{modalidad($padron->modalidad)}}</strong> </div>
		<div class="col-md-4">Discapacidad <strong>{{sino($padron->discapacidad)}}</strong> </div>
	</div>	
	
</div>
<?php
function fcuil($t){
	return substr($t,0,2)."-".substr($t,2,8)."-".substr($t,-1);
}
function ffec($f){
	return substr($f,-2)."/".substr($f,5,2)."/".substr($f,0,4);
}
function sexo($s){
	if($s=="M") {return 'Masculino';};
	if($s=="F") {return 'Femenino';};
	return "";
}
function estado($e){
	if($e=="1") {return 'Activo';};
	if($e=="2") {return 'Inactivo';};
	return "";
}
function sino($e){
	if($e=="1") {return 'SI';};
	if($e=="0") {return 'NO';};
	return "";
}
function modalidad($m){
	if($m=="1") {return 'Presencial';};
	if($m=="2") {return 'Virtual';};
}
function iva($i){
	if($i=='C') {return "Consumidor Final";};
	if($i=='I') {return "IVA Inscripto";};
	if($i=='E') {return "IVA Exento";};
	return "";
}
function cobertura($c){
	if($c=='1') {return "Particular";};
	if($c=='2') {return "CM Matanza";};
	return "";
}
?>
@endsection
