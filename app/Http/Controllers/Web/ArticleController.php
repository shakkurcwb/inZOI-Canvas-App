<?php

namespace App\Http\Controllers\Web;

use App\Models\Article;

use App\Jobs\ProcessArticleJob;

class ArticleController extends WebController
{
    public function index()
    {
        $articles = Article::orderBy('id', 'desc')->paginate();

        return view('pages.articles.index', [
            'articles' => $articles,
        ]);
    }

    public function create()
    {
        return view('pages.articles.create');
    }

    public function show(Article $article)
    {
        return view('pages.articles.show', [
            'article' => $article,
        ]);
    }
}
