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
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i>New SIC</button>
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
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New SIC</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form id="new_sic">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>SIC Name</label>
                            <input class="form-control" name="sic_name" type="text" required >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" id="c_modal" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
                    </div>
                </form>                                
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#update_modal" id="btn_update" style="display: none"><i class="fa fa-plus"></i>New SIC</button>
    <div class="modal fade" id="update_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update SIC</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form id="update_sic">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>SIC Name</label>
                            <input class="form-control" name="tbl_id" id="u_id" type="hidden" value="">
                            <input class="form-control" name="sic_name" id="sic_name" type="text" value="" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" id="cu_modal" data-dismiss="modal">Close</button>
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js"></script>
    <!-- <script src="/assets/js/pages/crud/ktdatatable/advanced/vertical.js"></script> -->
    <!-- <script src="/assets/js/pages/custom/user/edit-user.js?v=7.0.4"></script> -->
    <script>
        var status = "";
        $("#status").on('change',function(){
            status = $(this).val();
            $("#basicScenario").jsGrid("loadData");
        })
        function success_noti(){
            $("#basicScenario").jsGrid("loadData");
            toastr.success("Success!");
        }
        $("#new_sic").submit(function(event) {
            event.preventDefault();
            var fs =  new FormData(document.getElementById("new_sic"));
            $.ajax({
                url : "/new_sic",
                type : "POST",
                data : fs,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                processData : false,
                contentType: false,
                success : function(res){
                    if(res == "success"){
                        $("#c_modal").click();
                        $("#new_sic").find("input").each(function(){
                            $(this).val("");
                        })
                        success_noti();
                    }
                    else{
                        toastr.error("Fail!");
                        return;
                    }
                }
            })
        })
        $("#update_sic").submit(function(event) {
            event.preventDefault();
            var fs =  new FormData(document.getElementById("update_sic"));
            $.ajax({
                url : "/update_sic",
                type : "POST",
                data : fs,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                processData : false,
                contentType: false,
                success : function(res){
                    if(res == "success"){
                        $("#cu_modal").click();
                        success_noti();
                    }
                    else{
                        toastr.error("Fail!");
                        return;
                    }
                }
            })
        });

        $("#basicScenario").jsGrid({
            width: "100%",
            // filtering: true,
            editing: true,
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
                if($(args.event.target)[0].className == 'fa fa-edit'){
                    $("#u_id").val(args.item.id);
                    $("#sic_name").val(args.item.sic_name);
                    $("#btn_update").click();
                }
                else if($(args.event.target)[0].className == 'fa fa-trash'){
                    $.ajax({
                        url : "delete_sic",
                        type: "POST",
                        data : {
                            tbl_id : args.item.id
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(res){
                            if(res == "success"){
                                success_noti();
                            }
                            else{
                                toastr.error("Fail!");
                                return;
                            }
                        }
                    })
                }
            },
            rowDoubleClick : function(args){
            },
            controller: {
                loadData : function(filter){
                    return $.ajax({
                        type : "POST",
                        data : {
                            status  : status
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url : '/get_sic',
                        success : function(res){                           
                        }
                    });
                }
            },
            fields: [
                { name : "id" ,visible :false},
                { title: "SIC Name", name: "sic_name", type: "text", width: "150px",align: "left",editing: false},
                { title: "Business Name", name: "business_name", type: "text", width: "150px",align: "left",editing: false,visible:false},
                { title: "Edit", name: "min", type: "number", width : "50px",editing : false,
                    itemTemplate: function(val, item) {
                        return ("<span style='cursor:pointer'><i class='fa fa-edit' style='color:#1BC5BD'></i></span>"+
                        "<span style='cursor:pointer;padding-left:1rem'><i class='fa fa-trash' style='color: #F64E60'></i></span>");
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
                // { type: "control",deleteButton : false,}
            ]
        });
    </script>
	</body>
</html>
		