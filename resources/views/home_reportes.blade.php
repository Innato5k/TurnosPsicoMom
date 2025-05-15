@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Menú Reportes</strong></div>
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                            {{ session('status') }}
                            </div>
                        @endif
                         <ul class="list-group">
                            <li class="list-group-item" onclick="navega('reportes/cumples/')">Cumpleaños de Pacientes</li>
                            <li class="list-group-item" onclick="navega('reportes/asistencia/general')">Asistencia General</li>
                             <li class="list-group-item" onclick="navega('/reportes/asistencia/cmmatanza')">Asistencia Efectiva CMMatanza</li>
                    <li class="list-group-item" onclick="navega('/reportes/asistencia/discapacidad')">Asistencia Efectiva CMMatanza Discapacidad</li>
                    <li class="list-group-item" onclick="navega('/reportes/asistencia/particular')">Asistencia Efectiva Particular</li>
                    <li class="list-group-item" onclick="navega('/reportes/cancelaciones')">Cancelaciones de Turnos</li>
                    <li class="list-group-item"><var class="form-control" id="notificaciones">                   </var>
                    </li>
                         </ul>       
                        
                    </div>
                </div>
            </div>
        </div>
    </div> 
    <script>
var myVar=setInterval(function(){Chequea()},10000);
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
