@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-9">
	<form class="form-inline" method="post" action="/calendario">
	{{ csrf_field() }}
	<div class="form-group has-warning">
		<label class="label-form">Año</label>
		<input class="form-control" name="anio" id="anio" type="number" min="2023" max="2033" value="{{$anio}}" required>
	</div>
	&nbsp;&nbsp;	
	<div class="form-group has-warning">
		<label class="label-form">Mes</label>
		<select class="form-control" name="mes" id="mes">
			<option value="1">Enero</option>
			<option value="2">Febrero</option>
			<option value="3">Marzo</option>
			<option value="4">Abril</option>
			<option value="5">Mayo</option>
			<option value="6">Junio</option>
			<option value="7">Julio</option>
			<option value="8">Agosto</option>
			<option value="9">Septiembre</option>
			<option value="10">Octubre</option>
			<option value="11">Noviembre</option>
			<option value="12">Diciembre</option>
		</select>	
	</div>
	<button class="btn-primary">Consultar</button>
	</form>	
   </div>
	<div class="row">
		<div class="col-md-3"></div>	
		<div class="col-md-1">Lunes</div>
		<div class="col-md-1">Martes</div>
		<div class="col-md-1">Miércoles</div>
		<div class="col-md-1">Jueves</div>
		<div class="col-md-1">Viernes</div>
		<div class="col-md-1">Sábado</div>
		<div class="col-md-1">Domingo</div>
	</div>
	<div class="row">
		<div class="col-md-3"><br><br><br></div>

			<?php
				$pos=1;

			?>	
	@foreach($fechas as $item )
		@while(diasem($pos)!=$item->dia_semana)
			<div class="col-md-1"></div>
			<?php 
			 $pos=$pos+1;
			?>
			@if($pos==8)
				</div>
				<div class="row">
				<div class="col-md-3"><br><br><br></div>	
				<?php
					$pos=1;
				?>		
			@endif
		@endwhile
		<div class="col-md-1">
			@if($item->laborable=='0') 
			    <h3 class='text-danger'>{{substr($item->fecha,-2)}}</h3>{{$item->observaciones}}
			     @if(substr($item->fecha,0,10)>=substr($hoy,0,10))
			    <button class='btn-success btn-sm' onclick='navega("/calendario/liberar/{{$item->id}}")'>Liberar</button>
			    @endif
			</div>
			@else
				<h3>{{substr($item->fecha,-2)}}</h3>{{$item->observaciones}}
				@if(substr($item->fecha,0,10)>=substr($hoy,0,10)||$item->cantidad>0)   
				<button class='btn-info btn-sm' onclick='navega("/turnos/consultar/{{$item->id}}")'>
					@if($item->cantidad>0)
					  {{$item->cantidad}}&nbsp;
					@endif
				    Turnos</button>
				 @endif   
				 @if($item->fecha>$hoy)   
			     @if($item->cantidad==0)
					<button class='btn-danger btn-sm' onclick='navega("/calendario/bloquear/{{$item->id}}")'>Bloquear</button>
				 @endif	
				@endif
			</div>	
			@endif 
			
		<?php 
		 $pos=$pos+1;
		?>
			@if($pos==8)
				</div>
				<div class="row">
				<div class="col-md-3"><br><br><br></div>	
				<?php
					$pos=1;
				?>		
			@endif
	@endforeach	
</div>
<hr>
<div class="row">
	<div class="md-3"></div>
	<div class="md-6">
	<var class="form-control" id="notificaciones"></var>
	</div>	
</div>	
</div>

<script type="text/javascript">
	window.onload=function(){
		seleccionar("mes","{{$mes}}")
		var myVar=setInterval(function(){Chequea()},10000);
        document.getElementById("datos_pr").innerHTML=ejec_sq('/tablas/descripcion/DATOS_PROF/1')+" - "+ejec_sq('/tablas/descripcion/DATOS_PROF/2');
        document.getElementById("anio").focus();
	}
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
<?php
function diasem($p){
	if($p==0){return "Inicial";};
	if($p==1){return "Lunes";};
	if($p==2){return "Martes";};
	if($p==3){return "Miércoles";};
	if($p==4){return "Jueves";};
	if($p==5){return "Viernes";};
	if($p==6){return "Sábado";};
	if($p==7){return "Domingo";};
}
?>