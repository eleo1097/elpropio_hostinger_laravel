<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asunto: Solicitud de Cesantías Aprobada</title>
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
        <h1>Asunto: Solicitud de Cesantías Aprobada</h1>
        <p>Estimado(a) <strong> {{ $nombre_usuario }} </strong> ,</p>
        <p>Nos complace informarle que su solicitud de cesantías ha sido aprobada. El proceso de desembolso ha comenzado a gestionarse con la entidad en la que se encuentra afiliado.</p>
        <p>Justificación: {{ $justificacion }}</p>
        <p>Agradecemos su paciencia y confianza en nuestro servicio. Si tiene alguna pregunta o necesita más información, no dude en ponerse en contacto con nosotros a través de nomina@mxm.com.co o el cel. (+57) 317 4343975.</p>
        <p>Atentamente</p>
        <p>Talento Humano</p>
        <p>Supermercados Mas por Menos S.A.S.</p>
        <div class="footer">
            <p>Este es un mensaje automático, por favor no responder.</p>
        </div>
    </div>
</body>
</html>
