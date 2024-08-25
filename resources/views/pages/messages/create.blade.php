@extends('layouts.app-wrapper')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Create Message</h1>
        <div>
            <a href="{{ route('messages.index') }}" class="btn btn-secondary">Go Back</a>
        </div>
    </div>

    @include('components.notifications.status')

    <form action="{{ route('messages.store') }}" method="POST" class="mt-3">
        @csrf

        <div class="mb-3">
            <label for="source_url" class="form-label">Source URL *</label>
            <input type="text" class="form-control" id="source_url" name="source_url" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Message</button>
    </form>
@endsection
