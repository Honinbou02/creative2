<?php

namespace App\Services\Action;

use App\Models\Voice;
use App\Services\BaseService;

/**
 * Class VoiceService.
 */
class VoiceService extends BaseService
{
    private $voice;

    public function __construct()
    {
        $this->voice = new Voice();
    }

    /**
     * @throws \Exception
     */
    public function getVoices()
    {
        $voices = $this->getData(Voice::query());

        return $voices;
    }

}
