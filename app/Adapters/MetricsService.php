<?php

namespace App\Adapters;

use Illuminate\Database\Eloquent\Collection;

use App\Models\ArticleMetric;

class MetricsService
{
    public function getMostLikes(int $per_page = 10): Collection
    {
        $query = ArticleMetric::query()->orderBy('likes', 'desc');

        return $query->limit($per_page)->get();
    }

    public function getMostDownloads(int $per_page = 10): Collection
    {
        $query = ArticleMetric::query()->orderBy('downloads', 'desc');

        return $query->limit($per_page)->get();
    }

    public function getMostLikesAuthors(int $per_page = 10): Collection
    {
        $query = ArticleMetric::query()->selectRaw('authors.*, SUM(article_metrics.likes) as total_likes')
            ->join('articles', 'articles.id', '=', 'article_metrics.article_id')
            ->join('authors', 'authors.id', '=', 'articles.author_id')
            ->groupBy('authors.id')
            ->orderBy('total_likes', 'desc');

        return $query->limit($per_page)->get();
    }
    
    public function getMostDownloadsAuthors(int $per_page = 10): Collection
    {
        $query = ArticleMetric::query()->selectRaw('authors.*, SUM(article_metrics.downloads) as total_downloads')
        ->join('articles', 'articles.id', '=', 'article_metrics.article_id')
        ->join('authors', 'authors.id', '=', 'articles.author_id')
            ->groupBy('authors.id')
            ->orderBy('total_downloads', 'desc');

        return $query->limit($per_page)->get();
    }
}
