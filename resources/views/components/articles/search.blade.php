<form action="{{ route('articles.index') }}" method="GET" class="mt-3">
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Search Articles" name="query">
        <div class="input-group-append">
            <button type="submit" class="btn btn-secondary">Search</button>
        </div>
    </div>
</form>