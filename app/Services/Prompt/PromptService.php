<?php

namespace App\Services\Prompt;

use App\Models\ChatExpert;
use App\Services\Model\PdfService;
use App\Services\Core\AiConfigService;
use Illuminate\Support\Facades\Log;
use App\Traits\File\FileUploadTrait;

/**
 * Class PromptService.
 */
class PromptService
{
    use FileUploadTrait;
    public function codePrompt(){

        return request()->description;
    }

    public function chatPrompt()
    {
        $chatExpert = findById(new ChatExpert(), session(sessionLab()::SESSION_CHAT_EXPERT_ID));

        $expertName = $chatExpert->expert_name;
        $expertRole = $chatExpert->role;
        $userPrompt = request()->message;
        // deepseekAI
        if(isDeepseekAi(aiChatEngine())){
            return sprintf(
                "As %s, an expert in %s, Deliver engaging and context-aware responses. Here’s the question: %s.",
                $expertName,
                $expertRole,
                $userPrompt
            );
        }

        // ClaudeAI
        if(isClaudeAi(aiChatEngine())){
            return sprintf(
                "As %s, an expert in %s, Deliver engaging and context-aware responses. Here’s the question: %s.",
                $expertName,
                $expertRole,
                $userPrompt
            );
        }

        // Gemini
        if(isGeminiAi(aiChatEngine())){
            return sprintf(
                "%s, your persona is %s. Deliver engaging and context-aware responses. Here’s the question: %s",
                ucfirst($expertRole),
                $expertName,
                $userPrompt
            );
        }

        // Open AI
        if(isOpenAiEngine(aiChatEngine())){
            return sprintf(
                "You are %s, an expert in %s. Stay in character and respond only to the question: %s",
                $expertName,
                $expertRole,
                $userPrompt
            );
        }

        return "$expertRole you will now play a character and respond as that character (You will never break character). Your name is $expertName but do not introduce by yourself as well as greetings. Now reply for this question : {$userPrompt}";
    }

    public function aiImagePrompt()
    {
        $expertName  = "AI Image Expert";
        $expertRole  = "image expert";
        $userPrompt  = request()->message;
        $prompt      = "You will now play a character and respond as that character (You will never break character). Your name is $expertName. I want you to act as a $expertRole. As a $expertRole please answer this, $userPrompt. Do not include your name, role in your answer.";
        $history     = AiConfigService::chatHistory($prompt, $type = 'imageChat');
        $history     = json_encode($history);
        $finalPrompt = "Write what does user want to draw at the last moment of chat history. \n\n\nChat History: $history \n\n\n\n Result is 'Draw an image of ... ";
        return $finalPrompt;
    }
    public function pdfPrompt()
    {
        $userPrompt = request()->message;
        $pdfContent = session(sessionLab()::SESSION_PDF_CHAT_PDF_CONTENT);

        info("User Prompt is : $userPrompt");

        info("PDF Content is : $pdfContent");

        return "'this pdf' means pdf content. Do not reference previous chats, when user asking about pdf. Include reference pdf content when user only ask about the pdf. Otherwise response as assistant in short and professional and don't refer the pdf content. \n\n\n User Question: {$userPrompt} \n\n\nPDF content: {$pdfContent}";
    }
    private function pdfContent()
    {
        try {
            $request = request();
            $pdfFile = $request->file("pdfFile");
            $pdfService = new PdfService();
            // $pdfChat = $pdfService->myLatestChat();

            // Step 1 & 2 : Generate a dynamic filename of the uploadble file ex. a1b2c3.pdf & Upload it to the desired folders & return from the trait file with file path location including file name
            $uploadedPdfFile = $this->fileProcess($pdfFile, appStatic()::TEMP_PDF_DIR,false);


            // Step 3 : Parse the PDF file and get the text from it
            $pdfBodyText = $pdfService->getText($uploadedPdfFile);
            $pageBody    = $pdfBodyText;

            // Step 3.1 : Upload it to the S3 if the settings is enabled
           //TODO::S3 Bucket Upload

            if (!mb_check_encoding($pdfBodyText, 'UTF-8')) {
                $pageBody = mb_convert_encoding($pdfBodyText, 'UTF-8', mb_detect_encoding($pdfBodyText));
            }

            // Step 4 : Make embed vector from the parsed text of PDF.
            $pdfBodyEmbed = $pdfService->getEmbeddingData($pdfBodyText);

            #    Log::info("PDF Body  Embedding : ".json_encode($pdfBodyEmbed));

            $isOpenAiRaiseError = isOpenAiRaiseError($pdfBodyEmbed);

           

            // Step 5 : Declare a parameter called $prompt and store user input prompt into $prompt variable
            $prompt = $request->prompt;

            // Step 6 : Make embed vector from the prompt user input.
            $promptEmbed = $pdfService->getEmbeddingData($prompt);

            #  Log::info("Prompt Embedding : ".json_encode($promptEmbed));

            $isOpenAiRaiseError = isOpenAiRaiseError($promptEmbed);


            $getSimilarityScore = $pdfService->getSimilarityScore($pageBody, $promptEmbed, $pdfBodyEmbed);

            #    Log::info("Similarity : ".json_encode($getSimilarityScore));

            $sessionLab = sessionLab();
            $sessionPdfChatPdfContent = $sessionLab::SESSION_PDF_CHAT_PDF_CONTENT;
            session()->put($sessionPdfChatPdfContent, $pageBody);
            session()->save();
            
        }
        catch (\Throwable $e){         

            Log::info("Failed to Embedding PDF and action ".json_encode(errorArray($e)));
            
        }
    }

    public function visionPrompt()
    {

        return request()->message;
    }

    /**
     * Keyword Generator Prompt
     *
     * @throws \JsonException
     */
    public function keywordGeneratorPrompt($request = null)
    {
        $request         = is_null($request) ? request() : $request;
        $lang            = setLang();
        $topic           = setTopic();

        $mainKeywords    = $request->number_of_main_keywords;
        $relatedKeywords = $request->number_of_keywords;
        $tone            = $request->tone;

        return "
            Generate a list of highly relevant main keywords and related keywords based on the topic defined by [[TOPIC]] in [[LANG]] language with tone [[TONE]].
            Main Keywords MUST BE {$mainKeywords} high-impact phrases and each NO LONGER than 6 WORDS, directly tied to the topic. 
            Related keywords MUST BE {$relatedKeywords} supporting phrases that reflect long-tail, specific search intent and related subtopics. 
            Finally, the output should be structured as JSON with the following format and number of main_keywords item MUST be {$mainKeywords} and number of related_keywords item MUST be {$relatedKeywords} : [[RESPONSE_FORMAT]]. Do not add any text or heading with the response format.
            Provide just the generated result in the response format.
            Ensure all keywords are relevant, suitable for article optimization, and aligned with current SEO trends.\n\n

            [[TOPIC]]\n
            {$topic}\n\n

            [[LANG]]\n
            {$lang}\n\n

            [[TONE]]\n
            {$tone}\n\n

            [[RESPONSE_FORMAT]]\n
            {
                \"main_keywords\": [\"Main Key 1\", \"Main Key 2\"],
                \"related_keywords\": [\"Related Key 1\", \"Related Key 2\"]
            }
        ";

    }

    /**
     * Title Generator Prompt
     *
     * @throws \JsonException
     */
    public function titleGeneratorPrompt($request = null)
    {
        $request         = is_null($request) ? request() : $request;

        $numberOfResults = setNumberOfResult();
        $lang            = setLang();
        $topic           = setTopic();
        $mainKeywords    = $request->mainKeywords;
        $relatedKeywords = $request->contentKeywords;
        $numberOfResults = $request->number_of_results;
        $tone            = $request->tone;

        // $prompt = "Generate $numberOfResults seo friendly titles in $lang language based on these topic & keywords. 
        // Topic: $topic, Keywords: $keywords, each titles must be an array element, give the output as an array.here an Examples:['titles']";
        $prompt = "Generate a list of SEO-optimized article titles based on the following inputs:\n
	                Topic: [[TOPIC]]\n\n
	                Main Keywords: [[MAIN_KEYWORDS]]\n\n
	                Related Keywords: [[RELATED_KEYWORDS]]\n\n
	                Language: [[LANG]]\n\n
	                Number of Titles: [[NO_OF_TITLE]]\n\n
	                Tone: [[TONE]]\n\n

        The titles MUST incorporate the [[MAIN_KEYWORDS]] at the beginning. Title length maximum of 67 characters and generate EXACT {$numberOfResults} title. Provide the output in the following JSON format: \n[[RESPONSE_FORMAT]].  Do not add any text or heading with the response format. Provide just the generated result in the response format.\n\n
        [[TOPIC]]\n
        {$topic}\n\n

        [[LANG]]\n
        {$lang}\n\n

        [[MAIN_KEYWORDS]]\n
        {$mainKeywords}\n\n

        [[RELATED_KEYWORDS]]\n
        {$relatedKeywords}\n\n

        [[NO_OF_TITLE]]\n
        {$numberOfResults}\n\n
        
        [[TONE]]\n
        {$tone}\n\n

        [[RESPONSE_FORMAT]]\n
        {
            \"titles\": [
                \"Title 1\",
                \"Title 2\",
                \"Title 3\", 
                \"... up to the number of titles requested\"
            ]
        }
        ";

        return $prompt;
    }

    public function metaDescriptionGeneratorPrompt($request = null)
    {
        $numberOfResults = setNumberOfResult();
        $lang            = setLang();
        $topic           = setTopic();

        $request         = is_null($request) ? request() : $request;
        $mainKeywords    = $request->mainKeywords;
        $relatedKeywords = $request->contentKeywords;
        $contentTitle    = $request->title;
        $tone            = $request->tone;

        $prompt = "Generate a list of SEO-optimized article meta description based on the following inputs:\n\n
	                Topic: [[TOPIC]]\n\n
	                Main Keywords: [[MAIN_KEYWORDS]]\n\n
	                Related Keywords: [[RELATED_KEYWORDS]]\n\n
	                Article Title: [[TITLE]]\n\n
	                Number of Meta Description: [[NO_OF_META]]\n\n
	                Tone: [[TONE]]\n\n
	                Language: [[LANG]]\n\n
                    SEO Requirements:
                        - Include [[MAIN_KEYWORDS]] at beginning of meta description
                        - Front-load important keywords based on [[MAIN_KEYWORDS]] and [[RELATED_KEYWORDS]] keywords
                        \n\n

                    Generate EXACT {$numberOfResults} meta description and meta description length MUST be Minimum 70 characters and Maximum 160 characters. Provide the output in the following JSON format:\n [[RESPONSE_FORMAT]].  Do not add any text or heading with the response format. Provide just the generated result in the response format.\n\n

                    [[TOPIC]]\n
                    {$topic}\n\n

                    [[MAIN_KEYWORDS]]\n
                    {$mainKeywords}\n\n

                    [[RELATED_KEYWORDS]]\n
                    {$relatedKeywords}\n\n

                    [[LANG]]\n
                    {$lang}\n\n

                    [[TITLE]]\n
                    {$contentTitle}\n\n

                    [[NO_OF_META]]\n
                    {$numberOfResults}\n\n
                    
                    [[TONE]]\n
                    {$tone}\n\n
                    
                    [[RESPONSE_FORMAT]]\n
                    {
                        \"meta_description\": [
                            \"Meta Description 1\",
                            \"Meta Description 2\",
                            \"Meta Description 3\",
                            \"... up to the number of meta description requested\"
                        ]
                    }
            ";

        return $prompt;

//         return <<<EOT
//                 Create an SEO-optimized meta description for an article with the following title: "{$title}"

//                 SEO Requirements:
//                 - Include primary keyword naturally (from title)
//                 - Front-load important keywords
//                 - Include a clear value proposition
//                 - Add a compelling call-to-action
//                 - Use active voice
//                 - Avoid keyword stuffing
//                 - Make it click-worthy without being clickbait

//                 Technical Constraints:
//                 - Minimum 70 characters
//                 - Maximum 160 characters
//                 - Must be a single sentence or two short sentences
//                 - Must be readable,scannable and latest SEO-friendly

//                 Target audience: Technical professionals and developers
//                 Tone: Professional but engaging

//                 Format the response as a single line with just the meta description text.
// EOT;

        // return "Generate $numberOfResults seo friendly meta description in $lang language based on these title. Title: $title, each meta-description must be an array element, give the output as an array.here an Examples:['meta description']";
    }

    /**
     * Topic Generator Prompt
     * */
    public function topicGeneratorPrompt()
    {

    }

    /**
     * Outline Generator Prompt
     * */
    public function outlineGeneratorPrompt($request = null, $platform = null): string
    {
        wLog(
            "PromptService.php outlineGeneratorPrompt method Incoming Platform : {$platform}",
            ["platform" => $platform],
            logService()::LOG_OPEN_AI
        );

        $numberOfResults = setNumberOfResult();
        $lang            = setLang();
        $topic           = setTopic();

        $request         = is_null($request) ? request() : $request;
        $mainKeywords    = $request->mainKeywords;
        $relatedKeywords = $request->contentKeywords;
        $contentTitle    = $request->title;
        $metaDescription = $request->metaDescription;
        $tone            = $request->tone;

        if(isGeminiAi($platform)) {
            $responseFormat = "
            [
                {   
                    \"outline\": [
                        {
                            \"section\": \"Introduction\",
                            \"details\": \"Engaging opening explaining the value of the article.\"
                        },
                        {
                            \"section\": \"Main Section 1\",
                            \"details\": \"Detailed content for the first main section, enriched with relevant keywords.\"
                        },
                        {
                            \"section\": \"Main Section 2\",
                            \"details\": \"Further elaboration on the topic with more actionable advice.\"
                        },
                        {
                            \"section\": \"Main Section 3\",
                            \"details\": \"More in-depth explanation with examples or case studies.\"
                        },
                        {
                            \"section\": \"Main Section 4\",
                            \"details\": \"Final insights or tips for the reader to apply the information.\"
                        },
                        {
                            \"section\": \"Conclusion\",
                            \"details\": \"Summary and final call-to-action.\"
                        }
                    ]
                }, 
                {
                    \"outline\": [
                        {
                            \"section\": \"Introduction\",
                            \"details\": \"Engaging opening explaining the value of the article.\"
                        },
                        {
                            \"section\": \"Main Section 1\",
                            \"details\": \"Detailed content for the first main section, enriched with relevant keywords.\"
                        },
                        {
                            \"section\": \"Main Section 2\",
                            \"details\": \"Further elaboration on the topic with more actionable advice.\"
                        },
                        {
                            \"section\": \"Main Section 3\",
                            \"details\": \"More in-depth explanation with examples or case studies.\"
                        },
                        {
                            \"section\": \"Main Section 4\",
                            \"details\": \"Final insights or tips for the reader to apply the information.\"
                        },
                        {
                            \"section\": \"Conclusion\",
                            \"details\": \"Summary and final call-to-action.\"
                        }
                    ]
                } 
            ]
            ";

            wLog("Gemini | ".aiEngine()." = Response Format",["responseFormat" => $responseFormat], logService()::LOG_OPEN_AI);
        }
        else {
            $responseFormat = "
            {
                \"outline\": [
                    {
                        \"section\": \"Introduction\",
                        \"details\": \"Engaging opening explaining the value of the article.\"
                    },
                    {
                        \"section\": \"Main Section 1\",
                        \"details\": \"Detailed content for the first main section, enriched with relevant keywords.\"
                    },
                    {
                        \"section\": \"Main Section 2\",
                        \"details\": \"Further elaboration on the topic with more actionable advice.\"
                    },
                    {
                        \"section\": \"Main Section 3\",
                        \"details\": \"More in-depth explanation with examples or case studies.\"
                    },
                    {
                        \"section\": \"Main Section 4\",
                        \"details\": \"Final insights or tips for the reader to apply the information.\"
                    },
                    {
                        \"section\": \"Conclusion\",
                        \"details\": \"Summary and final call-to-action.\"
                    }
                ]
            },
            ";
        }

        // $sampleOutput =  
        // $prompt = "Generate section headings only to write a blog in $lang language based on these title & keywords. 
        // Title: $title, Keywords: $keywords, each section headings must be an array element, 
        // give the output as an array not json";
        $prompt = "
            Generate JSON-formatted, SEO-friendly article outlines based on these inputs:\n
                - Topic: {$topic}\n
                - Main Keywords: {$mainKeywords}\n
                - Related Keywords: {$relatedKeywords}\n
                - Title: {$contentTitle}\n
                - Language: {$lang}\n
                - Tone: {$tone}\n

            Structure:\n
                1.	Introduction: Brief summary of the article and its value.\n
                2.	H2 Sections: MUST contain the [[MAIN_KEYWORDS]] in the headings and generate around 10 to 12 heading.\n
                3.	Conclusion: Summarize key takeaways and add a call-to-action.\n\n

            Output Format: 
            Generate EXACT {$numberOfResults} outline. Strictly follow below json array structure and remove ```JSON and ``` from the response if exist. Output MUST BE valid JSON Format: \n
            {$responseFormat}.  Do not add any text or heading with the response format. Provide just the generated result in the response format.\n\n
        ";

        return $prompt;
    }

    /**
     * PDF Describe Prompt
     * */
    public function pdfDescribePrompt()
    {

    }

    /**
     * Code Generator Prompt
     * */
    public function codeGeneratorPrompt()
    {
        return request()->description ?? "Generate code based on this description. Description: Write a conditional program in JS";
    }

    /**
     * Article Generator Prompt
     *
     * @throws \JsonException
     */
    public function articleGeneratorPrompt($request = null)
    {        
        $request          = is_null($request) ? request() : $request;
        $mainKeywords     = $request->focus_keyword;
        $relatedKeywords  = $request->keywords;
        $contentTitle     = $request->title;
        $metaDescription  = $request->meta_description;
        $selected_outline = !empty($request->outlines) ? implode(",", $request->outlines) : NULL;
        $tone             = $request->tone;
        $maxArticleLength = $this->getArticleMaxLength($request->maxArticleLength);
        $lang             = setLang();

        // return "Write an Article in " . $lang . " language. Generate article (NB: Must not contain title) about " . $title . " and use the meta description: " . $metaDescription . " to make this with SEO Friendly. Generate the article with keywords: " . $keywords . " with following outline: " . $promptOutlines . ". Do not add other headings or write more than the specific headings. Give the heading output in bold font & Heading with html tag like h1";
        $prompt = "
        Write a {$maxArticleLength} words blog post on the topic defined by blog title [[TITLE]] and MAIN KEYWORD [[MAIN_KEYWORDS]] in [[LANG]] language with [[TONE]] tone.\n
        - MUST Start with catchy H1 using keywords from the [[MAIN_KEYWORDS]] list at the beginning, and under H1 add a short summary of the subject and explain why article is worth reading.\n
        - Secondly, prepare article outline with around 10 H2 subheaders enriched with keywords from the [[OUTLINE]] list, a lot of them should be questions. \n
        - MUST include the [MAIN_KEYWORDS]] at the beginning of the H2 title. \n
        - MUST have external links at least 2 in the content.\n
        - Thirdly, for each H2 subheader, add two or three paragraphs with detailed explanation for specific subheader. \n
        - Paragraphs must include terms from the [[MAIN_KEYWORDS]] and [[RELATED_KEYWORDS]] list. \n
        - MUST have the [[META_DESCRIPTION]] in the content.\n
        - Article length MUT BE {$maxArticleLength} words without HTML Code.\n
        Close article with bullet point summary of most important things to remember. \n\n
        The response MUST BE in HTML format, NOT markdown response. Remove 'html', 'head', 'body' tags and ```html and ``` from response. Do not add any additional text or heading or title like here is the blog post - with the generated content you will generate.\n\n

        [[MAIN_KEYWORDS]]\n
        {$mainKeywords}\n\n

        [[RELATED_KEYWORDS]]\n
        {$relatedKeywords}\n\n

        [[LANG]]\n
        {$lang}\n\n

        [[TITLE]]\n
        {$contentTitle}\n\n
       
        [[META_DESCRIPTION]]\n
        {$metaDescription}\n\n

        [[OUTLINE]]\n
        {$selected_outline}\n\n
        
        [[TONE]]\n
        {$tone}\n\n
        ";

        return $prompt;
    }

    public function getArticleMaxLength($type)
    {
        return appStatic()::ARTICLE_MAX_LENGTH_WORDS_TYPES[$type] ?? appStatic()::MEDIUM_ARTICLE_MAX_LENGTH_WORDS;
    }

    /**
     * generate text
     */
    public function generateText()
    {
        $request = request();
        $prompt  = $request->prompt;

        if(isUseGeminiAiEngine() || isUseClaudeAiEngine() || isUseDeepseekAiEngine()){
            return $prompt.' and given text must be avoid spacial character like (*) and not include any html character';
        }

        $prompt = strip_tags($prompt) . ' in ' . $request->language . ' language ' . strip_tags($prompt);

        if ($request->max_tokens != -1) {
            $prompt              .= ' .The tone of voice should be ' . $request->tone . ' and the output must be completed in ' . $request->max_tokens . ' words. Do not generate translation.';
        }
        else {
            $prompt              .= ' .The tone of voice should be ' . $request->tone . '. Do not generate translation.';
        }

        return $prompt;
    }

    // Template Prompt
    public function templateContentPrompt()
    {
        $prompt = $this->plainPrompt();
        if(isUseGeminiAiEngine() || isUseClaudeAiEngine() || isUseDeepseekAiEngine()) return $prompt;
        $request                  = request();
        $prompt                   = strip_tags($prompt) . ' in ' . $request->language . ' language ' . strip_tags($prompt);
        if (!empty($request->max_tokens) && $request->max_tokens != -1) {
            $prompt              .= ' .The tone of voice should be ' . $request->tone . ' and the output must be completed in ' . $request->max_tokens . ' words. Do not generate translation.';
        } else {
            $prompt              .= ' .The tone of voice should be ' . $request->tone . '. Do not generate translation.';
        }
        return $prompt;
    }
    // aiAssistantContentPrompt Prompt
    public function aiAssistantContentPrompt()
    {
        $request  = request();
        $prompt   = $request->prompt;
        if(isUseGeminiAiEngine() || isUseClaudeAiEngine() || isUseDeepseekAiEngine()) return $prompt;
        $request                  = request();
        $prompt                   = strip_tags($prompt) . ' in ' . $request->language . ' language.';
        if (!empty($request->max_tokens) && $request->max_tokens != -1) {
            $prompt              .= ' .The tone of voice should be ' . $request->tone . ' and the output must be completed in ' . $request->max_tokens . ' words. Do not generate translation.';
        } else {
            $prompt              .= ' .The tone of voice should be ' . $request->tone . '. Do not generate translation.';
        }
        return $prompt;
    }

    
    // socialPostPrompt Prompt
    public function socialPostPrompt()
    {
        $request  = request();
        $prompt   = $request->prompt;
        $prompt   = 'Generate a social media post article for ' . $request->platform_name. ' platform based on this content: ``' . $prompt .'``'.
                    ' . The social media post should be engaging and relevant to the platform audience. Make it as elaborate as possible. but if the platform is Twitter, the post must be completed within 280 characters including white spaces. Do not include any additional text like `here is your..` or `any heading`.';
        if(isUseGeminiAiEngine() || isUseClaudeAiEngine() || isUseDeepseekAiEngine()) return $prompt;
        $request                  = request();
        $prompt                   = strip_tags($prompt) . ' in ' . $request->language . ' language.';
        if (!empty($request->max_tokens) && $request->max_tokens != -1) {
            $prompt              .= ' .The tone of voice should be ' . $request->tone . ' and the output must be completed in ' . $request->max_tokens . ' words. Do not generate translation.';
        } else {
            $prompt              .= ' .The tone of voice should be ' . $request->tone . '. Do not generate translation.';
        }
        return $prompt;
    }
    // Template Prompt
    public function plainPrompt()
    {
        $request  = request();
        $searches = json_decode($request->field_names);
        $replaces = [];
        if(!empty($searches)) {
            foreach($searches as $name){
                $name = str_replace(['{_', '_}'], '', $name);
                $replaces[] = $request->$name;
            }
        }
        
        $prompt      = $request->prompt;
        $finalPrompt = str_replace($searches, $replaces, $prompt);

        return $finalPrompt;
    }

    /**
     * @throws \JsonException
     */
    public function dallE2Prompt()
    {
        if(request()->ai_image_prompt){
            return  request()->ai_image_prompt;
        }

        $title = setTitle();
        $style = setStyle();
        $mood = setMood();

        return (string)($title);
    }

    public function dallE3Prompt()
    {
        if(request()->ai_image_prompt){
            return  request()->ai_image_prompt;
        }
        $title = request()->title ?? "Generate a image";
        $style = request()->style ?? "Style: Write a image of a $title";
        $mood = request()->mood ?? "Happy";
        $lighting = request()->lighting_style ?? "cinematic lighting";

        return "{$title}, Style: {$style}, Mood: {$mood}, Lighting Style: {$lighting}.";
    }

    public function sdText2ImagePrompt()
    {
        $title = setTitle();
        $style = setStyle();
        $mood = setMood();
        $lighting = setLighting();

        return "{$title}, Style: {$style}, Mood: {$mood}, Lighting Style: {$lighting}.";
    }

    public function sdText2ImageMultiPrompt()
    {
        $title = setTitle()[0];
        $style = setStyle();
        $mood = setMood();
        $lighting = setLighting();

        return "{$title}, Style: {$style}, Mood: {$mood}, Lighting Style: {$lighting}.";
    }

    public function sdImage2ImagePrompt()
    {
        $title = setTitle();
        $style = setStyle();
        $mood = setMood();
        $lighting = setLighting();

        return "{$title}, Style: {$style}, Mood: {$mood}, Lighting Style: {$lighting}.";
    }

    /**
     * @throws \JsonException
     */
    public function setPrompt(string $contentPurpose, $platform = null)
    {

        return match ($contentPurpose) {
            appStatic()::PURPOSE_VISION               => $this->visionPrompt(),
            appStatic()::PURPOSE_GENERATE_TEXT        => $this->generateText(),
            appStatic()::PURPOSE_CHAT                 => $this->chatPrompt(),
            appStatic()::PURPOSE_AI_IMAGE             => $this->aiImagePrompt(),
            appStatic()::PURPOSE_PDF                  => $this->pdfPrompt(),
            appStatic()::PURPOSE_CODE                 => $this->codePrompt(),
            appStatic()::PURPOSE_TOPIC                => $this->topicGeneratorPrompt(),
            appStatic()::PURPOSE_KEYWORD              => $this->keywordGeneratorPrompt(),
            appStatic()::PURPOSE_TITLE                => $this->titleGeneratorPrompt(),
            appStatic()::PURPOSE_META_DESCRIPTION     => $this->metaDescriptionGeneratorPrompt(),
            appStatic()::PURPOSE_OUTLINE              => $this->outlineGeneratorPrompt(null, $platform),
            appStatic()::PURPOSE_ARTICLE              => $this->articleGeneratorPrompt(null, $platform),
            appStatic()::DALL_E_2                     => $this->dallE2Prompt(),
            appStatic()::DALL_E_3                     => $this->dallE3Prompt(),
            appStatic()::SD_TEXT_2_IMAGE              => $this->sdText2ImagePrompt(),
            appStatic()::SD_TEXT_2_IMAGE_MULTI_PROMPT => $this->sdText2ImageMultiPrompt(),
            appStatic()::SD_IMAGE_2_IMAGE_PROMPT,
            appStatic()::SD_IMAGE_2_IMAGE_MASKING,
            appStatic()::SD_IMAGE_2_IMAGE_UPSCALING    => $this->sdImage2ImagePrompt(),
            appStatic()::PURPOSE_TEMPLATE_CONTENT     => $this->templateContentPrompt(),
            appStatic()::SD_IMAGE_2_VIDEO              => $this->sdImage2ImagePrompt(),
            appStatic()::PURPOSE_AI_ASSISTANT_CONTENT   => $this->aiAssistantContentPrompt(),
            appStatic()::PURPOSE_SOCIAL_POST_GENERATION => $this->socialPostPrompt(),
            default => throw new \Exception("Prompt Not Found", 400),
        };
    }
}
