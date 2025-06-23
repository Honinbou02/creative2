<?php

namespace Modules\WordpressBlog\App\Http\Controllers\Wp;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\TagResource;
use App\Http\Controllers\Controller;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Http\RedirectResponse;
use Modules\WordpressBlog\Services\Tags\WpTagService;

class WpTagController extends Controller
{
    use ApiResponseTrait;

    protected $appStatic;
    protected $wpTagService;
    public function __construct()
    {

        $this->appStatic    = appStatic();
        $this->wpTagService = new WpTagService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = $this->wpTagService->getAll();
        return $tags;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('wordpressblog::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('wordpressblog::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('wordpressblog::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
    public function syncAllTags()
    {
        try {
            $tag = $this->wpTagService->syncTags();

            return $this->sendResponse(
                $this->appStatic::SUCCESS_WITH_DATA,
                "Successfully stored Tag",
                TagResource::make($tag)
            );
        } catch (\Throwable $e) {

            wLog("Failed to Store Tag", errorArray($e));

            return $this->sendResponse(
                $this->appStatic::VALIDATION_ERROR,
                "Failed to store Tag",
                [],
                errorArray($e)
            );
        }
    }
}
