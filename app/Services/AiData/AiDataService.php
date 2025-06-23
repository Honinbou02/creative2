<?php

namespace App\Services\AiData;

use App\Models\TextToSpeech;
use Illuminate\Http\Request;
use App\Models\GeneratedImage;
use App\Models\GeneratedContent;
use App\Traits\File\FileUploadTrait;
use App\Services\Core\AiConfigService;
use Illuminate\Database\Eloquent\Model;
use App\Services\Model\Article\ArticleService;
use App\Services\Model\AiWriter\AiWriterService;
use App\Services\Model\ChatThread\ChatThreadService;

class AiDataService
{
    use FileUploadTrait;

    public $sessionLab;
    public function __construct()
    {
        $this->sessionLab = sessionLab();
    }

    /**
     * Store the generated contents in the database
     *
     * @param array $decodedResult The decoded result from the API response
     * @param string $prompt The prompt used for generating the content
     * @param Request $request The request object
     * @param string $platform The platform where the content is generated
     * @param string $engineModel The model used for generating the content Ex. gpt-3.5-turbo
     * @return Model The newly created generated content model
     */
    public function storeGeneratedContents(array $decodedResult, string $prompt, Request $request, string $platform, string $engineModel = null): Model
    {
        $title = $request->title ?? "Generated-".slugMaker($request->topic ?? "");

        // Get the prompt completion tokens from the API response
        $getPromptCompletionTokens = getPromptCompletionToken($decodedResult["usage"]);

        // Extract the tokens from the response or set default to 0
        $promptToken      = $getPromptCompletionTokens[0] ?? 0;
        $completionTokens = $getPromptCompletionTokens[1] ?? 0;
        $totalTokens      = $getPromptCompletionTokens[2] ?? 0;

        if(isset($decodedResult['gowinstonAi'])){
            $content = $decodedResult['row_response'];
        } else {
            $content = isset($decodedResult['text']) ? $decodedResult['text'] : getContentFromResponse($decodedResult, isOutlineGenerating($request->content_purpose));  //TODO:: Save only generated data here ? or Full Response
        }

        $promptWords     = $this->getWordCount($prompt);
        $completionWords = isset($decodedResult['gowinstonAi']) ? $promptWords : $this->getWordCount($content);

        // Prepare the payload for creating a new generated content
        $payloads = [
            "article_id"        => $request->article_id ?? null,
            "title"             => $title,
            "slug"              => slugMaker($title),
            "model_name"        => $engineModel,
            "prompt"            => $prompt,
            "response"          => $content,
            "prompts_words"     => $promptWords,
            "completion_words"  => $completionWords,
            "total_words"       => ($promptWords+$completionWords),
            "prompts_token"     => $promptToken,
            "completion_token"  => $completionTokens,
            "total_token"       => $totalTokens,
            "content_type"      => $request->content_purpose,
            "platform"          => $platform,
            "is_active"         => 1,
            //TODO:: subscription_user_id and subscription_plan_id
        ];

        // Create a new generated content model and return it
        return GeneratedContent::query()->create($payloads);
    }
    public function storeGeneratedContentForTextToSpeech(array $data, Request $request, string $platform, string $engineModel): Model
    {
        try {
            $title = $request->title ?? "Generated-".slugMaker($request->topic ?? "");


            $total_word = strlen(plainText($request->content));
            // Prepare the payload for creating a new generated content
            $payloads = [

                "title"             => $title,
                "slug"              => slugMaker($title),
                "model_name"        => $engineModel,
                "prompt"            => plainText($request->content),
                "response"          => $data['audioName'],
                "file_path"         => $data['file_path'],
                "prompts_words"     => $total_word,
                "completion_words"  => $total_word,
                "total_words"       => 1,
                "prompts_token"     => $total_word,
                "completion_token"  => $total_word,
                "total_token"       => $total_word,
                "content_type"      => appStatic()::PURPOSE_TEXT_TO_VOICE,
                "platform"          => $platform,
                "is_active"         => 1,
                "storage_type"      => activeStorage('aws') ? 'aws' : 'local',

            ];

            info("Before Save Generated Content: " . json_encode($payloads));

            // Create a new generated content model and return it
            return GeneratedContent::query()->create($payloads);
        } catch (\Throwable $th) {
            throw $th;
        }
        // Set a default title if not provided
      
    }

    /**
     * @incomingParams $content received string Data
     *
     * At first explode with spaces
     * WIll count the number of words
     *
     * Finally return 1 either total count.
     *
     * NB: return 1 means when count value is 0 means no space found.
    */

    public function getWordCount($content) : int
    {
        $content         = is_array($content) ? implode(" ", $content) : $content;
        $explodedContent = explode(" ", $content);
        $totalCount      = count($explodedContent);

        return $totalCount <= 0 ? 1 : $totalCount;
    }


    public function storeStreamedData(array $payloads)
    {
        return GeneratedContent::query()->create($payloads);
    }

    public function storeArticleStreamedData()
    {
        $articlePrompt   = session("session_article_prompt");
        $articleContents = session("session_article_contents");
        $title           = session("session_article_title");
        $slug            = slugMaker($title);
        $modelName       = appStatic()::OPEN_AI_ARTICLE_MODEL;
        $article_id      = session("session_article_id");
        $outlines        = session("session_article_outlines");
        $platform        = session("session_article_platform");


        $promptWords     = $this->getWordCount($articlePrompt);
        $completionWords = $this->getWordCount($articleContents);
        $request = request();
        // Save the generated contents
        $payloads = [
            "is_active"         => 1,
            "title"             => $title,
            "slug"              => $slug,
            "model_name"        => $modelName,
            "prompt"            => $articlePrompt,
            "response"          => $articleContents,
            "prompts_words"     => $promptWords,
            "completion_words"  => $completionWords,
            "total_words"       => ($promptWords+$completionWords),
            "platform"          => $platform,
            "article_id"        => $article_id,
            "content_type"      => appStatic()::PURPOSE_ARTICLE,
        ];

        // Generate the content
        $generatedContent = $this->storeStreamedData($payloads);
        $session_article_id = (int)session("session_article_id");
        $article = (new ArticleService())->findArticleById($session_article_id);

        // Update the article
        (new ArticleService())->update($session_article_id, [
            "selected_outline"             => $outlines,
            "completed_step"               => appStatic()::ARTICLE_STEPS['articles'],
            "article_generated_content_id" => $generatedContent->id,
            "article"                      => $articleContents,
            "total_words"                  => ($article->total_words + $generatedContent->total_words),
        ]);

        return $generatedContent;
    }





    /**
     * Saves the generated image(s) to the database.
     *
     * @param array|object $decodedResult The decoded result containing the generated images.
     * @param string $prompt The prompt used to generate the image.
     * @param Request $request The request object containing additional data.
     * @param string $platform The platform used for image generation. openai, stable-diffusion, gemini
     * @param string $engineModel The engine model used for generation.
     *
     * @return array The saved generated images.
     * @throws \JsonException
     */

    public function saveGeneratedVideo(
        array | object $decodedResult,
        string $prompt,
        Request $request,
        string $platform,
        string $engineModel
    ) : array | model
    {
        // Set the title to the request title if available, otherwise use the prompt
        $title = setTitle();

        // Prepare the payloads for database insertion
        $payloads = [
            "title"        => $title,
            "slug"         => slugMaker($title),
            "model_name"   => $engineModel,
            "prompt"       => $prompt,
            "storage_type" => !activeStorage() ? "local" : "s3",
            "content_type" => $request->content_purpose,
            "platform"     => (new AiConfigService())->setPlatForm($platform),
        ];

        // Check if the platform uses OpenAI engine
        $isStableDiffusion = isStableDiffusion($platform);

        // Get the generated files based on the platform

        $payloads["generated_files"] = $decodedResult->id;
        $payloads["generated_image_path"] = $decodedResult->id;

        return GeneratedImage::query()->create($payloads);
    }


    /**
     * Saves the generated image(s) to the database.
     *
     * @param array|object $decodedResult The decoded result containing the generated images.
     * @param string $prompt The prompt used to generate the image.
     * @param Request $request The request object containing additional data.
     * @param string $platform The platform used for image generation. openai, stable-diffusion, gemini
     * @param string $engineModel The engine model used for generation.
     *
     * @return array The saved generated images.
     * @throws \JsonException
     */
    public function saveGeneratedImage(
        array | object $decodedResult,
        string $prompt,
        Request $request,
        string | int $platform,
        string $engineModel
    ) : array
    {
        info("Saving generated image : {$platform}");

        // Set the title to the request title if available, otherwise use the prompt
        $title = setTitle();

        // Prepare the payloads for database insertion
        $payloads = [
            "title"        => $title,
            "slug"         => slugMaker($title),
            "model_name"   => $engineModel,
            "prompt"       => $prompt,
            "storage_type" => !activeStorage() ? "local" : "s3",
            "content_type" => $request->content_purpose,
            "platform"     => $platform,
            "article_id"   => $request->article_id,
        ];

        // Check if the platform uses OpenAI engine
        $isOpenAi = isOpenAiEngine($platform);
       
        // Get the generated files based on the platform
        $generatedFiles = $isOpenAi ? getUrlsFromResponse($decodedResult) : $decodedResult->artifacts;

        $generatedImages = [];

        // Iterate over each generated file to save image data
        foreach ($generatedFiles as $key => $generatedFile) {
            $url      = $isOpenAi ? $generatedFile["url"] : $generatedFile->base64; // base64 image of SD.
            $filePath = $url;

            if(!activeStorage()){
                // If active storage is not used, save the file in a dynamic directory
                $dynamicDir = \fileService()->setStorageDirectory($request->content_purpose);
                $filePath = $this->saveFileFromUrl($url, $dynamicDir,"public",!$isOpenAi);
            }

            // Update the payloads with file and image data
            $payloads["file_path"]                  = $filePath;
            $payloads["generated_image_path"]       = $url;
            $payloads["generated_image_resolution"] = imageDimension(public_path($filePath), true);

            // Log the generated image details
            wLog("Generated Image Before Save ", $payloads, \logService()::LOG_OPEN_AI);

            // Create a new record for the generated image in the database
            $generatedImages[] = GeneratedImage::query()->create($payloads);
        }

        return $generatedImages;
    }


    public function saveChatThreadMessageStreamedData($isPdfStream = false)
    {
        $aiChatPrompt    = $isPdfStream ? session($this->sessionLab::SESSION_PDF_CHAT_PROMPT_CONTENT) : session($this->sessionLab::SESSION_AI_CHAT_PROMPT) ?? "";
        $aiChatContents  = $isPdfStream ? session($this->sessionLab::SESSION_PDF_STREAM_CONTENT) : session($this->sessionLab::SESSION_AI_CHAT_CONTENTS) ?? "";

        $chatThreadId    = (int) session($this->sessionLab::SESSION_CHAT_THREAD_ID);       

        $chatThread      = (new ChatThreadService())->findById($chatThreadId);

        $promptWords     = $this->getWordCount($aiChatPrompt);
        $completionWords = $this->getWordCount($aiChatContents);

        $totalWords      = $promptWords+$completionWords;

        $chatThreadMessage = (new ChatThreadService())->getChatThreadMessageByRandomNumber(session($this->sessionLab::SESSION_CHAT_RANDOM_NUMBER));

        $payloads = [
            "prompt"           => $aiChatPrompt,
            "platform"         => (new AiConfigService())->setPlatForm(aiEngine()),
            "type"             => request()->content_purpose ?? appStatic()::PURPOSE_CHAT,
            "response"         => $aiChatContents,
            "prompts_words"    => $promptWords ,
            "completion_words" => $completionWords,
            "total_words"      => $totalWords,
        ];
      
        $chatThreadMessage->update($payloads);

        // Update Chat Thread Words
        (new ChatThreadService())->updateChatThreadWordsAfterNewMessageStore($chatThread, $chatThreadMessage);

        return $chatThreadMessage;
    }
    public function saveGenerateTextStreamedData()
    {
        $generateContentId = session($this->sessionLab::SESSION_GENERATE_TEXT_ID);
        $aiChatPrompt      = session($this->sessionLab::SESSION_GENERATE_TEXT_PROMPT) ?? "";
        $aiChatContents    = session($this->sessionLab::SESSION_GENERATE_TEXT) ?? "";
       
        $promptWords     = $this->getWordCount($aiChatPrompt);
        $completionWords = $this->getWordCount($aiChatContents);

        $totalWords      = $promptWords+$completionWords;

        $generateContent      = (new AiWriterService())->findById($generateContentId);
        // info("generate Content AI Writer generateContent: " . json_encode($generateContent));
        $payloads = [
            "prompt"           => $aiChatPrompt,
            "platform"         => (new AiConfigService())->setPlatForm(appStatic()::ENGINE_OPEN_AI),
            "content_type"     => request()->content_purpose ?? appStatic()::PURPOSE_GENERATE_TEXT,
            "response"         => $aiChatContents,
            "prompts_words"    => $promptWords ,
            "completion_words" => $completionWords,
            "total_words"      => $totalWords,
        ];

        $generateContent->update($payloads);

        // Update Chat Thread Words

        return $generateContent;
    }

    public function saveTemplateContentStreamedData()
    {
        $generateContentId  = session($this->sessionLab::SESSION_TEMPLATE_GENERATED_CONTENT_ID);
        $templatePrompt     = session($this->sessionLab::SESSION_TEMPLATE_PROMPT) ?? "";
        $generatedContents  = session($this->sessionLab::SESSION_TEMPLATE_CONTENTS) ?? "";

        $promptWords     = $this->getWordCount($templatePrompt);
        $completionWords = $this->getWordCount($generatedContents);

        $totalWords      = $promptWords+$completionWords;

        $generateContent      = findById(new GeneratedContent(), $generateContentId);
        // info("generate Content AI Writer generateContent: " . json_encode($generateContent));
        $payloads = [
            "prompt"           => $templatePrompt,
            "platform"         => (new AiConfigService())->setPlatForm(appStatic()::ENGINE_OPEN_AI),
            "model_name"       => (new AiConfigService())->getModelBasedOnPurpose(request()->content_purpose ?? appStatic()::PURPOSE_TEMPLATE_CONTENT),
            "content_type"     => request()->content_purpose ?? appStatic()::PURPOSE_TEMPLATE_CONTENT,
            "response"         => $generatedContents,
            "prompts_words"    => $promptWords ,
            "completion_words" => $completionWords,
            "total_words"      => $totalWords,
        ];

        $generateContent->update($payloads);

        // Update Chat Thread Words

        return $generateContent;
    }


    public function saveAiVisionStreamedData()
    {
        $chatThreadService = new ChatThreadService();

        $chatThreadId     = session($this->sessionLab::SESSION_CHAT_THREAD_ID);
        $aiVisionPrompt   = session($this->sessionLab::SESSION_AI_VISION_PROMPT) ?? "";
        $aiVisionContents = session($this->sessionLab::SESSION_AI_VISION_CONTENTS) ?? "";

        $chatThread = $chatThreadService->findById($chatThreadId);

        $promptWords     = $this->getWordCount($aiVisionPrompt);
        $completionWords = $this->getWordCount($aiVisionContents);

        $totalWords      = $promptWords+$completionWords;


        // info("generate Content AI Writer generateContent: " . json_encode($generateContent));
        $payloads = [
            "prompt"           => $aiVisionPrompt,
            "platform"         => (new AiConfigService())->setPlatForm(appStatic()::ENGINE_OPEN_AI),
            "content_type"     => request()->content_purpose ?? appStatic()::PURPOSE_GENERATE_TEXT,
            "response"         => $aiVisionContents,
            "prompts_words"    => $promptWords ,
            "completion_words" => $completionWords,
            "total_words"      => $totalWords,
        ];

        $chatThreadMessage = $chatThreadService->getChatThreadMessageByRandomNumber(session($this->sessionLab::SESSION_CHAT_RANDOM_NUMBER));

        // Update Chat Thread Words
        $chatThreadMessage->update($payloads);

        $chatThreadService->updateChatThreadWordsAfterNewMessageStore($chatThread, $chatThreadMessage);

        return $chatThreadMessage;
    }

    /**
     * @incomingParams $generatedVoice will contain generated speech from OpenAI/Azure/ElevenLabs etc
     * @incomingParams $payloads will contain form submitted input data
     * 
     * */ 
    public function storeTextToSpeech(array $generatedVoice ,array $payloads){
        $payloads["file_path"] = $generatedVoice["file_path"];
        
        $textToSpeech = TextToSpeech::query()->create($payloads);
        
        return $textToSpeech;
    }

     
    public function saveAiAssistantStreamedData()
    {
        $generateContentId  = session($this->sessionLab::SESSION_AI_ASSISTANT_GENERATED_CONTENT_ID);
        $aiAssistantPrompt  = session($this->sessionLab::SESSION_AI_ASSISTANT_PROMPT) ?? "";
        $generatedContents  = session($this->sessionLab::SESSION_AI_ASSISTANT_CONTENTS) ?? "";

        $promptWords     = $this->getWordCount($aiAssistantPrompt);
        $completionWords = $this->getWordCount($generatedContents);

        $totalWords      = $promptWords+$completionWords;

        $generateContent      = findById(new GeneratedContent(), $generateContentId);
        // info("generate Content AI Writer generateContent: " . json_encode($generateContent));
        $payloads = [
            "prompt"           => $aiAssistantPrompt,
            "platform"         => (new AiConfigService())->setPlatForm(appStatic()::ENGINE_OPEN_AI),
            "model_name"       => (new AiConfigService())->getModelBasedOnPurpose(request()->content_purpose ?? appStatic()::PURPOSE_AI_ASSISTANT_CONTENT),
            "content_type"     => request()->content_purpose ?? appStatic()::PURPOSE_AI_ASSISTANT_CONTENT,
            "response"         => $generatedContents,
            "prompts_words"    => $promptWords ,
            "completion_words" => $completionWords,
            "total_words"      => $totalWords,
        ];

        $generateContent->update($payloads);

        // Update Chat Thread Words

        return $generateContent;
    }
}

