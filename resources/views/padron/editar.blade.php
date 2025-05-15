@extends('layouts.app')
@section('content')
<div class="container">
<h2>Editar Datos Paciente Paso 1</h2>
<form class="form-inline" method="post" action="/padron/editar">
	{{ csrf_field() }}
	<div class="form-group has-warning">
		<label class="label-form" for="apellido">Apellido</label>
		<input class="form-control" type="text" size="50" maxlength="100" id="apellido" name="apellido" required autofocus onblur="mayusc(this)" value="{{ $padron->apellido }}">
	</div>
	<br><br>
	<div class="form-group has-warning">
		<label class="label-form" for="nombre">Nombre</label>
		<input class="form-control" type="text" size="50" maxlength="100" id="nombre" name="nombre" onblur="mayusc(this)" value="{{ $padron->nombre}}" required>
	</div>
	<br><br>
	<div class="form-group has-warning">
		<label class="label-form" for="dni">DNI</label>
		<input class="form-control" type="number" id="dni" name="dni" min="4000000" max="99999999" required value="{{ $padron->dni}}">
	</div>
	&nbsp;&nbsp;
	<div class="form-group has-warning">
		<label class="label-form" for="cuil">CUIL (ingresarlo sin guiones)</label>
		<input class="form-control" type="text" size="11" maxlength="11" id="cuil" name="cuil" onblur="vCuit(this.id)" required value="{{ $padron->cuil}}">
	</div>
	<br><br>
		<div class="form-group has-warning">
		<label class="label-form" for="nacimiento_fecha">Fecha Nacimiento</label>
		<input class="form-control" type="date" id="fecha_nacimiento" name="fecha_nacimiento" required  value="{{ $padron->fecha_nacimiento }}">
	</div>
	&nbsp;&nbsp;
	
	<div class="form-group has-warning">
		<label class="label-form" for="sexo">Sexo</label>
		<select class="form-control" name="sexo" id="sexo">
			<option value="M">Masculino</option>
			<option value="F">Femenino</option>
		</select>		
	</div>
	<br><br>
	<div class="form-group has-warning">
		<label class="label-form" for="telefono_celular">Teléfono Celular</label>
		<input class="form-control" id="telefono_celular" name="telefono_celular" required value="{{ $padron->telefono_celular }}"> 
	</div>
	&nbsp;&nbsp;	
	<div class="form-group has-warning">
		<label class="label-form" for="email">Email</label>
		<input class="form-control" type="email" id="email" name="email" value="{{ $padron->email}}"> 
	</div>
	
	<br><br>
	<input hidden name="id" value="{{$padron->id}}">
	<button class="form-control btn-primary" type="submit">Siguiente</button>
</form>
</div>
<script>
window.onload = function() {
  seleccionar("sexo","{{$padron->sexo}}"); 
  document.getElementById("apellido").focus();
};
</script>
@endsection
