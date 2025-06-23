<?php

namespace App\Services\Balance;

use App\Models\GeneratedContent;
use App\Services\AiData\AiDataService;
use App\Services\Core\AiConfigService;
use App\Services\Model\ChatExpert\ChatExpertService;
use App\Services\Model\ChatThread\ChatThreadService;

/**
 * Class BalanceService.
 */
class BalanceService
{
    public $sessionLab;
    public function __construct()
    {
        $this->sessionLab = sessionLab();
    }

    /**
     * Update user balance based on usage.
     *
     * @param array $usages Array of usage data
     * @return void
     */
    public function balanceUpdate(object $generatedContent)
    {
        // When Logged in user is a admin. No need to update balance for content.
        if(escapeForAdmin()){
            return true;
        }

        // Extract prompt, completion, and total tokens from the result
        return $this->updateUserWordBalance(getUserObject(), $generatedContent->total_words);
    }


    public function embedWordBalanceUpdate($contents)
    {
        // When Logged in user is a admin. No need to update balance for content.
        if(escapeForAdmin()){
            return true;
        }

        $user = getUserObject();

        if($user->usage){
            $explodedContents = customExplode($contents," ");
            $usedWords = $user->usage->word_balance_used + count($explodedContents);

            $payloads = [
                "word_balance_used"      => $usedWords,
                "word_balance_remaining" => $user->usage->word_balance - $usedWords
            ];

            info("User Balance Update Before save : " . json_encode($payloads));

            $user->usage->update($payloads);

            return $user->usage;
        }
    }


    // SEO Keyword Balance Update
    public function seoKeywordBalanceUpdate(object $user)
    {
        // When Logged in user is a admin. No need to update balance for content.
        if(escapeForAdmin()){
            return true;
        }

        $bulkKeywordCost = getSetting("bulk_keyword_research_per_request_credit_cost",0);

        $userUsage = $user->usage;

        $userUsage->update([
            "seo_balance_used"      => $userUsage->seo_balance_used + $bulkKeywordCost,
            "seo_balance_remaining" => $userUsage->seo_balance_remaining - $bulkKeywordCost
        ]);

        return $userUsage;
    }

    // SEO Content Optimization Balance Update
    public function seoContentOptimizationBalanceUpdate(object $user)
    {
        // When Logged in user is a admin. No need to update balance for content.
        if(escapeForAdmin()){
            return true;
        }

        $user->usage->update([
            "seo_balance_used" => $user->usage->seo_balance_used + getSetting("content_optimization_per_request_credit_cost",0)
        ]);

        return $user->usage;
    }

    // SEO Helpful Content Analysis Balance Update
    public function seoHelpfulContentAnalysisBalanceUpdate(object $user)
    {
        // When Logged in user is a admin. No need to update balance for content.
        if(escapeForAdmin()){
            return true;
        }

        $helpfulContentCost = getSetting("helpful_content_optimization_per_request_credit_cost",0);
        $userUsage          = $user->usage;

        // User Usage Update
        $userUsage->update([
            "seo_balance_used" => $userUsage->seo_balance_used + $helpfulContentCost
        ]);

        return $userUsage;
    }



    public function openAiWordBalanceUpdate(): void
    {
        $calculationType = (string) request()->calculation_type;
        // TODO:: OPEN AI Balance Update
        if (session()->has($this->sessionLab::SESSION_ARTICLE_CONTENTS) && isArticleGenerating($calculationType)) {
            $this->updateArticleAndWordBalance();
        }

        // AI Chat Data Store & Balance Update
        if (session()->has($this->sessionLab::SESSION_AI_CHAT_CONTENTS)) {
            $this->updateAiChatWordBalance();
        }
        // AI Generate Text Data Store & Balance Update
        if (session()->has($this->sessionLab::SESSION_GENERATE_TEXT)) {
            $this->updateAiGenerateTextWordBalance();
        }

        // Vision Prompt
        if (session()->has($this->sessionLab::SESSION_AI_VISION_CONTENTS)) {
            $this->updateAiVisionWordBalance();
        }

        // PDF Chat
        if(session()->has($this->sessionLab::SESSION_PDF_STREAM_CONTENT)){
            $this->updateAiPdfWordBalance();
        }

        // Template Content
        if(session()->has($this->sessionLab::SESSION_TEMPLATE_CONTENTS)){
            $this->updateAITemplateWordBalance();
        }
        
        if (session()->has($this->sessionLab::SESSION_AI_ASSISTANT_CONTENTS) && isAiAssistant($calculationType)) {
            $this->updateAIAssistantWordBalance();
        }
    }

    // AI Assistant
    public function updateAIAssistantWordBalance()
    { 
        $generatedContent = (new AiDataService())->saveAiAssistantStreamedData();
        $this->updateUserWordBalance(getUserObject(), $generatedContent->total_words);
    }
    // Template Content
    public function updateAITemplateWordBalance()
    {

        $templateContents = session($this->sessionLab::SESSION_TEMPLATE_CONTENTS);
        $templatePrompt = session($this->sessionLab::SESSION_TEMPLATE_PROMPT);
        //TODO::Template Save
        $generatedContent = (new AiDataService())->saveTemplateContentStreamedData();

        $promptWords     = $generatedContent->prompts_words;
        $completionWords = $generatedContent->completion_words;

        //TODO :: Deduct the word Balance
        $this->updateUserWordBalance(getUserObject(), $generatedContent->total_words);
    }

    public function updateArticleAndWordBalance()
    {
        $articlePrompt   = session($this->sessionLab::SESSION_ARTICLE_PROMPT);
        $articleContents = session($this->sessionLab::SESSION_ARTICLE_CONTENTS);

        // Storing the generated contents & Article Data in the database
        $generatedContent = (new AiDataService())->storeArticleStreamedData();
       
        $promptWords     = $generatedContent->prompts_words;
        $completionWords = $generatedContent->completion_words;
       
        //TODO :: Deduct the word Balance
        $this->updateUserWordBalance(getUserObject(), $generatedContent->total_words);
    }

    public function updateAiPdfWordBalance()
    {
        $pdfPrompt           =  session($this->sessionLab::SESSION_PDF_CHAT_PROMPT_CONTENT);
        $pdfStreamedContents = session($this->sessionLab::SESSION_PDF_STREAM_CONTENT);

        // Storing the generated contents & Article Data in the database
        $generatedContent = (new AiDataService())->saveChatThreadMessageStreamedData(true);

        $promptWords     = $generatedContent->prompts_words;
        $completionWords = $generatedContent->completion_words;

        // Deduct the word Balance
        return $this->updateUserWordBalance(getUserObject(), $generatedContent->total_words);
    }

    public function updateAiChatWordBalance()
    {
        $chatThreadMessage = (new AiDataService())->saveChatThreadMessageStreamedData();

        
        info("ChatThreadMessage : " . json_encode($chatThreadMessage));
        // Deduct the word Balance
        $this->updateUserWordBalance(getUserObject(), $chatThreadMessage->total_words);
    }
    public function updateAiGenerateTextWordBalance()
    {
        $generateContentAiWriter = (new AiDataService())->saveGenerateTextStreamedData();

        info("generate Content AI Writer : " . json_encode($generateContentAiWriter));
        //TODO :: Deduct the word Balance

        $this->updateUserWordBalance(getUserObject(), $generateContentAiWriter->total_words);
    }

    public function updateAiVisionWordBalance()
    {
        $chatThreadMessage = (new AiDataService())->saveAiVisionStreamedData();

        info("Chat Thread Message : " . json_encode($chatThreadMessage));
        //TODO :: Deduct the word Balance

        $this->updateUserWordBalance(getUserObject(), $chatThreadMessage->total_words);
    }

    public function updateUserWordBalance(object $user, $totalWords = 0)
    {
        // When Logged in user is a admin. No need to update balance for content.
        if(escapeForAdmin()){
            return true;
        }

        if($user->usage){
            $usedWords = $user->usage->word_balance_used + $totalWords;

            $payloads = [
                "word_balance_used"      => $usedWords,
                "word_balance_remaining" => $user->usage->word_balance - $usedWords
            ];

            info("User Balance Update Before save : " . json_encode($payloads));

            $user->usage->update($payloads);

            return $user->usage;
        }
    }

    public function audioBalanceUpdate(object $user, int $totalText_2_voice = 1)
    {
        // When Logged in user is a admin. No need to update balance for content.
        if(escapeForAdmin()){
            return true;
        }

        // OpenAI/Eleven
        $platform = session(sessionLab()::SESSION_TEXT_TO_SPEECH_OPEN_AI);
       
        wLog("Updating User text to voice Balance", ["user_id" => $user->id, "newly_generated_Text_2_voice" => $totalText_2_voice], logService()::LOG_OPEN_AI);
        if($user->usage){
            $usage = $user->usage;

            $totalUsed      = $usage->word_balance_used_t2s + $totalText_2_voice;
            $totalRemaining = $usage->word_balance_t2s - $totalUsed;

            $usage->update([
                "word_balance_used_t2s"      => $totalUsed,
                "word_balance_remaining_t2s" => $totalRemaining
            ]);

            return $usage;
        }
    }
    public function audio2TextBalanceUpdate(object $user, int $total_voice_2_Text)
    {
        // When Logged in user is a admin. No need to update balance for content.
        if(escapeForAdmin()){
            return true;
        }

        // OpenAI/Eleven
        $platform = session(sessionLab()::SESSION_SPEECH_TO_TEXT_OPEN_AI);
       
        wLog("Updating User text to voice Balance", ["user_id" => $user->id, "newly_generated_Text_2_voice" => $total_voice_2_Text], logService()::LOG_OPEN_AI);
        if($user->usage){
            $usage = $user->usage;

            $totalUsed      = $usage->speech_balance_used + $total_voice_2_Text;
            $totalRemaining = $usage->speech_balance - $totalUsed;

            $usage->update([
                "speech_balance_used"      => $totalUsed,
                "speech_balance_remaining" => $totalRemaining
            ]);

            return $usage;
        }
    }

    public function updateImageBalance(object $user, int $totalImages)
    {
        // When Logged in user is a admin. No need to update balance for content.
        if(escapeForAdmin()){
            return true;
        }

        $dateTimeSecond = now()->toDateTimeLocalString();

        wLog("{$dateTimeSecond} | Before Updating User Image Balance", ["user_id" => $user->id, "newly_generated_images" => $totalImages], logService()::LOG_USER_BALANCE);
        if($user->usage){
            $usage = $user->usage;

            $totalUsed      = $usage->image_balance_used + $totalImages;
            $totalRemaining = $usage->image_balance - $totalUsed;

            $usage->update([
                "image_balance_used"      => $totalUsed,
                "image_balance_remaining" => $totalRemaining
            ]);

            wLog("{$dateTimeSecond} | After User Image Balance Update", ["usage"=>$usage], logService()::LOG_USER_BALANCE);

            return $usage;
        }
    }

    public function updateVideoBalance(object $user, int $totalVideos)
    {
        // When Logged in user is a admin. No need to update balance for content.
        if(escapeForAdmin()){
            return true;
        }

        wLog("Updating User Video Balance", ["user_id" => $user->id, "newly_generated_images" => $totalVideos], logService()::LOG_OPEN_AI);

        if($user->usage){
            $usage = $user->usage;

            $totalUsed      = $usage->video_balance_used + $totalVideos;
            $totalRemaining = $usage->video_balance - $totalUsed;

            $usage->update([
                "video_balance_used"      => $totalUsed,
                "video_balance_remaining" => $totalRemaining
            ]);

            return $usage;
        }
    }

    public function geminiWordBalanceUpdate()
    {
    }

    
    public function updateUserPostBalance()
    {
        // When Logged in user is a admin. No need to update balance for content.
        if(escapeForAdmin()){
            return true;
        }
        
        $user = getUserObject();
        if($user->usage){
            $usedPosts = $user->usage->total_social_platform_post_per_month_used + 1;

            $payloads = [
                "total_social_platform_post_per_month_used"      => $usedPosts,
                "total_social_platform_post_per_month_remaining" => $user->usage->total_social_platform_post_per_month - $usedPosts
            ];

            info("User Balance Update after creation : " . json_encode($payloads));

            $user->usage->update($payloads);

            return $user->usage;
        }
    }

    public function updateUserAccountBalance()
    {    
        // When Logged in user is a admin. No need to update balance for content.
        if(escapeForAdmin()){
            return true;
        }
        
        $user = getUserObject();
        if($user->usage){
            $usedAccounts = $user->usage->total_social_platform_account_per_month_used + 1;

            $payloads = [
                "total_social_platform_account_per_month_used"      => $usedAccounts,
                "total_social_platform_account_per_month_remaining" => $user->usage->total_social_platform_account_per_month - $usedAccounts
            ];

            info("User Balance Update after creation : " . json_encode($payloads));

            $user->usage->update($payloads);

            return $user->usage;
        }
    }

    public function updateStableDiffusionBalance(object $user, int $totalImages)
    {
        // When Logged in user is a admin. No need to update balance for content.
        if(escapeForAdmin()){
            return true;
        }

        wLog("Updating Stable Diffusion User Image Balance", ["user_id" => $user->id, "newly_generated_images" => $totalImages], logService()::LOG_SD);
        if($user->usage){
            $usage = $user->usage;

            $totalUsed      = $usage->image_balance_used + $totalImages;
            $totalRemaining = $usage->image_balance - $totalUsed;

            $usage->update([
                "image_balance_used"      => $totalUsed,
                "image_balance_remaining" => $totalRemaining
            ]);

            return $usage;
        }
    }

    public function noWordBalance(): void
    {
        $appStatic = appStatic();

        if(!hasBalance()){
            throw new \RuntimeException(localize($appStatic::MESSAGE_NO_WORD_BALANCE), $appStatic::BALANCE_ERROR);
        }
    }

    public function noPostBalance(): void
    {
        $appStatic = appStatic();

        if(!hasBalance($appStatic::PURPOSE_SOCIAL_POST)){
            throw new \RuntimeException(localize($appStatic::MESSAGE_NO_POST_BALANCE), $appStatic::BALANCE_ERROR);
        }
    }

    public function noAccountBalance(): void
    {
        $appStatic = appStatic();

        if(!hasBalance($appStatic::PURPOSE_SOCIAL_ACCOUNT)){
            throw new \RuntimeException(localize($appStatic::MESSAGE_NO_ACCOUNT_BALANCE), $appStatic::BALANCE_ERROR);
        }
    }
}
