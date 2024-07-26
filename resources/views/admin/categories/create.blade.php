<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Category</title>
</head>
<body>
<h1>Create Category</h1>
<form action="{{ route('admin.categories.store') }}" method="POST">
    @csrf
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="parent_id">Parent ID:</label>
    <select class="form-control" name="parent_id">
        <option value="0">Danh mục cha</option>
        @foreach($categories as $cate)
            <option value="{{ $cate->id }}">{{  $cate->name }}</option>
        @endforeach

    </select>
{{--    <input type="number" id="parent_id" name="parent_id">--}}

    <label for="description">Description:</label>
    <textarea id="description" name="description"></textarea>

    <label for="content">Content:</label>
    <textarea id="content" name="content"></textarea>

    <label for="active">Active:</label>
    <input type="checkbox" id="active" name="active" value="1" checked>
    <button type="submit">Save</button>
</form>
</body>
</html>
