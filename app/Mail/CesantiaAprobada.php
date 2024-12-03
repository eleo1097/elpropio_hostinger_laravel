<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CesantiaAprobada extends Mailable
{
    use Queueable, SerializesModels;

    public $justificacion;
    public $tipo_cesantia_reportada;
    public $nombre_usuario;

    public function __construct($justificacion, $tipo_cesantia_reportada, $nombre_usuario)
    {
        $this->justificacion = $justificacion;
        $this->tipo_cesantia_reportada = $tipo_cesantia_reportada;
        $this->nombre_usuario = $nombre_usuario;
    }

    public function build()
    {
        return $this->view('emails.cesantia_aprobada');
    }
}

