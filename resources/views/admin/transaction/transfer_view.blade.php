@include('admin.include.admin-header')
<link href="/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
<style>
@media (min-width: 992px) {
    .sub-body {
        padding: 0 12.5px;
    }
    .status {
        cursor: pointer;
    }
}
</style>
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<!--begin::Subheader-->
		<div class="subheader min-h-lg-15px pt-5 pb-7 subheader-transparent" id="kt_subheader">
            <div class="row w-100 m-0 sub-body">
                <div class="col-md-12 mb-5 d-flex" style="float:right">
                    <?php
                        $params = request()->route()->parameters;
                        $selected_id = "";
                        $user_name = '';
                        if(isset($params['id'])){
                            $selected_id = $params['id'];
                        }
                    ?>
                    @if(session('level') == 2)
                        <select class='form-control mr-5' style="width:200px" id="user">
                            <option value="">Admin</option>
                            @foreach($users as $key => $val)
                                @if($val->user_lock == 0)
                                    <?php
                                        if($selected_id == $val->id){
                                            $user_name = $val->user_name;
                                        }
                                    ?>
                                    <option value="{{$val->id}}" <?php echo $selected_id==$val->id?'selected':''?>>{{$val->user_name}} - {{$val->level==3?"Franchise":"AM"}}</option>
                                @endif
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>
		</div>
		<div class="d-flex flex-column-fluid">
			<div class="container-fluid">                
                @if($errors->any())
                    <div class="alert alert-danger">
                        <!-- <ul> -->
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        <!-- </ul> -->
                    </div>
                @endif
				<div class="row">
					<div class="col-lg-12">
						<div class="card card-custom" data-card="true" id="kt_card_1">
							<div class="card-header card-header-tabs-line">
								<div class="card-title">
									<h3 class="card-label">{{$page_name}} {{$user_name == '' ? '' : ' - ' .$user_name}}</h3>
								</div>
                                <div class="card-toolbar">
									<ul class="nav nav-tabs nav-bold nav-tabs-line">
										<li class="nav-item">
											<a class="nav-link" href="/transaction-records">
												<span class="nav-icon"><i class="far fa-chart-bar text-dark"></i></span>
												<span class="nav-text text-dark">Transaction Records</span>
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
                                <table class="table table-bordered table-hover table-checkable" id="kt_datatable">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Date Collected</th>
                                            <th>Transfer Amount</th>
                                            <!-- <th>Total Amount</th> -->
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total = 0;
                                        ?>
                                        @foreach($transfer as $key => $val)
                                            <tr>
                                                <td>{{$key + 1}}</td>
                                                <td>
                                                    <?php 
                                                        $date = date_create($val->created_at);
                                                        echo date_format($date, "m-d-Y");
                                                    ?>
                                                </td>
                                                <td>${{number_format($val->amount, 2)}}</td>
                                                <?php
                                                $total += $val->amount;
                                                ?>
                                                <!-- <td>${{number_format($total, 2)}}</td> -->
                                                <td>
                                                    @if($selected_id != '')
                                                        <a href="{{route('view-transfer', ['id' => $val->id, 'subid' => $selected_id])}}">
                                                            View paid transactions
                                                            <!-- <i class="fa fa-eye text-danger"></i> -->
                                                        </a>
                                                    @else
                                                        <a href="{{route('view-transfer', ['id' => $val->id])}}">
                                                            View paid transactions
                                                            <!-- <i class="fa fa-eye text-danger"></i> -->
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
	@include("admin.include.admin-footer")

	<script>var HOST_URL = "https://keenthemes.com/metronic/tools/preview";</script>
	<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
	<script src="/assets/plugins/global/plugins.bundle.js"></script>
	<script src="/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
	<script src="/js/suggest.js"></script>
	<script src="/assets/js/scripts.bundle.js"></script>
	<script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>
	<script src="/assets/js/export-table.js"></script>
	<script>
		$(document).ready(function(){
			<?php
                if(session('level') == 2){
            ?>
                $("#user").on('change', function(){
                    location.href="/transfer-history/"+$("#user").val()
                })
            <?php 
                }
            ?>
		})
	</script>
		