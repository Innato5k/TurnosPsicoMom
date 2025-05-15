@extends('layouts.app')
<link rel="icon" href="/infra/public/imagenes/favicon.ico" type="image/x-icon" />

@section('content')
<div class="container">
<h2>Operación No Permitida</h2>
<p class='text-success'><?php echo $mensajefinal;?></p><br>
<button class="btn-primary" onclick="continuar()">Continuar</button>
<script src='/infra/public/js/viejos/generales.js'></script>
<script type="text/javascript">
	function continuar(){
		url="{{ url('/home') }}";
		navega(url);
	}
</script>
</div>
@endsection