@include('admin.include.admin-header')
<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css" />
<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css" />                    
<style>
    .jsgrid-header-row{
        height : 60px;
    }
    .jsgrid-filter-row>.jsgrid-cell:first-child, .jsgrid-header-row>.jsgrid-header-cell:first-child, .jsgrid-insert-row>.jsgrid-cell:first-child{
        background : #c1bdb9;
    }
    .jsgrid-grid-body .jsgrid-cell:first-child{
        background : #c1bdb9;
    }
    /* #location_list span{
        display : block;
    } */
</style>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader min-h-lg-15px pt-5 pb-7 subheader-transparent" id="kt_subheader">
    </div>
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="alert alert-custom alert-white alert-shadow fade show gutter-b" role="alert">
                <div class="alert-icon">
                    <span class="svg-icon svg-icon-primary svg-icon-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"/>
                                <path d="M7.07744993,12.3040451 C7.72444571,13.0716094 8.54044565,13.6920474 9.46808594,14.1079953 L5,23 L4.5,18 L7.07744993,12.3040451 Z M14.5865511,14.2597864 C15.5319561,13.9019016 16.375416,13.3366121 17.0614026,12.6194459 L19.5,18 L19,23 L14.5865511,14.2597864 Z M12,3.55271368e-14 C12.8284271,3.53749572e-14 13.5,0.671572875 13.5,1.5 L13.5,4 L10.5,4 L10.5,1.5 C10.5,0.671572875 11.1715729,3.56793164e-14 12,3.55271368e-14 Z" fill="#000000" opacity="0.3"/>
                                <path d="M12,10 C13.1045695,10 14,9.1045695 14,8 C14,6.8954305 13.1045695,6 12,6 C10.8954305,6 10,6.8954305 10,8 C10,9.1045695 10.8954305,10 12,10 Z M12,13 C9.23857625,13 7,10.7614237 7,8 C7,5.23857625 9.23857625,3 12,3 C14.7614237,3 17,5.23857625 17,8 C17,10.7614237 14.7614237,13 12,13 Z" fill="#000000" fill-rule="nonzero"/>
                            </g>
                        </svg>
                    </span>
                </div>
                <div class="alert-text">
                    <ul>
                        <li><h4>All Ads you created are listed here.</h4></li>
                        <li><h4>Decide which Ads you want on the Billboard(s) by left hand column of check boxes, then click 'Publish Playlist'.</h4></li>
                        <li><h4>Ads will be displayed according to their individual schedule and your Campaign schedule. </h4></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <!--begin::Example-->
                    <!--begin::Card-->
                    <?php
                    $get_temp = false;
                    ?>
                    <div class="card card-custom" data-card="true" id="kt_card_1">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label" style="display:block">{{$page_name}} - {{session("business_name")}}</h3>
                                <span class="svg-icon svg-icon-primary svg-icon-2x" data-toggle="modal" data-target="#FaqModal" title="FAQs">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
                                            <path d="M12,16 C12.5522847,16 13,16.4477153 13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 C11,16.4477153 11.4477153,16 12,16 Z M10.591,14.868 L10.591,13.209 L11.851,13.209 C13.447,13.209 14.602,11.991 14.602,10.395 C14.602,8.799 13.447,7.581 11.851,7.581 C10.234,7.581 9.121,8.799 9.121,10.395 L7.336,10.395 C7.336,7.875 9.31,5.922 11.851,5.922 C14.392,5.922 16.387,7.875 16.387,10.395 C16.387,12.915 14.392,14.868 11.851,14.868 L10.591,14.868 Z" fill="#000000"/>
                                        </g>
                                    </svg>
                                </span>
                            </div>
                            <?php if(session('level') >= 2){?>
                            <div class="card-toolbar" style="margin:0 auto">
                                <div class="form-group" style="margin-bottom:0px;margin:0 auto;min-width:150px">
                                    <select class="form-control selectpicker" id="t_bus_name" title="Business Name" data-live-search="true" data-size="10">
                                        <?php foreach($business_name as $bus_temp){?>
                                        <option value="{{$bus_temp->business_name}}">{{$bus_temp->business_name}}</option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <?php }?>
                            <?php 
                            if(session('level') !=2 && count($multi) > 1){
                                $get_temp = true;
                            ?>
                            <div class="card-toolbar" style="margin:0 auto">
                                <div class="form-group" style="margin-bottom:0px;margin:0 auto;min-width:150px">
                                    <select class="form-control selectpicker" id="t_bus_name" title="Business Name" data-live-search="true" data-size="10">
                                        <?php foreach($multi as $bus_temp){
                                            if($bus_temp->multi_id == null){
                                            ?>
                                        <option value="{{$bus_temp->business_name}}">{{$bus_temp->business_name}}</option>
                                        <?php }
                                        else{
                                        ?>
                                        <option value="{{$bus_temp->com_name}}">{{$bus_temp->com_name}}</option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                            <?php }?>
                        </div>
                        <div class="card-body">
                            <div class="mb-5">
                                <span class="mb-5">Control your Playlist by using check boxes, then click 'Publish Playlist'</span>
                            </div>
                            <div id="basicScenario"></div>
                        </div>
                        <div class="card-footer">
                            <button type="button" style="float:right;display:none" class="btn btn-danger font-weight-bold" id="show_modal">Publish Playlist</button>
                            <button type="button" style="" class="btn btn-danger font-weight-bold" id="publish_cm">Publish Playlist</button>
                            <button type="button" id="preview" style="display:none" class="btn btn-danger font-weight-bold" data-target="#preview_modal" data-toggle="modal">Save</button>
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
<div class="modal fade" id="preview_modal" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">PlayList</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="pub_post" style='overflow:scroll;'>
                <div class="modal-body">
                    <span style="text-align:left;display:block">You have saved your active playlist.</span>
                    <ul>
                        <li>If you have an existing campaign set to run today, your Ads are being delivered to the billboards right now.</li>
                        <li>If you have an existing campaign set to run in the future, your Ads will be displayed then.</li>
                    </ul>
                    <div id="dis_section"></div>
                    <div>
                        <div class="form-group">
                            <label class="mt-3">Please select checkbox you want to post</label>
                            <div class="checkbox-list" id="social">
                                <label class="checkbox">
                                    <input type="checkbox" value="face">FaceBook <i class="socicon-facebook text-danger mr-5"></i><span></span>
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox" value="link">Linkedin <i class="socicon-linkedin text-danger mr-5"></i><span></span>
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox" value="twi">Twitter <i class="socicon-twitter text-danger mr-5"></i><span></span>
                                </label>
                            </div>
                            <label class="mt-3">Enter any text you wish to deliver along with the images</label>
                            <textarea class="form-control" name="post_text" id="post_text"></textarea>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a class="btn btn-success" href="/manage-campaign">Create Campaign Now</a> If you have not created a campaign yet, this playlist will not be delivered to the billboards until you create one.
                    </div>
                    <div class="mt-3">
                        <a class="btn btn-info">Post to all Social Media</a> Want to deliver a copy of your Ad to all your social Media at once?  Post an Ad to all our advertiser's social media accounts (including yours).
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="c_modal" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button type="submit" id="save_list" class="btn btn-light-danger font-weight-bold">Send to Social Media</button>
                </div>
            </form>
        </div>
    </div>
</div>
<button type="button" class="btn btn-success btn-block" style="display:none" id="pre_ad_modal" data-toggle="modal" data-target="#preview_mod">Preview Ad</button>
<div class="modal fade" id="preview_mod" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="update_sch">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- <img id="pre_img" style="width:100%"> -->
                    <div class="form-group row" style="margin:0">
                        <input type="number" id="u_id" style="display:none" name="u_id">
                        <div class="col-lg-12">
                            <div class="radio-list">
                                <label class="radio radio-danger">
                                    <input type="radio" name="radio" checked value="ime"> Display Continuously
                                    <span></span>
                                </label>
                                <span class="form-text text-muted">When activated, Ad will be displayed until you manually de-activate it.The Ad will be shown 24 hours a day.</span>
                                <label class="radio radio-danger" style="margin-top:10px">
                                    <input type="radio" name="radio" value="frame"> Select Time Frame
                                    <span></span>
                                </label>
                                <span class="form-text text-muted">Set start date, start time , days of week when you want this displated, end date, and end time to controll when you want this Ad to show.</span>
                            </div>
                        </div>
                        <div class="col-lg-12" id="dis_sch" style="display:none">
                            <div class="form-group row" style="margin:0px">
                                <label for="example-date-input" class="col-form-label">Start Date</label>
                                <div class="col-12">
                                    <input class="form-control" type="date" value="{{date('Y-m-d')}}" id="start_date" name="s_date">
                                </div>
                            </div>
                            <div class="row" style="margin:0px">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label class="col-form-label">Start Time</label>
                                        <div class="col-lg-12">
                                            <select class="form-control selectpicker" id="start_time" name="s_time">
                                                <option>12 AM</option>
                                                <option>1 AM</option>
                                                <option>2 AM</option>
                                                <option>3 AM</option>
                                                <option>4 AM</option>
                                                <option>5 AM</option>
                                                <option>6 AM</option>
                                                <option>7 AM</option>
                                                <option>8 AM</option>
                                                <option>9 AM</option>
                                                <option>10 AM</option>
                                                <option>11 AM</option>
                                                <option>1 PM</option>
                                                <option>2 PM</option>
                                                <option>3 PM</option>
                                                <option>4 PM</option>
                                                <option>5 PM</option>
                                                <option>6 PM</option>
                                                <option>7 PM</option>
                                                <option>8 PM</option>
                                                <option>9 PM</option>
                                                <option>10 PM</option>
                                                <option>11 PM</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label class="col-form-label">End Time</label>
                                        <div class="col-lg-12">
                                            <select class="form-control selectpicker" id="end_time" name="e_time">
                                                <option>12 AM</option>
                                                <option>1 AM</option>
                                                <option>2 AM</option>
                                                <option>3 AM</option>
                                                <option>4 AM</option>
                                                <option>5 AM</option>
                                                <option>6 AM</option>
                                                <option>7 AM</option>
                                                <option>8 AM</option>
                                                <option>9 AM</option>
                                                <option>10 AM</option>
                                                <option>11 AM</option>
                                                <option>1 PM</option>
                                                <option>2 PM</option>
                                                <option>3 PM</option>
                                                <option>4 PM</option>
                                                <option>5 PM</option>
                                                <option>6 PM</option>
                                                <option>7 PM</option>
                                                <option>8 PM</option>
                                                <option>9 PM</option>
                                                <option>10 PM</option>
                                                <option>11 PM</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Days of Week</label>
                                <div class="checkbox-inline" id="days" style="margin-left:12.5px">
                                    <label class="checkbox checkbox-primary">
                                        <input type="checkbox" checked="checked" value="0"> M
                                        <span></span>
                                    </label>
                                    <label class="checkbox checkbox-primary">
                                        <input type="checkbox" checked="checked" value="1"> T
                                        <span></span>
                                    </label>
                                    <label class="checkbox checkbox-primary">
                                        <input type="checkbox" checked="checked" value="2"> W
                                        <span></span>
                                    </label>
                                    <label class="checkbox checkbox-primary">
                                        <input type="checkbox" checked="checked" value="3"> T
                                        <span></span>
                                    </label>
                                    <label class="checkbox checkbox-primary">
                                        <input type="checkbox" checked="checked" value="4"> F
                                        <span></span>
                                    </label>
                                    <label class="checkbox checkbox-primary">
                                        <input type="checkbox" checked="checked" value="5"> S
                                        <span></span>
                                    </label>
                                    <label class="checkbox checkbox-primary">
                                        <input type="checkbox" checked="checked" value="6"> S
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="row" style="margin:0px">
                                <div class="col-6">
                                    <label class="col-form-label">Option 1</label>
                                    <!-- <div class="form-group">
                                        <label class="checkbox">
                                            <input type="checkbox" checked="checked" id="no_end" name="no_end"/> No End Date
                                            <span></span>
                                        </label>
                                    </div> -->
                                    <div class="radio-list" id="no_end">
                                        <label class="radio">
                                            <input type="radio" name="no_end" value="0"/>
                                            <span></span>
                                            End Date
                                        </label>
                                        <label class="radio">
                                            <input type="radio" checked="checked" name="no_end" value="1"/>
                                            <span></span>
                                            No End Date
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label class="col-form-label">Option 2 (End Date)</label>
                                    <div class="form-group row">
                                        <input class="form-control" type="date" value="{{date('Y-m-d')}}" min="{{date('Y-m-d')}}" id="end_date" name="e_date">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-light-danger font-weight-bold" id="u_sch">Update</button>
                    <button type="button" class="btn btn-light-primary font-weight-bold" id="c_sch" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
@include("admin.include.admin-footer")

<script>var HOST_URL = "https://keenthemes.com/metronic/tools/preview";</script>
<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
<script src="/assets/plugins/global/plugins.bundle.js"></script>
<script src="/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
<!-- <script src="/assets/js/pages/crud/forms/validation/form-controls.js"></script> -->
<script src="/js/suggest.js"></script>
<script src="/assets/js/scripts.bundle.js"></script>
<script src="/assets/js/pages/custom/user/edit-user.js?v=7.0.4"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js"></script>
<script type="text/javascript" src="/html2canvas-master/dist/html2canvas.js"></script>

<script>
    var loc_num = 0;
    var location_list = "";
    var over_change = false;
    var business_name = "";
    var post_id = "";
    var day_plan = 0;

    $("#update_sch").submit(function(event) {
        event.preventDefault();
        var fs = new FormData($("#update_sch")[0]);
        var days = "";
        $("#days").find("input").each(function(){
            if($(this).prop("checked") == true){
                days += $(this).val()+",";
            }
        })
        fs.append("days", days);
        $("#u_sch")[0].className= 'btn btn-outline-danger spinner spinner-darker-danger spinner-left mr-3';
        $("#u_sch").attr('disabled', true);
        $.ajax({
            type : "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData : false,
            contentType : false,
            data : fs,
            url : '/update_sch',
            success : function(res){
                $("#u_sch")[0].className = "btn btn-light-danger font-weight-bold";                        
                $("#u_sch").removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                $("#basicScenario").jsGrid("loadData");
                if(res == 'success'){
                    $("#c_sch").click();
                }
            }
        });
    })
    // Select Business name and template id
    $("#t_bus_name").on("change",function(){
        business_name = $(this).val();
        $("#basicScenario").jsGrid("loadData");
    })
    $(".radio-list").find("input").each(function(){
        $(this).on("change", function(){
            if($(this).val() == "ime"){
                $("#dis_sch").css("display","none");
            }
            else{
                $("#dis_sch").css("display","block");
            }
        })
    })
    $("#no_end").on('change',function(){
        $(this).find("input").each(function(){
            if($(this).prop('checked') == true && $(this).val() == 1){
                $("#end_date").attr('disabled', true);
            }
            else{
                $("#end_date").attr('disabled', false);
            }
        })
    })
    <?php
        if(session('level') != 2 && $get_temp == false){
    ?>
        business_name = "<?php echo session("business_name")?>";
        
    <?php
        }
    ?>
    function processing(){
        KTApp.block('#basicScenario', {
            overlayColor: '#000000',
            state: 'danger',
            message: 'Please wait...'
        });
    }
    // END OF 
    // $("#save_list").click(function(){
    $("#pub_post").submit(function(event){
        event.preventDefault();
        var fs = new FormData(document.getElementById("pub_post"));
        var social = "";
        $("#social").find("input").each(function(){
            if($(this).prop('checked') == true){
                social += $(this).val()+",";
            }
        })
        if(social == ""){
            toastr.error("Please Check At least On Socials!");
            return;
        }
        if(social != ""){
            if(post_id == ""){
                toastr.error("Please Check At least On Ad!");
                return;
            }
            if($("#post_text").val() == ""){
                toastr.error("Please Input Text!");
                $("#post_text").focus();
                return;
            }
        }
        $("#save_list")[0].className= 'btn btn-outline-danger spinner spinner-darker-danger spinner-left mr-3';
        $("#save_list").attr('disabled', true);

        if(business_name == "1 Demo"){
            Swal.fire("Success!", "You have published your Playlist, It will be viewed on the billboard within a few minutes!", "success");
            $("#c_modal").click();
            return;
        }
        fs.append("social",social);
        fs.append("post_text",$("#post_text").val());
        fs.append("business_name",business_name);
        fs.append("post_id",post_id);
        $.ajax({
            type : "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : fs,
            processData : false,
            contentType : false,
            url : '/save_list',
            success : function(res){
                $("#save_list")[0].className = "btn btn-light-danger font-weight-bold";                        
                $("#save_list").removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                if(res == "success"){
                    Swal.fire("Success!", "You have published your Playlist, It will be viewed on the billboard within a few minutes!", "success");
                    // $("#basicScenario").jsGrid("loadData");
                    $("#c_modal").click();
                }
                else{
                    Swal.fire("Fail!", res, "error");
                }
            },
            error: function(res){
                $("#save_list")[0].className = "btn btn-light-danger font-weight-bold";
                $("#save_list").removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
            }
        });
    })
    $("#publish_cm").click(function(){
        KTApp.block('#basicScenario', {
            overlayColor: '#000000',
            state: 'danger',
            message: 'Please wait...'
        });
        if(business_name == ""){
            toastr.error("Please Select Business Name!");
            return;
        }
        $("#publish_cm")[0].className= 'btn btn-outline-danger spinner spinner-darker-danger spinner-left mr-3';
        $("#publish_cm").attr('disabled', true);
        if(business_name == "1 Demo"){
            KTApp.unblock('#basicScenario');
            $("#publish_cm")[0].className = "btn btn-light-danger font-weight-bold";                        
            $("#publish_cm").removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
            $("#show_modal").click();
            return;
        }
        $.ajax({
            type : "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : {
                business_name : business_name
            },
            url : '/publish_cm',
            success : function(res){
                KTApp.unblock('#basicScenario');
                $("#publish_cm")[0].className = "btn btn-light-danger font-weight-bold";                        
                $("#publish_cm").removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                if(res == 'success'){
                    $("#show_modal").click();
                }
                else{
                    Swal.fire("Fail!", res, "error");
                }
            },
            error : function(res){
                Swal.fire("Fail!", "Please try again or Contact to support team", "error");
                KTApp.unblock('#basicScenario');
                $("#publish_cm")[0].className = "btn btn-light-danger font-weight-bold";                        
                $("#publish_cm").removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                // setTimeout(function(){
                //     location.reload();
                // },5000);
            }
        });
    })
    $("#show_modal").click(function(){
        if(business_name == ""){
            toastr.error("Please Select Business Name!");
            return;
        }
        $.ajax({
            type : "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : {
                business_name : business_name
            },
            url : '/get_active_ad',
            success : function(res){
                var temp = "";
                $("#dis_section")[0].innerHTML = "";
                for(var i =0 ; i < res.length; i++){
                    // var temp_img_url = '/upload/'+res[i]['img_url'];
                    // console.log(temp_img_url);
                    temp += '<div class="d-flex flex-wrap align-items-center mt-10 mb-10">'+
                                '<div class="symbol symbol-60 symbol-2by3 flex-shrink-0"><label class="checkbox"><input type="checkbox" value='+res[i]['id']+'><span></span></label></div>'+
                                '<div class="symbol symbol-60 symbol-2by3 flex-shrink-0">'+
                                    '<div class="symbol-label" style="background-image: url(\'/upload/'+res[i]['img_url']+'\'")></div>'+
                                '</div>'+
                                '<div class="d-flex flex-column ml-4 flex-grow-1 mr-2">'+
                                    '<a class="text-dark-75 font-weight-bold text-hover-primary font-size-lg mb-1">'+res[i]['location']+'</a>'+
                                '</div>'+
                            '</div>';
                }
                $("#dis_section").append(temp);
                $("#dis_section").find("input").each(function(){
                    post_id = "";
                    $(this).on("change",function(){
                        if($(this).prop("checked") == true){
                            post_id += $(this).val()+",";
                        }
                    })
                })
                $("#preview").click();
            }
        });
    })
    $("#days").find("input").each(function(){
        $(this).on("change",function(){
            var day_check = 0;
            if($(this).prop("checked") == true){
                $("#days").find("input").each(function(){
                    if($(this).prop("checked") == true){
                        day_check ++;
                    }
                })
                if(day_check >2 && day_plan == 1){
                    toastr.error("You can only 2 days");
                    $(this).prop('checked',false);
                    return;
                }
            }
        })
    })
    $("#basicScenario").jsGrid({
        width: "100%",
        // filtering: true,
        editing: false,
        inserting: false,
        sorting: true,
        paging: true,
        autoload: true,
        pageSize: 100,
        selecting: true,

        pageButtonCount: 5,
        deleteConfirm: "Do you really want to delete?",
        rowClick: function(args) { 
            // user_id = args.item.id;
            var playlist_status = 0;
            if($(args.event.target)[0].nodeName == "INPUT"){
                $("#publish_cm")[0].className= 'btn btn-outline-danger spinner spinner-darker-danger spinner-left mr-3';
                $("#publish_cm").attr('disabled', true);
                KTApp.block('#basicScenario', {
                    overlayColor: '#000000',
                    state: 'danger',
                    message: 'Please wait...'
                });
                if($(args.event.target).prop("checked") == true){
                    playlist_status = 1;
                }
                $.ajax({
                    url : 'update_ad_list',
                    type : "POST",
                    data : {
                        id : args.item.id,
                        playlist : playlist_status,
                        business_name : args.item.business_name
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success : function (res){
                        KTApp.unblock('#basicScenario');
                        $("#publish_cm")[0].className= 'btn btn-light-danger font-weight-bold';
                        $("#publish_cm").attr('disabled', false);
                        toastr.success("Success!");
                        // $("#basicScenario").jsGrid("loadData");
                    }
                })
            }
            if($(args.event.target)[0].className == 'fa fa-edit'){
                $('#u_id').val(args.item.id);
                $(".radio-list").find("input").each(function(){
                    if($(this).val() == args.item.schedule){
                        $(this).prop("checked",true);
                    }
                    else{
                        $(this).prop("checked",false);
                    }
                    if(args.item.schedule == "ime"){
                        $("#dis_sch").css("display","none");
                    }
                    if(args.item.schedule != "ime"){
                        $("#dis_sch").css("display","block");
                    }
                })
                var d = new Date(args.item.s_date);
                var sDate = d.getFullYear() + "-" + ((d.getMonth() + 1).toString().padStart(2, "0")) + "-" + d.getDate().toString().padStart(2, "0");
                $("#start_date").val(sDate);
                if(args.item.e_date == "No End date"){
                    // $("#no_end").prop("checked",true);
                    $("#no_end").find("input").each(function(){
                        if($(this).val() == 1){
                            $(this).prop('checked', true);
                        }
                    })
                    $("#end_date").attr('disabled', true);
                }
                if(args.item.e_date != "No End date"){
                    // $("#no_end").prop("checked",false);
                    $("#no_end").find("input").each(function(){
                        if($(this).val() == 0){
                            $(this).prop('checked', true);
                        }
                    })
                    $("#end_date").attr('disabled', false);
                }
                if(args.item.e_date != "No End date"){
                    var d = new Date(args.item.e_date);
                    var eDate = d.getFullYear() + "-" + ((d.getMonth() + 1).toString().padStart(2, "0")) + "-" + d.getDate().toString().padStart(2, "0");
                    $("#end_date").val(eDate);
                }
                $("#start_time").val(args.item.s_time);
                $('#start_time').selectpicker('refresh');
                $("#end_time").val(args.item.e_time);
                $('#end_time').selectpicker('refresh');
                var days_temp = args.item.days;
                var days = days_temp.split(",");
                $("#days").find("input").each(function(){
                    $(this).prop("checked",false);
                })
                for(var i = 0; i < days.length; i++){
                    $("#days").find("input").each(function(){
                        if($(this).val() == days[i]){
                            $(this).prop('checked',true);
                            return;
                        }
                    })
                }

                if(args.item.day_plan == 1){
                    day_plan = 1;             
                }
                else{
                    day_plan = 0;
                    $("#days").find("input").each(function(){
                        $(this).prop('checked',true);
                    })
                    
                }

                $("#pre_ad_modal").click();
            }
            if($(args.event.target)[0].className == 'fa fa-trash'){
                Swal.fire({
                    title: "Are you sure?",
                    text: "It will be deleted from your Billboard",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!"
                }).then(function(result) {
                    if (result.value) {
                        processing();
                        $.ajax({
                            type : "POST",
                            url : 'delete_ad',
                            data : {
                                id : args.item.id
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success : function(res){
                                KTApp.unblock('#basicScenario');
                                if(res == "success"){
                                    Swal.fire("Success!", "You Deleted Ad!", "success");
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
                        });
                    }
                });
                
            }
            // if($(args.event.target)[0].nodeName=="I"){
            // }
        },
        rowDoubleClick : function(args){
            
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
                    url : '/get_ad_byid',
                    success : function(res){
                    }
                });
            },
            deleteItem : function(item)
            {
                return $.ajax({
                    type : "POST",
                    url : 'delete_ad',
                    data : item,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success : function(res){
                        if(res == "success"){
                            Swal.fire("Success!", "You Deleted Ad!", "success");
                            // $("#basicScenario").jsGrid("loadData");
                            
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
            { name : "rest" ,visible :false},
            { name : "schedule" ,visible :false},
            { title: "Template Name", name: "media_id", type: "text", width: "50px",align: "left",visible :false},
            { title: "Template Name", name: "template_name", type: "text", width: "120px",align: "left", visible :false},
            { title : "Checked Boxes are delivered to Billboard", name : "playlist", width:"80px",
                itemTemplate: function(val, item) {
                    if(val == "1"){
                        return ('<label class="checkbox">'+
                            '<input type="checkbox" checked/>'+
                            '<span></span>'+
                        '</label>');
                    }
                    else{
                        return ('<label class="checkbox">'+
                            '<input type="checkbox"/>'+
                            '<span></span>'+
                        '</label>');
                    }
                },
                insertTemplate: function() {
                    var insertControl = this.insertControl = $("<input>").prop("type", "file");
                    return insertControl;
                },
                editoptions : function(){
                    value 
                },
                align: "center"
            },
            { title: "Ad List", name: "img_url", type: "text", width: "200px",
                itemTemplate: function(val, item) {
                    return ("<img src='/upload/"+val+"' width='180' height='150'>");
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
            { title: "Business Name", name: "business_name", type: "text", width: "120px",align: "left",visible:false},
            { title: "Edit schedule", editButton :false,width : "80px", align: "center",
                itemTemplate: function(val, item) {
                    return ("<span style='cursor:pointer'><i class='fa fa-edit' style='color:#1BC5BD'></i></span>");
                }
            },
            { title : "Locations", name : "location", width:"250px",
                itemTemplate: function(val, item) {
                    if(item.rest == 0){
                    var loca = val.split(",");
                        var temp_loca = "";
                        for(var i = 0; i < loca.length-1; i++){
                            temp_loca += "<span style='display:block;text-align:left'><i class='la la-map-marker'></i>"+loca[i]+"</span>";
                        }
                        return (temp_loca);
                    }
                    else{
                        return "";
                    }
                },
                insertTemplate: function() {
                    var insertControl = this.insertControl = $("<input>").prop("type", "file");
                    return insertControl;
                },
                editoptions : function(){
                    value 
                },
                align: "center"
            },
            { title: "Start Date", name: "s_date", type: "text", width: "80px",align: "left",
                itemTemplate : function(val, item){
                    if(item.schedule == "ime"){
                        return "01-01-2021";
                    }
                    else{
                        return val;
                    }
                }
            },
            { title: "Start Time", name: "s_time", type: "text", width: "80px",align: "left",
                itemTemplate : function(val, item){
                    if(item.schedule == "ime"){
                        return "12 AM";
                    }
                    else{
                        return val;
                    }
                }
            },
            { title: "End Date", name: "e_date", type: "text", width: "80px",align: "left",
                itemTemplate : function(val, item){
                    if(item.schedule == "ime"){
                        return "No End Date";
                    }
                    else{
                        return val;
                    }
                }
            },
            { title: "End Time", name: "e_time", type: "text", width: "80px",align: "left",
                itemTemplate : function(val, item){
                    if(item.schedule == "ime"){
                        return "12 PM";
                    }
                    else{
                        return val;
                    }
                }
            },
            { title: "Primary", name: "primary", type: "text", width: "80px",align: "left",visible :false},
            { title: "Day Plan", name: "day_plan", type: "text", width: "80px",align: "left",visible :false},
            { title : "Days of week", name : "days", width:"120px",
                itemTemplate: function(val, item) {
                    if(item.schedule == 'ime'){
                        return "Every Day";
                    }
                    var temp_days = val.split(",");
                    var dis_days = "";
                    if(val == "0,1,2,3,4,5,6,"){
                        return ("<span>Every Day</span>");
                    }
                    else{
                        for(var i = 0; i < temp_days.length-1; i++){
                            if(temp_days[i] == 0){
                                dis_days += "Mo,";
                            }
                            if(temp_days[i] == 1){
                                dis_days += "Tu,";
                            }
                            if(temp_days[i] == 2){
                                dis_days += "We,";
                            }
                            if(temp_days[i] == 3){
                                dis_days += "Th,";
                            }
                            if(temp_days[i] == 4){
                                dis_days += "Fr,";
                            }
                            if(temp_days[i] == 5){
                                dis_days += "Sa,";
                            }
                            if(temp_days[i] == 6){
                                dis_days += "Su";
                            }
                        }
                    }
                    return ("<span>"+dis_days+"</span>");
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
                align: "left"
            },
            { type: "control", editButton :false,width : "80px",
                itemTemplate: function(val, item) {
                    // if(item.primary == "1"){
                        
                    // }
                    // else{
                        return ("<span style='cursor:pointer;padding-left:1rem'><i class='fa fa-trash' style='color: #F64E60'></i></span>");
                    // }
                }
            }
        ]
    });
</script>
	</body>
</html>
		