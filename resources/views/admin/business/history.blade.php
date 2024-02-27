@include('admin.include.admin-header')
<!-- <link href="/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/> -->
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
                                    <h3 class="card-label">{{$page_name}} - {{$user->business_name}}</h3>
                                </div>
                                <!-- <div class="card-toolbar">
                                    <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal" >Create New Campaign</button>
                                </div> -->
                            </div>
                            <div class="card-body">
                                <div class="mb-7">
                                    <div class="row align-items-center">
                                        <div class="col-lg-9 col-xl-8">
                                            <div class="row align-items-center">
                                                <div class="col-md-4 my-2 my-md-0">
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query" />
                                                        <span><i class="flaticon2-search-1 text-muted"></i></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 my-2 my-md-0">
                                                    <div class="d-flex align-items-center">
                                                        <label class="mr-3 mb-0 d-none d-md-block">Status:</label>
                                                        <select class="form-control" id="kt_datatable_search_status" autocomplete="off">
                                                            <option value="">All</option>
                                                            <option value="0">Published to CM</option>
                                                            <option value="1">Campaign</option>
                                                            <option value="2">Deleted</option>
                                                            <!-- <option value="3">Canceled</option> -->
                                                            <option value="4">Created an Ad</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="col-lg-3 col-xl-4 mt-5 mt-lg-0">
                                            <a href="#" class="btn btn-light-primary px-6 font-weight-bold">
                                                Search
                                            </a>
                                        </div> -->
                                    </div>
                                </div>
                                <table class="table table-bordered table-hover table-checkable" id="kt_datatable">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Last Changed by</th>
                                            <th>Ad</td>
                                            <th>Status</th>
                                            <th>Modified</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $action_list = [
                                        "Publish To CM", "Campaign" , "Deleted" , "Publish To Socials", "Created an Ad"
                                    ];
                                    $today = date("Y-m-d");
                                    ?>
                                    <tbody>
                                        @foreach($logs as $key => $item)
                                            <tr>
                                                <td>
                                                    @if($item->status == 1)
                                                        @if($item->start_date > $today || $item->end_date < $today)
                                                        <a class="edit_camp ml-2 mr-5" style="cursor:pointer" 
                                                            data-id="{{$item->id}}"
                                                            data-start="{{$item->start_date}}"
                                                            data-end="{{$item->end_date}}"
                                                            onclick="edit_camp('{{$item->id}}', '{{$item->start_date}}', '{{$item->end_date}}')"
                                                        >
                                                            <i class="fa fa-edit text-success"></i>
                                                        </a>
                                                        <a class="delete_camp" onclick="delete_camp('{{$item->id}}')" data-id="{{$item->id}}" style="cursor:pointer"><i class="fa fa-trash text-danger"></i></a>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    <?php
                                                        $start_date = $item->start_date;
                                                        if($start_date != null){
                                                            $created = date_create($start_date);
                                                            echo date_format($created, "m-d-Y");
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        $end_date = $item->end_date;
                                                        if($end_date != null){
                                                            $created = date_create($end_date);
                                                            echo date_format($created, "m-d-Y");
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    {{isset($item->user_name)?$item->user_name:''}}
                                                </td>
                                                <td>
                                                    @if($item->img_url != null)
                                                        <img src='/upload/{{$item->img_url}}' width="100" height="50"/>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{$item->status}}
                                                </td>
                                                <td>
                                                    <?php
                                                        $date = $item->created_at;
                                                        $created = date_create($date);
                                                        echo date_format($created, "m-d-Y");
                                                    ?>
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
    <!-- <button class="btn-launch" style="display:none" data-toggle="modal" data-target="#UpdateModal"></button>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Start and End Date</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form id="frm_create">
                    <div class="modal-body">
                        <div class="form-group">
                            <span>Start Date : </span>
                            <input class="form-control" name="id" value="{{$user_id}}" style="display:none">
                            <input class="form-control" name="start_date" min="{{date('Y-m-d')}}" type="date" value="{{date('Y-m-d')}}">
                        </div>
                        <div class="form-group">
                            <span>End Date : </span>
                            <input class="form-control" name="end_date" min="{{date('Y-m-d')}}" type="date" value="{{date('Y-m-d', strtotime('+10 years'))}}">
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
    <div class="modal fade" id="UpdateModal" tabindex="-1" role="dialog" aria-labelledby="UpdateModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Start and End Date</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form id="frm_update">
                    <div class="modal-body">
                        <div class="form-group">
                            <span>Start Date : </span>
                            <input class="form-control" name="id" id="update_id" value="{{$user_id}}" style="display:none">
                            <input class="form-control" name="start_date" id="start_date" min="{{date('Y-m-d')}}" type="date" value="{{date('Y-m-d')}}">
                        </div>
                        <div class="form-group">
                            <span>End Date : </span>
                            <input class="form-control" name="end_date" id="end_date" min="{{date('Y-m-d')}}" type="date" value="{{date('Y-m-d', strtotime('+10 years'))}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div> -->
    @include("admin.include.admin-footer")

    <script>var HOST_URL = "https://keenthemes.com/metronic/tools/preview";</script>
    <script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
    <script src="/assets/plugins/global/plugins.bundle.js"></script>
    <script src="/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
    <script src="/js/suggest.js"></script>
    <script src="/assets/js/scripts.bundle.js"></script>
    <!-- <script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script> -->
    <script src="/assets/js/history.js"></script>
    <script>
        // $(".edit_camp").on('click', function(){
        //     $('#update_id').val($(this).data('id'));
        //     $("#start_date").val($(this).data('start'));
        //     $("#end_date").val($(this).data('end'));
        //     $(".btn-launch").click();
        // })
        function edit_camp(id, start, end){
            $('#update_id').val(id);
            $("#start_date").val(start);
            $("#end_date").val(end);
            $(".btn-launch").click();
        }
        function delete_camp(id){
            Swal.fire({
                title: "Are you sure?",
                text: "You won\'t be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url : "/delete_campaign",
                        data : {
                            id : id,
                        },
                        type : "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success : function(res){
                            if(res == 'success'){
                                location.reload();
                            }
                            else{
                                toastr.error(res);
                            }
                        },
                        error : function(err){
                            toastr.error("Server Error. Please refresh your browser");
                        }
                    })
                }
            });
        }
        $("#frm_create").submit(function(event){
            event.preventDefault();
            var fs = new FormData(document.getElementById('frm_create'));
            KTApp.blockPage();
            $.ajax({
                url : "/create-campaign",
                type : "POST",
                data : fs,
                processData : false,
                contentType : false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success : function(res){
                    KTApp.unblockPage();
                    if(res == 'success'){
                        location.reload();
                    }
                    else{
                        toastr.error(res);
                    }
                },
                error : function(err){
                    KTApp.unblockPage();
                    toastr.error("Server Error. Please refresh your browser");
                    // document.reload();
                }
            })
        })
        $("#frm_update").submit(function(event){
            event.preventDefault();
            var fs = new FormData(document.getElementById('frm_update'));
            KTApp.blockPage();
            $.ajax({
                url : "/update-campaign",
                type : "POST",
                data : fs,
                processData : false,
                contentType : false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success : function(res){
                    KTApp.unblockPage();
                    if(res == 'success'){
                        location.reload();
                    }
                    else{
                        toastr.error(res);
                    }
                },
                error : function(err){
                    KTApp.unblockPage();
                    toastr.error("Server Error. Please refresh your browser");
                    // document.reload();
                }
            })
        })
    </script>
		