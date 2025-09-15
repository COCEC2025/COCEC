#!/bin/bash

# ===========================================
# SCRIPT D'OPTIMISATION POUR LA PRODUCTION
# ===========================================

echo "🚀 Début de l'optimisation pour la production..."

# 1. Nettoyer le cache Laravel
echo "📦 Nettoyage du cache Laravel..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 2. Optimiser l'autoloader Composer
echo "🔧 Optimisation de l'autoloader Composer..."
composer install --optimize-autoloader --no-dev

# 3. Compiler les assets (si Laravel Mix est configuré)
echo "🎨 Compilation des assets..."
if [ -f "package.json" ]; then
    npm install --production
    npm run production
fi

# 4. Optimiser la configuration
echo "⚙️ Optimisation de la configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Vérifier les permissions
echo "🔐 Vérification des permissions..."
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

# 6. Optimiser les images (si ImageMagick est disponible)
echo "🖼️ Optimisation des images..."
if command -v convert &> /dev/null; then
    find public/assets/images -name "*.jpg" -o -name "*.jpeg" -o -name "*.png" | while read file; do
        echo "Optimisation de $file"
        convert "$file" -quality 85 -strip "$file"
    done
fi

# 7. Créer un fichier de version pour le cache busting
echo "📝 Création du fichier de version..."
echo "<?php return ['version' => '$(date +%s)'];" > config/version.php

echo "✅ Optimisation terminée avec succès!"
echo "📊 Résumé des optimisations:"
echo "   - Cache Laravel optimisé"
echo "   - Autoloader Composer optimisé"
echo "   - Assets compilés"
echo "   - Configuration mise en cache"
echo "   - Permissions vérifiées"
echo "   - Images optimisées"
echo "   - Version créée pour le cache busting"
