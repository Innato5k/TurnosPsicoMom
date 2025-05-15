@extends('layouts.app')
@section('content')
<div class="container">
<h2>Editar Datos Paciente Paso 3</h2>
<form class="form-inline" method="post" action="/padron/editar3">
	{{ csrf_field() }}
	
	<div class="form-group has-warning">
		<label class="label-form" for="cobertura">Cobertura</label>
		<select class="form-control" id="cobertura" name="cobertura" required>
			<option value="1">Particular</option>
			<option value="2">CM Matanza</option>
		</select>	
	</div>
	&nbsp;&nbsp;
	<div class="form-group has-warning">
		<label class="label-form" for="plan">Plan</label>
		<input class="form-control" id="plan" name="plan" maxlength="30" value="{{ $padron->plan}}">
	</div>
	&nbsp;&nbsp;
	<div class="form-group has-warning">
		<label class="label-form" for="afiliado">Afiliado Número</label>
		<input class="form-control" id="afiliado" name="afiliado" maxlength="30" value="{{$padron->afiliado}}">
	</div>
	<br><br>
	<div class="form-group has-warning">
		<label class="label-form" for="discapacidad">Discapacidad</label>
		<input class="form-control" id="discapacidad" name="discapacidad" type="checkbox">
	</div>	
	&nbsp;&nbsp;
	<div class="form-group has-warning">
		<label class="label-form" for="iva">Sit. ante el IVA</label>
		<select class="form-control" id="iva" name="iva" required>
			<option value="C">Consumidor Final</option>
			<option value="I">Responsable Inscripto</option>
			<option value="E">Iva Exento</option>
		</select>
	</div>	
	&nbsp;&nbsp;
	<div class="form-group has-warning">
		<label class="label-form" for="estado">Situación y frecuencia de consulta</label>
		<select class="form-control" id="estado" name="estado" required>
			<option value="1">Activo (frecuencia semanal)</option>
			<option value="2">Inactivo (no en tratamiento)</option>
			<option value="3">Activo (frecuencia quincenal)</option>
		</select>
	</div>	
	<br><br>
	<div class="form-group has-warning">
		<label class="label-form" for="ds_1">Horario Habitual 1 (cobertura del paciente) - Día Semana</label>
		<select class="form-control" id="ds_1" name="ds_1">
			<option value="">(no asignado)</option>
			<option value="Lunes">Lunes</option>
			<option value="Martes">Martes</option>
			<option value="Miércoles">Miércoles</option>
			<option value="Jueves">Jueves</option>
			<option value="Viernes">Viernes</option>
		</select>	
	</div>
  &nbsp;&nbsp;
  <div class="form-group has-warning">
		<label class="label-form" for="hora_1">Hora</label>
		<input class="form-control" id="hora_1" name="hora_1" type="time" value="{{$padron->hora_1}}">
	</div>
	<br><br>
	<div class="form-group has-warning">
		<label class="label-form" for="ds_2">Horario Habitual 2 (cobertura particular) - Día Semana</label>
		<select class="form-control" id="ds_2" name="ds_2">
			<option value="">(no asignado)</option>
			<option value="Lunes">Lunes</option>
			<option value="Martes">Martes</option>
			<option value="Miércoles">Miércoles</option>
			<option value="Jueves">Jueves</option>
			<option value="Viernes">Viernes</option>
		</select>	
	</div>
  &nbsp;&nbsp;
  <div class="form-group has-warning">
		<label class="label-form" for="hora_2">Hora</label>
		<input class="form-control" id="hora_2" name="hora_2" type="time" value="{{$padron->hora_2}}">
	</div>
	
	<br><br>
	
	<div class="form-group has-warning">
		<label class="label-form" for="modalidad">Modalidad Habitual</label>
		<select class="form-control" id="modalidad" name="modalidad" required>
			<option value="1">Presencial</option>
			<option value="2">Virtual</option>		
		</select>
	</div>
	&nbsp;&nbsp;
	
	<div class="form-group has-warning">
		<label class="label-form" for="observaciones">Observaciones</label>
		<input class="form-control" type="text" id="observaciones" name="observaciones" style="text-transform:uppercase;" onblur="mayusc(this)" size="60" maxlength="100" value="{{$padron->observaciones}}">
	</div>
	<br><br><br>
	<input name="id" hidden value="{{$padron->id}}">
	<button class="form-control btn-primary" type="submit">Finalizar</button>
</form>
</div>
<script>
window.onload = function() {
	seleccionar('iva','{{ $padron->iva}}');
	seleccionar('cobertura','{{ $padron->cobertura}}');
	seleccionar('estado','{{ $padron->estado}}');
	seleccionar('ds_1','{{ $padron->ds_1}}');
	seleccionar('ds_2','{{ $padron->ds_2}}');
	seleccionar('modalidad','{{ $padron->modalidad}}');
	if('{{$padron->discapacidad}}'=='1'){document.getElementById("discapacidad").checked=true;};
	if('{{$padron->copago_2}}'=='1'){document.getElementById("copago_2").checked=true;};
  	document.getElementById("cobertura").focus();
};
</script>
@endsection
