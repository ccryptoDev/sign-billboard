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
                                    <select class="form-control business-name">
                                        <option value="">All</option>
                                        @foreach($business_name as $temp)
                                        <option value="{{$temp->business_name}}">{{$temp->business_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
							</div>
                            <div class='card-body'>
								<table class="table table-bordered table-hover table-checkable" id="kt_datatable">
                                    <thead>
                                        <tr>
                                            <th>Business Name</th>
                                            <th>Location</th>
                                            <!-- Not Collected by Users(Avaiable) -->
                                            <th>Settled</th>
                                            <!-- Paid by Client -->
                                            <th>Locked Revenue</th>
                                            <!-- Not Paid by Client -->
                                            <th>Projected Revenue</th>
                                            <th>Available Revenue</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($invoices as $key => $val)
                                            <tr>
                                                <td>{{$val->business_name}}</td>
                                                <td>
                                                    <?php
                                                        $temp = json_decode($val->data);
                                                        foreach($temp as $item){
                                                            echo isset($item->location_name)?$item->location_name.",":'';
                                                        }
                                                    ?>
                                                </td>
                                                <?php
                                                $collect = 0;
                                                if($val->status == 1){
                                                    $collect = $val->amount;
                                                }
                                                else{
                                                    $collect = $val->part_amount * $val->paid;
                                                }
                                                ?>
                                                <td>
                                                    $ {{number_format($collect, 2)}}
                                                </td>
                                                <!-- Remaining By Client -->
                                                <td>
                                                    @if($val->status == 1)
                                                        $ {{number_format(0, 2)}}
                                                    @else
                                                        $ {{number_format(($val->amount - $val->part_amount * $val->paid), 2)}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($val->status == 1)
                                                        $ {{number_format(0, 2)}}
                                                    @else
                                                        $ {{number_format(($val->amount - $val->part_amount * $val->paid), 2)}}
                                                    @endif
                                                </td>
                                                <td>
                                                    $ {{number_format(($collect), 2)}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- <div class="card-footer">
                                <button class="btn btn-danger float-right">Pay Me</button>
                            </div> -->
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
    <script src="/js/inputmask.js"></script>
    <script src="/assets/js/income-table.js"></script>
    <script>

    </script>