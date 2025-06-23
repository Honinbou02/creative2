<?php

namespace App\Services\Business;

/**
 * Class SeoService.
 */
class SeoService
{
    private $seoReviewToolService;

    public function __construct()
    {
        $this->seoReviewToolService = new SeoReviewToolService();
    }

    public function getHelpfulContentAnalysis(array $payloads)
    {
        return $this->seoReviewToolService->getHelpfulContentAnalysis($payloads);
    }

    public function getSeoContentOptimizationAnalysis(array $payloads)
    {
        return $this->seoReviewToolService->getSeoContentOptimizationAnalysis($payloads);
    }

    public function generateBulkKeywordAnalysis(array $keywords)
    {
        return $this->seoReviewToolService->generateBulkKeywordAnalysis($keywords);
    }


}
