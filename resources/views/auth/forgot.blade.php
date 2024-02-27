@include('auth.header')
    <div class="d-flex flex-row-fluid flex-center">
        <div class="login-form">
            <form class="form" id="kt_login_singin_form" action="/forgot" method="POST">
                <div class="pb-5">
                    <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg pb-2">Forgotten Password ?</h3>
                    <div class="text-muted font-weight-bold font-size-h4 pb-5">
                        Enter your email to reset your password
                    </div>
                </div>
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
                <div class="form-group">
                    <label class="font-size-h6 font-weight-bolder text-dark">Email</label>
                    <input class="form-control h-auto py-7 px-6 rounded-lg border-0" type="text" name="email" value="{{old('email')?old('email'):''}}" autocomplete="off" required/>
                </div>
                <div class="pb-lg-0 pb-5">
                    <button type="submit" id="kt_login_singin_form_submit_button" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Submit</button>
                    <a href="{{route('login')}}" id="kt_login_singin_form_submit_button" class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@include('auth.footer')