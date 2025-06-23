<?php

namespace App\Services\Action;

use App\Services\Business\PexelsService;

/**
 * Class UnsplashActionService.
 */
class PexelsActionService
{
    private PexelsService $pexelsService;

    public function __construct()
    {
        $this->pexelsService = new PexelsService();
    }

    public function searchPhotos($request)
    {
        return $this->pexelsService->searchPhotos($request);
    }

    public function prepareArr($response)
    {
        // Extract necessary data
        $results = $response["photos"];

        $dataArr = [];

        foreach($results as $result) {
            $dataArr[] = [
                'id'              => $result['id'],
                'raw'             => $result['src']['original'],
                'regular'         => $result['src']['large'],
                'alt_description' => $result['alt'],
                'author' => [
                    'name'          => $result['photographer'],
                    'portfolio_url' => $result['photographer_url'],
                ]
            ];
        }

        return $dataArr;
    }

}
