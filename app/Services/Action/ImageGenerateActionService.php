<?php

namespace App\Services\Action;

use App\Services\Business\ImageGenerateService;

/**
 * Class ImageGenerateActionService.
 */
class ImageGenerateActionService
{
    private $imageService;

    public function __construct()
    {
        $this->imageService = new ImageGenerateService();
    }

    public function generateImage($request, object | null $article = null): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder|array
    {
        return $this->imageService->generateImage($request, $article);
    }
}
