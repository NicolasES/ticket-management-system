<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitação Registrada</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #edf2f7;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #2d3748;
            font-size: 24px;
            margin: 0;
        }
        .content {
            font-size: 16px;
            color: #4a5568;
        }
        .ticket-id {
            display: inline-block;
            background: #ebf8ff;
            color: #2b6cb0;
            padding: 4px 12px;
            border-radius: 6px;
            font-weight: bold;
            margin: 10px 0;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 14px;
            color: #a0aec0;
            border-top: 1px solid #edf2f7;
            padding-top: 20px;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4299e1;
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin-top: 20px;
            transition: background-color 0.2s;
        }
        .button:hover {
            background-color: #3182ce;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Sua solicitação foi registrada!</h1>
        </div>
        <div class="content">
            <p>Olá,</p>
            <p>Sua solicitação foi registrada com sucesso em nosso sistema de tickets. A equipe já foi notificada.</p>
            
            <p><strong>Assunto:</strong> {{ $ticket->getTitle() }}</p>
            <p><strong>Departamento:</strong> {{ $department->getName() }}</p>
            <p><strong>Status:</strong> <span style="color: #0707ffff;">Pendente</span></p>
            
            <p>Você pode acompanhar o progresso através do portal:</p>
            
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. Todos os direitos reservados.
        </div>
    </div>
</body>
</html>
