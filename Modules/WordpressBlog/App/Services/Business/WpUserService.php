<?php

namespace Modules\WordpressBlog\App\Services\Business;

use App\Services\BaseService;
use App\Services\WpBasicAuthService;
use Modules\WordpressBlog\App\Models\WpAuthor;

class WpUserService extends BaseService
{

    public function getWpUsersByUser(object $user)
    {
        return WpAuthor::query()->filters()->where("user_id", $user->id)->paginate(maxPaginateNo());
    }

    public function getWpAuthorList($conditions = [], $options = [])
    {
        $query = WpAuthor::query()->filters();

        return $this->getData($query, $conditions, $options);
    }

    public function getLastSyncTime(object $user)
    {
        $lastSyncTime = WpAuthor::query()
            ->filters()
            ->where("user_id", $user->id)
            ->orderBy('updated_at', 'desc')
            ->first()
            ->updated_at ?? null;
        
            return $lastSyncTime;
    }

    public function getWpUsers()
    {
        return (new WpBasicAuthService())->getUsers();
    }

    public function prepareWpAuthorsArr($wpUsers, object $user)
    {
        $wpUsersArr = [];

        foreach ($wpUsers ?? [] as $wpUser) {

            $wpUsersArr[] = [
                "wp_user_id" => $wpUser->id,
                "name"         => $wpUser->name,
                "email"        => $wpUser->slug."@automail.com",
                "username"     => $wpUser->slug,
                "first_name"   => $wpUser->name,
                "last_name"    => $wpUser->name,
                "user_site_id" => $user->site?->id,
                "user_id"      => $user->id,
            ];
        }

        return $wpUsersArr;
    }

    public function updateOrCreateWpUsers(array $users, $user)
    {
        $authors = [];
        foreach ($users as $wpUser){
            $authors[] = WpAuthor::updateOrCreate(
                [
                    "user_id"      => $user->id,
                    "wp_user_id"   => $wpUser['wp_user_id'],
                    "user_site_id" => $wpUser['user_site_id'],
                    "username"     => $wpUser['username']
                ],
                $wpUser
            );
        }

        return $authors;
    }
}