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
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-custom card-stretch gutter-b">
                        <div class="card-body d-flex align-items-center py-0 mt-3">
                            <div class="d-flex flex-column flex-grow-1 py-2 py-lg-5">
                                <a class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-2 text-hover-dark subTitle">
                                    @foreach($cate as $key => $val)
                                        @if(request()->route('id') == $val->id)
                                            {{$val->name}}
                                        @endif
                                    @endforeach
                                </a>
                                <p>
                                    @foreach($cate as $key => $val)
                                        @if(request()->route('id') == $val->id)
                                            {{$val->extra}}
                                        @endif
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    </div>                    
                </div>
                <div class="col-lg-3 col-xl-2">
                    <div class="card card-custom" data-sticky="true" data-margin-top="140px" data-sticky-for="1023" data-sticky-class="kt-sticky">
                        <div class="card-body p-0">
                            <ul class="navi navi-bold navi-hover my-5" role="tablist">
                                <li class="navi-item">
                                    <a class="navi-link" href="/graphic-design">
                                        <span class="navi-text">Trusted Partners</span>
                                    </a>
                                </li>
                                @foreach($cate as $key => $val)
                                    @if(session('level') >= 2 || (session('level') < 2 && $val->private == 1))
                                        <li class="navi-item">
                                            <a class="navi-link {{request()->route('id') == $val->id ? 'active' : ''}}" href="/training/{{$val->id}}" data-id="{{$val->id}}" data-title="{{$val->name}}">
                                                <span class="navi-text">{{$val->name}}</span>
                                            </a>
                                        </li>
                                    @endif
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
                                        <a href="/doc/{{base64_encode($val->id)}}" target="_blank" class="d-flex flex-column align-items-center">
                                            <span class="text-center text-dark-75 font-weight-bold mb-5 font-size-lg">
                                                {{$val->name}}
                                            </span>
                                            <img alt="" class="max-h-125px" src="{{$val->img != '' ? '/doc/'.$val->img : '/assets/media/svg/files/pdf.svg' }} ">
                                            <span class="text-dark-75 font-weight-bold mt-5 font-size-sm">
                                                {{$val->extra}}
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
    // $(".navi-link").on('click', function(){
    //     var cate_id = $(this).data('id');
    //     $(".subTitle").text($(this).data('title'));
    //     $(".navi-link").each(function(){
    //         $(this).removeClass('active');
    //     })
    //     $(this).addClass('active');
    //     if(cate_id == 0){
    //         $(".doc-container").each(function(){
    //             $(this).removeClass('d-none')
    //         })
    //     } else {
    //         hideContainer(cate_id);
    //     }
    // })
    function hideContainer(cate_id){
        $(".doc-container").each(function(){
            $(this).addClass('d-none')
        })
        $(".doc-container").each(function(){
            if($(this).data('id') == cate_id){
                $(this).removeClass('d-none')
            }
        })
        KTApp.unblockPage();
    }
    <?php
        if(session('level') < 2 && request()->route('id') != '') {
    ?>
        $(document).ready(function(){
            KTApp.blockPage();
            hideContainer('<?php echo request()->route('id')?>');
        })
    <?php }?>
</script>