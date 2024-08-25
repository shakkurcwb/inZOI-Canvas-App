@extends('layouts.app-wrapper')

@section('content')
    @include('components.notifications.status')

    <div class="d-flex justify-content-between gap-2 mt-3">

        <div class="w-50">
            <h4 class="text-muted">Top 10 Most-Liked Articles</h4>
            <div class="w-100">
                <table class="table table-sm table-bordered table-striped text-center mb-0">
                    @foreach ($most_likes_articles as $idx => $stats)
                        <tr>
                            <td>#{{ $idx + 1 }}</td>
                            <td>
                                <a href="{{ route('articles.show', $stats->article->id) }}">
                                    {{ $stats->article->title }} by {{ $stats->article->author->name }}
                                    @if ($stats->article->artifacts->released_at)
                                        <i class="fa-regular fa-circle-check ms-2 text-success"></i>
                                    @else
                                        <i class="fa-regular fa-circle-xmark ms-2 text-danger"></i>
                                    @endif
                                </a>
                            </td>
                            <td>{{ $stats->likes }} likes</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <div class="w-50">
            <h4 class="text-muted">Top 10 Most-Downloaded Articles</h4>
            <div class="w-100">
                <table class="table table-sm table-bordered table-striped text-center mb-0">
                    @foreach ($most_downloads_articles as $idx => $stats)
                        <tr>
                            <td>#{{ $idx + 1 }}</td>
                            <td>
                                <a href="{{ route('articles.show', $stats->article->id) }}">
                                    {{ $stats->article->title }} by {{ $stats->article->author->name }}

                                    @if ($stats->article->artifacts->released_at)
                                        <i class="fa-regular fa-circle-check ms-2 text-success"></i>
                                    @else
                                        <i class="fa-regular fa-circle-xmark ms-2 text-danger"></i>
                                    @endif
                                </a>
                            </td>
                            <td>{{ $stats->downloads }} downloads</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

    </div>

    <div class="d-flex justify-content-between gap-2 my-3">

        <div class="w-50">
            <h4 class="text-muted">Top 10 Most-Liked Authors</h4>
            <div class="w-100">
                <table class="table table-sm table-bordered table-striped text-center mb-0">
                    @foreach ($most_likes_authors as $idx => $author)
                        <tr>
                            <td>#{{ $idx + 1 }}</td>
                            <td>
                                <a target="_blank" href="{{ $author->profile_url }}">
                                    {{ $author->name }}
                                </a>
                            </td>
                            <td>{{ $author->total_likes }} likes</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <div class="w-50">
            <h4 class="text-muted">Top 10 Most-Downloaded Authors</h4>
            <div class="w-100">
                <table class="table table-sm table-bordered table-striped text-center mb-0">
                    @foreach ($most_downloads_authors as $idx => $author)
                        <tr>
                            <td>#{{ $idx + 1 }}</td>
                            <td>
                                <a target="_blank" href="{{ $author->profile_url }}">
                                    {{ $author->name }}
                                </a>
                            </td>
                            <td>{{ $author->total_downloads }} downloads</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

    </div>
@endsection
