<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 200px;
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .sidebar .brand {
            font-size: 2rem; 
            font-weight: bold;
            color: grey;
            text-align: center;
            margin-bottom: 20px;
        }
        .content {
            margin-left: 220px;
            padding: 20px;
        }
        .hlo{
            font-weight:bold;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Task Manager</a>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                @auth
                <li class="nav-item">
                    <span class="navbar-text mr-3">Hello, {{ Auth::user()->name }}</span>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button class="btn btn-danger" type="submit">Logout</button>
                    </form>
                </li>
                @endauth
            </ul>
        </div>
    </nav>
    <div class="sidebar">
        <div class="brand">Task Manager</div>
        <ul class="nav flex-column mt-3">
            <li class="nav-item">
                <a class="nav-link active hlo" href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link hlo" href="{{ route('tasks.create') }}">Add Task</a>
            </li>
            <li class="nav-item">
                <a class="nav-link hlo" href="{{ route('tasks.index') }}">Show Tasks</a>
            </li>
        </ul>
    </div>
    <div class="content">
       <div class="alert alert-info font-weight-bold mb-4" style="font-size:1.1rem;">
        This is a simple task manager application built with Laravel. You can add, edit, and delete tasks. The application uses Bootstrap for styling and jQuery for AJAX requests. Created as a practical assignment.
    </div>@yield('content')
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>