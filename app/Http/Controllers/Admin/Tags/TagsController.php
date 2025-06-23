<?php

namespace App\Http\Controllers\Admin\Tags;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Resources\TagResource;
use App\Http\Controllers\Controller;
use App\Traits\Api\ApiResponseTrait;
use App\Services\Model\Tag\TagsService;
use App\Http\Requests\Admin\Tag\TagRequestForm;
use Modules\WordpressBlog\Services\Tags\WpTagService;

class TagsController extends Controller
{
    use ApiResponseTrait;
    protected $appStatic;
    protected $tagsService;
    public function __construct()
    {
        $this->tagsService = new TagsService();
        $this->appStatic = appStatic();
    }
    public function index(Request $request)
    {
        $data = $this->tagsService->index();
       
        if ($request->ajax()) {
            return view('backend.admin.tags.tag-lists', $data)->render();
        }

        return view("backend.admin.tags.index")->with($data);
    }
    public function store(TagRequestForm $request)
    {
        try {
            $tag = $this->tagsService->store($request->getData());

            return $this->sendResponse(
                $this->appStatic::SUCCESS_WITH_DATA,
                localize("Successfully stored Tag"),
                TagResource::make($tag)
            );
        } catch (\Throwable $e) {

            wLog("Failed to Store Tag", errorArray($e));

            return $this->sendResponse(
                $this->appStatic::VALIDATION_ERROR,
                localize("Failed to store Tag"),
                [],
                errorArray($e)
            );
        }
    }
    public function edit(Tag $tag)
    {
        return $this->sendResponse(
            $this->appStatic::SUCCESS_WITH_DATA,
            localize("Successfully retrieved Tag"),
            $tag
        );
    }

    public function show(Request $request, $id)
    {
       
    }

    public function update(TagRequestForm $request, Tag $tag)
    {
        $data = $this->tagsService->update($tag, $request->getData());
        return $this->sendResponse(
            $this->appStatic::SUCCESS_WITH_DATA,
            localize("Successfully Tag Updated"),
            TagResource::make($data)
        );
    }
    public function destroy(Request $request, Tag $tag)
    {
        try {
            if(isModuleActive('WordpressBlog') && $tag->wp_id) {
                (new WpTagService())->delete($tag->wp_id);
            }
            if ($request->ajax()) {
                return $this->sendResponse(
                    $this->appStatic::SUCCESS,
                    localize("Successfully deleted Tag"),
                    $tag->delete()
                );
            }
        } catch (\Throwable $e) {
            wLog("Failed to Delete Tag", errorArray($e));
            return $this->sendResponse(
                $this->appStatic::VALIDATION_ERROR,
                localize("Failed to Delete : ") . $e->getMessage(),
                [],
                errorArray($e)
            );
        }
    }
}

