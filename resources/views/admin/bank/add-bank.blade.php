@include('admin.include.admin-header')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader min-h-lg-15px pt-5 pb-7 subheader-transparent" id="kt_subheader">
    </div>
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom" data-card="true" id="kt_card_1">
                        <div class="card-header ribbon ribbon-top ribbon-ver">
                            <div class="card-title">
                                <h3 class="card-label">{{$page_name}}</h3>
                            </div>
                            <?php
                                $status = 'danger';
                                $label = 'Not Verified';
                                if(isset($account->id)){
                                    if($account->payouts_enabled == true){
                                        $status = 'success';
                                        $label = 'Verified';
                                    }
                                    else{
                                        $status = 'warning';
                                        $label = 'Under Review';
                                    }
                                }
                                $front_require = 'required';
                                $back_require = 'required';
                                if(isset($account->front) && $account->front != null){
                                    $front_require = '';
                                }
                                if(isset($account->back) && $account->back != null){
                                    $back_require = '';
                                }
                            ?>
                            <div class="card-toolbar">
                                <div class="d-flex align-items-center">
                                    <span class="bullet bullet-bar bg-{{$status}} align-self-stretch mr-2"></span>
                                    <div class="d-flex flex-column flex-grow-1">
                                        <a class="text-dark-75 text-hover-primary font-weight-bold font-size-lg">
                                            {{$label}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form id="frmCreate">
                            <div class="card-body">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-1"></div>
                                    <div class="col-xl-9 my-2">
                                        @if (Session::has('success'))
                                            <div class="alert alert-success">
                                                <span>Success</span>
                                            </div>
                                        @endif
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </div>
                                        @endif
                                        <div class="form-group">
                                            <label>Business Type</label>
                                            <select class="form-control" name="business_type">
                                                <option value="individual" {{isset($bank->business_type)&&$bank->business_type=='individual'?'selected':''}}>Individual</option>
                                                <option value="company" {{isset($bank->business_type)&&$bank->business_type=='company'?'selected':''}}>Company</option>
                                            </select>
                                        </div>
                                        <div class="form-group com_type" style="display:{{isset($bank->business_type)&&$bank->business_type=='company'?'':'none'}}">
                                            <label>Company Type</label>
                                            <select class="form-control" name="company_type">
                                                <option value="multi_member_llc" {{isset($bank->company_type)&&$bank->company_type=='multi_member_llc'?'selected':''}}>Multi Member LLC</option>
                                                <option value="private_corporation" {{isset($bank->company_type)&&$bank->company_type=='private_corporation'?'selected':''}}>Private Corporation</option>
                                                <option value="private_partnership" {{isset($bank->company_type)&&$bank->company_type=='private_partnership'?'selected':''}}>Private Partnership</option>
                                                <option value="public_corporation" {{isset($bank->company_type)&&$bank->company_type=='public_corporation'?'selected':''}}>Public Corporation</option>
                                                <option value="public_partnership" {{isset($bank->company_type)&&$bank->company_type=='public_partnership'?'selected':''}}>Public Partnership</option>
                                                <option value="single_member_llc" {{isset($bank->company_type)&&$bank->company_type=='single_member_llc'?'selected':''}}>Single Member LLC</option>
                                                <option value="sole_proprietorship" {{isset($bank->company_type)&&$bank->company_type=='sole_proprietorship'?'selected':''}}>Sole Proprietorship</option>
                                                <option value="unincorporated_association" {{isset($bank->company_type)&&$bank->company_type=='unincorporated_association'?'selected':''}}>Unincorporated Association</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Company Name</label>
                                            <input class="form-control" name="company_name" value="{{isset($bank->company_name)?$bank->company_name:''}}" placeholder="Company Legal Name" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input class="form-control" name="address" value="{{isset($bank->address)?$bank->address:''}}" placeholder="Company Address Name" id="autocomplete" required>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>City</label>
                                                    <input class="form-control" name="city" value="{{isset($bank->city)?$bank->city:''}}" placeholder="City" id="city" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>State</label>
                                                    <input class="form-control" name="state" value="{{isset($bank->state)?$bank->state:''}}" placeholder="State" id="state" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Zip Code</label>
                                                    <input class="form-control" name="zip" value="{{isset($bank->zip)?$bank->zip:''}}" placeholder="Zip Code" id="zip" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Birth</label>
                                                    <input class="form-control" type="date" name="birth" max="{{date('Y-m-d')}}" value="{{isset($bank->birth)?$bank->birth:date('Y-m-d')}}" required/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Company Phone</label>
                                                    <input class="form-control phone" name="phone" value="{{isset($bank->phone)?$bank->phone:''}}" placeholder="" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tax ID(EIN)</label>
                                                    <input class="form-control" name="ein" value="{{isset($bank->company_name)?$bank->company_name:''}}" placeholder="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>SSN(Last 4 Digits)</label>
                                                    <input class="form-control ssn" name="ssn" value="{{isset($bank->ssn)?$bank->ssn:''}}" placeholder="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Bank Account Number</label>
                                                    <input class="form-control" name="account_number" value="{{isset($bank->account_number)?$bank->account_number:''}}" placeholder="" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Bank Routing Number</label>
                                                    <input class="form-control" name="route_number" value="{{isset($bank->route_number)?$bank->route_number:''}}" placeholder="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Upload Driver License (Front)</label>
                                                    <div></div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="frontDocument" id="frontFile" {{$front_require}}/>
                                                        <label class="custom-file-label" for="frontFile">Choose file</label>
                                                        <span> Must be a color image (JPG, PNG, or PDF).</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Upload Driver License (Back)</label>
                                                    <div></div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="backDocument" id="backFile" {{$back_require}}/>
                                                        <label class="custom-file-label" for="backFile">Choose file</label>
                                                        <span> Must be a color image (JPG, PNG, or PDF).</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <h3>Company Owner</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>First Name</label>
                                                    <input class="form-control" name="first_name" value="{{isset($bank->first_name)?$bank->first_name:''}}" placeholder="" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Last Name</label>
                                                    <input class="form-control" name="last_name" value="{{isset($bank->last_name)?$bank->last_name:''}}" placeholder="" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input class="form-control" name="email" value="{{isset($bank->email)?$bank->email:''}}" placeholder="" type="email" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-xl-1"></div>
                                    <div class="col-xl-9">
                                        <button class="btn btn-danger float-right ml-3" type="submit">Save</button>
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
@include("admin.include.admin-footer")
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
<script>var HOST_URL = "https://keenthemes.com/metronic/tools/preview";</script>
<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
<script src="/assets/plugins/global/plugins.bundle.js"></script>
<script src="/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
<script src="/js/suggest.js"></script>
<script src="/js/inputmask.js"></script>
<script src="/assets/js/scripts.bundle.js"></script>
<script src="/assets/js/campaign.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4pvNQmbADDWIXTrZPthdRduyLQWO17zg&libraries=places&callback=initAutocomplete" async defer></script>
<script>
    
    $(".phone").inputmask("mask", {
        "mask": "(999) 999-9999"
    });
    $(".ssn").inputmask("mask", {
        "mask": "9999"
    });
    $('select[name="business_type"]').on('change', function(){
        change_type();
    });
    function change_type(){
        var type = $("select[name='business_type']").val();
        if(type == 'individual'){
            $(".com_type").css('display', 'none')
        }
        else{
            $(".com_type").css('display', 'block')
        }
    }
    $(document).ready(function(){
        $("#frmCreate").submit(function(event){
            event.preventDefault();
            var fs = new FormData(document.getElementById("frmCreate"));
            KTApp.blockPage();
            $.ajax({
                url : "/save-bank",
                type : "POST",
                data : fs,
                processData : false,
                contentType : false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res){
                    KTApp.unblockPage();
                    if(res == 'success'){
                        toastr.success("Success");
                        location.reload();
                    }
                    else{
                        Swal.fire(res, "", "error");
                        // toastr.error(res)
                    }
                },
                error : function(err){
                    KTApp.unblockPage();
                    toastr.error("Please refresh your browser");
                }
            })
        })
    })
</script>
