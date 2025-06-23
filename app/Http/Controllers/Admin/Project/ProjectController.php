<?php

namespace App\Http\Controllers\Admin\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Folder;
use App\Services\Model\Folder\FolderService;
use App\Services\Model\GeneratedContent\GeneratedContentService;
use App\Services\Model\Project\ProjectService;
use App\Traits\Api\ApiResponseTrait;

class ProjectController extends Controller
{
    use ApiResponseTrait;
    protected $projectService;

    public function __construct()
    {
        $this->projectService = new ProjectService();
    }

    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $data                 = $this->projectService->index();
        if ($request->ajax()) {
           return $data['type'] == appStatic()::CONTENT_TYPE_IMAGE 
                ? view('backend.admin.projects._images', $data)->render() : view('backend.admin.projects._contents', $data)->render();
        }
        return view('backend.admin.projects.index', $data);
    }
    
    # move to folder modal open
    public function moveToFolderModalOpen(Request $request)
    {
        $content = (new GeneratedContentService())->findById((int)$request->id);
        $folders = (new FolderService())->getAll();

        return view('common.sidebar.move-to-folder-form-content', compact('content', 'folders'))->render();
    }

    # move to folder  
    public function moveToFolder(Request $request)
    {
        $data = (new GeneratedContentService())->moveToFolder($request);
        return $this->sendResponse(appStatic()::SUCCESS_WITH_DATA,
            localize("Successfully moved to a folder"),
        );
    }
   
}
