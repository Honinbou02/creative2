<?php

namespace App\Http\Controllers\Admin\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Model\Reports\ReportService;

class ReportsController extends Controller
{
    protected $reportService;

    public function __construct()
    {
        $this->reportService = new ReportService();
    }
    # words reports 
    public function words(Request $request)
    {
        try {
            $data = $this->reportService->words();
            if ($request->ajax()) {
                return view('backend.admin.reports.render.words-list', $data)->render();
            }
            return view('backend.admin.reports.words', $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    # codes reports 
    public function codes(Request $request)
    {
        $data = $this->reportService->codes();
        if ($request->ajax()) {
            return view('backend.admin.reports.render.code-list', $data)->render();
        }
        return view('backend.admin.reports.codes', $data);
    }

    # images reports 
    public function images(Request $request)
    {
        $data = $this->reportService->images();
        if ($request->ajax()) {
            return view('backend.admin.reports.render.image-list', $data)->render();
        }
        return view('backend.admin.reports.images', $data);
    }

    # s2t reports 
    public function s2t(Request $request)
    {
        $data = $this->reportService->s2t();
        if ($request->ajax()) {
            return view('backend.admin.reports.render.s2t-list', $data)->render();
        }
        return view('backend.admin.reports.s2t', $data);
    }

    # most used templates reports 
    public function mostUsed(Request $request)
    {
        $data = $this->reportService->mostUsed();
        if ($request->ajax()) {
            return view('backend.admin.reports.render.template-used-list', $data)->render();
        }
        return view('backend.admin.reports.mostUsedTemplates', $data);
    }

    # subscriptions reports 
    public function subscriptions(Request $request)
    {
        $data = $this->reportService->subscriptions();
        if ($request->ajax()) {
            return view('backend.admin.reports.render.subscriptions-list', $data)->render();
        }
        return view('backend.admin.reports.subscriptions', $data);
    }
}
