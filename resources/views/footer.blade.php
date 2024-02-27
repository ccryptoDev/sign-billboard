

@if(session('100'))
<section id="our-testimonial" class="bglight padding_bottom">
    <div class="parallax page-header testimonial-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-6 col-md-12 text-center text-lg-right">
                    <div class="heading-title wow fadeInUp padding_testi" data-wow-delay="300ms">
                        <span class="whitecolor">Quisque tellus risus, adipisci</span>
                        <h2 class="whitecolor font-normal">What People Say</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="owl-carousel" id="testimonial-slider">
            <?php
            foreach($ad as $value => $ads_temp){
                if($value < 5){
            ?>
            <div class="item testi-box">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-md-12 text-center">
                        <div class="d-inline-block">
                            <img src="/upload/{{$ads_temp->img_url}}" alt="">
                        </div>
                        <h4 class="defaultcolor font-light top15"><a href="#.">{{$ads_temp->business_name}}</a></h4>
                        <p></p>
                    </div>
                    <div class="col-lg-6 offset-lg-2 col-md-10 offset-md-1 text-lg-left text-center">
                        <p class="bottom15 top90">We have a number of different teams within our agency that specialise in different areas of business so you can be sure that you won’t receive a generic service and although we boast a years and years of service.</p>
                        <span class="d-inline-block test-star">
                            <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                        </span>
                    </div>
                </div>
            </div>
            <?php } }?>
        </div>
    </div>
</section>
@endif
<footer id="site-footer" class=" bgdark padding_top">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="footer_panel padding_bottom_half bottom20">
                    <a href="/" class="footer_logo bottom25" style="width:150px"><img src="/logo.png" alt="MegaOne"></a>
                    <p class="whitecolor bottom25">INEX is dedicated to making advertising simple, quick, and extremely effective. <br><br />Sales: sales@inex.net<br /> Support: support@inex.net</p>
                    <div class="d-table w-100 address-item whitecolor bottom25">
                        <span class="d-table-cell align-middle"><i class="fas fa-mobile-alt"></i></span>
                        <p class="d-table-cell align-middle bottom0"><a href="tel:405-415-3002" >
                            405-415-3002
                        </a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="footer_panel padding_bottom_half bottom20 pl-0 pl-lg-5">
                    <h3 class="whitecolor bottom25">Our Services</h3>
                    <ul class="links">
                        <li><a href="/bill_ad">Digital Billboard Advertising</a></li>
                        <li><a href="/digital">Digital Sign Sales</a></li>
                        <li><a href="/contact">Contact Us</a></li>
                        <li><a href="/about_us">About Us</a></li>
                        <li><a href="/login">Login</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="footer_panel padding_bottom_half bottom20">
                    <h3 class="whitecolor bottom25">Business hours</h3>
                    <ul class="hours_links whitecolor">
                        <li><span>Monday - Friday:</span> <span>9 AM-5 PM</span></li>
                    </ul>
                    <h3 class="whitecolor bottom25"></h3>
                    <ul class="social-icons white wow fadeInUp" data-wow-delay="300ms">
                        <li><a href="https://www.facebook.com/Digital-Signs-107309900997274/?modal=admin_todo_tour" target="_blank"><i class="fab fa-facebook-f"></i> </a> </li>
                        <li><a href="https://twitter.com/INEX44180205" target="_blank"><i class="fab fa-twitter"></i> </a> </li>
                        <li><a href="https://www.linkedin.com/in/rusty-latenser-0a66521a9/" target="_blank"><i class="fab fa-linkedin-in"></i> </a> </li>
                        <li><a href="https://www.instagram.com/latenser11/" target="_blank"><i class="fab fa-instagram"></i> </a> </li>
                    </ul>
                    <h3 class="whitecolor bottom25"></h3>
                    <span class="whitecolor bottom5 d-block"><a data-toggle="modal" data-target="#term_modal" href="javascript:;">Terms and Conditions</a></span>
                    <span class="whitecolor bottom25"><a data-toggle="modal" data-target="#privacy_modal" href="javascript:;">Privacy Policy</a></span>
                </div>
            </div>
        </div>
    </div>
</footer>
<ul class="sticky-toolbar nav flex-column pl-2 pr-2 pt-3 pb-3 mt-4 hide" id="sticky">
	<li class="nav-item" id="kt_demo_panel_toggle" data-toggle="tooltip" title="??? Call Us Now" data-placement="right">
		<a class="btn btn-sm btn-icon btn-bg-danger btn-icon-success" href="tel:405-415-3002">
			<i class="fas fa-phone-alt text-white"></i>
		</a>
	</li>
	<li class="nav-item mt-2" id="kt_demo_panel_toggle" data-toggle="tooltip" title="Google Review" data-placement="right">
		<a class="btn btn-sm btn-icon btn-bg-success btn-icon-success" target="_blank" href="https://g.page/r/CalqxUYJd-yuEA0/review">
			<i class="fab fa-google text-white"></i>
		</a>
	</li>
</ul>
<div class="copyright">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center wow fadeIn animated" data-wow-delay="300ms">
                <p class="m-0 py-3">Copyright © <span id="year1"></span> <a href="javascript:void(0)" class="hover-default">INEX</a>. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</div>
<div id="hs-script-loader"></div>
@include('auth.term-modal')
<!--Footer ends-->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="/front/js/jquery-3.4.1.min.js"></script>
<!--Bootstrap Core-->
<script src="/front/js/propper.min.js"></script>
<script src="/front/js/bootstrap.min.js"></script>
<!--to view items on reach-->
<script src="/front/js/jquery.appear.js"></script>
<!--Owl Slider-->
<script src="/front/js/owl.carousel.min.js"></script>
<!--number counters-->
<script src="/front/js/jquery-countTo.js"></script>
<!--Parallax Background-->
<script src="/front/js/parallaxie.js"></script>
<!--Cubefolio Gallery-->
<script src="/front/js/jquery.cubeportfolio.min.js"></script>
<!--Fancybox js-->
<script src="/front/js/jquery.fancybox.min.js"></script>
<!--tooltip js-->
<script src="/front/js/tooltipster.min.js"></script>
<!--wow js-->
<script src="/front/js/wow.js"></script>
<!--Revolution SLider-->
<script src="/front/js/revolution/jquery.themepunch.tools.min.js"></script>
<script src="/front/js/revolution/jquery.themepunch.revolution.min.js"></script>
<!-- SLIDER REVOLUTION 5.0 EXTENSIONS -->
<script src="/front/js/revolution/extensions/revolution.extension.actions.min.js"></script>
<script src="/front/js/revolution/extensions/revolution.extension.carousel.min.js"></script>
<script src="/front/js/revolution/extensions/revolution.extension.kenburn.min.js"></script>
<script src="/front/js/revolution/extensions/revolution.extension.layeranimation.min.js"></script>
<script src="/front/js/revolution/extensions/revolution.extension.migration.min.js"></script>
<script src="/front/js/revolution/extensions/revolution.extension.navigation.min.js"></script>
<script src="/front/js/revolution/extensions/revolution.extension.parallax.min.js"></script>
<script src="/front/js/revolution/extensions/revolution.extension.slideanims.min.js"></script>
<script src="/front/js/revolution/extensions/revolution.extension.video.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4pvNQmbADDWIXTrZPthdRduyLQWO17zg"></script>
<!--custom functions and script-->
<script src="/front/js/map.js"></script>
<script src="/front/js/functions.js"></script>
<script src="/dist/cookies-message.min.js"></script>
<script src="/dist/js.cookie.js"></script>
<script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/23356061.js"></script>
<script type="text/javascript">
    function setCookie(key, value, expiry) {
        var expires = new Date();
        expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
        document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
    }

    setTimeout(() => {
        $("#sticky").removeClass('hide');
    }, 5000);
    function getCookie(key) {
        var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
        return keyValue ? keyValue[2] : null;
    }

    function eraseCookie(key) {
        var keyValue = getCookie(key);
        setCookie(key, keyValue, '-1');
    }
    var url_list = ['/', "/why-use-outdoor", "/our_location"];
    $(document).ready(function(){
        $.CookiesMessage({
            messageText: "We use technical and analytics cookies to ensure that we give you the best experience on our website.",
            messageBg: "#151515",
            messageColor: "#FFFFFF",
            messageLinkColor: "#F0FFAA",
            closeEnable: false,
            closeColor: "#444444",
            // closeBgColor: "#000000",
            acceptEnable: true,
            acceptText: "Accept & Close",
            infoEnable: true,
            infoText: "More Info",
            infoUrl: "#",
            cookieExpire: 180
        });
        var visits = JSON.parse(localStorage.getItem("visits"));
        var pathname = window.location.pathname;
        if(jQuery.inArray(pathname,  url_list) !== -1 && jQuery.inArray(pathname, visits) === -1){
            if(visits == null){
                visits = [pathname];
            }
            else{
                visits.push(pathname);
            }
            localStorage.setItem("visits", JSON.stringify(visits));
            setTimeout(() => {
                $(".btn-fc").click();
            }, 5000);
        }
    })
</script>
