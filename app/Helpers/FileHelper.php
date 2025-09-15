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
}
