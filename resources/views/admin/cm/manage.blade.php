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
                            <div class="card-body">
                                <div id="basicScenario"></div>
                            </div>
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
        <!-- <script src="/assets/js/pages/crud/ktdatatable/advanced/vertical.js"></script> -->
		<!-- <script src="/assets/js/pages/custom/user/edit-user.js?v=7.0.4"></script> -->
		<script>
            function delete_cm(id){
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
                            url : '/delete_sub_list',
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
                                        "Playlist has been deleted.",
                                        "success"
                                    )
                                }
                                else{
                                    toastr.error("Fail to remove the playlist");
                                }
                            },
                            error : function (err){
                                toastr.error("Server error");
                                setTimeout(() => {
                                    location.reload()
                                }, 1000);
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
                            url : '/get_sub_list',
                            success : function(res){                           
                            }
                        });
                    },
                },
                fields: [
                    { name : "id" ,visible :false},
                    { title: "Name", name: "name", type: "text", width: "350px",align: "left",editing: false},
                    { title: "Items", name: "itemCount", type: "number", width: "150px",align: "left",editing: false, 
                        itemTemplate: function(val, item) {
                            if(val == undefined){
                                return 0;
                            }
                            else{
                                return val;
                            }
                        },
                    },
                    { title : "Action", width : "150px", 
                        itemTemplate: function(val, item) {
                            return ('<button class="btn btn-icon btn-light-danger pulse pulse-danger mr-5" onclick="delete_cm(`'+item.id+'`)"><i class="fa fa-trash"></i></button>')
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
                    // { title: "", name: "min", type: "number", width : "50px",editing : false,
                    //     itemTemplate: function(val, item) {
                    //         if(item.max < item.itemCount){
                    //             return ('<a href="" class="btn btn-icon btn-light-danger pulse pulse-danger mr-5">'+
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
                    //     align: "left"
                    // },
                    // { type: "control",deleteButton : false,}
                ]
            });
		</script>
	</body>
</html>
		