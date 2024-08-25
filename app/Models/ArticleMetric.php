<?php

namespace App\Models;

class ArticleMetric extends BaseModel
{
    protected $fillable = [
        'article_id',
        'downloads',
        'likes',
    ];

    protected $casts = [
        'downloads' => 'integer',
        'likes' => 'integer',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}