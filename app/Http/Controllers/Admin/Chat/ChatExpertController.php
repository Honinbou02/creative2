<?php

namespace App\Http\Controllers\Admin\Chat;

use App\Models\ChatExpert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Api\ApiResponseTrait;
use App\Services\Model\ChatExpert\ChatExpertService;
use App\Http\Requests\Admin\ChatExpert\ChatExpertRequest;

class ChatExpertController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(ChatExpertService $chatExpertService, Request $request)
    {
        $data["list"] = $chatExpertService->all();

        if($request->route()->getPrefix() === 'api') {
            return response()->json($data);
        }

        if($request->ajax()){
            return view('backend.admin.chat-experts.expert-list', $data)->render();
        }

        return view('backend.admin.chat-experts.index', $data)->render();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ChatExpertRequest $chatExpertRequest, ChatExpertService $chatExpertService)
    {
        $data   = $chatExpertRequest->getValidatedData();
        $result = $chatExpertService->store($data);

        return $this->sendResponse(appStatic()::SUCCESS, 'Successfully added the chat expert.', $result);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChatExpertService $chatExpertService, string $id)
    {
        $data = $chatExpertService->getChatExpertById($id, true);

        return $this->sendResponse(appStatic()::SUCCESS, '', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ChatExpertService $chatExpertService, ChatExpertRequest $chatExpertRequest, string $id)
    {
        try {
            $result = findById(new ChatExpert(), $id);
            $data   = $chatExpertRequest->getValidatedData($id);
            $result = $chatExpertService->update($result, $data);

            return $this->sendResponse(appStatic()::SUCCESS, 'Successfully updated the information.', $result);

        } catch(\Exception $err) {
            return $this->sendResponse(appStatic()::VALIDATION_ERROR, 'There is an error during updating the information.', [], errorArray($err));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
    }
}
