<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait OptimizesImages
{
    /**
     * Store and optionally optimize the uploaded image.
     *
     * @param UploadedFile $file
     * @param string $path
     * @return string
     */
    protected function storeAndOptimizeImage(UploadedFile $file, string $path): string
    {
        // Check if GD extension is installed
        if (!extension_loaded('gd')) {
            // Fallback to basic storage if GD is unavailable
            return $file->store($path, 'public');
        }

        $imagePath = $file->getRealPath();
        $mime = $file->getMimeType();

        // Load image using GD
        switch ($mime) {
            case 'image/jpeg':
                $source = @imagecreatefromjpeg($imagePath);
                break;
            case 'image/png':
                $source = @imagecreatefrompng($imagePath);
                break;
            case 'image/gif':
                $source = @imagecreatefromgif($imagePath);
                break;
            case 'image/webp':
                $source = @imagecreatefromwebp($imagePath);
                break;
            default:
                // For unsupported types by GD (like HEIC), just store normally
                return $file->store($path, 'public');
        }

        if (!$source) {
            return $file->store($path, 'public');
        }

        $width = imagesx($source);
        $height = imagesy($source);

        $maxWidth = 1920;
        $maxHeight = 1080;

        // Resize only if it exceeds maximum dimensions
        if ($width > $maxWidth || $height > $maxHeight) {
            $ratio = min($maxWidth / $width, $maxHeight / $height);
            $newWidth = (int)($width * $ratio);
            $newHeight = (int)($height * $ratio);

            $resized = imagecreatetruecolor($newWidth, $newHeight);

            // Preserve transparency for PNG and WEBP
            if ($mime === 'image/png' || $mime === 'image/webp') {
                imagealphablending($resized, false);
                imagesavealpha($resized, true);
                $transparent = imagecolorallocatealpha($resized, 255, 255, 255, 127);
                imagefilledrectangle($resized, 0, 0, $newWidth, $newHeight, $transparent);
            }

            imagecopyresampled($resized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($source);
            $source = $resized;
        }

        // Generate new filename and path
        $filename = uniqid() . '.webp';
        $fullPath = $path . '/' . $filename;
        $absolutePath = storage_path('app/public/' . $fullPath);

        // Ensure directory exists
        if (!file_exists(dirname($absolutePath))) {
            mkdir(dirname($absolutePath), 0755, true);
        }

        // Save as WebP with 80% quality
        imagewebp($source, $absolutePath, 80);
        imagedestroy($source);

        return $fullPath;
    }
}
