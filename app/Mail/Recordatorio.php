<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
use App\Turnos;
use App\Fechas;
use App\Tablas;

class Recordatorio extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($turno,$nombre)
    {
        //
        $this->turno=$turno;
        $this->nombre=$nombre;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $dp=Tablas::where([['tipo','DATOS_PROF'],['valor','1']])->get();
        $dp_nombre=$dp[0]->descripcion;
        $dp=Tablas::where([['tipo','DATOS_PROF'],['valor','2']])->get();
        $dp_profesion=$dp[0]->descripcion;
        $turno=Turnos::find($this->turno);
        $fechas=Fechas::where('fecha',$turno->fecha)->get();
        $ds=$fechas[0]->dia_semana;
        $contenido=["Estimado/a ".$this->nombre.". Le recuerdo que tenemos un turno agendado para una sesión:" ,
        "Fecha: ".$ds." ".$this->cf(substr($turno->fecha,0,10)).
        "  Hora: ".substr($turno->hora,0,5),
        "Modalidad: ".$this->modalidad($turno->modalidad),
        "Los turnos se podrán cancelar hasta 24 horas antes del mismo.",
        "Si se cancelara pasado este plazo, se abonará la sesión sin excepción.",
        "Saludos",
        $dp_nombre,
        $dp_profesion
        ];
               return $this->subject("Recordatorio de Turno")->view('emails.mensaje-enviado')->with(['contenido' => $contenido,]);
           
    }
    public function cf($f){
        return substr($f,-2)."/".substr($f,5,2)."/".substr($f,0,4);
    }
    public function modalidad($m){
        if($m=="1"){ return "Presencial";};
        return "Virtual";
    }
}
