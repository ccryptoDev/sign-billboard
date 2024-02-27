<style>
    #trustModal .modal-content{
        border : 10px solid white;
    }
    .one-line{
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
    }
    @media (min-width: 992px){
        /* .login.login-3 .login-aside{
            max-width : 500px !important;
        } */
        .login.login-3 .login-content .login-form.login-form-signup{
            max-width : 950px !important;
        }
    }
    .form-group{
        margin-bottom : 1rem !important;
    }
</style>
@include('auth.header')
    <div class="d-flex flex-row-fluid flex-center">
        <div class="login-form login-form-signup">
            <form class="form" id="kt_login_singin_form" action="/register" method="POST">
                <div class="pb-5 pb-lg-15">
                    <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Setup your Advertising Account</h3>
                    <div class="text-muted font-weight-bold font-size-h4">
                        Already have an Account ?
                        <a href="{{route('login')}}" class="text-primary font-weight-bolder">Sign in</a>
                    </div>
                </div>
                @csrf
                @if(session('success'))
                    <div class="alert alert-success">
                        <span>Please verify your phone/email address</span>
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
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark">Advertising Company</label>
                            <input class="form-control h-auto py-4 px-4 rounded-lg border-0" type="text" name="business_name" value="{{old('business_name')?old('business_name'):''}}" placeholder="Enter business legal name" autocomplete="off" required/>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark">Street Address</label>
                            <input class="form-control h-auto py-4 px-4 rounded-lg border-0" type="text" name="address" value="{{old('address')?old('address'):''}}" placeholder="Enter Street address" id="autocomplete" autocomplete="off" required/>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark">Contact Name</label>
                            <input class="form-control h-auto py-4 px-4 rounded-lg border-0" type="text" name="name" value="{{old('name')?old('name'):''}}" placeholder="Enter company owner or manager" autocomplete="off" required/>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark">Suite</label>
                            <input class="form-control h-auto py-4 px-4 rounded-lg border-0" type="text" name="suite" value="{{old('suite')?old('suite'):''}}" autocomplete="off"/>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark">Contact Telephone</label>
                            <input class="form-control h-auto py-4 px-4 rounded-lg border-0 phone" type="text" name="phone" value="{{old('phone')?old('phone'):''}}" placeholder="Enter Owner or manager phone or business number" autocomplete="off" required/>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark">City</label>
                            <input class="form-control h-auto py-4 px-4 rounded-lg border-0" type="text" name="city" id="city" value="{{old('city')?old('city'):''}}" autocomplete="off" required/>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark">State</label>
                            <input class="form-control h-auto py-4 px-4 rounded-lg border-0" type="text" name="state" id="state" value="{{old('state')?old('state'):''}}" autocomplete="off" required/>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark one-line">Zip code</label>
                            <input class="form-control h-auto py-4 px-4 rounded-lg border-0" type="text" name="zip" id="zip" value="{{old('zip')?old('zip'):''}}" autocomplete="off" required/>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark">Contact Email</label>
                            <input class="form-control h-auto py-4 px-4 rounded-lg border-0" type="email" name="email" value="{{old('email')?old('email'):''}}" placeholder="Enter owner or manager email address" autocomplete="off" required/>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark">How did you hear about INEX?</label>
                            <select class="form-control h-auto py-4 px-4 rounded-lg border-0 hear" name="hear" autocomplete="off" required>
                                <option value=""></option>
                                <option value="0">INEX Account Manager</option>
                                <option value="1">Search Engine(Google, Yahoo, etc)</option>
                                <option value="2">Recommended by a friend or colleague</option>
                                <option value="3">Social Media</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group sel-account" style="display:none">
                            <label class="font-size-h6 font-weight-bolder text-dark">You must select Account Manager</label>
                            <select class="form-control h-auto py-4 px-4 rounded-lg border-0" name="account_manager" >
                                <option >Select One</option>
                                @foreach($accounts as $key => $val)
                                    <option value="{{$val['id']}}">{{$val['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary">
                                <input type="checkbox" name="term"  value="{{old('checkbox')?'checked':''}}" required/>
                                <span></span>
                                I agree to INEX's <a data-toggle="modal" data-target="#term_modal" href="javascript:;">Terms of Service</a>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="pb-lg-0 pb-5">
                    <button type="submit" id="kt_login_singin_form_submit_button" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Sign Up</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('auth.term-modal')
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