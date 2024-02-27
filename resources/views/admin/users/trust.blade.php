@include('admin.include.admin-header')
<link type="text/css" rel="stylesheet" href="/assets/css/tips.css" /> 
<!-- <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css" />
<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css" />                     -->
<link href="/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
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
                <div class="alert alert-custom alert-white alert-shadow fade show gutter-b tip-container" role="alert">
                    <div class="alert-text">
                        <ul class="tip hide">
                            <a type="button" class="btn btn-text-white btn-success font-weight-bold btn-spec" data-toggle="modal" data-target="#specModal">Instructions</a>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-custom" data-card="true" id="kt_card_1">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">{{$page_name}} - {{session("business_name")}}</h3>
                                </div>
                                <div class="card-toolbar">
                                    <button type="button" class="btn btn-primary mr-5" data-toggle="modal" data-target="#exampleModal">
                                        <i class="fa fa-plus"></i>Add a Trusted Agent
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <!-- <div class="col-4">
                                        <input type="email" class="form-control" placeholder="Enter User Name" id="user_name">
                                    </div> -->
                                    <!-- <div class="col-8" style="float:right">
                                        <button type="button"  style='float:right;margin-bottom:5px' class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                            <i class="fa fa-plus"></i>New Account
                                        </button>
                                    </div> -->
                                </div>
                                <button type="button" id="u_modal" style='display:none;float:right;margin-bottom:5px' class="btn btn-primary" data-toggle="modal" data-target="#update_modal">
                                    <i class="fa fa-plus"></i>update Account
                                </button>
                                <table class="table table-bordered table-hover table-checkable" id="kt_datatable">
                                    <thead>
                                        <tr>
                                            <th>Business Name</th>
                                            <th>User Name</th>
                                            <th>Email</th>
                                            <th>User Level</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $level_list = ['Secondary TA', 'Primary TA', 'Admin']
                                    ?>
                                    <tbody>
                                        @foreach($trusts as $key => $item)
                                        <tr>
                                            <td>{{$item->multi_id == null?$item->business_name:$item->com_name}}</td>
                                            <td>{{$item->user_name}}</td>
                                            <td>{{$item->email}}</td>
                                            <td>{{isset($level_list[$item->level])?$level_list[$item->level] : ""}}</td>
                                            <td>
                                                <a class="btn btn-icon btn-light-success mr-5 edit-user" 
                                                    data-id="{{$item->id}}" data-multiple="{{$item->multi_id}}"
                                                    data-business="{{$item->business_name}}"
                                                    data-user_name="{{$item->user_name}}"
                                                    data-level="{{$item->level}}"
                                                    data-email="{{$item->email}}"
                                                    data-sicid="{{$item->sic_id}}"
                                                >
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <!-- <a class="btn btn-icon btn-light-danger mr-5"
                                                    href="/manage-invoice/{{$item->id}}"
                                                >
                                                    <i class="fas fa-file-invoice-dollar"></i>
                                                </a> -->
                                                @if($item->level != 1)
                                                <a class="btn btn-icon btn-light-danger mr-5 trash" data-id="{{$item->id}}" data-multiple="{{$item->multi_id}}">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- <div id="basicScenario"></div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add a Trusted Agent</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form id="add_account">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Business Name</label>
                            <?php
                                if(session('level') == '1'){
                            ?>
                                <input class="form-control" name="business_name" type="text" value="{{session('business_name')}}" disabled required >
                            <?php
                                }
                                if(session('level') >= '2'){
                            ?>
                            <!-- <input class="form-control" name="business_name" type="text" value=""  required > -->
                                <div class="business">
                                    <select class="form-control select2" id="business" name="business" style="width:100%">
                                    </select>
                                </div>
                                <input type="text" name="business_name" type="text" class="form-control" style="display:none">
                                <a href="javascript:;" class="manual">
                                    <span class="label label-danger label-inline font-weight-boldest mt-2 float-right">Input manully</span>
                                </a>
                            <?php
                                }
                            ?>
                        </div>
                        <div class="form-group">
                            <label>User Name</label>
                            <input class="form-control" name="user_name" type="text" value="" required>
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input class="form-control" name="email" type="email" value="" required>
                        </div>
                        <div class="form-group">
                            <label >User Level</label>
                                <div class="dropdown bootstrap-select form-control">
                                <?php
                                if(session('level') == '1'){
                                ?>
                                    <select class="form-control selectpicker" tabindex="null" name="user_level">
                                        <option value="0">Secondary TA</option>
                                    </select>
                                <?php
                                    }
                                    if(session('level') == '2'){
                                ?>                                                
                                    <select class="form-control selectpicker" tabindex="null" name="user_level">
                                        <option value="1">Primary TA</option>
                                        <option value="0">Secondary TA</option>
                                        <option value="2">Admin</option>
                                    </select>
                                <?php
                                    }
                                    if(session('level') > '2'){
                                ?>
                                    <select class="form-control selectpicker" tabindex="null" name="user_level">
                                        <option value="1">Primary TA</option>
                                        <option value="0">Secondary TA</option>
                                    </select>
                                <?php }?>
                            </div>
                        </div>
                        <?php if(session('level') == 2){?>
                        <div>
                        <?php }
                        else{
                        ?>
                        <div style="display:none">
                        <?php }?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" id="c_modal" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary font-weight-bold" id="btn_save">Save changes</button>
                    </div>
                </form>                                
            </div>
        </div>
    </div>
    <div class="modal fade" id="update_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update a Trusted Agent</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form id="update_account">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Business Name</label>
                            <?php
                                if(session('level') == '1'){
                            ?>
                                <input class="form-control" id="b_name" name="business_name" type="text" value="{{session('business_name')}}" disabled required >
                            <?php
                                }
                                if(session('level') >= '2'){
                            ?>
                            <!-- <input class="form-control" id="b_name" name="business_name" type="text" value=""  required> -->
                                <input type="hidden" name="id" id="update_id" style="display:none" class="form-control" required>
                                <div class="business">
                                    <select class="form-control select2" id="update_business" name="business" style="width:100%">
                                    </select>
                                </div>
                                <input type="text" name="business_name" id="business_name" type="text" class="form-control" style="display:none">
                                <a href="javascript:;" class="manual">
                                    <span class="label label-danger label-inline font-weight-boldest mt-2 float-right">Input manully</span>
                                </a>
                            <?php
                                }
                            ?>
                        </div>
                        <div class="form-group">
                            <label>User Name</label>
                            <input class="form-control" name="tbl_id" id="u_id" type="hidden" value="">
                            <input class="form-control" name="user_name" id="u_name" type="text" value="" required>
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input class="form-control" name="email" type="email" id='u_email' value="" required>
                        </div>
                        <div class="form-group">
                            <label >User Level</label>
                            <div class="dropdown bootstrap-select form-control">
                                <?php
                                if(session('level') == '1'){
                                ?>
                                    <select class="form-control selectpicker" tabindex="null" name="user_level" id="u_level">
                                        <option value="0" selected>Secondary TA</option>
                                    </select>
                                <?php
                                    }
                                    if(session('level') == '2'){
                                ?>                                                
                                    <select class="form-control selectpicker" tabindex="null" name="user_level" id="u_level">
                                        <option value="1">Primary TA</option>
                                        <option value="0">Secondary TA</option>
                                        <option value="2">Admin</option>
                                    </select>
                                <?php
                                    }
                                    if(session('level') > '2'){
                                ?>
                                    <select class="form-control selectpicker" tabindex="null" name="user_level">
                                        <option value="1">Primary TA</option>
                                        <option value="0">Secondary TA</option>
                                    </select>
                                <?php }?>
                            </div>
                        </div>
                        <?php if(session('level') == 2){?>
                        <div>
                        <?php }
                        else{
                        ?>
                        <div style="display:none">
                        <?php }?>
                        </div>
                        <?php if(session('level') == 2){?>
                        <!-- <div class="only_primary">
                            <div class="form-group">
                                <label>Select Sales</label>
                                <select class="form-control selectpicker" name='sales' id="u_sales" title="Select Sales" data-live-search="true" data-size="5" required>
                                    <?php foreach($sales as $sales_temp){
                                    ?>
                                    <option value="{{$sales_temp->id}}">{{$sales_temp->sales_name}}</option>
                                    <?php }?>
                                </select>
                            </div>
                        </div> -->
                        <?php }?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" id="cu_modal" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary font-weight-bold" id="btn_update">Save changes</button>
                    </div>
                </form>                                
            </div>
        </div>
    </div>
    <div class="modal fade" id="specModal" tabindex="-1" role="dialog" aria-labelledby="specModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="specModalLabel">Instructions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    Create accounts for coworkers or subordinates so that they can access this site and change billboard Ads for you.<br><br>
                    They will automatically receive an email which allows them to create a password and enter the web site.<br><br>
                    You can remove them at any time.<br><br>
                        -- Add Trusted Agent FAQs on the right side.<br><br>
                    - What is a Trusted Agent?<br><br>
                        A person whom you trust implicitly to post decent Ads on your behalf on the billboards.   They can do everything you can do except create other Trusted Agents.  Only you can do that.<br><br>
                    - Why have a Trusted Agent?<br><br>
                        Since your company can post Ads without INEX oversight, we use a Trusted Agent program.  This approach allows you to create addition account access.  The idea is that you can designate a coworker(s) or subordinate(s) to manage your Advertising campaigns.<br><br>
                    - Why have separate Trusted Agent accounts?<br><br>
                        --  We can track who posted certain ads and when they did it.<br><br>
                            -- if your Secondary Trusted Agent leaves the firm, you can delete their Trusted Agent account / access.<br><br>
                    - How many Secondary Trusted Agents can I have?<br><br>
                        You can have as many Secondary Trusted Agents as you wish.<br><br>
                    We STRONGLY suggest you create individual accounts for any person you trust to update your signs.  Do not allow them to use your account to access your billboard Ads.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
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
    <script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="/assets/js/trust.js"></script>
    <script>
        function display_noti(status, text){
            if(status == 'success'){
                toastr.success(text);
            }
            else{
                toastr.error(text);
            }
        }
        // Update User
        $(".edit-user").on('click', function(){
            $("#u_id").val($(this).data('id'));
            $("#b_name").val($(this).data('business'))
            $("#u_name").val($(this).data('user_name'));
            $("#u_email").val($(this).data('email'));
            $("#u_level").val($(this).data('level')).trigger("change");
            <?php
                if(session('level') == 2){
            ?>
            $("#business_name").val($(this).data('business'));
            $("#update_business").val($(this).data('business')).trigger("change");
            $("#u_sic").val($(this).data('sicid')).trigger("change");
            // $("#u_sales").val(args.item.sales_id).trigger("change");
            <?php }?>
            $("#u_modal").click();
        })
        // Delete User
        $(".trash").on('click', function(){
            var user_id = $(this).data('id');
            var multi_id = $(this).data('multiple');
            Swal.fire({
                title: "Are you sure?",
                text: "You won\"t be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type : "POST",
                        url : 'delete_trust',
                        data : {
                            id : user_id,
                            multi_id : multi_id, 
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success : function (res){
                            if(res == "success"){
                                location.reload();
                            }
                            if(res == "Multi"){
                                display_noti('error',"This user is used in another companies!");
                                $("#basicScenario").jsGrid("loadData");
                            }
                        },
                        error : function(res){
                            location.reload();
                        }
                    });
                }
            });
        })
        // Business name for drop
        $('#business').select2({
			placeholder: "Select a business name"
		});
        $('#update_business').select2({
			placeholder: "Select a business name"
		});
        $(".manual").on('click', function(){
            if($(this).find('span').text() == "Input manully"){
                $(this).find('span').text("Select business name");
            }
            else{
                $(this).find('span').text("Input manully");
            }
            $(document.getElementsByName('business_name')).toggle();
            $('.business').toggle();
        })
        get_business();
        function get_business(){
            $.ajax({
                url : "/get_business_ta",
                type : "POST",
                data : {

                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success : function(res){
                    // console.log(res);
                    var html = "";
                    $("#business")[0].innerHTML = "";
                    $("#update_business")[0].innerHTML = "";
                    for(var i = 0; i < res.length; i++){
                        html += '<option value="'+res[i]['business_name']+'">'+res[i]['business_name']+'</option>';
                    }
                    $("#business").append(html);
                    $("#update_business").append(html);
                },
                error : function(err){

                }
            })
        }
        // End of business name
        var search_name = "";
        $("#user_name").on("keyup",function(){
            search_name = $(this).val();
            $("#basicScenario").jsGrid("loadData");
        })
        $("#update_account").submit(function(event){
            event.preventDefault();
            KTApp.blockPage();
            var fs = new FormData(document.getElementById("update_account"));
            if($("#update_account").find('.manual').find('span').text() == "Input manully"){
                fs.append('manual', 0);
            }
            else{
                fs.append('manual', 1);
            }
            $("#btn_update")[0].className = "btn btn-outline-danger spinner spinner-darker-danger spinner-left mr-3";                        
            $("#btn_update").removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true);
            $.ajax({
                url : 'update_trust',
                data : fs,
                contentType : false,
                processData : false,
                type : "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success : function(res){
                    KTApp.unblockPage();
                    $("#btn_update")[0].className = "btn btn-primary font-weight-bold";
                    $("#btn_update").removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                    if(res == "success"){
                        // display_noti('success',"Success");
                        // get_business();
                        // $("#cu_modal").click();
                        // $("#basicScenario").jsGrid("loadData");
                        location.reload();
                    }
                    else{
                        display_noti('error',res);
                    }
                },
                error : function(res){
                    KTApp.blockPage();
                    display_noti('error',"Please try again after refresh your browser or Contact to support Team.");
                }
            })
        })
        $("#add_account").submit(function(event){
            event.preventDefault();
            var fs = new FormData(document.getElementById("add_account"));
            $("#btn_save")[0].className = "btn btn-outline-danger spinner spinner-darker-danger spinner-left mr-3";                        
            $("#btn_save").attr('disabled', true);
            if($("#add_account").find('.manual').find('span').text() == "Input manully"){
                fs.append('manual', 0);
            }
            else{
                fs.append('manual', 1);
            }
            $.ajax({
                url : 'add_trust',
                data : fs,
                contentType : false,
                processData : false,
                type : "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success : function(res){
                    $("#btn_save")[0].className = "btn btn-primary font-weight-bold";
                    $("#btn_save").removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);                    
                    result = res.split(",");
                    if(res == "success"){
                        location.reload();
                        // get_business();
                        // display_noti('success',"Success");
                        // $("#c_modal").click();
                        // $("#basicScenario").jsGrid("loadData");
                    }
                    // else if(result[0] == "Already Exist"){
                    //     Swal.fire({
                    //         // title: "Multi User!",
                    //         text: "This email address was previuosly registered with another company as a Trusted Agent. Please confirm you wish to add them to another company also!",
                    //         icon: "question",
                    //         showCancelButton: true,
                    //         confirmButtonText: "Confirm  TA Registration",
                    //         cancelButtonText: "Cancel TA Registration ",
                    //         reverseButtons: true
                    //     }).then(function(resu) {
                    //         if (resu.value) {
                    //             fs.append("user_id",result[1]);
                    //             $.ajax({
                    //                 url : "/save_multi",
                    //                 type: "POST",
                    //                 data : fs,
                    //                 contentType : false,
                    //                 processData : false,
                    //                 headers: {
                    //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    //                 },
                    //                 success: function(res){
                    //                     if(res == "success"){
                    //                         Swal.fire(
                    //                             "Success!",
                    //                             "",
                    //                             "success"
                    //                         )
                    //                         $("#basicScenario").jsGrid("loadData");
                    //                         $("#c_modal").click();
                    //                     }
                    //                     else{
                    //                         Swal.fire(
                    //                             "Fail To Register!",
                    //                             "",
                    //                             "error"
                    //                         )
                    //                     }
                    //                 }
                    //             })
                    //         } else if (resu.dismiss === "cancel") {
                    //             Swal.fire(
                    //                 "Cancelled",
                    //                 "",
                    //                 "error"
                    //             )
                    //         }
                    //     });
                    // }
                    else{
                        display_noti('error',res);
                    }
                },
                error : function(res){
                    display_noti('error',"Fail");
                    // location.reload();
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
                // if($(args.event.target)[0].nodeName == "INPUT" && $(args.event.target)[0].className!= "form-control"){
                if($(args.event.target)[0].nodeName == "BUTTON"){
                    var locked = 0;
                    // if($(args.event.target).prop("checked") == true){
                    if($(args.event.target)[0].className == "btn btn-success"){
                        locked = 1;
                    }
                    $.ajax({
                        url : 'update_lock',
                        type : "POST",
                        data : {
                            id : args.item.id,
                            business_name : args.item.business_name,
                            locked : locked
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success : function (res){
                            display_noti('success',"Success");
                            $("#basicScenario").jsGrid("loadData");
                        }
                    })
                }
            },
            rowDoubleClick : function(args){
                $("#u_id").val(args.item.id);
                $("#b_name").val(args.item.business_name)
                $("#u_name").val(args.item.user_name);
                $("#u_email").val(args.item.email);
                $("#u_level").val(args.item.level).trigger("change");
                <?php
                    if(session('level') == 2){
                ?>
                $("#business_name").val(args.item.business_name);
                $("#u_sic").val(args.item.sic_id).trigger("change");
                // $("#u_sales").val(args.item.sales_id).trigger("change");
                <?php }?>
                var d = new Date(args.item.s_date);
                var sDate = d.getFullYear() + "-" + ((d.getMonth() + 1).toString().padStart(2, "0")) + "-" + d.getDate().toString().padStart(2, "0");
                var d = new Date(args.item.e_date);
                var eDate = d.getFullYear() + "-" + ((d.getMonth() + 1).toString().padStart(2, "0")) + "-" + d.getDate().toString().padStart(2, "0");
                $("#s_date").val(sDate);
                $("#e_date").val(eDate);
                $("#u_modal").click();
            },
            controller: {
                loadData : function(filter){
                    return $.ajax({
                        type : "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data : {
                            search_name : search_name
                        },
                        url : '/get_trust',
                        success : function(res){                           
                        }
                    });
                },
                deleteItem : function(item)
                {
                    return $.ajax({
                        type : "POST",
                        url : 'delete_trust',
                        data : item,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success : function (res){
                            if(res == "success"){
                                display_noti('success',"Success");
                                $("#basicScenario").jsGrid("loadData");
                            }
                            if(res == "Multi"){
                                display_noti('error',"This user is used in another companies!");
                                $("#basicScenario").jsGrid("loadData");
                            }
                        },
                        error : function(res){
                            location.reload();
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
                { title: "Business Name", name: "business_name", type: "text", width: "150px",align: "left",
                    itemTemplate: function(val, item) {
                        if(item.multi_id == null){
                            return val;
                        }
                        else{
                            return item.com_name
                        }
                    }
                },
                { title: "User Name", name: "user_name", type: "text", width: "120px",align: "left"},
                { title: "Email", name: "email", type: "text", width: "150px",align: "left"},
                { title: "User Level", name: "level", type: "text", width: "100px",
                    itemTemplate: function(val, item) {
                        if(val == "0"){
                            return ("<span>Secondary TA</span>");
                        }
                        if(val == "1"){
                            return ("<span>Primary TA</span>");
                        }
                        if(val == "2"){
                            return ("<span>Admin</span>");
                        }
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
                { title: "Sales", name: "sales_name", type: "text", width: "120px",align: "left",visible :false},
                { title: "SIC", name: "sic_name", type: "text", width: "150px",align: "left",visible :false},
                { title: "Sales", name: "sales_id", type: "text", width: "150px",align: "left",visible:false},
                <?php 
                if(session('level') == 2){
                ?>
                // { title: "Multi User", name: "multi_id", type: "text", width: "50px",
                //     itemTemplate: function(val, item) {
                //         if(val != null){
                //             return ('<a class="btn btn-icon btn-light-danger pulse pulse-danger mr-5">'+
                //                     '<i class="flaticon2-bell-5"></i>'+
                //                     '<span class="pulse-ring"></span>'+
                //                 '</a>');
                //         }
                //     },
                //     insertTemplate: function() {
                //         var insertControl = this.insertControl = $("<input>").prop("type", "file");
                //         return insertControl;
                //     },
                //     editoptions : function(){
                //         value 
                //     },
                //     insertValue: function() {
                //         return this.insertControl[0].files[0]; 
                //     },
                //     align: "center"
                // },
                <?php }?>
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
		