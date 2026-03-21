<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificacionSaliente extends Mailable
{
    use Queueable, SerializesModels;

    public $radicado;
    public $urlConsultar;

    /**
     * Create a new message instance.
     */
    public function __construct($radicado, $urlConsultar)
    {
        $this->radicado = $radicado;
        $this->urlConsultar = $urlConsultar;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notificación de Correspondencia Saliente - Radicado ' . $this->radicado,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.notificacion_saliente',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
