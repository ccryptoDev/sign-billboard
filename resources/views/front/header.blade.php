<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="google-site-verification" content="ZiA6vbw8FwvzCNV_KHqNdYMMhmfncMvUvO7d6HsK3o"/>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <!-- GET SEO from database -->
        <?php
            $route_name = request()->route()->getName();
            $page_title = isset($page_name) ? $page_name : '';
            $img = 'https://inex.net/img/home-1.png';
            $title = 'INEX : Best Digital Billboard Advertising Company Oklahoma';
            $keywords = 'Best Digital Billboard Advertising Company Oklahoma, Digital Signs, digital signs Oklahoma, signs, sign companies Oklahoma, digital sign Midwest City, digital sign Del City, digital sign Nicoma Park.';
            $description = 'Get in front of your customers like never before with INEX Digital Billboards. We provide No minimum contract digital billboard advertising for small and medium-sized businesses. Digital billboard advertising is the most time-sensitive and flexible form of outdoor ... These outdoor signs allow advertisers to connect with audiences in real-time and ... uses a digital billboard to show the count of homes that their agents have.';
            foreach(App\ManageSEO::all() as $val){
                if($val->page_name == $page_title){
                    $title = $val->title;
                    $keywords = $val->tags;
                    $description = $val->extra;
                    if($val->file != ''){
                        $img = config('app.url').'/upload/'.$val->file;
                    }
                }
            }
        ?>
        <meta property="og:image" content="{{ $img }}">
        <title>{{ $title }}</title>
        <meta name="keywords" content="{{ $keywords }}">
        <meta name="description" content="{{ $description }}">
        <link href="/favicon.png" rel="icon">
        <!-- Bootstrap -->
        <link href="/layouts/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- tobii css -->
        <link href="/layouts/css/tobii.min.css" rel="stylesheet" type="text/css" />
        <!-- Icons -->
        <link href="/layouts/css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css">
        <!-- Slider -->               
        <link rel="stylesheet" href="/layouts/css/tiny-slider.css"/> 
        <!-- Main Css -->
        <link href="/layouts/css/style.min.css" rel="stylesheet" type="text/css" id="theme-opt" />
        <link href="/layouts/css/colors/default.css" rel="stylesheet" id="color-opt">
        <link href="/layouts/css/custom.css" rel="stylesheet" id="color-opt">
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-T6ZL8JC');</script>
        <!-- End Google Tag Manager -->
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>

    <body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T6ZL8JC"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <header id="topnav" class="defaultscroll sticky {{$route_name == 'register' ? 'bg-white' : ''}}">
        <div class="container">
            <a class="logo" href="/">
                <img src="/logo.png" height="44" class="logo-light-mode" alt="INEX">
                <img src="/logo.png" height="44" class="logo-dark-mode" alt="INEX">
            </a>
            <div class="menu-extras">
                <div class="menu-item">
                    <a class="navbar-toggle" id="isToggle" onclick="toggleMenu()">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                </div>
            </div>
            <div id="navigation">
                <ul class="navigation-menu">

                    <li class="has-submenu parent-parent-menu-item">
                        <a href="javascript:void(0)">Products</a><span class="menu-arrow"></span>
                        <ul class="submenu bg-light">
                            <li><a href="{{ route('why-use-outdoor') }}" class="sub-menu-item"> Why Use INEX</a></li>
                            <li><a href="{{ route('locations') }}" class="sub-menu-item"> Locations </a></li>
                            <li><a href="{{ route('register') }}" class="sub-menu-item">Create Account</a></li>
                            <li><a href="{{ route('login-demo') }}" class="sub-menu-item">Try Our Demo </a></li>
                        </ul>
                    </li>

                    <li class="has-submenu parent-menu-item">
                        <a href="javascript:void(0)">Pricing</a><span class="menu-arrow"></span>
                        <ul class="submenu bg-light">
                            <li><a href="{{ route('pricing') }}" class="sub-menu-item">All Pricing</a></li>
                            <li><a href="{{ route('cost-calculator') }}" class="sub-menu-item">Billboard Calculator</a></li>
                            <li><a href="{{ route('financing') }}" class="sub-menu-item">Financing Options </a></li>
                            <li><a href="{{ route('inex-packages') }}" class="sub-menu-item">INEX PACKAGES </a></li>
                        </ul>
                    </li>
                    <li class="has-submenu parent-parent-menu-item">
                        <a href="javascript:void(0)">Marketing Tools</a><span class="menu-arrow"></span>
                        <ul class="submenu bg-light">
                            <li><a href="{{ route('team') }}" class="sub-menu-item">Trusted Partners</a></li>
                            @foreach(App\DocCat::orderby('name')->get() as $val)
                                @if($val->private == 1)
                                    <li><a href="{{ route('case-studies', ['title'=> $val->name ]) }}" class="sub-menu-item">{{ $val->name }}</a></li>
                                @endif
                            @endforeach
                        </ul>
                    </li>

                    <li class="has-submenu parent-menu-item">
                        <a href="javascript:void(0)">Customer Support</a><span class="menu-arrow"></span>
                        <ul class="submenu bg-light">
                            <li><a href="/contact/sales" class="sub-menu-item">Contact Sales</a></li>
                            <li><a href="/contact/report" class="sub-menu-item">Report a Problem</a></li>
                            <li><a href="/contact/suggestion" class="sub-menu-item">Suggestions</a></li>
                        </ul>
                    </li>
                    <li><a href="/login" class="sub-menu-item">Login</a></li>
                </ul>
            </div>
        </div>
    </header>
        <!-- @if($route_name != 'login' && $route_name != 'forgot') -->
        <!-- @else
            <div class="back-to-home rounded d-none d-sm-block">
                <a href="/" class="btn btn-icon btn-soft-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home icons"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a>
            </div>
        @endif -->