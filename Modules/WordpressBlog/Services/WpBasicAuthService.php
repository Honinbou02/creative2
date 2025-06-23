<?php

namespace Modules\WordpressBlog\Services;

use App\Services\Curl\CurlService;
use Illuminate\Support\Facades\Http;
use phpDocumentor\Reflection\Types\Self_;

class WpBasicAuthService extends CurlService
{
    public function connectWp()
    {
        $credentials = $this->getCredentials();
        return $this->handle(
            self::URL_PROFILE(),
            null,
            1,
            'GET',
            "{$credentials[0]}:{$credentials[1]}"
        )["body"];
    }
    public function getCredentials()
    {
        return [
            wpCredential()->user_name,
            wpCredential()->password
        ];
    }
    // posts 
    public function getPosts()
    {
        $credentials = $this->getCredentials();
        $queryString = request()->getQueryString();

        return $this->handle(
            self::URL_POST() . "?{$queryString}",
            null,
            1,
            'GET',
            "{$credentials[0]}:{$credentials[1]}"
        )["body"];
    }
    public function uploadAPost(array $payloads)
    {
        $credentials = $this->getCredentials();

        $postEndpoint = request()->has("push_post_type") && (int) request()->push_post_type == 1 ? self::URL_UPDATE_POST(request()->wp_post_id) : self::URL_POST();

        $curlResponse = $this->handle(
            $postEndpoint,
            $payloads,
            1,
            'POST',
            "{$credentials[0]}:{$credentials[1]}"
        )["body"];

        if(isset($curlResponse->code) && $curlResponse->code == "rest_invalid_param") {
            throw new \Exception($curlResponse->message, $curlResponse->data?->status ?: 400);
        }

        return $curlResponse;
    }
    public function showPost(int $postId)
    {
        $credentials = $this->getCredentials();
        return $this->handle(
            self::URL_POST() . "/{$postId}",
            null,
            1,
            'GET',
            "{$credentials[0]}:{$credentials[1]}"
        )["body"];
    }
    public function deletePost(int $postId)
    {
        $credentials = $this->getCredentials();
        return $this->handle(
            self::URL_POST() . "/{$postId}",
            null,
            1,
            'DELETE',
            "{$credentials[0]}:{$credentials[1]}"
        )["body"];
    }
    public function updatePost(array $payloads, int $postId)
    {
        $credentials = $this->getCredentials();

        return $this->handle(
            self::URL_POST() . "/{$postId}",
            $payloads,
            1,
            'POST',
            "{$credentials[0]}:{$credentials[1]}"
        )["body"];
    }



    public function searchPosts($searchingKeyword)
    {
        $credentials = $this->getCredentials();


        $response = Http::withBasicAuth($credentials[0], $credentials[1])
            ->timeout(0)
            ->get(self::URL_POST() . '?search=' . $searchingKeyword);

        if($response->failed()) {
            throw new \RuntimeException($response->body(), $response->status());
        }


        return $response->json();
    }

    public function storeUpdateTags(array $tags)
    {
        $credentials = $this->getCredentials();
        $queryString = request()->getQueryString();

        return $this->handle(
            self::URL_TAGS() . "?{$queryString}",
            null,
            1,
            'POST',
            "{$credentials[0]}:{$credentials[1]}"
        )["body"];
    }
    // tags
    public function getTags()
    {
        $credentials = $this->getCredentials();
        $queryString = request()->getQueryString();

        return $this->handle(
            self::URL_TAGS() . "?{$queryString}",
            null,
            1,
            'GET',
            "{$credentials[0]}:{$credentials[1]}"
        )["body"];
    }
    public function storeTag(array $payloads)
    {
        $credentials = $this->getCredentials();
        $queryString = request()->getQueryString();

        return $this->handle(
            self::URL_TAGS() . "?{$queryString}",
            $payloads,
            1,
            'POST',
            "{$credentials[0]}:{$credentials[1]}"
        )["body"];
    }
    public function updateTag(array $payloads, $id)
    {
        $credentials = $this->getCredentials();
        return $this->handle(
            self::URL_TAGS() . "/$id",
            $payloads,
            1,
            'POST',
            "{$credentials[0]}:{$credentials[1]}"
        )["body"];
    }
    public function findTag($id)
    {
        $credentials = $this->getCredentials();
        return $this->handle(
            self::URL_TAGS() . "/$id",
            null,
            1,
            'GET',
            "{$credentials[0]}:{$credentials[1]}"
        )["body"];
    }
    public function deleteTag($id)
    {
        $credentials = $this->getCredentials();
        return $this->handle(
            self::URL_TAGS() . "/$id",
            null,
            1,
            "DELETE",
            "{$credentials[0]}:{$credentials[1]}"
        )["body"];
    }
    // categories
    public function getCategories()
    {
        $credentials = $this->getCredentials();
        $queryString = request()->getQueryString();

        return $this->handle(
            self::URL_CATEGORIES() . "?{$queryString}",
            null,
            1,
            'GET',
            "{$credentials[0]}:{$credentials[1]}"
        )["body"];
    }
    public function storeCategory(array $payloads)
    {
        $credentials = $this->getCredentials();
        $queryString = request()->getQueryString();
      
        return $this->handle(
            self::URL_CATEGORIES(),
            $payloads,
            1,
            'POST',
            "{$credentials[0]}:{$credentials[1]}"
        )["body"];
    }
    public function updateCategory(array $payloads, $id)
    {
        $credentials = $this->getCredentials();
        return $this->handle(
            self::URL_CATEGORIES() . "/$id",
            $payloads,
            1,
            'POST',
            "{$credentials[0]}:{$credentials[1]}"
        )["body"];
    }
    public function findCategory($id)
    {
        $credentials = $this->getCredentials();
        return $this->handle(
            self::URL_CATEGORIES() . "/$id",
            null,
            1,
            'GET',
            "{$credentials[0]}:{$credentials[1]}"
        )["body"];
    }
    public function deleteCategory($id)
    {
        $credentials = $this->getCredentials();
        return $this->handle(
            self::URL_CATEGORIES() . "/$id",
            null,
            1,
            "DELETE",
            "{$credentials[0]}:{$credentials[1]}"
        )["body"];
    }
    //  wp users
    public function getUsers()
    {
        $credentials = $this->getCredentials();
        $queryString = request()->getQueryString();

        $authors = $this->handle(
            self::URL_USERS() . "?{$queryString}",
            null,
            1,
            'GET',
            "{$credentials[0]}:{$credentials[1]}"
        )["body"];

        if(is_object($authors)) {
            if($authors->data->status == appStatic()::NOT_FOUND) {

                throw new \Exception(localize("Authors not found")." - ".$authors->message, appStatic()::NOT_FOUND);
            }
        }

        return $authors;
    }
    public static function BASE_URL()
    {
        $wpCredential = wpCredential();

        if(empty($wpCredential)) {
            throw new \Exception(localize("WordPress credentials not found"), appStatic()::NOT_FOUND);
        }

       $wpURL      = wpCredential()->url; // ."/wp-json/wp/v2/";
       $urlExplode = explode("/wp-json/wp/v2", $wpURL);

       // Does contain wp-json/wp/v2
       if(count($urlExplode) > 1) {
           $wpURL = $urlExplode[0] . "/wp-json/wp/v2";
       }else{
           // Not Found wp-json/wp/v2
           $wpURL .= "/wp-json/wp/v2";
       }

       // v2/ contains or not
       $v2Explode = explode("v2", $wpURL);

       if(count($v2Explode) > 1) {
           $wpURL .= "/";
       }else{
           $wpURL .= "/v2/";
       }

       return $wpURL;
    }
    public static function URL_PROFILE()
    {
       return self::BASE_URL() . "users/me";
    }
    public static function URL_POST()
    {
       return self::BASE_URL() . "posts";
    }

    public static function URL_UPDATE_POST($postId)
    {
       return self::URL_POST() . "/{$postId}";
    }
    public static function URL_TAGS()
    {
       return self::BASE_URL() . "tags";
    }
    public static function URL_USERS()
    {
       return self::BASE_URL() . "users";
    }
    public static function URL_CATEGORIES()
    {
       return self::BASE_URL() . "categories";
    }

    /**
     * @throws \Exception
     */
    public static function URL_MEDIA()
    {
        return self::BASE_URL() . "media";
    }

    public function getMediaByMediaId($mediaId)
    {
        $credentials = $this->getCredentials();

        return $this->handle(
            self::URL_MEDIA() . "/{$mediaId}",
            null,
            1,
            'GET',
            "{$credentials[0]}:{$credentials[1]}"
        )["body"];
    }


}
