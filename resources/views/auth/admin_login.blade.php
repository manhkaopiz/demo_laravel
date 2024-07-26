
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>
    <form method="POST" action="{{ route('admin.login') }}">
@csrf
<div>
    <label for="email">Email</label>
    <input type="email" id="email" name="email" required>
</div>
<div>
    <label for="password">Password</label>
    <input type="password" id="password" name="password" required>
</div>
<button type="submit">Login</button>
        <a href="{{ route('admin.register') }}">Đăng ký</a>
</form>
</body>
</html>
