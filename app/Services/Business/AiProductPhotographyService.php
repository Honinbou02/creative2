<?php

namespace App\Services\Business;

use App\Models\GeneratedImage;
use App\Traits\File\FileUploadTrait;
use App\Utils\AppIntegrationUrlKey;
use Illuminate\Support\Facades\Http;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

/**
 * Class AiProductPhotographyService.
 */
class AiProductPhotographyService
{
    use FileUploadTrait;
    private $appIntegrationUrlKey;

    public function __construct()
    {
        $this->appIntegrationUrlKey = new AppIntegrationUrlKey();
    }

    /**
     * Get available themes from the Pebblely API.
     *
     * @return array
     */
    public function getThemes(): array
    {
        $response = Http::get($this->appIntegrationUrlKey::PEBBLELY_THEMES_URL);

        if ($response->failed()) {
            throw new \Exception('Failed to fetch themes: ' . $response->body());
        }

        return $response->json();
    }

    public function getDimensions()
    {
        return localize("Use 1024x1024 for best results");
    }

    /**
     * Create a background for a given image using a selected theme and save it locally.
     *
     * @param string $imagePath Local path or URL to the product image.
     * @param string $themeId Theme ID for the background.
     */
    public function createBackground($file, string $themeId)
    {
        $imagePath = $this->getFileRealPath($file);

        $imageBase64 = base64_encode(file_get_contents($imagePath));

        // Prepare the request payload
        $payload = [
            'images' => [$imageBase64], // Pebblely expects an array of images
            'theme' => $themeId,
        ];


        // Make the POST request
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Pebblely-Access-Token' => "{$this->appIntegrationUrlKey->getPebblelyApiKey()}",
        ])->post('https://api.pebblely.com/create-background/v2/', $payload);


        if ($response->failed()) {
            throw new \Exception('Failed to create background: ' . $response->body());
        }

        return $response->json();
    }


    public function getProductShotFileName($extension = "png"): string
    {

        return "create_background_pebblely_" .Date("Y-m-d")."_".time()."_".randomStringNumberGenerator(6,true,true).".{$extension}";
    }


    public function saveGeneratedImage($imageFilePath, $userId)
    {
        $title        = "AI Product Shot";

        $data = [
            "title"                 => $title,
            "slug"                  => slugMaker($title),
            "model_name"            => "pebblely",
            "prompt"                => null,
            "generated_image_path"  => $imageFilePath,
            "file_path"             => $imageFilePath,
            "article_content_type"  => appStatic()::PURPOSE_BACKGROUND_CHANGE,
            "content_type"          => $title,
            "platform"              => 7, //TODO: Change to 7 for Peblely Product Shot
            "user_id"               => $userId
        ];

        return GeneratedImage::query()->create($data);
    }



}
