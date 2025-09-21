# Système de Fallback d'Images

Ce système permet d'afficher automatiquement une image placeholder (`placeholder-image.png`) lorsque l'image demandée n'existe pas ou est introuvable.

## Fonctionnalités

- **Fallback automatique** : Si une image n'existe pas, le système affiche automatiquement `placeholder-image.png`
- **Vérification de l'existence** : Le système vérifie si l'image existe avant de l'afficher
- **Support des chemins storage** : Gère les images stockées dans `storage/app/public/`
- **Support des assets** : Gère les images dans le dossier `public/assets/`
- **Directives Blade** : Syntaxe simplifiée pour les vues

## Utilisation

### 1. Helper PHP

```php
use App\Helpers\FileHelper;

// Image avec fallback par défaut (placeholder-image.png)
$imageUrl = FileHelper::getStorageImageUrl($imagePath);

// Image avec fallback personnalisé
$imageUrl = FileHelper::getStorageImageUrl($imagePath, 'assets/images/custom-placeholder.jpg');

// Image générale avec fallback
$imageUrl = FileHelper::getImageUrl($imagePath, 'assets/images/custom-placeholder.jpg');
```

### 2. Directives Blade

```blade
{{-- Image avec fallback par défaut --}}
<img src="@image($blog->image)" alt="{{ $blog->title }}">

{{-- Image avec fallback personnalisé --}}
<img src="@image($blog->image, 'assets/images/blog.jpg')" alt="{{ $blog->title }}">

{{-- Image avec placeholder personnalisé --}}
<img src="@imageWithPlaceholder($announcement->image, 'assets/images/announcements.jpg')" alt="{{ $announcement->title }}">
```

### 3. Syntaxe classique dans les vues

```blade
{{-- Méthode complète --}}
<img src="{{ \App\Helpers\FileHelper::getStorageImageUrl($blog->image, 'assets/images/blog.jpg') }}" alt="{{ $blog->title }}">

{{-- Méthode avec fallback par défaut --}}
<img src="{{ \App\Helpers\FileHelper::getStorageImageUrl($blog->image) }}" alt="{{ $blog->title }}">
```

## Images mises à jour

Les vues suivantes ont été mises à jour pour utiliser le système de fallback :

### Blog
- `resources/views/welcome.blade.php`
- `resources/views/main/blog/detail.blade.php`
- `resources/views/main/blog/index.blade.php`
- `resources/views/admin/blog/index.blade.php`

### Annonces
- `resources/views/admin/announcement/index.blade.php`
- `resources/views/includes/main/popup.blade.php`

### Agences
- `resources/views/admin/agency/index.blade.php`
- `resources/views/main/agency.blade.php`

### Comptes
- `resources/views/admin/accounts/physical/show.blade.php`
- `resources/views/admin/accounts/moral/show.blade.php`

### Interface Admin
- `resources/views/includes/admin/appbar.blade.php`

## Configuration

Le placeholder par défaut est situé dans :
```
public/assets/images/placeholder-image.png
```

Pour changer le placeholder par défaut, modifiez la valeur par défaut dans `FileHelper::getStorageImageUrl()`.

## Avantages

1. **Expérience utilisateur améliorée** : Plus d'images cassées
2. **Maintenance simplifiée** : Gestion centralisée des images
3. **Performance** : Vérification d'existence côté serveur
4. **Flexibilité** : Placeholders personnalisables par contexte
5. **Syntaxe claire** : Directives Blade intuitives

## Notes techniques

- Le système vérifie l'existence des fichiers avec `file_exists()`
- Support des chemins relatifs et absolus
- Compatible avec Laravel Storage
- Optimisé pour les performances
