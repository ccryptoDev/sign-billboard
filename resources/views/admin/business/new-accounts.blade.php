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
    <?php
    $list_hear = [
        "INEX Account Manager",
        "Search Engine(Google, Yahoo, etc)",
        "Recommended by a friend or colleague",
        "Social Media"
    ];
    ?>
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
                                            <th>Id</th>
                                            <th>Company Name</th>
                                            <th>Primary Contact</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Account Manager</th>
                                            <th>Hear</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($accounts as $key => $val)
                                            <tr>
                                                <td>{{$val->id}}</td>
                                                <td>{{$val->business_name}}</td>
                                                <td>{{$val->user_name}}</td>
                                                <td>{{$val->email}}</td>
                                                <td>{{$val->phone}}</td>
                                                <td>
                                                    <select class="form-control account_manger" data-id="{{$val->id}}">
                                                        <option value="">Select Account Manager</option>
                                                    @foreach($manager as $item)
                                                        <option value="{{$item->id}}" {{$item->id==$val->sales?'selected':''}}>{{$item->user_name}}</optino>
                                                    @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    @if($val->hear == 0)
                                                        @foreach($manager as $item)
                                                            {{$item->id==$val->account_manager?$item->user_name:''}}
                                                        @endforeach
                                                    @else
                                                        {{$list_hear[$val->hear]}}
                                                    @endif
                                                </td>
                                                <td>
                                                    <?php
                                                        $c_date = date_create($val->reg_date);
                                                        $c_date = date_format($c_date, "m-d-Y g:i a");
                                                        echo $c_date;
                                                    ?>
                                                </td>
                                                <td>
                                                    <a href="/edit-business/{{base64_encode($val->id)}}">
                                                        <i class="fa fa-edit text-success mr-5"></i>
                                                    </a>
                                                    <i class="fa fa-trash text-danger" onclick="delete_account('<?php echo $val->id?>')" style="cursor:pointer"></i>
                                                </td>
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
        <script src="/assets/js/newaccount-table.js"></script>
        <script>
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
                                    location.reload()
                                }
                                else{
                                    toastr.error("Fail");
                                }
                            }
                        })
                    }
                });                    
            }
            $(".account_manger").on('change', function(){
                KTApp.blockPage();
                var account_id = $(this).val();
                var user_id = $(this).data('id')
                $.ajax({
                    url : '/assign-account',
                    type : "GET",
                    data : {
                        user_id : user_id,
                        account_id : account_id
                    },
                    success : function(res){
                        KTApp.unblockPage();
                        if(res == 'success'){
                            location.reload()
                        }
                        else{
                            toastr.error(res);
                        }
                    },
                    error : function(err){
                        KTApp.unblockPage();
                        toastr.error("Please refresh your browser");
                    }
                })
            })
        </script>
	</body>
</html>
		