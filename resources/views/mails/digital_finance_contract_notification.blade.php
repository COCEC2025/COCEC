<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau contrat d'adhésion - COCEC Finance Digitale</title>
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
        .alert {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .info-box {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #EC281C;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">COCEC</div>
            <div class="title">Finance Digitale - Notification</div>
            <div style="color: #666;">La microfinance autrement</div>
        </div>

        <div class="alert">
            <strong>🚨 NOUVEAU CONTRAT RECU !</strong><br>
            Un nouveau contrat d'adhésion aux services de finance digitale vient d'être soumis.
        </div>

        <div class="info-box">
            <h3>📋 Informations du souscripteur :</h3>
            <p><strong>Nom complet :</strong> {{ $full_name }}</p>
            <p><strong>N° Compte :</strong> {{ $account_number }}</p>
            <p><strong>Téléphone :</strong> {{ $phone }}</p>
            @if($email)
                <p><strong>Email :</strong> {{ $email }}</p>
            @endif
        </div>

        <p><strong>Action requise :</strong></p>
        <ul>
            <li>Vérifier les informations du souscripteur</li>
            <li>Valider le compte COCEC</li>
            <li>Contacter le client pour finaliser l'adhésion</li>
            <li>Activer les services digitaux souscrits</li>
            <li>Préparer les identifiants BINDOO</li>
        </ul>

        <p><strong>Accès au contrat :</strong></p>
        <p>Connectez-vous à votre espace administrateur pour consulter les détails complets de ce contrat.</p>
        
        <div style="text-align: center; margin: 20px 0;">
            <a href="https://www.cocectogo.org/admin" style="display: inline-block; padding: 12px 30px; background-color: #EC281C; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;">
                Accéder à l'interface admin
            </a>
        </div>

        <div class="footer">
            <p><strong>COCEC - COOPERATIVE CHRETIENNE D'EPARGNE ET DE CREDIT</strong></p>
            <p>Site web : <a href="https://www.cocectogo.org" style="color: #EC281C;">www.cocectogo.org</a></p>
            <p>Agréée suivant Arrêté 016/MEFP/SG/CAS-IMEC du 26/02/2006</p>
            <p>Inscrite sur le registre des IMCEC sous le N° T/1/GFLM/2006/128 A</p>
        </div>
    </div>
</body>
</html>
