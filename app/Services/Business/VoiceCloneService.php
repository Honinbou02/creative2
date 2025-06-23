<?php

namespace App\Services\Business;

use App\Models\AiVoice;
use App\Utils\AppIntegrationUrlKey;
use Illuminate\Support\Facades\Http;

/**
 * Class VoiceCloneService.
 */
class VoiceCloneService
{
    private $appIntegrationUrlKey;

    public function __construct()
    {
        $this->appIntegrationUrlKey = new AppIntegrationUrlKey();
    }

    public function getVoicesByUserId($userId)
    {
        return AiVoice::query()->where('user_id', $userId)->paginate(maxPaginateNo());
    }

    public function cloneVoice(array $payloads)
    {
        $file     = $payloads["audio_file"];

        return $this->sendApiRequest($file, $payloads);
    }

    public function sendApiRequest(
        $file,array $payloads
    )
    {
        $fileName = $file->getClientOriginalName();
        $filePath = $file->getPathname();


        // Make the API request to ElevenLabs
        $response = Http::withHeaders([
            'xi-api-key' => $this->appIntegrationUrlKey->getElevenLabsApiKey(),
        ])
        ->attach('files', fopen($filePath, 'r'), $fileName)
        ->post(
            $this->appIntegrationUrlKey::BASE_URL_ELEVEN_LABS.'voices/add',
            ["name" => $payloads["name"]]
        );

        // Check if the request was successful
        if ($response->successful()) {
            return $response->json();
        }

        // Prepare actual error message of ElevenLabs
        $error = json_decode($response->body(), true);

        $erMsg = null;
        foreach ($error["detail"] as $key => $value) {
            $erMsg.= $value."<br/>";
        }

        throw new \RuntimeException($erMsg,appStatic()::NOT_FOUND);
    }


    public function saveVoice($voiceId, $userId, array $payloads)
    {

        return AiVoice::query()->create([
            "name"      => $payloads["name"],
            "voice_id"  => $voiceId,
            "user_id"   => $userId,
            "platform"  => appStatic()::ENGINE_ELEVEN_LAB,
        ]);
    }
}
