@extends('layouts.app')
@section('content')
<div class="container">
<h2>Buscar un Paciente</h2>
<p class="text-warning">Se puede buscar por apellido, nombre, teléfono y éstos pueden ser completos o parciales, la búsqueda será por aproximación</p>
<form class="form col-md-6" method="post" action="/padron/buscar">
	{{ csrf_field() }}
	<div class="form-group has-warning">
		<label class="label-form" for="apellido">Ingresa el texto a buscar</label>
		<input class="form-control" size="50" maxlength="50" name="texto" id="texto">
	</div>
	
	<button class="form-control btn-primary" type="submit">Buscar</button>
</form>
</div>
<div class="container">
<hr>
<div class="row">
	<div class="md-3"></div>
	<div class="md-6">
	<var class="form-control" id="notificaciones"></var>
	</div>	
</div>	
</div>
<script>
window.onload = function() {
	var myVar=setInterval(function(){Chequea()},10000);
        document.getElementById("datos_pr").innerHTML=ejec_sq('/tablas/descripcion/DATOS_PROF/1')+" - "+ejec_sq('/tablas/descripcion/DATOS_PROF/2');
  document.getElementById("texto").focus();
};
function Chequea(){
    resp=ejec_sq("/turnos/actual");
    if(resp!=""){document.getElementById("notificaciones").innerHTML=resp;};
}
function confirmar(id){
    ejec_sq("/turnos/asistencia/"+id);
    document.getElementById("notificaciones").innerHTML="";   
}
</script>

@endsection
