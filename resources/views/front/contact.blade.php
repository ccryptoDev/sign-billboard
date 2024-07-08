@include('front.header')
@include('front.sub-header')
<section class="section pt-5 mt-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 col-md-6 mt-4 mt-sm-0 pt-2 pt-sm-0 order-2 order-md-1">
                <div class="card custom-form rounded border-0 shadow p-4">
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
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user fea icon-sm icons"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <input name="name" id="name" type="text" value="{{ old('name')?old('name'):'' }}" class="form-control ps-5" placeholder="Name :" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <div class="form-icon position-relative">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail fea icon-sm icons"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                        <input name="email" id="email" type="email" value="{{ old('email')?old('email'):'' }}" class="form-control ps-5" placeholder="Email :" required>
                                    </div>
                                </div> 
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Type </label>
                                    <div class="form-icon position-relative">
                                        <select class="form-select form-control" name="type" aria-label="Select Contact Type">
                                            <option value="Contact Sales" {{$type=='sales'?'selected':''}}>Contact Sales</option>
                                            <option value="Report a Problem" {{$type=='report'?'selected':''}}>Report a Problem</option>
                                            <option value="Suggestion" {{$type=='suggestion'?'selected':''}}>Suggestion</option>
                                        </select>
                                    </div>
                                </div> 
                            </div>

                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Message <span class="text-danger">*</span></label>
                                    <div class="form-icon position-relative">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle fea icon-sm icons clearfix"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                        <textarea name="message" id="comments" rows="4" class="form-control ps-5" placeholder="Message :" required>{{ old('message')?old('message'):'' }}</textarea>
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
            <div class="col-lg-7 col-md-6 order-1 order-md-2">
                <div class="card border-0">
                    <div class="card-body p-0">
                        <img src="/img/writing-emails-for-work.jpg" class="img-fluid" alt="">
                        <div class="d-flex contact-detail align-items-center mt-3">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone fea icon-m-md text-dark me-3"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
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