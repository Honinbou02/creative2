<?php

namespace App\Services\Action;

use App\Services\Business\SeoService;
use Illuminate\Support\Facades\Log;

/**
 * Class SeoCheckerActionService.
 */
class SeoCheckerActionService
{
    private $seoService;

    public function __construct()
    {
        $this->seoService = new SeoService();
    }


    public function prepareDataForHelpFulContentAnalysis(object $article)
    {
        // Content to check
        $post = $article->article;


        return [
            "article_json"   => json_encode($article),
            "article_id"     => $article->id,
            'content'        => 1,
            "data"           => [
                'content_input' => [
                    'body_content' => $post
                ]
            ]
        ];
    }

    public function getHelpfulContentAnalysis(array $payloads): array
    {
        if(isDemoOn()){
            $jsonResult = file_get_contents("get_helpful_content_analysis.json");
        }
        else{
            $jsonResult = $this->seoService->getHelpfulContentAnalysis($payloads);
            file_put_contents("get_helpful_content_analysis.json", $jsonResult);
        }
        

        // decode the result
        $decodedResult = json_decode($jsonResult, true);

        if($decodedResult["status"] == "error"){
            throw new \RuntimeException($decodedResult["error message"],appStatic()::VALIDATION_ERROR);
        }

        $seoReport  = $this->parseHelpfulContentAnalysisResult($decodedResult);

        $categorySectionBlade    = view("backend.admin.seo.render.seo-helpful-content-analysis-category-section")->with($seoReport)->render();
        $seoDetailedRatingsBlade = view("backend.admin.seo.render.seo-helpful-content-analysis-feedbacks-section")->with($seoReport)->render();

        return [
            "meter"          => $seoReport["meter"],
            "category_section_blade"   => $categorySectionBlade,
            "seo_report"     => $seoDetailedRatingsBlade,
        ];
    }

    public function parseHelpfulContentAnalysisResult($jsonData)
    {

        return [
            "meter"             => $this->getHelpfulContentAnalysisScore($jsonData),
            "category_score"    => $this->getHelpfulContentAnalysisCategoryScore($jsonData),
            "detailed_ratings"  => $this->getHelpfulContentAnalysisDetailedRatings($jsonData),
        ];
    }

    public function getHelpfulContentAnalysisScore($jsonData)
    {
        if(!empty($jsonData["data"]["helpful content score"])){
            return [
                "score"                => $jsonData["data"]["helpful content score"],
                "status"               => $jsonData["data"]["helpful content status"],
                "available_seo_points" => $jsonData["data"]["available points"],
                "earned_seo_points"    => $jsonData["data"]["earned points"],
            ];
        }

        return [
            "score"                => 0,
            "status"               => 'Failed',
            "available_seo_points" => 0,
            "earned_seo_points"    => 0,
        ];
    }

    public function getHelpfulContentAnalysisCategoryScore($jsonData)
    {
        if(!empty($jsonData["data"]["category score"])){
            return $jsonData["data"]["category score"];
        }

        return [];
    }

    public function getHelpfulContentAnalysisDetailedRatings($jsonData)
    {

        return !empty($jsonData["data"]["data"]) ? $jsonData["data"]["data"] : [];
    }

    public function getSeoContentOptimizationAnalysis(array $payloads): array
    {
        $isFromDemo = null;
        if(isDemoOn()){
            $jsonResult = file_get_contents("seo_content_optimization_analysis.json");
        }
        else{
            $jsonResult = $this->seoService->getSeoContentOptimizationAnalysis($payloads);
            file_put_contents("seo_content_optimization_analysis.json", $jsonResult);
        }

        // decode the result
        $decodedResult = json_decode($jsonResult, true);

        if($decodedResult["status"] == "error"){
            throw new \RuntimeException($decodedResult["error message"],appStatic()::VALIDATION_ERROR);
        }

        $seoReport  = $this->parseSeoContentOptimizationAnalysisResult($decodedResult);

        $seoFeedBackBlade = view("backend.admin.seo.render.seo-content-optimization-feedback-section")->with($seoReport)->render();
        $seoMeeterBlade   = view("backend.admin.seo.render.seo-content-optimization-meeter-section")->with($seoReport)->render();

        return [
            "meter"          => $seoReport["meter"],
            "feedBack_blade" => $seoFeedBackBlade,
            "meeter_blade"   => $seoMeeterBlade,
            "seo_report"     => $seoReport,
        ];
    }

    public function prepareDataForSeoContentOptimizationAnalysis(object $article)
    {
        // Title tag
        $title_tag = $article->title;

        // Meta description
        $meta_description = $article->selected_meta_description;

        // Content to check
        $body_content = $article->article;

        // remove tabs and spaces
        $body_content = preg_replace('/\s+/S', " ", $body_content);

        // Focus keywords
        $focusKeywords = implode(" ", array_slice(explode(" ", $article->focus_keyword), 0, 3)); // maximum 3 words

        // Related keywords
        $keyWords = $article->selected_keyword;
        if(!empty($keyWords)){
            $keywordArr = explode(",", $keyWords);
            if(count($keywordArr) >= 3) { // minimum 3 keywords needed for related keywords
                $keyWords = implode("|", $keywordArr);
            } else {
                $keyWords = null;
            }
        }

        return [
            "article_json"   => json_encode($article),
            "article_id"     => $article->id,
            'content'        => 1,
            "keyword"        => $focusKeywords,
            "relatedKeyword" => $keyWords,
            "data"           => [
                'content_input' => [
                    "title_tag"        => $title_tag,
                    'meta_description' => $meta_description,
                    'body_content'     => $body_content
                ]
            ]
        ];
    }

    public function parseSeoContentOptimizationAnalysisResult($jsonData)
    {

        return [
            "meter"     => $this->getMeeterReport($jsonData),
            "overview"  => $this->getOverView($jsonData),
            "reports"   => $this->getReports($jsonData),
            "feedbacks" => $this->getMetaFeedback($jsonData),
        ];
    }

    public function getMeeterReport($jsonData)
    {
        $overView = $jsonData["data"]["Overview"];


        return [
            "score"                => $overView["Overall SEO score"],
            "available_seo_points" => $overView["Available SEO points"],
            "earned_seo_points"    => $overView["Earned SEO points"],
        ];
    }

    public function getOverView($data)
    {

        return [
            "title"   => $this->getTitleScore($data),
            "heading" => $this->getHeadingScore($data),
            "terms"   => $this->getTermsScore($data),
            "word"    => $this->getWordReport($data)
        ];
    }

    public function getTitleScore($data)
    {
        $titleTag             = $data["data"]["Title tag"];
        $seoScore             = $titleTag["SEO Score"];
        $maxSeoScoreAvailable = $titleTag["Max SEO score available"];

        return percentageResult($seoScore, $maxSeoScoreAvailable);
    }

    public function getHeadingScore($data)
    {
        $titleTag             = $data["data"]["Page headings"];
        $seoScore             = $titleTag["SEO Score"];
        $maxSeoScoreAvailable = $titleTag["Max SEO score available"];

        return percentageResult($seoScore, $maxSeoScoreAvailable);
    }

    public function getTermsScore($data)
    {
        $titleTag             = $data["data"]["Keyword usage"];
        $seoScore             = $titleTag["SEO Score"];
        $maxSeoScoreAvailable = $titleTag["Max SEO score available"];

        return percentageResult($seoScore, $maxSeoScoreAvailable);
    }

    public function getWordReport($data)
    {
        $titleTag             = $data["data"]["Content length"];
        $seoScore             = $titleTag["SEO Score"];
        $maxSeoScoreAvailable = $titleTag["Max SEO score available"];

        return percentageResult($seoScore, $maxSeoScoreAvailable);
    }

    public function getReports($data)
    {

        return [
            "errors"    => $this->getErrors($data),
            "warning"   => $this->getWarning($data),
            "optimized" => $this->getOptimized($data)
        ];
    }

    public function getSummary($data)
    {
        return $data["data"]["Overview"]["Summary"];
    }

    public function getErrors($data)
    {
        $overview = $this->getSummary($data);

        return $overview["Errors"] ?? 0;
    }


    public function getWarning($data)
    {
        $overview = $this->getSummary($data);

        return $overview["Warnings"] ?? 0;
    }

    public function getOptimized($data)
    {
        $overview = $this->getSummary($data);

        return $overview["Optimized"] ?? 0;
    }

    public function getMetaFeedback($data)
    {
        // Array Define
        $feedbackArr = $feedBackDetailsArr = [];

        if(isset($data["data"]) && count($data["data"]) > 0){

            foreach($data["data"] as $key=> $value){
                if($key != "Overview"){
                    $seoScore    = $value["SEO Score"] ?? 0;
                    $seoMaxScore = $value["Max SEO score available"] ?? 0;

                    $scoreArr =  [
                        "seo_score"  => $seoScore,
                        "max_score"  => $seoMaxScore,
                        "percentage" => percentageResult($seoScore, $seoMaxScore)
                    ];


                    if(isset($value["Feedback details"]) && count($value["Feedback details"]) > 0){
                        foreach($value["Feedback details"] as $key1 => $value1){
                            $feedBackDetailsArr[$key1] = [
                                "is_positive" => $value1["class"] == "positive",
                                "text" => $value1["text"]
                            ];
                        }
                    }

                    $feedbackArr[$key] = [
                        "score" => $scoreArr,
                        "feedbacks" => $feedBackDetailsArr
                    ];
                }
            }
        }

        return $feedbackArr;
    }


    public function getTitleFeedback($data)
    {
        $titleTag = $data["data"]["Title tag"];
        $titleFeedbackDetails = $titleTag["Feedback details"] ?? [];

        $seoScore = $titleTag["SEO Score"];
        $seoMaxScore = $titleTag["Max SEO score available"];
        $dataArr = [];
        $dataArr["score"] = [
            "seo_score" => $seoScore,
            "max_score" => $seoMaxScore,
            "percentage" => percentageResult($seoScore, $seoMaxScore)
        ];

        foreach ($titleFeedbackDetails as $key => $value) {
            $dataArr["feedbacks"][] = [
                "is_positive" => $value["class"] == "positive",
                "text" => $value["text"]
            ];
        }

        return $dataArr;
    }

    public function getMetaInfoFeedback($data)
    {
        $titleTag = $data["data"]["Meta description"];
        $titleFeedbackDetails = $titleTag["Feedback details"] ?? [];

        $seoScore = $titleTag["SEO Score"];
        $seoMaxScore = $titleTag["Max SEO score available"];
        $dataArr = [];
        $dataArr["score"] = [
            "seo_score" => $seoScore,
            "max_score" => $seoMaxScore,
            "percentage" => percentageResult($seoScore, $seoMaxScore)
        ];

        foreach ($titleFeedbackDetails as $key => $value) {
            $dataArr["feedbacks"][] = [
                "is_positive" => $value["class"] == "positive",
                "text" => $value["text"]
            ];
        }

        return $dataArr;
    }

    public function getHeadingFeedback($data)
    {
        $titleTag             = $data["data"]["Page headings"];
        $titleFeedbackDetails = $titleTag["Feedback details"] ?? [];

        $seoScore             = $titleTag["SEO Score"];
        $seoMaxScore          = $titleTag["Max SEO score available"];
        $dataArr              = [];
        $dataArr["score"]     = [
            "seo_score"  => $seoScore,
            "max_score"  => $seoMaxScore,
            "percentage" => percentageResult($seoScore, $seoMaxScore)
        ];

        foreach ($titleFeedbackDetails as $key => $value) {
            $dataArr["feedbacks"][] = [
                "is_positive" => $value["class"] == "positive",
                "text"        => $value["text"]
            ];
        }

        return $dataArr;
    }

    public function getKeywordSeoResult($keywords): array
    {
        // Merge Array
        $allKeywordsArr   = array_merge($keywords["main_keywords"], $keywords["related_keywords"]);

        $keywordSeoResult = $this->seoService->generateBulkKeywordAnalysis($allKeywordsArr);
        
        return $this->prepareBulkKeywordsResponse($keywordSeoResult, $keywords);
    }

    public function prepareBulkKeywordsResponse($keywordSeoResult, $keywords)
    {        
        $data = json_decode($keywordSeoResult, true);

        $keywordsArray = [];

        if (isset($data['data']['data']) && is_array($data['data']['data'])) {
            foreach ($data['data']['data'] as $item) {
                // Use the keyword as the key
                $keyword = $item['keyword'] ?? 'unknown_keyword';
                $keywordType = in_array($keyword, $keywords['main_keywords']) ? 'main_keywords' : (in_array($keyword, $keywords['related_keywords']) ? 'related_keywords' : '--');

                // Prepare the details for each keyword
                $keywordsArray[$keywordType][$keyword] = [
                    'competition'       => $item['competition'] ?? null,
                    'cpc'               => $item['cpc'] ?? null,
                    'categories'        => $item['categories'] ?? null,
                    'search_volume'     => $item['search_volume'] ?? null,
                    'monthly_searches'  => $item['monthly_searches'] ?? []
                ];
            }
        }

        Log::info("SEO keywords : ".json_encode($keywordsArray));
        wLog("SEO keywords", $keywordsArray, logService()::LOG_OPEN_AI);
        file_put_contents("keywords_seo_result.json", json_encode($keywordsArray));

        return $keywordsArray;
    }



    public function getJson()
    {
        return '{
	"status": "ok",
	"custom_settings": 0,
	"excluded_tools": 0,
	"data": {
		"Overview": {
			"Keyword": "laravel api guidelines",
			"Overall SEO score": 30,
			"Available SEO points": 330,
			"Earned SEO points": 100.6245,
			"Summary": {
				"Errors": 9,
				"Warnings": 2,
				"Optimized": 5
			}
		},
		"Title tag": {
			"Title tag element": 1,
			"Title tag content": "5 Essential Laravel API Guidelines for Best Practices",
			"Title length": 53,
			"Focus keywords position": 24,
			"Focus keywords found": 1,
			"Keyword": "laravel api guidelines",
			"Feedback details": {
				"Status": {
					"text": "Your content contains a Title tag",
					"class": "positive"
				},
				"Length": {
					"text": "Your Title tag is the perfect length",
					"class": "positive"
				},
				"Focus keyword": {
					"text": "Your Title tag targets your focus keyword: u0022laravel api guidelinesu0022",
					"class": "positive"
				},
				"Focus keywords position": {
					"text": "You are using your focus keyword at the beginning of your Title tag",
					"class": "positive"
				}
			},
			"Max SEO score available": 90,
			"SEO Score": 90
		},
		"Meta description": {
			"Meta description element": 1,
			"Meta description content": "Explore the power of Laravel, a leading PHP framework, for building robust web applications. Learn its features, benefits, and best practices to enhance your development skills",
			"Meta description length": 176,
			"Focus keywords position": 0,
			"Focus keywords found": 0,
			"Keyword": "laravel api guidelines",
			"Feedback details": {
				"Status": {
					"text": "Your content contains a Meta description",
					"class": "positive"
				},
				"Length": {
					"text": "Your Meta description is too long, a maximum of 160 characters is recommended",
					"class": "couldhave"
				},
				"Focus keyword": {
					"text": "You should use your focus keyword: u0022laravel api guidelinesu0022 in your Meta description",
					"class": "negative"
				},
				"Focus keywords position": {
					"text": "You should use focus keyword at the beginning of your Meta description tag",
					"class": "negative"
				}
			},
			"Max SEO score available": 20,
			"SEO Score": 4.1245
		},
		"Page headings": {
			"H1": 0,
			"H2": 0,
			"H3": 0,
			"H4": 5,
			"H5": 0,
			"H6": 0,
			"H1 count": 0,
			"H1 content": "",
			"Focus keywords found": 0,
			"Keyword": "laravel api guidelines",
			"Feedback details": {
				"Not found": {
					"text": "You should add a H1 to your content",
					"class": "negative"
				},
				"Focus keyword": {
					"text": "You should use your focus keyword: u0022laravel api guidelinesu0022 in your H1 tag",
					"class": "negative"
				}
			},
			"Max SEO score available": 20,
			"SEO Score": 0
		},
		"Content length": {
			"Word count total": 362,
			"Corrected word count": 362,
			"Anchor text words": 0,
			"Anchor Percentage": 0,
			"Feedback details": {
				"Status": {
					"text": "You should write more content for this page",
					"class": "couldhave"
				}
			},
			"Max SEO score available": 50,
			"SEO Score": 6.5
		},
		"On page links": {
			"Total links": 0,
			"External links": 0,
			"Internal": 0,
			"Nofollow count": 0,
			"Duplicate links": 0,
			"No alt tag": 0,
			"Feedback details": {
				"Status": {
					"text": "Your content contains less than 2 links",
					"class": "negative"
				}
			},
			"Max SEO score available": 40,
			"SEO Score": 0
		},
		"Image analysis": {
			"Number of images": 0,
			"Image name contains keyword": 0,
			"Image ALT tag contains keyword": 0,
			"Keyword": "laravel api guidelines",
			"Feedback details": {
				"Status": {
					"text": "You should add an Image to your content",
					"class": "negative"
				},
				"Image name contains keyword": {
					"text": "You should use your focus keyword: u0022laravel api guidelinesu0022 in your image Name",
					"class": "negative"
				},
				"Image ALT tag contains keyword": {
					"text": "You should use your focus keyword: u0022laravel api guidelinesu0022 in your image ALT Tag",
					"class": "negative"
				}
			},
			"Max SEO score available": 20,
			"SEO Score": 0
		},
		"Keyword usage": {
			"Keyword": "laravel api guidelines",
			"Keyword type": "N/A",
			"Frequency": 0,
			"Keyword density": 0,
			"Feedback details": {
				"Status": {
					"text": "You should add your focus keyword to the content of your page",
					"class": "negative"
				}
			},
			"Max SEO score available": 90,
			"SEO Score": 0
		}
	},
	"Google helpful content guidelines": {
		"Questions": {
			"Content and quality": [
				"Does the content provide original information, reporting, research, or analysis?",
				"Does the content provide a substantial, complete, or comprehensive description of the topic?",
				"Does the content provide insightful analysis or interesting information that is beyond the obvious?",
				"If the content draws on other sources, does it avoid simply copying or rewriting those sources, and instead provide substantial additional value and originality?",
				"Does the main heading or page title provide a descriptive, helpful summary of the content?",
				"Does the main heading or page title avoid exaggerating or being shocking in nature?",
				"Is this the sort of page youu0027d want to bookmark, share with a friend, or recommend?",
				"Would you expect to see this content in or referenced by a printed magazine, encyclopedia, or book?",
				"Does the content provide substantial value when compared to other pages in search results?",
				"Does the content have any spelling or stylistic issues?",
				"Is the content produced well, or does it appear sloppy or hastily produced?",
				"Is the content mass-produced by or outsourced to a large number of creators, or spread across a large network of sites, so that individual pages or sites donu0027t get as much attention or care?"
			],
			"Expertise": [
				"Does the content present information in a way that makes you want to trust it, such as clear sourcing, evidence of the expertise involved, background about the author or the site that publishes it, such as through links to an author page or a siteu0027s About page?",
				"If someone researched the site producing the content, would they come away with an impression that it is well-trusted or widely-recognized as an authority on its topic?",
				"Is this content written or reviewed by an expert or enthusiast who demonstrably knows the topic well?",
				"Does the content have any easily-verified factual errors?"
			],
			"Focus on people-first content": [
				"Do you have an existing or intended audience for your business or site that would find the content useful if they came directly to you?",
				"Does your content clearly demonstrate first-hand expertise and a depth of knowledge (for example, expertise that comes from having actually used a product or service, or visiting a place)?",
				"Does your site have a primary purpose or focus?",
				"After reading your content, will someone leave feeling theyu0027ve learned enough about a topic to help achieve their goal?",
				"Will someone reading your content leave feeling like theyu0027ve had a satisfying experience?"
			],
			"Avoid creating search engine-first content": [
				"Is the content primarily made to attract visits from search engines?",
				"Are you producing lots of content on many different topics in hopes that some of it might perform well in search results?",
				"Are you using extensive automation to produce content on many topics?",
				"Are you mainly summarizing what others have to say without adding much value?",
				"Are you writing about things simply because they seem trending and not because youu0027d write about them otherwise for your existing audience?",
				"Does your content leave readers feeling like they need to search again to get better information from other sources?",
				"Are you writing to a particular word count because youu0027ve heard or read that Google has a preferred word count? (No, we donu0027t.)",
				"Did you decide to enter some niche topic area without any real expertise, but instead mainly because you thought youu0027d get search traffic?",
				"Does your content promise to answer a question that actually has no answer, such as suggesting thereu0027s a release date for a product, movie, or TV show when one isnu0027t confirmed?",
				"Are you changing the date of pages to make them seem fresh when the content has not substantially changed?",
				"Are you adding a lot of new content or removing a lot of older content primarily because you believe it will help your search rankings overall by somehow making your site seem u0022fresh?u0022 (No, it wonu0027t)"
			],
			"Who created the content?": [
				"Is it self-evident to your visitors who authored your content?",
				"Do pages carry a byline, where one might be expected?",
				"Do bylines lead to further information about the author or authors involved, giving background about them and the areas they write about?"
			],
			"How was the content created?": [
				"Is the use of automation, including AI-generation, self-evident to visitors through disclosures or in other ways?",
				"Are you providing background about how automation or AI-generation was used to create content?",
				"Are you explaining why automation or AI was seen as useful to produce content?"
			]
		},
		"Official Google documentation": [
			"https://developers.google.com/search/docs/fundamentals/creating-helpful-content",
			"https://developers.google.com/search/blog/2019/08/core-updates"
		]
	}
}';
    }

}
