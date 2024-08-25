@extends('layouts.app-wrapper')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Update Message #{{ $message->id }}</h1>
        <div>
            <a href="{{ route('messages.index') }}" class="btn btn-secondary">Go Back</a>
        </div>
    </div>

    @include('components.notifications.status')

    <form action="{{ route('messages.update', $message->id) }}" method="POST"  class="mt-3">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="source_url" class="form-label">Source URL *</label>
            <input type="text" class="form-control" id="source_url" name="source_url" value="{{ $message->source_url }}"
                required>
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Update Message</button>

            <button type="button" class="btn btn-danger" onclick="frmDelete.submit()">Delete Message</button>
        </div>
    </form>
    <form name="frmDelete" action="{{ route('messages.destroy', $message->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
    </form>
@endsection
