<?php

namespace App\Services\Business;

use App\Models\AiVideo;
use App\Utils\AppIntegrationUrlKey;
use Illuminate\Support\Facades\Http;

/**
 * Class AiAvatarProService.
 */
class AiAvatarProService
{
    private $appIntegrationUrlKey;

    public function __construct()
    {
        $this->appIntegrationUrlKey = new AppIntegrationUrlKey();
    }

    /**
     * @throws \Exception
     */
    public function getAvatarsAndTalkingPhotos()
    {
        $endpoint = $this->appIntegrationUrlKey->getHeyGenApiURL()."avatars";

        $aiProAvatar = $this->sendApiRequest($endpoint);

        return [
            "avatars"        => $aiProAvatar["data"]["avatars"],
            "talking_photos" => $aiProAvatar["data"]["talking_photos"],
        ];
    }


    /**
     * @throws \Exception
     */
    public function loadVoices()
    {
        $endpoint = $this->appIntegrationUrlKey->getHeyGenApiURL()."voices";

        $aiProAvatar = $this->sendApiRequest($endpoint);

        return $aiProAvatar["data"]["voices"];
    }

    public function sendApiRequest($endpoint, array | null $payloads = null)
    {
        $headers = [
            "X-Api-Key" => $this->appIntegrationUrlKey->getHeyGenApiKey(),
            "Accept" => "application/json",
        ];

        $response = Http::withHeaders($headers)->get($endpoint);

        if($response->successful()){

            return $response->json();
        }

        throw new \Exception($response->body(), $response->status());
    }


    public function getEmotions()
    {
        return ['Excited', 'Friendly', 'Serious', 'Soothing', 'Broadcaster'];
    }

    public function createVideo(array $payloads)
    {

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'X-Api-Key' => $this->appIntegrationUrlKey->getHeyGenApiKey(),
        ])->post('https://api.heygen.com/v2/video/generate', [
            'video_inputs' => [
                [
                    'character' => [
                        'type' => 'avatar',
                        'avatar_id' => $payloads['avatar_id'],
                        'avatar_style' => $payloads["avatar_style"],
                    ],
                    'voice' => [
                        'type' => 'text',
                        'input_text' => $payloads["script"],
                        'voice_id' => $payloads["voice_id"],
                    ],
                    'background' => $this->getVideoBackground(),
                ],
            ],
            'dimension' => $this->getVideoDimension(),
        ]);

        if(!$response->successful()) {
            wLog("Failed to generate video", ["errors" => $response->body()]);
            throw new \Exception($response->body(), $response->status());
        }

        info("Video generated successfully : ".json_encode($response->json()));

        return $response->json()['data']['video_id'];
    }

    public function getHeyGenVideos()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'X-Api-Key' => $this->appIntegrationUrlKey->getHeyGenApiKey(),
        ])->get($this->appIntegrationUrlKey->getHeyGenApiURL(true));

        if($response->failed()) {
            throw new \Exception($response->body(), $response->status());
        }

        $videos = $response->json()["data"]["videos"];

        return $response->json();
    }

    public function getAiVideoByUserIdAndVideoId($videoId, $userId)
    {
        return AiVideo::query()->where("user_id", $userId)->where("video_id", $videoId)->first();
    }

    public function getVideoUrlByVideoId($videoId)
    {
        $apiUrl = "https://api.heygen.com/v1/video_status.get?video_id={$videoId}";

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'X-Api-Key' => $this->appIntegrationUrlKey->getHeyGenApiKey(),
        ])->get($apiUrl);

        if ($response->successful()) {
            return $response->json()['data'];
        }

        // Exception Trigger
        throw new \Exception($response->body(), $response->status());
    }

    public function getVideoStatus(object $aiVideo)
    {
        // Check is already generated or not
        if(!empty($aiVideo->generated_video_url)){

            return $aiVideo;
        }

        // Get Video Info
        $videoStatus = $this->getVideoUrlByVideoId($aiVideo->video_id);

        $aiVideo->update([
            "generated_thumbnail"         => $videoStatus["thumbnail_url"] ?? null,
            "generated_video_url"         => $videoStatus["video_url"] ?? null,
            "generated_video_gif_url"     => $videoStatus["video_url"] ?? null,
            "generated_video_status"      => $videoStatus["status"] ?? null,
            "generated_video_duration"    => $videoStatus["duration"] ?? 0,
            "generated_video_url_caption" => $videoStatus["video_url_caption"] ?? null,
        ]);

        return $aiVideo;
    }

    public function getVideoDimension(): array
    {
        return [
            'width'  => 1280,
            'height' => 720,
        ];
    }

    public function getVideoBackground()
    {

        return [
            'type'  => 'color',
            'value' => '#FFFFFF',
        ];
    }

    public function storeAiVideo(array $payloads, $videoId, $userId)
    {
        $payloads["title"]          = $payloads["title"] ?? "AI Generated Video with HeyGen";
        $payloads["video_script"]   = $payloads["script"];
        $payloads["video_id"]       = $videoId;
        $payloads["user_id"]        = $userId;

        // Platform Details
        $payloads["platform"]        = $this->getAvatarProPlatform();


        // Video Dimension
        $payloads["video_dimension"]  = json_encode($this->getVideoDimension());

        // Background
        $payloads["background_type"]  = $this->getVideoBackground()["type"];
        $payloads["background_value"] = $this->getVideoBackground()["value"];

        return AiVideo::query()->create($payloads);
    }

    public function getAvatarProPlatform()
    {
        return "HeyGen"; //TODO:: Will update later
    }

    /**
     * @throws \Exception
     */
    public function getAvatarByAvatarId($avatarId)
    {
        $endPoint = $this->appIntegrationUrlKey->getHeyGenApiURL()."avatars/$avatarId";

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'X-Api-Key' => $this->appIntegrationUrlKey->getHeyGenApiKey(),
        ])->get($endPoint);

        if($response->successful()) {
            return $response->json();
        }

        // Failed to Fetch Avatar
        throw new \Exception($response->body(), $response->status());
    }

}
