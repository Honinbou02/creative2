<?php

namespace App\Http\Controllers\Admin\Video;

use Illuminate\Http\Request;
use App\Models\GeneratedImage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Services\Balance\BalanceService;
use App\Services\Integration\IntegrationService;
use App\Http\Requests\Admin\Video\SDImage2VideoRequest;
use App\Services\Model\GeneratedImage\GeneratedImageService;

class VideoController extends Controller
{
    use ApiResponseTrait;
    public function index(Request $request, GeneratedImageService $generatedImageService)
    {

        if($request->ajax()){
            $request["content_type"] = appStatic()::SD_IMAGE_2_VIDEO;
            $data['details'] = $generatedImageService->getAll(true);
            return view("backend.admin.videos.list", $data);
        }

        return view("backend.admin.videos.index");
    }

    public function sdImage2Video(SDImage2VideoRequest $request, IntegrationService $integrationService)
    {
        try{
            DB::beginTransaction();
            $request["title"] = "SD image to video generation";
            $request["content_purpose"] = appStatic()::SD_IMAGE_2_VIDEO;
            $generatedVideo = $integrationService->generateVideo(appStatic()::ENGINE_STABLE_DIFFUSION,$request);
           
            (new BalanceService())->updateVideoBalance(getUserObject(), 1);
            DB::commit();
            $message = isset($generatedVideo->errors[0])  ? $generatedVideo->errors[0] : localize("Video Generation has started");

            return $this->sendResponse(
              appStatic()::SUCCESS_WITH_DATA,
              $message,
              $generatedVideo
            );
        }
        catch(\Throwable $e){
            DB::rollBack();
            wLog("Stable Diffusion failed to generate Video", errorArray($e));

            return $this->sendResponse(
                appStatic()::VALIDATION_ERROR,
                $e->getMessage(),
                [],
                errorArray($e)
            );
        }
    }
    public function downloadVideo(Request $request, $id)
    {
        $video = GeneratedImage::where('generated_image_path', $id)->first();
        if($video->file_path) {
            return response()->download(public_path($video->file_path));
        }
        $request['generationId'] = $id;
        $integrationService      = new IntegrationService();
        $generatedVideo          = $integrationService->prepareVideo(appStatic()::ENGINE_STABLE_DIFFUSION, $request);
        if($generatedVideo['fileUrl'] && $generatedVideo['response_code'] == 200){
            $video->file_path = $generatedVideo['fileUrl'];
            $video->save();
            return redirect()->back();
            return response()->download(public_path($generatedVideo['fileUrl']));
        }elseif($generatedVideo['response_code'] == 202){
            flash($generatedVideo['message']);
            return redirect()->route('admin.videos.index');
        }else{
            return redirect()->back();
        }
        return redirect()->back();
    }
}
