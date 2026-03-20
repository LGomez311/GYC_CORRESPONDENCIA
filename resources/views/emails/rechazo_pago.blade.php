<!DOCTYPE html>
<html>
<head>
    <title>Notificación de Pago Rechazado</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <h2 style="color: #d9534f; text-align: center;">Notificación de Pago Rechazado</h2>
        <p style="font-size: 16px; color: #333333;">Estimado administrador,</p>
        <p style="font-size: 16px; color: #333333;">Le informamos que el pago con identificador <strong>#{{ $pago->id_pago }}</strong> correspondiente al plan <strong>{{ $pago->plan?->nomb_plan ?? 'N / A' }}</strong> ha sido rechazado.</p>
        
        <div style="background-color: #fff3cd; border-left: 5px solid #ffc107; padding: 15px; margin: 20px 0;">
            <p style="margin: 0; font-size: 15px; font-weight: bold; color: #856404;">Motivo del rechazo:</p>
            <p style="margin: 10px 0 0 0; font-size: 15px; color: #856404;">{{ $pago->motivo_rechazo }}</p>
        </div>

        <p style="font-size: 16px; color: #333333;">Por favor, ingrese al sistema administrativo para revisar los detalles y subir un comprobante válido si es necesario.</p>

        <br>
        <p style="font-size: 14px; color: #777777; text-align: center;">Atentamente,<br>Equipo de Sistema de Correspondencia y Pagos</p>
    </div>
</body>
</html>
