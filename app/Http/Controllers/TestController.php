<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\Action\UnsplashActionService;
use App\Services\Core\AiConfigService;
use App\Services\OpenAi\OpenAiService;
use App\Traits\Api\ApiResponseTrait;
use Gemini;
use Gemini\Data\Blob;
use GuzzleHttp\Client;
use App\Models\Template;
use Gemini\Enums\MimeType;
use Illuminate\Http\Request;
use Gemini\Data\SafetySetting;
use Gemini\Enums\HarmCategory;
use App\Models\SubscriptionUser;
use Gemini\Data\GenerationConfig;
use Gemini\Enums\HarmBlockThreshold;
use Illuminate\Support\Facades\Http;
use App\Models\SubscriptionUserUsage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Payments\PaymentsController;
use Modules\WordpressBlog\Services\WpBasicAuthService;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Response;
class TestController extends Controller
{
    use ApiResponseTrait;
    public $sessionLab;
    public function __construct()
    {
        $this->sessionLab = sessionLab();
    }

    /**
     * @throws \Exception
     */
    public function index()
    {

        $files = [
            'bulk_keywords_seo.json',

            'title_response.json',
            'title_response_gemini.json',
            'titles.json',

            'outline_response.json',
            'outline_response_gemini.json',

//            'article_data_gemini.txt',
//            'article_text_gemini.txt',
            'gemini_outlines.json',
//            'gemini_outlines_backup.json',
            'keywords.json',
            'keywords_response.json',
            'keywords_response_gemini.json',
            'keywords_seo.json',
            'keywords_seo_response.json',
            'keywords_seo_result.json',
            'meta_response.json',
            'meta_response_gemini.json',

            'seo.json',
            'seo2.json',
            'seoOptimization.json',

        ];

        foreach ($files as $file) {
            $filePath = public_path($file);
            echo "File: " . htmlspecialchars($filePath) . "<br/>";
            if (file_exists($filePath)) {
                $content = file_get_contents($filePath);
                echo nl2br(htmlspecialchars($content)) . "<br/><br/><br/><br/><br/>";
            } else {
                echo "File not found: " . htmlspecialchars($filePath) . "<br/>";
            }
        }

        return $files;


        $contentGenerator = json_decode(file_get_contents("outline_response_gemini.json"));
        $outlines         =  $contentGenerator->response;
        $finalOutlineArr  = [];

        $aiEngine = "openai"; // aiEngine();

        $outlines  = !empty($outlines) && is_string($outlines) ? json_decode(json_encode(json_decode($outlines)), true) : $outlines;

        if(!empty($outlines) && is_array($outlines)) {
            foreach($outlines['outlines'] as $index => $outline) {
                $outline = is_string($outline) ? json_decode($outline, true) : $outline;
                $finalOutlineArr[$index] = $outline;
                if(!empty($outline['outline'])) {
                    foreach($outline['outline'] as $section) {
                        $finalOutlineArr[$index]['outline_only'][] = $section['section'];
                    }
                }
            }
        }

        return $this->sendResponse(
            appStatic()::SUCCESS_WITH_DATA,
            appStatic()::MESSAGE_OUTLINE_GENERATED,
            view("backend.admin.articles.render.render-outlines")->with(["outlines" => $finalOutlineArr])->render(),
            [],
            ["article_id" => $contentGenerator->id, "outlines" => $outlines, "final_outlines" => $finalOutlineArr]
        );


        $html = Article::query()->latest()->first()->article;
        return view("test");
    }

    public function stream()
    {
        $response = new StreamedResponse(function() {
            $html = Article::query()->latest()->first()->article;

// Split the HTML into tokens (tags and words)
            preg_match_all('/(<[^>]+>)|([^<]+)/', $html, $matches);
            $tokens = $matches[0];

            foreach ($tokens as $token) {
                if (str_starts_with($token, '<')) {
                    // If it's an HTML tag, stream character by character
                    $chars = str_split($token);
                    foreach ($chars as $char) {
                        Log::info("Character: {$char}");

                        echo "data: " . $char . "\n\n";
                        ob_flush();
                        flush();
                        usleep(100000); // 100ms delay for tags
                    }
                } else {
                    // If it's text content, stream character by character (preserving spaces)
                    $chars = str_split($token);
                    foreach ($chars as $char) {
                        // Only remove extra spaces between words but preserve single spaces
                        if ($char !== ' ' || !empty($lastChar) && $lastChar !== ' ') {
                            echo "data: " . $char . "\n\n";
                            ob_flush();
                            flush();
                            usleep(10000); // 200ms delay for characters
                        }
                        $lastChar = $char; // Track last character to preserve spaces
                    }
                }
            }
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');

        return $response;
    }

    private function splitHtmlContent($content)
    {
        $output = [];
        $length = strlen($content);
        $isTag = false;
        $buffer = '';

        for ($i = 0; $i < $length; $i++) {
            $char = $content[$i];

            if ($char === '<') {
                if ($buffer !== '') {
                    $output[] = $buffer; // Add the buffered text
                    $buffer = '';
                }
                $isTag = true;
            }

            if ($isTag) {
                $output[] = $char;
            } else {
                if ($char === ' ' || $char === "\n" || $char === "\t") {
                    if ($buffer !== '') {
                        $output[] = $buffer; // Add the buffered text
                        $buffer = '';
                    }
                    continue; // Ignore whitespace
                }
                $buffer .= $char;
            }

            if ($char === '>') {
                $isTag = false;
            }
        }

        if ($buffer !== '') {
            $output[] = $buffer; // Add any remaining buffered text
        }

        return $output;
    }

    public function pictureApi(Request $request, UnsplashActionService $unsplashActionService)
    {
        $pictures    = $unsplashActionService->searchPhotos($request);
        $prepareJson = $unsplashActionService->prepareArr($pictures);

        return view("backend.admin.unsplash.render.render-image")->with(["unsplashImages" => $prepareJson]);
    }

    public function testStream(Request $request)
    {

        return view("test.gemini.stream");
    }

    public function geminiTestStream(Request $request)
    {
        $message = $request->input('message', 'What is Laravel?');

        $gemini = Gemini::client(geminiAiKey()); // Ensure geminiAiKey() returns your API key

        $stream = $gemini->geminiPro()->streamGenerateContent($message);

        return Response::stream(function () use ($stream) {
            foreach ($stream as $response) {
                echo "data: " . $response->text() . "\n\n";
                ob_flush();
                flush();
            }

            // Indicate the end of the stream
            echo "data: [END]\n\n";
            ob_flush();
            flush();
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
        ]);
    }
}
