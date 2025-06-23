<?php

namespace App\Http\Controllers\Admin\Affiliate;

use Illuminate\Http\Request;
use App\Models\AffiliateEarning;
use App\Http\Controllers\Controller;
use App\Services\Model\Affiliate\AffiliateService;

class EarningHistoriesController extends Controller
{
    protected $affiliateService;
    public function __construct()
    {
        $this->affiliateService = new AffiliateService();
    }
    public function index(Request $request)
    {
        $data = $this->affiliateService->earningHistories();
        return view('backend.admin.affiliate.earnings', $data);
    }
}
