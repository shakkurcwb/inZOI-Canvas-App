<?php

namespace App\Models;

class ArticleArtifact extends BaseModel
{
    protected $fillable = [
        'article_id',
        'payload',
        'content',
        'generated_at',
        'released_at',
    ];

    protected $casts = [
        'payload' => 'array',
        'generated_at' => 'datetime',
        'released_at' => 'datetime',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}