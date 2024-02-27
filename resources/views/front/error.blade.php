@include('front.header')
<section class="bg-home d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-12 text-center">
                <img src="/layouts/images/404.svg" class="img-fluid" alt="404">
                <div class="text-uppercase mt-4 display-3">Oh ! no</div>
                @if(isset($error))
                    <div class="text-capitalize text-dark mb-4 error-page">{{$error}}</div>
                @else
                    <div class="text-capitalize text-dark mb-4 error-page">404</div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-center">  
                <a href="{{url()->previous()}}" class="btn btn-outline-primary mt-4">Go Back</a>
                <a href="/" class="btn btn-primary mt-4 ms-2">Go To Home</a>
            </div>
        </div>
    </div>
</section>
@include('front.footer')