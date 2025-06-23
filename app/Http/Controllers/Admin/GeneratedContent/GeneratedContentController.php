<?php

namespace App\Http\Controllers\Admin\GeneratedContent;

use Illuminate\Http\Request;
use App\Models\GeneratedContent;
use App\Http\Controllers\Controller;
use App\Services\Model\GeneratedContent\GeneratedContentService;
use App\Traits\Api\ApiResponseTrait;

class GeneratedContentController extends Controller
{
    use ApiResponseTrait;
    protected $appStatic;
    protected $generatedContentService;
    public function __construct()
    {
        $this->appStatic = appStatic();
        $this->generatedContentService = new GeneratedContentService();
    }
  
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $content = $this->generatedContentService->findById($id);

        return view('backend.admin.generatedContent.show', compact('content'));
    }

    public function update(Request $request)
    {
        $data = $this->generatedContentService->update($request);
        return $this->sendResponse(
            $this->appStatic::SUCCESS_WITH_DATA,
            "Successfully Tag Updated",
           
        );
    }

}
