<?php

namespace App\Http\Controllers\Admin\Article;

use App\Http\Controllers\Controller;
use App\Services\Action\WordpressArticleActionService;
use Illuminate\Http\Request;

class WordpressArticleController extends Controller
{
    private $wordpressArticleService;
    public function __construct()
    {
        $this->wordpressArticleService = new WordpressArticleActionService();
    }

    public function index()
    {

        $data["wordpressArticles"] = $this->wordpressArticleService->getWordpressArticles(getUserParentId());

        return view("Wordpress::articles.index", $data);
    }
}
