<?php

namespace App\Services\Business;

use App\Services\Balance\BalanceService;
use App\Services\Integration\IntegrationService;
use App\Services\Model\Article\ArticleService;

/**
 * Class ImageGenerateService.
 */
class ImageGenerateService
{

    /**
     * 1. Find Article By id
     * 2. Generate Images based on number of results
     * 3. Update Article selected_image column with last generated image file_path column
     * 4. Image Generation Balance Update at controller.
     * */
    public function generateImage($request, object | null $article = null): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder|array
    {
        // Default initialization
        $appStatic           = appStatic();
        $integrationService  = new IntegrationService();
        $articleService      = new ArticleService();
        $imageGenerateEngine = $appStatic::ENGINE_OPEN_AI;
        $contentPurpose      = $appStatic::DALL_E_2;

        if (getSetting('generate_image_option') == 'dall_e_3') {
            $contentPurpose = $appStatic::DALL_E_3;
        }

        if (getSetting('generate_image_option') == 'stable_diffusion') {
            $contentPurpose      = $appStatic::SD_TEXT_2_IMAGE;
            $imageGenerateEngine = $appStatic::ENGINE_STABLE_DIFFUSION;
        }

        // Merge Content Purpose
        $request->merge([
            'content_purpose'=> $contentPurpose
        ]);

        // 2. Generate Images based on number of results
        $images = $integrationService->imageGenerator($imageGenerateEngine, $request);

        // 3. Update Article selected_image column with last generated image file_path column
        if(!empty($article)) {
            $articleService->update($article->id, [
                "selected_image" => $images[0]->file_path,
            ], $article);
        }

        return $images;
    }
}
