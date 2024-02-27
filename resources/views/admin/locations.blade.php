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
            <div class="container-fluid">
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
    <!-- Edit Price / Discount -->
    <button type="button" class="btn btn-primary edit-price" data-toggle="modal" data-target="#editPriceModal" style="display:none">
        Edit Price
    </button>
    <div class="modal fade" id="editPriceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Price / Discount - <span id="location_name"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form id="frmPrice">
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" class="location_id form-control" name="id">
                            <div class="col-md-6 price">
                                <div class="form-group">
                                    <label>Price1</label>
                                    <input class="form-control currency"  data-inputmask-alias="currency"name="day1" required/>
                                </div>
                                <div class="form-group">
                                    <label>Price2</label>
                                    <input class="form-control currency"  data-inputmask-alias="currency"name="day2" required/>
                                </div>
                                <div class="form-group">
                                    <label>Price3</label>
                                    <input class="form-control currency"  data-inputmask-alias="currency"name="day3" required/>
                                </div>
                                <div class="form-group">
                                    <label>Price4</label>
                                    <input class="form-control currency"  data-inputmask-alias="currency"name="day4" required/>
                                </div>
                                <div class="form-group">
                                    <label>Price5</label>
                                    <input class="form-control currency"  data-inputmask-alias="currency"name="day5" required/>
                                </div>
                                <div class="form-group">
                                    <label>Price6</label>
                                    <input class="form-control currency"  data-inputmask-alias="currency"name="day6" required/>
                                </div>
                                <div class="form-group">
                                    <label>Price7</label>
                                    <input class="form-control currency"  data-inputmask-alias="currency"name="day7" required/>
                                </div>
                            </div>
                            <div class="col-md-6 discount">
                                <div class="form-group">
                                    <label>Discount1</label>
                                    <input class="form-control currency"  data-inputmask-alias="currency"name="dis1" required/>
                                </div>
                                <div class="form-group">
                                    <label>Discount2</label>
                                    <input class="form-control currency"  data-inputmask-alias="currency"name="dis2" required/>
                                </div>
                                <div class="form-group">
                                    <label>Discount3</label>
                                    <input class="form-control currency"  data-inputmask-alias="currency"name="dis3" required/>
                                </div>
                                <div class="form-group">
                                    <label>Discount4</label>
                                    <input class="form-control currency"  data-inputmask-alias="currency"name="dis4" required/>
                                </div>
                                <div class="form-group">
                                    <label>Discount5</label>
                                    <input class="form-control currency"  data-inputmask-alias="currency"name="dis5" required/>
                                </div>
                                <div class="form-group">
                                    <label>Discount6</label>
                                    <input class="form-control currency"  data-inputmask-alias="currency"name="dis6" required/>
                                </div>
                                <div class="form-group">
                                    <label>Discount7</label>
                                    <input class="form-control currency"  data-inputmask-alias="currency"name="dis7" required/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
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
        <script src="/js/inputmask.js"></script>
        <!-- <script src="/assets/js/pages/crud/ktdatatable/advanced/vertical.js"></script> -->
		<!-- <script src="/assets/js/pages/custom/user/edit-user.js?v=7.0.4"></script> -->
		<script>
            $(".currency").inputmask({reverse: true, rightAlign: false,});
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
            function edit_price(name, id, price, discount){
                $('.location_id').val(id);
                $('#location_name').text(name);
                var price = price.split(',');
                var discount = discount.split(',');
                var price_input = $(".price").find('input');
                var discount_input = $(".discount").find('input');
                price.map(function(key, i){
                    $(price_input[i]).val(key);
                })
                discount.map(function(key, i){
                    $(discount_input[i]).val(key);
                })
                $(".edit-price").click()
            }
            $("#frmPrice").submit(function(event){
                event.preventDefault();
                var fs = new FormData(document.getElementById("frmPrice"));
                $.ajax({
                    url : '/update-price',
                    type : "POST",
                    data : fs,
                    contentType : false,
                    processData : false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success : function(res){
                        if(res == 'success'){
                            location.reload()
                        }
                        else{
                            toastr.error(res);
                        }
                    },
                    error : function(err){
                        toastr.error("Please refresh your browser");
                    }
                })
            })
            var search_name = "";
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
                            url : '/get_locations',
                            success : function(res){                           
                            }
                        });
                    },
                    deleteItem : function(item)
                    {
                        return $.ajax({
                            type : "POST",
                            url : 'delete_locations',
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
                    insertItem : function(item)
                    {
                        $.ajax({
                            type : "POST",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url : '/insert_location',
                            data : item,
                            success : function(res){
                                if(res == "success"){
                                    $("#basicScenario").jsGrid("loadData");
                                }
                                else{
                                    toastr.error("Please Input Another name!");
                                }
                            }
                        });
                    },
                    updateItem : function(item)
                    {
                        $.ajax({
                            type : "POST",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url : '/update_locations',
                            data : item,
                            success : function(res){
                                if(res == "success"){
                                    toastr.success("Success!");
                                }
                                else{
                                    toastr.error("Fail!");
                                }
                                $("#basicScenario").jsGrid("loadData");
                            },
                            error : function(res){
                                location.reload();
                            }
                        });
                    }
                },
                fields: [
                    { name : "id" ,visible :false},
                    { title: "Location", name: "name", type: "text", width: "350px",align: "left",editing: false},
                    { title: "Nickname", name: "nickname", type: "text", width: "150px",align: "left"},
                    { title: "Width", name: "width", type: "number", width: "150px",align: "left"},
                    { title: "Height", name: "height", type: "number", width: "150px",align: "left"},
                    { title: "Ad Count", name: "itemCount", type: "number", width: "150px",align: "left",editing: false},
                    { title: "Max Ads Allowed", name: "max", type: "number", width: "150px",align: "left"},
                    { title: "Price", name: "price", type: "text", width: "150px",align: "left",editing : false,
                        itemTemplate: function(val, item) {
                            if(val == null){
                                val = ""
                            }
                            return ("<span>"+val+"<i class='fas fa-edit text-success' onclick='edit_price(`"+item.name+"`, `"+item.id+"`, `"+item.price+"`, `"+item.discount+"`)'></i></span>");
                        },
                    },
                    { title: "Discount", name: "discount", type: "text", width: "150px",align: "left",editing : false,
                        itemTemplate: function(val, item) {
                            if(val == null){
                                val = ""
                            }
                            return ("<span>"+val+"<i class='fas fa-edit text-success' onclick='edit_price(`"+item.name+"`, `"+item.id+"`, `"+item.price+"`, `"+item.discount+"`)'></i></span>");
                        },
                    },
                    { title: "", name: "min", type: "number", width : "50px",editing : false,
                        itemTemplate: function(val, item) {
                            if(item.max < item.itemCount){
                                return ('<a href="" class="btn btn-icon btn-light-danger pulse pulse-danger mr-5">'+
                                        '<i class="flaticon2-bell-5"></i>'+
                                        '<span class="pulse-ring"></span>'+
                                    '</a>');
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
                    { type: "control",deleteButton : false,}
                ]
            });
		</script>
	</body>
</html>
		