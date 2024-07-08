
        <?php
            $route_name = request()->route()->getName();
        ?>
        @if($route_name != "register" && $route_name != 'login' && $route_name != 'forgot')
        <footer class="footer">    
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="footer-py-60">
                            <div class="row">
                                <div class="col-lg-3 col-12 mb-0 mb-md-4 pb-0 pb-md-2">
                                    <a href="/" class="logo-footer">
                                        <img src="/logo.png" height="45" alt="INEX">
                                    </a>
                                    <p class="mt-4">INEX is dedicated to making advertising simple, quick, and extremely effective.</p>
                                    <p class="mb-1"><a class="text-foot" href="mailto:sales@inex.net">Sales: sales@inex.net</a></p>
                                    <p class=""><a class="text-foot" href="mailto:support@inex.net">Support: support@inex.net</a></p>
                                    <a target="_blank" href="tel:405-415-3002" class="text-foot rounded">
                                        <i data-feather="phone" class="fea icon-sm fea-phone"></i> &nbsp; 405-415-3002
                                    </a>
                                </div>
                                
                                <div class="col-lg-3 col-md-4 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                                    <h5 class="footer-head">Company</h5>
                                    <ul class="list-unstyled footer-list mt-4">
                                        <li><a href="{{route('about-us')}}" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> About Us</a></li>
                                        <li><a href="{{route('contact-us')}}" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> Contact Us</a></li>
                                        <li><a style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#term_modal" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> Terms and Conditions</a></li>
                                        <li><a style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#privacy_modal" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> Privacy Policy</a></li>
                                    </ul>
                                </div>
            
                                <div class="col-lg-3 col-md-4 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                                    <h5 class="footer-head">Business hours</h5>
                                    <p class="mt-4">Monday - Friday: 9 AM-5 PM</p>
                                    <ul class="list-unstyled social-icon foot-social-icon mb-0 mt-4">
                                        <li class="list-inline-item"><a target="_blank" href="https://www.facebook.com/Digital-Signs-107309900997274/?modal=admin_todo_tour" class="rounded" aria-label="Facebook" alt="Facebook"><i data-feather="facebook" class="fea icon-sm fea-social"></i></a></li>
                                        <li class="list-inline-item"><a target="_blank" href="https://twitter.com/INEX44180205" class="rounded" aria-label="Twitter" alt="Twitter"><i data-feather="twitter" class="fea icon-sm fea-social"></i></a></li>
                                        <li class="list-inline-item"><a target="_blank" href="https://www.linkedin.com/in/rusty-latenser-0a66521a9/" class="rounded" aria-label="Linkedin" alt="Linkedin"><i data-feather="linkedin" class="fea icon-sm fea-social"></i></a></li>
                                        <li class="list-inline-item"><a target="_blank" href="https://www.instagram.com/latenser11/" class="rounded" aria-label="Instagram" alt="Instagram"><i data-feather="instagram" class="fea icon-sm fea-social"></i></a></li>
                                    </ul>
                                </div>
                                <div class="col-lg-3 col-md-4 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                                    <h5 class="footer-head">Newsletter</h5>
                                    <p class="mt-4">Sign up and receive the latest tips via email. Also get access to all our ebooks, blogs, and case studies when you sign up.</p>
                                    <form action="/subscribe-email" method="POST">
                                        @csrf
                                        @if(session('success'))
                                            <div class="alert alert-success">
                                                <span>{{session('success')}}</span>
                                            </div>
                                        @endif
                                        @if($errors->any())
                                            <div class="alert alert-danger">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="foot-subscribe mb-3">
                                                    <label class="form-label">Insert your email <span class="text-danger">*</span></label>
                                                    <div class="form-icon position-relative">
                                                        <i data-feather="mail" class="fea icon-sm icons"></i>
                                                        <input type="email" name="email" id="emailsubscribe" class="form-control ps-5 rounded" placeholder="Your email : " required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="d-grid">
                                                    <input type="submit" id="submitsubscribe" name="send" class="btn btn-warning" style="background-color:#ffc107 !important;border-color:#ffc107 !important" value="Subscribe">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-py-30 footer-bar">
                <div class="container text-center">
                    <div class="row align-items-center">
                        <div class="col-sm-12">
                            <div class="text-sm-start">
                                <p class="mb-0"> Copyright © <script>document.write(new Date().getFullYear())</script> INEX. All Rights Reserved.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        @endif
        <div class="offcanvas offcanvas-end bg-white shadow" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header p-4 border-bottom">
                <h5 id="offcanvasRightLabel" class="mb-0">
                    <img src="/logo.png" height="45" class="light-version" alt="INEX">
                    <img src="/logo.png" height="45" class="dark-version" alt="INEX">
                </h5>
                <button type="button" class="btn-close d-flex align-items-center text-dark" data-bs-dismiss="offcanvas" aria-label="Close"><i class="uil uil-times fs-4"></i></button>
            </div>
            <div class="offcanvas-body p-4">
                <div class="row">
                    <div class="col-12">
                        <img src="/img/writing-emails-for-work.jpg" class="img-fluid d-block mx-auto" style="max-width: 256px;" alt="">
                        <div class="card border-0 mt-5" style="z-index: 1">
                            <div class="card-body p-0">
                                <form method="post" action="/contact" name="myForm" onsubmit="return validateForm()">
                                    <p id="error-msg" class="mb-0"></p>
                                    <div id="simple-msg"></div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            @csrf
                                            @if(session('success'))
                                                <div class="alert alert-success">
                                                    <span>{{session('success')}}</span>
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
                                                    <i data-feather="user" class="fea icon-sm icons"></i>
                                                    <input name="name" type="text" value="{{ old('name')?old('name'):'' }}" class="form-control ps-5" placeholder="Name :" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Your Email <span class="text-danger">*</span></label>
                                                <div class="form-icon position-relative">
                                                    <i data-feather="mail" class="fea icon-sm icons"></i>
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
                                                <label class="form-label">Comments <span class="text-danger">*</span></label>
                                                <div class="form-icon position-relative">
                                                    <i data-feather="message-circle" class="fea icon-sm icons clearfix"></i>
                                                    <textarea name="message" rows="4" class="form-control ps-5" placeholder="Message :" required>{{ old('message')?old('message'):'' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="g-recaptcha mb-3" name="g-recaptcha-response" data-sitekey="6LdRA1kkAAAAACQozwu8-LZNab4x9IQN-ohTNf84"></div> --}}
                                        <div class="g-recaptcha mb-3" name="g-recaptcha-response" data-sitekey="6LciwwcqAAAAAAQ1ucuknlIdEkUYZkQS_99BxohZ"></div>
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
                    </div>
                </div>
            </div>

        </div>
        <!-- Offcanvas End -->

        <!-- Back to top -->
        <a href="#" onclick="topFunction()" id="back-to-top" class="back-to-top fs-5"><i data-feather="arrow-up" class="fea icon-sm icons align-middle"></i></a>
        <!-- Back to top -->
        <div id="style-switcher" class="bg-light border p-3 pt-2 pb-2">
            <div class="bottom">
                <a href="tel:405-415-3002" class="settings bg-soft-primary title-bg-dark shadow d-block" title="??? Call Us Now">
                    <i class="mdi mdi-phone ms-1 mdi-24px position-absolute text-primary"></i>
                </a>
                <a href="https://g.page/r/CalqxUYJd-yuEA0/review" target="_blank" class="settings bg-danger title-bg-dark shadow d-block mt-5" title="Google Review">
                    <i class="mdi mdi-google ms-1 mdi-24px position-absolute text-white"></i>
                </a>
                <a href="javascript:void(0)" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" class="settings bg-soft-muted title-bg-dark shadow d-block mt-15" title="Contact Us" style="margin-top: 6rem !important">
                    <i class="mdi mdi-mail ms-1 mdi-24px position-absolute text-danger"></i>
                </a>
            </div>
        </div>
        @include('front.term-modal')
        <!-- Cookie -->
        <div class="p-4 cookie d-none">
            <div class="alert alert-dark bg-white mb-0 content" role="alert">
                <!-- <h4 class="alert-heading text-dark">Cookie Management</h4> -->
                <p class="text-dark">We use essential cookies to make our site work correctly for you. With your consent, we may also use non-essential cookies to improve user experience and analyze website traffic. By clicking “Accept,“ you agree to our website's cookie use as described in our Privacy Policy.</p>
                <!-- <p class="mb-0 border-top pt-3 text-dark">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p> -->
                <a class="btn btn-warning" id="accept-cookie"> Accept </a>
                <a class="btn btn-outline-warning" id="decline-cookie"> Decline </a>
            </div>
        </div>
        <script src="/layouts/js/bootstrap.bundle.min.js"></script>
        <script src="/layouts/js/shuffle.min.js"></script>
        <script src="/layouts/js/tiny-slider.js"></script>
        <script src="/layouts/js/tobii.min.js"></script>
        <script src="/layouts/js/feather.min.js"></script>
        <script src="/layouts/js/switcher.js"></script>
        <script src="/layouts/js/plugins.init.js"></script>
        <script src="/layouts/js/app.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        <script src="/layouts/js/custom.js"></script>
    </body>
</html>