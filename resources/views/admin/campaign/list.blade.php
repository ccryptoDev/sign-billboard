@include('admin.include.admin-header')
<link href="/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
<link type="text/css" rel="stylesheet" href="/assets/css/tips.css" /> 
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader min-h-lg-15px pt-5 pb-7 subheader-transparent" id="kt_subheader">
    </div>
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="alert alert-custom alert-white alert-shadow fade show gutter-b tip-container" role="alert">
                <div class="alert-text">
                    <ul class="tip">
                        <a type="button" class="btn btn-text-white btn-success font-weight-bold btn-spec" data-toggle="modal" data-target="#specModal">Instructions</a>
                    </ul>
                </div>
                <div class="alert-icon d-block text-right tips">
					<a data-toggle="modal" data-target="#FaqModal" class="btn btn-text-white btn-success font-weight-bold">What is a Campaign?</a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    @if(count($campaign) == 0)
                        <div class="card card-custom wave mb-8 mb-lg-0">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-center p-12">
                                    <div class="d-flex flex-column text-center">
                                        <span class="svg-icon svg-icon-primary svg-icon-4x mb-5">
                                            <img src="/img/empty-billboard.png" width="30%"/>
                                        </span>
                                        <div class="text-dark font-weight-bold font-size-h4 mb-3">
                                            There are no campaigns
                                        </div>
                                        @if(session('level') >= 2)
                                            <a href="{{route('user-campaign')}}" class="btn btn-outline-secondary text-dark-75 text-hover-black align-items-center">
                                                Create your first campaign  <i class="la la-angle-right"></i>
                                            </a>
                                        @else
                                            <a href="{{route('client-campaign')}}" class="btn btn-outline-secondary text-dark-75 text-hover-black align-items-center">
                                                Create your first campaign  <i class="la la-angle-right"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card card-custom" data-card="true" id="kt_card_1">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">{{$page_name}}</h3>
                                </div>
                                <div class="card-toolbar">
                                    @if(session('level') >= 2)
                                    <div>
                                        <a href="{{route('user-campaign')}}" class="btn btn-dark btn-lg mr-3">Create New Campaign</a>
                                    </div>
                                    <div>
                                        <select class="form-control inv_status" autocomplete="off">
                                            <option value="">All</option>
                                            <option value="Paid">Paid</option>
                                            <option value="Free">Free</option>
                                            <option value="Contract">Contract</option>
                                            <option value="Unpaid">Unpaid</option>
                                            <option value="Overdue">Overdue</option>
                                        </select>
                                    </div>
                                    @else
                                        <a href="{{route('client-campaign')}}" class="btn btn-danger btn-lg">Create New Campaign</a>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </div>
                                @endif
                                <table class="table table-bordered table-hover table-checkable" id="kt_datatable">
                                    <thead>
                                        <tr>
                                            <th>Invoice ID</th>
                                            <th>Campaign Name</th>
                                            <th>Business Name</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Days of the week</th>
                                            <th>Number of weeks</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($campaign as $key => $val)
                                            <tr>
                                                <td>
                                                    @foreach($invoices as $inv)
                                                        @if($inv['campaign_id'] == $val->id)
                                                            {{$inv['id']}}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>{{$val->campaign_name}}</td>
                                                <td>
                                                    @foreach($users as $user)
                                                        @if($user->id == $val->user_id)
                                                            {{$user->business_name}}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <?php
                                                        $created = date_create($val->start_date);
                                                        echo date_format($created, "m-d-Y");
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        if($val->end_flag != 1){
                                                            $created = date_create($val->end_date);
                                                            echo date_create($val->end_date)?date_format($created, "m-d-Y"):'';
                                                        }
                                                        else{
                                                            echo '<span class="label label-xl label-danger label-pill label-inline mr-2">No End Date</span>';
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    {{$val->days}}
                                                </td>
                                                <td>
                                                    {{$val->end_flag==0?$val->weeks:''}}
                                                </td>
                                                <td>
                                                    <?php
                                                        $free_plan = $val['free_plan'];
                                                        $today = date("Y-m-d");
                                                        $paid_flag = false;  
                                                        $inv_status = 0;
                                                        $inv_date = "";
                                                        $inv_paid = 0;
                                                        foreach($invoices as $inv){
                                                            if($inv['campaign_id'] == $val->id){
                                                                $inv_status = $inv['status'];
                                                                $inv_date = $inv['invoice_date'];
                                                                $inv_paid = $inv['paid'];                                                            
                                                            }
                                                        }
                                                    ?>
                                                    @if($free_plan == 1)
                                                        <?php 
                                                            $free_plan = 1;
                                                        ?>
                                                        <a class="label label-xl label-primary label-inline">FREE</a>
                                                    @elseif($free_plan == 2)
                                                        <?php 
                                                        $free_plan = 2;
                                                        ?>
                                                        <a class="label label-xl label-warning label-inline">CONTRACT</a>
                                                    @elseif($free_plan == 3)
                                                        <?php 
                                                        $paid_flag = false;
                                                        ?>
                                                        <a class="label label-xl label-danger label-inline">UNPAID</a>
                                                    @else
                                                        @if($inv_status == 0)
                                                            @if($inv_paid > 0 && $inv_date > $today)
                                                                <?php $paid_flag = true?>
                                                                <a class="label label-xl label-success label-inline">PAID</a>
                                                            @else
                                                                <a href="/invoice-campaign/{{$val->id}}" class="label label-xl label-danger label-inline">UNPAID</a>
                                                            @endif
                                                        @endif
                                                        @if($inv_status == 1)
                                                            <?php $paid_flag = true?>
                                                            <a class="label label-xl label-success label-inline">PAID</a>
                                                        @endif
                                                        @if($inv_status == 2)
                                                            <a href="/invoice-campaign/{{$val->id}}" class="label label-xl label-danger label-inline">UNPAID</a>
                                                        @endif
                                                        @if($inv_status == 3)
                                                            <a class="label label-xl label-warning label-inline">INCOMPLETE</a>
                                                        @endif
                                                    @endif
                                                </td>
                                                <?php
                                                $delete_flag = 0;
                                                if($val->free_plan != 0 || $paid_flag == true){
                                                    $delete_flag = 1;
                                                }
                                                ?>
                                                <td style="min-width : 200px">
                                                    @if($delete_flag == 0)
                                                    <a href="/edit-campaign/{{$val->id}}">
                                                        <i class="fa fa-edit text-success mr-5" title="Edit Campaign"></i>
                                                    </a>
                                                    @else
                                                    <a href="/edit-campaign/{{$val->id}}">
                                                        <i class="fa fa-eye text-info mr-5" title="View Campaign"></i>
                                                    </a>
                                                    @endif
                                                    @if($val->status != 3)
                                                    <!-- <a href="/invoice-campaign/{{$val->id}}">
                                                        <i class="fas fa-file-invoice-dollar text-primary mr-5" title="View Invoice"></i>
                                                    </a> -->
                                                    <a href="/list-invoice/{{$val->id}}">
                                                        <i class="fas fa-file-invoice-dollar text-primary mr-5" title="View Invoice"></i>
                                                    </a>
                                                    <a class="switch_location" onclick="switch_location('{{$val->id}}', '{{$val->campaign_name}}')" style="cursor:pointer">
                                                        <i class="fas fa-exchange-alt text-info mr-5" title="Switch campaign to opposing side of billboard"></i>
                                                    </a>
                                                    @endif
                                                    @if(session('level') >= 2 && $paid_flag == false)
                                                        <a style="cursor:pointer" onclick="send_payment_link('<?php echo $val->id?>')">
                                                            <i class="fa fa-paper-plane text-success mr-5" data-id="{{$val->id}}" title="Send Payment Link"></i>
                                                        </a>
                                                    @endif
                                                    @if($paid_flag == true)
                                                        <a style="cursor:pointer" onclick="get_campaign('<?php echo $val->id?>', '<?php echo $val->start_date?>', '<?php echo $val->end_date?>', '<?php echo $val->weeks?>', '<?php echo $val->sch?>', '<?php echo $val->campaign_name?>', '<?php echo $inv_date?>')">
                                                            <i class="fas fa-stop text-dark mr-5" data-id="{{$val->id}}" title="Stop Campaign"></i>
                                                        </a>                                                    
                                                    @endif
                                                    @if(session('level') == 2)
                                                        <a style="cursor:pointer" onclick="delete_camp('<?php echo $val->id?>')">
                                                            <i class="fa fa-trash text-danger" data-id="{{$val->id}}" title="Delete"></i>
                                                        </a>
                                                    @endif
                                                    @if($delete_flag == 0)
                                                        @if(session('level') != 2 && $paid_flag == false)
                                                            <a style="cursor:pointer" onclick="delete_camp('<?php echo $val->id?>')">
                                                                <i class="fa fa-trash text-danger" data-id="{{$val->id}}" title="Delete"></i>
                                                            </a>
                                                            <!-- @if(strtotime($val->start_date) > strtotime(date("Y-m-d"))) -->
                                                            <!-- <a style="cursor:pointer" onclick="delete_camp('<?php echo $val->id?>')">
                                                                <i class="fa fa-trash text-danger" data-id="{{$val->id}}" title="Delete"></i>
                                                            </a> -->
                                                            <!-- @endif -->
                                                        @else
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Instruction Modal -->
<div class="modal fade" id="specModal" tabindex="-1" role="dialog" aria-labelledby="specModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="specModalLabel">Instruction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
				<ul class="mt-5">
                    <li>You must have a Campaign for your Ad Playlist to be delivered to a billboard.</li>
                    <li>The minimum length is one week (we highly advise your plan on a 12-week minimum to gain advertising traction.</li>
                    <li>You only get charged for the weeks you advertise.</li>
                    <li>You can start and stop your advertising campaigns.</li>
				</ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Display Switch Location -->
<button type="button" class="btn btn-primary btn-swtich" data-toggle="modal" data-target="#switchModal" style="display:none"></button>
<div class="modal fade" id="switchModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Switch Locations - <span id="camp_name"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="frm_switch">
                <div class="modal-body">
                    <input type="hidden" value="" name="camp_id" id="switch_camp_id">
                    <div id="switch_locations"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold c-modal" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<button type="button" class="btn btn-primary btn-stop" data-toggle="modal" data-target="#stopModal" style="display:none"></button>
<div class="modal fade" id="stopModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Stop Campaign - <span class="camp_name"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="frm_stop">
                <div class="modal-body">
                    <input type="hidden" value="" name="id">
                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="date" value="" name="start_date" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label>Number of Weeks</label>
                        <input type="number" value="" name="weeks" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label>End Date</label>
                        <input type="date" value="" name="end_date" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label>Payment method</label>
                        <div class="checkbox-list">
                            <label class="checkbox method">
                                <input type="checkbox" name="method"/>
                                <span></span>
                                Default
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Your campaign is currently scheduled to end on</label>
                        <input type="date" value="" name="inv_date" class="form-control" disabled>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold c-modal" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Stop campaign</button>
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
<script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="/assets/js/campaign-table.js"></script>
<script>
    $("#frm_switch").submit(function(event){
        // KTApp.blockPage();
        event.preventDefault();
        var fs = new FormData(document.getElementById("frm_switch"));
        $.ajax({
            url : '/save-switch',
            type : 'POST',
            data : fs,
            processData : false,
            contentType : false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : function(res){
                if(res == 'success'){
                    toastr.success("Success");
                    $(".c-modal").click();
                }
                else{
                    toastr.error(res);
                }
            }
        })
    })
    function switch_location(id, name){
        KTApp.blockPage();
        $("#switch_camp_id").val(id);
        $.ajax({
            url : "/switch_location",
            type : "POST",
            data : {
                id : id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : function(res){
                $("#camp_name").text(name);
                $("#switch_locations")[0].innerHTML = "";
                $("#switch_locations").append(res['data']);
                $(".btn-swtich").click();
                KTApp.unblockPage();
            },
            error : function(err){
                KTApp.unblockPage();
                toastr.error("Please refresh your browser");
            }
        })
    }
    <?php
    if(session('level') >= 2){
    ?>
    function send_payment_link(id){
        var id = id;
        KTApp.blockPage();
        $.ajax({
            url : '/send-link/'+id,
            type : "Get",
            success : function(res){
                KTApp.unblockPage();
                if(res == 'success'){
                    toastr.success("Success");
                }
                else{
                    toastr.error(res)
                }
            },
            error : function(err){
                KTApp.unblockPage();
                toastr.error("Pleas refresh your browser");
            }
        })
    }
    <?php }?>
    function get_campaign(id, start, end, weeks, method, name, inv_date){
        var id = id;
        $("#stopModal .camp_name").text(name)
        $('#stopModal input[name="id"]').val(id)
        $('#stopModal input[name="start_date"]').val(start)
        $('#stopModal input[name="end_date"]').val(end)
        $('#stopModal input[name="weeks"]').val(weeks)
        $('#stopModal input[name="inv_date"]').val(inv_date)
        var method_label = "";
        if(method == 0){
            method_label = "In Full";
        }
        if(method == 1){
            method_label = "Every week";
        }
        if(method == 2){
            method_label = "4 weeks";
        }
        if(method == 3){
            method_label = "12 weeks";
        }
        $("#stopModal .method").html('<input type="checkbox" name="method" checked disabled/><span></span>'+method_label);
        $(".btn-stop").click();
    }
    $("#frm_stop").submit(function(event){
        event.preventDefault();
        KTApp.blockPage();
        var fs = new FormData(document.getElementById("frm_stop"));
        $.ajax({
            url : "/stop-campaign",
            type : "POST",
            data : fs,
            processData : false,
            contentType : false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : function(res){
                KTApp.unblockPage();
                if(res == "success"){
                    location.reload();
                }
                else{
                    toastr.error(res);
                }
            },
            error : function(err){
                KTApp.unblockPage();
                toastr.error("Please refresh your browser");
            }
        })
    })
    function delete_camp(id){
        var id = id;
        Swal.fire({
            title: "Are you sure?",
            text: "You won\"t be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!"
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url : '/delete-campaign/'+id,
                    type : "Get",
                    success : function(res){
                        if(res == 'success'){
                            location.reload()
                        }
                        else{
                            toastr.error(res)
                        }
                    },
                    error : function(err){
                        toastr.error("Pleas refresh your browser");
                    }
                })
            }
        });  
    }
    $(document).ready(function(){
        $('.select2').select2({
			placeholder: "Select a Business Name"
		});
    })
</script>
