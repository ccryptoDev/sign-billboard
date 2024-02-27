@include('header')
<!--Page Header-->
<section id="main-banner-page" class="position-relative page-header service-header section-nav-smooth parallax" style="background-image:url('/assets/media/bg/bg-10.jpg');">
    <div class="overlay overlay-dark opacity-7 z-index-1"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="page-titles whitecolor text-center padding_top padding_bottom">
                    <h2 class="font-bold padding_top"> Contact Us</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Page Header ends -->
<!-- Contact US -->
<section id="stayconnect1" class="bglight position-relative pt-5 pb-5 noshadow">
    <div class="container whitebox">
        <div class="widget py-5">
            <div class="row">
                <div class="col-md-12 text-center wow fadeIn mt-n3" data-wow-delay="300ms">
                    <h2 class="heading bottom30 darkcolor font-light2 pt-1"><span class="font-normal">Contact</span> Us
                        <span class="divider-center"></span>
                    </h2>
                    <div class="col-md-8 offset-md-2 bottom35">
                        <!-- <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A dolores explicabo laudantium, omnis provident quam reiciendis voluptatum?</p> -->
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 order-sm-2">
                    <div class="contact-meta px-2 text-center text-md-left">
                        <!-- <div class="heading-title">
                            <span class="defaultcolor mb-3">INEX Agency Worldwide</span>
                            <h2 class="darkcolor font-normal mb-4"><span class="d-none d-md-inline-block">Our</span> Agency Office <span class="d-none d-md-inline-block">In Edmond</span></h2>
                        </div> -->
                        <p class="bottom10">Address: Edmond OK 73025</p>
                        <p class="bottom10">405-415-3002</p>
                        <p class="bottom10"><a href="mailto:sales@inex.net">sales@inex.net</a></p>
                        <p class="bottom10">Mon-Fri: 9am-5pm</p>
                        <ul class="social-icons mt-4 mb-4 mb-sm-0 wow fadeInUp" data-wow-delay="300ms">
                            <li><a href="https://www.facebook.com/search/top?q=inex"><i class="fab fa-facebook-f"></i> </a> </li>
                            <li><a href="https://twitter.com/INEX44180205"><i class="fab fa-twitter"></i> </a> </li>
                            <li><a href="https://www.linkedin.com/in/rusty-latenser-0a66521a9/"><i class="fab fa-linkedin-in"></i> </a> </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="heading-title  wow fadeInUp" data-wow-delay="300ms">
                        <form class="getin_form wow fadeInUp" data-wow-delay="400ms" onsubmit="return false;">
                            <div class="row px-2">
                                <div class="col-md-12 col-sm-12" id="result1"></div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="name1" class="d-none"></label>
                                        <input class="form-control" id="name1" type="text" placeholder="Name:" required="" name="userName">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="email1" class="d-none"></label>
                                        <input class="form-control" type="email" id="email1" placeholder="Email:" name="email">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="message1" class="d-none"></label>
                                        <textarea class="form-control" id="message1" placeholder="Message:" required="" name="message"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <button type="submit" id="submit_btn1" class="button gradient-btn w-100">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="widget text-center top60 w-100">
                    <div class="contact-box">
                        <span class="icon-contact defaultcolor"><i class="fas fa-mobile-alt"></i></span>
                        <p class="bottom0"><a href="tel:+405-415-3002">+405-415-3002</a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="widget text-center top60 w-100">
                    <div class="contact-box">
                        <span class="icon-contact defaultcolor"><i class="far fa-envelope"></i></span>
                        <p class="bottom0"><a href="mailto:sales@inex.net">sales@inex.net</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('footer')