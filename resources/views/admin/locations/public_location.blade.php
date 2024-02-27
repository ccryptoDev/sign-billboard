@include('admin.include.admin-header')
<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css" />
<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css" />                    
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
                                    <h3 class="card-label">{{$page_name}}</h3>
                                </div>
                            </div>
                            <?php
                            $public_locations = [];
                            $private_locations = [];
                            foreach($p_locations as $item){
                                if($item->type == 0){
                                    $public_locations[] = $item->location_id;
                                }
                                else{
                                    $private_locations[] = $item->location_id;
                                }
                            }
                            ?>
                            <form id="frmLocation">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <span>Public Locations</span>
                                            <div class="form-group mt-5">
                                                <div class="radio-list public_list">
                                                    @foreach($locations as $key => $val)
                                                    <label class="radio">
                                                        <input type="radio" name="radios{{$key}}" value="{{$val->id}}" {{in_array($val->id, $public_locations)?'checked':''}}/>
                                                        <span></span>
                                                        {{$val->nickname}}
                                                    </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <span>Private Locations</span>
                                            <div class="form-group mt-5">
                                                <div class="radio-list private_list">
                                                    @foreach($locations as $key => $val)
                                                    <label class="radio">
                                                        <input type="radio" name="radios{{$key}}" value="{{$val->id}}" {{in_array($val->id, $private_locations)?'checked':''}}/>
                                                        <span></span>
                                                        {{$val->nickname}}
                                                    </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-danger">Save</button>
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js"></script>
    <script src="/js/inputmask.js"></script>
    <script>
        $(document).ready(function(){
            $("#frmLocation").submit(function(event){
                event.preventDefault();
                var fs = new FormData(document.getElementById("frmLocation"));
                // KTApp.blockPage();
                var public = [];
                var private = [];
                $(".public_list input").each(function(){
                    if($(this).prop('checked') == true){
                        public.push($(this).val());
                    }
                })
                $(".private_list input").each(function(){
                    if($(this).prop('checked') == true){
                        private.push($(this).val());
                    }
                })
                fs.append('public', public)
                fs.append('private', private)
                $.ajax({
                    url : "/save-public_location",
                    type : "POST",
                    data : fs,
                    contentType : false,
                    processData : false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success : function(res){
                        KTApp.unblockPage();
                        if(res == 'success'){
                            toastr.success("Success")
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
        })
    </script>
	</body>
</html>
		