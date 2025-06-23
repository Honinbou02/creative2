<?php

use App\Models\Tag;
use Illuminate\Support\Facades\Cache;
use Modules\WordpressBlog\App\Models\UserSite;
use Modules\WordpressBlog\App\Models\WpCredential;
use Modules\WordpressBlog\App\Models\WpSetting;

const SYNC_CATEGORIES = 0;
const SYNC_TAGS       = 1;
const SYNC_USERS      = 2;
const SYNC_POSTS      = 3;

const WP_STATUS = [
    'publish' => 'Published - Publicly visible posts',
    'future'  => 'Scheduled - Posts set to be published in the future',
    'draft'   => 'Draft - Posts not published and visible only to the author or admins',
    'pending' => 'Pending - Posts awaiting review before publication',
    'private' => 'Private - Published but visible only to certain logged-in users'
];

if (!function_exists('wpSettings')) {
    # return system wpSettings value
    function wpSettings($key, $default = null)
    {
        try {
            $wpSettings = Cache::remember('wpSettings', 86400, function () {
                return WpSetting::all();
            });
            $setting = $wpSettings->where('entity', $key)->first();
            return is_null($setting) ? $default : $setting->value;
        } catch (\Throwable $th) {
            wLog("wpSettings Exception : " . $th->getMessage(), ["error" => errorArray($th)], \logService()::LOG_SYSTEM_SETTING);
            return $default;
        }
    }
}
if (!function_exists('getDomain')) {
    function getDomain($url) {
        // Parse the URL to get its components
        $parsedUrl = parse_url($url);
        // Reconstruct the URL using only the scheme and host
        $domain = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
        return $domain;
    }
}
if (!function_exists('wpSyncOptions')) {
    function wpSyncOptions() {
        return [
            "Categories",
            "Tags",
            "Users",
            "Posts"
        ];
    }
}
if (!function_exists('wpCredential')) {
    function wpCredential(): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder|array
    {

       return UserSite::query()->where('user_id', userID())->where('is_active', 1)->first() ?? [];
    }
}

