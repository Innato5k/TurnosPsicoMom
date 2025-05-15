@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Menú Principal</strong></div>
                  
                       
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                   <ul class="list-group">
                    <li class="list-group-item">
                        <button class="btn-primary btn-lg" onclick="navega('/calendario')">Calendario</button>&nbsp;&nbsp;
                        <button class="btn-info btn-lg" onclick="navega('/turnos/disponibles')">Turnos<br>Disponibles</button>&nbsp;&nbsp;
                        <button class="btn-danger btn-lg" onclick="navega('/turnos/repaso')">Repaso Asistencia<br>y Pagos</button>&nbsp;&nbsp;
                        <button class="btn-warning btn-lg" onclick="navega('/turnos/impagos')">Consultas<br>Impagas</button>&nbsp;&nbsp;
                        
                    </li>
                    <li class="list-group-item">
                        <button class="btn-grey btn-lg" onclick="navega('/pacientes')">Buscar<br>Pacientes</button>&nbsp;&nbsp;
                        <button class="btn-warning btn-lg" onclick="navega('/pacientes/nuevo')">Nuevo<br>Paciente</button>&nbsp;&nbsp;
                        <button class="btn-success btn-lg" onclick="navega('/pacientes/exportar')">Excel<br>Pacientes</button>&nbsp;&nbsp;
                        
                    </li>    
                    <li class="list-group-item"><button class="btn-success btn-lg" onclick="navega('/reportes')">Menú<br>Reportes</button>&nbsp;&nbsp;
                    <button class="btn-primary btn-lg" onclick="navega('/mantenimiento')">Menú<br>Operaciones</button>
                    <button class="btn-danger btn-lg" onclick="navega('/pago')">Registrar<br>Pago Rápido</button></li>
                    <li class="list-group-item"><var class="form-control" id="notificaciones">                   </var>
                    </li>
                   </ul>
                </div>
            
                
                
    
                
            </div>

        </div>

    </div>
    
    
    
</div>
<script>
    window.onload=function(){
        var myVar=setInterval(function(){Chequea()},10000);
        document.getElementById("datos_pr").innerHTML=ejec_sq('/tablas/descripcion/DATOS_PROF/1')+" - "+ejec_sq('/tablas/descripcion/DATOS_PROF/2');
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
