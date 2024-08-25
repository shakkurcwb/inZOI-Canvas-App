<?php

namespace App\Models;

class Article extends BaseModel
{
    protected $fillable = [
        'message_id',
        'author_id',
        'title',
        'description',
        'publication_date',
    ];

    protected $casts = [
        'publication_date' => 'date',
    ];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function images()
    {
        return $this->hasMany(ArticleImage::class);
    }

    public function artifacts()
    {
        return $this->hasOne(ArticleArtifact::class);
    }

    public function metrics()
    {
        return $this->hasOne(ArticleMetric::class);
    }
}