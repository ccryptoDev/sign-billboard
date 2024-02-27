@include('admin.include.admin-header')
<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css" />
<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css" />                    
<style>
    .jsgrid-header-row{
        height : 60px;
    }
    .custom-file-label{
        overflow : hidden;
    }
    /* .custom-file-label::after{
        width : 100%;
    }
    .custom-file-input:lang(en) ~ .custom-file-label::after {
        content: "Click to browse for your image"; 
    } */
    @media(max-width:1360px){
        #temp_body{
            overflow-x : scroll !important;
        }
        /* #t_bus_name{
            margin : 0px !important;
            width : 100% !important;
        } */
    }
    @media(max-width:768px){
        #t_bus_name_b{
            margin : 0px !important;
            width : 100% !important;
        }
        #t_bus_name_c{
            margin : 0px !important;
            width : 85% !important;
        }
        .card.card-custom > .card-header .card-toolbar{
            margin : 0.3rem 0px !important;
            width : 100% !important;
        }
    }
</style>
	
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader min-h-lg-15px pt-5 pb-7 subheader-transparent" id="kt_subheader">
    </div>
    <!--end::Subheader-->
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Row-->
            <div class="row">
                <div class="col-lg-12">
                    <!--begin::Example-->
                    <!--begin::Card-->
                    <div class="card card-custom" data-card="true" id="kt_card_1">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">{{$page_name}} - {{session("business_name")}}</h3>
                            </div>
                            <div class="card-toolbar" style="margin:0 auto">
                                <div class="form-group" style="margin-bottom:0px;margin:0 auto;min-width:150px" id="t_bus_name_b">
                                    <select class="form-control selectpicker" id="t_bus_name" title="Business Name" data-live-search="true" data-size="5">
                                        <?php foreach($business_name as $bus_temp){?>
                                        <option value="{{$bus_temp->business_name}}">{{$bus_temp->business_name}}</option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="card-toolbar">
                                <div class="form-group" style="margin-bottom:0px;margin:0 auto;min-width:200px" id="t_bus_name_c">
                                    <select class="form-control selectpicker" id="t_temp_name" title="Select Template Name" data-live-search="true" data-size="5">
                                        
                                    </select>
                                </div>
                                <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" title="Toggle Card">
                                    <i class="ki ki-arrow-down icon-nm"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="template_form">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="d-flex align-items-center mb-9 bg-light-success rounded p-5">
                                            <span class="svg-icon svg-icon-warning mr-5">
                                                <i class="fa far fa-clipboard"></i>
                                            </span>
                                            <div class="d-flex flex-column flex-grow-1 mr-2">
                                                <a class="font-weight-bold text-dark-75 font-size-lg mb-1">Template</a>
                                            </div>
                                        </div>
                                        <div class="row" style="margin:0px">
                                            <div class="form-group" style="position:relative;width:576px;margin:auto;overflow:hidden" id="temp_body">
                                                <a>
                                                    <div class="" style="background-image : url('/blank_Template.png');width:576px;height:384px;margin:0 auto;background-size:100%100%" id="dis_img">
                                                        <img id="dis_overimg" src="/blank_overlay.png" width="60" height="60" style="position:absolute;margin-top:50px"/>
                                                        <div><span style="position:absolute;z-index:1;text-align:center;position: absolute;left: 0px;color: rgb(0, 0, 0);cursor: pointer;font-size: 20px;text-align: center;margin-right: 0px;font-weight: 300;right: 0px;" contenteditable="true" id="dis_font">Your text is displayed here</span></div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center mb-9 bg-light-success rounded p-5">
                                            <span class="svg-icon svg-icon-warning mr-5">
                                                <i class="fa fa-image"></i>
                                            </span>
                                            <div class="d-flex flex-column flex-grow-1 mr-2">
                                                <a class="font-weight-bold text-dark-75 font-size-lg mb-1">Select Background Image</a>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <!-- <label>Background Image</label> -->
                                            <div></div>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="bg_img" name="bg_img">
                                                <label class="custom-file-label" for="ch_img">Background Image</label>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center mb-9 bg-light-success rounded p-5">
                                            <span class="svg-icon svg-icon-warning mr-5">
                                                <i class="fa fa-image"></i>
                                            </span>
                                            <div class="d-flex flex-column flex-grow-1 mr-2">
                                                <a class="font-weight-bold text-dark-75 font-size-lg mb-1">Set Overlay Image Controls</a>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <!-- <label>Overlay Image</label> -->
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="overlay_img" name="overlay_img">
                                                <label class="custom-file-label" for="overlay_img">Overlay Image</label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-6">
                                                <label>Image Width</label>
                                                <input type="number" id="over_w" name="over_w" class="form-control form-control-sm" value="60" min="30" placeholder="Image Width">
                                            </div>
                                            <div class="col-6">
                                                <label>Image Height</label>
                                                <input type="number" id="over_h" name="over_h" class="form-control form-control-sm" value="60" min="30" placeholder="Image Height">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-6">
                                                <label>Set Left Margin</label>
                                                <input type="number" id="over_l" name="over_l" class="form-control form-control-sm" value="0" placeholder="Set Left Margin">
                                            </div>
                                            <div class="col-6">
                                                <label>Set Top Margin</label>
                                                <input type="number" id="over_t" name="over_t" class="form-control form-control-sm" value="50" placeholder="Set Top Margin">
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-9 bg-light-success rounded p-5">
                                            <span class="svg-icon svg-icon-warning mr-5">
                                                <i class="fa fa-font"></i>
                                            </span>
                                            <div class="d-flex flex-column flex-grow-1 mr-2">
                                                <a class="font-weight-bold text-dark-75 font-size-lg mb-1">Set Text Controls</a>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-6">
                                                <label>Font Size</label>
                                                <input type="number" id="font_s" name="font_s" value="12" class="form-control form-control-sm" placeholder="Large input">
                                            </div>
                                            <div class="col-6">
                                                <label>Font Weight</label>
                                                <input type="number" id="font_w" name="font_w" value="400" class="form-control form-control-sm" placeholder="Large input" step="100">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-6">
                                                <label>Font Color</label>
                                                <input type="color" id="font_c" name="font_c" class="form-control form-control-sm" placeholder="Font Color">
                                            </div>
                                            <div class="col-6">
                                                <label>Set Top Margin</label>
                                                <input type="number" id="font_t" name="font_t" value="0" class="form-control form-control-sm" placeholder="Set Top Margin">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-6">
                                                <label>Set Left Margin</label>
                                                <input type="number" id="font_l" name="font_l" value="0" class="form-control form-control-sm" placeholder="Set Left Margin">
                                            </div>
                                            <div class="col-6">
                                                <label>Set Right Margin</label>
                                                <input type="number" id="font_r" name="font_r" value="0" class="form-control form-control-sm" placeholder="Set Right Margin">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-6">
                                                <label>Alignment</label>
                                                <select class="form-control selectpicker" id="font_align" name="font_align">
                                                    <option>Left</option>
                                                    <option selected>Center</option>
                                                    <option>Right</option>
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <label>Set Number of Text</label>
                                                <input type="number" id="t_limit" name="t_limit" value="45" class="form-control form-control-sm" placeholder="Set Number of Text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-12">
                                                <label class="checkbox checkbox-success">
                                                    <input type="checkbox" checked name="dis_text" id="dis_text"/>
                                                    <span></span>
                                                    Require Text
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-6">
                                                <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#create_modal">Create</button>
                                            </div>
                                            <div class="col-6">
                                                <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#update_modal">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card card-custom" data-card="true" id="kt_card_2" style="margin-top:10px">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">Templates List</h3>
                            </div>
                            <div class="card-toolbar">
                                <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" title="Toggle Card">
                                    <i class="ki ki-arrow-down icon-nm"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="basicScenario"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
<div class="modal fade" id="create_modal" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Template</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="create_temp">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Input Template Name</label>
                        <input type="text" class="form-control" name="temp_name" id="temp_name" required>
                    </div>
                    <div class="form-group">
                        <label>Business Name</label>
                        <input type="input" disabled class="form-control" id="bus_name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="c_modal" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary font-weight-bold" id="save_temp">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="update_modal" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Template</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="update_temp">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Input Template Name</label>
                        <input type="text" class="form-control" name="temp_name" id="utemp_name" required>
                    </div>
                    <div class="form-group">
                        <label>Business Name</label>
                        <input type="input" disabled class="form-control" id="ubus_name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="uc_modal" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
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
<!-- <script src="/assets/js/pages/crud/forms/validation/form-controls.js"></script> -->
<script src="/assets/js/scripts.bundle.js"></script>
<script src="/assets/js/pages/custom/user/edit-user.js?v=7.0.4"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js"></script>

<script>
    var dis_loc = "";
    var update_id = "";
    var business_name = "";
    $("#dis_font").keypress(function(){
        if($(this).text().length > $("#t_limit").val()){
            return false;
        }
    })
    // Select Business name and template id
    $("#t_bus_name").on("change",function(){
        $("#bus_name").val($(this).val());
        $("#ubus_name").val($(this).val());
        
        business_name = $(this).val();
        $("#basicScenario").jsGrid("loadData");
        $.ajax({
            url : "get_temp_name",
            type : "POST",
            data : {
                business_name : $(this).val()
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : function(res){
                $("#t_temp_name")[0].innerHTML = "";
                var temp_list = "";
                for(var i =0 ; i < res.length; i++){
                    temp_list +="<option value="+res[i]['id']+">"+res[i]['template_name']+"</option>";
                }
                $("#t_temp_name").append(temp_list);
                $('#t_temp_name').selectpicker('refresh');
            }
        })
    })
    $("#t_temp_name").on("change",function(){
        $.ajax({
            url : "get_template_byid",
            type : "POST",
            data : {
                id : $(this).val()
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : function(res){
                update_id = res[0]['id'];
                $("#dis_img").css("backgroundImage",'url("/upload/'+res[0]['bg_img']+'")');
                if(res[0]['over_img'] != null){
                    $("#dis_overimg").attr('src', '/upload/'+res[0]['over_img']);
                }
                else{
                    $("#dis_overimg").attr('src', '/blank_overlay.png');
                }
                $("#over_w").val(res[0]['over_w']);
                $("#over_h").val(res[0]['over_h']);
                $("#over_l").val(res[0]['over_l']);
                $("#over_t").val(res[0]['over_t']);
                $("#font_s").val(res[0]['font_s']);
                $("#font_w").val(res[0]['font_w']);
                $("#font_c").val(res[0]['font_c']);
                $("#font_r").val(res[0]['font_r']);
                $("#font_t").val(res[0]['font_t']);
                $("#font_l").val(res[0]['font_l']);
                $("#t_limit").val(res[0]['t_limit']);
                $("#font_align").val(res[0]['align']).trigger('change');

                $("#dis_overimg").css("marginLeft",res[0]['over_l']);
                $("#dis_overimg").css("marginTop",res[0]['over_t']);
                $("#dis_overimg").width(res[0]['over_w']);
                $("#dis_overimg").height(res[0]['over_h']);

                $("#dis_font").css("marginLeft",res[0]['font_l']);
                $("#dis_font").css("marginTop",res[0]['font_t']);
                $("#dis_font").css("marginRight",res[0]['font_r']);
                $("#dis_font").css("fontSize",res[0]['font_s']);
                $("#dis_font").css("fontWeight",res[0]['font_w']);
                $("#dis_font").css("color",res[0]['font_c']);

                if(res[0]['dis_text'] == "0"){
                    $("#dis_text").prop("checked",true);
                }
                if(res[0]['dis_text'] == "1"){
                    $("#dis_text").prop("checked",false);
                }
                // var temp_loc = res[0]['location'].split(",");
                // $("#location_list").find("input").each(function(){
                //     $(this).prop("checked",false);
                // })
                // for(var i = 0; i < temp_loc.length; i++){
                //     $("#location_list").find("input").each(function(){
                //         if(temp_loc[i] == $(this).parent().text().trim()){
                //             $(this).prop('checked',"checked");
                //         }
                //     })
                // }
                $("#dis_location").val(res[0]['location']);
                $("#dis_buss").val(res[0]['business_name']);

                $("#utemp_name").val(res[0]['template_name']);
                $("#ubus_name").val(res[0]['business_name']).trigger("change");
                dis_loc = res[0]['location'];
            }
        })
    })
    // END OF SELECT
    // Create and Update
    function dis_location_error(){
        toastr.error("Please Select Location(s)!");
    }
    $("#create_temp").submit(function(event){
        event.preventDefault();
        if($("#bg_img").val() == ""){
            $("#c_modal").click();
            toastr.error("Please Input Background Image!");
            $("#bg_img").focus();
            return;
        }
        // if(dis_loc == ""){
        //     $("#c_modal").click();
        //     dis_location_error();
        //     return;
        // }
        var fs = new FormData(document.getElementById("template_form"));
        fs.append("temp_name",$("#temp_name").val());
        fs.append("business_name",$("#t_bus_name").val());
        // fs.append("location",dis_loc);
        $("#save_temp")[0].className= 'btn btn-outline-success spinner spinner-darker-success spinner-left mr-3';
        $("#save_temp").attr('disabled', true);
        $.ajax({
            url : 'create_temp',
            data : fs,
            contentType : false,
            processData : false,
            type : "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : function(res){
                $("#save_temp")[0].className = "btn btn-primary font-weight-bold";                        
                $("#save_temp").removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                if(res == "success"){
                    Swal.fire("Success!", "You created template!", "success");
                    $("#c_modal").click();
                    update_id = "";
                    $("#basicScenario").jsGrid("loadData");
                    setTimeout(function(){
                        location.reload();
                    },1000)
                }
                else{
                    Swal.fire("Fail!", "Please try again!", "error");
                }
            },
            error : function(res){
                Swal.fire("Fail!", "Please try again!", "error");
                setTimeout(function(){
                    location.reload();
                },1000);
            }
        })
    })
    $("#update_temp").submit(function(event){
        event.preventDefault();
        if(update_id == ""){
            $("#uc_modal").click();
            toastr.error("Please Select Template in Templates!");
            return;
        }
        // if(dis_loc == ""){
        //     $("#uc_modal").click();
        //     dis_location_error();
        //     return;
        // }
        var fs = new FormData(document.getElementById("template_form"));
        fs.append("temp_name",$("#utemp_name").val());
        fs.append("business_name",$("#t_bus_name").val());
        fs.append("location",dis_loc);
        fs.append("update_id",update_id);
        $.ajax({
            url : 'update_temp',
            data : fs,
            contentType : false,
            processData : false,
            type : "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : function(res){
                if(res == "success"){
                    Swal.fire("Success!", "You updated template!", "success");
                    $("#uc_modal").click();
                    update_id = "";
                    setTimeout(function(){
                        location.reload();
                    },1500);
                    $("#basicScenario").jsGrid("loadData");
                }
                else{
                    Swal.fire("Fail!", "Please try again!", "error");
                }
            },
            error : function(res){
                Swal.fire("Fail!", "Please try again!", "error");
                setTimeout(function(){
                    location.reload();
                },1000);
            }
        })
    })
    // END OF Crate and Update
    var temp_width = "";
    var temp_height = "";
    var temp_ratio = "";
    // $("#location_list").find("input").each(function(){
    //     $(this).on("change",function(){
    //         dis_loc = "";
    //         if($(this).prop("checked")==true){
    //             if(temp_ratio == "" || temp_ratio==$(this).parent().next().attr("t_width")/$(this).parent().next().attr("t_height")){
    //                 temp_ratio = $(this).parent().next().attr("t_width")/$(this).parent().next().attr("t_height");
    //                 if(temp_width < $(this).parent().next().attr("t_width")){
    //                     temp_width = $(this).parent().next().attr("t_width");
    //                     temp_height = $(this).parent().next().attr("t_height");
    //                 }
    //                 $("#dis_img").width(temp_width);
    //                 $("#dis_img").height(temp_height);
    //                 $("#temp_body").width(temp_width);
    //                 $("#temp_body").height(temp_height);
    //             }
    //             else{
    //                 toastr.options = {
    //                     "closeButton": false,
    //                     "debug": false,
    //                     "newestOnTop": false,
    //                     "progressBar": false,
    //                     "positionClass": "toast-top-right",
    //                     "preventDuplicates": false,
    //                     "onclick": null,
    //                     "showDuration": "1000",
    //                     "hideDuration": "1000",
    //                     "timeOut": "5000",
    //                     "extendedTimeOut": "1000",
    //                     "showEasing": "swing",
    //                     "hideEasing": "linear",
    //                     "showMethod": "fadeIn",
    //                     "hideMethod": "fadeOut"
    //                 };
    //                 toastr.error("Please Select Another Location(s)!");
    //                 $(this).prop("checked",false);
    //             }
    //             // console.log($(this).parent().parent().find(".size"));
    //         }
    //         var count_false = 0;
    //         $("#location_list").find("input").each(function(){
    //             if($(this).prop("checked") == true){
    //                 count_false ++;
    //             }
    //             dis_loc += $(this).prop("checked")==true?$(this).parent().text().trim()+",":"";
    //         })
    //         if(count_false == 0){
    //             temp_width =0;
    //             temp_height =0;
    //         }
    //         $("#dis_location").val(dis_loc);
    //     })
    // })
    $("#bg_img").on("change",function(){
        var _URL = window.URL;
        var file, img;
        if ((file = this.files[0])) {
            img = new Image();
            img.onload = function () {
                
            };
        }
        $("#dis_img").css("background-image","url("+_URL.createObjectURL(file)+")");
        // $("#dis_img")[0].src  = _URL.createObjectURL(file);
    });
    $("#over_w").on("change",function(){
        $("#dis_overimg").width($(this).val());
    })
    $("#over_h").on("change",function(){
        $("#dis_overimg").height($(this).val());
    })
    $("#over_l").on("change",function(){
        $("#dis_overimg").css("marginLeft",$(this).val()+"px");
    })
    $("#over_t").on("change",function(){
        $("#dis_overimg").css("marginTop",$(this).val()+"px");
    })
    // FONT
    $("#font_s").on("change",function(){
        $("#dis_font").css("fontSize",$(this).val()+"px");
    })
    $("#font_w").on("change",function(){
        $("#dis_font").css("fontWeight",$(this).val());
    })
    $("#font_c").on("change",function(){
        $("#dis_font").css("color",$(this).val());
    })
    $("#font_l").on("change",function(){
        $("#dis_font").css("marginLeft",$(this).val()+"px");
    })
    $("#font_t").on("change",function(){
        $("#dis_font").css("marginTop",$(this).val()+"px");
    })
    $("#font_r").on("change",function(){
        $("#dis_font").css("marginRight",$(this).val()+"px");
    })
    $("#font_align").on("change",function(){
        $("#dis_font").css("textAlign",$(this).val());
    })
    // END OF FONT
    $("#overlay_img").on("change",function(){
        var _URL = window.URL;
        var file, img;
        if ((file = this.files[0])) {
            img = new Image();
            img.onload = function () {
                
            };
        }
        // $("#dis_overimg").css("background-image","url("+_URL.createObjectURL(file)+")");
        $("#dis_overimg")[0].src  = _URL.createObjectURL(file);
    });
    // $("#dis_overimg").draggable();
    $("#basicScenario").jsGrid({
        width: "100%",
        // filtering: true,
        editing: false,
        inserting: false,
        sorting: true,
        paging: true,
        autoload: true,
        pageSize: 20,
        selecting: true,

        pageButtonCount: 5,
        deleteConfirm: "Do you really want to delete?",
        rowClick: function(args) { 
            // user_id = args.item.id;
            if(args.item.id == 0){
                swal.fire({
                    "title": "Fail",
                    "text": "You can't update it",
                    "type": "error",
                    "confirmButtonClass": "btn btn-secondary"
                });
                return false;
            }
        },
        rowDoubleClick : function(args){
            update_id = args.item.id;
            $("#dis_img").css("backgroundImage",'url("/upload/'+args.item.bg_img+'")');
            if(args.item.over_img != null){
                $("#dis_overimg").attr('src', '/upload/'+args.item.over_img);
            }
            else{
                $("#dis_overimg").attr('src', '/blank_overlay.png');
            }
            $("#over_w").val(args.item.over_w);
            $("#over_h").val(args.item.over_h);
            $("#over_l").val(args.item.over_l);
            $("#over_t").val(args.item.over_t);
            $("#font_s").val(args.item.font_s);
            $("#font_w").val(args.item.font_w);
            $("#font_c").val(args.item.font_c);
            $("#font_r").val(args.item.font_t);
            $("#font_t").val(args.item.font_t);
            $("#font_l").val(args.item.font_l);
            $("#t_limit").val(args.item.t_limit);
            $("#font_align").val(args.item.align).trigger('change');


            $("#dis_overimg").css("marginLeft",args.item.over_l);
            $("#dis_overimg").css("marginTop",args.item.over_t);
            $("#dis_overimg").width(args.item.over_w);
            $("#dis_overimg").height(args.item.over_h);

            $("#dis_font").css("marginLeft",args.item.font_l);
            $("#dis_font").css("marginTop",args.item.font_t);
            $("#dis_font").css("marginRight",args.item.font_r);
            $("#dis_font").css("fontSize",args.item.font_s);
            $("#dis_font").css("fontWeight",args.item.font_w);
            $("#dis_font").css("color",args.item.font_c);
            
            if(args.item.dis_text == "0"){
                $("#dis_text").prop("checked",true);
            }
            if(args.item.dis_text == "1"){
                $("#dis_text").prop("checked",false);
            }

            // var temp_loc = args.item.location.split(",");
            // $("#location_list").find("input").each(function(){
            //     $(this).prop("checked",false);
            // })
            // for(var i = 0; i < temp_loc.length; i++){
            //     $("#location_list").find("input").each(function(){
            //         if(temp_loc[i] == $(this).parent().text().trim()){
            //             $(this).prop('checked',"checked");
            //         }
            //     })
            // }
            // $("#dis_location").val(args.item.location);
            // $("#dis_buss").val(args.item.business_name);

            $("#utemp_name").val(args.item.template_name);
            $("#ubus_name").val(args.item.business_name).trigger("change");
            dis_loc = args.item.location;
        },
        controller: {
            loadData : function(filter){
                return $.ajax({
                    type : "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data : {
                        business_name : business_name
                    },
                    url : '/get_temp_manage',
                    success : function(res){                           
                    }
                });
            },
            deleteItem : function(item)
            {
                return $.ajax({
                    type : "POST",
                    url : 'delete_template',
                    data : item,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success : function(res){
                        if(res == "success"){
                            Swal.fire("Success!", "You deleted template!", "success");
                            // $("#basicScenario").jsGrid("loadData");
                            setTimeout(function(){
                                location.reload();
                            },1000)
                        }
                        else{
                            Swal.fire("Fail!", "Please try again!", "error");
                        }
                    },
                    error : function(res){
                        Swal.fire("Fail!", "Please try again!", "error");
                        setTimeout(function(){
                            location.reload();
                        },1000);
                    }
                });
            },

            updateItem : function(item)
            {
                $.ajax({
                    type : "UPDATE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type : "PUT",
                    url : '/update_status',
                    data : item,
                    success : function(res){
                        $("#basicScenario").jsGrid("loadData");
                    }
                });
            }
        },
        fields: [
            { name : "id" ,visible :false},
            { title: "Background Image", name: "bg_img", type: "text", width: "250px",
                itemTemplate: function(val, item) {
                    return ("<img src='/upload/"+val+"' width='250' height='150'>");
                },
                insertTemplate: function() {
                    var insertControl = this.insertControl = $("<input>").prop("type", "file");
                    return insertControl;
                },
                editoptions : function(){
                    value 
                },
                insertValue: function() {
                    return this.insertControl[0].files[0]; 
                },
                align: "center"
            },
            { title: "Business Name", name: "business_name", type: "text", width: "150px",align: "center"},
            { title: "Template Name", name: "template_name", type: "text", width: "150px",align: "center"},
            { title : "EM", name : "location", width:"100px",visible :false,
                itemTemplate: function(val, item) {
                    if(val.match("Emergency Broadcast Only")){
                        return ("<input type='checkbox' checked>");
                    }
                    else{
                        return ("<input type='checkbox'>");
                    }
                },
                insertTemplate: function() {
                    var insertControl = this.insertControl = $("<input>").prop("type", "file");
                    return insertControl;
                },
                editoptions : function(){
                    value 
                },
                <?php
                    if(session('level') == '1'){
                ?>
                visible : false,
                <?php }?>
                insertValue: function() {
                    return this.insertControl[0].files[0]; 
                },
                align: "center"
            },
            { title : "Primary", name : "primary", width:"100px",
                itemTemplate: function(val, item) {
                    if(val == 1){
                        return ("<input type='checkbox' checked>");
                    }
                    else{
                        return ("<input type='checkbox'>");
                    }
                },
                insertTemplate: function() {
                    var insertControl = this.insertControl = $("<input>").prop("type", "file");
                    return insertControl;
                },
                editoptions : function(){
                    value 
                },
                <?php
                    if(session('level') == '1'){
                ?>
                visible : false,
                <?php }?>
                insertValue: function() {
                    return this.insertControl[0].files[0]; 
                },
                align: "center"
            },
            { name : "bg_img" ,visible :false},
            { name : "over_img" ,visible :false},
            { name : "over_w" ,visible :false},
            { name : "over_w" ,visible :false},
            { name : "over_t" ,visible :false},
            { name : "over_l" ,visible :false},
            { name : "font_s" ,visible :false},
            { name : "font_w" ,visible :false},
            { name : "font_t" ,visible :false},
            { name : "font_l" ,visible :false},
            { name : "font_r" ,visible :false},
            { name : "font_c" ,visible :false},
            { name : "align" ,visible :false},
            { name : "t_limit" ,visible :false},
            { name : "dis_text" ,visible :false},
            { type: "control",
                <?php
                    if(session('level') == '1'){
                ?>
                visible : false,
                <?php }?>
                editButton :false }
        ]
    });
</script>
		