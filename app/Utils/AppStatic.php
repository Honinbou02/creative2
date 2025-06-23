<?php

namespace App\Utils;

class AppStatic
{
    CONST WRITE_RAP_LICENSE_URL = "https://client.themetags.net/";
    const DS              = DIRECTORY_SEPARATOR;
    const TRUE            = true;
    const FALSE           = false;
    const TYPE_FLAT       = 1;
    const TYPE_PERCENTAGE = 2;

    const IS_WP_SYNC      = 1;
    const ACTIVE          = 1;
    const EXPIRED         = 1;
    const IS_FOCUS_KEYWORD   = 1;

    # table data status
    public const STATUS_ARR = [
        1 => 'Active',
        0 => 'Disable',
    ];

    CONST NEW_POST = 2;
    const EXISTING_POST = 1;
    const REWRITE_TYPES = [
        'rewrite'            => 'Re-Write',
        'summarize'          => 'Summarize',
        'make_it_longer'     => "Make it longer",
        'make_it_shorter'    => 'Make It Shorter',
        'improve_writing'    => 'Improve Writing',
        'grammar_correction' => 'Grammatical Improvement'
    ];

    # Event Error Detection
    const TT_ERROR = "[TT_ERROR]";


    #Affiliation Module
    public const AFFILIATE_EARNING_ONE_TIME  = 0;
    public const AFFILIATE_EARNING_LIFE_TIME  = 1;

    const maxUpdateFile  = -5;

    # CURL Center
    const CURL_RESPONSE_BODY                        = 1;
    const CURL_RESPONSE_CODE                        = 2;
    const CURL_RESPONSE_HEADER                      = 3;
    const CURL_RESPONSE_CODE_WITH_BODY              = 4;
    const CURL_RESPONSE_CODE_WITH_BODY_AND_HEADERS  = 5;

    # subscription plan status
    const PLAN_STATUS_ACTIVE     = 1;
    const PLAN_STATUS_EXPIRE     = 2;
    const PLAN_STATUS_SUBSCRIBED = 3;
    const PLAN_STATUS_PENDING    = 4;
    const PLAN_STATUS_REJECTED   = 5;
    const PLAN_PURCHASE_LIMIT    = 1;
    CONST SPEECH_2_TEXT_FILE_SIZE_LIMIT = 1;

    public const SUBSCRIPTION_STATUS_ACTIVE     = 1;
    public const SUBSCRIPTION_STATUS_EXPIRED    = 2;
    public const SUBSCRIPTION_STATUS_SUBSCRIBED = 3;
    public const SUBSCRIPTION_STATUS_PENDING    = 4;

    public const SUBSCRIPTION_STATUS_ARR = [
        self::SUBSCRIPTION_STATUS_ACTIVE  => "Active",
        self::SUBSCRIPTION_STATUS_EXPIRED => "Expired",
    ];

    # Package Type
    const PACKAGE_TYPE_STARTER  = 'starter';
    const PACKAGE_TYPE_MONTHLY  = 'monthly';
    const PACKAGE_TYPE_YEARLY   = 'yearly';
    const PACKAGE_TYPE_LIFETIME = 'lifetime';
    const PACKAGE_TYPE_PREPAID  = 'prepaid';

    const PACKAGE_TYPE_ARR = [
      self::PACKAGE_TYPE_MONTHLY  => self::PACKAGE_TYPE_MONTHLY,
      self::PACKAGE_TYPE_YEARLY   => self::PACKAGE_TYPE_YEARLY,
      self::PACKAGE_TYPE_LIFETIME => self::PACKAGE_TYPE_LIFETIME,
      self::PACKAGE_TYPE_PREPAID => self::PACKAGE_TYPE_PREPAID,
    ];

    # payment status
    const PAYMENT_STATUS_PAID     = 1;
    const PAYMENT_STATUS_PENDING  = 2;
    const PAYMENT_STATUS_REJECTED = 3;
    const PAYMENT_STATUS_RESUBMIT = 4;

    # plan type status
    const PLAN_TYPE_STARTER  = 'starter';
    const PLAN_TYPE_MONTHLY  = 'monthly';
    const PLAN_TYPE_YEARLY   = 'yearly';
    const PLAN_TYPE_LIFETIME = 'lifetime';                  
    const PLAN_TYPE_PREPAID  = 'prepaid';

    const OFFLINE_PAYMENT_METHOD =  'offline';
    # Request Response Codes
    public const SUCCESS            = 200;
    public const SUCCESS_WITH_DATA  = 201;
    public const VALIDATION_ERROR   = 400;
    public const NOT_FOUND          = 404;
    public const UNAUTHORIZED        = 401;
    public const UNAUTHORIZED_ACTION = 401;

    public const LENGTH_ERROR       = 411;
    public const INTERNAL_ERROR     = 500;
    public const INVALID            = 525;
    public const DUPLICATE_CODE     = 23000;
    public const OPEN_AI_ERROR_CODE = 505;
    public const BALANCE_ERROR      = 400;

    public const RESPONSE_STATUS   = [
        200 => ['status' => true,   'response_code' => 200],
        201 => ['status' => true,   'response_code' => 201],
        400 => ['status' => false,  'response_code' => 400],
        401 => ['status' => false,  'response_code' => 401],
        404 => ['status' => false,  'response_code' => 404],
        411 => ['status' => false,  'response_code' => 411],
        500 => ['status' => false,  'response_code' => 500],
    ];

    public const INPUT_TYPES   = [
        'text'     => 'Text',
        'textarea' => 'Textarea'
    ];


    #Login Center
    public const MESSAGE_WELCOME_BACK           = "Welcome Back!";
    public const MESSAGE_SUCCESS_LOGOUT         = "Aww! Logout. We are waiting for you ;) Come back soon!.";
    public const MESSAGE_INVALID                = "Invalid Information!";
    public const MESSAGE_PROFILE                = "Authorized user Data";
    public const MESSAGE_UNAUTHORISED           = "Opps! You are not authorized, please Login first.";
    public const MESSAGE_DELETE                 = "Deleted! A Record successfully deleted";
    public const MESSAGE_STORE                  = "A Record has been successfully stored.";
    public const MESSAGE_UPDATE                 = "A Record has been successfully updated.";
    public const MESSAGE_DELETE_SUCCESS_POP_UP  = "Deleted!";
    public const MESSAGE_ACTION_FAILED          = "Sorry, Can't complete the action.";
    public const MESSAGE_EXPIRED                = "Sorry, It's already expired";
    public const MESSAGE_TICKET_CLOSED          = "Sorry, This ticket has already been closed.";
    public const MESSAGE_KEYWORD_GENERATED      = "Successfully New Keywords content generated.";
    public const MESSAGE_TITLE_GENERATED        = "Successfully New Titles content generated.";
    public const MESSAGE_OUTLINE_GENERATED      = "Successfully New Outlines content generated.";
    public const MESSAGE_ARTICLE_GENERATED      = "Successfully New Article content generated.";
    public const MESSAGE_CODE_GENERATED         = "Successfully New Code content generated.";
    public const MESSAGE_IMAGE_GENERATED        = "Successfully AI image generated.";
    public const MODEL_NOT_FOUND_MESSAGE        = "Not Found Exception!";
    public const MESSAGE_UNAUTHORIZED           = "Sorry! You are not authorized to perform this action.";
    public const MESSAGE_NO_WORD_BALANCE        = "Sorry! You don't have enough word balance remaining.";



    #Exceptions Center
    public const METHOD_NOT_ALLOWED             = "Method Not Allowed Http Exception Found";
    public const MESSAGE_DUPLICATE_ENTRY        = "The record  :attribute could not be inserted because a duplicate already exists.";

    #Envato Exceptions
    public const MESSAGE_INVALID_ENVATO_TOKEN   = "The personal token is missing the required permission for this script";
    public const MESSAGE_DELETED_ENVATO_TOKEN   = "The personal token is invalid or has been deleted";
    public const MESSAGE_INVALID_PURCHASE_CODE  = "Invalid purchase code";
    public const MESSAGE_VALID_PURCHASE_CODE    = "Valid purchase code";

    # Messages Center
    public const ORDER_PENDING_NOTE     = "Sir/Madam, We received a order from you. Currently our team is working with your order, We will update you soon. Thank you.";

    public const MESSAGE_STATUS_UPDATE         = "A record status has been successfully updated";
    public const MESSAGE_STATUS_WARNING        = "You are not authorize to update this record";

    # USER TYPES
    public const USER_TYPES = [
        1 => 'Super Admin',
        2 => 'Admin Staff',
        3 => 'Customer',
        4 => 'Customer Team'
    ];

    const TYPE_ADMIN          = 1;
    const TYPE_ADMIN_STAFF    = 2;
    const TYPE_CUSTOMER       = 3;
    const TYPE_CUSTOMER_TEAM  = 4;

    public const TICKET_STATUS_INSIDE   = "0 = Open, 1 = Completed/Closed, 2 = In-progress, 3 = Assigned, 4 = On-Hold, 5 = Solved, 6=Re-opened.";
    public const ACCOUNT_STATUS_INSIDE  = "0 = De-active, 1 = Active, 2 = Pending, 3 = Suspended.";
    public const ACTIVE_STATUS_INSIDE   = "0 = In-active, 1 = Active.";

    # Pagination setting
    public const PER_PAGE_DEFAULT   = 10;
    public const PER_PAGE_ARR       = [25, 50, 100, 200, 500];

    /**
     * OPEN AI MODELS START
     * */

    public const ENGINE_OPEN_AI                 = "openai";
    public const ENGINE_GEMINI_AI               = "geminiai";
    public const ENGINE_GOWINSTON_AI            = "gowinstonai";
    public const ENGINE_AZURE                   = "azure";
    public const ENGINE_GOOGLE_TTS              = "google";
    public const ENGINE_STABLE_DIFFUSION        = "stable_diffusion"; // 4
    public const ENGINE_ELEVEN_LAB              = "elevenLabs"; // 5
    public const ENGINE_CLIPDROP                = "clipdrop"; // 6
    public const ENGINE_PEBBLELY                = "pebblely"; // 7
    public const ENGINE_CLAUDE_AI               = "claudeai"; // 8
    public const ENGINE_DEEPSEEK_AI             = "deepseekai"; // 9



    #Models
    public const GPT_4_TURBO                = "gpt-4o";
    public const GPT_4_VISION_PREVIEW_TURBO = "gpt-4-vision-preview";
    public const GPT_3_5_TURBO              = "gpt-3.5-turbo";
    public const GPT_3_5_TURBO_16K          = "gpt-3.5-turbo-16k";
    public const DALL_E_2                   = "dall-e-2";
    public const DALL_E_3                   = "dall-e-3";
    public const TEXT_EMBEDDING             = "text-embedding-ada-002";
    public const VOICE_2_TEXT_WHISPER       = "whisper-1";

    public const SD_TEXT_2_IMAGE              = "sd-text-2-image";
    public const SD_IMAGE_2_IMAGE_PROMPT      = "sd-image-2-image-prompt";
    public const SD_IMAGE_2_IMAGE_MASKING     = "sd-image-2-image-masking";
    public const SD_TEXT_2_IMAGE_MULTI_PROMPT = "sd-image-2-image-multi-prompt";
    public const SD_IMAGE_2_IMAGE_UPSCALING   = "sd-image-2-image-upscalling";
    public const SD_IMAGE_2_VIDEO             = "sd-image-2-video";
    public const SD_TEXT_2_IMAGE_v16          = "stable-diffusion-v1-6";
    public const SD_TEXT_2_IMAGE_v10          = "stable-diffusion-xl-1024-v1-0";
    public const DEFAULT_CLAUDE_AI_MODEL      = 'claude-3-opus-20240229';
    public const DEFAULT_DEEPSEEK_AI_MODEL    = 'deepseek-chat';
    public const OPEN_AI_CHAT_MODEL           = self::GPT_3_5_TURBO;
    public const OPEN_AI_ARTICLE_MODEL        = self::GPT_3_5_TURBO;
    public const OPEN_AI_CODE_MODEL           = self::GPT_3_5_TURBO;
    public const OPEN_AI_DALL_E_2_MODEL       = self::DALL_E_2;
    public const OPEN_AI_DALL_E_3_MODEL       = self::DALL_E_3;
    public const SD_TEXT_2_IMAGE_MODEL        = self::SD_TEXT_2_IMAGE_v16;
    public const SD_UP_SCALE_MODEL            = "fast";
    public const SD_IMAGE_2_IMAGE_MASKING_MODEL  = self::SD_TEXT_2_IMAGE_v10;
    public const OPEN_AI_TTS_1                = "tts-1";
    public const OPEN_AI_TTS_1_HD             = "tts-1-hd";
    public const   OPEN_AI_TONE               = [
                                                'Friendly'     => 'Friendly',
                                                'Luxury'       => 'Luxury',
                                                'Relaxed'      => 'Relaxed',
                                                'Professional' => 'Professional',
                                                'Casual'       => 'Casual',
                                                'Excited'      => 'Excited',
                                                'Bold'         => 'Bold',
                                                'Masculine'    => 'Masculine',
                                                'Dramatic'     => 'Dramatic',
                                            ];
    public const OPEN_AI_CREATIVITY          = [
                                                '1'   => 'High',
                                                '0.5' => 'Medium',
                                                '0'   => 'Low'
                                            ];
    /**
     * OPEN AI MODELS END
     * */

    const DALL_E_2_RESOULATIONS = [
        "256x256",
        "512x512",
        "1024x1024",
    ];

    const ART_STYLES = [
        'none',
        '3d_render',
        'anime',
        'abstract',
        'ballpoint_pen',
        'bauhaus',
        'baroque',
        'cartoon',
        'conceptual',
        'clay',
        'contemporary',
        'cubism',
        'cyberpunk',
        'digital',
        'expressionism',
        'fauvism',
        'graffiti',
        'glitchcore',
        'impressionism',
        'hyperrealism',
        'minimalism',
        'pop_art',
        'realism',
        'surrealism',
        'watercolor'
    ];

    const DALL_E_3_RESOULATIONS = [
        "1024x1024",
        "1792x1024",
        "1024x1792"
    ];

    const SD_TEXT_2_IMAGE_RESOULATIONS = [
        "1024x1024",
        "1152x896",
        "896x1152",
        "1216x832",
        "1344x768",
        "768x1344",
        "1536x640",
        "640x1536",
    ];

    const SD_STYLES = [
        "3d-model",
        "analog-film",
        "anime",
        "cinematic",
        "comic-book",
        "digital-art",
        "enhance",
        "fantasy-art",
        "isometric",
        "line-art",
        "low-poly",
        "modeling-compound",
        "neon-punk",
        "origami",
        "photographic",
        "pixel-art",
        "tile-texture"
    ];


    const MODE_TYPES = [
        "Neutral",
        "Calm",
        "Cheerful",
        "Angry",
        "Aggressive",
        "Dark",
        "Boring",
        "Bright",
        "Chilling"
    ];


    const LIGHTING_STYLE_TYPES = [
        'Astral',
        'Azure',
        'Alpenglow',
        'Ambient',
        'Backlight',
        'Boreal',
        'Brilliant',
        'Balmy',
        'Blue Hour',
        'Cinematic',
        'Candlelit',
        'Crisp',
        'Celestial',
        'Cold',
        'Dusky',
        'Daylight',
        'Dawn',
        'Dramatic',
        'Foggy',
        'Golden Hour',
        'Hard',
        'Natural',
        'Neon',
        'Studio',
        'Warm',
        'Soft',
        'Diffused',
        'Bright',
        'Shadowy',
        'Sunny',
        'Overcast',
        'Twilight',
        'Gloomy',
        'Vibrant',
        'Muted',
        'Glossy',
        'Matte',
        'High Contrast',
        'Low Contrast',
    ];

    const SD_CLIP_GUIDANCE_PRESET = [
        "NONE",
        "FAST_BLUE",
        "FAST_GREEN",
        "SIMPLE",
        "SLOW",
        "SLOWER",
        "SLOWEST"
    ];

    const OPEN_AI_DEFAULT_RESOULATION = "1024x1024";

    /**
     * Model Purposes Start
     * */
    public const PURPOSE_CHAT               = "chat";
    public const PURPOSE_GENERATE_TEXT      = "generateText";
    public const PURPOSE_TEMPLATE_CONTENT   = "templateContents";
    public const PURPOSE_VISION             = "vision";
    public const PURPOSE_PDF                = "pdf";
    public const PURPOSE_TOPIC              = "topic";
    public const PURPOSE_KEYWORD            = "keywords";
    public const PURPOSE_TITLE              = "titles";
    public const PURPOSE_META_DESCRIPTION   = "meta_descriptions";
    public const PURPOSE_CONTENT            = "contents";
    public const PURPOSE_OUTLINE            = "outlines";
    public const PURPOSE_CODE               = "code";
    public const PURPOSE_ARTICLE            = "articles";
    public const PURPOSE_IMAGE              = "image";
    public const PURPOSE_VIDEO              = "video";
    public const PURPOSE_AI_IMAGE           = "aiImage";
    public const PURPOSE_TEXT_TO_VOICE      = "text2voice";
    public const PURPOSE_VOICE_TO_TEXT      = "voice2text";
    public const PURPOSE_VOICE_CLONE        = "voiceClone";
    public const PURPOSE_CONTENT_PLAGIARISM = "contentPlagiarism";
    public const PURPOSE_CONTENT_DETECTOR   = "contentDetector";
    public const PURPOSE_REIMAGINE          = "reimagine";
    public const PURPOSE_BACKGROUND_CHANGE  = "createBackground"; 
    // social pilot
    public const PURPOSE_AI_ASSISTANT_CONTENT   = "aiAssistant";
    public const PURPOSE_SOCIAL_POST_GENERATION = "socialPost";

    public const PURPOSE_SOCIAL_ACCOUNT         = "createSocialAccount";
    public const PURPOSE_SOCIAL_POST            = "createSocialPost";
    // social pilot

    /**
     * Model Purposes End
     * */

    public const MYSQL_EXCEPTIONS  = [
        1045 => "Access denied for user (using password: YES/NO)",
        1054 => "Unknown column in 'field list'",
        1062 => "Duplicate entry for key",
        1064 => "Syntax error in SQL statement",
        1136 => "Column count doesn't match value count at row",
        1146 => "Table doesn't exist",
        1217 => "Cannot delete or update a parent row: a foreign key constraint fails",
        1364 => "Field doesn't have a default value",
        1451 => "Cannot delete or update a parent row: a foreign key constraint fails",
        1452 => "Cannot add or update a child row: a foreign key constraint fails",
        2002 => "Can't connect to local MySQL server through socket",
        2013 => "Lost connection to MySQL server during query",
    ];


    public const SMALL_ARTICLE_MAX_LENGTH_WORDS  = 2400;
    public const MEDIUM_ARTICLE_MAX_LENGTH_WORDS = 3600;
    public const LARGE_ARTICLE_MAXLENGTH_WORDS   = 5200;

    #Article MAX length
    public const ARTICLE_MAX_LENGTH_WORDS_TYPES = [
        "small"  => self::SMALL_ARTICLE_MAX_LENGTH_WORDS,
        "medium" => self::MEDIUM_ARTICLE_MAX_LENGTH_WORDS,
        "large"  => self::LARGE_ARTICLE_MAXLENGTH_WORDS,
    ];

    #Article length range
    public const SMALL_ARTICLE_WORDS_RANGE  = "1000 to 2500";
    public const MEDIUM_ARTICLE_WORDS_RANGE = "2500 to 3600";
    public const LARGE_ARTICLE_WORDS_RANGE  = "3600 to 5400";
    public const ARTICLE_LENGTH_WORDS_TYPES_RANGE = [
        "small"  => self::SMALL_ARTICLE_WORDS_RANGE,
        "medium" => self::MEDIUM_ARTICLE_WORDS_RANGE,
        "large"  => self::LARGE_ARTICLE_WORDS_RANGE,
    ];


    /**
     * Article Step
     * */
    public const ARTICLE_STEPS = [
        "keywords" => 1,
        "titles"   => 2,
        "images"   => 3,
        "outlines" => 4,
        "meta_descriptions" => 41, // meta_descriptions
        "articles" => 5
    ];
    // text to speech
    public const openAiTextLength     = 4096;
    public const elevenLabsTextLength = 2500;

    public const CONTENT_TYPE_IMAGE   = 'image';
    public const CONTENT_TYPE_CONTENT = 'content';

    public const DATE_FORMAT_LIST = [
            'jS M, Y'                   => '22th May, 2024',
            'Y-m-d'                     => '2024-05-22',
            'Y-d-m'                     => '2024-22-05',
            'd-m-Y'                     => '22-05-2024',
            'm-d-Y'                     => '05-22-2024',
            'Y/m/d'                     => '2024/05/22',
            'Y/d/m'                     => '2024/22/05',
            'd/m/Y'                     => '22/05/2024',
            'm/d/Y'                     => '05/22/2024',
            'l jS \of F Y'              => 'Monday 22th of May 2024',
            'jS \of F Y'                => '22th of May 2024',
            'g:ia \o\n l jS F Y'        => '12:00am on Monday 22th May 2024',
            'F j, Y, g:i a'             => 'May 22 2024, 3:00 pm',
            'F j, Y'                    => 'May 22, 2024',
            '\i\t \i\s \t\h\e jS \d\a\y'=> 'it is the 22th day'
    ];
    public const OPEN_AI_MODELS = [ 
            'gpt-3.5-turbo'          => 'GPT-3.5 Turbo',
            'gpt-3.5-turbo-instruct' => 'Gpt 3.5 turbo instruct',
            'gpt-4'                  => 'ChatGPT 4 ',
            'gpt-4-turbo'            => 'GPT-4 Turbo',
            'gpt-3.5-turbo-16k'      => 'ChatGPT 3.5 Turbo-16k',           
            'gpt-4-0613'             => 'ChatGPT 4 Gpt-4-32k',
            'gpt-4o'                 => 'ChatGPT 4o',
            'gpt-4o-mini'            => 'Gpt 4o mini',
            'gpt-4o-mini-2024-07-18' => 'Gpt 4o mini 2024 07 18',
            'chatgpt-4o-latest'      => 'Chatgpt 4o latest',
            'gpt-3.5-turbo-1106'     => 'Updated GPT 3.5 Turbo',
    ];
    
    public const CLAUDE_AI_MODELS = [
        'claude-3-opus-20240229'    => 'Claude 3 Opus',
        'claude-3-sonnet-20240229'  => 'Claude 3.5 Sonnet',
    ];

    public const DEEPSEEK_AI_MODELS = [
        'deepseek-chat'    => 'DeepSeek V3',
    ];
    
    public const ALL_AI_MODELS = self::OPEN_AI_MODELS + self::CLAUDE_AI_MODELS + self::DEEPSEEK_AI_MODELS;

    public const open_ai_voices = "alloy, echo, fable, onyx, nova, shimmer";
    public const open_ai_speeds = [
        '0.25',
        '0.50',
        '0.75',
        '1',
        '1.25',
        '1.5',
        '1.75',
        '2.0',
        '2.25',
        '2.5',
        '2.75',
        '3.0',
        '3.25',
        '3.5',
        '3.75',
        '4.0'
    ];
    public const open_ai_tts_models         = ['tts-1', 'tts-1-hd'];
    public const open_ai_response_formats   = ['mp3', 'opus', 'aac', 'flac'];
    public const google_cloud_speeds        =
    [
        'x-slow' => 'Very Slow',
        'slow'   => 'Slow',
        'medium' => 'Medium',
        'fast'   => 'Fast',
        'x-fast' => 'Very Fast'
    ];
    public const google_cloud_breaks = [1,2,3,4,5];

    // AI Photo-Studio

    const PHOTO_STUDIO_ACTION_ARR = [
        1 => 'Reimagine',
        2 => 'Remove Background',
        3 => 'Replace Background',
        4 => 'Remove Text',
        5 => 'Text to Image',
        6 => 'Sketch to Image',
        7 => 'Upscale',
    ];

    const PHOTO_STUDIO_REIMAGINE          = 1;
    const PHOTO_STUDIO_REMOVE_BACKGROUND  = 2;
    const PHOTO_STUDIO_REPLACE_BACKGROUND = 3; // Contains Prompt
    const PHOTO_STUDIO_REMOVE_TEXT        = 4;
    const PHOTO_STUDIO_TEXT_TO_IMAGE      = 5; // Contains Prompt
    const PHOTO_STUDIO_SKETCH_TO_IMAGE    = 6; // Contains Prompt
    const PHOTO_STUDIO_UPSCALE            = 7; // Contains Prompt

    /**
     * Webhook Manage
     * */
    const HOOK_STRIPE_CUSTOMER_CREATED = "customer.created";
    const HOOK_STRIPE_CUSTOMER_UPDATED = "customer.updated";
    const HOOK_STRIPE_CUSTOMER_DELETED = "customer.deleted";

    const HOOK_CUSTOMER_SUBSCRIPTION_CREATED = "customer.subscription.created";
    const HOOK_CUSTOMER_SUBSCRIPTION_UPDATED = "customer.subscription.updated";
    const HOOK_CUSTOMER_SUBSCRIPTION_DELETED = "customer.subscription.deleted";

    const HOOK_PAYMENT_INTENT_SUCCEEDED = "payment_intent.succeeded";
    const HOOK_PAYMENT_INTENT_EXPIRED = "payment_intent.expired";
    const HOOK_PAYMENT_INTENT_FAILED = "payment_intent.failed";
    const HOOK_INVOICE_CREATED = "invoice.created";
    const HOOK_INVOICE_FINALIZED = "invoice.finalized";
    const HOOK_INVOICE_PAYMENT_SUCCEEDED = "invoice.payment_succeeded";
    const HOOK_INVOICE_PAYMENT_FAILED = "invoice.payment_failed";
    const HOOK_CHECKOUT_SESSION_COMPLETED = "checkout.session.completed";

    const DEFAULT_CURRENCY_CODE = "usd";
    public const OPEN_AI_TONES = [
        'Friendly'     => 'Friendly',
        'Luxury'       => 'Luxury',
        'Relaxed'      => 'Relaxed',
        'Professional' => 'Professional',
        'Casual'       => 'Casual',
        'Excited'      => 'Excited',
        'Bold'         => 'Bold',
        'Masculine'    => 'Masculine',
        'Dramatic'     => 'Dramatic',
    ];
    public const ENGINE_LISTS = [
        self::ENGINE_OPEN_AI        => 'Open AI',
        self::ENGINE_GEMINI_AI      => 'Gemini AI',
        self::ENGINE_CLAUDE_AI      => 'Claude AI',
        self::ENGINE_DEEPSEEK_AI    => 'DeepSeek AI',
    ];

    const TEST_2 = "Update test";

    #Wordpress
    const PUBLISHED = 1;
    const PUBLISHED_TO_WORDPRESS = 1;
    const UNPUBLISHED = 0;
    const COMPLETED_STEP = 1;
    
    # Article generation source
    const ARTICLE_SOURCE_WRITERAP = 1;
    const ARTICLE_SOURCE_WP = 2;

    # editable content_types
    public const EDITABLE_CONTENT_TYPES = [
        'templateContents',
        'generateText',
        'articles',
    ];

    
    #==========================Social Pilot
    // platforms
    const PLATFORM_LIST = [
        'facebook' ,
        'instagram',
        'twitter'  ,
        'linkedin' ,
    ];
    const PLATFORM_IDS = [
        'facebook'  => 1,
        'instagram' => 2,
        'twitter'   => 3,
        'linkedin'  => 4,
    ];
    const PLATFORM_FACEBOOK     = 'facebook';
    const PLATFORM_INSTAGRAM    = 'instagram';
    const PLATFORM_TWITTER      = 'twitter';
    const PLATFORM_LINKEDIN     = 'linkedin';

    const STATUS = [
        'FALSE'    => 0, 
        'TRUE'     => 1,
    ];

    const ACCOUNT_TYPE = [
        'PROFILE'    => '0', 
        'PAGE'       => '1', 
        'GROUP'      => '2',
    ];

    const ACCOUNT_TYPE_BY_VALUE = [
        '0' => 'PROFILE', 
        '1' => 'PAGE', 
        '2' => 'GROUP',
    ];
  
    const IS_CONNECTED = [
        '0' => 'No', 
        '1' => 'Yes',
    ];

    const POST_TYPES = [
        'FEED'  => 1,
        'STORY' => 2,
        'REEL'  => 3,
    ];

    const POST_TYPES_BY_VALUE = [
        1   => 'FEED' ,
        2   => 'STORY' ,
        3   => 'REEL' ,
    ];
    const POST_TYPES_BADGE_BY_VALUE = [
        1   => 'primary',
        2   => 'success',
        3   => 'warning'
    ];

    const POST_STATUS = [
        // 'DRAFT'         => 1,
        'PENDING'       => 2,
        'SUCCESSFUL'    => 3,
        'SCHEDULED'     => 4,
        'FAILED'        => 5,
    ];
    const POST_STATUS_BY_VALUE = [
        // 1   => 'DRAFT',
        2   => 'PENDING',
        3   => 'SUCCESSFUL',
        4   => 'SCHEDULED',
        5   => 'FAILED',
    ];
    const POST_STATUS_BADGE_BY_VALUE = [
        1   => 'secondary',
        2   => 'primary',
        3   => 'success',
        4   => 'warning',
        5   => 'danger',
    ];
    #==========================Social Pilot
}
