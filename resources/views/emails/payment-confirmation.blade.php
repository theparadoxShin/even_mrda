<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de paiement</title>
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
        .qr-section {
            background: #dbeafe;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin: 20px 0;
        }
        .event-details {
            background: #f1f5f9;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .success-icon {
            color: #10b981;
            font-size: 48px;
            margin-bottom: 20px;
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
        .highlight {
            color: #2563eb;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="header">
    <div class="success-icon">✓</div>
    <h1>Paiement Confirmé !</h1>
    <p>Votre inscription à l'événement a été validée</p>
</div>

<div class="content">
    <h2>Bonjour {{ $registration->first_name }},</h2>

    <p>Félicitations ! Votre paiement a été traité avec succès et votre inscription à l'événement <strong class="highlight">{{ $event->name }}</strong> est maintenant confirmée.</p>

    <div class="event-details">
        <h3>📅 Détails de l'événement</h3>
        <ul style="list-style: none; padding: 0;">
            <li><strong>Événement :</strong> {{ $event->name }}</li>
            <li><strong>Date :</strong> {{ $event->event_date->format('d/m/Y à H:i') }}</li>
            <li><strong>Participant :</strong> {{ $registration->full_name }}</li>
            <li><strong>Email :</strong> {{ $registration->email }}</li>
            <li><strong>Montant payé :</strong> ${{ number_format($event->price, 2) }} CAD</li>
        </ul>
    </div>

    <div class="qr-section">
        <h3>🎫 Votre QR Code d'entrée</h3>
        <p>Présentez ce QR code à l'entrée de l'événement. Vous pouvez l'imprimer ou le montrer sur votre téléphone.</p>
        <p><strong>Important :</strong> Conservez précieusement ce QR code, il vous servira de billet d'entrée.</p>
    </div>

    <h3>📋 Instructions importantes :</h3>
    <ul>
        <li>Arrivez 15 minutes avant le début de l'événement</li>
        <li>Présentez votre QR code à l'accueil</li>
        <li>Conservez cet email comme preuve de votre inscription</li>
    </ul>

    <p>Si vous avez des questions, n'hésitez pas à nous contacter.</p>

    <p>Nous avons hâte de vous voir à l'événement !</p>

    <p><strong>L'équipe Chorale</strong></p>
</div>

<div class="footer">
    <p style="margin: 0; color: #64748b;">
        Cet email a été envoyé automatiquement. Merci de ne pas y répondre.
    </p>
    <p style="margin: 5px 0 0 0; color: #64748b;">
        © {{ date('Y') }} Chorale App - Tous droits réservés
    </p>
</div>
</body>
</html>
