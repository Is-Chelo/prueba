<?php

namespace App\MobileApp\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadService
{

    public static function upload(UploadedFile $file, string $folder, $disk = 'public'): string
    {
        $filename = time() . '.' . $file->extension();

        //TODO: GUARDAMOS EN LA CARPETA NORMAL
        Storage::put("$folder/normal/" . $filename, file_get_contents($file->path()));

        // TODO: RECORTAR IMAGEN
        $image = $file;
        $img = file_get_contents($image->path());
        $dimensions = getimagesizefromstring($img);
        $width = $dimensions[0];
        $height = $dimensions[1];
        // $size = 300;
        $size = min($width, $height);

        $square = imagecreatetruecolor($size, $size);
        imagecopy($square, imagecreatefromstring($img), 0, 0, ($width - $size) / 2, ($height - $size) / 2, $size, $size);

        ob_start();
        imagepng($square);
        $imgData = ob_get_clean();
        Storage::put("$folder/thumb/" . $filename, $imgData);

        // Liberar memoria
        imagedestroy($square);
        
        return $filename;
    }

    public static function delete(string $path, $disk = 'public')
    {
        if (!Storage::exists($path)) {
            return false;
        }

        return Storage::delete($path);
    }


    public static function getUrl($name, $folder = 'seed', $disk = 'public')
    {
        if ($name == null) return null;

        $pathComplete = $folder . '/' . $name;

        $url_file = null;

        $exists = Storage::exists($pathComplete);
        if ($exists) {
            $url_file = asset(Storage::url($pathComplete));
            return $url_file;
        } else {
            return null;
        }
    }
}
