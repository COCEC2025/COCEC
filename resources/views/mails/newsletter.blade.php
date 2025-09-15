<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Abonnement à la newsletter</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; background-color: #f9f9f9; padding: 30px;">
    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05); text-align: center;">
        <h3 style="color: #333;">Bonjour, {{ $email }}</h3>
        
        <h1 style="font-size: 1.8em; color: #2c3e50; margin: 20px 0;">
            Merci pour votre inscription à notre newsletter !
        </h1>
        
        <p style="color: #555; font-size: 1em;">
            Vous recevrez désormais nos actualités, conseils, et informations importantes directement dans votre boîte de réception.
        </p>

        <p style="color: #777; font-size: 0.9em; margin-top: 30px;">
            Si vous n’avez pas effectué cette inscription, veuillez ignorer ce message ou nous contacter.
        </p>

        <p style="font-size: 0.8em; color: #aaa; margin-top: 20px;">
            &copy; {{ date('Y') }} COCEC. Tous droits réservés.<br>
            Site web : <a href="https://www.cocectogo.org" style="color: #EC281C;">www.cocectogo.org</a>
        </p>
    </div>
</body>

</html>
