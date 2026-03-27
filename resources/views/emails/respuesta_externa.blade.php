<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respuesta a su correspondencia</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Outfit', 'Inter', 'Segoe UI', Arial, sans-serif; background-color: #f0f2f5; color: #1e293b;">
    <div style="max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);">
        <!-- Header with Gradient Area -->
        <div style="background: linear-gradient(135deg, #00b5a3 0%, #009688 100%); padding: 40px 20px; text-align: center;">
            <div style="background: rgba(255, 255, 255, 0.2); width: 80px; height: 80px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <h1 style="color: #ffffff; margin: 0; font-size: 28px; font-weight: 700; letter-spacing: -0.5px;">Respuesta Enviada</h1>
        </div>

        <!-- Content Area -->
        <div style="padding: 40px 35px;">
            <p style="font-size: 16px; line-height: 1.6; color: #475569; margin-bottom: 30px;">
                Estimado/a <strong style="color: #0f172a;">{{ $recibido->nombre_persona ?? 'Usuario' }}</strong>,
            </p>
            
            <p style="font-size: 16px; line-height: 1.6; color: #475569;">
                Le informamos que su correspondencia ha sido atendida satisfactoriamente por nuestro equipo. A continuación encontrara los detalles de la respuesta:
            </p>

            <!-- Radicado Card -->
            <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 16px; padding: 25px; margin: 30px 0;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                    <span style="color: #64748b; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Número de Radicado</span>
                    <span style="color: #00b5a3; font-weight: 700; font-size: 15px;">{{ $recibido->radicado->num_radicado ?? 'N/A' }}</span>
                </div>
                <div style="margin-bottom: 15px;">
                    <span style="color: #64748b; font-size: 13px; font-weight: 600; text-transform: uppercase;">Asunto Original</span>
                    <p style="margin: 5px 0 0; color: #1e293b; font-weight: 500;">{{ $recibido->asunto }}</p>
                </div>
                <div>
                    <span style="color: #64748b; font-size: 13px; font-weight: 600; text-transform: uppercase;">Observaciones de la Respuesta</span>
                    <p style="margin: 8px 0 0; color: #475569; padding: 12px; background: #ffffff; border-radius: 8px; border-left: 4px solid #00b5a3; font-style: italic;">
                        {{ $detalle->observaciones ?: 'Sin observaciones adicionales.' }}
                    </p>
                </div>
            </div>

            <p style="font-size: 16px; line-height: 1.6; color: #475569; margin-bottom: 35px;">
                Puede consultar el estado detallado y descargar archivos adjuntos de la respuesta a través de nuestro portal de consulta ciudadana.
            </p>

            <!-- Call to action -->
            <div style="text-align: center; margin-bottom: 20px;">
                <a href="{{ route('public.correspondencia.consultar') }}" style="display: inline-block; padding: 16px 32px; background-color: #000000; color: #ffffff; text-decoration: none; border-radius: 12px; font-weight: 600; font-size: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.15); transition: all 0.3s ease;">
                    Consultar en el Portal
                </a>
            </div>
            
            <p style="font-size: 13px; color: #94a3b8; text-align: center; margin-top: 40px; line-height: 1.5;">
                Si el botón no funciona, copie y pegue el siguiente enlace en su navegador:<br>
                <a href="{{ route('public.correspondencia.consultar') }}" style="color: #00b5a3;">{{ route('public.correspondencia.consultar') }}</a>
            </p>
        </div>

        <!-- Footer -->
        <div style="background-color: #f1f5f9; padding: 30px; text-align: center; border-top: 1px solid #e2e8f0;">
            <p style="margin: 0; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 1px;">
                EASYCOR - Gestión Documental Inteligente
            </p>
            <p style="margin: 10px 0 0; font-size: 11px; color: #94a3b8;">
                Nit Empresa: {{ $recibido->nit_empresa }} | © {{ date('Y') }} Todos los derechos reservados.
            </p>
        </div>
    </div>
</body>
</html>
