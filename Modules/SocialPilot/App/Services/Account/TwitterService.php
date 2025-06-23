<?php

namespace Modules\SocialPilot\App\Services\Account;

use Abraham\TwitterOAuth\TwitterOAuth;
use Coderjerk\BirdElephant\BirdElephant;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;

class TwitterService
{
    protected $accountService;

    protected $params;
    protected $baseUrl = 'https://twitter.com';
    protected $apiUrl  = 'https://api.x.com';

    # constructor
    public function __construct()
    {
        $this->accountService   = new AccountService();
        
        $this->params = [
            'expansions'    => 'pinned_tweet_id',
            'user.fields'   => 'id,name,url,verified,username,profile_image_url'
        ];
    }

    # redirect to login
    public function redirect($platform)
    {
        $credentials    =  json_decode($platform->credentials);
        $client_id      = $credentials->client_id;
        $redirect_uri   = route('social.accounts.callback', ['platform' => $platform->slug]);
        $scope          = 'tweet.read tweet.write users.read offline.access';
        $state          = 'state';
        $codeChallenge = 'challenge';
        $codeChallengeMethod = 'plain';
        return "https://twitter.com/i/oauth2/authorize?response_type=code&client_id=$client_id&redirect_uri=$redirect_uri&scope=$scope&state=$state&code_challenge=$codeChallenge&code_challenge_method=$codeChallengeMethod";
    }

    # handle callback response
    public function callback($request, $platform)
    {
        try {
            $callbackResponse   = $this->getAccessToken($request->code ,$platform)->throw();
            $this->saveAccount($callbackResponse, $platform, appStatic()::ACCOUNT_TYPE['PROFILE']); 

            flashMessage("success", localize('Successfully added account'));
            return redirect()->route('admin.accounts.index', ['type' => $platform->slug]);
        } catch (\Throwable $th) {
            flashMessage("error", localize($th->getMessage()));
            return redirect()->route('admin.accounts.index', ['type' => $platform->slug]);
        }
    }

    # get url
    public function getUrl($urlEndpoint, $options = [], $credentials , $useBaseUrl = false)
    {
        $baseUrl = $useBaseUrl ? $this->baseUrl: $this->apiUrl;

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
        $credentials    = json_decode($platform->credentials);
        $client_id      = $credentials->client_id;
        $client_secret  = $credentials->client_secret;

        $apiUrl = $this->getUrl('oauth2/token', [
            'code'          => $code,
            'grant_type'    => 'authorization_code',
            'client_id'     =>$client_id,
            'redirect_uri'  => route('social.accounts.callback', ['platform' => $platform->slug]),
            'code_verifier' => 'challenge',
        ],$credentials);

        $basicAuthCredential = base64_encode($client_id . ':' .$client_secret);

        return Http::withHeaders([
            'Authorization' => "Basic $basicAuthCredential",
            'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
        ])->post($apiUrl);
    }

    # refresh access token
    public function refreshAccessToken($platform, $token)
    {
        $credentials         =  json_decode($platform->credentials);
        $client_id           = $credentials->client_id;
        $client_secret       = $credentials->client_secret;
        $basicAuthCredential = base64_encode($client_id . ':' .$client_secret);


        $apiUrl = $this->getUrl('oauth2/token', [
            'refresh_token' => $token,
            'grant_type'    => 'refresh_token',
            'client_id'     => $client_id,
        ],    $credentials );
        
        return Http::withHeaders([
            'Authorization' => "Basic $basicAuthCredential",
            'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
        ])->asForm()->post($apiUrl);
    }

    # save accounts
    public function saveAccount($callbackResponse, $platform, $type)
    {        
        $responseData   = $callbackResponse->json();
        
        $token          = Arr::get($responseData,'access_token' );
        $refresh_token  = Arr::get($responseData,'refresh_token' );
        
        $response   = $this->getAccount($platform, $token)->throw();
        $user       = $response->json('data');
        $accountDetails = [
            'id'                        => $user['id'],
            'avatar_thumbnail'          => Arr::get($user, 'profile_image_url'),
            'account_id'                => $user['id'], 
            'account_name'              => Arr::get($user,'name',null),
            'email'                     => Arr::get($user, 'email'),

            'access_token'              => $token,
            'access_token_expire_at'    => now()->addMonths(2),
            'refresh_token'             => $refresh_token,
            'refresh_token_expire_at'   => now()->addMonths(2),
        ];

        $this->accountService->store($platform, $accountDetails, $type, null);
    }

    # get instagram accounts
    public function getAccount($platform , $token)
    {
        $credentials    =  json_decode($platform->credentials);
        $apiUrl = $this->getUrl('users/me', [
            'user.fields' => 'name,profile_image_url,username',
        ],$credentials);
        return Http::withToken($token)->get($apiUrl);
    }
    
    # publish post
    public function publishPost($post, $platform, $platformAccount)
    {
        try {
            $credentials = array(
                'bearer_token'     => $platformAccount->access_token,
                'consumer_key'     => "zSYszH2BkYF8Cmz0G3JBQKjnq",
                'consumer_secret'  => "am0WLzWmubC7TAcAM3ADEZv84Gmi65XRu16Xf9QTGLa6cphwiC",
                'token_identifier' => "1841393778801991680-lbj1OxYGeXTHvrEmPwzZgIud487fIH",
                'token_secret'     => "Fuz1Nt3u8WgGcoANqeUHMhYCYUAFQMVEVZq55R567TXnx",
            );

            //instantiate the object
            $twitter = new BirdElephant($credentials); 
            
            $message     = localize("Post is being published");
            $status      = true;

            $token        = $platformAccount->access_token;
            $credentials  = json_decode($platform->credentials);
            
            $tweetFeed = '';

            if ($post->details) {
                $tweetFeed  .= $post->details;
            }

            if ($post->link) {
                $tweetFeed  .= $post->link;
            }
            
            $mediaFileIdsArray = [];
            if($post->media_manager_ids){
                if (strpos($post->media_manager_ids, ',') !== false) {
                    $mediaFileIdsArray = explode(',', $post->media_manager_ids);
                } else {
                    $mediaFileIdsArray = [$post->media_manager_ids];
                }
            }

            $mediaIdsString = [];
            if(count($mediaFileIdsArray) > 0) { 
                foreach ($mediaFileIdsArray as $mediaFileId) {
                    
                    $fileURL = socialPostMediaFile($mediaFileId); 

                    $image = $twitter->tweets()->upload($fileURL); 

                    $mediaIdsString[] = $image->media_id_string; 
                 }

                if(count($mediaIdsString) > 0){ 
                    $mediaIds = (new \Coderjerk\BirdElephant\Compose\Media)->mediaIds($mediaIdsString);
                    $tweet = (new \Coderjerk\BirdElephant\Compose\Tweet)->text($tweetFeed)->media($mediaIds);
                    
                    try {
                        $response   = $twitter->tweets()->tweet($tweet);   
                        if(isset($response->data) && isset( $response->data->id) ){
                            return [
                                'status'   => true,
                                'response' => localize("Posted Successfully"),
                                'url'      => "https://twitter.com/tweet/status/".$response->data->id
                            ];
                        }
                    } catch (\Throwable $th) {
                        return [
                            'status'   => false,
                            'response' => $th->getMessage() ?? 'Unauthorized'
                        ]; 
                    } 
                }
                
                return [
                    'status'   => false,
                    'response' => localize("Failed to post"),
                ];
            }else{ 
                $tweet          = (new \Coderjerk\BirdElephant\Compose\Tweet)->text($tweetFeed);
                try {
                    $response   = $twitter->tweets()->tweet($tweet);   
                    if(isset($response->data) && isset( $response->data->id) ){
                        return [
                            'status'   => true,
                            'response' => localize("Posted Successfully"),
                            'url'      => "https://twitter.com/tweet/status/".$response->data->id
                        ];
                    }
                } catch (\Throwable $th) {
                    return [
                        'status'   => false,
                        'response' => $th->getMessage() ?? 'Unauthorized'
                    ]; 
                }

            }
        } catch (\Exception $th) {
            $status  = false;
            $message = strip_tags($th->getMessage());
        }

        return [
            'status'   => $status,
            'response' => @$message,
            'url'      => null
        ]; 
    }
}
