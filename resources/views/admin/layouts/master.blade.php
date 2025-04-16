<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Panel - @yield('title')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>
<body>
    @auth
        <div class="d-flex">
            <!-- Sidebar -->
            <div class="bg-dark text-white vh-100" style="width: 250px;">
                <div class="p-3">
                    <h4>Admin Panel</h4>
                    <hr class="my-2 bg-light">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('admin.dashboard') }}"><i class="fas fa-home me-2"></i> Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('categories.index') }}"><i class="fas fa-list me-2"></i> Categories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('subcategories.index') }}"><i class="fas fa-list-alt me-2"></i> Subcategories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('posts.index') }}"><i class="fas fa-newspaper me-2"></i> Posts</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-grow-1">
                @include('admin.layouts.header')
                
                <main class="container-fluid py-3">
                    @yield('content')
                </main>

                @include('admin.layouts.footer')
            </div>
        </div>
    @else
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Unauthorized Access</div>
                        <div class="card-body text-center">
                            <p>You must be logged in to access the admin panel.</p>
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt me-1"></i> Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endauth

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>