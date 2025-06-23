<?php

namespace App\Http\Controllers\Admin\Affiliate;

use App\Http\Controllers\Controller;
use App\Services\Model\Affiliate\AffiliateService;

class AffiliatePaymentsController extends Controller
{
    protected $affiliateService;
    public function __construct()
    {
        $this->affiliateService = new AffiliateService();
    }
    public function index()
    {
        $data = $this->affiliateService->paymentHistories();

        return view('backend.admin.affiliate.paymentHistories', $data);
    }
}
