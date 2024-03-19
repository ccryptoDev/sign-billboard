
@include('front.header')
<section class="bg-half-170 d-table w-100 overflow-hidden" id="home" style="background-image: url('/img/Home.jpg');">
    <div class="container-fluid">
        <div class="row align-items-center p-3">
            <div class="col-lg-2 col-md-4 mt-4 pt-2 mt-sm-0 pt-sm-0">
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="title-heading bg-secondary rounded p-2" style="
                    background-image: url(/img/home01.png);
                    background-position: left;
                    background-size: contain;
                    background-repeat: no-repeat;">
                    <ul class="list-unstyled d-flex justify-content-betweenmt-3 mb-0">
                        <li class="m-auto" style="min-height:150px">
                            <!-- <h1 class="heading text-white">Billboard<br> Advertising</h1> -->
                        </li>
                        <li class="ml-auto mt-auto mb-auto">
                            <ul class="list-unstyled text-white">
                                <li class="mb-2">
                                    <a href="{{ route('register') }}" class="btn btn-block btn-light">Advertise Right Now</a>
                                </li>
                                <li class="mb-0">
                                    <a href="{{ route('login-demo') }}" class="btn btn-light">Try Our Online Demo</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row align-items-center p-3">
            <div class="col-lg-1">
            </div>
            <div class="col-lg-6 col-md-12 mt-4 pt-2 mt-sm-0 pt-sm-0">
                <div class="title-heading bg-danger rounded p-2" style="
                    background-image: url(/img/home02.png);
                    background-position: left;
                    background-size: contain;
                    background-repeat: no-repeat;">
                    <ul class="list-unstyled d-flex justify-content-betweenmt-3 mb-0">
                        <li class="m-auto" style="min-height:150px">
                            <!-- <h1 class="heading text-white">Business Signs<br> Sales & Service</h1> -->
                        </li>
                        <li class="ml-auto mt-auto mb-auto">
                            <ul class="list-unstyled text-white">
                                <li class="mb-2">
                                    <a href="{{ route('digital-signs') }}" class="btn btn-block btn-light">Why Business Signs?</a>
                                </li>
                                <li class="mb-0">
                                    <a href="/contact/sales" class="btn btn-light">Get Free Estimate</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row align-items-center p-3">
            <div class="col-lg-6 col-md-12 mt-4 pt-2 mt-sm-0 pt-sm-0">
                <div class="title-heading bg-primary rounded p-2" style="
                    background-image: url(/img/home03.png);
                    background-position: left;
                    background-size: contain;
                    background-repeat: no-repeat;">
                    <ul class="list-unstyled d-flex justify-content-betweenmt-3 mb-0">
                        <li class="m-auto" style="min-height:150px">
                            <!-- <h1 class="heading text-white">GeoFence<br> Marketing</h1> -->
                        </li>
                        <li class="ml-auto mt-auto mb-auto">
                            <ul class="list-unstyled text-white">
                                <li class="mb-2">
                                    <a href="{{ route('geofencing') }}" class="btn btn-block btn-light">What is Geofencing Marketing?</a>
                                </li>
                                <li class="mb-0">
                                    <a href="/contact/sales" class="btn btn-light">Get Your Free Consultation</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="d-table w-100 overflow-hidden p-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-left">
                <div class="section-title">
                    <h4 class="title mb-4">Advertising Your Whole Business Will Love</h4>
                    <p class="text-dark mx-auto">INEX has the tools you need for advertising your business and increasing your sales. Each product is powerful alone, but the real magic happens when you use them together.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="d-table w-100 overflow-hidden pb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-left">
                <div class="section-title">
                    <h4 class="title mb-4">Billboard Advertising</h4>
                    <p class="text-dark mx-auto">Get people to know you no matter what digital platform they use.  How?   People spend 17% of their waking hours in their cars – looking at signs!   Deliver your message inexpensively and to EVERYONE.   What is even better?  It is All Automated.   All Controlled By You.   24/7</p>
                
                    <div class="mt-4">
                        <a href="{{ route('register') }}" class="btn btn-primary mt-2 me-2">Open FREE Account</a>
                        <a href="{{ route('login-demo') }}" class="btn btn-outline-primary mt-2">Try Our Demo</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="d-table w-100 overflow-hidden pb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-left">
                <div class="section-title">
                    <h4 class="title mb-4">Business / Store Signage</h4>
                    <p class="text-dark mx-auto">Use Outdoor Signage to draw people into your store with sales and promotions.   Regardless, make sure you install the right sized sign for the road speed.   Too small means the sign is ineffective.   Too large means you wasted money.</p>
                    <p class="text-dark mx-auto">Use Indoor signage inside your business to push high margin products or purchase additional products.   Use interactive signs to reduce labor costs.  Use digital signage to draw people and educate them.</p>
                
                    <div class="mt-4">
                        <a href="{{ route('register') }}" class="btn btn-primary mt-2 me-2">What Is The Perfect Sign Size?</a>
                        <a href="/contact/sales" class="btn btn-outline-primary mt-2">Get a Free Estimate</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="d-table w-100 overflow-hidden pb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-left">
                <div class="section-title">
                    <h4 class="title mb-4">GeoFencing Marketing</h4>
                    <p class="text-dark mx-auto">Yes, we know all about social media.   It can be much more effective, especially is used with by itself.   You need to track down people already interested in your products.  How?</p>
                
                    <div class="mt-4">
                        <a href="{{ route('geofencing') }}" class="btn btn-primary mt-2 me-2">Show Me How It Works</a>
                        <a href="{{ route('case-studies', ['title'=> 'GeoFence Marketing' ]) }}" class="btn btn-outline-primary mt-2">Tools Used to Drive Sales</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="d-table w-100 overflow-hidden pb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-left">
                <div class="section-title">
                    <h4 class="title mb-4">What are people saying about our Services?</h4>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12 mt-4 pt-2">
                <div class="d-flex client-testi">
                    <div class="flex-1 content p-3 shadow rounded bg-white position-relative">
                        <ul class="list-unstyled mb-0">
                            <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                            <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                            <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                            <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                            <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                        </ul>
                        <p class="text-muted mt-2">" An affordable, easily accessible, powerfully effective way to advertise. Perfectly located digital billboard with attractive displays (bright enough to be viewed throughout daylight and dark and inclement weather)."</p>
                        <h6 class="text-primary">- A J</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12 mt-4 pt-2">
                <div class="d-flex client-testi">
                    <div class="flex-1 content p-3 shadow rounded bg-white position-relative">
                        <ul class="list-unstyled mb-0">
                            <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                            <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                            <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                            <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                            <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                        </ul>
                        <p class="text-muted mt-2">" What a wonderful experience. The sign was a BIG help getting the word out about our event. It was easy and so much fun to create slides. Wonderful people to work with too. "</p>
                        <h6 class="text-primary">- LaNeta Guth </h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12 mt-4 pt-2">
                <div class="d-flex client-testi">
                    <div class="flex-1 content p-3 shadow rounded bg-white position-relative">
                        <ul class="list-unstyled mb-0">
                            <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                            <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                            <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                            <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                            <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                        </ul>
                        <p class="text-muted mt-2">" Everything about this was so easy! Setting up the account only took a few minutes and creating the ad took even less time. The cost is very affordable. Our first ad ended yesterday and we've already set up our second ad!"</p>
                        <h6 class="text-primary">- Kristin Richardson </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="d-table w-100 overflow-hidden pb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 text-left">
                <div class="section-title">
                    <h4 class="title mb-4">Need Help in Understanding Advertising?</h4>
                    <p class="text-dark mx-auto">Download our FREE Ebooks and documents that teach you a simplified approach to getting the word out about your business.</p>
                </div>
            </div>
            <div class="col-lg-5 col-md-6 mt-4 mt-sm-0 pt-2 pt-sm-0 order-2 order-md-1">
                <div class="card custom-form rounded border-0 shadow p-4">
                    <form method="post" action="/contact" name="myForm" onsubmit="return validateForm(event)">
                        <p id="error-msg" class="mb-0"></p>
                        <div id="simple-msg"></div>
                        <div class="row">
                            <div class="col-md-12">
                                @csrf
                                @if(session('successSub'))
                                    <div class="alert alert-success">
                                        <span>{{session('successSub')}}</span>
                                    </div>
                                @endif
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="mb-3">
                                    <label class="form-label">Your Name <span class="text-danger">*</span></label>
                                    <div class="form-icon position-relative">
                                        <svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user fea icon-sm icons"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <input name="name" type="text" value="{{ old('name')?old('name'):'' }}" class="form-control ps-5" placeholder="Name :" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <div class="form-icon position-relative">
                                        <svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail fea icon-sm icons"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                        <input name="email" type="email" value="{{ old('email')?old('email'):'' }}" class="form-control ps-5" placeholder="Email :" required>
                                    </div>
                                </div> 
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Type </label>
                                    <div class="form-icon position-relative">
                                        <select class="form-select form-control" name="type" aria-label="Select Contact Type">
                                            <option value="Contact Sales" selected>Contact Sales</option>
                                            <option value="Report a Problem">Report a Problem</option>
                                            <option value="Suggestion">Suggestion</option>
                                        </select>
                                    </div>
                                </div> 
                            </div>

                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Message <span class="text-danger">*</span></label>
                                    <div class="form-icon position-relative">
                                        <svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle fea icon-sm icons clearfix"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                        <textarea name="message" rows="4" class="form-control ps-5" placeholder="Message :" required>{{ old('message')?old('message'):'' }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="g-recaptcha mb-3" name="g-recaptcha-response" data-sitekey="6LdRA1kkAAAAACQozwu8-LZNab4x9IQN-ohTNf84"></div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-grid">
                                    <button type="submit" name="send" class="btn btn-primary">Send Message</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-7 col-md-6 order-1 order-md-2">
                <div class="card border-0">
                    <div class="card-body p-0">
                        <img src="/img/writing-emails-for-work.jpg" class="img-fluid" alt="Contact us">
                        <div class="d-flex contact-detail align-items-center mt-3">
                            <div class="icon">
                                <svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone fea icon-m-md text-dark me-3"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            </div>
                            <div class="flex-1 content">
                                <h6 class="title fw-bold mb-0">Phone</h6>
                                <a href="tel:+1405-415-3002" class="text-primary">+405-415-3002</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('front.footer')
  