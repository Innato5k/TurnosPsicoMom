@extends('layouts.app')
@section('content')
<div class="container">
<h2>Editar Datos Paciente Paso 2</h2>
<form class="form-inline" method="post" action="/padron/editar2">
	{{ csrf_field() }}
	
	&nbsp;
	<h3>Domicilio</h3>
	<div class="form-group has-warning">
		<label class="label-form" for="domicilio_calle">Calle</label>
		<input class="form-control" type="text" id="domicilio_calle" name="domicilio_calle" size="60" maxlength="60" required value="{{ $padron->domicilio_calle}}">	
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="domicilio_numero">Número</label>
		<input class="form-control" type="number" id="domicilio_numero" name="domicilio_numero" min="0" max="20000" value="{{ $padron->domicilio_numero }}">
	</div>
	<br><br>
	<div class="form-group has-warning">
		<label class="label-form" for="domicilio_piso">Piso</label>
		<input class="form-control" type="text" size="10" maxlength="10" id="domicilio_piso" name="domicilio_piso" value="{{ $padron->domicilio_piso }}">
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="domicilio_departamento">Departamento</label>
		<input class="form-control" type="text" size="10" maxlength="10" id="domicilio_departamento" name="domicilio_departamento" value="{{ $padron->domicilio_departamento }}">
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="provincia">Provincia</label>
		<select class="form-control" id="provincia" name="provincia" onblur="completa_localidades()">
			@foreach($provincias as $item)
				<option value="{{$item->id}}">{{$item->descripcion}}</option>
			@endforeach
		</select>	
	</div>
	<br><br>
	<div class="form-group has-warning">
		<label class="label-form" for="localidad">Localidad</label>
		<select class="form-control" id="localidad" name="localidad" onblur="completa_cpostal()">
		</select>	
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="domicilio_codigopostal">Código Postal</label>
		<input class="form-control" type="text" id="domicilio_codigopostal" name="domicilio_codigopostal" required value="{{ $padron->domicilio_codigopostal }}">
	</div>
	<br><br>
	
	<input name="id" hidden value="{{$padron->id}}">
	<button class="form-control btn-primary" type="submit">Siguiente</button>
</form>
</div>
<script>
window.onload = function() {
	seleccionar("provincia","{{ $provincia}}");
	completa_localidades();
	seleccionar("localidad","{{ $padron->localidad}}");
	
  	document.getElementById("cuil").focus();
};
function completa_localidades(){
  prov=document.getElementById("provincia").value;
  document.getElementById('localidad').innerHTML=ejec_sq('/localidades/opciones/'+prov);
  return true;	
}
function completa_cpostal() {
	if(document.getElementById("domicilio_codigopostal").value==""){
		loca=document.getElementById("localidad").options[document.getElementById("localidad").options.selectedIndex].text;
	posicion=loca.indexOf("CP:")+3;
	document.getElementById("domicilio_codigopostal").value=loca.substr(posicion,10);
	};
	return true;
}
</script>
@endsection
