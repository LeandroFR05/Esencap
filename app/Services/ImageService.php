<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;

class ImageService
{
    protected ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    public function storeAsWebp(UploadedFile $file, string $directory = 'uploads', int $quality = 80): string
    {
        $filename = Str::random(20) . '.webp';
        $image = $this->manager->read($file->getRealPath());
        $encoded = $image->encode(new WebpEncoder(quality: $quality));

        Storage::disk('public')->put($directory . '/' . $filename, (string) $encoded);

        return $directory . '/' . $filename;
    }
}
