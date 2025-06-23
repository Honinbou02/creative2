<?php

namespace Modules\SocialPilot\App\Services\Post;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Modules\SocialPilot\App\Models\SocialPost;
use Modules\SocialPilot\App\Services\Account\AccountService;
use Modules\SocialPilot\App\Services\Account\FacebookService;
use Modules\SocialPilot\App\Services\Account\InstagramService;
use Modules\SocialPilot\App\Services\Account\LinkedinService;
use Modules\SocialPilot\App\Services\Account\TwitterService;

class SocialPostService
{
    public function index($getAll = false)
    {
        $request        = request();
        $socialPosts    = SocialPost::filterByUser()->latest();

        
        if($request->has('search')){
            $socialPosts->whereHas('platformAccount', function ($q) use ($request) {
                $q->where('account_name', 'like', '%'.$request->search.'%');
            });
        }
        
        if($request->post_status!= null){
            $socialPosts->where('post_status', $request->post_status);
        }

        if ($getAll) {
            $socialPosts    = $socialPosts->get();
        }else{
            $request->merge([
                'perPage'   => 25
            ]);
            $socialPosts    = $socialPosts->paginate(maxPaginateNo());
        }
        $data['details'] = $socialPosts;
        return $data;
    } 

    public function findById($id)
    {
        return SocialPost::findOrFail((int) $id);
    }

    public function store($request)
    {
        // todo:: check permission and balance

        $user               = user();
        $scheduleTime       = $request->schedule_time;
        $platformAccounts   = (new AccountService())->getByIds($request->platform_account_ids);
        
        DB::transaction(function() use ($request ,$user, $scheduleTime ,$platformAccounts ) {
            foreach($platformAccounts as $platformAccount){
                $platform = $platformAccount->platform;
                
                $postType       = $request->get($platform->slug.'_post_type');
                $postDetails    = $request->get($platform->slug.'_post_details');

                $post                       = new SocialPost();
                // $post->subscription_plan_id = $user ? $user->runningSubscription->id : null; // todo:: Subscription plan id
                $post->platform_id          = $platformAccount->platform_id;
                $post->platform_account_id  = $platformAccount->id;
                $post->post_type            = $postType;
                $post->details              = $postDetails;
                $post->media_manager_ids    = $request->media_manager_ids;
                $post->external_link        = $request->external_link;
                $post->post_status          = $scheduleTime ? appStatic()::POST_STATUS['SCHEDULED'] : appStatic()::POST_STATUS['PENDING'];
                $post->is_scheduled         = $scheduleTime ? appStatic()::STATUS['TRUE'] : appStatic()::STATUS['FALSE'];
                $post->schedule_time        = $scheduleTime;
                $post->user_id              = $user ? $user->id : null;
                $post->save();
            }
            // todo:: decrease balance here
        });
    }

    public function publish($post)
    {
        $platformAccount = $post->platformAccount;
        $platform        = $platformAccount->platform;

        if(!$platformAccount || !$platform) return;

        $response = match ($platform->slug) {
            appStatic()::PLATFORM_FACEBOOK      => (new FacebookService())->publishPost($post, $platform, $platformAccount),
            appStatic()::PLATFORM_INSTAGRAM     => (new InstagramService())->publishPost($post, $platform, $platformAccount),
            appStatic()::PLATFORM_TWITTER       => (new TwitterService())->publishPost($post, $platform, $platformAccount),
            appStatic()::PLATFORM_LINKEDIN      => (new LinkedinService())->publishPost($post, $platform, $platformAccount),
        };
        
        $is_success                     = Arr::get($response, 'status', false);
        $post->post_status              = $is_success ? appStatic()::POST_STATUS['SUCCESSFUL'] : appStatic()::POST_STATUS['FAILED'];
        $post->platform_api_response    = $response;
        $post->save();
        // TODO:: update balance here based on user/subscription plan
    }
}
