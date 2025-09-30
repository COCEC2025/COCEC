# Configuration reCAPTCHA pour COCEC

## Étapes de configuration

### 1. Obtenir les clés reCAPTCHA

1. Rendez-vous sur [Google reCAPTCHA Admin Console](https://www.google.com/recaptcha/admin)
2. Cliquez sur "+" pour créer un nouveau site
3. Remplissez les informations :
   - **Label** : COCEC Website
   - **Type de reCAPTCHA** : reCAPTCHA v3
   - **Domaines** : 
     - `cocectogo.org` (production)
     - `localhost` (développement)
     - `127.0.0.1` (développement local)
4. Acceptez les conditions d'utilisation
5. Cliquez sur "Submit"

### 2. Configuration des variables d'environnement

Ajoutez ces variables à votre fichier `.env` :

```env
# Google reCAPTCHA Configuration
RECAPTCHA_SITE_KEY=votre_clé_site_ici
RECAPTCHA_SECRET_KEY=votre_clé_secrète_ici
RECAPTCHA_SCORE_THRESHOLD=0.5
```

### 3. Actions configurées

Les actions suivantes sont configurées pour chaque formulaire :

- `contact_form` : Formulaire de contact
- `job_application` : Candidatures d'emploi
- `newsletter_subscription` : Inscription newsletter
- `complaint_form` : Formulaire de plainte
- `faq_comment` : Commentaires FAQ

### 4. Seuils de sécurité

- **Score minimum** : 0.5 (recommandé)
  - 0.0 = Très probablement un bot
  - 1.0 = Très probablement un humain
- **Rate Limiting** :
  - Contact : 3 soumissions / 10 minutes
  - Candidatures : 2 soumissions / 30 minutes
  - Plaintes : 2 soumissions / 60 minutes
  - Newsletter : 5 soumissions / 5 minutes
  - Commentaires FAQ : 10 soumissions / 5 minutes

### 5. Champs honeypot

Chaque formulaire inclut des champs cachés pour détecter les bots :
- `website_url` (champ texte caché)
- `phone_number` (champ téléphone caché)

### 6. Test en mode développement

En mode développement (clés non configurées), le système :
- Accepte toutes les soumissions
- Log les tentatives de vérification
- Utilise un token de développement

### 7. Monitoring

Les logs de sécurité sont enregistrés dans :
- `storage/logs/laravel.log`
- Recherchez les entrées avec "reCAPTCHA" pour le monitoring

## Dépannage

### Erreur "reCAPTCHA not configured"
- Vérifiez que les clés sont correctement définies dans `.env`
- Redémarrez le serveur après modification du `.env`

### Erreur "Score too low"
- Ajustez `RECAPTCHA_SCORE_THRESHOLD` (valeur entre 0.0 et 1.0)
- Valeur recommandée : 0.5

### Erreur "Action mismatch"
- Vérifiez que l'action dans le composant Blade correspond à la configuration

## Support

Pour toute question technique, contactez l'équipe de développement.
