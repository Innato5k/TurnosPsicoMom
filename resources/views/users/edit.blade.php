@extends('layouts.app')
@section('content')
<div class="container">
<h2>Editar Usuario</h2>
<form class="form" method="post" action="/usuarios/editar_do" onsubmit="return valida()">
	{{ csrf_field() }}
	<div class="form-group has-warning">
		<label class="label-form" for="name">Apellido y Nombre</label>
		<input class="form-control" size="100" maxlength="100" name="name" id="name" value="<?php echo $usuario['name'];?>" required autofocus>
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="cuil">CUIL/CUIT (sin guiones)</label>
		<input class="form-control" size="11" maxlength="11" name="cuil" id="cuil" onblur="vCuit(this.id)" value="<?php echo $usuario['cuil'];?>" required autofocus>
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="email">Email</label>
		<input class="form-control" size="100" maxlength="100" name="email" id="email" value="<?php echo $usuario['email'];?>" required autofocus>
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="tipo">Tipo</label>
		<select class="form-control" name="tipo" id="tipo">
			<option value="1" <?php if($usuario['tipo']==1) echo 'selected'?> >Final</option>
			<option value="3" <?php if($usuario['tipo']==3) echo 'selected'?> >Administrador</option>
		</select>
	</div>
	
	
	<input hidden name="id" value="<?php echo $usuario['id'];?>">
	<button class="form-control btn-primary" type="submit">Modificar</button>
</form>
</div>
		
<script type="text/javascript">
	function valida(){
		vCuit("cuil");
		valida_mail("email");
		if(document.getElementById("cuil").value==""){alert("cuil incorrecto");return false;};
		if(document.getElementById("email").value==""){alert("email es un campo obligatorio");return false;};
		if(document.getElementById("password").value.length<8) {alert("password es un campo obligatorio y de mínimo 8 caracteres");return false;};
		return true;
	}
</script>
@endsection
