<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
</head>
<body>
<h1>Manage Categories</h1>
<a href="{{ route('admin.categories.create') }}">Add New Category</a>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Parent ID</th>
        <th>Description</th>
        <th>Content</th>
        <th>Active</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->parent_id }}</td>
            <td>{{ $category->description }}</td>
            <td>{{ $category->content }}</td>
            <td>{{ $category->active ? 'Yes' : 'No' }}</td>
            <td>
                <a href="{{ route('admin.categories.edit', $category->id) }}">Edit</a>
                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;">
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
