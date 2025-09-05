<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau message de contact</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: white;
            padding: 30px;
            border: 1px solid #e2e8f0;
        }
        .footer {
            background: #f8fafc;
            padding: 20px;
            text-align: center;
            border-radius: 0 0 10px 10px;
            border: 1px solid #e2e8f0;
            border-top: none;
        }
        .info-box {
            background: #dbeafe;
            border: 1px solid #2563eb;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .message-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 20px;
            border-radius: 8px;
            margin: 15px 0;
            font-style: italic;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>📧 Nouveau Message de Contact</h1>
    <p>Reçu depuis le site web</p>
</div>

<div class="content">
    <h2>Nouveau message reçu</h2>

    <div class="info-box">
        <h3>📋 Informations de contact :</h3>
        <ul>
            <li><strong>Nom :</strong> {{ $contactData['name'] }}</li>
            <li><strong>Email :</strong> {{ $contactData['email'] }}</li>
            <li><strong>Sujet :</strong> {{ $contactData['subject'] }}</li>
        </ul>
    </div>

    <h3>💬 Message :</h3>
    <div class="message-box">
        {{ $contactData['message'] }}
    </div>

    <p><strong>Vous pouvez répondre directement à cet email.</strong></p>

    <hr style="margin: 30px 0; border: none; border-top: 1px solid #e2e8f0;">
    
    <p style="color: #64748b; font-size: 0.9em;">
        Reçu le {{ now()->format('d/m/Y à H:i') }} depuis le formulaire de contact du site web.
    </p>
</div>

<div class="footer">
    <p style="margin: 0; color: #64748b;">
        Chorale MRDA - Système de contact automatique
    </p>
</div>
</body>
</html>