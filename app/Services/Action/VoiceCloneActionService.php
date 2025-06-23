<?php

namespace App\Services\Action;

use App\Services\Balance\BalanceService;
use App\Services\Business\VoiceCloneService;

/**
 * Class VoiceCloneActionService.
 */
class VoiceCloneActionService
{

    private $voiceService;

    public function __construct()
    {
        $this->voiceService = new VoiceCloneService();
    }

    public function getVoicesByUserId($userId)
    {
        return $this->voiceService->getVoicesByUserId($userId);
    }

    /**
     * Create Voice
     * Save Voice into database
     * Balance Update
     * */
    public function cloneVoice(array $payloads, object $user)
    {
        $voiceClone = $this->voiceService->cloneVoice($payloads);

        if(empty($voiceClone)){
            throw new \RuntimeException("Failed to clone voice", appStatic()::BALANCE_ERROR);
        }

        $this->voiceService->saveVoice($voiceClone["voice_id"], $user->id, $payloads);

        // Update Balance
        (new BalanceService())->audio2TextBalanceUpdate(getUserObject(), 1);

        return $voiceClone;
    }


}
