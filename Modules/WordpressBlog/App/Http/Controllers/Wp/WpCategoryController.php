<?php

namespace Modules\WordpressBlog\App\Http\Controllers\Wp;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Blog\BlogCategoryResource;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Http\RedirectResponse;
use Modules\WordpressBlog\Services\Categories\WpCategoryService;

class WpCategoryController extends Controller
{
    use ApiResponseTrait;

    protected $appStatic;
    protected $wpCategoryService;
    public function __construct()
    {

        $this->appStatic    = appStatic();
        $this->wpCategoryService = new WpCategoryService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = $this->wpCategoryService->getAll();
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
    public function syncAllCategories()
    {
        try {
            $tag = $this->wpCategoryService->syncCategories();

            return $this->sendResponse(
                $this->appStatic::SUCCESS_WITH_DATA,
                "Successfully Sync Category",
                BlogCategoryResource::make($tag)
            );
        } catch (\Throwable $e) {

            wLog("Failed to Sync Category", errorArray($e));

            return $this->sendResponse(
                $this->appStatic::VALIDATION_ERROR,
                "Failed to Sync Category",
                [],
                errorArray($e)
            );
        }
    }
}

