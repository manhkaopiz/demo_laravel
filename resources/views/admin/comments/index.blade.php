<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Comments</title>
</head>
<body>
<h1>Manage Comments</h1>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Post</th>
        <th>Customer</th>
        <th>Comment</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($comments as $comment)
        <tr>
            <td>{{ $comment->id }}</td>
            <td>{{ $comment->post->title }}</td>
            <td>{{ $comment->customer->name }}</td>
            <td>{{ $comment->content }}</td>
            <td>
                <form action="{{ url('admin/comments/' . $comment->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
