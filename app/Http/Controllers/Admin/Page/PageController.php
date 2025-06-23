<?php

namespace App\Http\Controllers\Admin\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\Traits\Api\ApiResponseTrait;
use App\Http\Requests\Admin\Page\PageRequestForm;
use App\Models\Page;
use App\Services\Model\Page\PageService;

class PageController extends Controller
{
    use ApiResponseTrait;
    protected $appStatic;
    protected $pageService;
    public function __construct()
    {
        $this->pageService = new PageService();
        $this->appStatic = appStatic();
    }
    public function index(Request $request)
    {
        $data["pages"] = $this->pageService->getAll(true, null);
       
        if ($request->ajax()) {
            return view('backend.admin.pages.page-lists', $data)->render();
        }
        return view("backend.admin.pages.index")->with($data);
    }
    public function store(PageRequestForm $request)
    {
        try {
            $page = $this->pageService->store($request->getData());

            return $this->sendResponse(
                $this->appStatic::SUCCESS_WITH_DATA,
                localize("Successfully stored Page"),
                PageResource::make($page)
            );
        } catch (\Throwable $e) {

            wLog("Failed to Store Page", errorArray($e));

            return $this->sendResponse(
                $this->appStatic::VALIDATION_ERROR,
                localize("Failed to store Page"),
                [],
                errorArray($e)
            );
        }
    }
    public function edit(Page $page)
    {
        return $this->sendResponse(
            $this->appStatic::SUCCESS_WITH_DATA,
            localize("Successfully retrieved Page"),
            $page
        );
    }


    public function update(PageRequestForm $request, Page $page)
    {
        $data = $this->pageService->update($page, $request->getData());
        return $this->sendResponse(
            $this->appStatic::SUCCESS_WITH_DATA,
            localize("Successfully Page Updated"),
            PageResource::make($data)
        );
    }
    public function destroy(Request $request, Page $page)
    {
        try {
            if ($request->ajax()) {
                return $this->sendResponse(
                    $this->appStatic::SUCCESS,
                    localize("Successfully deleted Page"),
                    $page->delete()
                );
            }
        } catch (\Throwable $e) {
            wLog("Failed to Delete Page", errorArray($e));
            return $this->sendResponse(
                $this->appStatic::VALIDATION_ERROR,
                localize("Failed to Delete : ") . $e->getMessage(),
                [],
                errorArray($e)
            );
        }
    }
}

