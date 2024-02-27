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
                            <form method="post" name="myForm" id="createForm">
                            <!-- <form method="post" name="myForm" action="/create-business"> -->
                                <div class="card-body">
                                    @csrf
                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            <!-- <ul> -->
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            <!-- </ul> -->
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
                                            <input type="text" class="form-control phone" name="phone" value="{{old('phone')}}" required placeholder="Contact Telephone"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label>City</label>
                                            <input type="text" class="form-control" name="city" value="{{old('city')}}" id="city" required placeholder="City"/>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label>State</label>
                                            <input type="text" class="form-control" name="state" value="{{old('state')}}" id="state" required placeholder="State"/>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label>Zip code</label>
                                            <input type="text" class="form-control" name="zip" value="{{old('zip')}}" id="zip" required placeholder="Zip code"/>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Contact Email</label>
                                            <input type="text" class="form-control" name="email" value="{{old('email')}}" required placeholder="Contact Email"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Billing Contact</label>
                                            <input type="text" class="form-control" name="bill_name" value="{{old('bill_name')}}" placeholder="Billing Contact"/>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Billing Contact Email</label>
                                            <input type="email" class="form-control" name="bill_email" value="{{old('bill_email')}}" placeholder="Billing Contact Email"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Industry Category</label>
                                            <select class="form-control select2" id="kt_select2_1" name="category" autocomplete="off">
                                                @foreach($sic as $key => $val)
                                                    <option value="{{$val->id}}">{{$val->sic_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Billing Contact Phone</label>
                                            <input type="text" class="form-control phone"  name="bill_phone" value="{{old('bill_phone')}}" placeholder="Billing Contact Phone"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Franchise</label>
                                            @if(session('level') == 2)
                                            <select class="form-control select2" id="super_drop" name="super" autocomplete="off">
                                                @foreach($super as $key => $val)
                                                    <option value="{{$val->id}}">{{$val->user_name}}</option>
                                                @endforeach
                                            </select>
                                            @endif
                                            @if(session('level') == 3)
                                            <select class="form-control selectpicker" name="super">
                                                <option value="{{session('user_id')}}">{{session('user_name')}}</option>
                                            </select>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Account Manager</label>
                                            <select class="form-control select2" id="sales" name="sales" autocomplete="off"></select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Graphic Designer</label>
                                            <select class="form-control select2" id="graphic" name="graphic" autocomplete="off"></select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Contract Date</label>
                                            <input class="form-control" id="init_date" name="init_date" value="{{old('init_date')?old('init_date'):date('m-d-Y')}}" required></input>
                                        </div>
                                        <!-- <div class="form-group col-md-6">
                                            <label>Schedule Type</label>
                                            <select class="form-control" id="schedule_type" name="day_plan">
                                                <option value="0">7 Days</option>
                                                <option value="1">2 Days</option>
                                            </select>
                                        </div> -->
                                    </div>
                                    @if(session('level') == 2)
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Franchised Locations</label>
                                            <label>If this client owns their own sign, designate the signs that belong to them below.</label>
                                            <div class="checkbox-list free_location">
                                            @foreach($locations as $key => $val)
                                                <label class="checkbox">
                                                    <input type="checkbox" name="free_location[]" value="{{$val->id}}"/>
                                                    <span></span>
                                                    {{$val->name}}
                                                </label>
                                            @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @endif
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
    <script src="/assets/js/pages/crud/forms/widgets/select2.js"></script>
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
            var street_address = "";
            for (var i = 0; i < place.address_components.length; i++) {
                var addressType = place.address_components[i].types[0];
                if (componentForm[addressType]) {
                    var val = place.address_components[i][componentForm[addressType]];
                    if(addressType == "street_number"){
                        street_address += " " + val;
                    }
                    if(addressType == "route"){
                        street_address += " " + val;
                    }
                    if(addressType == "locality"){
                        $("#city").val(val);
                    }
                    if(addressType == "administrative_area_level_1"){
                        $("#state").val(val)
                    }
                    if(addressType == "administrative_area_level_2"){
                    }
                    if(addressType == "postal_code"){
                        $("#zip").val(val)
                    }
                    if(addressType == "country"){
                    }
                }
            }
            $("#autocomplete").val(street_address)
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
        $("#createForm").submit(function(event){
            KTApp.blockPage();
            event.preventDefault();
            var fs = new FormData(document.getElementById('createForm'));
            $.ajax({
                url : '/create-business',
                type : "POST",
                data : fs,
                processData : false, 
                contentType : false,
                success : function(res){
                    KTApp.unblockPage();
                    if(res == 'success'){
                        window.location.href="/manage-business";
                    }
                    else{
                        toastr.error(res);
                    }
                },
                error : function(err){
                    KTApp.unblockPage();
                    toastr.error("Fail. Please refresh your browser.");
                }
            })
        })
        $(".phone").inputmask("mask", {
            "mask": "(999) 999-9999"
        });
        $("#init_date").inputmask("99/99/9999", {
            "placeholder": "mm/dd/yyyy",
            autoUnmask: true
        });
        $('#kt_select2_1').select2({
            placeholder: "Select a category"
        });
        $('#sales').select2({
            placeholder: "Select a Account Manager"
        });
        $('#graphic').select2({
            placeholder: "Select a Graphic Designer"
        });
        <?php
        if(session('level') != 2){
        ?>
        get_sales("<?php echo session('user_id')?>");
        get_graphic("<?php echo session('user_id')?>");
        <?php
        }
        if(session('level') == 2){
        ?>
            $("#super_drop").select2({
                placeholder: "Select a Franchise"
            });
            get_sales($("#super_drop").val());
            get_graphic($("#super_drop").val());
            $("#super_drop").on('change', function(){
                get_sales($(this).val());
                get_graphic($(this).val());
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
                    // html += "<option></option>";
                    for(var i = 0; i < res.length; i++){
                        html += "<option value='"+res[i]['id']+"'>"+res[i]['user_name']+"</option>";
                    }
                    $("#sales").append(html);
                }
            })
        }
        function get_graphic(id){
            $.ajax({
                url : "/get_graphic",
                type : "POST",
                data : {
                    id : id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success : function(res){
                    $("#graphic")[0].innerHTML = "";
                    var html = "";
                    html += "<option></option>";
                    for(var i = 0; i < res.length; i++){
                        html += "<option value='"+res[i]['id']+"'>"+res[i]['user_name']+"</option>";
                    }
                    $("#graphic").append(html);
                }
            })
        }
    </script>
	</body>
</html>
		