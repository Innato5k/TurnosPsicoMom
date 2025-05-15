@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Enviar Mensaje</strong></div>
                  
                       
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                   
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    numero="549{{$numero}}";
    texto="{{$texto}}";   
    naveganuevo("https://api.whatsapp.com/send?phone="+numero+"&text="+texto+"&send");
    function naveganuevo(vurl){

window.open(vurl,'_blank');};


</script>    
@endsection
