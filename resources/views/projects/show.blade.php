<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $project->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .img-fluid {
            height: 400px !important;
            margin: 0 auto;
            width: 300px;
        }
        body {
            color: #336699 !important;
        }
        p {
            font-size: 18px;
        }
        .container {
            overflow-x: hidden;
        }
    </style>
</head>
<body>

@if($project->type === 'landing_page')
    <div class="text-center p-5 bg-primary text-white">
        <h1>{{ $project->title }}</h1>
        <p>{{ $project->content ?? 'Welcome to my landing page!' }}</p>
        <a href="#" class="btn btn-light">Call to Action</a>
    </div>

@elseif($project->type === 'cv')
    @php
        $cv = $project->cvEntry; 
        function isArabic($text) {
            return preg_match('/\p{Arabic}/u', $text);
        }

    @endphp
    <div class="container">
        <div class="row">
            
            

            <div class="spacer" style="height: 50px;"></div>
            
            <div class="row">
                <div class="col-md-6">
                    <h1>{{ $cv->name }}</h1>
                    <h3>{{ $cv->headline }}</h3>
                    <h1>
                        <span style="color:black;">
                            {{ isArabic($cv->skills) ? 'المهارات التي أعرفها' : 'Skills I know' }}
                        </span>
                    </h1>
                    {!! nl2br(e($cv->skills)) !!}

                    <h1>
                        <span style="color:black;">
                            {{ isArabic($cv->work_experience) ? 'الخبرة العملية' : 'Work Experience' }}
                        </span>
                    </h1>
                    {!! nl2br(e($cv->work_experience)) !!}



                    <div class="spacer" style="height: 50px;"></div>

                    @if($cv->facebook_url)
                        <a href="{{ $cv->facebook_url }}" target="_blank">
                            <img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" width="50px" alt="Facebook">
                        </a>
                    @endif

                    @if($cv->linkedin_url)
                        <a href="{{ $cv->linkedin_url }}" target="_blank">
                            <img src="https://cdn-icons-png.flaticon.com/512/174/174857.png" width="50px" alt="LinkedIn">
                        </a>
                    @endif

                    @if($cv->whatsapp_number)
                        <a href="https://wa.me/{{ $cv->whatsapp_number }}" target="_blank">
                            <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" width="50px" alt="WhatsApp">
                        </a>
                    @endif

                </div>
                <div class="col-md-6 text-center">
                    <img class="img-fluid" src="{{ asset('storage/'.$cv->image) }}" alt="profile">
                </div>
            </div>
        </div>
    </div>

@elseif($project->type === 'website')
    <div class="container p-5">
        <h1>{{ $project->title }}</h1>
        <p>{{ $project->content ?? 'Welcome to my website!' }}</p>
    </div>
@endif

</body>
</html>
