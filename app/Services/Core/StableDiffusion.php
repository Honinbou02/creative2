<?php

namespace App\Services\Core;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Stability;
class StableDiffusion
{
   public const BASE_URL = "https://api.stability.ai/v1";

    public function setURLEngineList(): string
    {
        return self::BASE_URL."/engines/list";
    }

    public function setURLText2Image($engineId): string
    {
        return self::BASE_URL."/generation/{$engineId}/text-to-image";
    }

    public function setURLImage2Image($engineId): string
    {
        return self::BASE_URL."/generation/{$engineId}/image-to-image";
    }

    public function setURLImage2ImageMask($engineId): string
    {
        return self::BASE_URL."/generation/{$engineId}/image-to-image/masking";
    }

    public function setURLImage2ImageUpscale($engineId): string
    {
        return "https://api.stability.ai/v2beta/stable-image/upscale/{$engineId}";
    }


    public function setImage2VideoURL()
    {
        return "https://api.stability.ai/v2beta/image-to-video";
    }

    public function setStableDiffusionGenerationResult(string $videoId)
    {
        return "https://api.stability.ai/v2beta/image-to-video/result/{$videoId}";
    }

    private function client(): PendingRequest
    {
        return Http::withHeaders([
            'Authorization' => 'Token '.config('stable-diffusion.token'),
        ])
        ->asJson()
        ->acceptJson();
    }


    public function getSDKey()
    {
        return config("services.stable-ai.key");
    }


    public function getAuthorization($bindBearer = false, $contentTypeJSON = null, $headers = [])
    {
        
        $bearer      = $bindBearer ? "Bearer" : "";
        $contentType = empty($contentTypeJSON) ? "Content-Type: application/json" : $contentTypeJSON;

        $header = [
            "Authorization:{$bearer} {$this->getSDKey()}",
            $contentType
        ];

        if(!empty($headers)){
            $header = array_merge($header, $headers);
        }

        return $header;
    }

}