@extends('layouts.app-wrapper')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Manage Articles</h1>
    </div>

    @include('components.notifications.status')

    @include('components.articles.search')

    <div class="mt-3">
        <table class="table table-sm table-striped text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Author</th>
                    <th scope="col">Title</th>
                    <th scope="col">Publication Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Downloads</th>
                    <th scope="col">Likes</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>

            @if ($articles->isEmpty())
                <tbody>
                    <tr>
                        <td colspan="8" class="text-center">No articles found.</td>
                    </tr>
                </tbody>
            @else
                <tbody>
                    @foreach ($articles as $article)
                        <tr>
                            <th scope="row">{{ $article->id }}</th>
                            <td>
                                {{ $article->author->name }}
                            </td>
                            <td>
                                {{ $article->title }}
                            </td>
                            <td>
                                {{ $article->publication_date->format('Y-m-d') }}
                            </td>
                            <td>
                                @if ($article->artifacts->released_at)
                                    <span class="badge bg-success">Released</span>
                                @else
                                    <span class="badge bg-warning">Ready</span>
                                @endif
                            </td>
                            <td>
                                {{ $article->metrics->downloads }}
                            </td>
                            <td>
                                {{ $article->metrics->likes }}
                            </td>
                            <td scope="row">
                                <a href="{{ route('articles.show', $article->id) }}"
                                    class="btn btn-sm btn-secondary">Show</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            @endif
        </table>

        {{ $articles->links() }}
    </div>
@endsection
