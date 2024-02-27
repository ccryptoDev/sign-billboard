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
                                        <h3 class="card-label">{{$page_name}} - {{session("business_name")}}</h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-4" id='add_list'>
                                            <div class="card card-custom card-stretch gutter-b">
                                                <div class="card-header border-0 pt-5">
                                                    <h3 class="card-title align-items-start flex-column">
                                                        <span class="card-label font-weight-bolder text-dark">Locations</span>
                                                        <span class="text-muted mt-3 font-weight-bold font-size-sm">Pending</span>
                                                    </h3>
                                                </div>
                                                <div class="card-body pt-8">
                                                    <?php
                                                    $curl = curl_init();

                                                    curl_setopt_array($curl, array(
                                                        CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/auth/login",
                                                        CURLOPT_RETURNTRANSFER => true,
                                                        CURLOPT_ENCODING => "",
                                                        CURLOPT_MAXREDIRS => 10,
                                                        CURLOPT_TIMEOUT => 0,
                                                        CURLOPT_FOLLOWLOCATION => true,
                                                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                                        CURLOPT_CUSTOMREQUEST => "POST",
                                                        CURLOPT_POSTFIELDS =>"{\n  \"username\" : \"taifu\", \n  \"password\" : \"".config('app.cm_pass')."\" \n}",
                                                        CURLOPT_HTTPHEADER => array(
                                                            "Content-Type: application/json"
                                                        ),
                                                    ));
                                            
                                                    $response = curl_exec($curl);
                                            
                                                    curl_close($curl);
                                                    $apiToken = json_decode($response,true)["apiToken"];

                                                    $ava_list = [];
                                                    $play_ids = [];

                                                    foreach($locations as $location){
                                                        $urlname = str_replace(" ", "%20", $location['name']);
                                                        $curl = curl_init();

                                                        curl_setopt_array($curl, array(
                                                            // CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/all?limit=1000",
                                                            CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/findByName/".$urlname,
                                                            CURLOPT_RETURNTRANSFER => true,
                                                            CURLOPT_ENCODING => "",
                                                            CURLOPT_MAXREDIRS => 10,
                                                            CURLOPT_TIMEOUT => 0,
                                                            CURLOPT_FOLLOWLOCATION => true,
                                                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                                            CURLOPT_CUSTOMREQUEST => "GET",
                                                            CURLOPT_HTTPHEADER => array(
                                                                "apiToken: ".$apiToken
                                                            ),
                                                        ));

                                                        $response = curl_exec($curl);

                                                        curl_close($curl);
                                                        $res = json_decode($response, true);
                                                        if(isset($res['id'])){
                                                            $ava_list[] = $location['name'];
                                                            $play_ids[] = $res['id'];
                                                            $exist = true;
                                                        }
                                                        else{
                                                            $exist = false;
                                                    ?>
                                                    <div class="d-flex align-items-center mb-10">
                                                        <div class="symbol symbol-40 symbol-light-primary mr-5">
                                                            <span class="symbol-label">
                                                                <span class="svg-icon svg-icon-lg svg-icon-primary">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24" height="24"/>
                                                                            <path d="M11,20 L11,17 C11,16.4477153 11.4477153,16 12,16 C12.5522847,16 13,16.4477153 13,17 L13,20 L15.5,20 C15.7761424,20 16,20.2238576 16,20.5 C16,20.7761424 15.7761424,21 15.5,21 L8.5,21 C8.22385763,21 8,20.7761424 8,20.5 C8,20.2238576 8.22385763,20 8.5,20 L11,20 Z" fill="#000000" opacity="0.3"/>
                                                                            <path d="M3,5 L21,5 C21.5522847,5 22,5.44771525 22,6 L22,16 C22,16.5522847 21.5522847,17 21,17 L3,17 C2.44771525,17 2,16.5522847 2,16 L2,6 C2,5.44771525 2.44771525,5 3,5 Z M4.5,8 C4.22385763,8 4,8.22385763 4,8.5 C4,8.77614237 4.22385763,9 4.5,9 L13.5,9 C13.7761424,9 14,8.77614237 14,8.5 C14,8.22385763 13.7761424,8 13.5,8 L4.5,8 Z M4.5,10 C4.22385763,10 4,10.2238576 4,10.5 C4,10.7761424 4.22385763,11 4.5,11 L7.5,11 C7.77614237,11 8,10.7761424 8,10.5 C8,10.2238576 7.77614237,10 7.5,10 L4.5,10 Z" fill="#000000"/>
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                                            </span>
                                                        </div>
                                                        <div class="d-flex flex-column font-weight-bold">
                                                            <a class="text-dark text-hover-primary mb-1 font-size-lg" style="cursor:pointer">{{$location['name']}}</a>
                                                        </div>
                                                    </div>
                                                    <?php }}?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-8" id='delete_list'>
                                            <!-- <div id="basicScenario"></div> -->
                                            <div class="card card-custom card-stretch gutter-b">
                                                <div class="card-header border-0 pt-5">
                                                    <h3 class="card-title align-items-start flex-column">
                                                        <span class="card-label font-weight-bolder text-dark">Master PlayList</span>
                                                        <span class="text-muted mt-3 font-weight-bold font-size-sm">Approved</span>
                                                    </h3>
                                                </div>
                                                <div class="card-body pt-8">
                                                    <div class="row">
                                                        <?php
                                                        foreach($locations as $location){
                                                            $exist = false;
                                                            foreach($ava_list as $key => $val){
                                                                if($val == $location['name']){
                                                                    $exist = true;
                                                                    $play_id = $play_ids[$key];
                                                                }
                                                            }
                                                            if($exist == true){
                                                        ?>
                                                        <div class="col-md-6">
                                                            <div class="d-flex align-items-center mb-10">
                                                                <div class="symbol symbol-40 symbol-light-success mr-5">
                                                                    <span class="symbol-label">
                                                                        <span class="svg-icon svg-icon-lg svg-icon-success">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                                    <rect x="0" y="0" width="24" height="24"/>
                                                                                    <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="#000000" opacity="0.3"/>
                                                                                    <path d="M10.875,15.75 C10.6354167,15.75 10.3958333,15.6541667 10.2041667,15.4625 L8.2875,13.5458333 C7.90416667,13.1625 7.90416667,12.5875 8.2875,12.2041667 C8.67083333,11.8208333 9.29375,11.8208333 9.62916667,12.2041667 L10.875,13.45 L14.0375,10.2875 C14.4208333,9.90416667 14.9958333,9.90416667 15.3791667,10.2875 C15.7625,10.6708333 15.7625,11.2458333 15.3791667,11.6291667 L11.5458333,15.4625 C11.3541667,15.6541667 11.1145833,15.75 10.875,15.75 Z" fill="#000000"/>
                                                                                    <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000"/>
                                                                                </g>
                                                                            </svg>
                                                                        </span>
                                                                    </span>
                                                                </div>
                                                                <div class="d-flex flex-column font-weight-bold">
                                                                    <input type="text" value={{$play_id}} class='play_id' style="display:none">
                                                                    <a class="text-dark text-hover-primary mb-1 font-size-lg" style="cursor:pointer">{{$location['name']}}</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php }}?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
		<!-- <script src="/assets/js/pages/custom/user/edit-user.js?v=7.0.4"></script> -->
		<script>
            $('#add_list').find('.text-hover-primary').click(function() {
                var name = $(this).text();
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won\"t be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, approve it!"
                }).then(function(result) {
                    if (result.value) {
                        $.ajax({
                            url : '/create_master',
                            type : 'POST',
                            data : {
                                name : name
                            },
                            headers : {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success : function(res){
                                if(res == 'success'){
                                    toastr.success("Success!");
                                    setTimeout(function(){
                                        location.reload();
                                    },1000)
                                }
                                else{
                                    toastr.error("Fail to Create!");
                                }
                            }
                        })
                    }
                });
            })
            $('#delete_list').find('.text-hover-primary').click(function() {
                var delete_id = $(this).parent().parent().find('.play_id').val();
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won\"t be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, reject it!"
                }).then(function(result) {
                    if (result.value) {                    
                        $.ajax({
                            url : '/delete_master',
                            type : 'POST',
                            data : {
                                id : delete_id
                            },
                            headers : {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success : function(res){
                                if(res == 'success'){
                                    toastr.success("Success!");
                                    setTimeout(function(){
                                        location.reload();
                                    },1000)
                                }
                                else{
                                    toastr.error("Fail to Delete!");
                                }
                            }
                        })
                    }
                });
            })
            var search_name = "";
            $("#user_name").on("keyup",function(){
                search_name = $(this).val();
                $("#basicScenario").jsGrid("loadData");
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
                            url : '/get_mainplay',
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
                    { title: "Business Name", name: "business_name", type: "text", width: "150px",align: "left"},
                    { title: "PlayList Id", name: "playlist_id", type: "text", width: "150px",align: "left"},
                    // { type: "control"}
                ]
            });
		</script>
	</body>
</html>
		