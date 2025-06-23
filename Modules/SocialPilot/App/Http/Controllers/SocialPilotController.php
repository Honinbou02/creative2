<?php

namespace Modules\SocialPilot\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Model\SystemSetting\SystemSettingService;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Modules\SocialPilot\App\Models\PlatformsAccount;
use Modules\SocialPilot\App\Models\SocialPost;
use Modules\SocialPilot\App\Services\Account\FacebookService;
use Modules\SocialPilot\App\Services\Account\InstagramService;
use Modules\SocialPilot\App\Services\Account\LinkedinService;
use Modules\SocialPilot\App\Services\Account\TwitterService;
use Modules\SocialPilot\App\Services\Post\SocialPostService;

class SocialPilotController extends Controller
{
    protected $settingsService;
    protected $socialPostService;

    # constructor
    public function __construct()
    {
        $this->settingsService      = new SystemSettingService();
        $this->socialPostService    = new SocialPostService();
    }

    # handelCronJob
    public function handelCronJob()
    {
        try {
            $this->handleScheduledAndPendingPosts();
            $this->refreshToken();
        } catch (\Throwable $th) {
            // do something crazy here
        }
        $this->settingsService->storeOrUpdate('last_cron_run', Carbon::now());
    }

    // publish scheduled posts
    function handleScheduledAndPendingPosts()
    {
        $posts = SocialPost::canBePosted()->cursor();
        foreach($posts->chunk(20) as $chunkPosts){
            foreach($chunkPosts as $post){
                sleep(1);
                if($post->schedule_time <= Carbon::now() || $post->post_status == appStatic()::POST_STATUS['PENDING']) {
                    $this->socialPostService->publish($post);
                }
            }
        }
    }

    // refresh tokens
    public function refreshToken()
    {
        $dateTime = now()->addDay()->format('Y-m-d h:i:s');

        PlatformsAccount::where('access_token_expire_at', '<=', $dateTime)->lazyById(1000,'id')
        ->each(function(PlatformsAccount $platformAccount) {
            $platform   = $platformAccount?->platform;
            $token      = $platformAccount?->refresh_token ?? $platformAccount?->access_token;

            if($platform){
                
                $response = match ($platform->slug){
                    appStatic()::PLATFORM_FACEBOOK      => (new FacebookService())->refreshAccessToken($platform, $token),
                    appStatic()::PLATFORM_INSTAGRAM     => (new InstagramService())->refreshAccessToken($platform, $token),
                    appStatic()::PLATFORM_TWITTER       => (new TwitterService())->refreshAccessToken($platform, $token),
                    appStatic()::PLATFORM_LINKEDIN      => (new LinkedinService())->refreshAccessToken($platform, $token),
                };
                
                // wLog("Refresh token response : {$platform->slug}", ["final_outline_contents" => $response->json()]);
                if ($response->successful()) {
                    if($platform->slug == appStatic()::PLATFORM_FACEBOOK || $platform->slug == appStatic()::PLATFORM_INSTAGRAM ){
                        $responseData                   = $response->json();
                        $accessToken                    = Arr::get($responseData , 'access_token');
                        $refreshToken                   = Arr::get($responseData , 'access_token');

                        $platformAccount->access_token              = $accessToken;
                        $platformAccount->access_token_expire_at    = now()->addMonths(2);
                        $platformAccount->refresh_token             = $refreshToken;
                        $platformAccount->refresh_token_expire_at   = now()->addMonths(2);

                    }else if($platform->slug == appStatic()::PLATFORM_TWITTER){
                        $responseData       = $response->json();
                        $token              = Arr::get($responseData,'access_token' );
                        $refreshToken       = Arr::get($responseData,'refresh_token' );

                        $platformAccount->access_token              = $token;
                        $platformAccount->access_token_expire_at    = now()->addMonths(2);
                        $platformAccount->refresh_token             = $refreshToken;
                        $platformAccount->refresh_token_expire_at   = now()->addMonths(2);
                    }
                    else if($platform->slug == appStatic()::PLATFORM_LINKEDIN){
                        $responseData   = $response->json();
                        $accessToken    = Arr::get($responseData , 'access_token');
                        $refreshToken   = Arr::get($responseData , 'refresh_token');

                        $platformAccount->access_token              = $accessToken;
                        $platformAccount->access_token_expire_at    = now()->seconds($responseData['expires_in']);
                        $platformAccount->refresh_token             = $refreshToken;
                        $platformAccount->refresh_token_expire_at   = now()->seconds($responseData['refresh_token_expires_in']);
                    }
                    $platformAccount->save();
                }
            }
        });
    }
}
