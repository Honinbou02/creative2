<?php

namespace Modules\WordpressBlog\Services\WpMedia;

use GuzzleHttp\Client;
use Modules\WordpressBlog\Services\WpBasicAuthService;
use Illuminate\Support\Facades\Http;

class WpMediaService
{
    public   function uploadImageToWordPress($imagePath)
    {
        try {
            $wpBasicAuthService = new WpBasicAuthService();
            $credentials        = $wpBasicAuthService->getCredentials();

            $username =  $credentials[0];
            $password =  $credentials[1];

            $mediaURL = $wpBasicAuthService::URL_MEDIA();

            $response = Http::withBasicAuth($username, $password)->attach(
                'file', fopen($imagePath, 'r'), basename($imagePath)
            )->timeout(0)->post($mediaURL);

            if($response->failed()){
                throw new \Exception($response->body(), $response->status());
            }

            return $response->json();
        }
        catch (\Throwable $th) {
            throw new \Exception($th->getMessage(), $th->getCode());
        }
    }

}