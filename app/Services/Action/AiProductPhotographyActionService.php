<?php

namespace App\Services\Action;

use App\Services\Balance\BalanceService;
use App\Services\Business\AiProductPhotographyService;
use App\Traits\File\FileUploadTrait;

/**
 * Class AiProductPhotographyActionService.
 */
class AiProductPhotographyActionService
{
    use FileUploadTrait;
    private $aiService;

    public function __construct()
    {
        $this->aiService = new AiProductPhotographyService();
    }

    public function getThemes()
    {
       return $this->aiService->getThemes();
    }

    public function getDimensions()
    {
        return $this->aiService->getDimensions();
    }

    /**
     *
     * */
    public function createBackground($file, $themeId, object $user)
    {
        $createBackground = $this->aiService->createBackground($file,$themeId);

        // Save the data to the product shot directory
        $fileName          = $this->aiService->getProductShotFileName("png");
        $uploadedFilePath  = $this->saveBase64StringToDirectory($createBackground["data"], fileService()::DIR_PRODUCT_SHOT,$fileName);

        // Image Record Store
        $generatedImage = $this->aiService->saveGeneratedImage($uploadedFilePath, $user->id);

        // User Balance Update
        (new BalanceService())->updateImageBalance($user, 1);

        return $generatedImage;
    }
}
