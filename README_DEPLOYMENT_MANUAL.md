# 🚀 Guide de Déploiement Manuel - COCEC

Ce guide vous explique comment déployer manuellement l'application COCEC sur votre serveur de production.

## 📋 Prérequis

- Serveur avec PHP 8.1+ et MySQL
- Composer installé
- Node.js et npm (pour la compilation des assets)
- Accès SSH au serveur
- Base de données MySQL configurée

## 🔧 Configuration Initiale

### 1. Variables d'environnement

Assurez-vous que votre fichier `.env` est configuré correctement :

```bash
APP_NAME=COCEC
APP_ENV=production
APP_KEY=base64:VOTRE_CLE_ICI
APP_DEBUG=false
APP_URL=https://tg.cocectogo.org

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=cocerbbe_cocec_db
DB_USERNAME=cocerbbe_cocec_website
DB_PASSWORD=X61UbfSgC1Ji2w

# Configuration mail
MAIL_MAILER=smtp
MAIL_HOST=mail.cocectogo.org
MAIL_PORT=465
MAIL_USERNAME=infos@cocectogo.org
MAIL_PASSWORD=C0cec@2025!
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=infos@cocectogo.org
MAIL_FROM_NAME="COCEC"
```

## 🚀 Processus de Déploiement

### Étape 1 : Préparation du serveur

```bash
# Définir le chemin de destination
export DEPLOYPATH=/home/cocerbbe/tg.cocectogo.org/public

# Créer le dossier temporaire pour le build
mkdir -p /tmp/laravel-build
```

### Étape 2 : Copie des fichiers

```bash
# Aller dans le dossier racine du projet
cd /home/cocerbbe/tg.cocectogo.org

# Copier tous les fichiers vers le dossier temporaire
/bin/cp -R * /tmp/laravel-build/

# Aller dans le dossier temporaire
cd /tmp/laravel-build
```

### Étape 3 : Installation des dépendances PHP

```bash
# Installer les dépendances avec Composer (mode production)
composer install --no-dev --optimize-autoloader
```

### Étape 4 : Compilation des assets (à faire localement)

**Sur votre machine locale :**

```bash
# Aller dans le dossier de votre projet
cd /chemin/vers/votre-projet

# Installer les dépendances npm
npm install

# Compiler les assets pour la production
npm run build
```

**Puis transférer le dossier `public/build` vers le serveur :**

```bash
# Via FTP/SFTP, copiez le dossier public/build vers :
# /home/cocerbbe/tg.cocectogo.org/public/build
```

### Étape 5 : Nettoyage des fichiers de développement

```bash
# Supprimer les fichiers non nécessaires en production
rm -rf tests .git .github storage/logs/* storage/framework/cache/* storage/framework/sessions/* storage/framework/views/*
```

### Étape 6 : Création des dossiers storage

```bash
# Créer les dossiers storage s'ils n'existent pas
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
```

### Étape 7 : Configuration des permissions

```bash
# Définir le propriétaire et les permissions
chown -R cocerbbe:cocerbbe storage
chown -R cocerbbe:cocerbbe bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Permissions pour les assets (si transférés)
chown -R cocerbbe:cocerbbe public/build
chmod -R 775 public/build
```

### Étape 8 : Déploiement sur le serveur

```bash
# Supprimer les anciens fichiers (ATTENTION : cela supprime tout dans $DEPLOYPATH)
/bin/rm -rf $DEPLOYPATH/*

# Copier tous les fichiers vers le serveur
/bin/cp -R * $DEPLOYPATH/

# Aller dans le dossier de destination
cd $DEPLOYPATH
```

### Étape 9 : Configuration Laravel

```bash
# Générer la clé d'application Laravel
php artisan key:generate --force

# Vider tous les caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### Étape 10 : Optimisation pour la production

```bash
# Optimiser l'application
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Étape 11 : Base de données

```bash
# Créer la table des sessions (si nécessaire)
php artisan session:table

# Exécuter les migrations
php artisan migrate --force

# Exécuter les seeders (optionnel)
composer require fakerphp/faker --dev
php artisan db:seed --force
```

### Étape 12 : Nettoyage final

```bash
# Supprimer le dossier temporaire
rm -rf /tmp/laravel-build
```

## 🔍 Vérifications Post-Déploiement

### 1. Vérifier l'application

```bash
# Tester l'application
curl -I https://tg.cocectogo.org

# Vérifier les logs
tail -f storage/logs/laravel.log
```

### 2. Vérifier la base de données

```bash
# Vérifier les tables créées
php artisan migrate:status

# Tester la connexion
php artisan tinker --execute="DB::connection()->getPdo();"
```

### 3. Vérifier les permissions

```bash
# Vérifier les permissions des dossiers
ls -la storage/
ls -la bootstrap/cache/
```

## 🛠️ Script de Déploiement Automatisé

Vous pouvez créer un script `deploy.sh` pour automatiser le processus :

```bash
#!/bin/bash

# Configuration
DEPLOYPATH="/home/cocerbbe/tg.cocectogo.org/public"
PROJECTPATH="/home/cocerbbe/tg.cocectogo.org"
BUILDPATH="/tmp/laravel-build"

echo "🚀 Début du déploiement COCEC..."

# Étape 1 : Préparation
echo "📁 Préparation des dossiers..."
mkdir -p $BUILDPATH
cd $PROJECTPATH

# Étape 2 : Copie des fichiers
echo "📋 Copie des fichiers..."
/bin/cp -R * $BUILDPATH/
cd $BUILDPATH

# Étape 3 : Installation des dépendances
echo "📦 Installation des dépendances PHP..."
composer install --no-dev --optimize-autoloader

# Étape 4 : Nettoyage
echo "🧹 Nettoyage des fichiers de développement..."
rm -rf tests .git .github storage/logs/* storage/framework/cache/* storage/framework/sessions/* storage/framework/views/*

# Étape 5 : Création des dossiers
echo "📂 Création des dossiers storage..."
mkdir -p storage/framework/{cache,sessions,views} storage/logs

# Étape 6 : Permissions
echo "🔐 Configuration des permissions..."
chown -R cocerbbe:cocerbbe storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Étape 7 : Déploiement
echo "🚀 Déploiement sur le serveur..."
/bin/rm -rf $DEPLOYPATH/*
/bin/cp -R * $DEPLOYPATH/
cd $DEPLOYPATH

# Étape 8 : Configuration Laravel
echo "⚙️ Configuration Laravel..."
php artisan key:generate --force
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Étape 9 : Optimisation
echo "⚡ Optimisation pour la production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Étape 10 : Base de données
echo "🗄️ Configuration de la base de données..."
php artisan migrate --force

# Étape 11 : Nettoyage
echo "🧹 Nettoyage final..."
rm -rf $BUILDPATH

echo "✅ Déploiement terminé avec succès !"
```

Pour utiliser le script :

```bash
# Rendre le script exécutable
chmod +x deploy.sh

# Exécuter le déploiement
./deploy.sh
```

## 🚨 Dépannage

### Problèmes courants

1. **Erreur de permissions** :
   ```bash
   chown -R cocerbbe:cocerbbe storage bootstrap/cache
   chmod -R 775 storage bootstrap/cache
   ```

2. **Erreur de base de données** :
   ```bash
   php artisan migrate:status
   php artisan migrate --force
   ```

3. **Erreur de cache** :
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

4. **Assets manquants** :
   - Vérifiez que le dossier `public/build` a été transféré
   - Vérifiez les permissions : `chmod -R 775 public/build`

### Logs utiles

```bash
# Logs de l'application
tail -f storage/logs/laravel.log

# Logs du serveur web
tail -f /var/log/apache2/error.log
# ou
tail -f /var/log/nginx/error.log
```

## 📞 Support

En cas de problème, vérifiez :

1. Les permissions des dossiers
2. La configuration de la base de données
3. Les logs d'erreur
4. La configuration du serveur web

---

**Note** : Ce guide est spécifique à l'application COCEC. Adaptez les chemins et configurations selon votre environnement.
