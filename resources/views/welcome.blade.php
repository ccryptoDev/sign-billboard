@include('header')
<link rel="stylesheet" href="/front/css/cubeportfolio.min.css">
<!-- header -->
<style>
    @media(min-width:1200px){
        .image img{
            min-height : 250px;
        }

        .dark-slider h2, .light-slider h2{
            font-size : 56px !important;
        }
    }
    @media(max-width:1200px){
        .dark-slider h2, .light-slider h2{
            white-space: break-spaces;
            font-size : 46px;
        }
    }
    .widget{
        border : 1px solid #ddd;
        box-shadow : 0 0 5px 0 rgb(0 0 0 / 10%);
    }
    /* #services-slider .service-box{
        background : white;
        box-shadow : 0 0 5px 0 rgb(0 0 0 / 10%);
    } */
    #services-slider .service-box>span{
        width : 100px !important;
        height : 100px !important;
    }
    .tp-bgimg.defaultimg {
        background-image: url(/front/images/MainPageImageWebsite.jpg) !important;
    }
    .btn-register{
        align-self : center;
        max-height : 200px;
        padding : 20px;
        border : 5px solid #000;
        border-radius : 20px;
    }
    </style>
    <section id="main-banner-page" class="position-relative page-header service-header section-nav-smooth parallax" 
        style="background-image:url('/home.jpg');background-size:contain !important;"
    >
        <div class="overlay overlay-dark opacity-7 z-index-1"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="page-titles whitecolor text-center padding_top padding_bottom d-flex">
                        <a href='/register' class="btn btn-danger btn-register">Want to Advertise on our Billboards?</a>
                        <h2 class="font-bold padding_top padding_bottom">Automating & Simplifying the way you Advertise.</h2>
                    </div>
                </div>
                <div id="services-slider" class="owl-carousel">
                    <div class="item whitebox">
                        <div class="widget heading_space text-center text-md-left">
                            <h3 class="text-center darkcolor font-normal bottom15">Digital Billboard Advertising</h3>
                            <h5 class="text-center darkcolor bottom10">OUR JOB?  GROW YOUR BUSINESS.  HOW?</h5>
                            <ul class="text-left bottom30">
                                <li>- SIMPLIFY / AUTOMATE THE PROCESS OF ADVERTISING.</li>
                                <li>- GIVE YOU TOTAL CONTROL OVER YOUR ADS.</li>
                                <li>- BUILT FOR ANY SIZE BUDGET.</li>
                                <li>- ADD IMPULSE BUYING INTO YOUR OUTDOOR ADVERTISING.</li>
                                <li>- INTEGRATE YOUR SOCIAL MEDIA POST DELIVERY TO OUR ENTIRE CLIENT NETWORK.</li>
                            </ul>
                            <h5 class="text-center darkcolor bottom10">INEX HAS A UNIQUE APPROACH.</h5>
                            <div class="text-center">
                                <button class="text-center button gradient-btn" onclick="location.href='/why-use-outdoor'" type="button">LEARN MORE…</button>
                            </div>
                        </div>
                    </div>
                    <div class="item whitebox">
                        <div class="widget heading_space text-center text-md-left">
                            <h3 class="text-center darkcolor font-normal bottom15">Digital Signs for your Store Front</h3>
                            <h5 class="text-center darkcolor bottom10">INCREASE SALES.  HOW?</h5>
                            <ul class="text-left bottom30">
                                <li>- DIGITAL SIGN INCREASE STORE TRAFFIC 10%-30%.</li>
                                <li>- DRIVE IMPULSE BUYING.</li>
                                <li>- INTEGRATE WITH IN-STORE UPSELLING.</li>
                                <li>- USE TO BRAND MARK, EDUCATE, SALES, PROMOTIONS, PULL IN BUYERS.</li>
                            </ul>
                            <h5 class="text-center darkcolor bottom10">ONE STOP SHOP - WE SELL, INSTALL, TRAIN, AND SERVICE DIGITAL SIGNS.</h5>
                            <div class="text-center">
                                <button class="text-center button gradient-btn" onclick="location.href='/why-use-outdoor'" type="button">LEARN MORE…</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@include('footer')
<script>
	$(".owl-item").click(function(){
		console.log($(this));
	})
</script>