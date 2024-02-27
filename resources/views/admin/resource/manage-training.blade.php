@include('admin.include.admin-header')
<link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
<style>
.action i {
    cursor: pointer
}
</style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader min-h-lg-15px pt-5 pb-7 subheader-transparent" id="kt_subheader">
    </div>
    <div class="d-flex flex-column-fluid">
        <div class="{{session('level') < 2 ? 'container' : 'container-fluid'}}">
            <div class="row">
                @if(session('level') < 2) 
                    <div class="col-lg-3 col-xl-2">
                        <div class="card card-custom" data-sticky="true" data-margin-top="140px" data-sticky-for="1023" data-sticky-class="kt-sticky">
                            <div class="card-body p-0">
                                <ul class="navi navi-bold navi-hover my-5" role="tablist">
                                    <li class="navi-item">
                                        <a class="navi-link" href="/graphic-design">
                                            <span class="navi-text">Partners</span>
                                        </a>
                                    </li>
                                    @foreach($cate as $key => $val)
                                        <li class="navi-item">
                                            <a class="navi-link" data-toggle="tab" data-id="{{$val->id}}" href="#kt_profile_tab_personal_information">
                                                <span class="navi-text">{{$val->name}}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-10">
                        <div class="row">
                            @foreach($docs as $key => $val)
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 doc-container" data-id="{{$val->cat_id}}">
                                    <div class="card card-custom gutter-b card-stretch">
                                        <div class="card-body">
                                            <div class="d-flex flex-column align-items-center">
                                                <img alt="" class="max-h-75px" src="{{$val->img != '' ? '/doc/'.$val->img : '/assets/media/svg/files/pdf.svg' }} ">
                                                <a href="/doc/{{$val->file_name}}" target="_blank" class="text-dark-75 font-weight-bold mt-5 font-size-lg">
                                                    {{$val->name}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="col-lg-12">
                        <div class="card card-custom" data-card="true" id="kt_card_1">
                            <div class="card-header">
                                <div class="card-title"></div>
                                <div class="card-toolbar">
                                    @if(session('level') == 2)
                                    <a class="btn btn-success btn-block mr-5" data-toggle="modal"
                                        data-target="#newModal">Upload New Document</a>
                                    <a class="btn btn-success mr-5 btn-update" data-toggle="modal" data-target="#updateModal"
                                        style="display:none">New</a>
                                    @endif
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
                                <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                                    style="margin-top: 13px !important">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Document Title</th>
                                            <th>Description</th>
                                            <th>Actions</th>
                                            @if(session('level') == 2)
                                            <th>File Name</th>
                                            <th>Share</th>
                                            <th>Visible</th>
                                            @endif
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($docs as $key => $val)
                                        <tr>
                                            <td>{{$val->cate_name}}</td>
                                            <td>{{$val->name}}</td>
                                            <td>{{$val->extra}}</td>
                                            <td class="action">
                                                @if(session('level') == 2)
                                                <i class="fa fa-edit text-success mr-5"
                                                    onclick="update_doc('{{$val->id}}')"></i>
                                                <i class="fa fa-trash text-danger mr-5"
                                                    onclick="delete_doc('{{$val->id}}')"></i>
                                                @endif
                                                <a href="/doc/{{$val->file_name}}" target="_blank">
                                                    <i class="far fa-file-pdf text-success mr-5"></i>
                                                </a>
                                                @if($val->img != '')
                                                <a href="/doc/{{$val->img}}" target="_blank">
                                                    <i class="far fa-file-image text-warning mr-5"></i>
                                                </a>
                                                @endif
                                            </td>
                                            @if(session('level') >= 2)
                                            <td>{{$val->file_name}}</td>
                                            <td>
                                                <i class="fa fa-paper-plane text-info mr-5"
                                                    title="Deliver this document to my client" style="cursor:pointer"
                                                    onclick="share_doc('{{$val->id}}')"></i>
                                            </td>
                                            @endif
                                            @if(session('level') == 2)
                                            <td>
                                                <?php echo $val->private == 0 ? 
                                                    '<span class="label label-lg label-danger label-inline mr-2">Private</span>'
                                                    : '<span class="label label-lg label-success label-inline mr-2">Public</span>'
                                                ?>
                                            </td>
                                            @endif
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
                @endif
            </div>
        </div>
    </div>
</div>
@if(session('level') == 2)
<div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload New Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="frmNew">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Document Title <span class="text-danger">*</span></label>
                        <input class="form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Description </label>
                        <textarea class="form-control" name="extra"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Category Name</label>
                        <select class="form-control drop-cate" name="cate">
                            @foreach($cate as $key => $val)
                            <option value="{{$val->id}}">{{$val->name}}</option>
                            @endforeach
                        </select>
                        <input class="form-control cate-input" name="cate_name" style='display:none'>
                        <span class="label label-primary label-inline font-weight-boldest mr-2 new-cate"
                            style="cursor:pointer">New Category</span>
                        <input class="cate-type" name="cate_type" value="0" type="hidden">
                    </div>
                    <div class="form-group">
                        <label>Upload PDF</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="file" accept=".pdf" />
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Upload Image</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="img" accept=".png, .jpg, .jpeg" />
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="radio-list">
                            <label class="radio">
                                <input type="radio" name="private" value="1" />
                                <span></span>
                                Public
                            </label>
                            <label class="radio">
                                <input type="radio" checked="checked" name="private" value="0" />
                                <span></span>
                                Private
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold"
                        data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="frmUpdate">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Document Title <span class="text-danger">*</span></label>
                        <input class="form-control" name="id" id="u_id" type="hidden">
                        <input class="form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="u_extra" name="extra"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Category Name</label>
                        <select class="form-control drop-cate" id="u_cate" name="cate">
                            @foreach($cate as $key => $val)
                            <option value="{{$val->id}}">{{$val->name}}</option>
                            @endforeach
                        </select>
                        <input class="form-control cate-input" name="cate_name" style='display:none'>
                        <span class="label label-primary label-inline font-weight-boldest mr-2 new-cate"
                            style="cursor:pointer">New Category</span>
                        <input class="cate-type" name="cate_type" value="0" type="hidden">
                    </div>
                    <div class="form-group">
                        <label>Upload PDF</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="file" id="customFile" accept=".pdf" />
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Upload Image</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="img" id="cutomImg"
                                accept=".png, .jpg, .jpeg" />
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="radio-list private">
                            <label class="radio">
                                <input type="radio" name="private" value="1" />
                                <span></span>
                                Public
                            </label>
                            <label class="radio">
                                <input type="radio" checked="checked" name="private" value="0" />
                                <span></span>
                                Private
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold"
                        data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<button type="button" class="btn btn-primary btn-share" data-toggle="modal" data-target="#shareModal"
    style="display:none"></button>
<div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareModalLabel">Share Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="frmShare">
                <div class="modal-body">
                    <input type="hidden" name="id" id="share_id">
                    <div class="form-group">
                        <label>From</label>
                        <input type="text" name="from" class="form-control" value="sales@inex.net" disabled>
                    </div>
                    <div class="form-group">
                        <label>Business Name</label>
                        <select class="form-control" name="business_name">
                            @foreach($business_name as $key => $val)
                            <option value="{{$val->business_name}}">{{$val->business_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Subject</label>
                        <input type="text" name="subject" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Body</label>
                        <textarea name="body" rows="3" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold c-modal"
                        data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include("admin.include.admin-footer")

<script>
var HOST_URL = "https://keenthemes.com/metronic/tools/preview";
</script>
<script>
var KTAppSettings = {
    "breakpoints": {
        "sm": 576,
        "md": 768,
        "lg": 992,
        "xl": 1200,
        "xxl": 1200
    },
    "colors": {
        "theme": {
            "base": {
                "white": "#ffffff",
                "primary": "#6993FF",
                "secondary": "#E5EAEE",
                "success": "#1BC5BD",
                "info": "#8950FC",
                "warning": "#FFA800",
                "danger": "#F64E60",
                "light": "#F3F6F9",
                "dark": "#212121"
            },
            "light": {
                "white": "#ffffff",
                "primary": "#E1E9FF",
                "secondary": "#ECF0F3",
                "success": "#C9F7F5",
                "info": "#EEE5FF",
                "warning": "#FFF4DE",
                "danger": "#FFE2E5",
                "light": "#F3F6F9",
                "dark": "#D6D6E0"
            },
            "inverse": {
                "white": "#ffffff",
                "primary": "#ffffff",
                "secondary": "#212121",
                "success": "#ffffff",
                "info": "#ffffff",
                "warning": "#ffffff",
                "danger": "#ffffff",
                "light": "#464E5F",
                "dark": "#ffffff"
            }
        },
        "gray": {
            "gray-100": "#F3F6F9",
            "gray-200": "#ECF0F3",
            "gray-300": "#E5EAEE",
            "gray-400": "#D6D6E0",
            "gray-500": "#B5B5C3",
            "gray-600": "#80808F",
            "gray-700": "#464E5F",
            "gray-800": "#1B283F",
            "gray-900": "#212121"
        }
    },
    "font-family": "Poppins"
};
</script>
<script src="/assets/plugins/global/plugins.bundle.js"></script>
<script src="/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
<script src="/js/suggest.js"></script>
<script src="/assets/js/scripts.bundle.js"></script>
<script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="/assets/js/doc-table.js"></script>
<script>
    function share_doc(id) {
        $("#share_id").val(id);
        $('.btn-share').click();
    }
    $("#frmShare").submit(function(event) {
        event.preventDefault();
        KTApp.blockPage();
        var fs = new FormData(document.getElementById('frmShare'));
        $.ajax({
            url: "/share_doc",
            type: "POST",
            data: fs,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                KTApp.unblockPage();
                if (res == "success") {
                    location.reload();
                } else {
                    toastr.error(res);
                }
            },
            error: function(err) {
                KTApp.unblockPage();
                toastr.error("Please refresh your browser");
            }
        })
    })
    $(".navi-link").on('click', function(){
        var cate_id = $(this).data('id');
        if(cate_id == 0){
            $(".doc-container").each(function(){
                $(this).removeClass('d-none')
            })
        } else {
            hideContainer(cate_id);
        }
    })
    function hideContainer(cate_id){
        $(".doc-container").each(function(){
            $(this).addClass('d-none')
        })
        $(".doc-container").each(function(){
            if($(this).data('id') == cate_id){
                $(this).removeClass('d-none')
            }
        })
    }
    <?php
        if(session('level') < 2 && request()->route('id') != '') {
    ?>
        hideContainer('<?php echo request()->route('id')?>');
    <?php }
        else {
    ?>
        $(".new-cate").on('click', function() {
            var cate_type = $(this).parent().find(".cate-type").val();
            if (cate_type == 0) {
                $(this).parent().find(".cate-type").val(1)
                $(this).parent().find(".drop-cate").css('display', "none")
                $(this).parent().find(".cate-input").css('display', "block")
            } else {
                $(this).parent().find(".cate-type").val(0)
                $(this).parent().find(".drop-cate").css('display', "block")
                $(this).parent().find(".cate-input").css('display', "none")
            }
        })

        function update_doc(id) {
            KTApp.blockPage();
            $.ajax({
                url : '/detail-doc',
                type : 'post',
                data : {
                    id: id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res){
                    KTApp.unblockPage();
                    if(res['success'] == true){
                        display_edit(res['data']);
                    }
                    else{
                        toastr.error('Invalid Document');
                    }
                },
                error: function(error){
                    KTApp.unblockPage();
                }
            })
        }

        function display_edit(data){
            var id = data['id'];
            var cate_id = data['cate'];
            var name = data['name'];
            var private = data['private'];
            var description = data['extra'];
            $("#u_id").val(id);
            $("#frmUpdate input[name='name']").val(name);
            $("#u_cate").css("display", "block");
            $("#frmUpdate .cate-input").css("display", "none");
            $("#frmUpdate input[name='cate_type']").val(0);
            $("#u_extra").text(description);
            $("#u_cate").val(cate_id);
            $(".private").find('input').each(function() {
                if ($(this).val() == private) {
                    $(this).prop('checked', true);
                }
            })
            $(".btn-update").click();
        }

        function delete_doc(id) {
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
                        url: '/delete_doc',
                        type: "GET",
                        data: {
                            id: id
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(res) {
                            if (res == "success") {
                                location.reload();
                            } else {
                                toastr.error("Fail");
                            }
                        }
                    })
                }
            });

        }
        $("#frmNew").submit(function(event) {
            event.preventDefault();
            KTApp.blockPage();
            var fs = new FormData(document.getElementById('frmNew'));
            $.ajax({
                url: "/new_doc",
                type: "POST",
                data: fs,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    KTApp.unblockPage();
                    if (res == "success") {
                        location.reload();
                    } else {
                        toastr.error(res);
                    }
                },
                error: function(err) {
                    KTApp.unblockPage();
                    toastr.error("Please refresh your browser");
                }
            })
        })
        $("#frmUpdate").submit(function(event) {
            event.preventDefault();
            KTApp.blockPage();
            var fs = new FormData(document.getElementById('frmUpdate'));
            $.ajax({
                url: "/update_doc",
                type: "POST",
                data: fs,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    KTApp.unblockPage();
                    if (res == "success") {
                        location.reload();
                    } else {
                        toastr.error(res);
                    }
                },
                error: function(err) {
                    KTApp.unblockPage();
                    toastr.error("Please refresh your browser");
                }
            })
        })
    <?php }?>
</script>