<?php

namespace App\Services\Model\Article;

use App\Models\Article;
use App\Services\Model\Tag\TagsService;
use App\Services\Model\Blog\BlogCategoryService;
use Modules\WordpressBlog\App\Services\Action\WpUserActionService;
use Modules\WordpressBlog\Services\Credentials\WpCredentialService;

/**
 * Class ArticleService.
 */
class ArticleService
{
    public function getAll($paginatePluckOrGet = null, $onlyActive = null, $withRelationship = []) {

        $query = Article::query()->filters()->latest("id")->where('created_by_id', userID());

        (empty($withRelationship) ? $query : $query->with($withRelationship));

        if(!is_null($onlyActive)){
            $query->isActive($onlyActive);
        }

        // Pluck Data Returning
        if (is_null($paginatePluckOrGet)) {
            return $query->pluck("id", "topic");
        }


        return $paginatePluckOrGet ? $query->paginate(maxPaginateNo()) : $query->get();
    }

    public function storeArticle(array $payloads)
    {
        \Log::info("Before Article Store". json_encode($payloads));

        return Article::query()->create($payloads);
    }

    public function findArticleById($id, $withRelationships = [])
    {
        $query = Article::query();

        // Bind Relationship when $withRelationship is not empty
        (!empty($withRelationships) ? $query->with($withRelationships) : false);

        return $query->findOrFail($id);
    }

    public function updateOrCreateArticleMetaOrKeywordByArticleId($articleId, array $payloads)
    {
        $columnName = isFocusKeyword($payloads['is_focus_keyword']) ? "focus_keyword" : "selected_meta_description";

        return Article::query()
            ->where('id', $articleId)
            ->update([$columnName => $payloads['content_body']]);
    }

    public function update($id, array $payloads, null | object $article = null) : object
    {
        if(array_key_exists('selected_image', $payloads)) {
            $payloads['selected_image'] = $this->removeDomain($payloads['selected_image']);
        }

        // Saving by .saveContent btn click
        $payloads["is_article_saved_by_save_changes_at"] = true;

        // Checking is $article is null
        if(empty($article)) {
            $article = $this->findArticleById($id);
        }

        $article->update($payloads);

        return $article;
    }

    private function removeDomain($url): bool|int|array|string|null
    {
        // Use parse_url to get the path component of the URL
        return parse_url($url, PHP_URL_PATH);
    }

    public function getWordPressFormFieldData(): array
    {
       $data = [];
       if(isModuleActive('WordpressBlog') && wpCredential()) {
           $data['categories'] = (new BlogCategoryService())->getAll(false, true, [], [['wp_id', '!=', null]]);
           $data['tags']       = (new TagsService())->getAll(false, true, [], [['wp_id', '!=', null]]);
           $data['authors']    = (new WpUserActionService())->getWpAuthorList(["user_id" => getUserObject()->id], ['pluck' => ['key' => 'wp_user_id', 'value' => 'name'], 'orderBy' => ['name' => 'ASC']]);
           $data['websites']   = (new WpCredentialService())->getAll('get', true);
       }

       return $data;
    }
    /**
     * Update Generated Content ID
     * */

    public function getDemoKeywords()
    {
        $response = "['main_keywords'=>['Laravel DevOps', 'Laravel development'],'related_keywords'=>['continuous integration', 'server automation', 'deployment pipeline']]";

        // Convert the string to a valid PHP array using eval()
        $dataArr = stringArrayToArray($response);

        return ['main_keywords' => $dataArr['main_keywords'], 'related_keywords' => $dataArr['related_keywords']];
    }

}
