<!DOCTYPE html>
<!-- resources/views/success.blade.php -->
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Réussi - Chorale App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #2563eb;
            --light-blue: #dbeafe;
            --dark-blue: #1e40af;
            --white: #ffffff;
            --success-green: #10b981;
        }

        body {
            background: linear-gradient(135deg, var(--light-blue) 0%, var(--white) 100%);
            min-height: 100vh;
            font-family: 'Arial', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .success-card {
            background: var(--white);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 60px 40px;
            text-align: center;
            max-width: 600px;
            width: 100%;
            margin: 20px;
        }

        .success-icon {
            background: var(--success-green);
            color: var(--white);
            width: 120px;
            height: 120px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            font-size: 3rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: var(--white) !important;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
        }

        .btn-primary-custom:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.4);
            color: var(--white) !important;
        }

        .btn-outline-custom {
            border: 2px solid var(--primary-blue);
            color: var(--primary-blue);
            background: transparent;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
        }

        .btn-outline-custom:hover {
            background: var(--primary-blue);
            color: var(--white) !important;
            transform: scale(1.05);
        }

        .info-box {
            background: var(--light-blue);
            border-radius: 15px;
            padding: 20px;
            margin: 30px 0;
            border-left: 4px solid var(--primary-blue);
        }
    </style>
</head>
<body>
<div class="success-card">
    <div class="success-icon">
        <i class="fas fa-check"></i>
    </div>

    <h1 class="h2 fw-bold text-success mb-3">Paiement Réussi !</h1>
    <p class="lead text-muted mb-4">
        Félicitations ! Votre inscription a été confirmée avec succès.
    </p>

    <div class="info-box">
        <h5 class="fw-bold text-primary mb-3">
            <i class="fas fa-info-circle me-2"></i>Que se passe-t-il maintenant ?
        </h5>
        <ul class="text-start text-muted">
            <li class="mb-2">✅ Vous allez recevoir un email de confirmation</li>
            <li class="mb-2">🎫 Votre QR code d'entrée sera joint à l'email</li>
            <li class="mb-2">📱 Vous recevrez des rappels avant l'événement</li>
            <li class="mb-2">🎵 Préparez-vous à vivre une expérience musicale unique !</li>
        </ul>
    </div>

    <div class="d-flex justify-content-center flex-wrap">
        <a href="{{ url('/') }}" class="btn btn-primary-custom">
            <i class="fas fa-home me-2"></i>Retour à l'accueil
        </a>
        <button onclick="window.close()" class="btn btn-outline-custom">
            <i class="fas fa-times me-2"></i>Fermer cette page
        </button>
    </div>

    <div class="mt-4">
        <small class="text-muted">
            <i class="fas fa-envelope me-1"></i>
            Vous n'avez pas reçu d'email ? Vérifiez vos spams ou contactez-nous.
        </small>
    </div>
</div>

<script>
    // Redirection automatique après 30 secondes
    setTimeout(function() {
        if (confirm('Voulez-vous être redirigé vers la page d\'accueil ?')) {
            window.location.href = '{{ url('/') }}';
        }
    }, 30000);
</script>
</body>
</html>
