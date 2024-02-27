@include('admin.include.admin-header')
<style>
    i{
        cursor : pointer
    }
    .ellipsis {
        max-width: 100px;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
    }
</style>
<link href="/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader min-h-lg-15px pt-5 pb-7 subheader-transparent" id="kt_subheader">
		</div>
		<div class="d-flex flex-column-fluid">
			<div class="container-fluid">
                <div class="alert alert-custom alert-white alert-shadow fade show gutter-b" role="alert">
                    <div class="alert-icon">
                        <span class="svg-icon svg-icon-primary svg-icon-xl">
                            <i class="la la-thumbs-o-up text-success"></i>
                        </span>
                    </div>
                    <div class="alert-text">
                        <ul class="mb-0">
                            <li>You can schedule multiple posts.</li>
                            <li>Select one of your Ads, add the text you wish to accompany the image.</li>
                            <li>Select the Social Media accounts you wish to deliver each Post.</li>
                            <li>You must have setup your Social media links to make this work.</li>
                        </ul>
                    </div>
                </div>
                <div class="card card-custom" data-card="true" id="kt_card_1">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">{{$page_name}}</h3>
                        </div>
                        <div class="card-toolbar">
                            <div class="form-group mr-5 mt-auto mb-auto">
                                <select class="form-control select2 business_name" id="business_name">
                                    <option value="">Select Business Name</option>
                                    @foreach($business_name as $key => $val)
                                    <option value="{{$val->business_name}}">{{$val->business_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <a class="btn btn-success" href="/create-post">Create Post</a>
                            <!-- @if(session('level') == 2)
                            <a class="btn btn-info ml-5" href="/history-posts">View History</a>
                            @endif -->
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover table-checkable" id="kt_datatable">
                            <thead>
                                <tr>
                                    <th>Scheduled Date</th>
                                    <th>Business Name</th>
                                    <th>Trusted Agent</th>
                                    <th>Text</th>
                                    <th>Delivered to</th>
                                    <th>Delivered Ad</th>
                                    <th>Delivery Status</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <?php
                            $social_list = config('app.social_list');
                            ?>
                            <tbody>
                                @foreach($data as $key => $val)
                                    <tr>
                                        <td>
                                            <?php
                                            $created = date_create($val->post_date);
                                            echo date_format($created, "m-d-Y");
                                            ?>
                                        </td>
                                        <td>{{$val->business_name}}</td>
                                        <td>{{$val->user_name}}</td>
                                        <td class="ellipsis">{{$val->context}}</td>
                                        <td>
                                            @foreach(json_decode($val->socials, true) as $social)
                                                {{$social_list[$social]}},
                                            @endforeach
                                        </td>
                                        <td>
                                            <div class="symbol-group symbol-hover">
                                                @foreach(json_decode($val->imgs, true) as $img)
                                                <div class="symbol" data-text="{{$val->context}}" title="View Post of image and text">
                                                    <img alt="Pic" src="/upload/{{$img}}"/>
                                                </div>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td>
                                            @if($val->status == 1)
                                                <span class="label label-xl label-success label-pill label-inline mr-2">Sent</span>
                                            @endif
                                        </td>
                                        <td>
                                            <?php
                                            $created = date_create($val->created_at);
                                            echo date_format($created, "m-d-Y h:i");
                                            ?>
                                        </td>
                                        <td>
                                            @if($val->flag == null)
                                            <i class="fa fa-trash delete-post text-danger mr-5" data-id="{{$val->id}}"></i>
                                            @endif
                                            <i class="fa fa-eye preview text-info" 
                                                title="View Post of image and text"
                                                data-id="{{$val->id}}"
                                                data-text="{{$val->context}}"
                                                <?php foreach(json_decode($val->imgs, true) as $img){
                                                ?>
                                                    data-src="/upload/{{$img}}"
                                                <?php }?>
                                            ></i>
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
    <button type="button" class="btn btn-primary btn-prview" style="display:none" data-toggle="modal" data-target="#exampleModal">Preview</button>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Preview</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea class="form-control mb-5" id="dis_text"></textarea>
                    <img src="" id="dis_img" style="width:100%">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @include('admin.include.admin-footer')
    <script>var HOST_URL = "https://keenthemes.com/metronic/tools/preview";</script>
    <script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
    <script src="/assets/plugins/global/plugins.bundle.js"></script>
    <script src="/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
    <script src="/js/suggest.js"></script>
    <script src="/assets/js/scripts.bundle.js"></script>
    <script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="/assets/js/post-table.js"></script>
<script>
    $(document).ready(function(){
        autosize($('#dis_text'));
        $('.select2').select2({
            placeholder: "Select a Business Name"
        });
        $(".delete-post").on('click', function(){
            var id = $(this).data('id');
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
                        url : '/delete-post/'+id,
                        Type : "GET",
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
                            toastr.error("Please refresh your browser");
                        }
                    })
                }
            });
        })
        $(".preview").on('click', function(){
            $("#dis_text").text($(this).data('text'))
            $("#dis_img").attr('src',$(this).data('src'));
            $(".btn-prview").click();
        })
        $(".symbol").on('click', function(){
            $("#dis_text").text($(this).data('text'))
            $("#dis_img").attr('src',$(this).find('img').attr('src'));
            $(".btn-prview").click();
        })
        <?php
            if(session('level') >= 2){
        ?>
            $(".status").on('change', function(){
                KTApp.blockPage();
                $.ajax({
                    url : '/process-post',
                    data : {
                        id : $(this).data('id'),
                        status : $(this).val()
                    },
                    type : "GET",
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
                        toastr.error("Please refresh your browser");
                    }
                })
            })
        <?php }?>
    })
</script>