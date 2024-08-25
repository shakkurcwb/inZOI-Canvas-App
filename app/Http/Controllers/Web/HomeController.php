<?php

namespace App\Http\Controllers\Web;

use App\Adapters\MetricsService;

class HomeController extends WebController
{
    public function index(MetricsService $service)
    {
        $most_likes_articles = $service->getMostLikes();

        $most_downloads_articles = $service->getMostDownloads();

        $most_likes_authors = $service->getMostLikesAuthors();

        $most_downloads_authors = $service->getMostDownloadsAuthors();

        return view('pages.home.index', [
            'most_likes_articles' => $most_likes_articles,
            'most_downloads_articles' => $most_downloads_articles,
            'most_likes_authors' => $most_likes_authors,
            'most_downloads_authors' => $most_downloads_authors,
        ]);
    }
}