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
                                                <td>
                                                    {{
                                                        $val->sub_inv_id==null?$val->id:11000 + $val->sub_inv_id
                                                    }}
                                                </td>
                                                <td>
                                                    {{$val->inv_date==null?$val->invoice_date:$val->inv_date}}
                                                </td>
                                                <td>
                                                    @foreach($users as $user)
                                                        @if($user->id == $val->client_id)
                                                            {{$user->business_name}}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <?php
                                                    if($val->pay_date != null){
                                                        $created = date_create($val->pay_date);
                                                        echo date_format($created, "m-d-Y H:i:s");
                                                    }
                                                    ?>
                                                </td>
                                                <th>{{$check_id != 0?$check_id + 10000: ""}}</th>
                                                <td>${{number_format($val->part_amount * 103.4 / 100,2)}}</td>
                                                <td><?php
                                                    echo $manual_invoice==true?'<span class="label label-xl label-primary label-inline mr-2">ACH</span>':
                                                    '<span class="label label-xl label-danger label-inline mr-2">Check</span>'?></td>
                                                <td>
                                                    ${{number_format($val->part_amount * 103.4 / 100,2)}}
                                                </td>
                                                <td>
                                                    <?php
                                                        $paid = false;
                                                    ?>
                                                    @if($val->paid > 0 && (strtotime($val->invoice_date) > strtotime($today)) || ($val->sub_status == 1))
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
                                                <td style="min-width : 150px">
                                                    <a href="/view-invoice/{{$val->id}}/{{$val->sub_inv_id}}" data-container="body" data-toggle="tooltip" data-placement="bottom" title="View Invoice">
                                                        <i class="fa fa-eye text-success mr-4"></i>
                                                    </a>
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
    @include("admin.include.admin-footer")

    <script>var HOST_URL = "https://keenthemes.com/metronic/tools/preview";</script>
    <script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
    <script src="/assets/plugins/global/plugins.bundle.js"></script>
    <script src="/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
    <script src="/js/suggest.js"></script>
    <script src="/assets/js/scripts.bundle.js"></script>
    <script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="/assets/js/invoice.js"></script>