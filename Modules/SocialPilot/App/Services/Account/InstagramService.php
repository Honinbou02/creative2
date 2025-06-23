<?php

namespace Modules\SocialPilot\App\Services\Account;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class InstagramService
{
    protected $accountService;
    protected $baseUrl = 'https://www.facebook.com';
    protected $apiUrl  = 'https://graph.facebook.com';

    # constructor
    public function __construct()
    {
        $this->accountService   = new AccountService();
    }

    # get the scopes
    public function getScopes($type = 'auth')
    {
        switch ($type) {
           case 'auth':
               return [
                'instagram_basic',
                'instagram_manage_insights',
                'instagram_content_publish'
               ];
           default:
               return [
                   'pages_read_engagement'
               ];
        }
    }

    # get url
    public function getUrl($urlEndpoint, $options = [], $credentials , $useBaseUrl = false)
    {
        $baseUrl = $useBaseUrl ? $this->baseUrl: $credentials->graph_api_url;

        if (str_starts_with($urlEndpoint, '/')) {
            $urlEndpoint = substr($urlEndpoint, 1);
        };

        $urlEndpointWithVersion = $baseUrl . '/' . $urlEndpoint;
        $version                = $credentials->app_version;

        if ($version) {
            $urlEndpointWithVersion = $baseUrl . '/' . $version . '/'. $urlEndpoint;
        }

        if (count($options) > 0 ) {
            $urlEndpointWithVersion .= '?' . http_build_query($options);
        }
        return $urlEndpointWithVersion;
    }

    # get access token
    public function getAccessToken($code, $platform)
    {
        $credentials    =  json_decode($platform->credentials);
        $apiUrl         = $this->getUrl('/oauth/access_token', [
            'code'          => $code,
            'client_id'     => $credentials->client_id,
            'client_secret' => $credentials->client_secret,
            'redirect_uri'      => route('social.accounts.callback', $platform->slug),
        ], $credentials);
        return Http::post($apiUrl);
    }

    # refresh token
    public function refreshAccessToken($platform , $token)
    { 
        $credentials =  json_decode($platform->credentials);
        $apiUrl      = $this->getUrl('/oauth/access_token', [
            'client_id'         => $credentials->client_id,
            'client_secret'     => $credentials->client_secret,
            'grant_type'        => 'fb_exchange_token',
            'fb_exchange_token' => $token,
        ], $credentials);
        return Http::post($apiUrl);
    }

    # get instagram accounts
    public function getAccounts($fields = ['connected_instagram_account','name','access_token'] , $platform , $token)
    {
        $credentials    =  json_decode($platform->credentials);
        $apiUrl         = $this->getUrl('/me/accounts', [
                            'access_token' => $token,
                            'fields' => collect($fields)->join(',')
                        ], $credentials);

        return Http::get($apiUrl);
    }

    # get account details
    public function getAccountDetails($accountId, $fields = null, $platform , $token)
    {
        $credentials    = json_decode($platform->credentials);
        $urlEndpoint    = '/'. $accountId;
        $redirect_uri   = $this->getUrl($urlEndpoint, [], $credentials);
        
        return Http::withToken($token)->get($redirect_uri, [
            'fields' => collect($fields)->join(','),
        ]);
    }
    
    # save accounts
    public function saveAccounts($accounts, $platform, $type, $token, $platformAccountID = null)
    {
        foreach ($accounts as $account) {
            if (isset($account['connected_instagram_account']) && isset($account['connected_instagram_account']['id'])) { 
                $accountId       = $account['connected_instagram_account']['id'];
                try {
                    $accountDetailsInfo     = $this->getAccountDetails($accountId, ['id,name,username,profile_picture_url'], $platform, $token)->throw()->json();
                    $accountDetails = [
                        'id'                        => $accountDetailsInfo['id'],
                        'avatar_thumbnail'          => Arr::get($accountDetailsInfo, 'profile_picture_url', null),
                        'account_id'                => $accountDetailsInfo['id'], 
                        'account_name'              => Arr::get($accountDetailsInfo,'username',null),
                        'email'                     => Arr::get($accountDetailsInfo,'email',null),

                        'access_token'              => Arr::get($accountDetailsInfo, 'access_token', $token),
                        'access_token_expire_at'    => now()->addMonths(2),
                        'refresh_token'             => Arr::get($accountDetailsInfo,'access_token',$token),
                        'refresh_token_expire_at'   => now()->addMonths(2),
                    ];

                    $this->accountService->store($platform, $accountDetails, $type, $platformAccountID);
                } catch (\Exception $ex) {
                    // do something crazy
                }
            }
        }
    }

    # redirect to login
    public function redirect($platform)
    {
        $scopes       = collect($this->getScopes())->join(',');
        $credentials  =  json_decode($platform->credentials);
        
        return  $this->getUrl('dialog/oauth', [
            'response_type'     => 'code',
            'client_id'         => $credentials->client_id,
            'redirect_uri'      => route('social.accounts.callback', $platform->slug),
            'scope'             => $scopes,
        ], $credentials, true);
    }

    # handle callback response
    public function callback($request, $platform)
    {
        try {
            $token      = $this->getAccessToken($request->code ,$platform)->throw()->json('access_token');
            $accounts   = $this->getAccounts(['connected_instagram_account,name,access_token'], $platform, $token)->throw()->json('data'); 
            if(count($accounts)){ 
                $this->saveAccounts($accounts, $platform, appStatic()::ACCOUNT_TYPE['PAGE'], $token); 
                flashMessage("success", localize('Successfully added account'));
                return redirect()->route('admin.accounts.index', ['type' => $platform->slug]);
            }

            flashMessage("error", localize('There are no instagram business accounts linked with the facebook.'));
            return redirect()->route('admin.accounts.index', ['type' => $platform->slug]);
        } catch (\Throwable $th) {
            flashMessage("error", localize($th->getMessage()));
            return redirect()->route('admin.accounts.index', ['type' => $platform->slug]);
        }
    }

    # publish post
    public function publishPost($post, $platform, $platformAccount)
    {
        try {
            $accountConnectionInfo = $this->accountConnectionInfo($platform, $platformAccount);

            $isConnected       = Arr::get($accountConnectionInfo, 'status', false);
            $message           = localize("Platform connection error");
            $status            = false;

            if($isConnected){
                if(is_null($post->media_manager_ids)){
                    $message = localize("Only Text or url is not supported in instagram feed");
                }else{
                    $message     = localize("Post is being published");
                    $status      = true;
                    
                    switch ($post->post_type) {
                        # post to feed
                        case appStatic()::POST_TYPES['FEED']:
                            $platformResponse = $this->postToFeed($post, $platform, $platformAccount);
                            break;
                        # post to reel
                        case appStatic()::POST_TYPES['REEL']:
                            $platformResponse = $this->postToReels($post, $platform, $platformAccount);
                            break;
                        # post to story
                        case appStatic()::POST_TYPES['STORY']:
                            $platformResponse = $this->postToStories($post, $platform, $platformAccount);
                            break;
                        
                        default:
                            # do something crazy here by doing nothing right now
                            break;
                    }
                    
                    $url     = Arr::get( $platformResponse, 'url');
                    $message = Arr::get( $platformResponse, 'message', $message);
                    $status  = Arr::get( $platformResponse, 'status', $status);
                }
            }
        } catch (\Exception $th) {
            $status  = false;
            $message = strip_tags($th->getMessage());
        }

        return [
            'status'   => @$url ? true : false,
            'response' => @$message,
            'url'      => @$url
        ]; 
    }

    # account connection info
    public function accountConnectionInfo($platform, $platformAccount)
    {
        try {
            $credentials =  json_decode($platform->credentials);
            $baseApi     = $credentials->graph_api_url;
            $apiVersion  = $credentials->app_version;
            $api         = $baseApi."/".$apiVersion;

            $token       = $platformAccount->access_token;
            $userId      = $platformAccount->account_id;
            $apiUrl      = $api."/".$userId."/media";
            $fields      = 'id,caption,media_type,media_url,thumbnail_url,permalink,timestamp';

            $params = ['fields' => $fields, 'access_token' => $token];
            
            $response    = Http::get($apiUrl, $params);
            $apiResponse = $response->json();
      
            if(isset($apiResponse['error'])) {
                $this->accountService->disConnectAccount($platformAccount);
                return [
                    'status'  => false,
                    'message' => $apiResponse['error']['message']
                ];
            }

            $apiResponse  = $this->formatResponse($apiResponse);
    
            return ['status' => true, 'response' => $apiResponse];
        } catch (\Exception $th) {
           return ['status'  => false, 'message' => strip_tags($th->getMessage())];
        }
    }

    # get the formatted response
    public function formatResponse(array $response) : array {
        $responseData = Arr::get($response,'data', []);
        if(count($responseData) > 0) {
            $formattedData = [];
            foreach($responseData as $key => $value) {
                $formattedData [] = [
                    'status_type'   => Arr::get($value,'media_type',null),
                    'full_picture'  => Arr::get($value,'media_url',null),
                    'link'          => Arr::get($value,'permalink',null),
                    'created_time'  => Arr::get($value,'timestamp',null),
                ];
            }
            $response ['data'] = $formattedData;
        }
        return $response;
    }

    # post to facebook feed
    public function postToFeed($post, $platform, $platformAccount)
    {
        $token      = $platformAccount->access_token;

        $mediaFileIdsForInstagram   = [];

        
        $mediaFileIdsArray = [];
        if($post->media_manager_ids){
            if (strpos($post->media_manager_ids, ',') !== false) {
                $mediaFileIdsArray = explode(',', $post->media_manager_ids);
            } else {
                $mediaFileIdsArray = [$post->media_manager_ids];
            }
        }

        if(count($mediaFileIdsArray) > 10) {
            return [
                'status'     => false,
                'message'    => localize('Instagram doesn\'t support more than 10 media at a time') ,
            ];
        } else if(count($mediaFileIdsArray) > 1) {
            # carousel post
            $accountId      = $platformAccount->account_id;
            $credentials    =  json_decode($platform->credentials);
            $apiUrl         = $this->getUrl($accountId . '/media', [], $credentials);

            foreach ($mediaFileIdsArray as $mediaFileId) {
                $fileURL = socialPostMediaFile($mediaFileId);
                
                $upload_params['is_carousel_item']  = true;
                $upload_params['caption']           = $post->details ?? "feed";
                
                if(!isValidVideoUrl($fileURL)){
                    $upload_params['media_type'] = 'IMAGE';
                    $upload_params['image_url']  = $fileURL;
                }else{
                    $upload_params['media_type'] = 'VIDEO';
                    $upload_params['video_url']  = $fileURL;
    
                }
    
                $upload_response            = Http::withToken($token)->asForm()->acceptJson()->post($apiUrl, $upload_params)->throw();
                $mediaFileIdsForInstagram[] = @$upload_response->json('id');
            }
    
            $upload_params = [
                'media_type' => 'CAROUSEL',
                'children'   => $mediaFileIdsForInstagram,
                'caption'    => $post->details??"feed"
            ];
    
            $publishCarouselResponse = Http::withToken($token)->retry(3, 3000)->post($apiUrl, $upload_params);
            $uploadResponse          =   $this->publishToInstagram($accountId, $publishCarouselResponse->json('id'), $platform, $token);
            
            if(@$uploadResponse["id"]){
                $shortcode      = $this->getPost(@$uploadResponse["id"] , $token , $platform  );
                $url            = "https://www.instagram.com/p/". $shortcode;
            }
        } else{
            # single post
            $mediaFileIdInDb   = $mediaFileIdsArray[0];
            $response          = $this->publishSingleFileToFeed($mediaFileIdInDb, $platformAccount, $platform, $post->details?? "feed");
            if(@$response["id"]){
                $shortcode = $this->getPost(@$response["id"], $token, $platform);
                $url           = "https://www.instagram.com/p/". $shortcode;
            }
        }

        return [
            'url'        => @$url,
            'status'     => @$url ? true : false,
            'message'    => @$url ? localize('Post published successfully') : localize('Failed to publish post'),
        ];
    }

    # publish carousel items
    protected function publishToInstagram($igId, $mediaId , $platform, $token)
    {
        $credentials    =  json_decode($platform->credentials);
        $apiUrl         = $this->getUrl($igId . '/media_publish', [], $credentials);
        
        return Http::retry(3, 3000)->withToken($token)->post($apiUrl, [
                'creation_id' => (int) $mediaId,
        ]);
    }

    # get IG post
    public function getPost($postId, $token ,$platform)
    {
        $credentials   =  json_decode($platform->credentials);
        $response      = Http::withToken($token)->get($this->getUrl($postId."?fields=shortcode", [], $credentials))->throw();
        return @$response->json('shortcode');
    }

    # publish single file
    public function publishSingleFileToFeed($mediaFileIdInDb , $platformAccount, $platform, $caption)
    {
        $id = $platformAccount->account_id;
        
        $token         = $platformAccount->access_token;
        $credentials   =  json_decode($platform->credentials);
        $fileURL        = socialPostMediaFile($mediaFileIdInDb);

        if(!isValidVideoUrl($fileURL)){
            $postData = ['media_type' => "IMAGE",'image_url' => $fileURL, 'caption' => $caption];
        }else{
            $postData = [
                'media_type'    => "REELS",
                'video_url'     => $fileURL,
                'share_to_feed' => true,
                'caption'   => $caption
            ];
        }

        $apiUrl     = $this->getUrl("$id/media", [], $credentials);
        $response   = Http::withToken($token)->retry(3, sleepMilliseconds: 3000)->post($apiUrl, $postData)->throw();
        $mediaId    = $response->json('id');

        $isUploaded = $this->checkUploadStatus(mediaId: $mediaId, delayInSeconds: 3, maxAttempts: 10, platform: $platform, token: $token);

        if(!$isUploaded['is_ready']){
            return ['status' => false,];
        }
        $uploadResponse =    $this->publishToInstagram($id, $mediaId, $platform, $token);
        return  ['id' =>  $uploadResponse->json('id')];
    }

    # check upload status
    private function checkUploadStatus($mediaId, $delayInSeconds = 3, $maxAttempts = 10, $platform, $token)
    {
        $status     = false;
        $attempted  = 0;
        $isFinished = false;

        $credentials   =  json_decode($platform->credentials);

        while (!$isFinished && $attempted < $maxAttempts) {

        $videoStatus = Http::withToken($token)
                    ->baseUrl($this->apiUrl)
                    ->retry(1, 3000)
                    ->get($this->getUrl($mediaId, ['fields' => 'status_code,status'], $credentials))->throw();


        $status = $videoStatus->json('status_code');
        $isFinished = in_array(strtolower($status), ['finished', 'ok', 'completed', 'ready']);

        if ($isFinished) {
            break;
        }

        $isError = in_array(strtolower($status), ['error', 'failed']);
        if ($isError) {
            break;
        }

        $attempted++;
            sleep($delayInSeconds);
        }

        return [
            'is_ready' => $isFinished,
            'status_code' => $status,
            'status' => $videoStatus->json('status'),
        ];
    }

    # post to IG reel
    public function postToReels($post, $platform, $platformAccount)
    {
        $credentials    = json_decode($platform->credentials);
        $token          = $platformAccount->access_token;
        $id             = $platformAccount->account_id;

        $mediaFileIdsArray = [];
        if($post->media_manager_ids){
            if (strpos($post->media_manager_ids, ',') !== false) {
                $mediaFileIdsArray = explode(',', $post->media_manager_ids);
            } else {
                $mediaFileIdsArray = [$post->media_manager_ids];
            }
        }

        $fileURL        = socialPostMediaFile($mediaFileIdsArray[0]);
        
        if(isValidVideoUrl($fileURL)){
            $postData = [
                'media_type'        => "REELS",
                'video_url'         => $fileURL,
                'share_to_feed'     => true,
                'caption'           => $post->details?? "feed"
            ]; 
            $apiUrl = $this->getUrl("$id/media", [], $credentials);

            $response = Http::withToken($token)->retry(3, sleepMilliseconds: 3000)->post($apiUrl, $postData)->throw();    
            $mediaId = $response->json('id');

            $isUploaded = $this->checkUploadStatus(mediaId: $mediaId, delayInSeconds: 3, maxAttempts: 10, platform: $platform, token: $token);
    
            if(!$isUploaded['is_ready']){
                return ['status' => false];
            }

            $uploadResponse =    $this->publishToInstagram($id, $mediaId, $platform , $token);

            if(@$uploadResponse["id"]){

                $shortcode = $this->getPost(@$uploadResponse["id"] , $token , $platform  );
                $url           = "https://www.instagram.com/p/". $shortcode;

                 return [
                    'url'        => @$url,
                    'status'     => true ,
                    'message'    => localize('Post published successfully')
                ];
            }
         }
        return [
            "status"  => false,
            "message" => localize("Invalid video format. Only mp4 & mov are supported in instagram reels.")
        ];
    }

    # post to IG stories
    public function postToStories($post, $platform, $platformAccount)
    {
        $credentials    = json_decode($platform->credentials);
        $token          = $platformAccount->access_token;
        $id             = $platformAccount->account_id;

        $mediaFileIdsArray = [];
        if($post->media_manager_ids){
            if (strpos($post->media_manager_ids, ',') !== false) {
                $mediaFileIdsArray = explode(',', $post->media_manager_ids);
            } else {
                $mediaFileIdsArray = [$post->media_manager_ids];
            }
        }

        $fileURL        = socialPostMediaFile($mediaFileIdsArray[0]);

        $postData ['caption']   = $post->details ?? "feed";
        $postData['media_type'] = "STORIES";

        if(isValidVideoUrl($fileURL)){
            $postData['video_url'] =  $fileURL;
        }else{
            $postData['image_url'] = $fileURL;
        } 

        $apiUrl     = $this->getUrl("$id/media", [], $credentials);
        $response   = Http::withToken($token)->retry(3, sleepMilliseconds: 3000)->post($apiUrl, $postData)->throw();
        $mediaId    = $response->json('id');

        $isUploaded = $this->checkUploadStatus(mediaId: $mediaId, delayInSeconds: 3, maxAttempts: 10, platform: $platform, token: $token);

        if(!$isUploaded['is_ready']){
            return [
                'status' => false,
                'message' => localize('Failed to post')
            ];
        }

       $uploadResponse =    $this->publishToInstagram($id, $mediaId,$platform , $token);


       if(@$uploadResponse["id"]){
            $shortcode = $this->getPost(@$uploadResponse["id"] , $token , $platform  );
            $url       = "https://www.instagram.com/p/". $shortcode;
       }

        return [
            'url'        => @$url,
            'status'     => @$url ? true : false,
            'message'    => @$url ? localize('Post published successfully') : localize('Failed to post'),
        ];
    }
}
