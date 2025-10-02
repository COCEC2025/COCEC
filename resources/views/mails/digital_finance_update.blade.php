<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de votre demande - COCEC Finance Digitale</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #EC281C;
        }
        .logo {
            color: #EC281C;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .title {
            color: #EC281C;
            font-size: 20px;
            margin-bottom: 10px;
        }
        .content {
            margin-bottom: 30px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 14px;
        }
        .highlight {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #EC281C;
            margin: 20px 0;
        }
        .contact-info {
            background-color: #e8f4fd;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">COCEC</div>
            <div class="title">Finance Digitale</div>
            <div style="color: #666;">La microfinance autrement</div>
        </div>

        <div class="content">
            <p>Bonjour <strong>{{ $full_name }}</strong>,</p>

            <p>Nous avons bien reçu votre demande de mise à jour et de souscription aux services de finance digitale de la COCEC.</p>

            <div class="highlight">
                <p><strong>Votre demande a été enregistrée avec succès !</strong></p>
                <p>Notre équipe va examiner votre formulaire et vous contacter dans les plus brefs délais pour finaliser votre souscription.</p>
            </div>

            <p><strong>Prochaines étapes :</strong></p>
            <ul>
                <li>Vérification de vos informations</li>
                <li>Validation de votre compte COCEC</li>
                <li>Activation de vos services digitaux</li>
                <li>Envoi de vos identifiants de connexion</li>
            </ul>

            <div class="contact-info">
                <p><strong>Besoin d'aide ?</strong></p>
                <p>N'hésitez pas à nous contacter :</p>
                <p>📞 Téléphone : +228 91 12 64 71 / +228 22 71 41 48</p>
                <p>📧 Email : finance-digitale@cocectogo.org</p>
                <p>📍 Adresse : Lomé, KANYIKOPE à 50 m du Lycée FOLLY-BEBE</p>
            </div>

            <p>Merci de votre confiance en la COCEC !</p>
        </div>

        <div class="footer">
            <p><strong>COCEC - COOPERATIVE CHRETIENNE D'EPARGNE ET DE CREDIT</strong></p>
            <p>Agréée suivant Arrêté 016/MEFP/SG/CAS-IMEC du 26/02/2006</p>
            <p>Inscrite sur le registre des IMCEC sous le N° T/1/GFLM/2006/128 A</p>
        </div>
    </div>
</body>
</html>
