<?php

namespace Database\Seeders;

use App\Models\GalleryImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Chemin vers le dossier public/images
        $imagesPath = public_path('images');
        
        // Vérifier si le dossier existe
        if (!File::exists($imagesPath)) {
            $this->command->info('Le dossier public/images n\'existe pas.');
            return;
        }

        // Récupérer tous les fichiers images
        $imageFiles = File::files($imagesPath);
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        foreach ($imageFiles as $file) {
            $extension = strtolower($file->getExtension());
            
            // Vérifier si c'est une image
            if (in_array($extension, $imageExtensions)) {
                $filename = $file->getFilename();
                $imagePath = 'images/' . $filename;
                
                // Vérifier si l'image n'existe pas déjà en base
                $existingImage = GalleryImage::where('image_path', $imagePath)->first();
                
                if (!$existingImage) {
                    // Créer un titre basé sur le nom du fichier
                    $title = $this->generateTitleFromFilename($filename);
                    
                    // Déterminer la catégorie basée sur le nom du fichier
                    $category = $this->determineCategoryFromFilename($filename);
                    
                    GalleryImage::create([
                        'title' => $title,
                        'image_path' => $imagePath,
                        'description' => null,
                        'category' => $category,
                        'event_date' => now()->subDays(rand(1, 365)), // Date aléatoire dans l'année passée
                        'is_featured' => rand(0, 1) == 1, // Aléatoirement mis en avant
                        'is_active' => true,
                    ]);
                    
                    $this->command->info("Image ajoutée: {$filename}");
                }
            }
        }
    }
    
    /**
     * Générer un titre à partir du nom de fichier
     */
    private function generateTitleFromFilename($filename): string
    {
        // Supprimer l'extension
        $nameWithoutExtension = pathinfo($filename, PATHINFO_FILENAME);
        
        // Remplacer les underscores et tirets par des espaces
        $title = str_replace(['_', '-'], ' ', $nameWithoutExtension);
        
        // Capitaliser chaque mot
        $title = ucwords($title);
        
        return $title;
    }
    
    /**
     * Déterminer la catégorie basée sur le nom du fichier
     */
    private function determineCategoryFromFilename($filename): string
    {
        $filename = strtolower($filename);
        
        if (str_contains($filename, 'choir') || str_contains($filename, 'chorale')) {
            return 'Chorale';
        }
        
        if (str_contains($filename, 'concert')) {
            return 'Concerts';
        }
        
        if (str_contains($filename, 'rehearsal') || str_contains($filename, 'repetition')) {
            return 'Répétitions';
        }
        
        if (str_contains($filename, 'event') || str_contains($filename, 'evenement')) {
            return 'Événements';
        }
        
        // Catégorie par défaut
        return 'Général';
    }
}