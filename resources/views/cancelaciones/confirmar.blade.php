@extends('layouts.app')
@section('content')
<div class="container">
<h2>Consulta del Sistema al Profesional</h2>
<form class="form" method="post" action="/turnos/escancelacion">
	{{ csrf_field() }}
	<p class="text-warning">El turno que acabas de asignar al paciente {{$paciente}} para el día {{$ds_turno." ".ffec($turno->fecha)}} a las {{substr($turno->hora,0,5)}} corresponde a la reprogramación del siguiente turno? </p><br>
	<p class="text-success">{{$ds_cancelacion." ".ffec($cancelacion->fecha)}} a las {{substr($cancelacion->hora,0,5)}}</p>
	<div class="form-group has-warning">
	<input hidden name="idturno" value="{{ $turno->id }}">
	<input hidden name="idcancelacion" value="{{ $cancelacion->id }}">
	<button class="form-control btn-success" name="confirmar" type="submit" value="confirmar">Confirmar</button>&nbsp;&nbsp;<button class="form-control btn-warning" name="ignorar" type="submit">No, no corresponde</button>
</form>
</div>

@endsection
<?php
	function ffec($f){
		return substr($f,-2)."/".substr($f,5,2)."/".substr($f,0,4);
	}

?>