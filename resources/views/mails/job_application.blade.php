<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Confirmation de candidature</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; background-color: #f9f9f9; padding: 30px;">
    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
        
        <!-- En-tête avec logo -->
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="color: #2c3e50; margin: 0; font-size: 1.5em;">COCEC</h2>
            <p style="color: #7f8c8d; margin: 5px 0 0 0; font-size: 0.9em;">Confirmation de candidature</p>
        </div>
        
        <!-- Salutation personnalisée -->
        <h3 style="color: #333; margin-bottom: 20px;">
            Bonjour {{ $first_name }} {{ $last_name }},
        </h3>
        
        <!-- Message principal -->
        <div style="background-color: #f8f9fa; padding: 20px; border-radius: 6px; margin: 20px 0;">
            <h1 style="font-size: 1.4em; color: #2c3e50; margin: 0 0 15px 0; text-align: center;">
                ✅ Votre candidature a été reçue avec succès !
            </h1>
            
            <p style="color: #555; font-size: 1em; margin: 15px 0;">
                Nous avons bien reçu votre candidature pour le poste de <strong>{{ $application_type }}</strong>.
            </p>
            
            <p style="color: #555; font-size: 1em; margin: 15px 0;">
                Notre équipe va examiner votre profil avec attention. Si votre candidature correspond à nos besoins, 
                nous vous contacterons dans les plus brefs délais pour la suite du processus de recrutement.
            </p>
        </div>
        
        <!-- Informations importantes -->
        <div style="border-left: 4px solid #3498db; padding-left: 20px; margin: 25px 0;">
            <h4 style="color: #2c3e50; margin: 0 0 10px 0;">📋 Prochaines étapes :</h4>
            <ul style="color: #555; margin: 0; padding-left: 20px;">
                <li>Examen de votre candidature par notre équipe RH</li>
                <li>Contact sous 5-7 jours ouvrables si votre profil nous intéresse</li>
                <li>Entretien téléphonique ou en présentiel</li>
            </ul>
        </div>
        
        <!-- Contact -->
        <div style="background-color: #ecf0f1; padding: 15px; border-radius: 6px; margin: 20px 0;">
            <p style="color: #555; font-size: 0.9em; margin: 0;">
                <strong>Questions ?</strong> N'hésitez pas à nous contacter à l'adresse : 
                <a href="mailto:recrutement@cocec.com" style="color: #3498db;">recrutement@cocec.com</a>
            </p>
        </div>
        
        <!-- Signature -->
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ecf0f1;">
            <p style="color: #555; font-size: 0.9em; margin: 0;">
                Cordialement,<br>
                <strong>L'équipe RH de COCEC</strong>
            </p>
        </div>
        
        <!-- Pied de page -->
        <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #ecf0f1;">
            <p style="font-size: 0.8em; color: #95a5a6; margin: 0;">
                &copy; {{ date('Y') }} COCEC. Tous droits réservés.<br>
                Site web : <a href="https://www.cocectogo.org" style="color: #EC281C;">www.cocectogo.org</a><br>
                Cet email a été envoyé à {{ $email }}
            </p>
        </div>
    </div>
</body>

</html>
