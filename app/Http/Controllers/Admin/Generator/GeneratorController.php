<?php

namespace App\Http\Controllers\Admin\Generator;

use App\Http\Requests\Admin\MetaDescriptionGenerateRequest;
use App\Services\Action\ImageGenerateActionService;
use App\Services\Action\SeoCheckerActionService;
use App\Services\Action\UnsplashActionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\Api\ApiResponseTrait;
use App\Services\Core\AiConfigService;
use App\Services\Balance\BalanceService;
use App\Services\Model\Article\ArticleService;
use App\Services\Integration\IntegrationService;
use App\Http\Requests\Admin\ArticleGenerateRequest;
use App\Http\Requests\Admin\TitleGenerate\TitleGenerateRequest;
use App\Http\Requests\Admin\KeywordGenerate\KeywordGenerateRequest;
use App\Http\Requests\Admin\OutlineGenerate\GenerateOutlineRequest;
use App\Services\Action\PexelsActionService;

class GeneratorController extends Controller
{
    use ApiResponseTrait;
    public $integrationService;
    public $appStatic;
    public function __construct()
    {
        $this->integrationService = new IntegrationService();
        $this->appStatic          = appStatic();
    }

    public function imageSearch(Request $request, UnsplashActionService $unsplashActionService, PexelsActionService $pexelsActionService)
    {
        try {
            $actionService = $unsplashActionService;

            switch ($request->platform) {
                case 'unsplash':
                    $actionService = $unsplashActionService;
                    break;
                
                case 'pexels':
                    $actionService = $pexelsActionService;
                    break;
                
                default: 
                    $actionService = $unsplashActionService;
                    break;
            }

            $pictures    = $actionService->searchPhotos($request);
            $prepareJson = $actionService->prepareArr($pictures);

            $data = [
                "unsplashImages" => $prepareJson,
                "offCanvasId"    => "offcanvasSelectedImage"
            ];

            return $this->sendResponse(
                $this->appStatic::SUCCESS_WITH_DATA,
                localize("Image Searching result"),
                view("backend.admin.unsplash.render.render-image")->with($data)->render()
            );
        } catch (\Throwable $e) {
            \DB::rollBack();
            wLog("Failed to search image", errorArray($e));

            return $this->sendResponse(
                $this->appStatic::VALIDATION_ERROR,
                localize("Failed to search image"),
                [],
                errorArray($e)
            );
        }
    }

    public function generateTopics(Request $request)
    {
        try {
            DB::beginTransaction();

            $contentGenerator = $this->integrationService->contentGenerator(aiEngine(), $request);
            (new BalanceService())->balanceUpdate($contentGenerator);

            DB::commit();

            return $contentGenerator;
        } catch (\Throwable $e) {
            DB::rollBack();
            wLog("Failed to Generate Text", errorArray($e), logService()::LOG_OPEN_AI);
            return $this->sendResponse(
                $this->appStatic::VALIDATION_ERROR,
                $e->getMessage(),
                [],
                errorArray($e)
            );
        }
    }

    /**
     * @param Request $request contains form requests inputs
     *
     * @parameter $generatedKeywords will receive a generated data with JSON Response.
     *
     *
     * Result Response for the new-keyword generation
     *
     * {
     * "status": true,
     * "response_code": 201,
     * "message": "Successfully generated content.",
     * "data": "['visit USA', 'tourism in USA']",
     * "errors": [],
     * "optional": []
     * }
     * */
    public function generateKeywords(KeywordGenerateRequest $request, ArticleService $articleService): \Illuminate\Http\JsonResponse
    {
        try {
            $balanceService = new BalanceService();

            // Throw Exception if the user doesn't contain any balance
            checkWordBalance();

            // Is Blog Wizard Allowed
            checkValidCustomerFeature(allowBlogWizard());

            DB::beginTransaction();

            if ($request->has("article_id") && !empty($request->article_id)) {
                $article = $articleService->findArticleById($request->article_id);
            } else {
                $article = $articleService->storeArticle($request->except(["article_id", "number_of_main_keywords", "number_of_keywords"]));
            }

            $request->merge(["article_id" => $article->id]);

            $generatedContent = $this->integrationService->contentGenerator(aiEngine(), $request);

            /**
             * Update Article with keyword_generated_content_id
             * */
            $articleService->update($article->id, [
                'title'                        => $request->topic,
                "completed_step"               => $this->appStatic::ARTICLE_STEPS['keywords'],
                "keyword_generated_content_id" => $generatedContent->id,
                "total_words"                  => ($article->total_words + $generatedContent->total_words),
            ], $article);

            // QUESTION: I can see that balance is updating on rawCompletion() in GeminiAiService; Updating balance 2 times
            (new BalanceService())->balanceUpdate($generatedContent);

            DB::commit();

            $keywords    = $generatedContent->response;
            $keywordsArr = (array) json_decode($keywords);

            $seoKeywordCheck = false;

            // When it's admin or Admin Team
            if (isAdminUserGroup()) {
                $seoKeywordCheck = true;
            } else {
                // When it's customer or customer team
                $seoKeywordCheck = allowCustomerSeKeyword();
            }


            // Article SEO Report Check when it's seo_check has a value.
            // if($seoKeywordCheck && $request->has("seo_check") && $request->seo_check == 1){
            //     // Making Bulk Keyword Analysis Request
            //     $keywordSeoResult = (new SeoCheckerActionService())->getKeywordSeoResult($keywordsArr);

            //     // Update SEO Keyword Balance
            //     (new BalanceService())->seoKeywordBalanceUpdate(getUserObject());

            //     return $this->seoResponse($keywordSeoResult, $article);
            // }

            return $this->nonSeoResponse($keywordsArr, $article);
        } catch (\Throwable $e) {
            DB::rollBack();

            wLog("Failed to Generate Keywords", errorArray($e), logService()::LOG_OPEN_AI);

            return $this->sendResponse($this->appStatic::LENGTH_ERROR, $e->getMessage(), [], errorArray($e));
        }
    }

    /**
     * @throws \JsonException
     */
    public function nonSeoResponse($keywordsArr, $article): \Illuminate\Http\JsonResponse
    {
        // Generated Keywords without SEO Check
        $mainKeywordsArr    = $keywordsArr["main_keywords"];
        $relatedKeywordsArr = $keywordsArr["related_keywords"];

        return $this->sendResponse(
            $this->appStatic::SUCCESS_WITH_DATA,
            $this->appStatic::MESSAGE_KEYWORD_GENERATED,
            [
                "main_keywords"    => view("backend.admin.articles.render.render-keywords")->with(["keywords" => $mainKeywordsArr, "isMain" => true])->render(),
                "related_keywords" => view("backend.admin.articles.render.render-keywords")->with(["keywords" => $relatedKeywordsArr])->render()
            ],
            [],
            ["article_id" => $article->id]
        );
    }

    /**
     * @throws \JsonException
     */
    public function seoResponse($keywordSeoResult, $article): \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse(
            $this->appStatic::SUCCESS_WITH_DATA,
            $this->appStatic::MESSAGE_KEYWORD_GENERATED,
            [
                "main_keywords"    => view("backend.admin.articles.render.seo-keyword")->with(["keywords" => $keywordSeoResult['main_keywords'], "isMain" => true])->render(),
                "related_keywords" => view("backend.admin.articles.render.seo-keyword")->with(["keywords" => $keywordSeoResult['related_keywords']])->render(),
            ],
            [],
            [
                "article_id"   => $article->id,
                "bulkKeywords" => $keywordSeoResult
            ]
        );
    }

    public function generateTitles(TitleGenerateRequest $request, ArticleService $articleService)
    {
        try {
            // Checking Remaining Word balance.
            checkWordBalance();

            // Is Blog Wizard Allowed
            checkValidCustomerFeature(allowBlogWizard());

            DB::beginTransaction();
            $article = $articleService->findArticleById($request->article_id);

            $contentGenerator = $this->integrationService->contentGenerator(aiEngine(), $request);

            /**
             * Update Article with title_generated_content_id
             * */
            $articleService->update($article->id, [
                "completed_step"             => $this->appStatic::ARTICLE_STEPS['titles'],
                "title_generated_content_id" => $contentGenerator->id,
                "focus_keyword"              => $request->mainKeywords ?? $request->focus_keyword,
                "selected_keyword"           => $request->contentKeywords ?? $request->keywords,
                "total_words"                => ($article->total_words + $contentGenerator->total_words),
            ], $article);

            (new BalanceService())->balanceUpdate($contentGenerator);

            $titles = (array) json_decode($contentGenerator->response);

            DB::commit();
            return $this->sendResponse(
                $this->appStatic::SUCCESS_WITH_DATA,
                $this->appStatic::MESSAGE_TITLE_GENERATED,
                view("backend.admin.articles.render.render-titles")->with(["titles" => $titles['titles']])->render(),
                [],
                ["article_id" => $article->id, "titles" => $titles]
            );
        } catch (\Throwable $e) {
            DB::rollBack();
            wLog("Failed to Generate Title", errorArray($e), logService()::LOG_OPEN_AI);
            return $this->sendResponse($this->appStatic::LENGTH_ERROR, $e->getMessage(), [], errorArray($e));
        }
    }

    public function generateMetaDescriptions(MetaDescriptionGenerateRequest $request, ArticleService $articleService): \Illuminate\Http\JsonResponse
    {
        try {
            // Checking Remaining Word balance.
            checkWordBalance();

            // Is Blog Wizard Allowed
            checkValidCustomerFeature(allowBlogWizard());

            DB::beginTransaction();
            $article = $articleService->findArticleById($request->article_id);

            $contentGenerator = $this->integrationService->contentGenerator(aiEngine(), $request);

            /**
             * Update Article with title_generated_content_id
             * */
            $articleService->update($article->id, [
                "completed_step"                        => $this->appStatic::ARTICLE_STEPS['meta_descriptions'],
                "meta_description_generated_content_id" => $contentGenerator->id,
                "selected_title"                        => $request->title,
                "total_words"                           => ($article->total_words + $contentGenerator->total_words),
            ], $article);

            (new BalanceService())->balanceUpdate($contentGenerator);

            $metaDescriptions = (array) json_decode($contentGenerator->response);

            DB::commit();
            return $this->sendResponse(
                $this->appStatic::SUCCESS_WITH_DATA,
                $this->appStatic::MESSAGE_TITLE_GENERATED,
                view("backend.admin.articles.render.render-meta-description")->with(["metaDescriptions" => $metaDescriptions['meta_description']])->render(),
                [],
                ["article_id" => $article->id, "meta_descriptions" => $metaDescriptions]
            );
        } catch (\Throwable $e) {
            DB::rollBack();
            wLog("Failed to Generate Title", errorArray($e), logService()::LOG_OPEN_AI);
            return $this->sendResponse($this->appStatic::LENGTH_ERROR, $e->getMessage(), [], errorArray($e));
        }
    }


    public function generateOutlines(GenerateOutlineRequest $request, ArticleService $articleService): \Illuminate\Http\JsonResponse
    {
        try {
            // Checking Remaining Word balance.
            checkWordBalance();

            // Is Blog Wizard Allowed
            checkValidCustomerFeature(allowBlogWizard());

            DB::beginTransaction();

            $article  = $articleService->findArticleById($request->article_id);
            $aiEngine = aiEngine();

            wLog(
                "Engine : {$aiEngine}, Article ID : {$request->article_id} Before Generate Outline",
                ["incoming_payloads" => $request->all()],
                logService()::LOG_OPEN_AI
            );

            $contentGenerator = $this->integrationService->contentGenerator(aiEngine(), $request);

            wLog(
                "Article ID : {$request->article_id} Generated Outline",
                ["response" => $contentGenerator],
                logService()::LOG_OPEN_AI
            );


            // Balance Update
            (new BalanceService())->balanceUpdate($contentGenerator);

            /**
             * Update Article with title_generated_content_id
             * */
            $articleService->update($article->id, [
                "completed_step"               => $this->appStatic::ARTICLE_STEPS['outlines'],
                "outline_generated_content_id" => $contentGenerator->id,
                "title"                        => $request->title,
                "selected_title"               => $request->title,
                "selected_meta_description"    => $request->metaDescription,
                "total_words"                  => ($article->total_words + $contentGenerator->total_words),
            ], $article);

            DB::commit();

            $outlines        =  $contentGenerator->response;

            // for Gemini
            $outlines = !empty($outlines) && is_string($outlines) ? json_decode(json_encode(json_decode($outlines)), true) : $outlines;

            wLog("OUTLINES JSON DECODE : Article ID : {$request->article_id}", ["outline_contents" => $outlines], logService()::LOG_OPEN_AI);

            // for OpenAi
            $finalOutlineArr = [];
            if (!empty($outlines) && is_array($outlines)) {
                foreach ($outlines as $index => $outline) {
                    $outline = is_string($outline) ? json_decode($outline, true) : $outline;
                    $finalOutlineArr[$index] = $outline;
                    if (!empty($outline['outline'])) {
                        foreach ($outline['outline'] as $section) {
                            $finalOutlineArr[$index]['outline_only'][] = $section['section'];
                        }
                    }
                }
            }

            wLog("FINAL OUTLINE ARR : Article ID : {$request->article_id}", ["final_outline_contents" => $finalOutlineArr], logService()::LOG_OPEN_AI);

            return $this->sendResponse(
                $this->appStatic::SUCCESS_WITH_DATA,
                $this->appStatic::MESSAGE_OUTLINE_GENERATED,
                view("backend.admin.articles.render.render-outlines")->with(["outlines" => $finalOutlineArr])->render(),
                [],
                ["ai_engine" => $aiEngine, "article_id" => $article->id, "outlines" => $outlines, "final_outlines" => $finalOutlineArr]
            );
        } catch (\Throwable $e) {
            DB::rollBack();

            wLog("Failed to Complete Outline Generate", ["errors" => errorArray($e)], logService()::LOG_OPEN_AI);

            return $this->sendResponse($this->appStatic::VALIDATION_ERROR, $e->getMessage(), [], errorArray($e));
        }
    }

    public function generateImages(Request $request, ArticleService $articleService, ImageGenerateActionService $imageGenerateActionService): \Illuminate\Http\JsonResponse
    {
        try {
            // Is Image Generate Allowed
            checkValidCustomerFeature(allowImages());

            // 1. Find Article By id
            $article = $articleService->findArticleById($request->article_id);
            $user    = getUserObject();

            DB::beginTransaction();

            $images = $imageGenerateActionService->generateImage($request, $article);

            // 4. Image Generation Balance Update
            (new BalanceService())->updateImageBalance($user, $request->number_of_results ?? 1);

            DB::commit();

            return $this->sendResponse(
                $this->appStatic::SUCCESS_WITH_DATA,
                $this->appStatic::MESSAGE_TITLE_GENERATED,
                view("backend.admin.articles.render.render-images")->with(["images" => $images])->render(),
                [],
                ["article_id" => $article->id, "images" => $images]
            );
        } catch (\Throwable $e) {
            DB::rollBack();

            $payloads = [
                "incoming_payloads" => $request->all(),
                "errors" => errorArray($e)
            ];

            wLog("Failed to Generate Image for Article", $payloads, logService()::LOG_OPEN_AI);

            return $this->sendResponse($this->appStatic::LENGTH_ERROR, $e->getMessage(), [], errorArray($e));
        }
    }
    public function generateArticles(ArticleGenerateRequest $request, ArticleService $articleService, ImageGenerateActionService $imageGenerateActionService)
    {
        $article_id       = (int) $request->article_id;
        $topic            = trim($request->topic);
        $focus_keyword    = trim($request->focus_keyword);
        $keywords         = trim($request->keywords);
        $title            = trim($request->title);
        $meta_description = trim($request->meta_description);
        $selected_outline = !empty($request->outlines) ? implode(",", $request->outlines) : NULL;

        try {
            // If Outlines is not selected then throw error
            if (empty($selected_outline)) {
                throw new \RuntimeException(localize("Please, Generate outlines first."));
            }

            // Checking Remaining Word balance.
            checkWordBalance();

            // Is Blog Wizard Allowed
            checkValidCustomerFeature(allowBlogWizard());

            $article         = $articleService->findArticleById($article_id);
            $aiConfigService = new AiConfigService();
            $platform        = $aiConfigService->setPlatForm(aiEngine());

            // Store the article meta-description & focus_keyword
            $articleArr = [
                "topic"                     => $topic,
                "selected_keyword"          => $keywords,
                "focus_keyword"             => $focus_keyword,
                "title"                     => $title,
                "selected_title"            => $title,
                "selected_meta_description" => $meta_description,
                "selected_outline"          => $selected_outline,
            ];

            // Updating Article
            $articleService->update($article->id, $articleArr, $article);

            // Content Purpose = articles merged.
            $request->merge(["content_purpose" => "articles", "stream" => true]);
            info("Article Generation Request All" . json_encode($request->all(), JSON_THROW_ON_ERROR));

            // save in session
            session()->put("session_article_id", $article->id);
            session()->put("session_article_main_keywords", $focus_keyword);
            session()->put("session_article_related_keywords", $keywords);
            session()->put("session_article_title", $title);
            session()->put("session_article_meta_description", $meta_description);
            session()->put("session_article_outlines", $selected_outline);
            session()->put("session_article_platform", $platform);

            return $this->integrationService->contentGenerator(aiEngine(), $request);
        } catch (\Throwable $e) {
            wLog("Failed to Generate Article", errorArray($e), logService()::LOG_OPEN_AI);

            return $this->streamErrorResponse($e->getMessage());
        }
    }

    # format ai response data
    /**
     * @incomingParams $string contains a data
     *
     * Step 1 : Check is array & not empty checking
     *
     * Step 2 : When Step 1 is true we will replace single quote with Double Quote
     *
     * Step 3 : When Step 2 is complete, now we are adding a forward-slash before "\["
     *
     * Step 4 : When Step 3 is complete, Decode the string & set empty array when it's null
     *
     * Step 5 : Finally Return the decoded data.
     *
     */

    public function formatOutputData($string)
    {
        $afterDecoded =  json_decode($string, true);
        if (is_array($afterDecoded)) {
            return $afterDecoded;
        }
        // Step 1
        if (!is_array($string) && !empty($string)) {
            // Step 2
            $jsonString = str_replace("'", "\"", $string);
            // Step 3
            $isArrayStr = preg_match('/\[(.*)\]/', $string);
            // Step 4
            if ($isArrayStr) {
                // Decode the JSON string to an array
                $afterDecoded =  json_decode($jsonString, true) ?? [];
                return $afterDecoded;
            } else {
                $jsonString = str_replace("\n  ", "", $jsonString);
                $afterDecoded =  json_decode($jsonString, true) ?? [];
                return  $afterDecoded;
            }
            // Step 5
            return  [];
        }

        // Step 5

        return $string;
    }
}
