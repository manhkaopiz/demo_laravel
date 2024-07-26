<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
</head>
<body>
    <h1>Posts</h1>
    <div class="container">
        <form action="{{ route('posts.index') }}" method="GET">
            <input type="text" name="query" placeholder="Search posts..." value="{{ request()->input('query') }}">
            <button type="submit">Search</button>
        </form>

        <div class="row">
            @foreach ($posts as $post)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->name }}</h5>
                            <p class="card-text">{{ $post->title }}</p>
                            <p class="card-text">Category: {{ $post->category->name }}</p>

                            @if($post->images->isNotEmpty())
                                <div class="images">
                                    @foreach ($post->images as $image)
                                        <img src="{{ asset('storage/' . $image->path) }}" alt="Image" class="img-fluid">
                                    @endforeach
                                </div>
                            @endif

                            <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
