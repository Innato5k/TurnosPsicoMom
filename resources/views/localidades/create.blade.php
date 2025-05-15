@extends('layouts.app')
@section('content')
<div class="container">
<h2>Nueva Localidad</h2>
<form class="form" method="post" action="/localidades/nueva">
	{{ csrf_field() }}
	<div class="form-group has-warning">
		<label class="label-form" for="descripcion">Descripción</label>
		<input class="form-control" size="100" maxlength="100" name="descripcion" id="descripcion" required autofocus>
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="provincia">Provincia</label>
		<select class="form-control" id="provincia" name="provincia">
			@foreach($provincias as $item)
				<option value="{{$item->id}}">{{$item->descripcion}}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="codigo_postal">Código Postal</label>
		<input class="form-control" size="15" maxlength="15" name="codigo_postal" id="codigo_postal" required autofocus>
	</div>
	
	<button class="form-control btn-primary" type="submit">Crear</button>
</form>
</div>
@endsection
