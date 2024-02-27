@include('admin.include.admin-header')
<link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
<style>
    .action i{
        cursor : pointer
    }
    .select2-container{
        width: 100% !important;
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
                                    <a class="btn btn-success mr-5" data-toggle="modal" data-target="#newModal">Add Partner</a>
                                    <a class="btn btn-danger mr-5" href="/resource-types">Manage Type</a>
                                    <a class="btn btn-success mr-5 btn-update" data-toggle="modal" data-target="#updateModal" style="display:none">New</a>
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
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Website</th>
                                            <th>Phone</th>
                                            <th>Company Name</th>
                                            <th>Profile</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($resources as $key => $val)
                                            <tr>
                                                <td>{{$val->name}}</td>
                                                <td>{{$val->email}}</td>
                                                <td>{{$val->email_1}}</td>
                                                <td>{{$val->phone_number}}</td>
                                                <td>{{$val->com_name}}</td>
                                                <td>
                                                    <div class="symbol mr-3">
                                                        @if($val->file != '')
                                                            <img src="/upload/{{$val->file}}" style="">
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php
                                                        $created = date_create($val->created_at);
                                                        echo date_format($created, "m-d-Y H:i");
                                                    ?>
                                                </td>
                                                <td class="action">
                                                    <i class="fa fa-edit text-success mr-5"
                                                        onclick="update_doc('{{$val->id}}', '{{$val->name}}', 
                                                        '{{$val->phone_number}}', '{{$val->com_name}}',
                                                        '{{$val->email}}', '{{$val->email_1}}',
                                                        '{{$val->cate_id}}')"
                                                    ></i>
                                                    <a onclick="delete_doc('{{$val->id}}')"><i class="fa fa-trash text-danger mr-5"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    <tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(session('level') == 2)
        <div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Partner</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <form id="frmNew">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>User Name<span class="text-danger">*</span></label>
                                <input class="form-control" name="name" required>
                            </div>
                            <div class="form-group">
                                <label>Phone Number<span class="text-danger">*</span></label>
                                <input class="form-control phone" name="phone_number" required>
                            </div>
                            <div class="form-group">
                                <label>Company Name</label>
                                <input class="form-control" name="com_name">
                            </div>
                            <div class="form-group">
                                <label>Email<span class="text-danger">*</span></label>
                                <input class="form-control" name="email" required>
                            </div>
                            <div class="form-group">
                                <label>Website</label>
                                <input class="form-control" name="email_1" type="url">
                            </div>
                            <div class="form-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="file" id="customFile"/>
                                    <label class="custom-file-label" for="customFile">Avatar</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Resource Type</label>
                                <select class="form-control select2 drop-cate" id="cate" name="cate[]" multiple="multiple">
                                    @foreach($cate as $key => $val)
                                        <option value="{{$val->id}}">{{$val->title}}</option>
                                    @endforeach
                                </select>
                                <input class="form-control cate-input" name="cate_name" style='display:none'>
                                <span class="label label-primary label-inline font-weight-boldest mr-2 new-cate" style="cursor:pointer">New Type</span>
                                <input class="cate-type" name="cate_type" value="0" type="hidden">
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
        <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Partner</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <form id="frmUpdate">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>User Name<span class="text-danger">*</span></label>
                                <input class="form-control" name="name" required>
                                <input class="form-control" name="id" id="u_id" type="hidden">
                            </div>
                            <div class="form-group">
                                <label>Phone Number<span class="text-danger">*</span></label>
                                <input class="form-control phone" name="phone_number" required>
                            </div>
                            <div class="form-group">
                                <label>Company Name</label>
                                <input class="form-control" name="com_name">
                            </div>
                            <div class="form-group">
                                <label>Email<span class="text-danger">*</span></label>
                                <input class="form-control" name="email" required>
                            </div>
                            <div class="form-group">
                                <label>Website</label>
                                <input class="form-control" name="email_1" type="url">
                            </div>
                            <div class="form-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="file" id="customFile"/>
                                    <label class="custom-file-label" for="customFile">Avatar</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Resource Type</label>
                                <select class="form-control select2 drop-cate" id="u_cate" name="cate[]" multiple="multiple">
                                    @foreach($cate as $key => $val)
                                        <option value="{{$val->id}}">{{$val->title}}</option>
                                    @endforeach
                                </select>
                                <input class="form-control cate-input" name="cate_name" style='display:none'>
                                <span class="label label-primary label-inline font-weight-boldest mr-2 new-cate" style="cursor:pointer">New Type</span>
                                <input class="cate-type" name="cate_type" value="0" type="hidden">
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
    <script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="/assets/js/doc-table.js"></script>
    <script>
        $(".phone").inputmask("mask", {
            "mask": "(999) 999-9999"
        });
        $('.drop-cate').select2({
			placeholder: "Select category"
		});
        $(".new-cate").on('click', function(){
            var cate_type = $(this).parent().find(".cate-type").val();
            if(cate_type == 0){
                $(this).parent().find(".cate-type").val(1)
                $(this).parent().find(".drop-cate").css('display', "none")
                $(this).parent().find(".cate-input").css('display', "block")
            }
            else{
                $(this).parent().find(".cate-type").val(0)
                $(this).parent().find(".drop-cate").css('display', "block")
                $(this).parent().find(".cate-input").css('display', "none")
            }
        })
        function update_doc(id, name, phone_number, com_name, email, email_1, cate_id){
            $("#u_id").val(id);
            $("#frmUpdate input[name='name']").val(name);
            $("#frmUpdate input[name='phone_number']").val(phone_number);
            $("#frmUpdate input[name='com_name']").val(com_name);
            $("#frmUpdate input[name='email']").val(email);
            $("#frmUpdate input[name='email_1']").val(email_1);
            $("#frmUpdate input[name='email_1']").val(email_1);
            $("#u_cate").css("display", "block");
            $("#frmUpdate .cate-input").css("display", "none");
            $("#frmUpdate input[name='cate_type']").val(0);
            cate_id = JSON.parse(cate_id);
            $("#u_cate").val(cate_id).trigger('change');;
            $(".btn-update").click();
        }
        function delete_doc(id){
            var id = id;
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url : '/delete_resource',
                        type : "POST",
                        data : {
                            id : id
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success : function (res){
                            if(res == "success"){
                                location.reload();
                            }
                            else{
                                toastr.error("Fail");
                            }
                        }
                    })
                }
            });
            
        }
        $("#frmNew").submit(function(event){
            event.preventDefault();
            KTApp.blockPage();
            var fs = new FormData(document.getElementById('frmNew'));
            $.ajax({
                url : "/new_resource",
                type : "POST",
                data : fs,
                processData : false,
                contentType : false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success : function (res){
                    KTApp.unblockPage();
                    if(res == "success"){
                        location.reload();
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
        $("#frmUpdate").submit(function(event){
            event.preventDefault();
            KTApp.blockPage();
            var fs = new FormData(document.getElementById('frmUpdate'));
            $.ajax({
                url : "/update_resource",
                type : "POST",
                data : fs,
                processData : false,
                contentType : false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success : function (res){
                    KTApp.unblockPage();
                    if(res == "success"){
                        location.reload();
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