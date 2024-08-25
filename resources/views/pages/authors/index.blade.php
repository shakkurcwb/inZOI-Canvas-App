@extends('layouts.app-wrapper')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Manage Authors</h1>
    </div>

    @include('components.notifications.status')

    @include('components.authors.search')

    <div class="mt-3">
        <table class="table table-sm table-striped text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Articles</th>
                    <th scope="col">Downloads</th>
                    <th scope="col">Likes</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>

            @if ($authors->isEmpty())
                <tbody>
                    <tr>
                        <td colspan="4" class="text-center">No authors found.</td>
                    </tr>
                </tbody>
            @else
                <tbody>
                    @foreach ($authors as $author)
                        <tr>
                            <th scope="row">{{ $author->id }}</th>
                            <td>
                                <a target="_blank" href="{{ $author->profile_url }}">
                                    {{ $author->name }}
                                </a>
                            </td>
                            <td>{{ $author->articles()->count() }}</td>
                            <td>{{ $author->metrics()->sum('downloads') }}</td>
                            <td>{{ $author->metrics()->sum('likes') }}</td>
                            <td scope="row">
                                <a href="{{ route('authors.show', $author->id) }}" class="btn btn-sm btn-secondary">
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            @endif
        </table>

        {{ $authors->links() }}
    </div>
@endsection
