<?php

namespace App\Http\Controllers\Admin\NewsLetter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Api\ApiResponseTrait;
use App\Services\Model\NewsLetter\NewsLetterService;

class NewslettersController extends Controller
{
    use ApiResponseTrait;
    protected $appStatic;
    protected $newsLetterService;
    public function  __construct()
    {
        $this->appStatic = appStatic();
        $this->newsLetterService = new NewsLetterService();
    }
    public function index()
    {
        $data = $this->newsLetterService->index();
        return view('backend.admin.NewsLetter.index', $data);
    }
    public function sendNewsletter(Request $request)
    {
        try {
            $message = $this->newsLetterService->send($request);        
            return $this->sendResponse(
                $this->appStatic::SUCCESS_WITH_DATA,
                $message,              
            );
        } catch (\Throwable $e) {

            wLog("Failed to send message", errorArray($e));
            return $this->sendResponse(
                $this->appStatic::VALIDATION_ERROR,
                localize("Failed to send message"),
                [],
                errorArray($e)
            );
        }
    }
    public function subscribers()
    {
        
    }
}
