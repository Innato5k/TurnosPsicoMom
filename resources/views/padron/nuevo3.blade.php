@extends('layouts.app')
@section('content')
<div class="container">
<h2>Nuevo Paciente Paso 3</h2>
<form class="form-inline" method="post" action="/padron/nuevo3">
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
		<input class="form-control" id="plan" name="plan" maxlength="30">
	</div>
	&nbsp;&nbsp;
	<div class="form-group has-warning">
		<label class="label-form" for="afiliado">Afiliado Número</label>
		<input class="form-control" id="afiliado" name="afiliado" maxlength="30">
	</div>
	<br><br>
	<div class="form-group has-warning">
		<label class="label-form" for="discapacidad">Discapacidad</label>
		<input class="form-control" id="discapacidad" name="discapacidad" type="checkbox">
	</div>	
	<div class="form-group has-warning">
		<label class="label-form" for="iva">Sit. ante el IVA</label>
		<select class="form-control" id="iva" name="iva" required>
			<option value="C">Consumidor Final</option>
			<option value="I">Responsable Inscripto</option>
			<option value="E">Iva Exento</option>
		</select>
	</div>	
	<br><br>
	<div class="form-group has-warning">
		<label class="label-form" for="ds_1">Horario Habitual 1 (cobertura del paciente)- Día Semana</label>
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
		<input class="form-control" id="hora_1" name="hora_1" type="time">
	</div>
	<br><br>
	<div class="form-group has-warning">
		<label class="label-form" for="ds_2">Horario Habitual 2 (cobertura particular)- Día Semana</label>
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
		<input class="form-control" id="hora_2" name="hora_2" type="time">
	</div>
	br><br>
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
		<input class="form-control" type="text" id="observaciones" name="observaciones" style="text-transform:uppercase;" onblur="mayusc(this)" size="60" maxlength="100">
	</div>
	<br><br>
	<br><br>
	<br><br>
	<input name="id" hidden value="{{$padron->id}}">
	<button class="form-control btn-primary" type="submit">Finalizar</button>
</form>
</div>
<script>
window.onload = function() {
  document.getElementById("cobertura").focus();
};

</script>
@endsection
