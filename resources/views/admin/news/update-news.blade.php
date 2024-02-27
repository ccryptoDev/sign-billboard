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
            <div class="container">
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
                            <form id="frmUpdate">
                                <div class="card-body">
                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label>Title <span class="text-danger">*</span></label>
                                        <input class="form-control" name="id" value="{{$news->id}}" type="hidden">
                                        <input class="form-control" name="title" required autocomplete="off" value="{{$news->title}}">
                                    </div>
                                    <div class="form-group">
                                        <label>Delivery Date <span class="text-danger">*</span></label>
                                        <input class="form-control" name="date" type="date" value="{{$news->date}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Content <span class="text-danger">*</span></label>
                                        <textarea name="content" id="kt-ckeditor-1">{{$news->content}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Auth Name <span class="text-danger">*</span></label>
                                        <input class="form-control" name="auth_name" type="text" value="{{$news->auth_name}}" disabled required autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>Attachment</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="file" id="customFile"/>
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-success" type="submit">Update</button>
                                </div>
                            </form>
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
    <script src="/assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>
    <script>
        var KTCkeditor = function () {
            // Private functions
            var demos = function () {
                ClassicEditor
                    .create( document.querySelector( '#kt-ckeditor-1' ) )
                    .then( editor => {
                        console.log( editor );
                    } )
                    .catch( error => {
                        console.error( error );
                    } );
            }

            return {
                // public functions
                init: function() {
                    demos();
                }
            };
        }();

        // Initialization
        jQuery(document).ready(function() {
            KTCkeditor.init();
            $("#frmUpdate").submit(function(event){
                event.preventDefault();
                KTApp.blockPage();
                var fs = new FormData(document.getElementById('frmUpdate'));
                $.ajax({
                    url : "/update_news",
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
                            location.href="/newsletter"
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
		