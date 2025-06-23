<?php

namespace Modules\WordpressBlog\App\resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WpSettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
