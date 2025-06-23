<?php

namespace Modules\SocialPilot\App\Services\Account;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class LinkedinService
{
    protected $accountService;
    protected $baseUrl = 'https://linkedin.com';
    protected $apiUrl  = 'https://api.linkedin.com';

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
                return ['openid profile email w_member_social'];
           default:
                return ['openid profile email w_member_social'];
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

        if (count($options) > 0 ) {
            $urlEndpointWithVersion .= '?' . http_build_query($options);
        }
        return $urlEndpointWithVersion;
    }

    # get access token
    public function getAccessToken($code, $platform)
    {
        $credentials        =  json_decode($platform->credentials);
        $apiUrl             = $this->getUrl('/oauth/v2/accessToken', [
            'code'          => $code,
            'grant_type'    => 'authorization_code',
            'client_id'     => $credentials->client_id,
            'client_secret' => $credentials->client_secret,
            'redirect_uri'  => route('social.accounts.callback', $platform->slug),
        ], $credentials, true);
        return Http::post($apiUrl);
    }
    
    # refresh access token
    public function refreshAccessToken($platform, $token)
    {
        $credentials =  json_decode($platform->credentials);
        $apiUrl      = $this->getUrl('oauth/v2/accessToken', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $token,
            'client_id' =>  $credentials->client_id,
            'client_secret' => $credentials->client_secret,
        ], $credentials, true);
        return Http::asForm()->post($apiUrl);
    }

    # get linkedin accounts
    public function getAccount($platform , $token)
    {
        $credentials    =  json_decode($platform->credentials);
        $apiUrl = $this->getUrl('v2/userinfo', [],$credentials);
        return Http::withToken($token)->get($apiUrl);
    }

    # redirect to login
    public function redirect($platform)
    {
        $scopes       = collect($this->getScopes())->join(',');
        $credentials  =  json_decode($platform->credentials);
        
        return  $this->getUrl('oauth/v2/authorization', [
            'response_type'     => 'code',
            'client_id'         => $credentials->client_id,
            'redirect_uri'      => route('social.accounts.callback', $platform->slug),
            'scope'             => $scopes,
        ], $credentials, true);
    }

    # handle callback response
    public function callback($request, $platform)
    {
        $getAccessTokenResponse = $this->getAccessToken($request->code, $platform);
        $tokenResponse          = $getAccessTokenResponse->json();
        $token                  = @$tokenResponse['access_token'] ?? null;

        if ($getAccessTokenResponse->failed() || !$token) {
            flashMessage("error", localize('Failed to linkedin account.'));
            return redirect()->route('admin.accounts.index', ['type' => $platform->slug]);
        }
        $tokenExpireIn      = @$tokenResponse['expires_in'] ?? null;
        $linkedInAccount    = $this->getAccount($platform, $token);

        if ($linkedInAccount->failed()) {
            flashMessage("error", localize('Failed to linkedin account.')); 
            return redirect()->route('admin.accounts.index', ['type' => $platform->slug]);
        }

        
        $user = $linkedInAccount->json();
        
        $this->saveAccount($user, $platform, appStatic()::ACCOUNT_TYPE['PROFILE'], $token, $tokenExpireIn); 

        flashMessage("success", localize('Successfully added account'));
        return redirect()->route('admin.accounts.index', ['type' => $platform->slug]);
    }

    # save accounts
    public function saveAccount($user, $platform, $type, $token, $tokenExpireIn)
    {
        $accountDetails = [
            'id'                        => $user['sub'],
            'avatar_thumbnail'          => Arr::get($user, 'picture'),
            'account_id'                => $user['sub'], 
            'account_name'              => Arr::get($user,'name',null),
            'email'                     => Arr::get($user, 'email'),

            'access_token'              => $token,
            'access_token_expire_at'    => now()->seconds($tokenExpireIn),
            'refresh_token'             => $token,
            'refresh_token_expire_at'   => now()->seconds($tokenExpireIn),
        ];

        $this->accountService->store($platform, $accountDetails, $type, null);
    }

    # publish post
    public function publishPost($post, $platform, $platformAccount)
    {
        try {
            $message     = localize("Post is being published");
            $status      = true;

            $token        = $platformAccount->access_token;
            $linkedinId   = $platformAccount->account_id;
            $credentials  = json_decode($platform->credentials);
            
            $mediaFileIdsArray = [];
            if($post->media_manager_ids){
                if (strpos($post->media_manager_ids, ',') !== false) {
                    $mediaFileIdsArray = explode(',', $post->media_manager_ids);
                } else {
                    $mediaFileIdsArray = [$post->media_manager_ids];
                }
            }

            if(count($mediaFileIdsArray) > 0){
                $uploadedMedia = collect([]);
                foreach ($mediaFileIdsArray as $mediaFileId) {
                    $fileURL        = socialPostMediaFile($mediaFileId);
                    $imageContainer = $this->apiClient($token)->post($this->getUrl('rest/images', [
                                        'action' => 'initializeUpload'
                                    ],$credentials), [
                                        "initializeUploadRequest" => ["owner" => "urn:li:person:{$linkedinId}"]
                                    ])
                                    ->json('value');

                    $response       = $this->apiClient($token)->attach('file', fopen($fileURL, 'r'))->post($imageContainer['uploadUrl']);
                    if ($response->created()) {
                        $uploadedMedia->push($imageContainer);
                    }
                }

                $postImages = $uploadedMedia->map(function ($item) {
                    return ['id' => $item['image']];
                });

                $attachMediaObj = ($postImages->count() > 1) ? [
                                    "content" => [
                                        "multiImage" => [
                                            "images" => $postImages->toArray()
                                        ]
                                    ]
                                ] : [
                                    "content" => [
                                        "media" => [
                                            "id" => $postImages->value('id')
                                        ]
                                    ]
                                ];
                $post = [
                    "author"        => "urn:li:person:{$linkedinId}",
                    "commentary"    => $post->details ?? '',
                    "visibility"    => 'PUBLIC',
                    "distribution"  => [
                                        "feedDistribution" => 'MAIN_FEED',
                                        "targetEntities" => [],
                                        "thirdPartyDistributionChannels" => []
                                    ],
                    "lifecycleState" => "PUBLISHED",
                    "isReshareDisabledByAuthor" => false,
                    ...$attachMediaObj
                ];

                
                $response = $this->apiClient($token)->post($this->getUrl('rest/posts', [], $credentials), $post);

                if ($response->successful()) {
                    return [
                        'status'   =>true,
                        'response' => localize("Posted Successfully"),
                        'url'      => null
                    ];
                }
                
                return [
                    'status'   => false,
                    'response' => @$response->json('message') ?? localize("Failed to post"),
                    'url'      => null
                ];

            }else{
                $post = [
                    "author" => "urn:li:person:{$linkedinId}",
                    "commentary" =>  $post->details ?? '',
                    "visibility" => 'PUBLIC',
                    "distribution" => [
                        "feedDistribution" => 'MAIN_FEED',
                        "targetEntities" => [],
                        "thirdPartyDistributionChannels" => []
                    ],
                    "lifecycleState" => "PUBLISHED",
                    "isReshareDisabledByAuthor" => false
                ];
                
                $response = $this->apiClient($token)->post($this->getUrl('rest/posts', [], $credentials), $post);

                
                if ($response->successful()) {
                    return [
                        'status'   =>true,
                        'response' => localize("Posted Successfully"),
                        'url'      => null
                    ];

                }

                return [
                    'status'   => false,
                    'response' => @$response->json('message') ?? localize("Failed to post"),
                    'url'      => null
                ];
            }
        } catch (\Exception $th) {
            $status  = false;
            $message = strip_tags($th->getMessage());
        }

        return [
            'status'   => $status,
            'response' => $message,
            'url'      => null
        ];
    }
    
    # api client
    private function apiClient($token)
    {
        return Http::withHeaders([
            'X-Restli-Protocol-Version' => '2.0.0',
            'LinkedIn-Version' => '202408',
        ])->withToken($token)->retry(1, 3000);
    }

}
