<?php

namespace App\Services\Action;

use App\Services\Business\BrandVoiceService;

/**
 * Class BrandVoiceActionService.
 */
class BrandVoiceActionService
{

    private $brandService;

    public function __construct()
    {
        $this->brandService = new BrandVoiceService();
    }

    public function getBrandVoicesByUserId($userId)
    {

        return $this->brandService->getBrandVoicesByUserId($userId);
    }

    public function getTones()
    {
        return $this->brandService->getTones();
    }
    public function getTypes()
    {
        return $this->brandService->getTypes();
    }

    public function storeBrandVoice(array $payloads, $userId)
    {
        // Save Brand Voice
        $brandVoice = $this->brandService->storeBrandVoice($payloads, $userId);

        // Brand Voice Products
        $brandVoiceProducts = $this->brandService->storeBrandVoiceProducts($brandVoice, $payloads);

        return $brandVoice;
    }

    public function updateBrandVoice(object $brandVoice, $payloads)
    {
        // Save Brand Voice
        $brandVoice = $this->brandService->updateBrandVoice($brandVoice, $payloads);

        // Delete Existing Brand Voice Products
        $this->deleteBrandVoiceProductsByBrandVoiceId($brandVoice->id);

        // Brand Voice Products
        $brandVoiceProducts = $this->brandService->storeBrandVoiceProducts($brandVoice, $payloads);

        return $brandVoice;
    }

    public function deleteBrandVoiceProductsByBrandVoiceId($brandVoiceId)
    {
        $this->brandService->deleteBrandVoiceProductsByBrandVoiceId($brandVoiceId);
    }

    public function getBrandVoiceById($id)
    {
        return $this->brandService->getBrandVoiceById($id);
    }
}
