<?php

namespace App\Services\Dashboard;

use App\Models\ChatThreadMessage;
use Carbon\Carbon;
use App\Models\Template;
use Illuminate\Support\Str;
use App\Models\TextToSpeech;
use App\Models\SystemSetting;
use App\Models\GeneratedImage;
use App\Models\GeneratedContent;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionUser;
use App\Services\Model\Customer\CustomerService;
use App\Services\Model\GeneratedContent\GeneratedContentService;
use App\Services\Model\SubscriptionPlan\SubscriptionPlanService;

class DashboardService {

    public function index($request) :array
    {
        $data = [];
        $data["plans"]                  = (new SubscriptionPlanService())->getAll(null, true);
        $data['histories']              = $this->allPlanHistory();
        $data['total_customers']        = (new CustomerService())->getAll(null, true)->count();
        $data['total_words']            = $this->total_generated_words();
        $data['total_images']           = $this->total_generated_images();
        $data['total_codes']            = $this->total_generated_codes();
        $data['total_text_to_speeches'] = $this->total_text_to_speeches();
        $data['total_speech_to_texts']  = $this->total_speech_to_texts();
        $data['total_ai_chat_images']   = $this->total_generated_ai_chat_images();
        $data['totalWordsChart']        = $this->totalWordsChart($request->timeline);
        $data['totalWordsData']         = $data['totalWordsChart'][0];
        $data['timelineText']           = $data['totalWordsChart'][1];
        $data['totalTemplateWordsData'] = $this->topFiveTemplateChart();
        return $data;
    }

    public function allPlanHistory()
    {
        return SubscriptionUser::when(isCustomer(), function($q){
            $q->where('user_id', userID());
        })->with('customer', 'plan')->paginate(maxPaginateNo());
    }
    public function total_generated_words()
    {
        $request = request();
        $usage = GeneratedContent::latest()
        ->whereNotIn('content_type', [appStatic()::PURPOSE_VOICE_TO_TEXT, appStatic()::PURPOSE_TEXT_TO_VOICE,appStatic()::PURPOSE_IMAGE,appStatic()::PURPOSE_AI_IMAGE])
        ->when(!isAdmin(), function($q){
            $q->where('user_id', user()->id);
        })->when($request->template_id, function($q) use($request){
            $q->where('template_id', $request->template_id);
        });

        # conditional   
        if (Str::contains($request->date_range, 'to') && $request->date_range != null) {
            $date_var = explode(" to ", $request->date_range);
        } else {
            $date_var = [date("d-m-Y", strtotime('7 days ago')), date("d-m-Y", strtotime('today'))];
        }
        
        $usage = $usage->where('created_at', '>=', date("Y-m-d", strtotime($date_var[0])))->where('created_at', '<=',  date("Y-m-d", strtotime($date_var[1]) + 86400000));
        $chatMessageCount = $this->chatMessageCount();
        return $usage->sum('total_words') + $chatMessageCount;
    }
    public function total_generated_images()
    {
        $request = request();
        $usage = GeneratedImage::latest()
        ->where('content_type', appStatic()::PURPOSE_IMAGE)
        ->when(!isAdmin(), function($q) use($request){
            $q->where('user_id', user()->id);
        });
        # conditional   
        if (Str::contains($request->date_range, 'to') && $request->date_range != null) {
            $date_var = explode(" to ", $request->date_range);
        } else {
            $date_var = [date("d-m-Y", strtotime('7 days ago')), date("d-m-Y", strtotime('today'))];
        }
        $usage = $usage->where('created_at', '>=', date("Y-m-d", strtotime($date_var[0])))->where('created_at', '<=',  date("Y-m-d", strtotime($date_var[1]) + 86400000));
        return $usage->count();
    }
    public function total_generated_ai_chat_images()
    {
        $request = request();
        $usage = GeneratedImage::latest()
        ->where('content_type', appStatic()::PURPOSE_AI_IMAGE)
        ->when(!isAdmin(), function($q) use($request){
            $q->where('user_id', user()->id);
        });
        # conditional   
        if (Str::contains($request->date_range, 'to') && $request->date_range != null) {
            $date_var = explode(" to ", $request->date_range);
        } else {
            $date_var = [date("d-m-Y", strtotime('7 days ago')), date("d-m-Y", strtotime('today'))];
        }
        $usage = $usage->where('created_at', '>=', date("Y-m-d", strtotime($date_var[0])))->where('created_at', '<=',  date("Y-m-d", strtotime($date_var[1]) + 86400000));
        return $usage->count();
    }
    public function total_generated_codes()
    {
        $request = request();
        $usage = GeneratedContent::latest()
        ->where('content_type', appStatic()::PURPOSE_CODE)
        ->when(!isAdmin(), function($q) {
            $q->where('user_id',  user()->id);
        });

        # conditional   
        if (Str::contains($request->date_range, 'to') && $request->date_range != null) {
            $date_var = explode(" to ", $request->date_range);
        } else {
            $date_var = [date("d-m-Y", strtotime('7 days ago')), date("d-m-Y", strtotime('today'))];
        }

        $usage = $usage->where('created_at', '>=', date("Y-m-d", strtotime($date_var[0])))->where('created_at', '<=',  date("Y-m-d", strtotime($date_var[1]) + 86400000));

        return $usage->count();
    }
    public function total_text_to_speeches()
    {
        $usage = TextToSpeech::when(!isAdmin(), function($q){
            $q->where('user_id', user()->id);
        });
        return $usage->count();
    }
    public function total_speech_to_texts()
    {
        $usage = GeneratedContent::latest()
        ->where('content_type', appStatic()::PURPOSE_VOICE_TO_TEXT)
        ->when(!isAdmin(), function($q) {
            $q->where('user_id', user()->id);
        });
        return $usage->count();
    }
        # total words chart
        private function totalWordsChart($time)
        {
            $timeline                   = 7; // 7, 30 or 90 days
            $timelineText               = localize('Last 7 days');
    
            if ((int)$time > 7) {
                $timeline = (int) $time;
                if ($timeline == 30) {
                    $timelineText               = localize('Last 30 days');
                } else {
                    $timelineText               = localize('Last 3 months');
                }
            }
    
            $projects = GeneratedContent::latest()
            ->whereNotIn('content_type', [appStatic()::PURPOSE_VOICE_TO_TEXT, appStatic()::PURPOSE_TEXT_TO_VOICE, appStatic()::PURPOSE_IMAGE,appStatic()::PURPOSE_AI_IMAGE])
            ->when(!isAdmin(), function($q){
                $q->where('user_id', user()->id);
            })->where('created_at', '>=', Carbon::now()->subDays($timeline));
            $chatMessageCount = $this->chatMessageCount();
    
            $projectQueries = $projects->oldest();
            $totalWordsTimelineInString = '';
            $totalWordsAmountInString   = '';
    
            for ($i = $timeline; $i >= 0; $i--) {
                $totalWordsAmount = 0;
    
                foreach ($projectQueries->get() as $project) {
                    if (date('Y-m-d', strtotime($i . ' days ago')) == date('Y-m-d', strtotime($project->created_at))) {
                        $totalWordsAmount += $project->total_words + $chatMessageCount;
                    }
                }
    
                if ($i == 0) {
                    $totalWordsTimelineInString .= json_encode(date('Y-m-d', strtotime($i . ' days ago')));
                    $totalWordsAmountInString   .= json_encode($totalWordsAmount);
                } else {
                    $totalWordsTimelineInString .= json_encode(date('Y-m-d', strtotime($i . ' days ago'))) . ',';
                    $totalWordsAmountInString   .= json_encode($totalWordsAmount) . ',';
                }
            }
    
            $totalWordsData             = new SystemSetting; // to create temp instance.
            $totalWordsData->labels     = $totalWordsTimelineInString;
            $totalWordsData->words      = $totalWordsAmountInString;
            $totalWordsData->totalWords = $projectQueries->sum('total_words') + $chatMessageCount;
    
            return [$totalWordsData, $timelineText];
        }
    
        # top 5 template chart
        private function topFiveTemplateChart()
        {
            $templates = Template::orderBy('total_words_generated', 'DESC')->take(5);
            $totalTemplateWordsCount = $templates->sum('total_words_generated');
            $templatesLabelsInString = '';
            $templateSeries = [];
    
            foreach ($templates->get() as $key => $template) {
                $templatesLabelsInString .= json_encode($template->template_name);
                if ($key + 1 != 5) {
                    $templatesLabelsInString .= ',';
                }
                array_push($templateSeries, (float) $template->total_words_generated);
            }
    
            $totalTemplateWordsData                          = new SystemSetting; // to create temp instance.
            $totalTemplateWordsData->totalTemplateWordsCount = $totalTemplateWordsCount;
            $totalTemplateWordsData->series                  = json_encode($templateSeries);
            $totalTemplateWordsData->labels                  = $templatesLabelsInString;
    
            return $totalTemplateWordsData;
        }
        private function chatMessageCount()
        {
          return  ChatThreadMessage::when(!isAdmin(), function($q){
                $q->where('user_id', user()->id);
            })->sum('total_words');
        }
}
