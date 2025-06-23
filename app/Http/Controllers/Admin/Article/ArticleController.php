<?php

namespace App\Http\Controllers\Admin\Article;

use App\Http\Requests\Article\ArticleMetaAndKeywordStoreRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Api\ApiResponseTrait;
use App\Services\Model\Article\ArticleService;
use App\Http\Requests\Article\ArticleUpdateRequestForm;

class ArticleController extends Controller
{
    use ApiResponseTrait;
    protected $appStatic;
    protected $articleService;

    public function __construct()
    {
        $this->appStatic = appStatic();
        $this->articleService = new ArticleService();
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data['lists'] = $this->articleService->getAll(true, null, ['generatedArticles', 'latestArticle']);
            
            return view('backend.admin.articles.render.article-list', $data)->render();
        }

        return view('backend.admin.articles.index', []);
    }

    public function create(Request $request)
    {
        try{
            $data = $this->articleService->getWordPressFormFieldData();
            $data["showGenerateSmallBtn"] = true;

            return view("backend.admin.articles.add_article", $data);
        }
        catch(\Throwable $e){
            wLog("Article Create Failed", errorArray($e));

            flashMessage($e->getMessage(), 'error');

            return redirect()->back()->withErrors($e->getMessage());
        }

    }

    public function show($id)
    {
        try{
            // Get the Article
            $article = $this->articleService->findArticleById($id);

            // Post Ownership validation
            validateRecordOwnerCheck($article);

            $data['article'] = $article;

            return view("backend.admin.seo.article.show-article", $data);
        }
        catch(\Throwable $e){
            wLog("Failed to show article", errorArray($e));

            return redirect()->back();
        }
    }

    public function storeArticleMetaOrKeyword(ArticleMetaAndKeywordStoreRequest $request): \Illuminate\Http\JsonResponse
    {
        try{
            $saveMetaOrKeyword = $this->articleService->updateOrCreateArticleMetaOrKeywordByArticleId($request->article_id,$request->validated());

            $msg = isFocusKeyword($request->is_focus_keyword) ? "Successfully saved Focus Keyword" : "Successfully saved Meta Description";

            return $this->sendResponse(
                $this->appStatic::SUCCESS_WITH_DATA,
                localize($msg),
                $saveMetaOrKeyword
            );
        }
        catch(\Throwable $e){
            wLog("Failed to save keyword or meta description", errorArray($e));

            return $this->sendResponse(
              $this->appStatic::NOT_FOUND,
              localize("Failed to save keyword or meta description"),
              [],
              errorArray($e)
            );
        }
    }

    public function edit($id)
    {
        $data                         = $this->articleService->getWordPressFormFieldData();
        
        $article = $this->articleService->findArticleById($id, ['latestArticle', 'latestOutline']);
        $data['editArticle']          = $article;
        
        $outlines                     = explode(',', $article->selected_outline);
        $data['editArticleOutlines']  = $outlines;

        $isWordpressArticle           = isWordpressArticle($article->article_source);
        $data['isWordpressArticle']   = $isWordpressArticle;
        $data["showGenerateSmallBtn"] = !$isWordpressArticle; // When $isWordpressArticle == true, don't show generate small button either Show.

        return view("backend.admin.articles.add_article", $data);
    }

    public function update(ArticleUpdateRequestForm $request, $id)
    {
        try{
            $article = $this->articleService->update($id, $request->getData());

            return $this->sendResponse(
                $this->appStatic::SUCCESS_WITH_DATA,
                localize("Article Update Successfully"),
                $article
            );
        }
        catch(\Throwable $e){
            wLog("Failed to update Article", errorArray($e));

            return $this->sendResponse(
              $this->appStatic::NOT_FOUND,
              localize("Failed to update Article"),
              [],
              errorArray($e)
            );
        }
    }

    public function destroy(Request $request, $id)
    {
        try{
            $article = $this->articleService->findArticleById($id);

            // Post Ownership validation
            validateRecordOwnerCheck($article);

            $article->delete();

            return $this->sendResponse(
                $this->appStatic::SUCCESS_WITH_DATA,
                localize("Article Deleted Successfully"),
            );
        }
        catch(\Throwable $e){
            wLog("Failed to delete Article", errorArray($e));

            return $this->sendResponse(
              $this->appStatic::VALIDATION_ERROR,
              localize("Failed to delete Article"),
              [],
              errorArray($e)
            );
        }
    }

}
