@include('admin.include.admin-header')
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
                                    @if(session('level') == 2)
                                        <a class='btn btn-success mr-4' href="/create-invoice">Create an Invoice</a>
                                    @endif
                                    <div>
                                        <select class="form-control inv_status">
                                            <option value="">All</option>
                                            <option value="Paid">Paid</option>
                                            <option value="Free">Free</option>
                                            <option value="Contract">Contract</option>
                                            <option value="Unpaid">Unpaid</option>
                                            <option value="Overdue">Overdue</option>
                                            <option value="Temp">Temp</option>
                                        </select>
                                    </div>
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
                                <?php
                                $today = date("Y-m-d");
                                ?>
                                <table class="table table-bordered table-hover table-checkable" id="kt_datatable" style="margin-top: 13px !important">
                                    <thead>
                                        <tr>
                                            <th>Invoice #</th>
                                            <th>Due Date</th>
                                            <th>Business Name</th>
                                            <th>Date Paid</th>
                                            <th>Business Check</th>
                                            <th>Invoiced Amount</th>
                                            <th>Payment Type</th>
                                            <th>Amount Paid</th>
                                            <th>Status</th>
                                            <th>Manual Override</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($invoices as $key => $val)
                                            <?php
                                            $free_plan = 0;
                                            $manual_invoice = false;
                                            $check_id = 0;
                                            if($val->campaign_id == 0){
                                                $manual_invoice = true;
                                                $extra = json_decode($val->description, true);
                                                $check_id = isset($extra['account_number'])?$extra['account_number']:0;
                                            }
                                            ?>
                                            @foreach($campaigns as $camp)
                                                @if($camp->id == $val->campaign_id)
                                                    <?php $free_plan = $camp->free_plan?>
                                                @endif
                                            @endforeach
                                            <tr>
                                                <td>{{$val->id}}</td>
                                                <td>{{$val->invoice_date}}</td>
                                                <td>
                                                    @foreach($users as $user)
                                                        @if($user->id == $val->client_id)
                                                            {{$user->business_name}}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach($checkout as $item)
                                                        @if($item->invoice_id == $val->id)
                                                            <?php
                                                            $created = date_create($item->created_at);
                                                            echo date_format($created, "m-d-Y");
                                                            ?>
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <th>{{$check_id != 0?$check_id + 10000: ""}}</th>
                                                <td>${{number_format($val->part_amount,2)}}</td>
                                                <td><?php
                                                    echo $manual_invoice==true?'<span class="label label-xl label-primary label-inline mr-2">ACH</span>':
                                                    '<span class="label label-xl label-danger label-inline mr-2">Check</span>'?></td>
                                                <td>
                                                    @foreach($checkout as $item)
                                                        @if($item->invoice_id == $val->id)
                                                            ${{number_format($item->amount, 2)}}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <?php
                                                        $paid = false;
                                                    ?>
                                                    @if($val->paid > 0 && strtotime($val->invoice_date) > strtotime($today))
                                                        <?php
                                                            $paid = true;
                                                        ?>
                                                    @endif
                                                    @if($free_plan == 1)
                                                        <span class="label label-xl label-primary label-inline mr-2">FREE</span>
                                                    @elseif($free_plan == 2)
                                                        <span class="label label-xl label-warning label-inline mr-2">CONTRACT</span>
                                                    @elseif($free_plan == 3)
                                                        <span class="label label-xl label-danger label-inline mr-2">TEMP</span>
                                                    @else
                                                        @if($val->status == 0)
                                                            @if($paid == true)
                                                                <span class="label label-xl label-success label-inline mr-2">PAID</span>
                                                            @else
                                                                <span class="label label-xl label-danger label-inline mr-2">OVERDUE</span>
                                                            @endif
                                                        @endif
                                                        @if($val->status == 1)
                                                            <span class="label label-xl label-success label-inline mr-2">PAID</span>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    <select class="form-control status" data-id="{{$val->id}}">
                                                        @if($manual_invoice == false)
                                                            <option value=""></option>
                                                            <option value="3" {{$free_plan==1?'selected':''}}>Free</option>
                                                            <option value="4" {{$free_plan==2?'selected':''}}>Contract</option>
                                                            <option value="1" {{$free_plan==0&&$val->status==1?'selected':''}}>Paid</option>
                                                            <option value="2" {{$free_plan==0&&$val->status==2?'selected':''}}>Suspend</option>
                                                            @if(session('level') == 2)
                                                            <option value="5" {{$free_plan==3?'selected':''}}>Temp</option>
                                                            @endif
                                                        @else
                                                            <option value=""></option>
                                                            <option value="1" {{$free_plan==0&&$val->status==1?'selected':''}}>Paid</option>
                                                        @endif
                                                    </select>
                                                </td>
                                                <td style="min-width : 150px">
                                                    <a href="/view-invoice/{{$val->id}}" data-container="body" data-toggle="tooltip" data-placement="bottom" title="View Invoice">
                                                        <i class="fa fa-eye text-success mr-4"></i>
                                                    </a>
                                                    <a onclick="send_invoice('{{$val->id}}')" data-container="body" data-toggle="tooltip" data-placement="bottom" title="Send Email" style="cursor:pointer">
                                                        <i class="fa fa-paper-plane text-info mr-4"></i>
                                                    </a>
                                                    <a onclick="view_contact('{{$val->bill_name}}', '{{$val->bill_phone}}', '{{$val->bill_email}}')" data-container="body" data-toggle="tooltip" data-placement="bottom" title="View Contact" style="cursor:pointer">
                                                        <i class="fa fa-user text-primary mr-4"></i>
                                                    </a>
                                                    @if($manual_invoice == true)
                                                    <a onclick="get_manual_inv('{{$val->id}}')" data-container="body" data-toggle="tooltip" data-placement="bottom" title="Input Payment information" style="cursor:pointer">
                                                        <i class="fa fa-edit text-warning mr-4"></i>
                                                    </a>
                                                    @endif
                                                    @if(session('level') == 2)
                                                    <a data-container="body" style="cursor:pointer" onclick="delete_inv('{{$val->id}}')" data-toggle="tooltip" data-placement="bottom" title="Delete Invoice">
                                                        <i class="fa fa-trash text-danger"></i>
                                                    </a>
                                                    @endif
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
    <button type="button" class="btn btn-primary btn-bill" data-toggle="modal" data-target="#billModal" style="display:none"></button>
    <div class="modal fade" id="billModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Contact</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Billing Contact</label>
                        <input class="form-control bill-contact" value="">
                    </div>
                    <div class="form-group">
                        <label>Billing Phone</label>
                        <input class="form-control bill-phone" value="">
                    </div>
                    <div class="form-group">
                        <label>Billing Email</label>
                        <input class="form-control bill-email" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-primary btn-payment" data-toggle="modal" data-target="#paymentModal" style="display:none"></button>
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Payment Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form id="frmPayment">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Business Name</label>
                            <input class="form-control" name="id" type="hidden">
                            <input class="form-control" name="business_name" value="" disabled>
                        </div>
                        <div class="form-group">
                            <label>Invoice #</label>
                            <input class="form-control" name="invoice_id" value="" disabled>
                        </div>
                        <div class="form-group">
                            <label>Amount Due</label>
                            <input class="form-control" name="amount_due" value="" disabled>
                        </div>
                        <div class="form-group">
                            <label>Tax</label>
                            <input class="form-control" name="tax" value="" disabled>
                        </div>
                        <div class="form-group">
                            <label>Business Check #</label>
                            <input class="form-control" name="business_check" value="">
                        </div>
                        <div class="form-group">
                            <label>Date Paid</label>
                            <input class="form-control" name="date_paid" value="">
                        </div>
                        <div class="form-group">
                            <label>Amount Paid</label>
                            <input class="form-control" name="amount_paid" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-light-danger">Save Changes</button>
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
        <script>
            function get_manual_inv(id){
                KTApp.blockPage();
                $.ajax({
                    url : "/get-manual-invoice/"+id,
                    type : "GET",
                    success : function(res){
                        KTApp.unblockPage();
                        if(res['success'] == true){
                            var data = res['data'];
                            $("#paymentModal input[name=id]").val(id)
                            $("#paymentModal input[name=business_name]").val(data['business_name'])
                            $("#paymentModal input[name=invoice_id]").val(data['invoice_id'])
                            $("#paymentModal input[name=amount_due]").val(data['amount_due'])
                            $("#paymentModal input[name=tax]").val(data['tax'])
                            $("#paymentModal input[name=date_paid]").val(data['date_paid'])
                            $("#paymentModal input[name=business_check]").val(data['extra']['account_number'])
                            $("#paymentModal input[name=amount_paid]").val(data['amount_paid'])
                            $(".btn-payment").click();
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
            $("#frmPayment").submit(function(event){
                event.preventDefault();
                var fs = new FormData(document.getElementById("frmPayment"));
                KTApp.blockPage();
                $.ajax({
                    url : "/change-manu-inv",
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
                            toastr.error(res)
                        }
                    },
                    error : function(err){
                        KTApp.unblockPage();
                        toastr.error("Please refresh your browser");
                    }
                })
            })
            function delete_inv(id){
                var inv_id = id;
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won\"t be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!"
                }).then(function(result) {
                    if (result.value) {
                        $.ajax({
                            url : '/delete-invoice/'+inv_id,
                            type : 'GET',
                            success : function(res){
                                if(res == 'success'){
                                    location.reload();
                                }
                                else{
                                    toastr.error(res);
                                }
                            }
                        })
                    }
                });
            }
            function send_invoice(id){
                KTApp.blockPage();
                $.ajax({
                    url : "/send-invoice/"+id,
                    type : "GET",
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
            function view_contact(name, phone, email){
                $(".bill-contact").val(name)
                $(".bill-phone").val(phone)
                $(".bill-email").val(email)
                $(".btn-bill").click();
            }
            $(document).ready(function(){
                var $sel = $('#kt_datatable').on('change','.status',function (event) {
                // var $sel = $(".status").on('change', function(event){
                    var inv_id = $(this).data('id');
                    var status = $(this).val();
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won\"t be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, change it!"
                    }).then(function(result) {
                        if (result.value) {
                            KTApp.blockPage();
                            $sel.trigger('update');
                            $.ajax({
                                url : "/change-inv-status",
                                type : "POST",
                                data : {
                                    inv_id : inv_id,
                                    status : status,
                                },
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success : function(res){
                                    KTApp.unblockPage();
                                    if(res == 'success'){
                                        toastr.success("Success")
                                    }
                                    else{
                                        toastr.error(res)
                                    }
                                },
                                error : function(err){
                                    KTApp.unblockPage();
                                    toastr.error("Please refresh your browser");
                                }
                            })
                        }
                        else{
                            // return false;
                            $sel.val( $sel.data('currVal') );     
                        }
                    })
                }).on('update', function(){
                    $(this).data('currVal', $(this).val());
                }).trigger('update');
            })
        </script>
	</body>
</html>
		