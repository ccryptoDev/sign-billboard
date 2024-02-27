@include('admin.include.admin-header')
<link href="/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>                    
	<style>
		@media(max-width:768px){
			#f_comp{
				margin-top:0px !important;
			}
		}
        .action i{
            cursor : pointer;
        }
	</style>
    <?php
    $name = "";
    if(session('level') == 2){
        $name = "Admin";
    }
    if(session('level') == 3){
        $name = "Franchise";
    }
    if(session('level') == 4){
        $name = "Account Manager";
    }
    ?>
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <?php
        $col_num = "col-md-4";
        if(session('level') == 2){
            $col_num = "col-md-3";
        }
        ?>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    @if(session('level') == 2)
                    <div class="{{$col_num}}">
                        <a href="/new-accounts" class="card card-custom bg-danger bg-hover-state-danger card-stretch gutter-b">
                            <div class="card-body">
                                <span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"/>
                                            <path d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                            <path d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                        </g>
                                    </svg>
                                </span>
                                <div class="text-inverse-danger font-weight-bolder font-size-h5 mb-2 mt-5">New Account</div>
                            </div>
                        </a>
                    </div>
                    <!-- <div class="{{$col_num}}">
                        <a href="{{route('manage-payment-method')}}" class="card card-custom bg-danger bg-hover-state-danger card-stretch gutter-b">
                            <div class="card-body">
                                <span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"/>
                                            <path d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                            <path d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                        </g>
                                    </svg>
                                </span>
                                <div class="text-inverse-danger font-weight-bolder font-size-h5 mb-2 mt-5">Client Pay Option</div>
                            </div>
                        </a>
                    </div> -->
                    @endif
                    <div class="{{$col_num}}">
                        <a href="/manage-business" class="card card-custom bg-success bg-hover-state-success card-stretch gutter-b">
                            <div class="card-body">
                                <span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <path d="M18,2 L20,2 C21.6568542,2 23,3.34314575 23,5 L23,19 C23,20.6568542 21.6568542,22 20,22 L18,22 L18,2 Z" fill="#000000" opacity="0.3"/>
                                            <path d="M5,2 L17,2 C18.6568542,2 20,3.34314575 20,5 L20,19 C20,20.6568542 18.6568542,22 17,22 L5,22 C4.44771525,22 4,21.5522847 4,21 L4,3 C4,2.44771525 4.44771525,2 5,2 Z M12,11 C13.1045695,11 14,10.1045695 14,9 C14,7.8954305 13.1045695,7 12,7 C10.8954305,7 10,7.8954305 10,9 C10,10.1045695 10.8954305,11 12,11 Z M7.00036205,16.4995035 C6.98863236,16.6619875 7.26484009,17 7.4041679,17 C11.463736,17 14.5228466,17 16.5815,17 C16.9988413,17 17.0053266,16.6221713 16.9988413,16.5 C16.8360465,13.4332455 14.6506758,12 11.9907452,12 C9.36772908,12 7.21569918,13.5165724 7.00036205,16.4995035 Z" fill="#000000"/>
                                        </g>
                                    </svg>
                                </span>
                                <div class="text-inverse-danger font-weight-bolder font-size-h5 mb-2 mt-5">Manage Business Accounts</div>
                            </div>
                        </a>
                    </div>
                    <div class="{{$col_num}}">
                        <a href="/manage-coupon" class="card card-custom bg-info bg-hover-state-info card-stretch gutter-b">
                            <div class="card-body">
                                <span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"></rect>
                                            <path d="M12,4.56204994 L7.76822128,9.6401844 C7.4146572,10.0644613 6.7840925,10.1217854 6.3598156,9.76822128 C5.9355387,9.4146572 5.87821464,8.7840925 6.23177872,8.3598156 L11.2317787,2.3598156 C11.6315738,1.88006147 12.3684262,1.88006147 12.7682213,2.3598156 L17.7682213,8.3598156 C18.1217854,8.7840925 18.0644613,9.4146572 17.6401844,9.76822128 C17.2159075,10.1217854 16.5853428,10.0644613 16.2317787,9.6401844 L12,4.56204994 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                            <path d="M3.5,9 L20.5,9 C21.0522847,9 21.5,9.44771525 21.5,10 C21.5,10.132026 21.4738562,10.2627452 21.4230769,10.3846154 L17.7692308,19.1538462 C17.3034221,20.271787 16.2111026,21 15,21 L9,21 C7.78889745,21 6.6965779,20.271787 6.23076923,19.1538462 L2.57692308,10.3846154 C2.36450587,9.87481408 2.60558331,9.28934029 3.11538462,9.07692308 C3.23725479,9.02614384 3.36797398,9 3.5,9 Z M12,17 C13.1045695,17 14,16.1045695 14,15 C14,13.8954305 13.1045695,13 12,13 C10.8954305,13 10,13.8954305 10,15 C10,16.1045695 10.8954305,17 12,17 Z" fill="#000000"></path>
                                        </g>
                                    </svg>
                                </span>
                                <div class="text-inverse-danger font-weight-bolder font-size-h5 mb-2 mt-5">Coupon Manager</div>
                            </div>
                        </a>
                    </div>
                    <div class="{{$col_num}}">
                        <a href="/weekly-inventory" class="card card-custom bg-primary bg-hover-state-primary card-stretch gutter-b">
                            <div class="card-body">
                                <span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <rect fill="#000000" opacity="0.3" x="12" y="4" width="3" height="13" rx="1.5"/>
                                            <rect fill="#000000" opacity="0.3" x="7" y="9" width="3" height="8" rx="1.5"/>
                                            <path d="M5,19 L20,19 C20.5522847,19 21,19.4477153 21,20 C21,20.5522847 20.5522847,21 20,21 L4,21 C3.44771525,21 3,20.5522847 3,20 L3,4 C3,3.44771525 3.44771525,3 4,3 C4.55228475,3 5,3.44771525 5,4 L5,19 Z" fill="#000000" fill-rule="nonzero"/>
                                            <rect fill="#000000" opacity="0.3" x="17" y="11" width="3" height="6" rx="1.5"/>
                                        </g>
                                    </svg>
                                </span>
                                <div class="text-inverse-danger font-weight-bolder font-size-h5 mb-2 mt-5">Today's Inventory</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-header h-auto">
                                <div class="card-title py-5">
                                    <h3 class="card-label">
                                        <span class="d-block text-dark font-weight-bolder">INEX Updates</span>
                                        <span class="d-block text-muted mt-2 font-size-sm"></span>
                                    </h3>
                                </div>
                                <div class="card-toolbar">
                                    <a href="{{route('manage-training')}}" class="btn btn-success mr-3">Advertising Tools</a>
                                    @if(session("level") == 2)
                                        <a href="{{route('manage-pa')}}" class="btn btn-primary mr-3">Manage Page Announcements</a>
                                        <button class='btn btn-danger' data-toggle="modal" data-target="#updatesModal">New Updates</button>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
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
                                <table class="table table-bordered table-hover table-checkable" id="kt_datatable" style="margin-top: 13px !important">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Content</th>
                                            <th>Read</th>
                                            @if(session('level') == 2)
                                            <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($suggestions as $key => $val)
                                            <tr>
                                                <td>
                                                    <?php
                                                        $created = date_create($val->created_at);
                                                        echo date_format($created, "m-d-Y H:i");
                                                    ?>
                                                </td>
                                                <td>
                                                    <p class="content-text">{{$val->content}}</p>
                                                </td>
                                                <td>
                                                    <input type="checkbox" class="suggest_status" name="status" 
                                                        {{$val->fixed==0?'':'checked'}}
                                                        data-id={{$val->id}}
                                                    />
                                                </td>
                                                @if(session('level') == 2)
                                                    <td class="action" style="min-width:150px">
                                                        <i class="fa fa-edit text-success mr-2" 
                                                            data-id="{{$val->id}}"
                                                            data-content="{{$val->content}}"
                                                        ></i>
                                                        <a href="/view-history/{{$val->id}}" target="_blank">
                                                            <i class="fa fa-eye text-info mr-2" 
                                                                data-id="{{$val->id}}"
                                                                data-content="{{$val->content}}"
                                                            ></i>
                                                        </a>
                                                        <a href="/send-update/{{$val->id}}">
                                                            <i class="fas fa-envelope text-warning mr-2"></i>
                                                        </a>
                                                        <i class="fa fa-trash text-danger" data-id="{{$val->id}}"></i>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>   
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
    @if(session('level') == 2)
    <div class="modal fade" id="updatesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Updates</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form id="frmSuggest">
                    <div class="modal-body">
                        <div class="form-group">
                            <textarea class="form-control" id="kt_autosize_1" name="content" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <button class='btn btn-danger btn-u' data-toggle="modal" data-target="#updatesUModal" style="display:none">New Updates</button>
    <div class="modal fade" id="updatesUModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form id="frmUpdateSuggest">
                    <div class="modal-body">
                        <div class="form-group">
                            <input class="form-control" type="hidden" id="u_id" name="id"></input>
                            <textarea class="form-control" id="kt_autosize_2" name="content" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
        @include("admin.include.admin-footer")

		<script>var HOST_URL = "https://keenthemes.com/metronic/tools/preview";</script>
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
		<script src="/assets/plugins/global/plugins.bundle.js"></script>
		<script src="/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
		<script src="/js/suggest.js"></script>
		<script src="/assets/js/scripts.bundle.js"></script>
        <script src="/assets/js/pages/widgets.js"></script>
        <script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>
        <script src="/js/dashboard.js"></script>
        <script>
        "use strict";
        var KTAutosize = function () {

        // Private functions
        var demos = function () {
            // basic demo
            var demo1 = $('#kt_autosize_1');
            var demo2 = $('#kt_autosize_2');

            autosize(demo1);

            autosize(demo2);
            autosize.update(demo2);
        }

        return {
            <?php
            if(session('level') == 2){
            ?>
                init: function() {
                    demos();
                }
            <?php }?>
        };
        }();

        jQuery(document).ready(function() {
        KTAutosize.init();
        });

        jQuery(document).ready(function() {
            <?php
            if(session('level') == 2){
            ?>
            $(".fa-trash").click(function(){
                var id = $(this).data('id');
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won\"t be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!"
                }).then(function(result) {
                    if (result.value) {
                        $.ajax({
                            type : "POST",
                            url : '/delete_suggestion',
                            data : {
                                id : id
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success : function (res){
                                location.reload();
                            },
                            error : function(res){
                                location.reload();
                            }
                        })
                    }
                });
            })
            $(".fa-edit").click(function(){
                $(".btn-u").click();
                var id = $(this).data('id');
                $("#u_id").val(id);
                var content = $(this).data('content');
                $("#kt_autosize_2").val(content);
            })
            <?php }?>
            $(".suggest_status").on('change', function(){
                var id = $(this).data('id');
                var fixed = $(this).prop('checked')==true?1:0;
                $.ajax({
                    type : "UPDATE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type : "POST",
                    url : '/update_fixed',
                    data : {
                        id : id,
                        fixed : fixed
                    },
                    success : function(res){
                        toastr.success('success');
                    }
                });
            })
        });
        </script>
	</body>
</html>
		