<?php

namespace App\Http\Controllers\Admin\Voice2Text;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Integration\IntegrationService;

class Voice2TextInputController extends Controller
{
    public function recordVoiceToText(Request $request)
    {
        $result = (new IntegrationService())->audio2TextGenerator(appStatic()::ENGINE_OPEN_AI, $request);
        return response()->json($result);
    }
}
