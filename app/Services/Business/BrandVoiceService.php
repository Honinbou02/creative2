<?php

namespace App\Services\Business;

use App\Models\BrandVoice;
use App\Models\BrandVoiceProduct;

/**
 * Class BrandVoiceService.
 */
class BrandVoiceService
{

    public function getBrandVoicesByUserId($userId)
    {

        return BrandVoice::query()->with("products")
            ->when(!isAdmin(), function ($query) use ($userId) {
                $query->where("user_id", $userId);
            })
            ->paginate(maxPaginateNo());
    }

    public function getTones()
    {
        return [
            "Professional",
            "Funny",
            "Casual",
            "Excited",
            "Witty",
            "Sarcastic",
            "Feminine",
            "Masculine",
            "Bold",
            "Dramatic",
            "Grumpy",
            "Secretive",
        ];
    }

    public function getTypes()
    {
        return [
            "Product",
            "Service",
            "Other",
        ];
    }

    public function storeBrandVoice($payloads, $userId)
    {
        $data            = $payloads;
        $data["user_id"] = $userId;

        unset($data["name"], $data["types"], $data["descriptions"]);

        return BrandVoice::query()->create($payloads);
    }

    public function updateBrandVoice($brandVoice,array $payloads)
    {
        $data            = $payloads;

        unset($data["name"], $data["types"], $data["descriptions"]);

        $brandVoice->update($payloads);

        return $brandVoice;
    }

    public function storeBrandVoiceProducts(object $brandVoice, array $payloads)
    {
        $products = [];
        foreach ($payloads["names"] as $key => $name) {

            if(!empty($name && $payloads["types"][$key] && $payloads["descriptions"][$key])) {
                $payloads["brand_voice_id"] = $brandVoice->id;
                $payloads["name"]           = $name;
                $payloads["type"]           = $payloads["types"][$key];
                $payloads["features"]       = $payloads["descriptions"][$key];

                $products[] = BrandVoiceProduct::query()->create($payloads);
            }
        }

        return $products;
    }

    public function deleteBrandVoiceProductsByBrandVoiceId($brandVoiceId)
    {
        return BrandVoiceProduct::query()->where("brand_voice_id", $brandVoiceId)->delete();
    }

    public function getBrandVoiceById($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null
    {
        return BrandVoice::query()->findOrFail($id);
    }

}
