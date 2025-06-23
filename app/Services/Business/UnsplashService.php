<?php

namespace App\Services\Business;

use App\Utils\AppIntegrationUrlKey;
use Illuminate\Support\Facades\Http;

/**
 * Class UnsplashService.
 */
class UnsplashService
{

    private $appService;

    public function __construct()
    {
        $this->appService = new AppIntegrationUrlKey();
    }

    public function searchPhotos($request)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Client-ID ' . $this->appService->getUnsplashClientKey(),
        ])->get($this->appService->getUnsplashSearchURL(), [
            'query'    => $request->q ?? "SEO",
            'page'     => $request->page ?? 1,
            'per_page' => $request->per_page ?? 10,
        ]);

        if($response->failed()){
            wLog("Failed to get photos from unsplash", ["errors" =>  $response->json()]);

            throw new \RuntimeException($response->body(), 500);
        }

        return $response->json();
    }
}
