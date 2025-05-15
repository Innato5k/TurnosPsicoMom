@extends('layouts.app')
@section('content')
<div class="container">
<h2>Nuevo Paciente</h2>
<form class="form-inline" method="post" action="/padron/nuevo">
	{{ csrf_field() }}
	<div class="form-group has-warning">
		<label class="label-form" for="apellido">Apellido</label>
		<input class="form-control" type="text" size="50" maxlength="100" id="apellido" name="apellido" onblur="mayusc(this)" required autofocus>
	</div>
	<br><br>
	<div class="form-group has-warning">
		<label class="label-form" for="nombre">Nombre</label>
		<input class="form-control" type="text" size="50" maxlength="100" id="nombre" name="nombre" onblur="mayusc(this)" required>
	</div>
	<br><br>
	<div class="form-group has-warning">
		<label class="label-form" for="dni">DNI</label>
		<input class="form-control" type="number" id="dni" name="dni" min="4000000" max="99999999" required>
	</div>
	&nbsp;&nbsp;	
	<div class="form-group has-warning">
		<label class="label-form" for="fecha_nacimiento">Fecha Nacimiento</label>
		<input class="form-control" type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>
	</div>
  &nbsp;&nbsp;	
	<div class="form-group has-warning">
		<label class="label-form" for="sexo">Sexo</label>
		<select class="form-control" name="sexo" id="sexo">
			<option value="M">Masculino</option>
			<option value="F">Femenino</option>
			<option value="X">Otro</option>
		</select>		
	</div>
	<br><br>
	<div class="form-group has-warning">
		<label class="label-form" for="telefono_celular">Teléfono Celular</label>
		<input class="form-control" id="telefono_celular" name="telefono_celular" required> 
	</div>
	&nbsp;&nbsp;	
	<div class="form-group has-warning">
		<label class="label-form" for="email">Email</label>
		<input class="form-control" type="email" id="email" name="email"> 
	</div>
	<br><br>
	<button class="form-control btn-primary" type="submit">Siguiente</button>
</form>
</div>
<script>
window.onload = function() {
  document.getElementById("apellido").focus();
};
</script>
@endsection
