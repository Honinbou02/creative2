<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Api\ApiResponseTrait;
use App\Services\Model\Blog\BlogService;
use App\Http\Resources\Admin\Blog\BlogResource;
use App\Http\Requests\Admin\Blog\BlogRequestForm;

class BlogController extends Controller
{
    use ApiResponseTrait;
    protected $appStatic;
    protected $blogService;
    public function __construct()
    {
        $this->blogService = new BlogService();
        $this->appStatic = appStatic();
    }
    public function index(Request $request)
    {
        $data = $this->blogService->index();
        if ($request->ajax()) {
            return view('backend.admin.blogs.blog-list', $data)->render();
        }

        return view("backend.admin.blogs.index")->with($data);
    }
    public function store(BlogRequestForm $request)
    {
        try {
      
            $blog = $this->blogService->store($request->getData());

            return $this->sendResponse(
                $this->appStatic::SUCCESS_WITH_DATA,
                localize("Successfully stored blog"),
                BlogResource::make($blog)
            );
        } catch (\Throwable $e) {

            wLog("Failed to Store ", errorArray($e));

            return $this->sendResponse(
                $this->appStatic::VALIDATION_ERROR,
                localize("Failed to store blog"),
                [],
                errorArray($e)
            );
        }
    }
    public function edit(Blog $blog)
    {
        $blogTags = $blog->tags()->pluck('tag_id');
        return $this->sendResponse(
            $this->appStatic::SUCCESS_WITH_DATA,
            localize("Successfully retrieved blog"),
            ['blog'=>$blog, 'blogTags'=>$blogTags]
        );
    }



    public function update(BlogRequestForm $request, Blog $blog)
    {
        $data = $this->blogService->update($blog, $request->getData());
        return $this->sendResponse(
            $this->appStatic::SUCCESS_WITH_DATA,
            localize("Successfully blog Updated"),
            BlogResource::make($data)
        );
    }

    public function destroy(Request $request, Blog $blog)
    {
        try {
            if ($request->ajax()) {
                return $this->sendResponse(
                    $this->appStatic::SUCCESS,
                    localize("Successfully deleted blog"),
                    $blog->delete()
                );
            }
        } catch (\Throwable $e) {
            wLog("Failed to Delete blog", errorArray($e));
            return $this->sendResponse(
                $this->appStatic::VALIDATION_ERROR,
                localize("Failed to delete the blog"),
                [],
                errorArray($e)
            );
        }
    }
}
