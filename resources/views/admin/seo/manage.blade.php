@include('admin.include.admin-header')
<link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
<style>
    .action i{
        cursor : pointer
    }
</style>
<?php
    $pages = [
        'Homepage',
        'Why Use INEX',
        'Locations',
        'Create Free Account',
        'Try Our DEMO',
        'Why Use INEX Outdoor Digital Advertising?',
        'Why Use Digital Signs over Static Signs?',
        'What do we Sell',
        'Geofencing Explained',
        'All Pricing',
        'Billboard Calculator',
        'Case Studies',
        'Contact Sales',
        'Login',
        'Generic',
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
                                    <a class="btn btn-success mr-5" data-toggle="modal" data-target="#newModal">New</a>
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
                                            <th>Title</th>
                                            <th>Page Name</th>
                                            <th>Description</th>
                                            <th>Keywords</th>
                                            <th>Image</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($seos as $key => $val)
                                            <tr>
                                                <td>{{$val->title}}</td>
                                                <td>{{$val->page_name}}</td>
                                                <td>{{$val->extra}}</td>
                                                <td>{{$val->tags}}</td>
                                                <td>
                                                    @if($val->file != '')
                                                        <div class="symbol mr-3">
                                                            <img src="/upload/{{$val->file}}" style="">
                                                        </div>
                                                    @endif
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
    <div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form id="frmNew">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Title<span class="text-danger">*</span></label>
                            <input class="form-control" name="title" required>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="extra" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Keywords</label>
                            <textarea name="tags" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>UMT</label>
                            <textarea name="umt" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Select Page</label>
                            <select class="form-control" name="page_name">
                                @foreach($pages as $key => $val)
                                    <option value="{{ $val }}">{{ $val }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="file" id="customFile"/>
                                <label class="custom-file-label" for="customFile">Image</label>
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
                    <h5 class="modal-title" id="exampleModalLabel">Update</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form id="frmUpdate">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Title<span class="text-danger">*</span></label>
                            <input class="form-control" name="title" required>
                            <input class="form-control" name="id" id="u_id" type="hidden">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea id="extra_1" class="form-control" name="extra"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Keywords</label>
                            <textarea name="tags" class="form-control" id="tags"></textarea>
                        </div>
                        <div class="form-group">
                            <label>UMT</label>
                            <textarea name="umt" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Select Page</label>
                            <select class="form-control" name="page_name">
                                @foreach($pages as $key => $val)
                                    <option value="{{ $val }}">{{ $val }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="file" id="customFile"/>
                                <label class="custom-file-label" for="customFile">Image</label>
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
        // function update_doc(id, title, extra, tags, umt page_name){
        //     $("#u_id").val(id);
        //     $("#frmUpdate input[name='title']").val(title);
        //     $("#frmUpdate textarea[name='extra']").val(extra);
        //     $("#frmUpdate textarea[name='tags']").val(tags);
        //     $("#frmUpdate textarea[name='umt']").val(umt);
        //     $("#frmUpdate select[name='page_name'").val(page_name).trigger('change');;
        //     $(".btn-update").click();
        // }
        function update_doc(id){
            KTApp.blockPage();
            $.ajax({
                url: '/detail-seo',
                type: 'POST',
                data: {
                    id: id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res){
                    KTApp.unblockPage();
                    if(res['success'] == true) {
                        var data = res['data'];
                        $("#u_id").val(data['id']);
                        $("#frmUpdate input[name='title']").val(data['title']);
                        $("#frmUpdate textarea[name='extra']").val(data['extra']);
                        $("#frmUpdate textarea[name='tags']").val(data['tags']);
                        $("#frmUpdate textarea[name='umt']").val(data['umt']);
                        $("#frmUpdate select[name='page_name'").val(data['page_name']).trigger('change');;
                        $(".btn-update").click();
                    } else {
                        toastr.error(res);
                    }
                },
                error: function (err){
                    KTApp.unblockPage();
                }
            })
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
                    KTApp.blockPage();
                    $.ajax({
                        url : '/delete-seo',
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
                                KTApp.unblockPage();
                                toastr.error("Fail");
                            }
                        },
                        error: function (err){
                            KTApp.unblockPage();
                        }
                    })
                }
            });
            
        }
        jQuery(document).ready(function() {
            $("#frmNew").submit(function(event){
                event.preventDefault();
                KTApp.blockPage();
                var fs = new FormData(document.getElementById('frmNew'));
                $.ajax({
                    url : "/new-seo",
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
                    url : "/update-seo",
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
        });
    </script>	