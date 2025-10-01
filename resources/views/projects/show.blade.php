<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $project->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

@if($project->type === 'landing_page')
    <div class="text-center p-5 bg-primary text-white">
        <h1>{{ $project->title }}</h1>
        <p>{{ $project->content ?? 'Welcome to my landing page!' }}</p>
        <a href="#" class="btn btn-light">Call to Action</a>
    </div>
@elseif($project->type === 'cv')
    <div class="container p-5">
        <h2>{{ $project->title }}</h2>
        <p>{{ $project->content ?? 'CV details go here...' }}</p>
    </div>
@elseif($project->type === 'website')
    <div class="container p-5">
        <h1>{{ $project->title }}</h1>
        <p>{{ $project->content ?? 'Welcome to my website!' }}</p>
    </div>
@endif

</body>
</html>
