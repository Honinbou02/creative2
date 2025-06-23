<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Api\ApiResponseTrait;
use App\Services\Model\Blog\BlogCategoryService;
use App\Http\Resources\Admin\Blog\BlogCategoryResource;
use App\Http\Requests\Admin\Blog\BlogCategoryRequestForm;
use Modules\WordpressBlog\Services\Categories\WpCategoryService;

class BlogCategoryController extends Controller
{
    use ApiResponseTrait;
    protected $appStatic;
    protected $blogCategoryService;
    public function __construct()
    {
        $this->blogCategoryService = new BlogCategoryService();
        $this->appStatic = appStatic();
    }
    public function index(Request $request)
    {
        $data = $this->blogCategoryService->index();
       
        if ($request->ajax()) {
            return view('backend.admin.blog-categories.blog-category-list', $data)->render();
        }

        return view("backend.admin.blog-categories.index")->with($data);
    }
    public function store(BlogCategoryRequestForm $request)
    {
        try {
            $blogCategory = $this->blogCategoryService->store($request->getData());

            return $this->sendResponse(
                $this->appStatic::SUCCESS_WITH_DATA,
                localize("Successfully stored Category"),
                BlogCategoryResource::make($blogCategory)
            );
        } catch (\Throwable $e) {

            wLog("Failed to Store Category", errorArray($e));

            return $this->sendResponse(
                $this->appStatic::VALIDATION_ERROR,
                localize("Failed to store blogCategory"),
                [],
                errorArray($e)
            );
        }
    }
    public function edit(BlogCategory $blogCategory)
    {
        return $this->sendResponse(
            $this->appStatic::SUCCESS_WITH_DATA,
            localize("Successfully retrieved Category"),
            $blogCategory
        );
    }



    public function update(BlogCategoryRequestForm $request, BlogCategory $blogCategory)
    {
        $data = $this->blogCategoryService->update($blogCategory, $request->getData());
        return $this->sendResponse(
            $this->appStatic::SUCCESS_WITH_DATA,
            localize("Successfully Category Updated"),
            BlogCategoryResource::make($data)
        );
    }

    public function destroy(Request $request, BlogCategory $blogCategory)
    {
        try {
            if(isModuleActive('WordpressBlog') && $blogCategory->wp_id) {
                (new WpCategoryService())->delete($blogCategory->id);
            }
            if ($request->ajax()) {
                return $this->sendResponse(
                    $this->appStatic::SUCCESS,
                    localize("Successfully deleted Category"),
                    $blogCategory->delete()
                );
            }
        } catch (\Throwable $e) {
            wLog("Failed to Delete blogCategory", errorArray($e));
            return $this->sendResponse(
                $this->appStatic::VALIDATION_ERROR,
                localize("Failed to delete the Category"),
                [],
                errorArray($e)
            );
        }
    }
}
