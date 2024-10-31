<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="google-site-verification" content="ZtxW9imGT_Mew1mRmK0J0v0NksxA6fQdqG2K5a82x20"/>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        
        <?php
        if($_SERVER['REQUEST_URI'] == '/'){ ?>
            <meta property="og:image" content="https://inex.net/img/home-1.png">
            <title>INEX : Best Digital Billboard Advertising Company Oklahoma</title>
            <meta name="keywords" content="Best Digital Billboard Advertising Company Oklahoma, Digital Signs, digital signs Oklahoma, signs, sign companies Oklahoma, digital sign Midwest City, digital sign Del City, digital sign Nicoma Park.">
            <meta name="description" content="Get in front of your customers like never before with INEX Digital Billboards. We provide No minimum contract digital billboard advertising for small and medium-sized businesses. Digital billboard advertising is the most time-sensitive and flexible form of outdoor ... These outdoor signs allow advertisers to connect with audiences in real-time and ... uses a digital billboard to show the count of homes that their agents have.">
        <?php }
        else if($_SERVER['REQUEST_URI'] == '/bill_ad'){ ?>
            <title>INEX :Billboard Advertising space in Oklahoma</title>
            <meta property="og:image" content="https://inex.net/front/images/img1.png">
            <meta name="keywords" content="Best Digital Sign Company Oklahoma">
            <meta name="description" content="INEX supplies outdoor and indoor digital signs. We provide and install all size of indoor and outdoor digital signage.">
        <?php }
        else if($_SERVER['REQUEST_URI'] == '/digital'){ ?>
            <meta property="og:image" content="https://inex.net/assets/media/bg/bg-10.jpg">
            <title>INEX : Best Digital Sign Company Oklahoma </title>
            <meta name="keywords" content="Digital Sign Company Oklahoma">
            <meta name="description" content="INEX provides high quality outdoor LED signs to help your business stand out. Visit our website to see how we can serve you. Electronic Signs can help any business reach new customers.">
        <?php }
        else if($_SERVER['REQUEST_URI'] == '/contact'){ ?>
            <meta property="og:image" content="https://inex.net/front/images/bg-contact-header.jpg">
            <title>INEX : Affordable Digital Signs Oklahoma </title>
            <meta name="keywords" content="Outdoor LED Signs Oklahoma">
            <meta name="description" content="INEX provides digital sign advertising for every possible application. We offer Indoor and Outdoor LED Displays. Outdoor electronic led displays led signs have proven to increase business 15%-150% at 10%. Electronic Signs can help any business reach new customers. We will help you understand as much as possible about all your advertising sign options when">
        <?php }
        else if($_SERVER['REQUEST_URI'] == '/about_us'){ ?>
            <meta property="og:image" content="https://inex.net/img/about1.jpg">
            <title>INEX : Outdoor LED Signs Oklahoma </title>
            <meta name="keywords" content="Best Digital Billboard Advertising Company Oklahoma">
            <meta name="description" content="Get in front of your customers like never before with INEX Digital Billboards. We provide No minimum contract digital billboard advertising for small and medium-sized businesses. Digital billboard advertising is the most time-sensitive and flexible form of outdoor ... These outdoor signs allow advertisers to connect with audiences in real-time and ... uses a digital billboard to show the count of homes that their agents have.">
        <?php }
        else if($_SERVER['REQUEST_URI'] == '/blog'){ ?>
            <title> INEX : Outdoor LED Signs Oklahoma </title>
            <meta property="og:image" content="">
            <meta name="keywords" content="Affordable billboard Advertising space Oklahoma">
            <meta name="description" content="Advertise in the Oklahoma City area with INEX Digital Billboard Advertising. Choose your billboard, pick any budget, upload your ad, launch your brand-building campaign. Looking for Billboards for Rent?">
        <?php }
        else{
        ?>
            <meta property="og:image" content="https://inex.net/img/home-1.png">
            <title>INEX : Best Digital Billboard Advertising Company Oklahoma</title>
            <meta name="keywords" content="Best Digital Billboard Advertising Company Oklahoma, Digital Signs, digital signs Oklahoma, signs, sign companies Oklahoma, digital sign Midwest City, digital sign Del City, digital sign Nicoma Park.">
            <meta name="description" content="Get in front of your customers like never before with INEX Digital Billboards. We provide No minimum contract digital billboard advertising for small and medium-sized businesses. Digital billboard advertising is the most time-sensitive and flexible form of outdoor ... These outdoor signs allow advertisers to connect with audiences in real-time and ... uses a digital billboard to show the count of homes that their agents have.">
        <?php }?>
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
    </head>

    <body>
        <?php
            $route_name = request()->route()->getName();
        ?>
            <header id="topnav" class="defaultscroll sticky {{$route_name == 'register' ? 'bg-white' : ''}}">
                <div class="container">
                    <a class="logo" href="/">
                        <img src="/logo.png" height="44" class="logo-light-mode" alt="">
                        <img src="/logo.png" height="44" class="logo-dark-mode" alt="">
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
                                    <li class="has-submenu parent-menu-item"><a href="javascript:void(0)"> Billboard Advertising &nbsp;&nbsp;</a><span class="submenu-arrow"></span>
                                        <ul class="submenu bg-light">
                                            <li><a href="{{ route('why-use-outdoor') }}" class="sub-menu-item"> Why Use INEX</a></li>
                                            <li><a href="{{ route('locations') }}" class="sub-menu-item"> Locations </a></li>
                                            <li><a href="{{ route('register') }}" class="sub-menu-item">Create Account</a></li>
                                            <li><a href="{{ route('login-demo') }}" class="sub-menu-item">Try Our Demo </a></li>
                                        </ul> 
                                    </li>
                                    <li class="has-submenu parent-menu-item"><a href="javascript:void(0)"> Signs </a><span class="submenu-arrow"></span>
                                        <ul class="submenu bg-light">
                                            <li><a href="{{ route('digital-signs') }}" class="sub-menu-item">Why Use Digital Signs over Static Signs?</a></li>
                                            <li><a href="javascript:void(0)" class="sub-menu-item">What Kind of Signs do we offer? </a></li>
                                        </ul>  
                                    </li>
                                    <li class="has-submenu parent-menu-item"><a href="javascript:void(0)"> Geofence Marketing</a><span class="submenu-arrow"></span>
                                        <ul class="submenu bg-light">
                                            <li><a href="{{ route('geofencing') }}" class="sub-menu-item">Geofencing Explained</a></li>
                                        </ul>  
                                    </li>
                                </ul>
                            </li>

                            <li class="has-submenu parent-menu-item">
                                <a href="javascript:void(0)">Pricing</a><span class="menu-arrow"></span>
                                <ul class="submenu bg-light">
                                    <li><a href="{{ route('pricing') }}" class="sub-menu-item">All Pricing</a></li>
                                    <li><a href="{{ route('cost-calculator') }}" class="sub-menu-item">Billboard Calculator</a></li>
                                </ul>
                            </li>
                            <li class="has-submenu parent-parent-menu-item">
                                <a href="javascript:void(0)">Advertising Tools</a><span class="menu-arrow"></span>
                                <ul class="submenu bg-light">
                                    @foreach(App\DocCat::all() as $val)
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