<?php

declare(strict_types=1);

namespace App\Util;

use App\Models\Image;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageManager
{
    public static function upload(UploadedFile $image, string $dir): string
    {
        $image->hashName();
        return $image->store($dir);
    }

    public static function remove(Collection $images): void
    {
        foreach ($images->toArray() as $image) {
            Image::destroy($image['id']);
            Storage::delete($image['path']);
        }
    }
}
