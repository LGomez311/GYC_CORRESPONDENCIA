<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TwoFactorCode extends Mailable
{
    use Queueable, SerializesModels;

    public $code;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Código de Verificación - EASYCOR')
                    ->html($this->getEmailHtml());
    }

    private function getEmailHtml()
    {
        $year = date('Y');
        return "
        <div style='
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f6fb;
            padding: 40px;
        '>
            <div style='
                max-width: 520px;
                margin: auto;
                background-color: #ffffff;
                border-radius: 12px;
                padding: 30px;
                box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            '>

                <h2 style='
                    color: #0d121b;
                    margin-bottom: 10px;
                    text-align: center;
                '>
                    Verificación de Dos Pasos
                </h2>

                <p style='
                    color: #4c669a;
                    font-size: 15px;
                    text-align: center;
                '>
                    Estás intentando iniciar sesión. Ingresa el siguiente código para continuar.
                </p>

                <div style='
                    margin: 30px 0;
                    padding: 20px;
                    background-color: #f0f4ff;
                    border-radius: 10px;
                    text-align: center;
                '>
                    <p style='
                        margin: 0;
                        font-size: 14px;
                        color: #4c669a;
                    '>
                        Tu código de verificación es:
                    </p>

                    <p style='
                        margin: 10px 0 0;
                        font-size: 32px;
                        font-weight: bold;
                        letter-spacing: 6px;
                        color: #4c669a;
                    '>
                        {$this->code}
                    </p>
                </div>

                <p style='
                    font-size: 14px;
                    color: #6b7280;
                    line-height: 1.6;
                '>
                    ⚠️ <strong>Este código expirará en 10 minutos.</strong>  
                    Si no fuiste tú, te recomendamos cambiar tu contraseña inmediatamente.
                </p>

                <hr style='
                    margin: 30px 0;
                    border: none;
                    border-top: 1px solid #e5e7eb;
                '>

                <p style='
                    font-size: 12px;
                    color: #9ca3af;
                    text-align: center;
                '>
                    © {$year} EASYCOR. Todos los derechos reservados.
                </p>

            </div>
        </div>";
    }
}
