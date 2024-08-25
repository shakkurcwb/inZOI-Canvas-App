<?php

namespace App\Models;

class Message extends BaseModel
{
    protected $fillable = [
        'source_url',
        'processed_at',
    ];

    protected $casts = [
        "processed_at" => "datetime",
    ];

    public function article()
    {
        return $this->hasOne(Article::class);
    }
}