<?php

namespace Modules\WordpressBlog\Services\Settings;

use App\Traits\File\FileUploadTrait;
use Modules\WordpressBlog\App\Models\WpSetting;


class WpSettingService
{
    use FileUploadTrait;

    public function getAll($isPaginateGetOrPluck = null, $onlyActives = null, $withRelationships = ["updatedBy", "createdBy"])
    {
        $request = Request();
        $query = WpSetting::query();
      
        // Bind Relationships
        (!empty($withRelationships) ? $query->with($withRelationships) : false);

        if($request->has('is_active')) {
            $query->isActive(intval($request->is_active));
        }
        if(!is_null($onlyActives)){
            $query->isActive($onlyActives);
        }

        if (is_null($isPaginateGetOrPluck)) {
            return $query->pluck("user", "id");
        }

        return $isPaginateGetOrPluck === 'get' ?  $query->get() : $query->paginate(maxPaginateNo());
    }

    public function findWpSettingById($id, $withRelationships = [])
    {
        $query = WpSetting::query();

        // Bind Relationships
        !empty($withRelationships) ? $query->with($withRelationships) : false;

        return $query->findOrFail($id);
    }

    public function update(object $templateCategory, array $payloads)
    {
        $templateCategory->update($payloads);
        return $templateCategory;
    }
    public function wpSettingTabs()
    {
        $tabs = [
            'settings-tab'=>[
                'title' => 'Settings',
                'h1'    => 'Settings',
                'icon'  => 'settings'
            ],

        ];

        return collect($tabs);
    }
    public function store($request)
    {
      
        if(!empty($request->settings)) {
            foreach($request->settings as $key=>$value) {
               $this->storeOrUpdate($key, $value);
            }
        }
        if(!empty($request->env)) {
            
            foreach($request->env as $key=>$value) {
               $this->storeOrUpdate($key, $value);
               writeToEnvFile($key, $value);
            }
        }
        if($request->type == 'checkbox') {
            $this->storeOrUpdate($request->entity, $request->value);
        }
        // google tts
        if ($request->hasFile('file')) {
            $file     = $request->file;
            $path     = fileService()::DIR_FILE;
            $fileName = $file->getClientOriginalName();
            unlinkFile($path.'/'.$fileName);
            $filePath = $this->fileProcess($file, $path, false, null, null, true);
            $this->storeOrUpdate('google_tts_file_path', $filePath);
            $this->storeOrUpdate('google_tts_file_name', $fileName);
        }
        cacheClear();
    }
    private function storeOrUpdate($key, $value = null)
    {
        $value = gettype($value) == 'array' ? json_encode($value) : $value;
        WpSetting::updateOrCreate([
            'entity' => $key
        ], [
            'value'     => $value,
            'is_active' => 1,               
        ]);
    }
}
