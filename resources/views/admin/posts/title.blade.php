<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }}</title>
</head>
<body>
<h1>{{ $post->title }}</h1>
<p>{{ $post->description }}</p>

<h2>Images</h2>
@foreach ($post->images as $image)
    <img src="{{ asset('storage/' . $image->path) }}" alt="Image" style="max-width: 200px;">
@endforeach

{{--<h2>Comments</h2>--}}
{{--<ul>--}}
{{--    @foreach ($comments as $comment)--}}
{{--        <li>{{ $comment->customer->name }}: {{ $comment->content }}</li>--}}
{{--    @endforeach--}}
{{--</ul>--}}

{{--@if (Auth::check())--}}
{{--    <form action="{{ route('comments.store', ['id' => $post->id]) }}" method="POST">--}}
{{--        @csrf--}}
{{--        <textarea name="content" rows="3" required></textarea>--}}
{{--        <button type="submit">Submit Comment</button>--}}
{{--    </form>--}}
{{--@endif--}}

<h2>Comments</h2>
<ul>
    @foreach ($comments as $comment)
        <li>
            {{ $comment->customer->name }}: {{ $comment->content }}
                {{$comment->post_id }}



                <form action="{{ route('admin.comments.destroy', $comment->post_id ) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Comment</button>
                </form>

        </li>
    @endforeach
</ul>
<h2>Ratings</h2>
<p>Average Rating: {{ $averageRating }}</p>


{{--    <form action="{{ route('ratings.store', ['id' => $post->id]) }}" method="POST">--}}
{{--        @csrf--}}
{{--        <label for="rating">Rate this post:</label>--}}
{{--        <select name="rating" id="rating" required>--}}
{{--            <option value="1">1</option>--}}
{{--            <option value="2">2</option>--}}
{{--            <option value="3">3</option>--}}
{{--            <option value="4">4</option>--}}
{{--            <option value="5">5</option>--}}
{{--        </select>--}}
{{--        <button type="submit">Submit Rating</button>--}}
{{--    </form>--}}


<a href="{{ route('admin.posts') }}">Back to Posts</a>
</body>
</html>
