<?php

namespace Modules\SocialPilot\App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AiAssistant\AiAssistantRequest;
use App\Models\ArticlesSocialPost;
use App\Models\GeneratedContent;
use App\Services\Balance\BalanceService;
use App\Services\Integration\IntegrationService;
use App\Services\Model\Article\ArticleService;
use App\Services\Model\Prompt\PromptGroupService;
use App\Services\Model\Prompt\PromptService;
use Illuminate\Http\Request;
use App\Traits\Api\ApiResponseTrait;
use Modules\SocialPilot\App\Http\Requests\PostRequestForm;
use Modules\SocialPilot\App\Services\Account\AccountService;
use Modules\SocialPilot\App\Services\Platform\PlatformService;
use Modules\SocialPilot\App\Services\Post\SocialPostService;
use Modules\SocialPilot\App\Services\QuickText\QuickTextService;

class SocialPostController extends Controller
{
    use ApiResponseTrait;

    protected $quickTextService;
    protected $platformService;
    protected $platformAccountService;
    protected $socialPostService;
    protected $articleService;

    public function __construct()
    {
        $this->quickTextService         = new QuickTextService();
        $this->platformService          = new PlatformService();
        $this->platformAccountService   = new AccountService();
        $this->socialPostService        = new SocialPostService();
        $this->articleService           = new ArticleService();
    }

    # aiAssistantForm
    public function aiAssistantForm(Request $request)
    {
        $data['groups']             = (new PromptGroupService())->getAll(null, true);
        $data['groupPrompts']       =  (new PromptService())->getAll(true, true);
        $data =  view('socialpilot::posts.forms.generate', $data)->render();
        return $this->sendResponse(
            appStatic()::SUCCESS_WITH_DATA,
            localize("Successfully retrieved ai assistant form"),
            $data
        );
    }
    
    # save contents before starting streaming
    public function saveAiAssistantContent(AiAssistantRequest $request)
    {
        try {
            // Checking Remaining Word balance.
            checkWordBalance(); // Check permissions and word balance

            // Is AiAssistant Allowed
            checkValidCustomerFeature(allowAiAssistant());  // Check permissions and word balance
             
            $generatedContent = GeneratedContent::query()->create($request->getData());

            // saving generated_content_id into session
            session()->put([
                sessionLab()::SESSION_AI_ASSISTANT_GENERATED_CONTENT_ID => $generatedContent->id
            ]);

            return $this->sendResponse(
              appStatic()::SUCCESS_WITH_DATA,
              localize("Ai Assistant content"),
                $generatedContent,
                [],
                [
                    "params" => $request->all()
                ]
            );
        } catch (\Throwable $e) {
            wLog("Failed to Generate Ai Assistant Content", errorArray($e), logService()::LOG_OPEN_AI);

            return $this->sendResponse(
                appStatic()::VALIDATION_ERROR,
                $e->getMessage(),
                [],
                errorArray($e)
            );
        }
    }

    # streaming
    public function streamAiAssistant(Request $request)
    {
        try{
            // Check Balance
            checkWordBalance();

            // Is AiAssistant Allowed
            checkValidCustomerFeature(allowAiAssistant());

            $integrationService = new IntegrationService();
            $request->merge([
                'stream'=>true
            ]);

            return $integrationService->contentGenerator(aiAssistantEngine(), $request);
        } catch(\Throwable $e) {
            wLog("Failed to Generate Ai Assistant Text", errorArray($e), logService()::LOG_OPEN_AI);

            return $this->streamErrorResponse($e->getMessage());
        }
    }

    # Display a listing of the resource. 
    public function index(Request $request)
    {
        $data   = $this->socialPostService->index();
        if ($request->ajax()) {
           return view('socialpilot::posts._contents', $data)->render();
        }
        return view('socialpilot::posts.index', $data);
    }

    # create posts
    public function create(Request $request)
    {
        checkPostCreateBalance();

        $data['quickTexts']         = ($this->quickTextService->index())["details"]; 
        $data['platforms']          = ($this->platformService->index())["details"]; 
        $data['platformAccounts']   = ($this->platformAccountService->index())["details"];

        $data['articleSocialPost']  = null;
        $data['activeBy']           = "index";
        if($request->id != null){
            $data['articleSocialPost'] = ArticlesSocialPost::whereId((int) $request->id)->first();
            $data['activeBy']           = "platform";
        }

        return view('socialpilot::posts.create', $data);
    }

    # store posts
    public function store(PostRequestForm $request)
    { 
        checkPostCreateBalance();

        try {
            $this->socialPostService->store($request); 

            // update post balance
            try {
                (new BalanceService())->updateUserPostBalance();
            } catch (\Throwable $th) {
                //throw $th;
            }

            return $this->sendResponse(
                appStatic()::SUCCESS_WITH_DATA,
                localize("Successfully created posts, see post listing for more information"),
                []
            );
        } catch (\Throwable $e) {
            wLog("Failed to create post", errorArray($e));
            return $this->sendResponse(
                appStatic()::VALIDATION_ERROR,
                localize("Failed to create post"),
                [],
                errorArray($e)
            );
        }
    }

    # destroy a resource
    public function destroy($id)
    {
        $data = $this->socialPostService->findById($id);
        try {
            return $this->sendResponse(
                appStatic()::SUCCESS_WITH_DATA,
                localize("Successfully deleted post"),
                $data->delete()
            );
        } catch (\Throwable $th) {
            wLog("Failed to Delete Folder", errorArray($th));
            return $this->sendResponse(
                appStatic()::VALIDATION_ERROR,
                localize("Failed to delete the post"),
                [],
                errorArray($th)
            );
        }
    }

    # generate social post form
    public function showArticlePostGenerationForm(Request $request)
    {
        if ($request->id) {
            $data['article']            = $this->articleService->findArticleById((int)$request->id);
            $data['platforms']          = $this->platformService->index(true)['details'];
            $data['articleSocialPosts'] = ArticlesSocialPost::whereArticleId($request->id)->get();

            return view('socialpilot::posts.forms.social-post-from-article', $data)->render();
        }

        return;
    }
 
    # generate social post
    public function articlePostGeneration(Request $request)
    {
        try{ 
            // Check Balance
            checkWordBalance();
 
            // Is AiAssistant Allowed
            checkValidCustomerFeature(allowAiAssistant());

            $platforms          = $this->platformService->findByIds($request->platform_ids);
            $article            = $this->articleService->findArticleById((int) $request->article_id);

            $integrationService = new IntegrationService();

            foreach ($platforms as $platform) {
                $request->merge([
                    'platform_name' => $platform->name,
                    'prompt'        => $article->article ?? 'Generate a random post',
                ]);
                $generatedContent = $integrationService->contentGenerator(aiAssistantEngine(), $request);
                if ($generatedContent) {
                    $this->saveGeneratedArticlePosts($generatedContent, $article, $platform);
                }
            } 
            
            $articleSocialPosts = ArticlesSocialPost::whereArticleId($article->id)->get();
            $view = view('socialpilot::posts._article_social_posts', ['articleSocialPosts' => $articleSocialPosts])->render();

            return $this->sendResponse(
                appStatic()::SUCCESS_WITH_DATA,
                localize("Successfully generated social posts"),
                $view
            );
        } catch(\Throwable $e) {
            wLog("Failed to Generate Social Posts", errorArray($e), logService()::LOG_OPEN_AI);
            return $this->sendResponse(500, $e->getMessage());
        }
    }

    # save generated article posts
    private function saveGeneratedArticlePosts($generatedContent, $article, $platform)
    {
        $user = user();
        $data = [
            'article_id'    => $article->id,
            'platform_id'   => $platform->id,
            'post_details'  => $generatedContent->response,
            'user_id'       => $user->id,
            'is_active'     => 1,
            'created_by_id' => $user->id,
            'updated_by_id' => $user->id,
        ];
        ArticlesSocialPost::create($data);
    }
}
