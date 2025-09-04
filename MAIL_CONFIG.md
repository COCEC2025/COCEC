# Configuration des Emails - COCEC Finance Digitale

## 📧 Configuration des Emails

Ce système envoie automatiquement des emails de confirmation et de notification lors de la soumission des formulaires de finance digitale.

### 🔧 Variables d'Environnement Requises

Ajoutez ces variables dans votre fichier `.env` :

```env
# Configuration Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre-email@gmail.com
MAIL_PASSWORD=votre-mot-de-passe-app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=finance-digitale@cocectogo.org
MAIL_FROM_NAME="COCEC - Finance Digitale"

# Email de notification admin
ADMIN_EMAIL=info@cocectogo.org
```

### 📬 Types d'Emails Envoyés

#### 1. **Fiche de Mise à Jour** (`DigitalFinanceUpdate`)
- **Email client** : Confirmation de réception (si email fourni)
- **Email admin** : Notification de nouvelle demande

#### 2. **Contrat d'Adhésion** (`DigitalFinanceContract`)
- **Email client** : Confirmation de réception (si email fourni)
- **Email admin** : Notification de nouveau contrat

### 🎨 Templates d'Emails

Les templates sont situés dans `resources/views/mails/` :
- `digital_finance_update.blade.php` - Confirmation client (mise à jour)
- `digital_finance_update_notification.blade.php` - Notification admin (mise à jour)
- `digital_finance_contract.blade.php` - Confirmation client (contrat)
- `digital_finance_contract_notification.blade.php` - Notification admin (contrat)

### 🚀 Test des Emails

Pour tester le système d'emails :

1. **Configuration locale** : Utilisez `MAIL_MAILER=log` pour sauvegarder les emails dans `storage/logs/laravel.log`
2. **Configuration SMTP** : Configurez un serveur SMTP réel (Gmail, SendGrid, etc.)
3. **Configuration production** : Utilisez des services comme Amazon SES, Mailgun, ou Postmark

### 📝 Exemple de Configuration Gmail

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre-email@gmail.com
MAIL_PASSWORD=votre-mot-de-passe-app-gmail
MAIL_ENCRYPTION=tls
```

**Note** : Pour Gmail, utilisez un "mot de passe d'application" et non votre mot de passe principal.

### 🔍 Logs et Débogage

Les erreurs d'envoi d'emails sont automatiquement loggées dans `storage/logs/laravel.log` avec le préfixe :
- `Erreur envoi mail confirmation: `
- `Erreur envoi mail notification admin: `

### ✅ Vérification

Après configuration, testez en soumettant un formulaire :
1. Vérifiez que l'email client est reçu (si email fourni)
2. Vérifiez que l'email admin est reçu à `info@cocectogo.org`
3. Vérifiez les logs en cas d'erreur

### 🎯 Personnalisation

Pour modifier les emails :
- **Contenu** : Éditez les fichiers dans `resources/views/mails/`
- **Destinataires** : Modifiez les contrôleurs dans `app/Http/Controllers/`
- **Sujets** : Modifiez les classes Mail dans `app/Mail/`
