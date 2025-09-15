<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre compte COCEC a été créé</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #EC281C;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            max-width: 150px;
            height: auto;
        }
        .company-name {
            color: #EC281C;
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }
        .subtitle {
            color: #666;
            font-size: 16px;
            margin: 0;
        }
        .content {
            margin: 30px 0;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #EC281C;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .credentials {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 20px;
            margin: 20px 0;
        }
        .credential-item {
            margin: 10px 0;
            font-size: 16px;
        }
        .credential-label {
            font-weight: bold;
            color: #856404;
        }
        .credential-value {
            font-family: 'Courier New', monospace;
            background-color: #fff;
            padding: 5px 10px;
            border-radius: 3px;
            border: 1px solid #ddd;
            color: #333;
        }
        .warning {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
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
        .button {
            display: inline-block;
            background-color: #EC281C;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
        }
        .button:hover {
            background-color: #d4241a;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <img src="{{ asset('assets/images/Logo.png') }}" alt="COCEC Logo" class="logo">
            <div class="company-name">COCEC</div>
            <p class="subtitle">Coopérative Chrétienne d'Épargne et de Crédit</p>
        </div>

        <div class="content">
            <div class="greeting">
                Bonjour <strong>{{ $name }}</strong>,
            </div>

            <p>Votre compte utilisateur a été créé avec succès sur la plateforme COCEC.</p>

            <div class="info-box">
                <p><strong>Rôle attribué :</strong> {{ $role ?? 'Utilisateur' }}</p>
                @if($phone_num)
                    <p><strong>Téléphone :</strong> {{ $phone_num }}</p>
                @endif
            </div>

            <div class="credentials">
                <h3 style="color: #856404; margin-top: 0;">🔐 Vos identifiants de connexion</h3>
                
                <div class="credential-item">
                    <span class="credential-label">Adresse email :</span>
                    <span class="credential-value">{{ $email }}</span>
                </div>
                
                <div class="credential-item">
                    <span class="credential-label">Mot de passe :</span>
                    <span class="credential-value">{{ $password }}</span>
                </div>
            </div>

            <div class="warning">
                <strong>⚠️ Important :</strong> 
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li>Conservez précieusement ces identifiants</li>
                    <li>Changez votre mot de passe après votre première connexion</li>
                    <li>Ne partagez jamais vos identifiants avec d'autres personnes</li>
                </ul>
            </div>

            <p>Vous pouvez maintenant vous connecter à votre compte en utilisant les identifiants ci-dessus.</p>

            <div style="text-align: center;">
                <a href="https://www.cocectogo.org/admin" class="button">Se connecter à l'interface admin</a>
            </div>

            <p>Si vous avez des questions ou besoin d'assistance, n'hésitez pas à contacter l'équipe technique.</p>
        </div>

        <div class="footer">
            <p><strong>COCEC - Coopérative Chrétienne d'Épargne et de Crédit</strong></p>
            <p>Site web : <a href="https://www.cocectogo.org" style="color: #EC281C;">www.cocectogo.org</a></p>
            <p>Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
            <p>© {{ date('Y') }} COCEC. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>
