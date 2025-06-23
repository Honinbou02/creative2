<?php

namespace App\Services\Action;

use App\Models\Voice;
use App\Models\Avatar;
use App\Models\AiVideo;
use App\Models\TalkingPhoto;
use App\Services\Balance\BalanceService;
use App\Services\Business\AiAvatarProService;
use Illuminate\Support\Str;

/**
 * Class AiAvatarProActionService.
 */
class AiAvatarProActionService
{
    private $avatarService;

    public function __construct()
    {
        $this->avatarService = new AiAvatarProService();
    }

    public function getAvatarByAvatarId($avatarId)
    {
        return $this->avatarService->getAvatarByAvatarId($avatarId);
    }


    /**
     * @throws \Exception
     */
    public function getAvatarsAndTalkingPhotos()
    {
        return $this->avatarService->getAvatarsAndTalkingPhotos();
    }

    /**
     * @throws \Exception
     */
    public function importAvatarsAndTalkingPhotos()
    {
        $avatarsAndTalkingPhotosData = $this->avatarService->getAvatarsAndTalkingPhotos();

        foreach ($avatarsAndTalkingPhotosData as $avatarsAndTalkingPhotosType => $photos) {
            if($avatarsAndTalkingPhotosType == 'avatars'){
                foreach($photos as $photo) {
                    Avatar::query()->updateOrInsert(
                        ['avatar_id' => $photo['avatar_id']],
                        [
                            'avatar_name'       => $photo['avatar_name'],
                            'gender'            => $photo['gender'],
                            'preview_image_url' => $photo['preview_image_url'],
                            'preview_video_url' => $photo['preview_video_url'],
                            'created_at'        => now(),
                            'updated_at'        => now(),
                        ]
                    );
                }
            } else if($avatarsAndTalkingPhotosType == 'talking_photos'){
                foreach($photos as $photo) {
                    TalkingPhoto::query()->updateOrInsert(
                        ['talking_photo_id' => $photo['talking_photo_id']],
                        [
                            "talking_photo_name" => $photo['talking_photo_name'],
                            "preview_image_url"  => $photo['preview_image_url'],
                            'created_at'         => now(),
                            'updated_at'         => now(),
                        ]
                    );                    
                }
            }
        }
    }


    /**
     * @throws \Exception
     */
    public function loadVoices()
    {
        return $this->avatarService->loadVoices();
    }

    /**
     * @throws \Exception
     */
    public function importVoices()
    {
        $voicesData = $this->avatarService->loadVoices();

        foreach ($voicesData as $voice) {
            Voice::query()->updateOrInsert(
                ['voice_id' => $voice['voice_id']],
                [
                    'language'                   => $voice['language'],
                    'gender'                     => $voice['gender'],
                    'name'                       => $voice['name'],
                    'preview_audio'              => $voice['preview_audio'],
                    'support_pause'              => $voice['support_pause'],
                    'emotion_support'            => $voice['emotion_support'],
                    'support_interactive_avatar' => $voice['support_interactive_avatar'],
                    'created_at'                 => now(),
                    'updated_at'                 => now(),
                ]
            );
        }

        return "Voices imported successfully.";
    }


    public function getEmotions()
    {
        return $this->avatarService->getEmotions();
    }

    /**
     * @throws \Exception
     */
    public function createVideo(array $payloads, object $user)
    {
        $videoId = $this->avatarService->createVideo($payloads); // will receive Video Id

        $aiVideo = $this->avatarService->storeAiVideo($payloads, $videoId, $user->id);

        // Balance Update
        (new BalanceService())->updateVideoBalance($user, 1);

        return $aiVideo;
    }

    public function getVideos($userId)
    {
        return AiVideo::query()
            ->when(!isAdmin(), function ($q) use ($userId){
                $q->where("user_id", $userId);
            })->latest()
            ->paginate(maxPaginateNo());
    }

    public function getHeyGenVideos()
    {
        return $this->avatarService->getHeyGenVideos();
    }

    public function getVideoStatus($videoId, $userId)
    {

        // Validated the video id is belongs to the user or not
        $isUserVideo = $this->avatarService->getAiVideoByUserIdAndVideoId($videoId, $userId);

        if(empty($isUserVideo)){
            throw new \Exception("Sorry Unauthorized action.", appStatic()::UNAUTHORIZED);
        }

        // Get User Status of HeyGen Video
        $this->avatarService->getVideoStatus($isUserVideo);

        return $isUserVideo;
    }
}
