@extends('layouts.app-wrapper')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Show Article #{{ $article->id }}</h1>
        <div class="d-flex gap-2">
            @if ($article->artifacts->released_at)
                <form action="{{ route('messages.publish', $article->message_id) }}" method="POST" class="mb-0">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <i class="fa-solid fa-flag-checkered me-2"></i> Un-Publish
                    </button>
                </form>
            @else
                <form action="{{ route('messages.publish', $article->message_id) }}" method="POST" class="mb-0">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-flag-checkered me-2"></i> Publish
                    </button>
                </form>
            @endif

            <form action="{{ route('messages.process', $article->message_id) }}" method="POST" class="mb-0">
                @csrf
                <button type="submit" class="btn btn-primary">Refresh Article</button>
            </form>

            <a href="{{ route('articles.index') }}" class="btn btn-secondary">Go Back</a>
        </div>
    </div>

    @include('components.notifications.status')

    <div class="d-flex justify-content-between mt-3">
        <div class="card" style="width: 20rem;">
            <div class="card-body text-center">
                <h5 class="card-title">Downloads <i class="fas fa-download text-primary ms-2"></i></h5>
                <p class="card-text h1 text-success">{{ $article->metrics->downloads }}</p>
            </div>
        </div>
        <div class="card" style="width: 20rem;">
            <div class="card-body text-center">
                <h5 class="card-title">Likes <i class="fas fa-thumbs-up text-primary ms-2"></i></h5>
                <p class="card-text h1 text-success">{{ $article->metrics->likes }}</p>
            </div>
        </div>
        <div class="card" style="width: 20rem;">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Creator</h5>
                        <a target="_blank" href="{{ $article->author->profile_url }}">
                            <p class="card-text">{{ $article->author->name }}</p>
                        </a>
                    </div>
                    @if ($article->author->avatar_url)
                        <a target="_blank" href="{{ $article->author->profile_url }}">
                            <img width="80px" src="{{ $article->author->avatar_url }}"
                                alt="{{ $article->author->name }}" class="img-thumbnail">
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card my-3">
        <div class="card-body">
            <h5 class="card-title">{{ $article->title }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">{{ $article->description }}</h6>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($article->images as $image)
                    <div class="col">
                        <div class="card">
                            <img src="{{ $image->url }}" class="card-img-top" alt="{{ $image->alt }}">
                        </div>
                    </div>
                @endforeach
                <div class="col">
                    <div class="card h-100 d-flex justify-content-center align-items-center">
                        <a target="_blank" href="{{ $article->message->source_url }}">
                            <h5 class="card-title">View on Canvas...</h5>
                        </a>
                    </div>
                </div>
            </div>
            @if ($article->artifacts->content)
                <hr>
                <div class="mt-4">
                    <script>
                        function copy() {
                            var copyText = document.querySelector('textarea');
                            copyText.select();
                            document.execCommand('copy');
                        }
                    </script>
                    <textarea class="form-control" rows="10" readonly onclick="copy()">{{ $article->artifacts->content }}</textarea>
                </div>
            @endif
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <strong>Publication Date:</strong> {{ $article->publication_date->format('Y-m-d') }}
                <small>({{ $article->publication_date->diffForHumans() }})</small>
            </li>
            <li class="list-group-item">
                <strong>Last Updated At:</strong> {{ $article->updated_at->format('Y-m-d H:i:s') }}
                <small>({{ $article->updated_at->diffForHumans() }})</small>
            </li>
            @if ($article->artifacts->generated_at)
                <li class="list-group-item">
                    <strong>Content Generated At:</strong> {{ $article->artifacts->generated_at->format('Y-m-d') }}
                    <small>({{ $article->artifacts->generated_at->diffForHumans() }})</small>
                </li>
            @endif
            @if ($article->artifacts->released_at)
                <li class="list-group-item">
                    <strong>Content Released At:</strong> {{ $article->artifacts->released_at->format('Y-m-d') }}
                    <small>({{ $article->artifacts->released_at->diffForHumans() }})</small>
                </li>
            @endif
        </ul>
    </div>
@endsection
