@include('admin.include.admin-header')
<link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>               
	<style>
        .jsgrid-header-row{
            height : 60px;
        }
        .pac-container{
            z-index : 1051;
        }
    </style>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader min-h-lg-15px pt-5 pb-7 subheader-transparent" id="kt_subheader">
        </div>
        <div class="d-flex flex-column-fluid">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-custom" data-card="true" id="kt_card_1">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">{{$page_name}}</h3>
                                </div>
                                <div class="card-toolbar">
                                    @if(session('level') == 2 || session('level') == 3)
                                    <a class="btn btn-success mr-5" href="{{route('create-business')}}">Create Business Account</a>
                                    @endif
                                    <div class="form-group mt-3 mb-auto">
                                        <select class="form-control selectpicker" id="update_status">
                                            <option value="">All</option>
                                            <option value="0" selected>Activated</option>
                                            <option value="1">Locked out</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </div>
                                @endif
                                <table class="table table-bordered table-hover table-checkable" id="kt_datatable" style="margin-top: 13px !important">
                                    <thead>
                                        <tr>
                                            <th>Company Name</th>
                                            <th>Primary Contact</th>
                                            <th>Account #</th>
                                            <th>Account Manager</th>
                                            <th>Campaign History</th>
                                            <th>Campaign Status</th>
                                            <th>Access Status</th>
                                            <th>Created At</th>
                                            @if(session('level') == 2 || session('level') == 3)
                                            <th>Actions</th>
                                            @endif
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-primary" id="btn_location" data-toggle="modal" data-target="#modalLocation" style="display:none">
        Launch demo modal
    </button>
    <div class="modal fade" id="modalLocation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Location</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form id="frmLocation">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Location</label>
                            <input type="hidden" name="id" id="up_id" class="form-control" required>
                            <input type="text" name="address" id="address" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" name="city" id="city" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>State</label>
                            <input type="text" name="state" id="state" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Zip</label>
                            <input type="text" name="zip" id="zip" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold c_modal" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
                    </div>
                </form>
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
        <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js"></script> -->
        <script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>
        @if(session('level') == 2 || session('level') == 3)
        <script src="/assets/js/business-table.js"></script>
        @else
        <script src="/assets/js/business-table-account.js"></script>
        @endif
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
                    document.getElementById('address'), 
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
                $("#sub_address").val(address);
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
            var search_name = "";
            function update_status(id,status){
                KTApp.blockPage();
                $.ajax({
                    url : 'update_status',
                    type : "POST",
                    data : {
                        id : id,
                        status : status,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success : function (res){
                        KTApp.unblockPage();
                        if(res == "success"){
                            $('#kt_datatable').DataTable().ajax.reload();
                            toastr.success("Success");
                        }
                        else{
                            toastr.error("Fail");
                        }
                    },
                    error : function(){
                        KTApp.unblockPage();
                        toastr.error("Fail");
                    }
                })
            }
            function update_location(id, address, city, state, zip){
                $("#up_id").val(id);
                $("#address").val(address);
                $("#city").val(city);
                $("#state").val(state);
                $("#zip").val(zip);
                $("#btn_location").click();
            }
            function delete_account(id){
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!"
                }).then(function(result) {
                    if (result.value) {
                        $.ajax({
                            url : 'delete_business',
                            type : "POST",
                            data : {
                                id : id
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success : function (res){
                                if(res == "success"){
                                    $('#kt_datatable').DataTable().ajax.reload();
                                    toastr.success("Success");
                                    // $("#basicScenario").jsGrid("loadData");
                                }
                                else{
                                    toastr.error("Fail");
                                }
                            }
                        })
                    }
                });
                
            }
            $("#frmLocation").submit(function(event){
                event.preventDefault();
                var fs = new FormData(document.getElementById('frmLocation'));
                $.ajax({
                    url : "/update_location_business",
                    type : "POST",
                    data : fs,
                    processData : false,
                    contentType : false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success : function (res){
                        if(res == "success"){
                            $('#kt_datatable').DataTable().ajax.reload();
                            toastr.success("Success");
                            $(".c_modal").click();
                            // $("#basicScenario").jsGrid("loadData");
                        }
                        else{
                            toastr.error(res);
                        }
                    }
                })
            })
        </script>
	</body>
</html>
		