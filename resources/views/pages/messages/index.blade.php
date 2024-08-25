@extends('layouts.app-wrapper')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Manage Messages</h1>
        <div>
            <a href="{{ route('messages.create') }}" class="btn btn-primary">Create Message</a>
        </div>
    </div>

    @include('components.notifications.status')

    @include('components.messages.search')

    <div class="mt-3">
        <table class="table table-sm table-striped text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Source</th>
                    <th scope="col">Status</th>
                    <th scope="col">Article</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>

            @if ($messages->isEmpty())
                <tbody>
                    <tr>
                        <td colspan="5" class="text-center">No messages found.</td>
                    </tr>
                </tbody>
            @else
                <tbody>
                    @foreach ($messages as $message)
                        <tr>
                            <th scope="row">{{ $message->id }}</th>
                            <td>
                                <a target="_blank" href="{{ $message->source_url }}">
                                    {{ substr($message->source_url, -25) }}
                                </a>
                            </td>
                            <td>
                                @if ($message->article?->artifacts->released_at)
                                    <span class="badge bg-success">Released</span>
                                @elseif ($message->processed_at)
                                    <span class="badge bg-primary">Processed</span>
                                @else
                                    <span class="badge bg-warning">Draft</span>
                                @endif
                            </td>
                            <td>
                                @if ($message->article)
                                    <a href="{{ route('articles.show', $message->article->id) }}">
                                        {{ $message->article->title }} by {{ $message->article->author->name }}
                                    </a>
                                @else - @endif
                            <td scope="row">
                                @if (!$message->processed_at)
                                    <form action="{{ route('messages.process', $message->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary">Process</button>
                                    </form>
                                @endif

                                <a href="{{ route('messages.edit', $message->id) }}"
                                    class="btn btn-sm btn-secondary">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            @endif
        </table>

        {{ $messages->links() }}
    </div>
@endsection
