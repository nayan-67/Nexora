<?php

namespace App\Traits;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

trait ResizeImage
{
    public function imageResize($file, $width, $filename)
    {
        try {
            $filePath = $file->getRealPath();
            if (!file_exists($filePath)) {
                throw new \Exception("File not found: {$filePath}");
            }

            $uploadsDir = public_path('uploads');
            if (!File::isDirectory($uploadsDir)) {
                File::makeDirectory($uploadsDir, 0755, true);
            }

            // Read and resize image using ImageManager directly for v4.x
            $manager = ImageManager::usingDriver(Driver::class);
            $image = $manager->decodePath($filePath);
            $image->scaleDown($width);

            $publicPath = public_path('uploads/' . $filename);
            $image->save($publicPath, 95);

        } catch (\Exception $e) {
            Log::error("Image resize failed for {$filename}: " . $e->getMessage());
            toast($e->getMessage(), 'error');
            return back();
        }

        return true;
    }
}
