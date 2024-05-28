@include('admin.include.admin-header')
<link href="/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
<style>
    .label {
        cursor: pointer;
    }
</style>
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<!--begin::Subheader-->
		<div class="subheader min-h-lg-15px pt-5 pb-7 subheader-transparent" id="kt_subheader">
		</div>
		<div class="d-flex flex-column-fluid">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="card card-custom" data-card="true" id="kt_card_1">
							<div class="card-header card-header-tabs-line">
								<div class="card-title">
									<h3 class="card-label">{{$page_name}}</h3>
								</div>
                                <div class="card-toolbar">
									<ul class="nav nav-tabs nav-bold nav-tabs-line">
										<li class="nav-item">
                                            <a class="nav-link" href="/transfer-history">
                                                <span class="nav-icon"><i class="far fa-list-alt text-dark"></i></span>
                                                <span class="nav-text text-dark">Transfer History</span>
                                            </a>
                                        </li>
										<li class="nav-item">
											<a class="nav-link" href="/current-revenue">
												<span class="nav-icon"><i class="far fa-list-alt text-dark"></i></span>
												<span class="nav-text text-dark">Current Revenue</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
							<div class="card-body">
                                <table class="table table-bordered table-hover table-checkable" id="kt_datatable" style="margin-top: 13px !important">
                                    <thead>
                                        <tr>
                                            <th>Business</th>
                                            <th>Invoice #</th>
                                            <th>Payment Plan</th>
                                            <th>Payment Period Started</th>
                                            <th>Payment Period Ended</th>
                                            <!-- <th>Location</th> -->
                                            <th>Total</th>
                                            <th>Average Coupon</th>
                                            <th>Average Discounted Price</th>
                                            <!-- <th>Commission</th> -->
                                            <th>INEX</th>
                                            <th>Franchise</th>
                                            <th>AM</th>
                                            <th>Account Manager</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $plan = ['In Full', 'Weekly', '4 Weeks', '12 weeks'];
                                    $plan_nums = [0, 1, 4, 12];
                                    ?>
                                    <tbody>
                                        @foreach($invoices as $key => $val)
                                            @if(($val->status == 1 || $val->paid != 0) && $val->sub_id != null)
                                            <tr>
                                                <td>{{$val->business_name}}</td>
                                                <td>#{{$val->sub_id?11000 + $val->sub_id : $val->id}}</td>
                                                <td>{{isset($plan[$val->sch])?$plan[$val->sch]:''}}</td>
                                                <?php
                                                    $start_date = date_create($val->start_date);
                                                    $end_date = date_create($val->end_date);
                                                    if($val->campaign_id == 0){
                                                        $extra = json_decode($val->description, true);
                                                        $start_date = date_create($extra['due']);
                                                        $end_date = date_create($extra['due']);
                                                    }
                                                    $start_date = "";
                                                    $end_date = "";
                                                    // foreach($checkout as $check){
                                                    //     if($check->invoice_id == $val->id){
                                                    //         if($start_date == ""){
                                                                // $start_date = $check->created_at;
                                                                $start_date = date_create($val->start_date);

                                                                // $start_date = date_format($start_date, "m-d-Y");
                                                                $start_date = date_format($start_date, "Y-m-d");

                                                                // $end_date = date_create($val->invoice_date);
                                                                $end_date = date_create($val->end_date);

                                                                // $end_date = date_format($end_date, "m-d-Y");
                                                                $end_date = date_format($end_date, "Y-m-d");
                                                    //         }
                                                    //     }
                                                    // }
                                                    if($val->sub_id){
                                                        $start_date = date_create($val->sub_date);

                                                        // $start_date = date_format($start_date, "m-d-Y");
                                                        $start_date = date_format($start_date, "Y-m-d");

                                                        if($val->sch != 0){
                                                            $diff_days = $plan_nums[$val->sch] * 7 - 1;

                                                            // $end_date = date('m-d-Y', strtotime('+'.$diff_days.' days', strtotime($val->sub_date)));
                                                            $end_date = date('Y-m-d', strtotime('+'.$diff_days.' days', strtotime($val->sub_date)));
                                                        }  else {
                                                            $diff_days = $val->weeks * 7 - 1;

                                                            // $end_date = date('m-d-Y', strtotime('+'.$diff_days.' days', strtotime($val->sub_date)));  
                                                            $end_date = date('Y-m-d', strtotime('+'.$diff_days.' days', strtotime($val->sub_date)));  
                                                        }
                                                    }
                                                ?>
                                                <td>
                                                    {{$start_date}}
                                                </td>
                                                <td>
                                                    {{$end_date}}
                                                </td>
                                                <?php
                                                $data = json_decode($val->data, true);
                                                $locations = "";
                                                $sub_total = 0;
                                                $total = 0;        
                                                $weeks = $val['weeks'];
                                                if($val->status != 1){
                                                    $weeks = $val['paid'];
                                                }
                                                if($val->sch != 0){
                                                    $weeks = $plan_nums[$val->sch];
                                                }
                                                foreach($data as $temp){
                                                    $locations .= isset($temp['location_name'])?$temp['location_name']:''.',';
                                                    $sub_total += $val->campaign_id==0?$val->part_amount:$temp['sub_total'] * $weeks;
                                                    $total = $val->campaign_id==0?$val->part_amount:$temp['price'] * $weeks;
                                                    $sub_total = $val->campaign_id==0?$val->part_amount:$temp['sub_total'] * $weeks;
                                                    $coupon_amount = 0;
                                                    if($val->coupon_amount != null){
                                                        $coupon_amount = $val->coupon_amount * $weeks;
                                                    }
                                                    $calc = $sub_total - $coupon_amount;
                                                }
                                                $coupon_amount = 0;
                                                if($val->coupon_amount != null){
                                                    $coupon_amount = $val->coupon_amount * $weeks;
                                                }
                                                // $sub_total = $sub_total - $coupon_amount;
                                                $sub_total = $val->part_amount;
                                                ?>
                                                <!-- <td>{{$locations}}</td> -->
                                                <td>
                                                    ${{number_format($sub_total, 2)}}
                                                </td>
                                                <td>
                                                    ${{number_format($coupon_amount, 2)}}
                                                </td>
                                                <td>
                                                    ${{number_format($sub_total, 2)}}
                                                </td>
                                                <?php
                                                $per = 0;
                                                $per = isset($revenue->inex)?$revenue->inex:0;
                                                $inex_amo = $sub_total * $per / 100;
                                                $per = isset($revenue->franch)?$revenue->franch:0;
                                                $fra_amo = $sub_total * $per / 100;
                                                $per = isset($revenue->account)?$revenue->account:0;
                                                $acc_amo = $sub_total * $per / 100;                                                
                                                ?>
                                                <td>
                                                    <span class="label label-xl label-{{$val->transfer_inex == 1?'success' : 'danger'}} label-inline mr-2 h-auto pt-0 pb-0"
                                                        onclick="change_status('{{$val->sub_id}}', '0')"
                                                    >
                                                        {{$val->transfer_inex === 1?'PAID' : 'UNPAID'}} - ${{number_format($inex_amo, 2)}}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="label label-xl label-{{$val->transfer_fr == 1?'success' : 'danger'}} label-inline mr-2 h-auto pt-0 pb-0"
                                                        onclick="change_status('{{$val->sub_id}}', '1')"
                                                    >
                                                        {{$val->transfer_fr === 1?'PAID' : 'UNPAID'}} - ${{number_format($fra_amo, 2)}}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="label label-xl label-{{$val->transfer == 1?'success' : 'danger'}} label-inline mr-2 h-auto pt-0 pb-0"
                                                        onclick="change_status('{{$val->sub_id}}', '2')"
                                                    >
                                                        {{$val->transfer === 1?'PAID' : 'UNPAID'}} - ${{number_format($acc_amo, 2)}}
                                                    </span></td>
                                                <td>{{$val->am}}</td>
                                            </tr>
                                            @endif
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
	@include("admin.include.admin-footer")

	<script>var HOST_URL = "https://keenthemes.com/metronic/tools/preview";</script>
	<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
	<script src="/assets/plugins/global/plugins.bundle.js"></script>
	<script src="/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
	<script src="/js/suggest.js"></script>
	<script src="/assets/js/scripts.bundle.js"></script>
	<script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script>
        var currentRouteName = @json(Route::currentRouteName());
        console.log(currentRouteName);
    </script>
	<script src="/assets/js/invoice.js"></script>
	<script>
        function change_status(id, type){
            Swal.fire({
                title: "Are you sure?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, change it!"
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url : "/change_sub_status",
                        type : "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data : {
                            id : id,
                            type : type,
                        },
                        success : function(res){
                            if(res == 'success'){
                                toastr.success("Success");
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
		$(document).ready(function(){
			
		})
	</script>
		