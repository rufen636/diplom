<?php

namespace App\Services\Manager\Image;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    public function save($model, $image)
    {
        $image_path = Storage::disk('public')->put('/images', $image);
        Image::create([
            'imageable_type' => $model->getMorphClass(),
            'imageable_id' => $model->id,
            'small_uri' => $image_path,
            'big_uri' => $image_path,
        ]);
    }

    public static function url($path)
    {

        if (!is_array($path)) {
            if (Str::startsWith($path, 'http')) {
                return $path;
            }
        } else {
            $images = [];
            foreach ($path as $p) {
                if (Str::startsWith($p, 'http')) {
                    $images[] = $p;
                } else {
                    $images[] = self::storage($p);
                }
            }
            return $images;
        }

        return self::storage($path);
    }

    public static function storage($path)
    {
        return request()->getScheme() . '://' . request()->getHost()
            . (request()->getPort() ? ':' . request()->getPort() : '')
            . Storage::url($path);
    }
}
