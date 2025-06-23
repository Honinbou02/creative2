<?php

namespace App\Services\Feature;

class FeatureService
{
    public function aiFeatureList(): array
    {
        return [
            'enable_seo_keywords' => [
                'title'       => 'SEO Bulk Keywords Analysis',
                'description' => localize('If this feature is disabled, no one will not have access to it. If enabled, the customer can analyze bulk keywords if this feature is included in their package'),
                'is_active'   => getSetting('enable_seo_keywords') ? 1 : 0,
            ],

            'enable_helpful_content_analysis' => [
                'title'       => 'SEO Helpful Content Analysis',
                'description' => localize('If this feature is disabled, no one will not have access to it. If enabled, the customer can seo helpful content if this feature is included in their package'),
                'is_active'   => getSetting('enable_helpful_content_analysis') ? 1 : 0,
            ],

            'enable_seo_content_optimization' => [
                'title'       => 'SEO Content Optimizations',
                'description' => localize('If this feature is disabled, no one will not have access to it. If enabled, the customer can seo optimize their content if this feature is included in their package'),
                'is_active'   => getSetting('enable_seo_content_optimization') ? 1 : 0,
            ],

            'enable_ai_chat' => [
                'title'       => 'AI Chat',
                'description' => localize('If this feature is disabled, no one will not have access to it. If enabled, the customer can chat with an expert if this feature is included in their package'),
                'is_active'   => getSetting('enable_ai_chat') ? 1 : 0,
                'engines'     => appStatic()::ENGINE_LISTS,
            ],
            'enable_ai_writer' => [
                'title'       => 'AI Writer',
                'description' =>  localize('If this feature is disabled, no one will not have access to it.If enabled, the customer can generate a Content with AI if this feature is included in their package'),
                'is_active'   => getSetting('enable_ai_writer') ? 1 : 0,
                'engines'     => appStatic()::ENGINE_LISTS,
            ],
            'enable_ai_rewriter' => [
                'title'       => 'AI ReWriter',
                'description' =>  localize('If this feature is disabled, no one will not have access to it.If enabled, the customer can generate a Content with AI if this feature is included in their package'),
                'is_active'   => getSetting('enable_ai_rewriter') ? 1 : 0,
                'engines'     => appStatic()::ENGINE_LISTS,
            ],
            'enable_templates' => [
                'title'       => 'Templates',
                'description' =>  localize('If this feature is disabled, no one will not have access to it.If enabled, the customer can generate a Content with AI if this feature is included in their package'),
                'is_active'   => getSetting('enable_templates') ? 1 : 0,
                'engines'     => appStatic()::ENGINE_LISTS,
            ],
            'enable_ai_blog_wizard' => [
                'title'       => 'AI Blog Wizard',
                'description' =>  localize('If this feature is disabled, no one will not have access to it.If enabled, the customer can create a blog with AI if this feature is included in their package'),
                'is_active'   => getSetting('enable_ai_blog_wizard') ? 1 : 0,
                'engines'     => appStatic()::ENGINE_LISTS,
            ],
            'enable_ai_assistant' => [
                'title'       => 'AI Assistant',
                'description' =>  localize('If this feature is disabled, no one will not have access to it.If enabled, the customer can create a posts with AI if this feature is included in their package'),
                'is_active'   => getSetting('enable_ai_assistant') ? 1 : 0,
                'engines'     => appStatic()::ENGINE_LISTS,
            ],
            'enable_generate_code' => [
                'title'       => 'Generate Code',
                'description' => localize('If this feature is disabled, no one will not have access to it. If enabled, the customer can generate code if this feature is included in their package'),
                'is_active'   => getSetting('enable_generate_code') ? 1 : 0,
                'engines'     => appStatic()::ENGINE_LISTS,
            ],

            'enable_ai_pdf_chat' => [
                'title'       => 'AI PDF CHAT',
                'description' => localize('If this feature is disabled, no one will not have access to it. If enabled, the customer can chat with PDF expert if this feature is included in their package'),
                'is_active'   => getSetting('enable_ai_pdf_chat') ? 1 : 0
            ],
            'enable_ai_vision' => [
                'title'       => 'AI Vision',
                'description' => localize('If this feature is disabled, no one will not have access to it. If enabled, the customer can chat with AI Vision expert if this feature is included in their package'),
                'is_active'   => getSetting('enable_ai_vision') ? 1 : 0
            ],
            'enable_brand_voice' => [
                'title'       => 'Brand Voice',
                'description' => localize('If this feature is disabled, no one will not have access to it. If enabled, the customer can create Brand Voice if this feature is included in their package'),
                'is_active'   => getSetting('enable_brand_voice') ? 1 : 0
            ],
            'enable_voice_clone' => [
                'title'       => 'Voice Clone',
                'description' => localize('If this feature is disabled, no one will not have access to it. If enabled, the customer can clone Voice if this feature is included in their package'),
                'is_active'   => getSetting('enable_voice_clone') ? 1 : 0
            ],
            // Generate with Stable Diffusion.
            'enable_ai_video' => [
                'title'       => 'AI Video',
                'description' => localize('If this feature is disabled, no one will not have access to it. If enabled, the customer can chat with AI Video expert if this feature is included in their package'),
                'is_active'   => getSetting('enable_ai_video') ? 1 : 0
            ],

            // Generate with HeyGen
            'enable_ai_avatar_pro' => [
                'title'       => 'AI Avatar Pro',
                'description' => localize('If this feature is disabled, no one will not have access to it. If enabled, the customer can chat with AI Video expert if this feature is included in their package'),
                'is_active'   => getSetting('enable_ai_avatar_pro') ? 1 : 0
            ],

            'enable_ai_images' => [
                'title'       => 'AI Image',
                'description' => localize('If this feature is disabled, no one will not have access to it. If enabled, the customer can generate image if this feature is included in their package'),
                'is_active'   => getSetting('enable_ai_images') ? 1 : 0
            ],
            'enable_ai_chat_image' => [
                'title'       => 'AI Chat Image',
                'description' => localize('If this feature is disabled, no one will not have access to it. If enabled, the customer can chat with AI Image expert if this feature is included in their package'),
                'is_active'   => getSetting('enable_ai_chat_image') ? 1 : 0
            ],

            // Generate with Pebblely
            'enable_ai_product_shot' => [
                'title'       => 'AI Product Shot',
                'description' => localize('If this feature is disabled, no one will not have access to it. If enabled, the customer can generate image if this feature is included in their package'),
                'is_active'   => getSetting('enable_ai_product_shot') ? 1 : 0
            ],

            // Generate with ClipDrop
            'enable_ai_photo_studio' => [
                'title'       => 'AI PHOTO Studio',
                'description' => localize('If this feature is disabled, no one will not have access to it. If enabled, the customer can generate image if this feature is included in their package'),
                'is_active'   => getSetting('enable_ai_photo_studio') ? 1 : 0
            ],

            'enable_ai_detector' => [
                'title'       => 'AI Detector',
                'description' => localize('If this feature is disabled, no one will not have access to it.If enabled, the customer can check Detect content with AI if this feature is included in their package'),
                'is_active'   => getSetting('enable_ai_detector') ? 1 : 0
            ],
            'enable_ai_plagiarism' => [
                'title'       => 'AI Plagiarism',
                'description' => localize('If this feature is disabled, no one will not have access to it.If enabled, the customer can check Plagiarism with AI if this feature is included in their package'),
                'is_active'   => getSetting('enable_ai_plagiarism') ? 1 : 0
            ],

            'enable_speech_to_text' => [
                'title'       => 'Speech to Text',
                'description' =>  localize('If this feature is disabled, no one will not have access to it.If enabled, the customer can convert Speech to Text if this feature is included in their package'),
                'is_active'   => getSetting('enable_speech_to_text') ? 1 : 0
            ],
            'enable_text_to_speech' => [
                'title'       => 'Text To Speech',
                'description' =>  localize('If this feature is disabled, no one will not have access to it.If enabled, the customer can convert text to speech if this feature is included in their package'),
                'is_active'   => getSetting('enable_text_to_speech') ? 1 : 0
            ],
            'enable_eleven_labs' => [
                'title'       => 'ElevenLabs',
                'description' =>  localize('If this feature is disabled, no one will not have access to it.If enabled, the customer can convert text to speech if this feature is included in their package'),
                'is_active'   => getSetting('enable_eleven_labs') ? 1 : 0
            ],
            'enable_google_cloud' => [
                'title'       => 'Google Cloud',
                'description' =>  localize('If this feature is disabled, no one will not have access to it.If enabled, the customer can convert text to speech if this feature is included in their package'),
                'is_active'   => getSetting('enable_google_cloud') ? 1 : 0
            ],
            'enable_azure' => [
                'title'       => 'Azure',
                'description' =>  localize('If this feature is disabled, no one will not have access to it.If enabled, the customer can convert text to speech if this feature is included in their package'),
                'is_active'   => getSetting('enable_azure') ? 1 : 0
            ],
            'enable_generate_image' => [
                'title'       => 'Generate Images',
                'description' =>  localize('If this feature is disabled, no one will not have access to it'),
                'is_active'   => getSetting('enable_generate_image') ? 1 : 0
            ],
            'enable_generate_image_step' => [
                'title'       => 'Generate Images Step AI Blog Wizard',
                'description' => localize('If this feature is disabled, can not generate image when blog article generate'),
                'is_active'   => getSetting('enable_generate_image_step') ? 1 : 0
            ],
            
        ];
    }

    public function subscriptionFeatures(): array
    {
        return [
            'balance_carry_forward' => [
                'title'       => 'Balance Carry Forward:',
                'description' => "Remaining balance from active package(only for active) will be added to next package balance.<br>This service is applicable for same package - Lifetime to Lifetime, Yearly to Yearly, Monthly to Monthly and Prepaid to Prepaid package.",
                'is_active'   => getSetting('balance_carry_forward') ? 1 : 0
            ],
            'new_package_purchase' => [
                'title'       => 'Auto Activated New package Expire Old Package',
                'description' => 'if enable, running package expire when purchase to new package',
                'is_active'   => getSetting('new_package_purchase') ? 1 : 0
            ],
            'auto_subscription_active' => [
                'title'       => 'Allow user to cancel Auto Subscription',
                'description' => 'if enable, user can cancel auto recurring payment if purchase from paypal',
                'is_active'   => getSetting('auto_subscription_active') ? 1 : 0
            ],
            'auto_subscription_deactive' => [
                'title'       => 'Allow user to Active Auto Subscription',
                'description' => 'if enable, user can Active auto recurring payment if purchase from paypal.',
                'is_active'   => getSetting('auto_subscription_deactive') ? 1 : 0
            ],
        ];
    }
    public function settingsTabs(): object
    {
        $tabs = [
            'settings-info-tab' => [
                'title' => 'General Information',
                'h1'    => 'System Info Setup',
                'icon'  => 'tool'
            ],
            'general-settings-tab' => [
                'title' => 'General Settings',
                'h1'    => 'System Setting Configuration',
                'icon'  => 'settings'
            ],
            'settings-feature-list-tab' => [
                'title' => 'AI Featured Activations',
                'h1'    => 'AI Featured Activations',
                'icon'  => 'hexagon'
            ],
            'subscription-setting-tab' => [
                'title' => 'Subscription Setting',
                'h1'    => 'Subscription Setting',
                'icon'  => 'package'
            ],
            'affiliate-configurations-tab' => [
                'title' => 'Affiliate Configurations',
                'h1'    => 'Affiliate Configurations',
                'icon'  => 'git-pull-request'
            ],
            'invoice-settings-tab' => [
                'title' => 'Invoice Settings',
                'h1'    => 'Invoice Settings',
                'icon'  => 'shopping-bag'
            ],
            'settings-seo-meta-tab' => [
                'title' => 'SEO Meta Configuration',
                'h1'    => 'SEO Meta Configuration',
                'icon'  => 'activity'
            ],
            'settings-cookie-consent-tab' => [
                'title' => 'Cookie Consent',
                'h1'    => 'Cookie Consent',
                'icon'  => 'alert-circle'
            ],
            'settings-custom-scripts-tab' => [
                'title' => 'Custom Scripts & CSS',
                'h1'    => 'Custom Scripts & CSS',
                'icon'  => 'code'
            ],
            'copy-write-text-tab' => [
                'title' => 'CopyWrite Text',
                'h1'    => 'CopyWrite Text',
                'icon'  => 'at-sign'
            ],
            'social-links-tab' => [
                'title' => 'Social Links',
                'h1'    => 'Social Links',
                'icon'  => 'at-sign'
            ],
        ];

        return collect($tabs);
    }
    public function credentialTabs()
    {
        $tabs = [
            'ai-setting-tab' => [
                'title' => 'AI Engine Setting',
                'h1'    => 'AI Engine Setting',
                'icon'  => 'lock'
            ],

            'seo-review-tool-tab' => [
                'title' => 'SEO Review Tool',
                'h1'    => 'SEO Review Tool',
                'icon'  => 'target'
            ],

            'smtp-settings-tab' => [
                'title' => 'SMTP Settings',
                'h1'    => 'SMTP Settings',
                'icon'  => 'settings'
            ],

            'stable-diffusion-tab' => [
                'title' => 'Stable Diffusion',
                'h1'    => 'Stable Diffusion',
                'icon'  => 'image'
            ],

            'unsplash-tab' => [
                'title' => 'Unsplash',
                'h1'    => 'Unsplash',
                'icon'  => 'image'
            ],
            
            'pexels-tab' => [
                'title' => 'Pexels',
                'h1'    => 'Pexels',
                'icon'  => 'image'
            ],

            'serper-tab' => [
                'title' => 'Serper',
                'h1'    => 'Serper',
                'icon'  => 'hexagon'
            ],

            'plagiarism-tab' => [
                'title' => 'Plagiarism',
                'h1'    => 'Plagiarism',
                'icon'  => 'tag'
            ],

            'azure-tab' => [
                'title' => 'Azure Setup',
                'h1'    => 'Azure Setup',
                'icon'  => 'anchor'
            ],

            'eleven-labs-tab' => [
                'title' => 'ElevenLabs',
                'h1'    => 'ELEVEN LABS',
                'icon'  => 'file-plus'
            ],

//            New Features Start
            'ai-photo-studio-tab' => [
                'title' => 'AI Photo Studio',
                'h1'    => 'AI Photo Studio',
                'icon'  => 'aperture'
            ],

            'ai-product-shot-tab' => [
                'title' => 'AI Product Shot',
                'h1'    => 'AI Product Shot',
                'icon'  => 'crosshair'
            ],

            'ai-avatar-pro-tab' => [
                'title' => 'AI Avatar Pro',
                'h1'    => 'AI Avatar Pro',
                'icon'  => 'zap'
            ],
//            New Features End


            'google-cloud-tab' => [
                'title' => 'Cloud Text-to-Speech API',
                'h1'    => 'Cloud Text-to-Speech API',
                'icon'  => 'type'
            ],

            'aws-tab' => [
                'title' => 'Amazon Web Services',
                'h1'    => 'Amazon Web Services',
                'icon'  => 'airplay'
            ],

            'google-recaptcha-tab' => [
                'title' => 'Google Recaptcha V3',
                'h1'    => 'Google Recaptcha V3',
                'icon'  => 'chrome'
            ],

            'google-analytics-tab' => [
                'title' => 'Google Analytics',
                'h1'    => 'Google Analytics',
                'icon'  => 'activity'
            ],

            'google-adsense-tab' => [
                'title' => 'Google Adsense',
                'h1'    => 'Google Adsense',
                'icon'  => 'percent'
            ],

            'twilio-tab' => [
                'title' => 'Twilio Setup',
                'h1'    => 'Twilio Setup',
                'icon'  => 'compass'
            ],

            'social-login-google-credential-tab' => [
                'title' => 'Social Login Google',
                'h1'    => 'Social Login Google',
                'icon'  => 'log-in'
            ],

            'social-login-facebook-credential-tab' => [
                'title' => 'Social Login Facebook',
                'h1'    => 'Social Login Facebook',
                'icon'  => 'facebook'
            ],
        ];

        return collect($tabs);
    }
    public function appearanceFeatureTab()
    {
        $tabs = [
            'hero-section-tab' => [
                'title' => 'Hero Section',
                'h1'    => 'Hero Section',
                'icon'  => 'key'
            ],
            'brand-section-tab' => [
                'title' => 'Brand Section',
                'h1'    => 'Brand Section',
                'icon'  => 'key'
            ],
            'feature-document-tab-1' => [
                'title' => 'Feature',
                'h1'    => 'Feature',
                'icon'  => 'key'
            ],
            'feature-document-tab-2' => [
                'title' => 'Feature Item 1',
                'h1'    => 'Feature Item 1',
                'icon'  => 'key'
            ],
            'feature-document-tab-3' => [
                'title' => 'Feature Item 2',
                'h1'    => 'Feature Item 2',
                'icon'  => 'key'
            ],
            'feature-document-tab-4' => [
                'title' => 'Feature Item 3',
                'h1'    => 'Feature Item 3',
                'icon'  => 'key'
            ],
            'feature-document-tab-5' => [
                'title' => 'Feature Item 4',
                'h1'    => 'Feature Item 4',
                'icon'  => 'key'
            ],
            'feature-document-tab-6' => [
                'title' => 'Feature Item 5',
                'h1'    => 'Feature Item 5',
                'icon'  => 'key'
            ],
            'feature-document-tab-7' => [
                'title' => 'Feature Item 6',
                'h1'    => 'Feature Item 6',
                'icon'  => 'key'
            ],


            'feature-tab-1' => [
                'title' => 'Application Feature 1',
                'h1'    => 'Application Feature 1',
                'icon'  => 'key'
            ],
            'feature-tab-2' => [
                'title' => 'Application Feature 2',
                'h1'    => 'Application Feature 2',
                'icon'  => 'key'
            ],
            'feature-tab-3' => [
                'title' => 'Application Feature 3',
                'h1'    => 'Application Feature 3',
                'icon'  => 'key'
            ],
            'feature-tab-4' => [
                'title' => 'Application Feature 4',
                'h1'    => 'Application Feature 4',
                'icon'  => 'key'
            ],
            'feature-tab-5' => [
                'title' => 'Application Feature 5',
                'h1'    => 'Application Feature 5',
                'icon'  => 'key'
            ],
            'feature-tab-6' => [
                'title' => 'Application Feature 6',
                'h1'    => 'Application Feature 6',
                'icon'  => 'key'
            ],

            "integration-tab" => [
                'title' => 'Integration',
                'h1'    => 'Our Integration',
                'icon'  => 'key'
            ],

            "contact-us-tab" => [
                'title' => 'Contact Us',
                'h1'    => 'Contact Us',
                'icon'  => 'key'
            ],

            "ai-journey-tab" => [
                'title' => 'AI Journey',
                'h1'    => 'AI Journey',
                'icon'  => 'key'
            ],
            'feature-tools-tab-1' => [
                'title' => 'AI Feature Tools 1',
                'h1'    => 'AI Feature Tools',
                'icon'  => 'key'
            ],
            'feature-tools-tab-2' => [
                'title' => 'AI Feature Tools 2',
                'h1'    => 'AI Feature Tools 2',
                'icon'  => 'key'
            ],
            'feature-tools-tab-3' => [
                'title' => 'AI Feature Tools 3',
                'h1'    => 'AI Feature Tools 3',
                'icon'  => 'key'
            ],
            'feature-tools-tab-4' => [
                'title' => 'AI Feature Tools 4',
                'h1'    => 'AI Feature Tools 4',
                'icon'  => 'key'
            ],
            'feature-tools-tab-5' => [
                'title' => 'AI Feature Tools 5',
                'h1'    => 'AI Feature Tools 5',
                'icon'  => 'key'
            ],
            'auth-tab' => [
                'title' => 'Login & Register',
                'h1'    => 'Login & Register',
                'icon'  => 'key'
            ],

        ];

        return collect($tabs);
    }
    public function SubscriptionPlanFeatures(): object
    {
        $packageFeatures = [
            'words' => [
                'total_words'     => 1000,
                'allow'           => 1,
                'show'            => 1,
                'unlimited_words' => 1,
                'title'           => 'Words',

                'features' => [
                    'words' => [
                        'title' => 'Words',
                        'allow' => 1,
                        'show'  => 1,
                    ],
                    'ai_template' => [
                        'title' => 'AI Template',
                        'allow' => 1,
                        'show'  => 1,
                    ],
                    'ai_chat' => [
                        'title' => 'AI Chat',
                        'allow' => 1,
                        'show'  => 1,
                    ],
                ],
            ],
        ];

        return collect($packageFeatures);
    }
}
