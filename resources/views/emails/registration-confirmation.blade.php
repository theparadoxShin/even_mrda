<!DOCTYPE html>
<!-- resources/views/emails/registration-confirmation.blade.php -->
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription confirmée</title>
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
        .warning-box {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .btn {
            display: inline-block;
            background: #2563eb;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 25px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>🎵 Inscription Enregistrée</h1>
    <p>Votre inscription est en attente de paiement</p>
</div>

<div class="content">
    <h2>Bonjour {{ $registration->first_name }},</h2>

    <p>Merci pour votre inscription à l'événement <strong>{{ $registration->event->name }}</strong>.</p>

    <div class="warning-box">
        <h3>⚠️ Paiement requis</h3>
        <p><strong>Votre inscription n'est pas encore confirmée.</strong> Pour finaliser votre participation, vous devez effectuer le paiement de <strong>${{ number_format($registration->event->price, 2) }} CAD par virement interac à l'adresse/numéro : carelletchoumi@yahoo.fr /+1 (438) 491-8227 </strong>.</p>
    </div>

    <h3>📅 Détails de l'événement :</h3>
    <ul>
        <li><strong>Événement :</strong> {{ $registration->event->name }}</li>
        <li><strong>Date :</strong> {{ $registration->event->event_date->format('d/m/Y à H:i') }}</li>
        <li><strong>Prix :</strong> ${{ number_format($registration->event->price, 2) }} CAD</li>
    </ul>

    <h3>👤 Vos informations :</h3>
    <ul>
        <li><strong>Nom :</strong> {{ $registration->full_name }}</li>
        <li><strong>Email :</strong> {{ $registration->email }}</li>
        <li><strong>Téléphone :</strong> {{ $registration->phone }}</li>
    </ul>

    <p>Une fois votre paiement traité, vous recevrez un email de confirmation avec votre QR code d'entrée.</p>

    <p><strong>L'équipe Marie Reine Des Apôtres</strong></p>
</div>

<div class="footer">
    <p style="margin: 0; color: #64748b;">
        Cet email a été envoyé automatiquement. Merci de ne pas y répondre.
    </p>
    <p style="margin: 5px 0 0 0; color: #64748b;">
        © {{ date('Y') }} MRDA - Tous droits réservés - Build with ❤️ by <a href="https://parfaittedomtedom.com" target="_blank" class="text-warning text-decoration-none opacity-90 fw-bold">Parfait Tedom Tedom</a>
    </p>
</div>

</body>
</html>
