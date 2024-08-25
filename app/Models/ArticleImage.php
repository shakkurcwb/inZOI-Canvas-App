<?php

namespace App\Models;

class ArticleImage extends BaseModel
{
    protected $fillable = [
        'article_id',
        'url',
        'alt',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}