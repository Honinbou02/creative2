<?php

namespace App\Services\Business;

use App\Models\ArticleSEO;
use App\Utils\AppIntegrationUrlKey;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Class SeoReviewToolService.
 */
class SeoReviewToolService
{
    private $appService;

    public function __construct()
    {
        $this->appService  = new AppIntegrationUrlKey();
    }

    /**
     * @throws \JsonException
     */
    public function seoContentOptimization($payloads)
    {
        // API URL
        $apiUrl          = $this->appService->getSEOBaseURL().'v5-1/seo-content-optimization/';
        $payloads["key"] = $this->appService->getSEOApiKey();

        // Save ArticleSEO.php
        $articleSEO = $this->storeArticleSeo($payloads, $apiUrl);

        // Unset article_json, article_id from $payloads
        unset($payloads["article_json"], $payloads["article_id"]);

        $response = Http::timeout(0)
                    ->withHeaders([
                        'Content-Type' => 'application/json'
                    ])->post($apiUrl, $payloads);

        // Storing the SEO Response
        $articleSEO->update([
            "seo_json" => json_encode($response->body())
        ]);

        // When API Request is Failed
        if($response->failed()) {
            wLog(
                "SEO Content Optimization Failed for article {$articleSEO->article_id}",
                [ "errors" => $response->json()],
                logService()::LOG_SEO
            );

            throw new \RuntimeException($response->body(), $response->status());
        }

        wLog(
            "SEO Content Optimization Success for article {$articleSEO->article_id}",
            [ "successResponse" => $response->json()],
            logService()::LOG_SEO
        );

        $apiResponse = json_decode($response->body());

        return $response->json();
    }

    public function getHelpfulContentAnalysis(array $payloads)
    {
        $contentInput = $payloads["data"]["content_input"];

        // Content to check
        $data = trim($contentInput["body_content"]);

        // remove tabs and spaces
        $data = preg_replace('/\s+/S', " ", $data);

        // Encode data array to JSON
        $data = json_encode($data);

        // API key
        $apiKey      = $this->appService->getSEOApiKey();
        $apiEndpoint = $this->getHelpfulContentAnalysisUrl();

        $articleSEO = $this->storeArticleSeo(
          $payloads,
          $apiEndpoint
        );


        $toolRequestUrl = "{$apiEndpoint}/?content=1" . "&key=" . $apiKey;

        $seoDataJson = $this->curlFunction($toolRequestUrl, $data);

        header("Content-type: application/json");

        Log::info(json_encode($seoDataJson));

        $articleSEO->update([
            "seo_json" => json_encode($seoDataJson)
        ]);

        return $seoDataJson;
    }
    
    public function getSeoContentOptimizationAnalysis(array $payloads)
    {
        $contentInput = $payloads["data"]["content_input"];

        // Title tag
        $title_tag = $contentInput["title_tag"];

        // Meta description
        $meta_description = $contentInput["meta_description"];

        // Content to check
        $body_content = $contentInput["body_content"];

        // remove tabs and spaces
        $body_content = preg_replace('/\s+/S', " ", $body_content);

        $data = [
            'content_input' => [
                'title_tag'        => $title_tag,
                'meta_description' => $meta_description,
                'body_content'     => trim($body_content)
            ]
        ];

        // Encode data array to JSON
        $data = json_encode($data);

        // Keyword to check
        $keywordInput = $payloads["keyword"];

        // Related keywords (optional)
        $relatedKeywords = $payloads["relatedKeyword"];

        // API key
        $apiKey      = $this->appService->getSEOApiKey();
        $apiEndpoint = $this->getSeoContentOptimizationUrl();

        $articleSEO = $this->storeArticleSeo(
          $payloads,
          $apiEndpoint
        );


        $toolRequestUrl = "{$apiEndpoint}/?content=1&keyword=" . urlencode($keywordInput) . "&relatedkeywords=" . urlencode($relatedKeywords) . "&key=" . $apiKey;

        $seoDataJson = $this->curlFunction($toolRequestUrl, $data);

        header("Content-type: application/json");

        Log::info(json_encode($seoDataJson));

        $articleSEO->update([
            "seo_json" => json_encode($seoDataJson)
        ]);

        return $seoDataJson;
    }

    public function getBulkKeywordAnalysisURL(): string
    {
        return $this->appService->getSEOBaseURL()."keyword-statistics";
    }

    public function generateBulkKeywordAnalysis(array $keywords)
    {
        wLog("Array Keywords",["keywords" => $keywords], logService()::LOG_SEO);
        if(is_string($keywords)){
            $keywords = json_decode($keywords,true );
        }

        $dataArr = [
            "keywords" => $keywords
        ];

        // Input keywords
        $data = json_encode($dataArr);
        // $data = json_encode(['keywords' => ['seo', 'sem']]);

        // Location
        $location = "United States";

        // Language
        $language = "English";

        // API key
        $apiKey = $this->appService->getSEOApiKey();

        $toolRequestUrl = "https://api.seoreviewtools.com/keyword-statistics/?location=".urlencode($location)."&hl=".urlencode($language)."&key=".$apiKey;

        wLog("Bulk : {$toolRequestUrl} ",[], logService()::LOG_SEO);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $toolRequestUrl);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $dataJson = curl_exec($ch);
        $curlInfo = curl_getinfo($ch);

        header("Content-type: application/json");

        wLog("Bulk Keyword Analysis",["response" => $dataJson], logService()::LOG_SEO);

        return $dataJson;
    }

    public function getHelpfulContentAnalysisUrl()
    {
        return $this->appService->getSEOBaseURL()."helpful-content-analysis";
    }

    public function getSeoContentOptimizationUrl()
    {
        return $this->appService->getSEOBaseURL()."v5-1/seo-content-optimization";
    }

    public function storeArticleSeo(array $payloads, $apiUrl)
    {
        // Save ArticleSEO.php
        $data = [
            "article_id"        => $payloads["article_id"],
            "article_json"      => $payloads["article_json"],
            "seo_request_body"  => json_encode(array_diff_key($payloads, array_flip(['article_id', 'article_json']))),
            "seo_operator_url"  => $apiUrl,
            "created_by_id"     => userID(),
        ];

        return ArticleSEO::query()->create($data);
    }


    function curlFunction($toolRequestUrl, $data)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $toolRequestUrl);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
        
        $html     = curl_exec($ch);
        $curlInfo = curl_getinfo($ch);

        return($html);
    }

}
