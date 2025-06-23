<?php

namespace App\Http\Controllers\Admin\Folder;

use App\Models\Folder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Api\ApiResponseTrait;
use App\Services\Model\Folder\FolderService;
use App\Http\Resources\Admin\Folder\FolderResource;
use App\Http\Requests\Admin\Folder\StoreFolderRequestForm;
use App\Http\Requests\Admin\Folder\MoveToFolderRequestForm;

class FolderController extends Controller
{
    use ApiResponseTrait;
    protected $appStatic;
    protected $folderService;
    public function __construct()
    {
        $this->folderService = new FolderService();
        $this->appStatic = appStatic();
    }
    public function index(Request $request)
    {
        $data["folders"] = $this->folderService->getAll(true, null);
       
        if ($request->ajax()) {
            return view('backend.admin.folders.folder-list', $data)->render();
        }
        return view("backend.admin.folders.index")->with($data);
    }
    public function store(StoreFolderRequestForm $request)
    {
        try {
            $folder = $this->folderService->store($request->getData());
            return $this->sendResponse(
                $this->appStatic::SUCCESS_WITH_DATA,
                localize("Successfully stored Folder"),
                FolderResource::make($folder)
            );
        } catch (\Throwable $e) {
            wLog("Failed to Store Folder", errorArray($e));
            return $this->sendResponse(
                $this->appStatic::VALIDATION_ERROR,
                localize("Failed to store Folder"),
                [],
                errorArray($e)
            );
        }
    }
    public function edit(Folder $folder)
    {
        return $this->sendResponse(
            $this->appStatic::SUCCESS_WITH_DATA,
            localize("Successfully retrieved Folder"),
            $folder
        );
    }



    public function update(StoreFolderRequestForm $request, Folder $folder)
    {
        $data = $this->folderService->update($folder, $request->getData());
        return $this->sendResponse(
            $this->appStatic::SUCCESS_WITH_DATA,
            localize("Successfully Folder Updated"),
            FolderResource::make($data)
        );
    }

    public function destroy(Request $request, Folder $folder)
    {
        try {
            if ($request->ajax()) {
                return $this->sendResponse(
                    $this->appStatic::SUCCESS,
                    localize("Successfully deleted Folder"),
                    $folder->delete()
                );
            }
        } catch (\Throwable $e) {
            wLog("Failed to Delete Folder", errorArray($e));
            return $this->sendResponse(
                $this->appStatic::VALIDATION_ERROR,
                localize("Failed to delete the folder"),
                [],
                errorArray($e)
            );
        }
    }
    public function moveToFolderContent(MoveToFolderRequestForm $request)
    {
      
        $data = $this->folderService->moveToFolderContent($request->validated());
        return view('common.move-to-folder-content', $data);
    }
    public function moveToFolder(Request $request)
    {
      
        try {
           $data = $this->folderService->moveToFolder($request->all());
            if ($request->ajax()) {
                return $this->sendResponse(
                    $this->appStatic::SUCCESS,
                    localize("Successfully Moved to Folder"),
                );
            }
        } catch (\Throwable $e) {
            wLog("Failed to Delete Folder", errorArray($e));
            return $this->sendResponse(
                $this->appStatic::VALIDATION_ERROR,
                localize("Failed Move to Folder"),
                [],
                errorArray($e)
            );
        }
    }
}
