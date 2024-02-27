@include('front.header')
<section class="bg-home d-flex align-items-center">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-6">
                <div class="me-lg-5">
                    <?php
                        $route_name = request()->route()->getName();
                    ?>
                    @if($route_name == 'login-demo')
                        <a href="/"><img src="/img/demo.jpg" class="img-fluid d-block mx-auto" width="80%" alt="INEX"></a>
                    @else
                        <a href="/"><img src="/logo.png" class="img-fluid d-block mx-auto" width="50%" alt="INEX"></a>
                    @endif
                    <h4 class="card-title text-center">
                        Control.<br>
                        Everything.<br>
                        Online.<br>
                    </h4>
                    @if($route_name == 'login-demo')
                    <a><img src="/img/clicksign.png" class="img-fluid d-block" width="40%" alt="INEX" style="margin-left:auto"></a>
                    @endif
                </div>
            </div>
            <div class="col-lg-5 col-md-6">
                <div class="card login-page bg-white shadow rounded border-0">
                    <div class="card-body">
                        <h4 class="card-title text-center">Login</h4>  
                        <form class="login-form mt-4" action="/login" method="POST">
                            <div class="row">
                                @csrf
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        <span>Please verify your email address</span>
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
                                    <div class="mb-3">
                                        <label class="form-label">Your Email <span class="text-danger">*</span></label>
                                        <div class="form-icon position-relative">
                                            <i data-feather="user" class="fea icon-sm icons"></i>
                                            <input type="email" class="form-control ps-5" placeholder="Email" name="email" value="{{old('email')?old('email'):($route_name=='login-demo'?'demo@inex.net':'')}}" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Password <span class="text-danger">*</span></label>
                                        <div class="form-icon position-relative">
                                            <i data-feather="key" class="fea icon-sm icons"></i>
                                            <input type="password" class="form-control ps-5" placeholder="Password" name="password" autocomplete="off" value="{{$route_name=='login-demo'?'demo':''}}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-between">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">Remember me</label>
                                            </div>
                                        </div>
                                        <p class="forgot-pass mb-0"><a href="{{route('forgot')}}" class="text-dark fw-bold">Forgot password ?</a></p>
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-0">
                                    <div class="d-grid">
                                        <button class="btn btn-primary" type="submit">Sign in</button>
                                    </div>
                                </div>

                                <div class="col-12 text-center">
                                    <p class="mb-0 mt-3"><small class="text-dark me-2">Don't have an account ?</small> <a href="{{route('register')}}" class="text-dark fw-bold">Sign Up</a></p>
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