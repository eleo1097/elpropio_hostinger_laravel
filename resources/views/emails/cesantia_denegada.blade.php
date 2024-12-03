<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asunto: Solicitud de Cesantías Denegada</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 30px;
            max-width: 600px;
            margin: 0 auto;
        }
        h1 {
            color: #333333;
        }
        p {
            color: #666666;
            line-height: 1.6;
        }
        .footer {
            margin-top: 20px;
            font-size: 0.8em;
            color: #999999;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Asunto: Solicitud de Cesantías Denegada</h1>
        <p>Estimado(a) <strong>{{ $nombre_usuario }}</strong>,</p>
        <p>Lamentamos informarle que su solicitud de cesantías ha sido denegada debido a inconsistencias en los soportes entregados. Para continuar con el proceso, por favor revise los siguientes puntos y presente los documentos correctos:</p>
        <p><strong>[observaciones]:</strong> {{ $justificacion }}</p>
        
        <p>Puede reenviar los documentos a través de nuestra plataforma o contactarnos directamente para obtener más detalles y asistencia.</p>
        <p>Agradecemos su comprensión y colaboración. Si tiene alguna pregunta, no dude en comunicarse con nosotros a través de  nomina@mxm.com.co o el cel. (+57) 317 4343975.</p>
        <p>Atentamente</p>
        <p>Talento Humano</p>
        <p>Supermercados Mas por Menos S.A.S.</p>
        <div class="footer">
            <p>Este es un mensaje automático, por favor no responder.</p>
        </div>
    </div>
</body>
</html>
