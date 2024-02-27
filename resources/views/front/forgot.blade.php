@include('front.header')
<section class="bg-home d-flex align-items-center">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-6">
                <div class="me-lg-5">   
                    <a href="/"><img src="/logo.png" class="img-fluid d-block mx-auto" width="50%" alt="INEX"></a>
                    <h4 class="card-title text-center">
                        Control.<br>
                        Everything.<br>
                        Online.<br>
                    </h4>
                </div>
            </div>
            <div class="col-lg-5 col-md-6">
                <div class="card shadow rounded border-0">
                    <div class="card-body">
                        <h4 class="card-title text-center">Forgotten Password ?</h4>
                        <form class="login-form mt-4" action="/forgot" method="POST">
                            <div class="row">
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
                                <div class="col-lg-12">
                                    <p class="text-muted">Please enter your email to reset your password.</p>
                                    <div class="mb-3">
                                        <label class="form-label">Email address <span class="text-danger">*</span></label>
                                        <div class="form-icon position-relative">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail fea icon-sm icons"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                            <input type="email" class="form-control ps-5" placeholder="Enter Your Email Address" name="email" value="{{old('email')?old('email'):''}}" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="d-grid">
                                        <button class="btn btn-primary" type="submit">Send</button>
                                    </div>
                                </div>
                                <div class="mx-auto">
                                    <p class="mb-0 mt-3"><small class="text-dark me-2">Remembered your password?</small> <a href="{{route('login')}}" class="text-dark fw-bold">Sign in</a></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</section>
@include('front.footer')