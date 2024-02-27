@include('admin.include.admin-header')
<link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
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
                                <a class="btn btn-info mr-5" data-toggle="modal" data-target="#newModal">Add Subscriber</a>
                                <a class="btn btn-success mr-5" data-toggle="modal" data-target="#importModal">Import</a>
                                @if($status == 'duplicated')
                                <a href="/manage-subscribers" class="btn mr-5 btn-primary">List Subscribers</a>
                                @else
                                <a href="/manage-subscribers/duplicated" class="btn mr-5 btn-primary">Get Duplication</a>
                                @endif
                                <a class="btn btn-success mr-5 d-none btn-update" data-toggle="modal" data-target="#updateModal">New</a>
                                <button class="btn btn-danger delete_dupliation mr-5">Delete All Duplications</button>
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
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Subscription</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subs as $key => $val)
                                        <tr>
                                            <td>{{$val->firstName}}</td>
                                            <td>{{$val->lastName}}</td>
                                            <td>{{$val->email}}</td>
                                            <td>
                                                <?php
                                                    echo $val->status == 0 ? '<span class="label label-primary label-inline font-weight-lighter mr-2">Subscriber</span>' : '<span class="label label-danger label-inline font-weight-lighter mr-2">Unsubscriber</span>'
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $created = date_create($val->created_at);
                                                    echo date_format($created, "m-d-Y H:i");
                                                ?>
                                            </td>
                                            <td class="action">
                                                <i class="fa fa-edit text-success mr-5"
                                                    onclick="update_doc('{{$val->id}}')"
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
<a class="btn btn-success mr-5 btn-update" data-toggle="modal" data-target="#updateModal" style="display:none">New</a>
<div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Subscriber</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="frmNew">
                <div class="modal-body">
                    <div class="form-group">
                        <label>First Name<span class="text-danger">*</span></label>
                        <input class="form-control" name="firstName" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name<span class="text-danger">*</span></label>
                        <input class="form-control" name="lastName" required>
                    </div>
                    <div class="form-group">
                        <label>Email<span class="text-danger">*</span></label>
                        <input class="form-control" name="email" type="email" required>
                    </div>
                    <div class="form-group">
                        <div class="checkbox-list">
                            <label class="checkbox">
                                <input type="checkbox" name="status" checked/>
                                <span></span>
                                Subscriber
                            </label>
                        </div>
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Subscriber</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="frmUpdate">
                <div class="modal-body">
                    <div class="form-group">
                        <label>First Name<span class="text-danger">*</span></label>
                        <input class="form-control" name="firstName" required>
                        <input class="form-control" name="id" id="u_id" type="hidden">
                    </div>
                    <div class="form-group">
                        <label>Last Name<span class="text-danger">*</span></label>
                        <input class="form-control" name="lastName" required>
                    </div>
                    <div class="form-group">
                        <label>Email<span class="text-danger">*</span></label>
                        <input class="form-control" name="email" type="email" required>
                    </div>
                    <div class="form-group">
                        <div class="checkbox-list">
                            <label class="checkbox">
                                <input type="checkbox" name="status"/>
                                <span></span>
                                Subscriber
                            </label>
                        </div>
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
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Subscribers</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="frmImport">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Import CSV</label>
                        <div></div>
                        <div class="custom-file">
                            <input type="file" name="file" class="custom-file-input" id="customFile" accept=".csv"/>
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                    <div class="cusContainer d-none">
                        <div class="form-group">
                            <label>First Name</label>
                            <select class="form-control cusDrop" name="firstName"></select>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <select class="form-control cusDrop" name="lastName"></select>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <select class="form-control cusDrop" name="email"></select>
                        </div>
                        <div class="form-group">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    <input type="checkbox" name="status" checked/>
                                    <span></span>
                                    Subscriber
                                </label>
                            </div>
                        </div>
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
    function update_doc(id){
        KTApp.blockPage();
        $.ajax({
            url: '/get-subscriber',
            type: 'POST',
            data: {
                id: id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res){
                KTApp.unblockPage();
                if(res['success'] == true){
                    $("#u_id").val(id);
                    var data = res['data'];
                    $("#frmUpdate input[name='firstName']").val(data['firstName']);
                    $("#frmUpdate input[name='lastName']").val(data['lastName']);
                    $("#frmUpdate input[name='email']").val(data['email']);
                    $("#frmUpdate input[name='status']").prop('checked', data['status'] == 0 ? true : false);
                    $('.btn-update').click();
                } else {
                    toastr.error(res);
                }
            },
            error: function(err){
                KTApp.unblockPage();
            }
        })
    }
    function delete_doc(id){
        KTApp.blockPage();
        $.ajax({
            url: '/delete-subscriber',
            type: 'POST',
            data: {
                id: id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res){
                KTApp.unblockPage();
                if(res == 'success'){
                    location.reload();
                } else {
                    toastr.error(res);
                }
            },
            error: function(err){
                KTApp.unblockPage();
            }
        })
    }
    $(document).ready(function(){
        $("#frmImport").on('submit', function(event){
            event.preventDefault();
            var fs = new FormData(document.getElementById('frmImport'))
            KTApp.blockPage();
            $.ajax({
                url: '/import-csv',
                type: 'POST',
                data: fs,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res){
                    KTApp.unblockPage();
                    if(res == 'success'){
                        location.reload();
                    } else {
                        toastr.error(res);
                    }
                },
                error: function(err){
                    KTApp.unblockPage();
                }
            })
        })
        $("#frmNew").on('submit', function(event){
            event.preventDefault();
            KTApp.blockPage();
            var fs = new FormData(document.getElementById('frmNew'))
            $.ajax({
                url: '/add-subscriber',
                type: 'POST',
                data: fs,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res){
                    KTApp.unblockPage();
                    if(res == 'success'){
                        location.reload();
                    } else {
                        toastr.error(res);
                    }
                },
                error: function(err){
                    KTApp.unblockPage();
                }
            })
        })
        $("#frmUpdate").on('submit', function(event){
            event.preventDefault();
            KTApp.blockPage();
            var fs = new FormData(document.getElementById('frmUpdate'))
            $.ajax({
                url: '/update-subscriber',
                type: 'POST',
                data: fs,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res){
                    KTApp.unblockPage();
                    if(res == 'success'){
                        location.reload();
                    } else {
                        toastr.error(res);
                    }
                },
                error: function(err){
                    KTApp.unblockPage();
                }
            })
        })
        $("#customFile").on('change', function(e) {
            var file = e.target.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                $(".cusContainer").removeClass('d-none');
                $('.cusDrop').each(function(){
                    $(this)[0].innerHTML = '';
                })
                var contents = e.target.result;
                var lines = contents.split(/\r\n|\n/);
                header_line = lines[0].split(',');
                first_line = lines[1].split(',');
                var html = '';
                for(var i = 0; i < header_line.length; i++){
                    html += '<option value="'+i+'">'+header_line[i]+'</option>';
                }
                $('.cusDrop').each(function(){
                    $(this).append(html);
                })
            };
            reader.readAsText(file);
        })
        $(".delete_dupliation").on('click', function(){
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    KTApp.blockPage();
                    $.ajax({
                        url : '/delete_duplocation',
                        type : "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success : function (res){
                            KTApp.unblockPage();
                            if(res == "success"){
                                location.reload();
                            }
                            else{
                                toastr.error("Fail");
                            }
                        },
                        error: function (err){
                            KTApp.unblockPage();
                        }
                    })
                }
            })
        })
    })
</script>