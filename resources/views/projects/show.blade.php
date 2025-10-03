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
<script defer src="{{ asset('js/bundle.js') }}"></script>

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











@if($project->type === 'website')
@php
    $website = $project->website;
@endphp

<!DOCTYPE html>
<html lang="ar">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $project->title }}</title>
  <link rel="icon" href="{{ asset('images/logo-light.svg') }}">
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body x-data="{ page: 'home', darkMode: true, stickyMenu: false, navigationOpen: false, scrollTop: false }"
  x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
  :class="{'b eh': darkMode === true}">

  <!-- ===== Header Start ===== -->
  <header class="g s r vd ya cj" :class="{ 'hh sm _k dj bl ll' : stickyMenu }"
    @scroll.window="stickyMenu = (window.pageYOffset > 20) ? true : false">
    <div class="bb ze ki xn 2xl:ud-px-0 oo wf yf i">
      <div class="vd to/4 tc wf yf">
        <a href="index.html">
          <img class="om" src="{{ asset('images/logo-light.svg') }}" alt="Logo Light" />
          <img class="xc nm" src="images/logo-dark.svg" alt="Logo Dark" />
        </a>

        <!-- Hamburger Toggle BTN -->
        <button class="po rc" @click="navigationOpen = !navigationOpen">
          <span class="rc i pf re pd">
            <span class="du-block h q vd yc">
              <span class="rc i r s eh um tg te rd eb ml jl dl" :class="{ 'ue el': !navigationOpen }"></span>
              <span class="rc i r s eh um tg te rd eb ml jl fl" :class="{ 'ue qr': !navigationOpen }"></span>
              <span class="rc i r s eh um tg te rd eb ml jl gl" :class="{ 'ue hl': !navigationOpen }"></span>
            </span>
            <span class="du-block h q vd yc lf">
              <span class="rc eh um tg ml jl el h na r ve yc" :class="{ 'sd dl': !navigationOpen }"></span>
              <span class="rc eh um tg ml jl qr h s pa vd rd" :class="{ 'sd rr': !navigationOpen }"></span>
            </span>
          </span>
        </button>
        <!-- Hamburger Toggle BTN -->
      </div>

      <div class="vd wo/4 sd qo f ho oo wf yf" :class="{ 'd hh rm sr td ud qg ug jc yh': navigationOpen }">
        <nav>
          <ul class="tc _o sf yo cg ep">
            <li><a href="#" class="xl" :class="{ 'mk': page === 'home' }">Home</a></li>
            <li><a href="#about" class="xl">About Us</a></li>
            <li><a href="#members" class="xl">Team Members</a></li>
            <li><a href="#services" class="xl">Services</a></li>
            <li><a href="#gallery" class="xl">Gallery</a></li>
          </ul>
        </nav>
      </div>
    </div>
  </header>
  <!-- ===== Header End ===== -->

  <main>
    <!-- ===== Hero Start ===== -->
    <section class="gj do ir hj sp jr i pg">
      <div class="xc fn zd/2 2xl:ud-w-187.5 bd 2xl:ud-h-171.5 h q r">
        <img src="{{ asset('images/shape-01.svg') }} " alt="shape" class="xc 2xl:ud-block h t -ud-left-[10%] ua" />
        <img src="{{ asset('images/shape-02.svg') }}" alt="shape" class="xc 2xl:ud-block h u p va" />
        <img src="{{ asset('images/shape-03.svg') }}" alt="shape" class="xc 2xl:ud-block h v w va" />
        <img src="{{ asset('images/shape-04.svg') }}" alt="shape" class="h q r" />
        <img src="{{ $website->hero_image ? asset('storage/'.$website->hero_image) : 'images/hero.png' }}" alt="Hero Image" class="h q r ua" />
      </div>

      <div class="bb ze ki xn 2xl:ud-px-0">
        <div class="tc _o">
          <div class="animate_left jn/2">
            <h1>{{ $website->hero_text ?? 'مرحبا بكم!' }}</h1>
            <p>{{ $website->hero_subtitle ?? '' }}</p>
          </div>
        </div>
      </div>
    </section>
    <!-- ===== Hero End ===== -->

<!-- ===== About Section ===== -->
@if($website->about_title || $website->about_description)
<section id="about" class="ji gp uq 2xl:ud-py-35 pg">
    <div class="bb ze ki xn wq">
        <div class="tc wf gg qq flex flex-wrap items-center"> <!-- make container flex -->
            @if($website->about_image)
            <div class="w-full md:w-1/2 pr-4"> <!-- image 50% on md+ screens -->
                <img src="{{ asset('storage/'.$website->about_image) }}" alt="About Image" class="w-full h-auto" />
            </div>
            @endif
            <div class="w-full md:w-1/2 animate_right jn/2"> <!-- text 50% -->
                <h4 class="ek yj mk gb">{{ $website->about_title }}</h4>
                <p class="uo">{{ $website->about_description }}</p>
            </div>
        </div>
    </div>
</section>
@endif

    <!-- ===== About End ===== -->

    <!-- ===== Team Section ===== -->
    <section id="members" class="i pg ji gp uq">
      <span class="rc h s r vd fd/5 fh rm"></span>
      <img src="{{ asset('images/shape-08.svg') }}" alt="Shape Bg" class="h q r" />
      <img src="{{ asset('images/shape-09.svg') }}" alt="Shape" class="of h y z/2" />
      <img src="{{ asset('images/shape-10.svg') }}" alt="Shape" class="h _ aa" />
      <img src="{{ asset('images/shape-11.svg') }}" alt="Shape" class="of h m ba" />

      <div class="bb ze i va ki xn xq jb jo">
        <h1 class="fk vj zp or kk wm wb">{{ $website->team_title ?? 'Members' }}</h1>
        <div class="wc qf pn xo gg cp">
          @for($i=1; $i<=3; $i++)
            @php
              $memberImage = $website->{'team_member'.$i.'_image'};
              $memberName = $website->{'team_member'.$i.'_name'};
              $memberPosition = $website->{'team_member'.$i.'_position'};
            @endphp
            @if($memberName || $memberPosition)
            <div class="animate_top rj">
              <div class="c i pg z-1">
                @if($memberImage)<img class="vd" src="{{ asset('storage/'.$memberImage) }}" alt="{{ $memberName }}" />@endif
                <h4 class="yj go kk wm ob zb">{{ $memberName }}</h4>
                <p>{{ $memberPosition }}</p>
              </div>
            </div>
            @endif
          @endfor
        </div>
      </div>
    </section>
    <!-- ===== Team End ===== -->

    <!-- ===== Services Section ===== -->
    <section id="services" class="lj tp kr">
      <div class="bb ze ki xn yq mb en">
        <h1 class="fk vj zp or kk wm wb">{{ $website->services_title ?? 'Services' }}</h1>
        <div class="wc qf pn xo ng">
          @for($i=1; $i<=3; $i++)
            @php
              $serviceTitle = $website->{'service'.$i.'_title'};
              $serviceDesc = $website->{'service'.$i.'_description'};
            @endphp
            @if($serviceTitle || $serviceDesc)
            <div class="animate_top sg oi pi zq ml il am cn _m">
                <img src="{{ asset('images/icon-0'.($i+3).'.svg') }}" alt="Icon {{ $i+3 }}">
              <h4 class="ek zj kk wm nb _b">{{ $serviceTitle }}</h4>
              <p>{{ $serviceDesc }}</p>
            </div>
            @endif
          @endfor
        </div>
      </div>
    </section>
    <!-- ===== Services End ===== -->


	


<section id="gallery" class="gallery-section">
  <div class="gallery-row">
    <div class="gallery-item">
      <img src="{{ asset('storage/'.$website->gallery_image1) }}" alt="Project" />
    </div>
    <div class="gallery-item">
      <img src="{{ asset('storage/'.$website->gallery_image2) }}" alt="Project" />
    </div>
    <div class="gallery-item">
      <img src="{{ asset('storage/'.$website->gallery_image3) }}" alt="Project" />
    </div>
    <div class="gallery-item">
      <img src="{{ asset('storage/'.$website->gallery_image4) }}" alt="Project" />
    </div>
  </div>
</section>

<style>
.gallery-section {
  padding: 40px 20px;
  max-width: 1200px;
  margin: 0 auto;
}

.gallery-row {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  justify-content: center; /* center on smaller screens */
}

.gallery-item {
  flex: 1 1 calc(25% - 20px); /* 4 items per row with gap */
  box-sizing: border-box;
}

.gallery-item img {
  width: 100%;
  height: 200px;
  display: block;
  border-radius: 10px;
  transition: transform 0.3s;
}

.gallery-item img:hover {
  transform: scale(1.05);
}

/* Responsive: 2 columns on medium screens, 1 column on small screens */
@media (max-width: 992px) {
  .gallery-item {
    flex: 1 1 calc(50% - 20px);
  }
}

@media (max-width: 600px) {
  .gallery-item {
    flex: 1 1 100%;
  }
}
</style>


    <!-- ===== Gallery End ===== -->

    <!-- ===== Contact Section ===== -->
<section id="support" class="contact-section gallery-section">
  <div class="contact-container">
    <!-- Left Column -->
    <div class="contact-left">
      @if($website->contact_email_value)
        <p><h1 class="wj kk wm cc">{{ $website->contact_email_label }}
            <br>
        </h1> {{ $website->contact_email_value }}</p>
      @endif
      <br>
      @if($website->contact_office_value)
        <p><h1 class="wj kk wm cc">{{ $website->contact_office_label }}
            <br>
        </h1> {{ $website->contact_office_value }}</p>
      @endif
      <br>
      @if($website->contact_phone_value)
        <p><h1 class="wj kk wm cc">{{ $website->contact_phone_label }}
            <br>
        </h1> {{ $website->contact_phone_value }}</p>
      @endif
      <br>
      <div class="social-links">
        @if($website->social_facebook)
          <a href="{{ $website->social_facebook }}" target="_blank">
            <img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" width="40" alt="Facebook">
          </a>
        @endif
        @if($website->social_linkedin)
          <a href="{{ $website->social_linkedin }}" target="_blank">
            <img src="https://cdn-icons-png.flaticon.com/512/174/174857.png" width="40" alt="LinkedIn">
          </a>
        @endif
        @if($website->social_whatsapp)
          <a href="https://wa.me/{{ $website->social_whatsapp }}" target="_blank">
            <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" width="40" alt="WhatsApp">
          </a>
        @endif
      </div>
    </div>

    <!-- Right Column -->
    <div class="contact-right">
      @if($website->contact_image)
        <img src="{{ asset('storage/'.$website->contact_image) }}" class="contact-img" alt="Contact Image">
      @endif
    </div>
  </div>
</section>

<style>
.contact-section {
  padding: 40px 20px;
}

.contact-container {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 20px;
}

/* Left Column */
.contact-left {
  flex: 1 1 45%; /* take about 45% width */
  display: flex;
  flex-direction: column;
  gap: 15px;
  text-align: left;
}

.contact-left p {
  margin: 0;
}

/* Social Links inline */
.social-links {
  display: flex;
  gap: 10px;
}

/* Right Column */
.contact-right {
  flex: 1 1 50%; /* take about 50% width */
  text-align: center;
}

.contact-img {
  width: 100%;
  height: auto;
  border-radius: 10px;
}

/* Responsive for mobile */
@media (max-width: 768px) {
  .contact-container {
    flex-direction: column;
  }

  .contact-left, .contact-right {
    flex: 1 1 100%;
  }
}
</style>



  </main>
<script href="{{ asset('js/bundle.js') }}"></script>

</body>
</html>
@endif
