@extends('layouts.app')
@section('content')
<div class="container">
<h2>Cancelar Turno del {{$dia_semana." ".ffec($turno->fecha)}} a las {{substr($turno->hora,0,5)}} hs.</h2>
<form class="form" method="post" action="/turnos/cancelar">
	{{ csrf_field() }}
	<input hidden name="id" value="{{ $turno->id }}">
	<div class="form-group has-warning">
		<label class="label-form" for="paciente">Paciente</label>
		<strong>{{$apynomb}}</strong>
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="paciente">Teléfono Celular</label>
		<strong>{{$telefono}}</strong>
	</div>
	<div>
	<div class="form-group has-warning">
		<label class="label-form" for="motivo">Motivo de la Cancelación</label>
		<select class="form-control" name="motivo" id="motivo">
			
		</select>	
	</div>	
	<button class="form-control btn-danger" type="submit">Cancelar sin Reprogramar</button>
	<h4>Reprogramar</h4>
		<div class="table-responsive">
			<table class="table">
				<tr class="bg-info"><th>Fecha</th><th>Hora</th><th>Estado</th><th>Acciones</tr>
	<?php $ante="";$cant=0;?>			
	@foreach($turnos as $item)
		<?php if(ffec($item->fecha)!=$ante){$cant=$cant+1;};?>		
	    @if($cant<7)
	    	@if($item->bloqueado=="1")
				<tr class="bg-danger text-danger">
			@else
			    @if($item->paciente>0)
			      <tr class="bg-info text-danger">
			    @else
			      <tr class="bg-primary">	
			    @endif  	
			@endif    
		    <td>
			@if(ffec($item->fecha)!=$ante)
				{{$item->dia_semana." ".ffec($item->fecha)}}
				<?php $ante=ffec($item->fecha);?>
			@endif	
		    </td><td>{{substr($item->hora,0,5)}}</td>
		    @if($item->bloqueado=="1")
			  <td>{{$item->motivo_bloqueo}}</td>
			@else
				@if($item->paciente>0)
					<td>{{apynom($item)}}</td>
				@else
					<td>D I S P O N I B L E</td>
				@endif
			@endif
		<td>
			@if($item->bloqueado=="0")
			  @if(!$item->paciente>0)
			  	<button class="btn-success" name="reprogramar" value="{{$item->id}}">Reprogramar</button>
			  @endif
			@endif
		</td>		
		</tr>
		@endif
	@endforeach
			</table>
		</div>
	<input hidden name="id" value="{{ $turno->id }}">
	
</form>
</div>
<script type="text/javascript">
	window.onload=function(){
		document.getElementById("motivo").innerHTML=ejec_sq("/tablas/opciones/MOT_CANC");
		document.getElementById("motivo").focus();
	}
	
</script>
@endsection
<?php
	function ffec($f){
		return substr($f,-2)."/".substr($f,5,2)."/".substr($f,0,4);
	}
function apynom($i){
	if($i->paciente>0){return $i->apellido.", ".$i->nombre;};
	return "S/D";
}	
?>