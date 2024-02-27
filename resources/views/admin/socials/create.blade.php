@include('admin.include.admin-header')
<style>
    .symbol, .symbol-label{
        width : 90% !important;
        height : 150px;
    }
</style>
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader min-h-lg-15px pt-5 pb-7 subheader-transparent" id="kt_subheader">
		</div>
		<div class="d-flex flex-column-fluid">
			<div class="container">
                <div class="card card-custom" data-card="true" id="kt_card_1">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">{{$page_name}}</h3>
                        </div>
                        <div class="card-toolbar">
                        </div> 
                    </div>
                    <?php 
                    $col = session('level') >= 2?"col-md-6":"col-md-12";
                    ?>
                    <form id="frmPost">
                        <div class="card-body">
                            <div class="row">
                                @if(session('level') >= 2)
                                <div class="{{$col}}">
                                    <div class="d-flex align-items-center mb-3 bg-light-success rounded p-5">
                                        <span class="svg-icon svg-icon-warning mr-5">
                                            <i class="text-success far fa-user"></i>
                                        </span>
                                        <div class="d-flex flex-column flex-grow-1 mr-2">
                                            <a class="font-weight-bold text-dark-75 font-size-lg mb-1">Select Business Name</a>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control select2 business_name" id="business_name">
                                            <option value="">Select Business Name</option>
                                            @foreach($business_name as $key => $val)
                                            <option value="{{$val->business_name}}">{{$val->business_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endif
                                <div class="{{$col}}">
                                    <div class="d-flex align-items-center mb-3 bg-light-success rounded p-5">
                                        <span class="svg-icon svg-icon-warning mr-5">
                                            <i class="text-success far fa-clock"></i>
                                        </span>
                                        <div class="d-flex flex-column flex-grow-1 mr-2">
                                            <a class="font-weight-bold text-dark-75 font-size-lg mb-1">Schedule Delivery Date</a>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="date" class="form-control" placeholder="Select date" name="date" value="{{date('Y-m-d')}}" min="{{date('Y-m-d')}}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3 bg-light-success rounded p-5">
                                <span class="svg-icon svg-icon-warning mr-5">
                                    <i class="text-success fas fa-clipboard-list"></i>
                                </span>
                                <div class="d-flex flex-column flex-grow-1 mr-2">
                                    <a class="font-weight-bold text-dark-75 font-size-lg mb-1">Enter your message</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" rows='5' name='text' required></textarea>
                            </div>
                            <div class="d-flex align-items-center mb-3 bg-light-success rounded p-5">
                                <span class="svg-icon svg-icon-warning mr-5">
                                    <i class="text-success fab fa-linkedin-in"></i>
                                </span>
                                <div class="d-flex flex-column flex-grow-1 mr-2">
                                    <a class="font-weight-bold text-dark-75 font-size-lg mb-1">Choose Socials</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="checkbox-list">
                                    <label class="checkbox" data-container="body" data-toggle="popover" data-placement="left">
                                        <input type="checkbox" name="social[]" value="0"/>
                                        <span></span>
                                        Twitter <i class="fab fa-twitter text-primary"></i>
                                    </label>
                                    <label class="checkbox" data-container="body" data-toggle="popover" data-placement="left">
                                        <input type="checkbox" name="social[]" value="1"/>
                                        <span></span>
                                        Facebook <i class="fab fa-facebook-f text-primary"></i>
                                    </label>
                                    <label class="checkbox" data-container="body" data-toggle="popover" data-placement="left">
                                        <input type="checkbox" name="social[]" value="2"/>
                                        <span></span>
                                        LinkedIn <i class="fab fa-linkedin-in text-primary"></i>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3 bg-light-success rounded p-5">
                                <span class="svg-icon svg-icon-warning mr-5">
                                    <i class="text-success far fa-image"></i>
                                </span>
                                <div class="d-flex flex-column flex-grow-1 mr-2">
                                    <a class="font-weight-bold text-dark-75 font-size-lg mb-1">Select One image to deliver</a>
                                </div>
                            </div>
                            <div class="form-group row ads-list"></div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-danger btn-lg" type="submit">Post</button>
                        </div>
                    </form>
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
<script>
    $(document).ready(function(){
        $('.select2').select2({
            placeholder: "Select a Business Name"
        });
        <?php
        if(session('level')<2){
        ?>
        var business_name = "<?php echo session('business_name')?>";
        get_ads(business_name);
        <?php }
        else{
        ?>
        $("#business_name").on('change', function(){
            get_ads($(this).val());
        })
        <?php }?>
        function get_ads(business_name){
            $.ajax({
                type : "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : {
                    business_name : business_name
                },
                url : '/get_ad_byid',
                success : function(res){
                    var html = "";
                    $(".ads-list")[0].innerHTML = "";
                    for(var i = 0; i < res.length; i++){
                        html += '<div class="col-md-3 d-flex mt-4">'+
                                '<div class="m-auto">'+
                                    '<label class="radio radio-outline radio-danger">'+
                                        '<input type="radio" name="img[]" value="'+res[i]['id']+'"/>'+
                                        '<span></span>'+
                                    '</label>'+
                                '</div>'+
                                '<div class="symbol symbol-150 symbol-2by3 flex-shrink-0">'+
                                    '<div class="symbol-label" style="background-image: url(/upload/'+res[i]["img_url"]+')"></div>'+
                                '</div>'+
                            '</div>';
                    }
                    $(".ads-list").append(html);
                    $(".symbol").click(function(){
                        $(this).parent().find('input').prop('checked')==true?$(this).parent().find('input').prop('checked', false):$(this).parent().find('input').prop('checked', true)
                    })
                }
            });
        }
        $("#frmPost").submit(function(event){
            event.preventDefault();
            var fs = new FormData(document.getElementById("frmPost"));
            fs.append('business_name', business_name)
            <?php
            if(session('level') >= 2){
            ?>
            fs.append('business_name',  $("#business_name").val())
            <?php }?>
            KTApp.blockPage();
            $.ajax({
                url : "/post-social",
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
                        location.href="/social-posts";
                    }
                    else{
                        toastr.error(res);
                    }
                },
                error : function(err){
                    toastr.error("Please refresh your browser");
                    KTApp.unblockPage();
                }
            })
        })
    })
</script>