<?php

namespace Modules\WordpressBlog\App\Services\Action;

use Modules\WordpressBlog\App\Services\Business\WpUserService;

class WpUserActionService
{

    private $wpUserService;

    public function __construct()
    {
        $this->wpUserService = new WpUserService();
    }

    public function syncWpUsersByUser(object $user)
    {
        $wpUsers = $this->wpUserService->getWpUsers($user);

        // Store or Update WpAuthor.php
        $wpAuthorsArr = $this->wpUserService->prepareWpAuthorsArr($wpUsers, $user);

        return $this->wpUserService->updateOrCreateWpUsers($wpAuthorsArr, $user);
    }

    public function getWpUsersByUser(object $user)
    {
        return $this->wpUserService->getWpUsersByUser($user);
    }

    public function getWpAuthorList($conditions = [], $options = [])
    {
        return $this->wpUserService->getWpAuthorList($conditions, $options);
    }

    public function getLastSyncTime(object $user)
    {
        return $this->wpUserService->getLastSyncTime($user);
    }
}