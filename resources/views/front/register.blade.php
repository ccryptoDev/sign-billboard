@include('front.header')
<section class="bg-home d-flex align-items-center mt-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6">
                <div class="me-lg-5">
                    <a href="/"><img src="/img/register-1.jpg" class="img-fluid d-block mx-auto" width="50%" alt="INEX"></a>
                    <h4 class="card-title text-center">
                        Control.<br>
                        Everything.<br>
                        Online.<br>
                    </h4>
                    <a href="/"><img src="/img/register-2.jpg" class="img-fluid d-block mx-auto" width="50%" alt="INEX"></a>
                    <!-- <h5 class="card-title text-center">WHY CREATE AN ACCOUNT?</h4> -->
                    <!-- <ul class="font-weight-bolder text-left font-size-h5 line-height-xl text-uppercase pb-20 pr-5">
                        <li>You can manage your Ad Campaigns online 24/7.</li>
                        <li>You can advertise for a single day if you wish.</li>
                        <li>You can display multiple Ads for the same low cost.</li>
                        <li>Your account is free.</li>
                    </ul> -->
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="card shadow rounded border-0 mt-5">
                    <div class="card-body">
                        <h4 class="card-title text-center">Setup your Advertising Account</h4>  
                        <form class="login-form mt-4" action="/register" method="POST">
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
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Advertising Company <span class="text-danger">*</span></label>
                                        <div class="form-icon position-relative">
                                            
                                            <input type="text" class="form-control" placeholder="Enter business legal name" name="business_name" value="{{old('business_name')?old('business_name'):''}}" required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Street Address <span class="text-danger">*</span></label>
                                        <div class="form-icon position-relative">
                                            
                                            <input type="text" class="form-control" name="address" value="{{old('address')?old('address'):''}}" placeholder="Enter Street address" id="autocomplete" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Contact Name <span class="text-danger">*</span></label>
                                        <div class="form-icon position-relative">
                                            
                                            <input type="text" class="form-control" name="name" value="{{old('name')?old('name'):''}}" placeholder="Enter company owner or manager" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Suite </label>
                                        <div class="form-icon position-relative">
                                            
                                            <input type="text" class="form-control" name="suite" name="suite" value="{{old('suite')?old('suite'):''}}" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Contact Telephone <span class="text-danger">*</span></label>
                                        <div class="form-icon position-relative">
                                            
                                            <input type="text" class="form-control" name="phone" value="{{old('phone')?old('phone'):''}}" placeholder="Enter Owner or manager phone or business number" autocomplete="off" required/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">City <span class="text-danger">*</span></label>
                                        <div class="form-icon position-relative">
                                            
                                            <input type="text" class="form-control" name="city" id="city" value="{{old('city')?old('city'):''}}" autocomplete="off" required/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">State <span class="text-danger">*</span></label>
                                        <div class="form-icon position-relative">
                                            
                                            <input type="text" class="form-control" name="state" id="state" value="{{old('state')?old('state'):''}}" autocomplete="off" required/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Zip code <span class="text-danger">*</span></label>
                                        <div class="form-icon position-relative">
                                            
                                            <input type="text" class="form-control" name="zip" id="zip" value="{{old('zip')?old('zip'):''}}" autocomplete="off" required/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Contact Email <span class="text-danger">*</span></label>
                                        <div class="form-icon position-relative">
                                            
                                            <input type="text" class="form-control" type="email" name="email" value="{{old('email')?old('email'):''}}" placeholder="Enter owner or manager email address" autocomplete="off" required/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">How did you hear about INEX? </label>
                                        <div class="form-icon position-relative">
                                            <select class="form-control hear" name="hear" autocomplete="off" required>
                                                <option value=""></option>
                                                <option value="0">INEX Account Manager</option>
                                                <option value="1">Search Engine(Google, Yahoo, etc)</option>
                                                <option value="2">Recommended by a friend or colleague</option>
                                                <option value="3">Social Media</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3 sel-account" style="display:none">
                                        <label class="form-label">You must select Account Manager <span class="text-danger">*</span></label>
                                        <div class="form-icon position-relative">
                                            <select class="form-control" name="account_manager" >
                                                <option >Select One</option>
                                                @foreach($accounts as $key => $val)
                                                    <option value="{{$val['id']}}">{{$val['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="term" value="" id="flexCheckDefault" required>
                                            <label class="form-check-label" for="flexCheckDefault">I agree to INEX's <a data-toggle="modal" data-target="#term_modal" href="javascript:;" class="text-primary">Terms of Service</a></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="d-grid">
                                        <button class="btn btn-primary">Register</button>
                                    </div>
                                </div>

                                <div class="mx-auto">
                                    <p class="mb-0 mt-3"><small class="text-dark me-2">Already have an account ?</small> <a href="{{route('login')}}" class="text-dark fw-bold">Sign in</a></p>
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
<script>
    var placeSearch, autocomplete;
    var lat = "";
    var lng = "";
    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_2 : 'long_name' ,
        administrative_area_level_1: 'long_name',
        country: 'long_name',
        postal_code: 'long_name'
    };

    function initAutocomplete() {
        autocomplete = new google.maps.places.Autocomplete(
            document.getElementById('autocomplete'), 
            {
                componentRestrictions: {country: ["us"]}
            }
        );
        autocomplete.setFields(['address_component']);
        autocomplete.addListener('place_changed', fillInAddress);
    }

    function fillInAddress() {
        var place = autocomplete.getPlace();
        for (var component in componentForm) {
            // document.getElementById(component).value = '';
            // document.getElementById(component).disabled = false;
        }
        var address = "";
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                if(addressType == "locality"){
                    $("#city").val(val);
                }
                if(addressType == "administrative_area_level_1"){
                    $("#state").val(val)
                }
                if(addressType == "postal_code"){
                    $("#zip").val(val)
                }
            }
        }
        if(address.lastIndexOf("/") == address.length -1){
            address = address.substr(0, address.length -2);
        }
        $("#address").val(address);
    }

    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var circle = new google.maps.Circle(
                    {center: geolocation, radius: position.coords.accuracy}
                );
                autocomplete.setBounds(circle.getBounds());
                lat = position.coords.latitude;
                lng = position.coords.longitude;
            });
        }
    }
</script>
@include('auth.footer')
<script>
    var placeSearch, autocomplete;
    var lat = "";
    var lng = "";
    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_2 : 'long_name' ,
        administrative_area_level_1: 'long_name',
        country: 'long_name',
        postal_code: 'long_name'
    };

    function initAutocomplete() {
        autocomplete = new google.maps.places.Autocomplete(
            document.getElementById('autocomplete'), 
            {
                componentRestrictions: {country: ["us"]}
            }
        );
        autocomplete.setFields(['address_component']);
        autocomplete.addListener('place_changed', fillInAddress);
    }

    function fillInAddress() {
        var place = autocomplete.getPlace();
        for (var component in componentForm) {
            // document.getElementById(component).value = '';
            // document.getElementById(component).disabled = false;
        }
        var address = "";
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                if(addressType == "locality"){
                    $("#city").val(val);
                }
                if(addressType == "administrative_area_level_1"){
                    $("#state").val(val)
                }
                if(addressType == "postal_code"){
                    $("#zip").val(val)
                }
            }
        }
        if(address.lastIndexOf("/") == address.length -1){
            address = address.substr(0, address.length -2);
        }
        $("#address").val(address);
    }

    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var circle = new google.maps.Circle(
                    {center: geolocation, radius: position.coords.accuracy}
                );
                autocomplete.setBounds(circle.getBounds());
                lat = position.coords.latitude;
                lng = position.coords.longitude;
            });
        }
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4pvNQmbADDWIXTrZPthdRduyLQWO17zg&libraries=places&callback=initAutocomplete" async defer></script>
<script>
    $(document).ready(function(){
        $(".phone").inputmask("mask", {
            "mask": "(999) 999-9999"
        });
		$(".hear").on('change', function(){
			$(this).val() == 0 ? $(".sel-account").css('display', 'block') : $(".sel-account").css('display', 'none')
		})
        $(".btn-trust").click();
    })
</script>