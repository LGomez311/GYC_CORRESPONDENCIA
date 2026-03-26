<!DOCTYPE html>
<html>
<head>
    <title>Pago Aprobado</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <h2 style="color: #2e7d32; text-align: center;">¡Su pago ha sido aprobado!</h2>
        
        <p>Estimado/a <strong>{{ $pago->admin ? $pago->admin->emple_nombres . ' ' . $pago->admin->emple_apellidos : 'Usuario' }}</strong>,</p>
        
        <p>Nos complace informarle que su pago con ID <strong>{{ $pago->id_pago }}</strong> correspondiente al plan <strong>{{ $pago->plan ? $pago->plan->nombre_plan : 'Suscripción' }}</strong> ha sido verificado y aprobado exitosamente.</p>
        
        <p>Su licencia ha sido generada o renovada adecuadamente en nuestro sistema. Ahora puede continuar operando sin interrupciones.</p>
        
        <p>Agradecemos su confianza en nosotros.</p>
        
        <br>
        <p>Atentamente,<br><strong>EASYCOR</strong></p>
    </div>
</body>
</html>
