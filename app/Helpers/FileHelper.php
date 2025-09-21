<?php

namespace App\Helpers;

class FileHelper
{
    /**
     * Nettoie un nom de fichier en supprimant les caractères spéciaux
     * et en limitant la longueur
     */
    public static function cleanFileName($name, $maxLength = 50)
    {
        // Supprimer les caractères spéciaux et les espaces multiples
        $cleaned = preg_replace('/[^a-zA-Z0-9\s\-_]/', '', $name);
        $cleaned = preg_replace('/\s+/', '_', trim($cleaned));
        
        // Limiter la longueur
        if (strlen($cleaned) > $maxLength) {
            $cleaned = substr($cleaned, 0, $maxLength);
        }
        
        return $cleaned;
    }
    
    /**
     * Génère un nom de fichier PDF avec l'ID et le nom de la personne
     */
    public static function generatePdfFileName($prefix, $id, $name, $maxNameLength = 30)
    {
        $cleanedName = self::cleanFileName($name, $maxNameLength);
        return $prefix . '_' . $id . '_' . $cleanedName . '.pdf';
    }
    
    /**
     * Retourne l'URL de l'image avec fallback vers placeholder si l'image n'existe pas
     */
    public static function getImageUrl($imagePath, $placeholder = 'assets/images/placeholder-image.png')
    {
        if (empty($imagePath)) {
            return asset($placeholder);
        }
        
        // Vérifier si l'image existe dans le storage
        $fullPath = storage_path('app/public/' . $imagePath);
        if (file_exists($fullPath)) {
            return asset('storage/' . $imagePath);
        }
        
        // Vérifier si c'est un chemin d'asset direct
        $assetPath = public_path($imagePath);
        if (file_exists($assetPath)) {
            return asset($imagePath);
        }
        
        // Retourner le placeholder par défaut
        return asset($placeholder);
    }
    
    /**
     * Retourne l'URL de l'image avec fallback vers placeholder pour les images de storage
     */
    public static function getStorageImageUrl($imagePath, $placeholder = 'assets/images/placeholder-image.png')
    {
        if (empty($imagePath)) {
            return asset($placeholder);
        }
        
        // Vérifier si l'image existe dans le storage
        $fullPath = storage_path('app/public/' . $imagePath);
        if (file_exists($fullPath)) {
            return asset('storage/' . $imagePath);
        }
        
        // Retourner le placeholder par défaut
        return asset($placeholder);
    }
}
