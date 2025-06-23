<?php

namespace Modules\WordpressBlog\App\Http\Controllers\Wp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Http\RedirectResponse;
use Modules\WordpressBlog\App\Http\Requests\WpBlogPostRequestForm;
use Modules\WordpressBlog\Services\Posts\WpBlogPostPublishedService;

class WpBlogPostPublishedController extends Controller
{
    use ApiResponseTrait;
    protected $appStatic;
    protected $publishedBlogService;
    public function __construct()
    {
        $this->appStatic = appStatic();
        $this->publishedBlogService = new WpBlogPostPublishedService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->publishedBlogService->loadData();
        return view('wordpressblog::posts.render-post-data', $data);
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
    public function store(WpBlogPostRequestForm $request)
    {
        try {

            $article = $this->publishedBlogService->published($request->getData());

            return $this->sendResponse(
                $this->appStatic::SUCCESS_WITH_DATA,
                "Successfully Published Post",
                $article
            );
        } catch (\Throwable $e) {
            wLog("Failed to Published Post", errorArray($e));
            return $this->sendResponse(
                $this->appStatic::VALIDATION_ERROR,
                "Failed to Published Post",
                [],
                errorArray($e)
            );
        }
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
}
