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
                                <div class="card-toolbar">
                                    <button class="btn btn-success" data-toggle="modal" data-target="#addModal">Add User</button>
                                    <button class="btn btn-success" data-toggle="modal" data-target="#updateModal" id="btn-update" style="display:none">Add User</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="basicScenario"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form id="frm_new">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Business Name</label>
                            <div class="business">
                                <select class="form-control select2" id="business" name="business" style="width:100%">
                                </select>
                            </div>
                            <input type="text" name="business_name" type="text" class="form-control" style="display:none">
                            <a href="javascript:;" class="manual">
                                <span class="label label-danger label-inline font-weight-boldest mt-2 float-right">Input manully</span>
                            </a>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" type="email" class="form-control" required>
                        </div>
                        <?php
                            if(session('level') == 2){
                        ?>
                        <div class="form-group">
                            <label>Level</label>
                            <select class="form-control level" name="level" required>
                                <option value="2">Super Admin</option> 
                                <option value="3">Franchise</option> 
                                <option value="4">Account Manager</option>
                                <option value="5">Graphics Designer</option>
                            </select>
                        </div>
                        <div class="form-group sup_div" style="display:none">
                            <label>Franchise</label>
                            <select class="form-control super select2" id="super" name="super[]" style="width:100%"></select>
                        </div>
                        <?php }?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold c-modal" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form id="frm_update">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Business Name</label>
                            <input type="hidden" name="id" id="update_id" style="display:none" class="form-control" required>
                            <div class="business">
                                <select class="form-control select2" id="update_business" name="business" style="width:100%">
                                </select>
                            </div>
                            <input type="text" name="business_name" id="business_name" type="text" class="form-control" style="display:none">
                            <a href="javascript:;" class="manual">
                                <span class="label label-danger label-inline font-weight-boldest mt-2 float-right">Input manully</span>
                            </a>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" id="update_name" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" id="update_email" type="email" class="form-control" required>
                        </div>
                        <?php
                            if(session('level') == 2){
                        ?>
                        <div class="form-group">
                            <label>Level</label>
                            <select class="form-control level" name="level" id="update_level" required>
                                <option value="2">Super Admin</option> 
                                <option value="3">Franchise</option> 
                                <option value="4">Account Manager</option>
                                <option value="5">Graphics Designer</option>
                            </select>
                        </div>
                        <div class="form-group sup_div" style="display:none">
                            <label>Franchise</label>
                            <select class="form-control super select2" id="up_super" name="super[]" style="width:100%"></select>
                        </div>
                        <?php }?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold c-modal" data-dismiss="modal">Close</button>
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
    <script src="/assets/js/scripts.bundle.js"></script>
    <script src="/assets/js/pages/crud/forms/widgets/select2.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js"></script>
    <!-- <script src="/assets/js/pages/crud/ktdatatable/advanced/vertical.js"></script> -->
    <!-- <script src="/assets/js/pages/custom/user/edit-user.js?v=7.0.4"></script> -->
    <script>
        $('#super').select2({
			placeholder: "Select a Franchise"
		});
        $('#up_super').select2({
			placeholder: "Select a Franchise"
		});
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
                url : "/get_business",
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
                        html += "<option value='"+res[i]['business_name']+"'>"+res[i]['business_name']+"</option>";
                    }
                    $("#business").append(html);
                    $("#update_business").append(html);
                },
                error : function(err){

                }
            })
        }
        get_super();
        function get_super(){
            $.ajax({
                url : "/get_super",
                type : "POST",
                data : {

                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success : function(res){
                    var html = "";
                    $("#super")[0].innerHTML = "";
                    $("#up_super")[0].innerHTML = "";
                    for(var i = 0; i < res.length; i++){
                        html += "<option value='"+res[i]['id']+"'>"+res[i]['user_name']+"</option>";
                    }
                    $("#super").append(html);
                    $("#up_super").append(html);
                },
                error : function(err){

                }
            })
        }
        <?php
        if(session('level') == 2){
        ?>
        $("#frm_new").find(".level").on('change', function(){
            if($(this).val() == 4 || $(this).val() == 5){
                if($(this).val() == 5){
                    $('#super').select2({
                        placeholder: "Select a Franchise",
                        multiple : true
                    });
                }
                else{
                    $('#super').select2({
                        placeholder: "Select a Franchise",
                        multiple : false
                    });
                }
                $("#frm_new").find('.sup_div').css('display', 'block');
            }
            else{
                $("#frm_new").find('.sup_div').css('display', 'none');
            }
        })
        $("#frm_update").find(".level").on('change', function(){
            if($(this).val() == 4 || $(this).val() == 5){
                if($(this).val() == 5){
                    $('#up_super').select2({
                        placeholder: "Select a Franchise",
                        multiple : true
                    });
                }
                else{
                    $('#up_super').select2({
                        placeholder: "Select a Franchise",
                        multiple : false,
                    });
                }
                $("#frm_update").find('.sup_div').css('display', 'block');
            }
            else{
                $("#frm_update").find('.sup_div').css('display', 'none');
            }
        })
        <?php }?>
        $("#frm_new").submit(function(event){
            event.preventDefault();
            KTApp.blockPage();
            var fs = new FormData(document.getElementById('frm_new'));
            if($("#frm_new").find('.manual').find('span').text() == "Input manully"){
                fs.append('manual', 0);
            }
            else{
                fs.append('manual', 1);
            }
            <?php
            if(session('level') == 3){
            ?>
            fs.append('level', 2);
            fs.append('super', "<?php echo session('user_id')?>");
            <?php }?>
            $.ajax({
                url : '/new-admin',
                type : "POST",
                data : fs,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType : false,
                processData : false,
                success : function(res){
                    KTApp.unblockPage()
                    if(res == 'success'){
                        get_business();
                        $(".c-modal").click();
                        toastr.success("Success");
                        $("#frm_new").find('.sup_div').css('display', 'none');
                        <?php
                        if(session('level') == 2){
                        ?>
                        get_super();
                        <?php }?>
                        $("#basicScenario").jsGrid("loadData");
                    }
                    else{
                        toastr.error(res);
                    }
                },
                error :  function(err){
                    toastr.error("Please refresh your browser");
                    KTApp.unblockPage()
                }
            })
        })
        $("#frm_update").submit(function(event){
            event.preventDefault();
            KTApp.blockPage();
            var fs = new FormData(document.getElementById('frm_update'));
            if($("#frm_update").find('.manual').find('span').text() == "Input manully"){
                fs.append('manual', 0);
            }
            else{
                fs.append('manual', 1);
            }
            <?php
            if(session('level') == 3){
            ?>
            fs.append('level', 2);
            fs.append('super', "<?php echo session('user_id')?>");
            <?php }?>
            $.ajax({
                url : '/update-admin',
                type : "POST",
                data : fs,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType : false,
                processData : false,
                success : function(res){
                    KTApp.unblockPage()
                    if(res == 'success'){
                        get_business();
                        $(".c-modal").click();
                        toastr.success("Success");
                        $("#basicScenario").jsGrid("loadData");
                        <?php
                        if(session('level') == 2){
                        ?>
                        get_super();
                        <?php }?>
                    }
                    else{
                        toastr.error(res);
                    }
                },
                error :  function(err){
                    toastr.error("Please refresh your browser");
                }
            })
        })
        function update_user(id,business_name, name, email, level, sup){
            $('#update_id').val(id);
            $("#business_name").val(business_name);
            $("#update_business").val(business_name);
            $("#update_business").trigger('change.select2');
            $("#update_name").val(name);
            $("#update_email").val(email);
            $('#update_level').val(level);
            if(level == 4 || level == 5){
                level == 5?$('#up_super').select2({
                        placeholder: "Select a Franchise",
                        multiple : true
                    }):$('#up_super').select2({
                        placeholder: "Select a Franchise",
                        multiple : false
                    });
                sup=level==5?sup.split('/'):sup;
                console.log(sup);
                $("#frm_update").find('.sup_div').css('display', 'block');
                $('#up_super').val(sup);
                $('#up_super').trigger('change.select2');
            }
            else{
                $("#frm_update").find('.sup_div').css('display', 'none');
            }
            $('#btn-update').click();
        }
        function delete_user(id){
            Swal.fire({
                title: "Are you sure?",
                text: "You won\'t be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    KTApp.blockPage();
                    $.ajax({
                        url : '/delete_admin',
                        type : "POST",
                        data : {
                            id : id
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success : function (res){
                            KTApp.unblockPage()
                            if(res == 'success'){
                                $("#basicScenario").jsGrid("loadData");
                                Swal.fire(
                                    "Deleted!",
                                    "User has been deleted.",
                                    "success"
                                )
                            }
                            else{
                                toastr.error("Fail to remove user");
                            }
                        },
                        error : function (err){
                            toastr.error("Please refresh your browser");
                        }
                    })
                }
            });
        }
        function lock_user(id){
            Swal.fire({
                title: "Are you sure?",
                // text: "You won\'t be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes"
            }).then(function(result) {
                if (result.value) {
                    KTApp.blockPage();
                    $.ajax({
                        url : '/lock_user',
                        type : "POST",
                        data : {
                            id : id
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success : function (res){
                            KTApp.unblockPage()
                            if(res == 'success'){
                                $("#basicScenario").jsGrid("loadData");
                                Swal.fire(
                                    "Updated!",
                                    "User status has been updated.",
                                    "success"
                                )
                            }
                            else{
                                toastr.error("Fail to update user");
                            }
                        },
                        error : function (err){
                            toastr.error("Please refresh your browser");
                        }
                    })
                }
            });
        }
        var search_name = "";
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
                            search_name : search_name
                        },
                        url : '/get_admin',
                        success : function(res){                           
                        }
                    });
                },
            },
            fields: [
                { name : "id" ,visible :false},
                { title: "Business Name", name: "business_name", type: "text", width: "120px",align: "left",editing: false},
                { title: "Name", name: "user_name", type: "text", width: "120px",align: "left",editing: false},
                { title: "Email", name: "email", type: "text", width: "120px",align: "left",editing: false},
                { title: "Level", name: "level", type: "number", width: "100px",align: "left",editing: false, 
                    itemTemplate: function(val, item) {
                        if(val == 2){
                            return "Super Admin";
                        }
                        else if(val == 3){
                            return "Franchise";
                        }
                        else if(val == 4){
                            return "Account Manager";
                        }
                        else{
                            return "Graphics Designer";
                        }
                    },
                },
                { title: "Franchise", name: "supervisor", type: "text", width: "100",align: "left",editing: false, 
                    itemTemplate: function(val, item) {
                        return val;
                    },
                },
                { title : "Status",name: "user_lock", width : "70px", 
                    itemTemplate: function(val, item) {
                        if(val != 0){
                            return "Locked out";
                        }
                        // else{
                        //     return "Unlock User";
                        // }
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
                { title : "Action", width : "120px", 
                    itemTemplate: function(val, item) {
                        var sup = "";
                        if(item.level == 5){
                            var sup_id = JSON.parse(item.sup_id);
                            sup_id.forEach(function(temp){
                                sup += temp+"/";
                            })
                        }
                        else{
                            sup = item.sup_id;
                        }
                        if(item.user_lock == 1){
                            return ('<button class="btn btn-icon btn-light-success pulse pulse-success mr-5" title="Update User" onclick="update_user(`'+item.id+'`,`'+item.business_name+'`,`'+item.user_name+'`,`'+item.email+'`,`'+item.level+'`,`'+sup+'`)"><i class="fa fa-edit"></i></button>'+
                                '<button class="btn btn-icon btn-light-info pulse pulse-info mr-5" title="Lock User" onclick="lock_user(`'+item.id+'`)"><i class="fas fa-lock-open"></i></button>'+
                                '<button class="btn btn-icon btn-light-danger pulse pulse-danger mr-5" title="Delete User" onclick="delete_user(`'+item.id+'`)"><i class="fa fa-trash"></i></button>')
                        }
                        else{
                            return ('<button class="btn btn-icon btn-light-success pulse pulse-success mr-5" title="Update User" onclick="update_user(`'+item.id+'`,`'+item.business_name+'`,`'+item.user_name+'`,`'+item.email+'`,`'+item.level+'`,`'+sup+'`)"><i class="fa fa-edit"></i></button>'+
                                '<button class="btn btn-icon btn-light-info pulse pulse-info mr-5" title="Lock User" onclick="lock_user(`'+item.id+'`)"><i class="fa fa-lock"></i></button>'+
                                '<button class="btn btn-icon btn-light-danger pulse pulse-danger mr-5" title="Delete User" onclick="delete_user(`'+item.id+'`)"><i class="fa fa-trash"></i></button>')
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
                }
            ]
        });
    </script>
</body>
</html>
		