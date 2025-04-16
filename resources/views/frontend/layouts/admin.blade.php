<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
</head>
<body>
    <h1>Admin Panel</h1>
    <nav>
        <a href="{{ route('categories.index') }}">Categories</a> |
        <a href="{{ route('subcategories.index') }}">Subcategories</a> |
        <a href="{{ route('posts.index') }}">Posts</a>
    </nav>
    <hr>
    <div>
        @yield('content')
    </div>
</body>
</html>
