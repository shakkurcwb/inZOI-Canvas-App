<?php

namespace App\Adapters;

use Illuminate\Support\Facades\Http;

class ScrapperApi
{
    const BASE_URL = 'http://127.0.0.1:5000/';

    public function scrap(string $url): array
    {
        $response = Http::timeout(60)->get(self::BASE_URL, [
            'url' => $url,
        ]);

        if ($response->failed()) {
            throw new \Exception('Failed to scrap the article: ' . str($response->body()));
        }

        return $response->json();
    }
}