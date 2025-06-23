<?php

namespace App\Services\Action;

use App\Services\Balance\BalanceService;
use App\Services\Business\PhotoStudioService;

/**
 * Class PhotoStudioActionService.
 */
class PhotoStudioActionService
{
    private $photoStudioService;

    public function __construct()
    {
        $this->photoStudioService = new PhotoStudioService();
    }

    public function getPhotoStudioByUserId(
        $userId
    )
    {
        //Todo:: WIll implement later

        return $userId;
    }


    /**
     * Main method to handle photo studio actions.
     *
     *
     * @return mixed
     * @throws \Exception
     */
    public function generatePhotoStudioImage($action, array $payload, $user)
    {
        $userId = $user->id;

        // Generate image based on the action
        $getActionMethodName = $this->photoStudioService->getActionMethodName($action);

        $photoStudio = $this->photoStudioService->$getActionMethodName($payload);

        // Save the image to the public directory
        $uploadedFilePath  = $this->photoStudioService->saveGeneratedBase64EncodedImage($photoStudio, $action);

        // Image Record Store
        $generatedImage = $this->photoStudioService->saveGeneratedImage($uploadedFilePath,$payload, $userId);


        // User Balance Update
        (new BalanceService())->updateImageBalance($user, 1);

        return $generatedImage;
    }

    public function savePic()
    {
        /*
         * params of actions
         * reimagine = image_file
         * remove background = image_file
         * remove text = image_file
         *
         * replace background = image_file, prompt - Done
         * sketch to image = sketch_file, prompt - Done
         * text to image = prompt
         *
         * upscale = image_file, target_width, target_height
         * */
        
    }

}
