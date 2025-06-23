<?php

namespace App\Http\Controllers;

use App\Services\FrontendService;
use App\Services\Model\OfflinePaymentMethod\OfflinePaymentMethodService;
use App\Services\Model\SubscriptionPlan\SubscriptionPlanService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $frontendService;

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function __construct()
    {
        $this->frontendService = new FrontendService();
    }
    public function index()
    {
        $data               = $this->frontendService->index();
        $data["payments"]  = (new SubscriptionPlanService())->payments();
        $data["offlinePaymentMethods"]  = (new OfflinePaymentMethodService())->getAll(false, 1);


        return view('frontend.default.pages.home', $data);
    }

    public function listing()
    {

        return view('pages.listing.list');
    }

    public function templates(Request $request)
    {
        $data['templates'] = $this->frontendService->templates($request);
        return view('frontend.default.pages.inc.templates', $data)->render();
    }

    public function plans(Request $request)
    {
        $data['plans'] = $this->frontendService->plans($request);
        return view('frontend.default.pages.inc.plans', $data)->render();
    }

    public function blogs()
    {
        $data['blogs'] = $this->frontendService->blogs();
        $data['latestLimit'] = $this->frontendService->blogs();
        return view('frontend.default.pages.blogs', $data);
    }

    public function blog($slug)
    {
        $data['blog'] = $this->frontendService->blog($slug);
        return view('frontend.default.pages.blog-details', $data);
    }
}
