<?php

namespace App\Services\Core;

use Gemini\Data\Blob;
use Gemini\Enums\MimeType;
use App\Models\ChatThreadMessage;
use App\Services\Core\SerperService;

/**
 * Class AiConfigService.
 */
class AiConfigService
{

    /**
     * @incomingParams $platformType will receive integer value
     * Here
     *  1 == OpenAI
     *  2 == Stable Diffusion
     *  3 == ElevenLabs
     *  4 == Azure
     *  5 == GoogleTTS
     *  6 == Whisper
     *  7 == Gemini AI
     *
     * @incomingParams $generateAction will receive string value
     *
     * code, keywords, titles, outlines, articles, images etc.
     * */
    public function setConfiguration(
        int $platformType      = 1,
        string $generateAction = "code",
        $prompt                = "",
        $oldThreeConversations = [],
        array $optional        = []
    ) {
        $appStatic = appStatic();

        // Chat
        if (isAiChat($generateAction)) {

            return $this->configChat($prompt);
        }

        //AI vision
        if (isAiVision($generateAction) && $platformType == 1) {

            return $this->configVision($prompt, $platformType);
        }
        //AI vision
        if (isAiVision($generateAction) && $platformType == 7) {

            return $this->configGeminiVision($prompt);
        }

        // Code
        if (isAiCode($generateAction)) {

            return $this->configCode($prompt);
        }

        // Keywords or Titles or Outlines
        if ($generateAction === $appStatic::PURPOSE_KEYWORD || $generateAction === $appStatic::PURPOSE_TITLE || $generateAction === $appStatic::PURPOSE_OUTLINE) {

            return $this->configKeywordTitleOutline($prompt);
        }

        // Meta Description
        if ($generateAction === $appStatic::PURPOSE_META_DESCRIPTION) {

            return $this->configMetaDescription($prompt);
        }

        // Articles
        if (isArticleGenerating($generateAction)) {

            return $this->configArticle($prompt);
        }

        // Images for Open AI & DALL E 2
        if (isOpenAiEngine(1) && $generateAction === $appStatic::OPEN_AI_DALL_E_2_MODEL) {
            return $this->configDallE2($prompt);
        }

        // Images for Open AI & DALL E 3
        if (isOpenAiEngine(1) && $generateAction === $appStatic::OPEN_AI_DALL_E_3_MODEL) {

            return  $this->configDallE3($prompt);
        }

        // Text to Images for Stable Diffusion
        if ($platformType == 2 && $generateAction === $appStatic::SD_TEXT_2_IMAGE) {
            return $this->configSDText2Image($prompt, $optional);
        }

        //Stable Diffusion Text to Image with Multiple Prompt
        if ($platformType == 2 && $generateAction === $appStatic::SD_TEXT_2_IMAGE_MULTI_PROMPT) {
            return $this->configSDText2ImageMultiPrompt($prompt, $optional);
        }

        //Stable Diffusion Image to Image with Prompt
        if ($platformType == 2 && $generateAction === $appStatic::SD_IMAGE_2_IMAGE_PROMPT) {
            return $this->configSDImage2ImagePrompt($prompt, $optional);
        }

        //Stable Diffusion Image to Image with Up Scale
        if ($platformType == 2 && $generateAction === $appStatic::SD_IMAGE_2_IMAGE_UPSCALING) {
            return $this->configSDImage2ImagePrompt($prompt, $optional);
        }

        //Stable Diffusion Image to Image with Masking
        if ($platformType == 2 && $generateAction === $appStatic::SD_IMAGE_2_IMAGE_MASKING) {
            return $this->configSDImage2ImageMaskingPrompt($prompt, $optional);
        }

        //open ai text to speech
        if (isOpenAiEngine(1) && ($generateAction === $appStatic::OPEN_AI_TTS_1_HD || $generateAction === $appStatic::OPEN_AI_TTS_1)) {
            return $this->configOpenAiTTS();
        }

        //Eleven labs text to speech
        if ($platformType == 3 && ($generateAction === $appStatic::PURPOSE_TEXT_TO_VOICE)) {
            return $this->configElevenLabsTTS();
        }

        //Google cloud text to speech
        if ($platformType == 5 && ($generateAction === $appStatic::PURPOSE_TEXT_TO_VOICE)) {
            return $this->configGoogleTTS();
        }

        //AZURE cloud text to speech
        if ($platformType == 4 && ($generateAction === $appStatic::PURPOSE_TEXT_TO_VOICE)) {
            return $this->configAzureTTS();
        }

        //open ai generate text
        if (isOpenAiEngine(1) && isAiText($generateAction)) {
            return $this->configText($prompt, $optional);
        }

        //open ai Template Content
        if (isOpenAiEngine(1) && isAiTemplate($generateAction)) {
            return $this->configTemplate($prompt, $optional);
        }

        //open ai PDF
        if (isOpenAiEngine(1) && isAiPdf($generateAction)) {
            return $this->configPdfChat($prompt, $optional);
        }

        //open ai Image
        if (isOpenAiEngine(1) && isAiImage($generateAction)) {
            return $this->configAiImageChat($prompt, $optional);
        }
        
        //open ai ai assistant Content
        if (isOpenAiEngine(1) && isAiAssistant($generateAction)) {
            return $this->configAiAssistant($prompt, $optional);
        }
        
        //open ai ai assistant Content
        if (isOpenAiEngine(1) && isSocialPost($generateAction)) {
            return $this->configSocialPost($prompt, $optional);
        }
 
    }

    
    public function configSocialPost($prompt, array $optional = [])
    {
        if(isGeminiAi(aiBlogWizardEngine()) || isClaudeAi(aiBlogWizardEngine() || isDeepseekAi(aiBlogWizardEngine()))) return $prompt;
        $temperature    = isset($optional['temperature'])? $optional['temperature'] : 1.0;
        $max_tokens     = isset($optional['max_tokens']) ? $optional['max_tokens'] : -1;

        // ai params
        $aiParams = [
            'temperature'       => 1.0,
            'presence_penalty'  => 0.6,
            'frequency_penalty' => 0,
            'stream'            => false
        ];

        if ($max_tokens != -1 && $max_tokens != 0 ) {
            $aiParams['max_tokens'] = $max_tokens;
        }
        # opts
        $aiParams['messages'] = [[
            "role" => "user",
            "content" => $prompt
        ]];

        return $aiParams;
    }

    public function configAiAssistant($prompt, array $optional = [])
    {
        if(isGeminiAi(aiAssistantEngine()) || isClaudeAi(aiAssistantEngine() || isDeepseekAi(aiAssistantEngine()))) return $prompt;
        $temperature    = isset($optional['temperature'])? $optional['temperature'] : 1.0;
        $max_tokens     = isset($optional['max_tokens']) ? $optional['max_tokens'] : -1;

        // ai params
        $aiParams = [
            'temperature'       => 1.0,
            'presence_penalty'  => 0.6,
            'frequency_penalty' => 0,
            'stream'            => true
        ];

        if ($max_tokens != -1 && $max_tokens != 0 ) {
            $aiParams['max_tokens'] = $max_tokens;
        }
        # opts
        $aiParams['messages'] = [[
            "role" => "user",
            "content" => $prompt
        ]];

        return $aiParams;
    }

    public function configChat($prompt)
    {
        $messages   = [];
        $messages[] = ["role" => "system", "content" => "You are a helpful assistant."];
        $messages[] = ["role" => "system", "content" => $prompt];
        $realTime   = request()->real_time_data;

        $chatMessages = ChatThreadMessage::where('chat_thread_id', getChatThreadId())->orderBy('created_at', 'desc')->take(5)->get()->reverse();      
        // Checking is the chat thread is not empty
        if($realTime == 'false') {           
            if (!empty($chatMessages)) {             
                foreach ($chatMessages as $key => $chat) {                   
                    if(!empty($chat->response)) {
                        $messages[] = ["role" => "user", "content" => $chat->title];                      
                        $messages[] = ["role" => "assistant", "content" => $chat->response ?? ""]; 
                    }
                }
            }
        }
      
        if($realTime == 'true' && serperApi()){
            $serper = new SerperService(getSetting('serper_api_key'));
            $question  = [
              'q'=> request()->message
            ];
            $search = $serper->search($question);
            $final_prompt =
            "Prompt: " . request()->message.
            '\n\nWeb search json results: '
            .json_encode($search).
            '\n\nInstructions: Based on the Prompt generate a proper response with help of Web search results(if the Web search results in the same context).Only if the prompt require links: (make curated list of links and descriptions using only the <a target="_blank">,write links with using <a target="_blank"> with mrgin Top of <a> tag is 5px and start order as number and write link first and then write description).Must not write links if its not necessary. Must not mention anything about the prompt text.';
            $messages[] = ["role" => "user", "content" => $final_prompt];
        }else{
            // User Manual Input Prompt
            $messages[] = ["role" => "user", "content" => request()->message];
        }
       
        return [
            'messages'          => $messages,
            'temperature'       => 1.0,
            'presence_penalty'  => 0.6,
            'frequency_penalty' => 0,
            'stream'            => true
        ];
    }

    public function configVision($prompt, $platformType = null)
    {
        $messages[] = ["role" => "system", "content" => "You are a helpful assistant."];

        //TODO::Last 3 conversations will add here
        $images        = session(sessionLab()::SESSION_AI_VISION_IMAGES) ?? [];
        $contentImages = [];

        foreach ($images as $image) {
            $contentImages[] = [
                'type'       => 'image_url',
                'image_url'  => [
                    'url'    => urlVersion($image[0]),
                    'detail' => 'auto'
                ]
            ];
        }

        $content = [[
            'type' => 'text',
            'text' => $prompt,
        ]];

        if($platformType == 7) {
            return  [
                $prompt,
                new Blob(
                    mimeType: MimeType::IMAGE_JPEG,
                    data: base64_encode(
                        file_get_contents($images[0])
                    )
                )
            ];
        }

        return [
            'messages' => [
                [
                    'role' => 'user',
                    'content' => array_merge($content, $contentImages)
                ],
            ],
            'max_tokens' => 2000,
            'stream' => true
        ];
    }
    public function configGeminiVision($prompt)
    {
        $images  = session(sessionLab()::SESSION_AI_VISION_IMAGES) ?? [];
        return  [
            $prompt,
            new Blob(
                mimeType: MimeType::IMAGE_JPEG,
                data: base64_encode(
                    file_get_contents(urlVersion($images[0][0]))
                )
            )
        ];
    }
    public function configPdfChat($prompt)
    {

        $chatMessages = ChatThreadMessage::where('chat_thread_id', getChatThreadId())->orderBy('created_at', 'desc')->take(5)->get()->reverse();      
        $messages   = [];
        $messages[] = ["role" => "system", "content" => "You are a helpful assistant."];
        $messages[] = ["role" => "system", "content" => $prompt];
  
        // Checking is the chat thread message is not empty
         
        if (!empty($chatMessages)) {             
            foreach ($chatMessages as $key => $chat) {                   
                if(!empty($chat->response)) {
                    $messages[] = ["role" => "user", "content" => $chat->title];                      
                    $messages[] = ["role" => "assistant", "content" => $chat->response ?? ""]; 
                }
            }
        }
        
        // User Manual Input Prompt
        $messages[] = ["role" => "user", "content" => request()->message];

        return [
            'messages'          => $messages,
            'temperature'       => 1.0,
            'presence_penalty'  => 0.6,
            'frequency_penalty' => 0,
            'stream'            => true
        ];
    }
    public function configAiImageChat($prompt)
    {
        $messages[] = ["role" => "user", "content" => $prompt];
       return [

            'messages'          => $messages,
            'temperature'       => 1.0,
            'presence_penalty'  => 0.6,
            'frequency_penalty' => 0,
            'stream'            => false
        ];
    }
    public function configCode($prompt)
    {
        return [
            "messages" => [
                [
                    "role" => "system",
                    "content" => "You are a super intelligent assistant who writes code."
                ],
                [
                    "role" => "user",
                    "content" => $prompt
                ],
            ],
            'temperature' => 1,
            'max_tokens' => 1000,
        ];
    }
 

    public function configText($prompt, array $optional = [])
    {
        $temperature    = isset($optional['temperature'])? $optional['temperature'] : 1.0;
        $max_tokens     = isset($optional['max_tokens']) ? $optional['max_tokens'] : -1;

        // ai params
        $aiParams = [
            'temperature'       => 1.0,
            'presence_penalty'  => 0.6,
            'frequency_penalty' => 0,
            'stream'            => true
        ];
      
        if ($max_tokens != -1 && $max_tokens != 0 ) {
            $aiParams['max_tokens'] = $max_tokens;
        }
        # opts
        $aiParams['messages'] = [[
            "role" => "user",
            "content" => $prompt
        ]];
        return $aiParams;
    }

    public function configTemplate($prompt, array $optional = [])
    {
        if(isGeminiAi(templatesEngine()) || isClaudeAi(templatesEngine() || isDeepseekAi(templatesEngine()))) return $prompt;
        $temperature    = isset($optional['temperature'])? $optional['temperature'] : 1.0;
        $max_tokens     = isset($optional['max_tokens']) ? $optional['max_tokens'] : -1;

        // ai params
        $aiParams = [
            'temperature'       => 1.0,
            'presence_penalty'  => 0.6,
            'frequency_penalty' => 0,
            'stream'            => true
        ];

        if ($max_tokens != -1 && $max_tokens != 0 ) {
            $aiParams['max_tokens'] = $max_tokens;
        }
        # opts
        $aiParams['messages'] = [[
            "role" => "user",
            "content" => $prompt
        ]];

        return $aiParams;
    }
    public function configGeminiAiTemplate()
    {
        
    }
    public function configKeywordTitleOutline($prompt)
    {
        return [
            "messages" => [
                [
                    "role" => "user",
                    "content" => $prompt
                ],
            ],
            'temperature' => 1,
            'max_tokens' => 2000,
        ];
    }

    public function configMetaDescription($prompt)
    {
        return [
            "messages" => [
                [
                    "role" => "user",
                    "content" => $prompt
                ],
            ],
            'temperature' => 1,
            'max_tokens' => 2000,
        ];
    }

    public function configArticle($prompt)
    {
        return [
            "messages" => [
                [
                    "role" => "user",
                    "content" => $prompt
                ],
            ],
            'temperature'       => 1,
            'max_tokens'        => 4000,
            'presence_penalty'  => 0.6,
            'frequency_penalty' => 0,
            'stream'            => true,
        ];
    }

    public function configDallE2($prompt)
    {
        return [
            'prompt'          => $prompt,
            'size'            => setSize(),
            'n'               => setNumberOfResults(),
            "response_format" => "url",
        ];
    }

    public function configDallE3($prompt): array
    {
        return [
            'prompt'          => $prompt,
            'size'            => setSize(),
            'n'               => (int) setNumberOfResults(),
            "response_format" => "url",
        ];
    }


    public function configSDText2Image(string $prompt, array $optional)
    {
        return [
            'text_prompts' => [
                [
                    'text' => $prompt,
                ],
            ],
            'cfg_scale' => 7,
            'height' => (int) $optional['height'],
            'width'  => (int) $optional['width'],
            'steps' => 30,
            'samples' => setNumberOfResults(),
        ];
    }

    public function configSDText2ImageMultiPrompt(string $prompt, array $optional)
    {
        $textPrompts = [];


        $titles = request()->title; // Example titles array

        $text_prompts = [];

        foreach ($titles as $index => $title) {
            $text_prompts[$index] = [
                "text" => $title,
                "weight" => 1
            ];
        }

        $params =  [
            'cfg_scale' => 7,
            'height' => (int) $optional['height'],
            'width'  => (int) $optional['width'],
            'steps' => 30,
            'samples' => setNumberOfResults(),
        ];

        $params["text_prompts"] = $text_prompts;

        return $params;
    }

    public function configSDImage2ImagePrompt(string $prompt, array $optional)
    {
        return [
            'samples'                 => setNumberOfResults(),
        ];
    }

    public function configSDImage2ImageMaskingPrompt(string $prompt, array $optional): array
    {
        $image = $optional['image'];

        return [
//            'prompt'     => $prompt,
            'init_image' => base64_encode(file_get_contents($image->getRealPath())),
            'mask'       => base64_encode(file_get_contents($image->getRealPath())),
            'mask_source' => 'MASK_IMAGE_WHITE',
            'text_prompts' => [
                [
                    'text' => $prompt,
                    'weight' => 1.0
                ]
            ],
            'cfg_scale'            => 7,
            'clip_guidance_preset' => 'FAST_BLUE',
            'samples'    => setNumberOfResults(),
            'steps'                => 30,
        ];
    }

    /**
     * Prompt Storing in session
     *
     * @incomingParams $prompt will receive string value as command prompt
     * @incomingParams $contentPurpose will receive string value as content purpose like articles, code, template content generations
     * */
    public function setPromptInSession(string $prompt, string $contentPurpose)
    {
        info("Purpose : {$contentPurpose} and Prompt : {$prompt}");

        // Article Generation
        if (isArticleGenerating($contentPurpose)) {
            session()->put([sessionLab()::SESSION_ARTICLE_PROMPT => $prompt]);
            session()->save();

            return session(sessionLab()::SESSION_ARTICLE_PROMPT);
        }

        // Code Generation
        if (isCodeGenerating($contentPurpose)) {
            session()->put([sessionLab()::SESSION_CODE_PROMPT => $prompt]);
            session()->save();

            return session(sessionLab()::SESSION_CODE_PROMPT);
        }

        // Template Generation
        if (isAiTemplate($contentPurpose)) {
            session()->put([sessionLab()::SESSION_TEMPLATE_PROMPT =>$prompt] );
            session()->save();

            info("Template Prompt : " . session(sessionLab()::SESSION_TEMPLATE_PROMPT));

            return session(sessionLab()::SESSION_TEMPLATE_CONTENTS_PROMPT);
        }
        
        // Text  Generation
        if (isAiText($contentPurpose)) {
            session()->put([sessionLab()::SESSION_GENERATE_TEXT_PROMPT =>$prompt] );
            session()->save();

            return session(sessionLab()::SESSION_GENERATE_TEXT_PROMPT);
        }

        // AI Chat Conversation
        if (isAiChat($contentPurpose)) {
            session()->put([sessionLab()::SESSION_AI_CHAT_PROMPT => $prompt]);
            session()->save();

            return session(sessionLab()::SESSION_AI_CHAT_PROMPT);
        }

        // AI Vision
        if (isAiVision($contentPurpose)) {
            session()->put([sessionLab()::SESSION_AI_VISION_PROMPT => $prompt]);
            session()->save();
        }

        // AI Writer
        if (isAiWriter($contentPurpose)) {
            session()->put([sessionLab()::SESSION_AI_VISION_PROMPT => $prompt]);
            session()->save();
        }
    }


    public function setCompletionDataInSession(string | null $content, string $contentPurpose)
    {
//        info("streaming session $contentPurpose and Content is : {$content}" );
        $sessionLab = sessionLab();

        // Article Generation
        if (isArticleGenerating($contentPurpose)) {
            // Article Contents
            $sessionArticleContents = $sessionLab::SESSION_ARTICLE_CONTENTS;

            session()->put([$sessionArticleContents => $content]);
            session()->save();

            return session($sessionArticleContents);
        }

        // AI Chat Thread Conversation
        if (isAiChat($contentPurpose)) {
            // AI Chat Contents
            $sessionAiChatContents = $sessionLab::SESSION_AI_CHAT_CONTENTS;

            session()->put([$sessionAiChatContents => $content]);
            session()->save();

            return session($sessionAiChatContents);
        }

        // AI Text 
        if (isAiText($contentPurpose)) {
            $sessionAiTextContents = $sessionLab::SESSION_GENERATE_TEXT;

            session()->put([$sessionAiTextContents => $content]);
            session()->save();

            return session($sessionAiTextContents);
        }

        // AI Vision
        if (isAiVision($contentPurpose)) {
            $sessionAiVisionContents = $sessionLab::SESSION_AI_VISION_CONTENTS;

            session()->put([$sessionAiVisionContents => $content]);
            session()->save();

            return session($sessionAiVisionContents);
        }

        // AI Code
        if(isAiCode($contentPurpose)){
            $sessionAiCodeContents = $sessionLab::SESSION_AI_CODE_CONTENTS;

            session()->put([$sessionAiCodeContents => $content]);
            session()->save();

            return session($sessionAiCodeContents);
        }

        // AI Pdf
        if(isAiPdf($contentPurpose)){
            $sessionAiPdfContents = $sessionLab::SESSION_PDF_STREAM_CONTENT;

            session()->put([$sessionAiPdfContents => $content]);
            session()->save();

//            info("PDF Chat Stream: " . session($sessionAiPdfContents));

            return session($sessionAiPdfContents);
        }

        // AI Template Content
        if(isAiTemplate($contentPurpose)){
            $sessionAiPdfContents = $sessionLab::SESSION_TEMPLATE_CONTENTS;

            session()->put([$sessionAiPdfContents => $content]);
            session()->save();

//            info("Template Stream: " . session($sessionAiPdfContents));

            return session($sessionAiPdfContents);
        }

           // AI Assistant Content
        if(isAiAssistant($contentPurpose)){
            $sessionAiAssistantContents = $sessionLab::SESSION_AI_ASSISTANT_CONTENTS;

            session()->put([$sessionAiAssistantContents => $content]);
            session()->save(); 
            return session($sessionAiAssistantContents);
        }
    }

    /**
     * @incomingParams $platForm may contain => "OpenAi",
     * @incomingParams $platForm may contain => "Stable Diffusion(SD)",
     * @incomingParams $platForm may contain => "ElevenLabs",
     * @incomingParams $platForm may contain => "Azure TTS",
     * @incomingParams $platForm may contain => "Google TTS"
     * @incomingParams $platForm may contain => "GeminiAi"
     * @incomingParams $platForm may contain => "ClaudeAi"
     * @incomingParams $platForm may contain => "DeepseekAi"
     * */
    public function setPlatForm(string $platForm)
    {
        $appStatic = appStatic();

        return match($platForm){
            $appStatic::ENGINE_OPEN_AI          => 1,
            $appStatic::ENGINE_STABLE_DIFFUSION => 2,
            $appStatic::ENGINE_ELEVEN_LAB       => 3,
            $appStatic::ENGINE_AZURE            => 4,
            $appStatic::ENGINE_GOOGLE_TTS       => 5,
            $appStatic::ENGINE_GOWINSTON_AI     => 6,
            $appStatic::ENGINE_GEMINI_AI        => 7,
            $appStatic::ENGINE_CLAUDE_AI        => 8,
            $appStatic::ENGINE_DEEPSEEK_AI      => 9,
            default => 1
        };
    }


    /**
     * @throws \Exception
     */
    public function getModelBasedOnPurpose($type)
    {
        $appStatic = appStatic();
        return match ($type) {
            "code", "chat", "generateText", 'pdf', 'aiImage', 'aiAssistant', "socialPost"    =>  userActiveSubscriptionModel($type,appStatic()::OPEN_AI_CHAT_MODEL),
            "keywords", "titles", "outlines","meta_descriptions", "articles","rewrite", $appStatic::PURPOSE_TEMPLATE_CONTENT => userActiveSubscriptionModel($type,appStatic()::OPEN_AI_ARTICLE_MODEL),
            $appStatic::PURPOSE_VISION                          => getSetting($type, appStatic()::GPT_4_TURBO),
            $appStatic::TEXT_EMBEDDING                          => getSetting($type, appStatic()::TEXT_EMBEDDING),
            $appStatic::PURPOSE_VOICE_TO_TEXT                   => getSetting($type, appStatic()::VOICE_2_TEXT_WHISPER),
            $appStatic::DALL_E_2                                => getSetting($type, appStatic()::DALL_E_2),
            $appStatic::DALL_E_3                                => getSetting($type, appStatic()::DALL_E_3),
            $appStatic::SD_TEXT_2_IMAGE, $appStatic::SD_IMAGE_2_IMAGE_PROMPT, $appStatic::SD_TEXT_2_IMAGE_MULTI_PROMPT => getSetting($type, appStatic()::SD_TEXT_2_IMAGE_v10),
            $appStatic::SD_IMAGE_2_IMAGE_UPSCALING              => getSetting($type, appStatic()::SD_UP_SCALE_MODEL),
            $appStatic::SD_IMAGE_2_IMAGE_MASKING                => getSetting($type, appStatic()::SD_IMAGE_2_IMAGE_MASKING_MODEL),
            default                                             => throw new \Exception("API AI Model Not Found"),
        };
    }

    public function configOpenAiTTS(): array
    {
        $request = request();
        return [
            'voice' => $request->voice,
            'speed' => $request->speed,
            'response_format' => $request->response_format,
            'input' => $request->content ?? null,
        ];
    }
    public function configElevenLabsTTS(): array
    {
        $request = request();
        $opts =  [
            'text'                  => $request->content,
            'voice_settings'        => [
                    'stability'         => $request->stability / 100,
                    'similarity_boost'  => $request->similarity_boost / 100,
                    'style'             => $request->style / 100,
                    'use_speaker_boost' => $request->use_speaker_boost == 'on' ? true : false,
            ]
        ];
        return $opts;
    }
    public function configGoogleTTS()
    {
        $text = "<speak>The <say-as interpret-as=\"characters\">SSML</say-as>
                standard <break time=\"1s\"/>is defined by the
                <sub alias=\"World Wide Web Consortium\">W3C</sub>.</speak>";
        $request = request();
        $opts = [
            'input'             => [
                'ssml'          => $text,
            ],
            "voice"             => [
                "languageCode"  => $request->language ?? "en-US",
                "name"          => $request->voice ?? 'en-GB-Standard-A',
                "ssmlGender"    => $request->gender ?? "MALE"
            ],
            "audioConfig"       => [
                "audioEncoding" => "MP3_64_KBPS",
            ]
        ];
        return $opts;
    }
    public function configAzureTTS()
    {
        $request = request();
        $lang    = $request->language ?? 'en-GB';
        $voice   = $request->voice ?? 'en-GB-LibbyNeural';
        $text    = plainText($request->content);
        $text    = preg_replace("/\&/", "&amp;", $text);
        $text    = preg_replace("/(^|(?<=\s))<((?=\s)|$)/i", "&lt;", $text);
        $text    = preg_replace("/(^|(?<=\s))>((?=\s)|$)/i", "&gt;", $text);

        $ssml_text = '<speak version="1.0" xmlns="http://www.w3.org/2001/10/synthesis" xmlns:mstts="http://www.w3.org/2001/mstts"
         xmlns:emo="http://www.w3.org/2009/10/emotionml" xml:lang="' . $lang . '">
         <voice name="' . $voice . '">' . $text . '</voice>
         </speak>';
        return   $ssml_text;
    }

    public static function chatHistory($prompt = '', $type = 'chat'):array
    {
        $chatMessages = ChatThreadMessage::where('chat_thread_id', getChatThreadId())->orderBy('created_at', 'desc')->take(5)->get()->reverse();      
        $messages   = [];

    
        // Checking is the chat thread is not empty
        if($type == 'imageChat') {
            if (!empty($chatMessages)) {             
                foreach ($chatMessages as $key => $chat) {                   
                    if(!empty($chat->response)) {
                        $messages[] = [
                            "role" => "user", 
                            "content" => $chat->title
                        ];                     
                    
                    }
                }
            }else{
                $messages[] = [
                    "role" => "user",
                    "content" => $prompt
                    ];
            }
            $messages[] = ["role" => "user", "content" => $prompt];
            return $messages;
        }

        return $messages;
    }
}
