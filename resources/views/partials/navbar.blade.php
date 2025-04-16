<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Blog Admin</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('blogs.index') }}">Blogs</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('categories.index') }}">Categories</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('subcategories.index') }}">Subcategories</a></li>
            </ul>
        </div>
    </div>
</nav>
