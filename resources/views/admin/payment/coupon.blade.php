@include('admin.include.admin-header')
<style>
    i{
        cursor :pointer
    }
</style>
<link href="/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
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
                                <div class="card-toolbar">
                                    <button class="btn btn-success" data-toggle="modal" data-target="#newModal">New Coupon</button>
                                    <button class="btn btn-success btnUpdate" data-toggle="modal" data-target="#editModal" style="display:none">Edit Coupon</button>
                                </div>
							</div>
							<div class="card-body">
                                <table class="table table-bordered table-hover table-checkable" id="kt_datatable" style="margin-top: 13px !important">
                                    <thead>
                                        <tr>
                                            <th>Coupon Number</th>
                                            <th>Business Name</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Number of weeks</th>
                                            <th>Amount</th>
                                            <th>Type</th>
                                            <th>Coupon Used</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $week_type = ["Week", "Fixed", "Percentage"];
                                    $today = date("Y-m-d");
                                    ?>
                                    <tbody>
                                        @foreach($coupon as $key => $val)
                                            <tr>
                                                <td>{{$val->id}}</td>
                                                <td>{{$val->business_name}}</td>
                                                <td>
                                                    <?php
                                                    $created = date_create($val->start_date);
                                                    echo date_format($created, "m-d-Y");
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $created = date_create($val->end_date);
                                                    echo date_format($created, "m-d-Y");
                                                    ?>
                                                </td>
                                                <td>{{$val->type==0?$val->weeks:''}}</td>
                                                <td>{{$val->type==0?'':$val->amount}}</td>
                                                <td>{{$week_type[$val->type]}}</td>
                                                <?php
                                                    $coupon_date = "";
                                                    $coupon_end = "";
                                                ?>
                                                @foreach($campaigns as $item)
                                                    @if($val->id == $item->coupon && $coupon_date == "")
                                                        <?php
                                                        $coupon_date = $item->start_date;
                                                        $coupon_end = $item->end_date;
                                                        ?>
                                                    @endif
                                                @endforeach
                                                <td>
                                                    <?php 
                                                        if($coupon_date != ""){
                                                            $created = date_create($coupon_date);
                                                            echo date_format($created, "m-d-Y");
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    @if($coupon_end == "" && $val->end_date < $today)
                                                        <span class="label label-xl label-danger label-pill label-inline mr-2">Expired</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <i class='fa fa-edit text-success mr-5'
                                                        data-id="{{$val->id}}"
                                                        data-type="{{$val->type}}"
                                                        data-start="{{$val->start_date}}"
                                                        data-end="{{$val->end_date}}"
                                                        data-weeks="{{$val->weeks}}"
                                                        data-amount="{{$val->amount}}"
                                                        data-name="{{$val->business_name}}"
                                                        title='Edit'
                                                    ></i>
                                                    <i class="fa fa-envelope-open-text text-info mr-5 send-email" title="Send Email" 
                                                        onclick="send_email('{{$val->business_name}}')"
                                                    ></i>
                                                    <i class="fa fa-heart text-primary mr-5 send-email" title="Referral Thank You with Coupon" 
                                                        onclick="refer_email('{{$val->business_name}}')"
                                                    ></i>
                                                    <i class='fa fa-trash text-danger' onclick="delete_coupon('{{$val->id}}')" totle="Delete"></i>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    <div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Coupon</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form id="frmNew">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Business Name</label>
                            <select class="form-control selectpicker" name="business_name[]" id="business_name" multiple required>
                                <option value="All">All</option>
                                @foreach($business_name as $key => $val)
                                    <option value="{{$val->business_name}}">{{$val->business_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Coupon Type</label>
                            <div class="radio-inline cop-type">
                                <label class="radio">
                                    <input type="radio" name="type" value="0" checked/>
                                    <span></span>
                                    Week
                                </label>
                                <label class="radio">
                                    <input type="radio" name="type" value="1"/>
                                    <span></span>
                                    Fixed
                                </label>
                                <label class="radio">
                                    <input type="radio" name="type" value="2"/>
                                    <span></span>
                                    Percentage
                                </label>
                            </div>
                        </div>
                        <div class="form-group amount-tag" style="display:none">
                            <label>Amount</label>
                            <input class="form-control amount" type="text" name="amount" data-inputmask-alias="numeric" value="0">
                        </div>
                        <div class="form-group weeks">
                            <label>Number of weeks</label>
                            <input class="form-control" type="number" name="weeks" value="1">
                        </div>
                        <div class="form-group">
                            <label>Start Date</label>
                            <input class="form-control" type="date" name="start_date" value="{{date('Y-m-d')}}" required>
                        </div>
                        <div class="form-group">
                            <label>End Date</label>
                            <input class="form-control" type="date" name="end_date" value='{{date("Y-m-d", strtotime("+1 week"))}}' required>
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
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Coupon</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form id="frmUpdate">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Business Name</label>
                            <input class="form-control id" type="text" name="id" style="display:none">
                            <select class="form-control selectpicker name" name="business_name" required>
                                @foreach($business_name as $key => $val)
                                    <option value="{{$val->business_name}}">{{$val->business_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Coupon Type</label>
                            <div class="radio-inline cop-type">
                                <label class="radio">
                                    <input type="radio" name="type" value="0"/>
                                    <span></span>
                                    Week
                                </label>
                                <label class="radio">
                                    <input type="radio" name="type" value="1"/>
                                    <span></span>
                                    Fixed
                                </label>
                                <label class="radio">
                                    <input type="radio" name="type" value="2"/>
                                    <span></span>
                                    Percentage
                                </label>
                            </div>
                        </div>
                        <div class="form-group amount-tag" style="display:none">
                            <label>Amount</label>
                            <input class="form-control amount" type="text" name="amount" data-inputmask-alias="numeric" value="0">
                        </div>
                        <div class="form-group weeks">
                            <label>Number of weeks</label>
                            <input class="form-control" type="number" name="weeks" value="1">
                        </div>
                        <div class="form-group">
                            <label>Start Date</label>
                            <input class="form-control" type="date" name="start_date" value="{{date('Y-m-d')}}" required>
                        </div>
                        <div class="form-group">
                            <label>End Date</label>
                            <input class="form-control" type="date" name="end_date" value='{{date("Y-m-d", strtotime("+1 week"))}}' required>
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
	<script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>
	<script src="/assets/js/invoice.js"></script>
    <script src="/js/inputmask.js"></script>
	<script>
        function delete_coupon(id){
            // var id = $(this).data('id');
            Swal.fire({
                title: "Are you sure?",
                text: "You won\"t be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url : "/delete-coupon/"+id,
                        type : "GET",
                        success : function(res){
                            location.reload();
                        },
                        error : function(err){
                            toastr.error("Please refresh your browser");
                        }
                    })
                }
            });
        }
        function send_email(business_name){
            KTApp.blockPage();
            $.ajax({
                url : 'email-coupon',
                type : "GET",
                data : {
                    business_name : business_name
                },
                success : function(res){
                    KTApp.unblockPage();
                    if(res == 'success'){
                        toastr.success("Success");
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
        }
        function refer_email(business_name){
            KTApp.blockPage();
            $.ajax({
                url : 'refer-coupon',
                type : "GET",
                data : {
                    business_name : business_name
                },
                success : function(res){
                    KTApp.unblockPage();
                    if(res == 'success'){
                        toastr.success("Success");
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
        }
		$(document).ready(function(){
            $(".amount").inputmask({reverse: true, rightAlign: false,});
            $("#business_name").on('change', function(){
                get_list();
            })
            $(".cop-type input").on('change', function(){
                if($(this).val() == 0){
                    $(".amount-tag").css('display', "none");
                    $(".weeks").css('display', "block");
                }
                else{
                    $(".amount-tag").css('display', "block");
                    $(".weeks").css('display', "none");
                }
            })
            function get_list(){
                var list = [];
                var all_flag = false;
                $('#business_name option:selected').each(function(){
                    if($(this).val() == 'All'){
                        all_flag = true;
                    }
                });
            }
            $("#frmNew").submit(function(event){
                event.preventDefault();
                KTApp.blockPage();
                var fs = new FormData(document.getElementById('frmNew'));
                $.ajax({
                    url : "/save-coupon",
                    type : "POST",
                    data : fs,
                    contentType : false,
                    processData : false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success : function(res){
                        KTApp.unblockPage();
                        if(res == 'success'){
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
            $("#frmUpdate").submit(function(event){
                event.preventDefault();
                KTApp.blockPage();
                var fs = new FormData(document.getElementById('frmUpdate'));
                $.ajax({
                    url : "/update-coupon",
                    type : "POST",
                    data : fs,
                    contentType : false,
                    processData : false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success : function(res){
                        KTApp.unblockPage();
                        if(res == 'success'){
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
            $(".fa-edit").on('click', function(){
                $("#frmUpdate .id").val($(this).data('id'))
                $('#frmUpdate .name').val($(this).data('name')).change();
                $('#frmUpdate input[name="start_date"]').val($(this).data('start'));
                $('#frmUpdate input[name="end_date"]').val($(this).data('end'));
                $('#frmUpdate input[name="amount"]').val($(this).data('amount'));
                $('#frmUpdate input[name="weeks"]').val($(this).data('weeks'));
                var type = $(this).data('type');
                $("#frmUpdate .cop-type").find('input').each(function(){
                    if($(this).val() == type){
                        $(this).prop('checked', true)
                    }
                    if(type == 0){
                        $('#frmUpdate .amount-tag').css('display', "none");
                        $('#frmUpdate .weeks').css('display', "block");
                    }
                    else{
                        $('#frmUpdate .amount-tag').css('display', "block");
                        $('#frmUpdate .weeks').css('display', "none");
                    }
                })
                $(".btnUpdate").click();
            })
		})
	</script>
		