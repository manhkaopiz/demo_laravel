<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
</head>
<body>
<h1>Edit Category</h1>
<form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="{{ $category->name }}" required>
    <label for="parent_id">Parent ID:</label>
    <input type="number" id="parent_id" name="parent_id" value="{{ $category->parent_id }}">
    <label for="description">Description:</label>
    <textarea id="description" name="description">{{ $category->description }}</textarea>
    <label for="content">Content:</label>
    <textarea id="content" name="content">{{ $category->content }}</textarea>
    <label for="active">Active:</label>
    <input type="checkbox" id="active" name="active" value="1" {{ $category->active ? 'checked' : '' }}>
    <button type="submit">Update</button>
</form>
</body>
</html>
