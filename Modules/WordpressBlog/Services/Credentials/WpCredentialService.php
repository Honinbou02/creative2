<?php

namespace Modules\WordpressBlog\Services\Credentials;

use App\Services\WpBasicAuthService;
use Modules\WordpressBlog\App\Models\UserSite;



class WpCredentialService
{

    public function index()
    {
        $data['credential'] = $this->userCredential();
        $data["urlExample"] = (new WpBasicAuthService())::URL_EXAMPLE;
        return $data;
    }
    public function getAll($isPaginateGetOrPluck = null, $onlyActives = null, $withRelationships = ["updatedBy", "createdBy"])
    {
        $request = Request();
        $query = UserSite::query();

        // Bind Relationships
        (!empty($withRelationships) ? $query->with($withRelationships) : false);

        if ($request->has('is_active')) {
            $query->isActive(intval($request->is_active));
        }
        if (!is_null($onlyActives)) {
            $query->isActive($onlyActives);
        }

        if (is_null($isPaginateGetOrPluck)) {
            return $query->pluck("user", "id");
        }

        return $isPaginateGetOrPluck === 'get' ?  $query->get() : $query->paginate(maxPaginateNo());
    }

    public function findWpCredentialById($id, $withRelationships = [])
    {
        $query = UserSite::query();

        // Bind Relationships
        !empty($withRelationships) ? $query->with($withRelationships) : false;

        return $query->findOrFail($id);
    }

    public function store(array $payloads)
    {
        $model = $this->userCredential();
     
        if($model) {
            $model->update($payloads);
            return $model;
        }
        return UserSite::query()->create($payloads);
    }

    public function update(object $templateCategory, array $payloads): object
    {
        $templateCategory->update($payloads);
        return $templateCategory;
    }
    public function firstCredential()
    {
        return UserSite::first();
    }
    public function userCredential()
    {
        return UserSite::where('user_id', userID())->first();
    }
}
