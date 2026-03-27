<?php

namespace App\Mail;

use App\Models\Recibido;
use App\Models\DetalleRecibido;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RespuestaCorrespondenciaExterna extends Mailable
{
    use Queueable, SerializesModels;

    public $recibido;
    public $detalle;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Recibido $recibido, DetalleRecibido $detalle)
    {
        $this->recibido = $recibido;
        $this->detalle = $detalle;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Respuesta a su correspondencia - Radicado ' . ($this->recibido->radicado->num_radicado ?? 'N/A'))
                    ->view('emails.respuesta_externa');
    }
}
