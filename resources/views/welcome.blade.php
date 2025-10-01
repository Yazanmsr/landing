<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Laravel App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">

    <div class="text-center">
        <h1 class="mb-4">Welcome to MyApp</h1>
        <a href="{{ route('google.login') }}" class="btn btn-danger btn-lg">Sign in with Google</a>
    </div>

</body>
</html>
