@include('admin.include.admin-header')
<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css" />
<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css" />                    
	<style>
        .jsgrid-header-row{
            height : 60px;
        }
        td{
            white-space : break-spaces;
        }
    </style>
        <!--begin::Content-->
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <!--begin::Subheader-->
            <div class="subheader min-h-lg-15px pt-5 pb-7 subheader-transparent" id="kt_subheader">
            </div>
            <div class="d-flex flex-column-fluid">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-custom" data-card="true" id="kt_card_1">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h3 class="card-label">{{$page_name}} - {{session("business_name")}}</h3>
                                    </div>
                                    <div class="card-toolbar">
                                        <h2><span class="total"></span></h2>
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
        <button type="button" class="btn btn-primary btn-update" data-toggle="modal" data-target="#exampleModal" style="display:none">
            Update Suggestion
        </button>

        <!-- Modal-->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Suggestion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <form id="frm_update">
                        <div class="modal-body">
                            <div class="form-group mb-1">
                                <input type="text" id="update_id" name="id" style="display:none">
                                <label>Content</label>
                                <textarea class="form-control" id="suggetionContent" name="content" rows="10"></textarea>
                            </div>
                            <div class="form-group mt-5">
                                <label>Hours</label>
                                <input class="form-control" type="text" name="hour" id="hour">
                            </div>
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
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js"></script>
		<!-- <script src="/assets/js/pages/custom/user/edit-user.js?v=7.0.4"></script> -->
		<script>
            $("#frm_update").submit(function(event){
                event.preventDefault();
                var fs = new FormData(document.getElementById("frm_update"));
                $.ajax({
                    url : '/update_suggest',
                    type : "POST",
                    data : fs,
                    contentType : false,
                    processData : false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success : function (res){
                        location.reload();
                        // $(".c-modal").click();
                        // toastr.success("Success!");
                        // $("#basicScenario").jsGrid("loadData");
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
                    var fixed = 0;
                    if($(args.event.target)[0].nodeName == "INPUT"){
                        if($(args.event.target).prop("checked") == true){
                            fixed = 1;
                        }
                        $.ajax({
                            url : 'update_fixed',
                            type : "POST",
                            data : {
                                id : args.item.id,
                                fixed : fixed
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success : function (res){
                                // $("#basicScenario").jsGrid("loadData");
                            }
                        })
                    }
                },
                rowDoubleClick : function(args){
                    $("#update_id").val(args.item.id);
                    $("#hour").val(args.item.hour);
                    $("#suggetionContent").text(args.item.content);
                    $(".btn-update").click();
                },
                controller: {
                    loadData : function(filter){
                        return $.ajax({
                            type : "POST",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url : '/get_suggestion',
                            success : function(res){
                                var hours = 0;
                                var t_hours = 0;
                                var total = 0;
                                for(var i = 0; i < res.length; i++){
                                    if(res[i].fixed == 1){
                                        hours+=res[i].hour!=null?parseFloat(res[i].hour):0;
                                    }
                                    else{
                                        t_hours+=res[i].hour!=null?parseFloat(res[i].hour):0;
                                    }
                                }
                                var text = "Remaining : " + t_hours.toFixed(2)+" hrs, Fixed : "+hours.toFixed(2) + "hrs , $"+ parseFloat(25 * hours).toFixed(2);
                                $(".total").text(text);
                            }
                        });
                    },
                    deleteItem : function(item)
                    {
                        return $.ajax({
                            type : "POST",
                            url : 'delete_suggestion',
                            data : item,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success : function (res){
                                toastr.success("Success!");
                                $("#basicScenario").jsGrid("loadData");
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
                    { title: "User Name", name: "user_name", type: "text", width: "150px",align: "left"},
                    { title: "Business Name", name: "business_name", type: "text", width: "150px",align: "left"},
                    { title: "Content", name: "content", type: "text", width: "550px",align: "left"},
                    { title: "Hours", name: "hour", type: "text", width: "150px",align: "left"},
                    { title: "Created Date", name: "cre_date", type: "text", width: "150px",align: "left"},
                    { title: "Fixed", name: "fixed", type: "text", width: "100px",
                        itemTemplate: function(val, item) {
                            if(val == "1"){
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
                        insertValue: function() {
                            return this.insertControl[0].files[0]; 
                        },
                        align: "center"
                    },
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
	</body>
</html>
		