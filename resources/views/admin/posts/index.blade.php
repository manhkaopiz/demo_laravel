<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{ route('admin.dashboard') }}">My Blog</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.posts') }}">Posts</a>
            </li>
            @if(Auth::check() && Auth::user()->is_admin)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.posts.create') }}">Create Post</a>
                </li>
            @endif
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.register') }}">Register</a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            @endguest
        </ul>
    </div>
</nav>
<div class="container mt-5">
    <h1>Posts in {{ $category->name ?? 'All Categories' }}</h1>
    <form action="{{ route('admin.posts') }}" method="GET">
        <div class="input-group mb-3">
            <input type="text" name="query" class="form-control" placeholder="Search posts..." value="{{ request()->input('query') }}">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </div>
    </form>

    @isset($categories)
        <div class="categories">
            <h2>Categories</h2>
            <ul class="list-group">
                @foreach($categories as $category)
                    <li class="list-group-item">
                        <a href="{{ route('admin.categories.posts', $category->id) }}">{{ $category->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endisset

    <div class="row">
        @foreach ($posts as $post)
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title">{{ $post->name }}</h4>
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text">{{ $post->description }}</p>
                        <p class="card-text">Category: {{ $post->category->name }}</p>

                        @if($post->images->isNotEmpty())
                            <div class="images">
                                @foreach ($post->images as $image)
                                    <img src="{{ asset('storage/' . $image->path) }}" alt="Image" class="img-fluid mb-2" style="max-height: 200px;">
                                @endforeach
                            </div>
                        @endif

                        <a href="{{ route('admin.posts.title', $post->id) }}" class="btn btn-primary">View Details</a>
                        <a href="{{ route('admin.posts.show', $post->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
