@include('admin.include.admin-header')
<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css" />
<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css" />                    
	<style>
        .jsgrid-header-row{
            height : 60px;
        }
    </style>
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader min-h-lg-15px pt-5 pb-7 subheader-transparent" id="kt_subheader">
        </div>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-custom" data-card="true" id="kt_card_1">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">{{$page_name}}</h3>
                                </div>
                            </div>
                            <form method="post" name="myForm" action="/create-business">
                                <div class="card-body">
                                    <h1 class="text-center">DIGITAL BILLBOARD ADVERTISING AGREEMENT</h1>
                                    @csrf
                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </div>
                                    @endif
                                    @if(Session::has('success'))
                                        <div class="alert alert-success" role="alert">
                                            {{Session::get('success')}}
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label>Advertising Company</label>
                                        <input type="text" class="form-control" name="ad_company" value="{{old('ad_company')}}" required placeholder="Advertising Company"/>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Street Address</label>
                                            <input type="text" class="form-control" name="street" id="autocomplete" value="{{old('street')}}" required placeholder="Street Address"/>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Contact Name</label>
                                            <input type="text" class="form-control" name="name" value="{{old('name')}}" required placeholder="Contact Name"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Suite</label>
                                            <input type="text" class="form-control" name="suite" value="{{old('suite')}}" placeholder="Suite"/>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Contact Telephone</label>
                                            <input type="text" class="form-control" name="phone" value="{{old('phone')}}" required placeholder="Contact Telephone"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>City / State /Zip code</label>
                                            <input type="text" class="form-control" name="city" value="{{old('city')}}" id="address" required placeholder="City / State /Zip code"/>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Contact Email</label>
                                            <input type="text" class="form-control" name="email" value="{{old('email')}}" required placeholder="Contact Email"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Billing Contact</label>
                                            <input type="text" class="form-control" name="bill_name" value="{{old('bill_name')}}" required placeholder="Billing Contact"/>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Billing Contact Email</label>
                                            <input type="email" class="form-control" name="bill_email" value="{{old('bill_email')}}" required placeholder="Billing Contact Email"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Industry Category</label>
                                            <!-- <input type="text" class="form-control"  name="category" value="{{old('category')}}" required placeholder="Industry Category"/> -->
                                            <select class="form-control select2" id="kt_select2_1" name="category">
                                                @foreach($sic as $key => $val)
                                                    <option value="{{$val->id}}">{{$val->sic_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Billing Contact Phone</label>
                                            <input type="text" class="form-control"  name="bill_phone" value="{{old('bill_phone')}}" required placeholder="Billing Contact Phone"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Franchise</label>
                                            <!-- <input type="text" class="form-control"  name="category" value="{{old('category')}}" required placeholder="Industry Category"/> -->
                                            @if(session('level') == 2)
                                            <select class="form-control select2" id="super_drop" name="super">
                                                @foreach($super as $key => $val)
                                                    <option value="{{$val->id}}">{{$val->user_name}}</option>
                                                @endforeach
                                            </select>
                                            @endif
                                            @if(session('level') == 3)
                                            <input type="text" value="{{session('user_name')}}" name="super">
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Account Manager</label>
                                            <select class="form-control select2" id="sales" name="sales"></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-lg btn-danger float-right">Save</button>
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

		<script>var HOST_URL = "https://keenthemes.com/metronic/tools/preview";</script>
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
		<script src="/assets/plugins/global/plugins.bundle.js"></script>
        <script src="/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
        <script src="/js/suggest.js"></script>
		<script src="/assets/js/scripts.bundle.js"></script>
        <script>
            var placeSearch, autocomplete,autocomplete1;
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
                        // types: ['(cities)'],
                        componentRestrictions: {country: ["us"]}
                    }
                );
                autocomplete.setFields(['address_component']);
                autocomplete.addListener('place_changed', fillInAddress);
            }

            function fillInAddress() {
                // Get the place details from the autocomplete object.
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
                        // if(addressType == "street_number"){
                        //     $("#street_number").val(val);
                        // }
                        // if(addressType == "route"){
                        //     $("#route").val(val);
                        // }
                        if(addressType == "locality"){
                            // City
                            address += val + "/";
                            // $("#locality").val(val);
                        }
                        if(addressType == "administrative_area_level_1"){
                            // $("#administrative_area_level_1").val(val);
                            address += val + "/";
                        }
                        if(addressType == "administrative_area_level_2"){
                            // $("#administrative_area_level_2").val(val);
                        }
                        if(addressType == "postal_code"){
                            address += val + "/";
                            // $("#postal_code").val(val);
                        }
                        if(addressType == "country"){
                            // $("#country").val(val);
                        }
                        // $("#dis_city").text(val);
                        // $("#state").val(val);
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
            $('#kt_select2_1').select2({
                placeholder: "Select a category"
            });
            $('#sales').select2({
                placeholder: "Select a Account Manager"
            });
            <?php
            if(session('level') != 2){
            ?>
            get_sales("<?php echo session('user_id')?>");
            <?php
            }
            if(session('level') == 2){
            ?>
            $("#super_drop").select2({
                placeholder: "Select a Franchise"
            });
            get_sales($("#super_drop").val());
            $("#super_drop").on('change', function(){
                get_sales($(this).val());
            })
            <?php }?>
            function get_sales(id){
                $.ajax({
                    url : "/get_sales",
                    type : "POST",
                    data : {
                        id : id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success : function(res){
                        $("#sales")[0].innerHTML = "";
                        var html = "";
                        for(var i = 0; i < res.length; i++){
                            html += "<option value='"+res[i]['id']+"'>"+res[i]['user_name']+"</option>";
                        }
                        $("#sales").append(html);
                    }
                })
            }
        </script>
	</body>
</html>
		