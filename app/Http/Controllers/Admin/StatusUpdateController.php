<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Status\StatusUpdateRequest;
use App\Services\Admin\Status\ActiveStatusService;
use App\Traits\Api\ApiResponseTrait;
use App\Traits\Global\AllModelNameTrait;
use App\Traits\UnHashed\UnHashedTrait;
use App\Utils\AppStatic;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Http\Resources\Admin\ActiveStatus\ActiveStatusResource;
class StatusUpdateController extends Controller
{
    use AllModelNameTrait;
    use UnHashedTrait;
    use ApiResponseTrait;

    public function updateActiveStatus(
        StatusUpdateRequest $request,
        AppStatic $appStatic,
        ActiveStatusService $activeStatusService
    )
    {
        try {
            $id    = $this->decryptId($request->id);  // Decrypting ID from Encrypted
            $model = $this->getModelName($request->model);  // Hashed Model name

            info("Request ID : " . $id);

            if(!empty($id && $model)){
                $modelRow = findById($model, $id);

                if(!isAdmin() && $modelRow->created_by_id !== user()->id) {
                    return $this->sendResponse(
                        $appStatic::UNAUTHORIZED,
                        $appStatic::MESSAGE_STATUS_WARNING,
                    );
                }
                
                // Active Status Service
                $activeStatusService->updateActiveStatus($modelRow);

                return $this->sendResponse(
                    $appStatic::SUCCESS_WITH_DATA,
                    $appStatic::MESSAGE_STATUS_UPDATE,
                    ActiveStatusResource::make($modelRow)
                );
            }

            return $this->sendResponse(
                $appStatic::VALIDATION_ERROR,
                localize("ID or Model Not Found Something Went wrong with incoming information"),
            );
        }
        catch (DecryptException $decryptException){
            // ID Decrypt Exception

            return $this->sendResponse(
                $appStatic::VALIDATION_ERROR,
                localize("Something Went wrong with incoming information"),
                [],
                errorArray($decryptException)
            );

        }
        catch (\Throwable $e){

            return $this->sendResponse(
                $appStatic::VALIDATION_ERROR,
                $e->getMessage(),
                [],
                errorArray($e)
            );
        }
    }
}
