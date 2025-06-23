<?php

namespace App\Http\Controllers\Admin\Affiliate;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Model\Affiliate\AffiliateService;

class AffiliateOverviewController extends Controller
{
    protected $affiliateService;
    public function __construct()
    {
        $this->affiliateService = new AffiliateService();
    }
    public function index(Request $request)
    {
        $data = $this->affiliateService->overview($request);


        return view('backend.admin.affiliate.overview', $data);
    }
}
