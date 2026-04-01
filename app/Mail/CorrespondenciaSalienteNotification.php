<?php

namespace App\Mail;

use App\Models\Envio;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CorrespondenciaSalienteNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $envio;

    /**
     * Create a new message instance.
     */
    public function __construct(Envio $envio)
    {
        $this->envio = $envio;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Notificación de Correspondencia Saliente - Radicado ' . ($this->envio->radicado->num_radicado ?? 'N/A'))
                    ->view('emails.envio_externo');
    }
}
