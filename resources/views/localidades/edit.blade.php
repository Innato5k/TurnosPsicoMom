@extends('layouts.app')
@section('content')
<div class="container">
<h2>Editar Localidad</h2>
<form class="form" method="post" action="/localidades/editar">
	{{ csrf_field() }}
	<div class="form-group has-warning">
		<label class="label-form" for="descripcion">Descripción</label>
		<input class="form-control" size="100" maxlength="100" name="descripcion" id="descripcion" value="{{ $localidad->descripcion }}" required autofocus>
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="provincia">Provincia</label>
		<select class="form-control" id="provincia" name="provincia">
			@foreach($provincias as $item)
			    @if($item->id==$localidad->provincia)
			    <option value="{{$item->id}}" selected>{{$item->descripcion}}</option>
				@else
				<option value="{{$item->id}}" >{{$item->descripcion}}</option>
				@endif
			@endforeach
		</select>
	</div>
	
	<div class="form-group has-warning">
		<label class="label-form" for="codigo_postal">Código Postal</label>
		<input class="form-control" size="15" maxlength="15" name="codigo_postal" value="{{ $localidad->codigo_postal }}" required|autofocus>
	</div>
	<input hidden name="id" value="{{ $localidad->id }}">
	<button class="form-control btn-primary" type="submit">Modificar</button>
</form>
</div>
@endsection