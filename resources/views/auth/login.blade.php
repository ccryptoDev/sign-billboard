@include('auth.header')
    <div class="d-flex flex-row-fluid flex-center">
        <div class="login-form">
            <form class="form" id="kt_login_singin_form" action="/login" method="POST">
                <div class="pb-5">
                    <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg pb-2">Sign In</h3>
                    <div class="text-muted font-weight-bold font-size-h4 pb-5">
                        New Here?
                        <a href="{{route('register')}}" class="text-primary font-weight-bolder">Create Account</a>
                    </div>
                </div>
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
                <div class="form-group">
                    <label class="font-size-h6 font-weight-bolder text-dark">Email</label>
                    <input class="form-control h-auto py-7 px-6 rounded-lg border-0" type="text" name="email" value="{{old('email')?old('email'):''}}" autocomplete="off" required/>
                </div>
                <div class="form-group">
                    <div class="d-flex justify-content-between mt-n5">
                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">Password</label>
                        <a href="{{route('forgot')}}" class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5">
                        Forgot Password ?
                        </a>
                    </div>
                    <input class="form-control h-auto py-7 px-6 rounded-lg border-0" type="password" name="password" autocomplete="off" value="" required/>
                </div>
                <div class="pb-lg-0 pb-5">
                    <button type="submit" id="kt_login_singin_form_submit_button" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Sign In</button>
                </div>
                <!-- <div class="text-left d-flex justify-content-center">
                    <div class="top-signin text-left d-flex pt-5 pb-lg-0 pb-10">
                        <span class="font-weight-bold text-muted font-size-h4">Having issues?</span>
                        <a href="/contact" class="font-weight-bold text-primary font-size-h4 ml-2" id="kt_login_signup">Get Help</a>
                    </div>
                </div> -->
            </form>
        </div>
    </div>
</div>
@include('auth.footer')