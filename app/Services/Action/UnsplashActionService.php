<?php

namespace App\Services\Action;

use App\Services\Business\UnsplashService;

/**
 * Class UnsplashActionService.
 */
class UnsplashActionService
{
    private UnsplashService $unsplashService;

    public function __construct()
    {
        $this->unsplashService = new UnsplashService();
    }

    public function searchPhotos($request)
    {
        return $this->unsplashService->searchPhotos($request);
    }

    public function prepareArr($response)
    {
        // Extract necessary data
        $results = $response["results"];

        $dataArr = [];

        foreach($results as $result) {
            $dataArr[] = [
                'id'              => $result['id'],
                'raw'             => $result['urls']['raw'],
                'regular'         => $result['urls']['regular'],
                'alt_description' => $result['alt_description'],
                'author' => [
                    'name'          => $result['user']['name'],
                    'portfolio_url' => $result['user']['portfolio_url'],
                ]
            ];
        }

        return $dataArr;
    }

}
