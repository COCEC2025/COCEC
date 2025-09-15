<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nouveau message de contact</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; background-color: #f9f9f9; padding: 30px;">
    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
        
        <!-- En-tête avec logo -->
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="color: #2c3e50; margin: 0; font-size: 1.5em;">COCEC</h2>
            <p style="color: #7f8c8d; margin: 5px 0 0 0; font-size: 0.9em;">Service Client</p>
        </div>
        
        <!-- Salutation -->
        <h3 style="color: #333; margin-bottom: 20px;">
            Bonjour Équipe Support,
        </h3>
        
        <!-- Message principal -->
        <div style="background-color: #e3f2fd; padding: 20px; border-radius: 6px; margin: 20px 0; border-left: 4px solid #2196f3;">
            <h1 style="font-size: 1.4em; color: #1565c0; margin: 0 0 15px 0; text-align: center;">
                📧 Nouveau message de contact reçu !
            </h1>
            
            <p style="color: #1565c0; font-size: 1em; margin: 15px 0;">
                Un nouveau message a été envoyé via le formulaire de contact du site web.
            </p>
        </div>
        
        <!-- Informations de l'expéditeur -->
        <div style="background-color: #f8f9fa; padding: 20px; border-radius: 6px; margin: 20px 0;">
            <h4 style="color: #2c3e50; margin: 0 0 15px 0;">👤 Informations de l'expéditeur :</h4>
            
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 8px 0; color: #555; font-weight: bold; width: 40%;">Nom complet :</td>
                    <td style="padding: 8px 0; color: #333;">{{ $fullname ?? 'Non renseigné' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #555; font-weight: bold;">Email :</td>
                    <td style="padding: 8px 0; color: #333;">
                        <a href="mailto:{{ $email }}" style="color: #3498db;">{{ $email }}</a>
                    </td>
                </tr>

                <tr>
                    <td style="padding: 8px 0; color: #555; font-weight: bold;">Sujet :</td>
                    <td style="padding: 8px 0; color: #333;">{{ $subject ?? 'Aucun sujet' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #555; font-weight: bold;">Date d'envoi :</td>
                    <td style="padding: 8px 0; color: #333;">{{ date('d/m/Y à H:i') }}</td>
                </tr>
            </table>
        </div>
        
        <!-- Message -->
        <div style="background-color: #fff8e1; padding: 20px; border-radius: 6px; margin: 20px 0; border-left: 4px solid #ff9800;">
            <h4 style="color: #2c3e50; margin: 0 0 15px 0;">💬 Message :</h4>
            <div style="background-color: #ffffff; padding: 15px; border-radius: 4px; border: 1px solid #e0e0e0;">
                <p style="color: #333; font-size: 1em; margin: 0; line-height: 1.6; white-space: pre-wrap;">
                    {{ $message ?? 'Aucun message' }}
                </p>
            </div>
        </div>
        
        <!-- Actions à effectuer -->
        <div style="border-left: 4px solid #4caf50; padding-left: 20px; margin: 25px 0;">
            <h4 style="color: #2c3e50; margin: 0 0 10px 0;">📋 Actions recommandées :</h4>
            <ul style="color: #555; margin: 0; padding-left: 20px;">
                <li>Analyser la demande du client</li>
                <li>Identifier le service concerné</li>
                <li>Préparer une réponse appropriée</li>
                <li>Faire un retour au client.</li>
            </ul>
        </div>
        
        <!-- Réponse rapide -->
        <div style="background-color: #e8f5e8; padding: 15px; border-radius: 6px; margin: 20px 0; border-left: 4px solid #4caf50;">
            <p style="color: #2e7d32; font-size: 0.9em; margin: 0;">
                <strong>⚡ Réponse rapide :</strong> Pour répondre directement, cliquez sur l'email de l'expéditeur ci-dessus 
            </p>
        </div>
        
        
        <!-- Signature -->
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ecf0f1;">
            <p style="color: #555; font-size: 0.9em; margin: 0;">
                Cordialement,<br>
                <strong>Système de contact COCEC</strong>
            </p>
        </div>
        
        <!-- Pied de page -->
        <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #ecf0f1;">
            <p style="font-size: 0.8em; color: #95a5a6; margin: 0;">
                &copy; {{ date('Y') }} COCEC. Tous droits réservés.<br>
                Site web : <a href="https://www.cocectogo.org" style="color: #EC281C;">www.cocectogo.org</a><br>
                Cet email est généré automatiquement - Ne pas répondre directement
            </p>
        </div>
    </div>
</body>

</html>
