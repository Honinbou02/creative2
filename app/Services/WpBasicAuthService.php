<?php

namespace App\Services;

use App\Services\Curl\CurlService;
use Modules\WordpressBlog\App\Models\UserSite;
use Illuminate\Support\Facades\Http;

class WpBasicAuthService extends CurlService
{
    const DOMAIN_URL          = "https://hostingard-wp.themetagss.net";
    const WP_END_POINT        = "/wp-json/wp/v2/";
    const BASE_URL            = self::DOMAIN_URL. self::WP_END_POINT;
    const URL_PROFILE         = self::BASE_URL."users/me";
    const URL_POST            = self::BASE_URL."posts";
    const URL_CATEGORIES      = self::BASE_URL."categories";
    const URL_TAGS            = self::BASE_URL."tags";
    const URL_USERS           = self::BASE_URL."users";
    const BASIC_AUTH_USER     = "hellothemetags";
    CONST BASIC_AUTH_PASSWORD = "jOap i3dY JodY oRr8 RVWj OXdb";

    const URL_EXAMPLE = "https://themetags.com/wp-json/wp/v2/";


    const SYNC_CATEGORIES = 0;
    const SYNC_TAGS       = 1;
    const SYNC_USERS      = 2;
    const SYNC_POSTS      = 3;

    /**
     * @throws \Exception
     */
    public function getUserProfileURL($credentials = null): string
    {
        $credentials = $credentials ?? $this->getCredentials();

        return $credentials[2]."users/me";
    }

    /**
     * @throws \Exception
     */
    public function getPostsURL($credentials = null): string
    {
        $credentials = $credentials ?? $this->getCredentials();

        return $credentials[2]."/posts";
    }

    /**
     * @throws \Exception
     */
    public function getCategoriesURL($credentials = null): string
    {
        $credentials = $credentials ?? $this->getCredentials();

        return $credentials[2]."/categories";
    }

    /**
     * @throws \Exception
     */
    public function getTagsURL($credentials = null): string
    {
        $credentials = $credentials ?? $this->getCredentials();

        return $credentials[2]."/tags";
    }

    /**
     * @throws \Exception
     */
    public function getUsersURL($credentials = null): string
    {
        $credentials = $credentials ?? $this->getCredentials();

        return $credentials[2]."users";
    }


    /**
     * @throws \Exception
     */
    public function connectWp()
    {
        $credentials = $this->getCredentials();

        $profileURL =$this->getUserProfileURL($credentials);

        $response = Http::withBasicAuth($credentials[0], $credentials[1])->get($profileURL);


        if($response->failed()) {
            throw new \Exception($response->body(), $response->status());
        }

        return $response->json();
    }

    /**
     * @throws \Exception
     */
    public function uploadAPost(array $payloads)
    {
        $credentials = $this->getCredentials();

        return $this->handle(
            $this->getPostsURL($credentials),
            $payloads,
            1,
            false,
            "{$credentials[0]}:{$credentials[1]}"
        )["body"];
    }

    /**
     * @throws \Exception
     */
    public function showPost(int $postId)
    {
        $credentials = $this->getCredentials();
        return $this->handle(
            $this->getPostsURL($credentials)."/{$postId}",
            null,
            1,
            true,
            "{$credentials[0]}:{$credentials[1]}"
        )["body"];
    }


    /**
     * @throws \Exception
     */
    public function updatePost(array $payloads, int $postId)
    {
        $credentials = $this->getCredentials();

        return $this->handle(
            self::URL_POST."/{$postId}",
            $payloads,
            1,
            false,
            "{$credentials[0]}:{$credentials[1]}"
        )["body"];
    }

    /**
     * @throws \Exception
     */
    public function getPosts()
    {
        $credentials = $this->getCredentials();
        $queryString = request()->getQueryString();

        return $this->handle(
            self::URL_POST."?{$queryString}",
            null,
            1,
            true,
            "{$credentials[0]}:{$credentials[1]}"
        )["body"];
    }

    /**
     * @throws \Exception
     */
    public function getCategories()
    {
        $credentials = $this->getCredentials();
        $queryString = request()->getQueryString();

        return $this->handle(
            $this->getCategoriesURL($credentials)."?{$queryString}",
            null,
            1,
            true,
            "{$credentials[0]}:{$credentials[1]}"
        )["body"];
    }

    /**
     * @throws \Exception
     */
    public function getTags()
    {
        $credentials = $this->getCredentials();
        $queryString = request()->getQueryString();

        return $this->handle(
            $this->getTagsURL($credentials)."?{$queryString}",
            null,
            1,
            true,
            "{$credentials[0]}:{$credentials[1]}"
        )["body"];
    }

    /**
     * @throws \Exception
     */
    public function getUsers()
    {
        $credentials = $this->getCredentials();
        $queryString = request()->getQueryString();
        $endpoint = $this->getUsersURL($credentials);

        if(!empty($queryString)){
            $endpoint.="?{$queryString}";
        }

        return $this->handle(
            $endpoint,
            null,
            1,
            "GET",
            "{$credentials[0]}:{$credentials[1]}"
        )["body"];
    }

    /**
     * @throws \Exception
     *
     * @return array ["userName","password","url"]
     */
    public function getCredentials()
    {
        $authUser = $this->getBasicAuthUser();
        $authPass = $this->getBasicAuthPassword();
        $authURL  = $this->getBasicAuthURL();

        return [
            $authUser,
            $authPass,
            $authURL
        ];
    }

    public function getBasicAuthURL() : string
    {
        $site = user()->site;

        if(empty($site)){
           throw new \Exception("Sorry! You don't have any site yet.");
        }

        if(!$this->isSiteActive($site->is_active)){
            throw new \Exception("Sorry! Your site is not active yet.");
        }

        return $site->url;
    }

    public function getBasicAuthUser() : string
    {
        $site = user()->site;

        if(empty($site)){
           throw new \Exception("Sorry! You don't have any site yet.");
        }

        if(!$this->isSiteActive($site->is_active)){
            throw new \Exception("Sorry! Your site is not active yet.");
        }

        return $site->user_name;
    }


    public function getBasicAuthPassword()
    {
        $site = user()->site;

        if(empty($site)){
           throw new \Exception("Sorry! You don't have any site yet.");
        }

        if(!$this->isSiteActive($site->is_active)){
            throw new \Exception("Sorry! Your site is not active yet.");
        }

        return $site->password;
    }

    public function isSiteActive($value)
    {
        return $value == appStatic()::ACTIVE;
    }


    public function syncOptions()
    {
        return [
            "Categories",
            "Tags",
            "Users",
            "Posts"
        ];
    }

    public function storeUpdateTags(array $tags)
    {

    }
}
