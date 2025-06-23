<?php
namespace App\Services\Model\Reports;

use App\Models\User;
use App\Models\Template;
use App\Services\Model\Template\TemplateService;
use App\Services\Model\User\UserService;
use Illuminate\Support\Str;
use App\Models\GeneratedImage;
use App\Models\GeneratedContent;
use App\Models\SubscriptionUser;
use App\Models\SubscriptionPlan;

class ReportService {
    public function words():array
    {
        $data = [];
        $request = request();

        $generatedContents = $this->getGeneratedContentsByUserAndTemplateId(
            $request->user_id,
            $request->template_id,
            ["sum_and_paginate" => true]
        );

        $userId = $this->getTempUserId();

        $data['totalWordsGenerated'] = $generatedContents['total_words'];
        $data['usage']               = $generatedContents["paginate_records"];
        $data['users']               = $this->users($userId);
        $data['user_id']             = $userId;
        $data['template_id']         = $request->template_id;
        $data['templates']           = Template::all();

        return $data;
    }


    public function getGeneratedContentsByUserAndTemplateId($userId = null, $templateId = null, $returnOptions = [])
    {
        if(empty($userId) && !isAdmin()) {
            $userId = userID();
        }

        $request = request();

        //TODO:: Refactor Required based on our standard
        $usage = GeneratedContent::latest()
            ->when(!empty($userId), function($q) use($userId){
                $q->where('user_id', $userId);
            })->when($templateId, function($q) use($templateId){
                $q->where('template_id', $templateId);
            });

        if (Str::contains($request->date_range, 'to') && !empty($request->date_range) ) {
            $date_var = explode(" to ", $request->date_range);
        } else {
            $date_var = [date("d-m-Y", strtotime('7 days ago')), date("d-m-Y", strtotime('today'))];
        }

        $start = date("Y-m-d", strtotime($date_var[0]));
        $end   = date("Y-m-d", strtotime($date_var[1]));

        $usage = $usage->whereDate('created_at', '>=', $start)
                 ->whereDate('created_at', '<=', $end);

        $data = [];

        if(isset($returnOptions["sum_and_paginate"]) && $returnOptions["sum_and_paginate"]) {
            $data['total_words']       = $usage->sum('total_words');
            $data['paginate_records']  = $usage->paginate(maxPaginateNo());
        }

        return $data;
    }

    public function getTempUserId()
    {
        $request = request();

        if($request->has("user_id") && !empty($request->user_id)){
            return $request->user_id; //TODO::When logged in user is not Admin, We must verify the user_id is belongs to the logged in user parent or not. Will implement Later.
        }

        if(!isAdmin()){
            return getUserParentId();
        }

        return null;
    }

    public function codes():array
    {
        $data = [];
        $request = request();

        $userId = $this->getTempUserId();

        $usage = GeneratedContent::latest()->where('content_type', 'code')->when($userId, function($q) use($userId){
            $q->where('user_id', $userId);
        });

        # conditional   
        if (Str::contains($request->date_range, 'to') && $request->date_range != null) {
            $date_var = explode(" to ", $request->date_range);
        } else {
            $date_var = [date("d-m-Y", strtotime('7 days ago')), date("d-m-Y", strtotime('today'))];
        }

        $usage = $usage->where('created_at', '>=', date("Y-m-d", strtotime($date_var[0])))->where('created_at', '<=',  date("Y-m-d", strtotime($date_var[1]) + 86400000));

        $data['totalWordsGenerated'] = $usage->count();
        $data['usage']               = $usage->paginate(maxPaginateNo());
        $data['user_id']             = $userId;
        $data['users']               = $this->users();

        return $data;
    }

    public function s2t():array
    {
        $data = [];
        $request = request();

        $userId = $this->getTempUserId();

        $usage = GeneratedContent::query()
            ->latest()
            ->where('content_type', 'speech_to_text')
            ->when($userId, function($q) use($userId){
                $q->where('user_id', $userId);
            });

        # conditional   
        if (Str::contains($request->date_range, 'to') && $request->date_range != null) {
            $date_var = explode(" to ", $request->date_range);
        } else {
            $date_var = [date("d-m-Y", strtotime('7 days ago')), date("d-m-Y", strtotime('today'))];
        }

        $usage = $usage->where('created_at', '>=', date("Y-m-d", strtotime($date_var[0])))->where('created_at', '<=',  date("Y-m-d", strtotime($date_var[1]) + 86400000));

        $data['totalWordsGenerated'] = $usage->count();
        $data['usage']               = $usage->paginate(maxPaginateNo());
        $data['user_id']             = $userId;
        $data['users']               = $this->users();

        return $data;
    }

    public function images()
    {
        $data = [];
        $request = request();

        $userId = $this->getTempUserId();

        $usage = GeneratedImage::query()
        ->latest()
        ->when($userId, function($q) use($userId){
            $q->where('user_id', $userId);
        })->when($request->platform, function($q) use($request){
            $q->where('platform', $request->platform);
        });

        # conditional
        if (Str::contains($request->date_range, 'to') && $request->date_range != null) {
            $date_var = explode(" to ", $request->date_range);
        } else {
            $date_var = [date("d-m-Y", strtotime('7 days ago')), date("d-m-Y", strtotime('today'))];
        }

        $usage = $usage->where('created_at', '>=', date("Y-m-d", strtotime($date_var[0])))->where('created_at', '<=',  date("Y-m-d", strtotime($date_var[1]) + 86400000));

        $data['totalWordsGenerated'] = $usage->count();
        $data['usage']               = $usage->paginate(maxPaginateNo());
        $data['user_id']             = $request->user_id;
        $data['users']               = $this->users();
        $data['platform']            = $request->platform;
        $data['platforms']           = [appStatic()::ENGINE_OPEN_AI, appStatic()::ENGINE_STABLE_DIFFUSION];

        return $data;
    }

    public function mostUsed()
    {

        $data = [];
        $request = request();
        $searchKey  = null;
        $order = 'DESC';

        if ($request->order == "ASC") {
            $order = 'ASC';
        }

        $templateCategoryId = $request->template_category_id == 'all' ?  null : $request->template_category_id;

        $templateIds        = (new TemplateService())->userPlanTemplateIds();

        //TODO:: Refactor Required based on our standard
        $usage = Template::query()->when(isCustomer(), function($q) use($templateIds){
            $q->whereIn('id', $templateIds)->orWhere('created_by_id', userID());
        })->orderBy('total_words_generated', $order);

        if ($request->search != null) {
            $usage      = $usage->where('name', 'like', '%' . $request->search . '%');
            $searchKey  = $request->search;
        }

        $data['totalWordsGenerated'] = $usage->count();
        $data['usage']               = $usage->paginate(maxPaginateNo(30));
        return $data;
    }
    public function subscriptions()
    {
        $data = [];
        $request = request();
        $searchKey = null;

        $userId = $this->getTempUserId();

        //TODO:: Refactor Required based on our standard
        $histories = SubscriptionUser::latest()->when($userId, function($q) use($userId){
            $q->where('user_id', $userId);
        })->when($request->package_id, function($q) use($request){
            $q->where('subscription_plan_id', $request->package_id);
        });

        if ($request->search != null) {

            $userIds = User::query()->when(!isAdmin(), function ($q) use($request){
                $q->where('parent_user_id', userID());
            })->where('name', 'like', '%' . $request->search . '%')->pluck('id');

            $histories = $histories->whereIn('user_id', $userIds);

            $searchKey = $request->search;
        }

        # conditional   
        if (Str::contains($request->date_range, 'to') && $request->date_range != null) {
            $date_var = explode(" to ", $request->date_range);
        } else {
            $date_var = [date("d-m-Y", strtotime('7 days ago')), date("d-m-Y", strtotime('today'))];
        }

        $histories = $histories->where('created_at', '>=', date("Y-m-d", strtotime($date_var[0])))->where('created_at', '<=',  date("Y-m-d", strtotime($date_var[1]) + 86400000));

        $data['totalPrice'] = $histories->sum('price');

        $data['histories']  = $histories->paginate(maxPaginateNo());

        $data['users']      = $this->users();
        $data['user_id']    = $request->user_id;
        $data['package_id'] = $request->package_id;

        //TODO:: Refactor Required based on our standard
        $data['packages']   = SubscriptionPlan::get(['id', 'title']);

        return $data;
    }
    public function users($userId = null)
    {

        return (new UserService())->getUsersByUserId($userId);
    }
}