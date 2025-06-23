<?php

namespace Modules\SocialPilot\App\Services\Account;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class FacebookService
{
    protected $accountService;
    
    protected $baseUrl = 'https://www.facebook.com';

    public function __construct()
    {
        $this->accountService   = new AccountService();
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
    
    # store requested resource
    public function store($request, $platform)
    {
        $response = [
            'status_code'       => 200,
            'message'           => localize('Successfully created an account'),
            'result'            => []
        ];
        
        $credentials = json_decode($platform->credentials);
        $baseApi     = $credentials->graph_api_url;
        $apiVersion  = $credentials->app_version;
        $api         = $baseApi."/".$apiVersion;
        $accessToken = $request->access_token;
        $groupID     = $request->group_id;
        $pageID      = $request->page_id;
        $type        = $request->account_type;

        $platformAccountID   = $request->account_id ?? null; // already exist in our db
        
        $fields      = 'id,name,picture,link';

        switch ($type) {
            case appStatic()::ACCOUNT_TYPE['PROFILE']:
                $api    =   $api."/me";
                $fields = 'id,name,email,picture,link';
                break;
            case appStatic()::ACCOUNT_TYPE['PAGE']:
                $api    =   $api."/".$pageID;
                break;

            case appStatic()::ACCOUNT_TYPE['GROUP']:
                $api    =   $api."/".$groupID;
                break;
        }
        
        $platformApiResult = Http::get( $api, ['access_token' => $accessToken, 'fields' => $fields]);
        $platformApiResult = $platformApiResult->json();
        
        if(isset($platformApiResult['error'])) {
            $response['status_code'] = 500;
            $response['message']     = isset($platformApiResult['error']) ? localize($platformApiResult['error']['message']) : localize('Something went wrong.');
            return $response;
        }

        switch ($type) {
            case appStatic()::ACCOUNT_TYPE['PROFILE']:
                $uniqueIdentity     = Arr::get($platformApiResult,'email', null);
                break;
            case appStatic()::ACCOUNT_TYPE['PAGE']:
                $uniqueIdentity     = Arr::get($platformApiResult, 'id', null);
                $fields             = 'id,name,picture,link';
                break;
            case appStatic()::ACCOUNT_TYPE['GROUP']:
                $uniqueIdentity     = Arr::get($platformApiResult, 'id', null);
                $fields             = 'id,name,picture,link';
                $link               = $credentials->group_url."/".$uniqueIdentity;
                break;
        }

        if(isset($platformApiResult['picture']['data'])){
            $avatarThumbnail = $platformApiResult['picture']['data']['url'];
        }

        $accountDetails = [
            'id'                    => Arr::get($platformApiResult, 'id', null),
            'access_token'          => $accessToken,
            'avatar_thumbnail'      => @$avatarThumbnail,
            'account_id'            => $uniqueIdentity, 
            'account_name'          => Arr::get($platformApiResult, 'name', null),
            'email'                 => Arr::get($platformApiResult, 'email', null),
            'link'                  => Arr::get($platformApiResult, 'link', @$link),
        ];

        $this->accountService->store($platform , $accountDetails , $type , $platformAccountID);

        return $response;
    }

    # redirect to login
    public function redirect($platform)
    {
        // TODO:: Connect facebook account
    }
    
    # handle callback response
    public function callback($request)
    {
        // 
    }
  
    # publish post
    public function publishPost($post, $platform, $platformAccount)
    {
        try {
            $accountConnectionInfo = $this->accountConnectionInfo($platform, $platformAccount);

            $isConnected       = Arr::get($accountConnectionInfo, 'status', false);
            $message           = localize("Platform connection error");
            $status            = false;

            if($isConnected && $platformAccount->account_type != appStatic()::ACCOUNT_TYPE['PROFILE']){
                $message     = localize("Post published Successfully");
                $status      = true;
                switch ($post->post_type) {
                    case appStatic()::POST_TYPES['FEED']:
                        # post to feed
                        $platformResponse = $this->postToFeed($post, $platform, $platformAccount);
                        if(isset($platformResponse['error'])) {
                            $status  = false;
                            $message = $platformResponse['error']['message'];
                        }

                        if(@$platformResponse['message']) {
                            $message =  @$platformResponse['message'];
                        };

                        $postId = Arr::get($platformResponse,'id');
                        $url    = $postId ? "https://fb.com/".$postId : null;
                        break;
                    case appStatic()::POST_TYPES['REEL']:
                        # post to reel
                        $platformResponse = $this->postToReels($post, $platform, $platformAccount);
                        if(!$platformResponse['status']) {
                            $status = false;
                        }
                        if(@$platformResponse['message']) {
                            $message   =  @$platformResponse['message'];
                        }
                        $postId = Arr::get($platformResponse, 'post_id');
                        $url    =   $postId  ?  "https://www.facebook.com/reel/".$postId : null;
                        break;
                    
                    default:
                        # do something crazy here later - such as story
                        break;
                }
            }
         } catch (\Exception $ex) {
            $status  = false;
            $message = strip_tags($ex->getMessage());
         }
         return [
            'status'   => $status,
            'response' => $message,
            'url'      => @$url
        ];
    }

    # get account details
    public function accountConnectionInfo($platform, $platformAccount)
    {
        try {
            $credentials =  json_decode($platform->credentials);

            $baseApi     = $credentials->graph_api_url;
            $apiVersion  = $credentials->app_version;
            $api         = $baseApi."/".$apiVersion;

            $token       = $platformAccount->access_token;
            $fields      = 'id,full_picture,type,message,permalink_url,link,privacy,created_time,reactions.summary(true),comments.summary(true),shares';

            switch ($platformAccount->account_type) {
                case appStatic()::ACCOUNT_TYPE['PROFILE']:
                    $api =   $api."/me/feed";
                    break;
                case appStatic()::ACCOUNT_TYPE['PAGE']:
                    $fields = 'status_type,message,full_picture,created_time,permalink_url';
                    $api    =  $api."/".$platformAccount->account_id."/feed";
                    break;

                case appStatic()::ACCOUNT_TYPE['GROUP']:
                    $api    =   $api."/".$platformAccount->account_id."/feed";
                    break;
            }

            $apiResponse = Http::get( $api, [
                'access_token' =>   $token,
                'fields'       =>   $fields
            ]);

            $apiResponse    = $apiResponse->json();

            if(isset($apiResponse['error'])) {
                $this->accountService->disConnectAccount($platformAccount);
                return [
                    'status'  => false,
                    'message' => $apiResponse['error']['message']
                ];
            }
            return(['status' => true, 'response' => $apiResponse,]);
        } catch (\Exception $th) {
           return ['status'  => false, 'message' => strip_tags($th->getMessage())];
        }
    
    }

    # post to facebook feed
    public function postToFeed($post, $platform, $platformAccount)
    {
        $token      = $platformAccount->access_token;
        $pageId     = $platformAccount->account_id;
        $postData   = [];

        if ($post->details) {
            $postData['message'] = $post->details;
        }

        if ($post->external_link){
            $postData['link'] = $post->external_link;
        } 

        if($post->media_manager_ids){
            $mediaFiles = [];

            if (strpos($post->media_manager_ids, ',') !== false) {
                $mediaFileIdsArray = explode(',', $post->media_manager_ids);
            } else {
                $mediaFileIdsArray = [$post->media_manager_ids];
            }

            foreach ($mediaFileIdsArray as $mediaFileId) {
                $response = $this->uploadMedia($mediaFileId, $token, $platform, $pageId);

                if (isset($response['id'])) {
                    $mediaFiles[] = ['media_fbid' => $response['id']];
                }
            }
           $postData['attached_media'] =  $mediaFiles;
        }


        $credentials    =  json_decode($platform->credentials);
        $apiUrl         = $this->getUrl($pageId . '/feed', [], $credentials);
        $response       = Http::retry(3, 3000)
                            ->withToken($token)
                            ->post($apiUrl,  $postData);
        return $response->json();

    }

    # post to facebook reel
    public function postToReels($post, $platform, $platformAccount)
    {
        $credentials    =  json_decode($platform->credentials);
        $token          = $platformAccount->access_token;
        $pageId         = $platformAccount->account_id;


        if($post->media_manager_ids){
            
            $reelsApiUrl = $this->getUrl($pageId . '/video_reels', [], $credentials);

            if (strpos($post->media_manager_ids, ',') !== false) {
                $mediaFileIdsArray = explode(',', $post->media_manager_ids);
            } else {
                $mediaFileIdsArray = [$post->media_manager_ids];
            }

            foreach ($mediaFileIdsArray as $mediaFileId) {

                $fileURL = socialPostMediaFile($mediaFileId);

                if(isValidVideoUrl($fileURL)){
                    $sessionParams = [
                        "upload_phase" => "start",
                        "access_token" => $token
                    ];


                    $sessionResponse = Http::retry(3, 3000)->post($reelsApiUrl, $sessionParams);
                    $sessionResponse = $sessionResponse->json();

                    if(!isset($sessionResponse['video_id']) ){
                        return [
                            "status"  => false,
                            "message" => localize('Cannot create an upload session for uploading reels video to the Facebook page')
                        ];
                    }

                    $uploadResponse = Http::retry(3, 3000)->withHeaders([
                        'Authorization' => 'OAuth ' . $token,
                        'file_url'      => $fileURL
                    ])->post(@$sessionResponse['upload_url']);

                    $uploadResponse     = $uploadResponse->json();

                    if(isset($uploadResponse['success'])){
                        try {
                            $params = [
                                "video_id" => $sessionResponse['video_id'],
                                "video_state" => "PUBLISHED",
                                'upload_phase' => 'finish',
                                "description" => $post->details,
                                "access_token" => $token,
                            ];


                            $publishApiUrl = $this->getUrl($pageId . '/video_reels', [], $credentials);


                            $response     = Http::retry(3, 3000)->post(  $publishApiUrl, $params);
                            $response     = $response->json();


                            if($response['success']){
                                return [
                                    "status" => true,
                                    "post_id" => $sessionResponse['video_id'],
                                    "message" => localize('Video upload is processing now')
                                ];
                            }

                            return [
                                "status"  => false,
                                "message" => @$response['error']['message'] ?? localize("Unable to upload!! Something went wrong in API")
                            ];

                        } catch (\Exception $e) {
                            return [
                                "status" => false,
                                "message" => $e->getMessage(),
                            ];
                        }
                  
                    }

                    return [
                        "status"  => false,
                        "message" => @$uploadResponse['debug_info']['message'] ?? localize("Unable to upload!! Something went wrong in API")
                    ];

                   
                }
                
                return [
                    "status"  => false,
                    "message" => localize("Facebook reels does not support uploading images")
                ];
            }
        }

 
        return [
            "status"  => false,
            "message" => localize("No file found!! Facebook REELS does not support just links or texts.")
        ];

    }

    # upload media files to platforms
    public function uploadMedia($mediaFileId, $token, $platform , $pageId )
    {
        $fileURL = socialPostMediaFile($mediaFileId);

        $apiString =  "/videos";
        if(!isValidVideoUrl($fileURL)){
            $apiString      =  "/photos";
            $uploadParams   = [
                'url'           => $fileURL,
                'published'     => false,
            ];
        }else{
            $uploadParams = [
                'file_url'  =>  $fileURL,
                'published' =>  false,
                'description'=> 'example caption',
                'access_token' => $token,
            ];
        }
   
        $credentials    =  json_decode($platform->credentials);
        $apiUrl         = $this->getUrl($pageId . $apiString  ,[] ,$credentials );
        $uploadResponse = Http::retry(3, 3000)->withToken($token)->post($apiUrl , $uploadParams);
        return $uploadResponse->json();

    }
}
