<header>
    <nav class="navbar navbar-expand-md bg-dark" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand mb-0 h1 text-light" href="{{ route('home') }}">{{ config('app.name') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('messages*') ? 'active' : '' }}"
                            aria-current="page" href="{{ route('messages.index') }}">Messages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('articles*') ? 'active' : '' }}"
                            href="{{ route('articles.index') }}">Articles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('authors*') ? 'active' : '' }}"
                            href="{{ route('authors.index') }}">Authors</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
