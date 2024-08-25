<?php

namespace App\Models;

class Author extends BaseModel
{
    protected $fillable = [
        'name',
        'profile_url',
        'avatar_url',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function metrics()
    {
        return $this->hasManyThrough(ArticleMetric::class, Article::class);
    }
}