<?php

namespace Modules\WordpressBlog\App\Http\Controllers\Wp;

use App\Http\Controllers\Controller;
use App\Services\Action\WordpressArticleActionService;
use App\Services\Model\Article\ArticleService;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\WordpressBlog\App\Http\Requests\ImportPostContentRequest;

class WordpressArticleController extends Controller
{
    use ApiResponseTrait;
    private $wordpressArticleService;
    public function __construct()
    {
        $this->wordpressArticleService = new WordpressArticleActionService();
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            // Wordpress post searching
            if($request->has("searchWordpressPost") && !empty($request->search)){

                return $this->wordpressArticleService->searchWordpressPosts($request->search);
            }


            $articles = (new ArticleService())->getAll(true, null, ['generatedArticles', 'latestArticle']);

            $data["lists"] = $articles;

            return view('wordpressblog::articles.render.article-list', $data)->render();
        }

        $data["wordpressArticles"]        = $this->wordpressArticleService->getWordpressArticles(getUserParentId());
        $data["importWordpressPostBlade"] = view("wordpressblog::articles.render.form-import-wordpress-article")->render();


        return view("wordpressblog::articles.index")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('wordpressblog::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    public function importArticle(ImportPostContentRequest $request, WordpressArticleActionService $wordpressArticleActionService)
    {
        $appStatic = appStatic();

        try{
            \DB::beginTransaction();
            $article = $wordpressArticleActionService->importWordpressPostContent($request->wp_post_id, getUserParentId());
            \DB::commit();

            return $this->sendResponse(
                $appStatic::SUCCESS_WITH_DATA,
                localize("Successfully imported Content"),
                $article,
            );
        }
        catch(\Throwable $e){
            \DB::rollBack();
            wLog("Failed to import Content", errorArray($e));

            return $this->sendResponse(
                $appStatic::NOT_FOUND,
                "Failed to import Content",
                [],
                errorArray($e)
            );
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('wordpressblog::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, ArticleService $articleService)
    {
        $article                      = $articleService->findArticleById($id, ['latestArticle', 'latestOutline']);
        $data                         = $articleService->getWordPressFormFieldData();
        $data['editArticle']          = $article;
        $outlines                     = explode(',', $data['editArticle']->selected_outline);
        $data['editArticleOutlines']  = $outlines;
        $isWordpressArticle           = isWordpressArticle($article->article_source);
        $data['isWordpressArticle']   = $isWordpressArticle;
        $data["showGenerateSmallBtn"] = !$isWordpressArticle; // When $isWordpressArticle == true, don't show generate small button either Show.

        return view("backend.admin.articles.add_article", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
