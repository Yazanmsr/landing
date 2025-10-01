<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

    <div class="text-center">
        <h1>Welcome!</h1>
        <p>Your email: <strong>{{ $user->email }}</strong></p>
        <a href="{{ route('logout') }}" class="btn btn-secondary">Logout</a>

    </div>

</body>
</html>
