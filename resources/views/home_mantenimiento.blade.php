@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Menú Operaciones Mantenimiento</strong></div>
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                            {{ session('status') }}
                            </div>
                        @endif
                         <ul class="list-group">
                            <li class="list-group-item" onclick="navega('/turnos/generar')">Generar Horarios para Turnos</li>

                            <li class="list-group-item" onclick="navega('/calendario/generar')">Generar Fechas del Año</li>
                             <li class="list-group-item" onclick="navega('/localidades/')">Localidades</li>
                    <li class="list-group-item" onclick="navega('/provincias/')">Provincias</li>
                    <li class="list-group-item" onclick="navega('/usuarios')">Usuarios</li>
                    <li class="list-group-item text-danger" onclick="navega('/turnos/eliminar')">Eliminar todos los Turnos de un Mes (peligroso)</li>
                   <li class="list-group-item"><var class="form-control" id="notificaciones">                   </var>
                    </li>
                         </ul>       
                        
                    </div>
                </div>
            </div>
        </div>
    
    <script>
    window.onload = function() {        
    var myVar=setInterval(function(){Chequea()},10000);
    document.getElementById("datos_pr").innerHTML=ejec_sq('/tablas/descripcion/DATOS_PROF/1')+" - "+ejec_sq('/tablas/descripcion/DATOS_PROF/2');
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
</div>
@endsection
