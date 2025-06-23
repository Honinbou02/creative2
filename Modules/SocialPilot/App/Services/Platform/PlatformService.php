<?php

namespace Modules\SocialPilot\App\Services\Platform;

use Modules\SocialPilot\App\Models\Platform;

class PlatformService
{
    public function index($getAll = false)
    {
        $request         = request();
        $platforms       = Platform::query();
        
        if(isCustomerUserGroup() || $request->onlyActives){
            $platforms  = $platforms->isActive();
        }

        if($request->has('search')){
            $platforms->where('name', 'like', '%'.$request->search.'%');
        }
        
        if ($getAll) {
            $platforms       = $platforms->get();
        }else{
            $platforms       = $platforms->paginate(maxPaginateNo());
        }
        $data['details'] = $platforms;
        return $data;
    } 

    public function findById($id)
    {
        return Platform::findOrFail((int) $id);
    }

    public function findBySlug($slug)
    {
        return Platform::whereSlug($slug)->first();
    }

    public function findByIds($ids)
    {
        return Platform::whereIn('id', $ids)->get();
    }
    
    public function storeCredentials($request)
    {
        $platform                      = $this->findById((int) $request->id);
        $platform->credentials         = $request->credentials;
        $platform->save();
        return $platform;
    }

    public function update($request)
    {
        $request = request();
        $platform                           = $this->findById((int) $request->id);
        $platform->icon_media_manager_id    = $request->icon_media_manager_id;
        $platform->save();
        return $platform;
    }
}
