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
                                    <label class='mr-3 mb-0'>Status</label>
                                    <div class=''>
                                        <select class="form-control selectpicker" id="status">
                                            <option value="">All</option>
                                            <option value="0">Active</option>
                                            <option value="1">Inactive</option>
                                        </select>
                                    </div>
                                    <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" title="Toggle Table">
                                        <i class="ki ki-arrow-down icon-nm"></i>
                                    </a>
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
    <button type="button" class="btn btn-success btn-block" id="pre_edit" style='display: none' data-toggle="modal" data-target="#exampleModal">Preview Ad</button>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Locations</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form id="add_location">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Business Name</label>
                            <input class="form-control" name="business_name" id="business_name" type="text" disabled required >
                        </div>
                        <div class="form-group">
                            <label>Locations</label>
                            <div class="checkbox-list" id='location_list'>
                                <?php
                                foreach($locations as $loc_temp){
                                ?>
                                <label class="checkbox">
                                    <input type="checkbox" name="current" value="{{$loc_temp->id}}"> {{$loc_temp->name}}
                                    <span></span>
                                </label>
                                <?php }?>
                            </div>
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
        $("#add_location").submit(function(event) {
            event.preventDefault();
            var fs =  new FormData(document.getElementById("add_location"));
            var location_list = [];
            $("#location_list").find("input").each(function(){
                if($(this).prop('checked') == true){
                    location_list.push($(this).val());
                }
            })
            if(location_list.length == 0){
                toastr.error("Please Select At least one location!");
                return;
            }
            fs.append("business_name",$("#business_name").val());
            fs.append("location_list",location_list);
            $.ajax({
                url : "/update_location",
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
                        success_noti();
                    }
                    else{
                        toastr.error("Fail!");
                        return;
                    }
                }
            })
        })
        $("#update_locations").submit(function(event) {
            event.preventDefault();
            var fs = new FormData(document.getElementById("update_locations"));
            KTApp.block('#kt_blockui_content', {
                overlayColor: '#000000',
                state: 'danger',
                message: 'Please wait...'
            });

            setTimeout(function() {
                KTApp.unblock('#kt_blockui_content');
            }, 2000);
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
                var location_id = args.item.location_id;
                if($(args.event.target)[0].className == 'fa fa-edit'){
                    $("#location_list").find("input").each(function(){
                        $(this).prop("checked",false);
                    })
                    for(var i = 0 ; i < location_id.length ; i++){
                        $("#location_list").find("input").each(function(){
                            if(location_id[i] == $(this).val()){
                                $(this).prop("checked",true);
                            }
                        })
                    }
                        
                    $("#business_name").val(args.item.business_name);
                    $("#pre_edit").click();
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
                        url : '/get_location_by_busiess',
                        success : function(res){                           
                        }
                    });
                }
            },
            fields: [
                { name : "id" ,visible :false},
                { title: "Business", name: "business_name", type: "text", width: "150px",align: "left",editing: false},
                { title: "Name", name: "user_level", type: "text", width: "150px",align: "left",visible: false,editing: false},
                { title: "location_id", name: "location_id", type: "text", width: "150px",align: "left",visible: false,editing: false},
                { title: "Locations", name: "location_name", type: "text", width: "300px",align: "left",
                    itemTemplate: function(val, item) {
                        var text = "";
                        for(var i = 0; i < val.length; i++){
                            if(i == val.length-1){
                                text += val[i];    
                            }
                            else{
                                text += val[i]+",";
                            }
                        }
                        return text;
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
                },
                // { title: "Schedule Type", name: "day_plan", type: "number", width: "80px",align: "center",
                //     itemTemplate: function(val, item) {
                //         if(val == 0){
                //             return '<button type="button" class="btn btn-danger btn-block">7 Days</button>';
                //         }
                //         else{
                //             return '<button type="button" class="btn btn-warning btn-block">2 days</button>';
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
                // },
                { title: "Status", name: "user_lock", type: "text", width: "30px",align: "center",editing: false,
                    itemTemplate: function(val, item) {
                        if(val == "1"){
                            return ("<span><i style='color: #F64E60' class='fas fa-lock'></i></span>")
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
                },
                { title: "Edit", name: "min", type: "number", width : "50px",editing : false,
                    itemTemplate: function(val, item) {
                        return ("<span style='cursor:pointer'><i class='fa fa-edit' style='color:#1BC5BD'></i></span>");
                        // <span style='cursor:pointer;padding-left:1rem'><i class='fa fa-trash' style='color: #F64E60'></i></span>");
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
		