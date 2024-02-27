@include('admin.include.admin-header')
<link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
<style>
    .action i{
        cursor : pointer
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
                                    <a class="btn btn-success mr-5" href="{{route('create-news')}}">Add Newsletter</a>
                                    <!-- <a class="btn btn-success mr-5" data-toggle="modal" data-target="#newModal">Add Newsletter</a> -->
                                    <a class="btn btn-success mr-5 btn-update" data-toggle="modal" data-target="#updateModal" style="display:none">Add Newsletter</a>
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
                                            <th>Delivery Date</th>
                                            <th>Auth Name</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                            <th>Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($news as $key => $val)
                                            <tr>
                                                <td>{{$val->title}}</td>
                                                <!-- <td>{{$val->content}}</td> -->
                                                <td>
                                                    <?php
                                                        $created = date_create($val->date);
                                                        echo date_format($created, "m-d-Y");
                                                    ?>
                                                </td>
                                                <td>{{$val->auth_name}}</td>
                                                <td>
                                                    @if($val->flag == 0)
                                                        <span class="label label-xl label-danger label-inline mr-2">Pending</span>
                                                    @else
                                                        <span class="label label-xl label-success label-inline mr-2">Approved</span>
                                                    @endif
                                                </td>
                                                <td class="action">
                                                    <a href="/update-news/{{$val->id}}" title="Edit">
                                                        <i class="fa fa-edit text-success mr-5"></i>
                                                    </a>
                                                    @if(session('level') == 2)
                                                        <i class="fas {{$val->flag == 0? 'fa-check': 'fa-times'}} text-info mr-5" onclick="change_status('{{$val->id}}', '{{$val->flag}}')" title="Approve / Reject"></i>
                                                    @endif
                                                    <i class="far fa-eye text-primary mr-5" onclick="send_test('{{$val->id}}')" title="Testing"></i>
                                                    @if($val->attachment != null)
                                                        <a href="/news/{{$val->attachment}}" target="_blank" title="View Attachment">
                                                            <i class="fas fa-download text-success mr-5"></i>
                                                        </a>
                                                    @endif
                                                    <i class="fa fa-trash text-danger mr-5" onclick="delete_doc('{{$val->id}}')" title="Delete"></i>
                                                </td>
                                                <td>
                                                    <?php
                                                        $created = date_create($val->created_at);
                                                        echo date_format($created, "m-d-Y H:i");
                                                    ?>
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
        function send_test(id){
            KTApp.blockPage();
            $.ajax({
                url: '/test-newsletter',
                type: 'POST',
                data : {
                    id: id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res){
                    KTApp.unblockPage();
                    if(res == 'success'){
                        toastr.success("Please check your email to test the newsletter");
                        return;
                    }
                    toastr.error(res);
                },
                error : function (error){
                    KTApp.unblockPage();
                }
            })
        }
        function change_status(id, flag){
            var status = flag == 0?"Approve":"Reject"
            Swal.fire({
                title: "Are you sure?",
                text: status + " newsletter",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes"
            }).then(function(result) {
                if (result.value) {
                    KTApp.blockPage();
                    $.ajax({
                        url : "/change-news",
                        type : "GET",
                        data : {
                            id : id,
                            status : flag
                        },
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
                        error: function (){
                            KTApp.unblockPage();
                        }
                    })
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
                        url : '/delete-news',
                        type : "GET",
                        data : {
                            id : id
                        },
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
                        error : function (error) {
                            KTApp.unblockPage();
                        }
                    })
                }
            });
            
        }
    </script>
		