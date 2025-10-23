@if($project->type === 'cv')

<!DOCTYPE html>
<html lang="ar"">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $project->title }}</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            margin: 0;
            padding: 0;
            background: #f9f9f9;
            color: #333;
        }
        .img-fluid {
            max-height: 400px;
            width: auto;
            margin: 0 auto;
        }
        .service-card {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        h1, h2, h3, h4 {
            color: #333;
        }
        .text-white h1, .text-white p {
            text-shadow: 2px 2px 5px rgba(0,0,0,0.5);
        }
    </style>
</head>
<body>

@if($project->type === 'landing_page')
    @php
        $lp = $project->landingPage; 
        // صورة الهيدر الافتراضية إذا لم تكن موجودة
        $headerImage = $lp && $lp->image ? asset('storage/'.$lp->image) : 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1400&q=80';
    @endphp

    {{-- Header Section --}}
    <div class="text-center p-5 text-white" style="background: url('{{ $headerImage }}') no-repeat center center/cover;">
        <h1>{{ $lp->title ?? 'مرحبا بكم!' }}</h1>
        <p>{{ $lp->description ?? 'هذه هي صفحة الهبوط الخاصة بي.' }}</p>
        @if($lp && $lp->button_link)
            <a href="{{ $lp->button_link }}" class="btn btn-light">{{ $lp->button_text ?? 'سجل الآن' }}</a>
        @endif
    </div>

    {{-- About Section --}}
    @if($lp && ($lp->about_title || $lp->about_description))
        <div class="container py-5 text-center">
            <h2>{{ $lp->about_title ?? '' }}</h2>
            <p>{{ $lp->about_description ?? '' }}</p>
        </div>
    @endif

    {{-- Services Section --}}
    @if($lp && ($lp->service1_title || $lp->service2_title || $lp->service3_title))
        <div class="container py-5">
            <h2 class="text-center mb-4">خدماتي</h2>
            <div class="row justify-content-center">
                @for($i=1; $i<=3; $i++)
                    @php
                        $title = $lp->{'service'.$i.'_title'};
                        $desc = $lp->{'service'.$i.'_description'};
                    @endphp
                    @if($title || $desc)
                        <div class="col-md-4">
                            <div class="service-card text-center">
                                <h4>{{ $title }}</h4>
                                <p>{{ $desc }}</p>
                            </div>
                        </div>
                    @endif
                @endfor
            </div>
        </div>
    @endif

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
                    @if($cv->phone_number)
                        <a href="tel:{{ $cv->phone_number }}">
                            <img src="https://cdn-icons-png.flaticon.com/512/724/724664.png" width="50px" alt="Phone">
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
    <div class="container p-5 text-center">
        <h1>{{ $project->title }}</h1>
        <p>{{ $project->content ?? 'Welcome to my website!' }}</p>
    </div>
@endif

</body>
</html>
@endif




























@if($project->type === 'landing_page')
@php
    $lp = $project->landingPage; // استدعاء بيانات landing page من قاعدة البيانات
@endphp
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $lp->title ?? 'صفحة الهبوط' }}</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            margin: 0;
            padding: 0;
            background: #f9f9f9;
            color: #333;
        }

        header {
            background: url('{{ $lp->image ? asset('storage/'.$lp->image) : "https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1400&q=80" }}') no-repeat center center/cover;
            color: white;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 0 20px;
        }

        header h1 {
            font-size: 3em;
            margin-bottom: 20px;
            text-shadow: 2px 2px 5px rgba(0,0,0,0.5);
        }

        header p {
            font-size: 1.2em;
            margin-bottom: 30px;
            text-shadow: 1px 1px 4px rgba(0,0,0,0.5);
        }

        .cta-button {
            padding: 15px 40px;
            background: #ff6b6b;
            color: white;
            text-decoration: none;
            font-size: 1.2em;
            border-radius: 50px;
            transition: 0.3s;
        }

        .cta-button:hover {
            background: #ff4757;
        }

        section {
            padding: 80px 20px;
            text-align: center;
        }

        section h2 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #333;
        }

        .services {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 30px;
        }

        .service-box {
            background: white;
            padding: 30px;
            border-radius: 15px;
            width: 250px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .service-box:hover {
            transform: translateY(-10px);
        }

        .service-box i {
            font-size: 3em;
            color: #ff6b6b;
            margin-bottom: 15px;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input, textarea {
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1em;
            width: 100%;
        }

        button {
            padding: 15px;
            background: #1e90ff;
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 1.1em;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #1c86ee;
        }

        footer {
            background: #333;
            color: white;
            padding: 20px;
            text-align: center;
        }

        @media (max-width: 768px) {
            .services {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>

<header>
    <h1>{{ $lp->title ?? 'مرحبا بكم في صفحتي' }}</h1>
    <p>{{ $lp->description ?? 'تعرف على سيرتي الذاتية وخدماتي الاحترافية' }}</p>
    @if($lp->button_link)
        <a href="{{ $lp->button_link }}" class="cta-button">{{ $lp->button_text ?? 'سجل الآن' }}</a>
    @endif
</header>

@if($lp->about_title || $lp->about_description)
<section id="about">
    <h2>{{ $lp->about_title ?? 'عنّي' }}</h2>
    <p>{{ $lp->about_description ?? 'أنا مطور ومصمم واجهات، أتمتع بخبرة واسعة في بناء مواقع وتطبيقات احترافية.' }}</p>
</section>
@endif

@if($lp->service1_title || $lp->service2_title || $lp->service3_title)
<section id="services">
    <h2>{{ $lp->services_heading }}</h2>
    <div class="services">
        @for($i=1; $i<=3; $i++)
            @php
                $title = $lp->{'service'.$i.'_title'};
                $desc  = $lp->{'service'.$i.'_description'};
            @endphp
            @if($title || $desc)
                <div class="service-box text-center">
                    {{-- Global Icon --}}
                    <div class="service-icon mb-2">
                        <i class="fas fa-star fa-2x"></i> {{-- You can replace fa-star with any icon --}}
                    </div>
                    <h3>{{ $title }}</h3>
                    <p>{{ $desc }}</p>
                </div>
            @endif
        @endfor

    </div>
</section>
@endif

</body>
</html>
@endif
