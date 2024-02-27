@include('front.header')
@include('front.sub-header')
<section class="section pt-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 mt-4 pt-2 m-auto">
                <div class="card pricing-rates business-rate border-0 p-4 rounded-md shadow">
                    <div class="card-body p-0">
                        <span class="title fw-bold text-uppercase text-primary mb-4">Billboard Advertising</span>

                        <ul class="list-unstyled pt-3">
                            <li class="h6 mb-0"><span class="text-primary h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>No Contract</li>
                            <li class="h6 mb-0"><span class="text-primary h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>Purchase Weekly if You Want</li>
                            <li class="h6 mb-0"><span class="text-primary h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>One Week Minimum</li>
                            <li class="h6 mb-0"><span class="text-primary h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>Unlimited Ads (no additional Cost)</li>
                            <li class="h6 mb-0"><span class="text-primary h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>Use our Playlist to turn certain Ads On/Off</li>
                            <li class="h6 mb-0"><span class="text-primary h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>Manage 24/7 without INEX Oversight</li>
                            <li class="h6 mb-0"><span class="text-primary h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>Stop Anytime (if longer than a week)</li>
                            <li class="h6 mb-0"><span class="text-primary h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>Buy Multiple Slots If you want.</li>
                            <li class="h6 mb-0"><span class="text-primary h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>Get your Message in Front of Everyone</li>
                            <li class="h6 mb-0"><a href="{{ route('cost-calculator') }}"><span class="text-primary h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>Use our Cost Calculator</a></li>
                            <li class="h6 mb-0"><span class="text-primary h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>Everything Online</li>
                            <li class="h6 mb-0"><span class="text-primary h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>Controllable by Phone</li>
                            <li class="h6 mb-0"><span class="text-primary h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>$10 per Day per Side!</li>
                        </ul>

                        <div class="mt-4">
                            <div class="d-grid">
                                <a class="btn btn-primary" href="{{ route('register') }}">Open Your Free Account</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@include('front.footer')