<?php

namespace App\Jobs;

use App\Models\Message;
use App\Models\Author;
use App\Models\Article;
use App\Models\ArticleArtifact;
use App\Models\ArticleImage;
use App\Models\ArticleMetric;

use App\Adapters\ScrapperApi;
use App\Adapters\ContentGenerator;

class ProcessMessageJob extends BaseJob
{
    public Message $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function handle(ScrapperApi $api, ContentGenerator $generator): int
    {
        $payload = $api->scrap($this->message->source_url);

        if (empty($payload)) {
            return 1;
        }

        $author = Author::updateOrCreate([
            'name' => $payload['creator']['name'],
        ], [
            'profile_url' => $payload['creator']['profile_url'],
            'avatar_url' => $payload['creator']['avatar_url'],
        ]);

        $article = Article::updateOrCreate([
            'message_id' => $this->message->id,
            'author_id' => $author->id,
        ], [
            'title' => $payload['title'],
            'description' => $payload['description'],
            'publication_date' => $payload['publication_date'],
        ]);

        foreach ($payload['images'] as $image) {
            ArticleImage::updateOrCreate([
                'article_id' => $article->id,
                'url' => $image,
            ]);
        }

        $content = $generator->generate($payload);

        ArticleArtifact::updateOrCreate([
            'article_id' => $article->id,
        ], [
            'payload' => $payload,
            'content' => $content,
            'generated_at' => now(),
        ]);

        ArticleMetric::updateOrCreate([
            'article_id' => $article->id,
        ], [
            'likes' => $payload['stats']['likes'],
            'downloads' => $payload['stats']['downloads'],
        ]);

        $this->message->update(['processed_at' => now()]);

        return 0;
    }

    public const DUMMY_RESPONSE = [
        "creator" => [
          "avatar_url" => "https://cdn.canvas.playinzoi.com/acc-foV9a28qby1mZzXMR89lcY/prfimg/wwqi_Purple%20and%20Yellow%20Playful%20YouTube%20Profile%20Picture%20(12).png",
          "name" => "Nesmeralda",
          "profile_url" => "https://canvas.playinzoi.com/en-US/profile/acc-foV9a28qby1mZzXMR89lcY",
        ],
        "description" => "Kartoffeln>>>>>",
        "images" => [
          0 => "https://cdn.canvas.playinzoi.com/acc-foV9a28qby1mZzXMR89lcY/ugc/gRC8/thumbnail4.jpg",
          1 => "https://cdn.canvas.playinzoi.com/acc-foV9a28qby1mZzXMR89lcY/ugc/gRC8/thumbnail5.jpg",
          2 => "https://cdn.canvas.playinzoi.com/acc-foV9a28qby1mZzXMR89lcY/ugc/gRC8/thumbnail6.jpg",
          3 => "https://cdn.canvas.playinzoi.com/acc-foV9a28qby1mZzXMR89lcY/ugc/gRC8/thumbnail7.jpg",
        ],
        "publication_date" => "2024.08.17",
        "stats" => [
          "downloads" => 32,
          "likes" => 73,
        ],
        "title" => "Heilige Kartoffilus",
        "url" => "https://canvas.playinzoi.com/en-US/gallery/gal-240817-103657-9960000",
    ];
}
