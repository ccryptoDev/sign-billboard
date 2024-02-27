@include('admin.include.admin-header')
<link href="/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<!--begin::Subheader-->
		<div class="subheader min-h-lg-15px pt-5 pb-7 subheader-transparent" id="kt_subheader">
		</div>
		<div class="d-flex flex-column-fluid">
			<div class="container-fluid">
				<div class="row">
                    <div class="col-lg-4 mt-8">
                        <div class="card card-custom gutter-b">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">
                                        Current Volume - Volume Trends
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="chart_current" class="d-flex justify-content-center"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-8">
                        <div class="card card-custom gutter-b">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">
                                        Previous Volume
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="chart_previous" class="d-flex justify-content-center"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-8">
                        <div class="card card-custom gutter-b">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">
                                        % Change
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="chart_change" class="d-flex justify-content-center"></div>
                            </div>
                        </div>
                    </div>
					<div class="col-lg-12">
						<div class="card card-custom" data-card="true" id="kt_card_1">
							<div class="card-header card-header-tabs-line">
								<div class="card-title">
									<h3 class="card-label">{{$page_name}} - Volume Trends</h3>
								</div>
                                <div class="card-toolbar">
                                    Today's Date : <?php echo date("m/d/Y")?>
                                </div>
							</div>
							<div class="card-body">
                                <?php 
                                $data = [];
                                $com_rate = 0;
                                if(session('level')==3 && isset($revenue->franch)){
                                    $com_rate = $revenue->france / 100;
                                }
                                if(session('level')==4 && isset($revenue->account)){
                                    $com_rate = $revenue->account / 100;
                                }
                                if(session('level') == 2 && isset($revenue->inex)){
                                    $com_rate = $revenue->inex / 100;
                                }
                                $week = [0,0,0];
                                $now = time();
                                ?>
                                @foreach($invoices as $key => $val)
                                    @if($val->status == 1 || $val->paid != 0)
                                        <?php
                                            $inv_data = json_decode($val->data, true);
                                            foreach($inv_data as $item){
                                                $temp = [];
                                                $your_date = strtotime($val->created_at);
                                                $datediff = $now - $your_date;

                                                $diff = round($datediff / (60 * 60 * 24));
                                                $weeks = $val['weeks'];
                                                if($val->status != 1){
                                                    $weeks = $val['paid'];
                                                }
                                                if($diff > 7 && $diff < 14){
                                                    $sub_total = $val->campaign_id==0?$val->part_amount:$item['sub_total'] * $weeks;
                                                    $coupon_amount = 0;
                                                    if($val->coupon_amount != null){
                                                        $coupon_amount = $val->coupon_amount * $weeks;
                                                    }
                                                    $sub_total = $sub_total - $coupon_amount;
                                                    $current = $sub_total * $com_rate;
                                                    $week[0] += floatval($current);
                                                }
                                                if($diff > 28 && $diff < 56){
                                                    $sub_total = $val->campaign_id==0?$val->part_amount:$item['sub_total'] * $weeks;
                                                    $coupon_amount = 0;
                                                    if($val->coupon_amount != null){
                                                        $coupon_amount = $val->coupon_amount * $weeks;
                                                    }
                                                    $sub_total = $sub_total - $coupon_amount;
                                                    $current = $sub_total * $com_rate;
                                                    $week[1] += floatval($current);
                                                }
                                                if($diff > 84 && $diff < 168){
                                                    $sub_total = $val->campaign_id==0?$val->part_amount:$item['sub_total'] * $weeks;
                                                    $coupon_amount = 0;
                                                    if($val->coupon_amount != null){
                                                        $coupon_amount = $val->coupon_amount * $weeks;
                                                    }
                                                    $sub_total = $sub_total - $coupon_amount;
                                                    $current = $sub_total * $com_rate;
                                                    $week[2] += floatval($current);
                                                }
                                                // Real
                                                if($diff < 7){
                                                    $data[0]['label'] = "Last 7 Days";
                                                    $sub_total = $val->campaign_id==0?$val->part_amount:$item['sub_total'] * $weeks;
                                                    $coupon_amount = 0;
                                                    if($val->coupon_amount != null){
                                                        $coupon_amount = $val->coupon_amount * $weeks;
                                                    }
                                                    $sub_total = $sub_total - $coupon_amount;
                                                    $current = $sub_total * $com_rate;
                                                    $data[0]['current'] = isset($data[0]['current'])?$data[0]['current'] + $current:$current;
                                                    $data[0]['coupon'] = isset($data[0]['coupon'])?$data[0]['coupon']+ floatval($coupon_amount):floatval($coupon_amount);
                                                }
                                                if($diff < 28){
                                                    $data[1]['label'] = "Last 4 Weeks";
                                                    $sub_total = $val->campaign_id==0?$val->part_amount:$item['sub_total'] * $weeks;
                                                    $coupon_amount = 0;
                                                    if($val->coupon_amount != null){
                                                        $coupon_amount = $val->coupon_amount * $weeks;
                                                    }
                                                    $sub_total = $sub_total - $coupon_amount;
                                                    $current = $sub_total * $com_rate;
                                                    $data[1]['current'] = isset($data[1]['current'])?$data[1]['current'] + $current:$current;
                                                    $data[1]['coupon'] = isset($data[1]['coupon'])?$data[1]['coupon']+ floatval($coupon_amount):floatval($coupon_amount);
                                                }
                                                if($diff < 84){
                                                    $data[2]['label'] = "Last 12 Weeks";
                                                    $sub_total = $val->campaign_id==0?$val->part_amount:$item['sub_total'] * $weeks;
                                                    $coupon_amount = 0;
                                                    if($val->coupon_amount != null){
                                                        $coupon_amount = $val->coupon_amount * $weeks;
                                                    }
                                                    $sub_total = $sub_total - $coupon_amount;
                                                    $current = $sub_total * $com_rate;
                                                    $data[2]['current'] = isset($data[2]['current'])?$data[2]['current'] + $current:$current;
                                                    $data[2]['coupon'] = isset($data[2]['coupon'])?$data[2]['coupon']+ floatval($coupon_amount):floatval($coupon_amount);
                                                }
                                            }
                                        ?>
                                    @endif
                                @endforeach
                                <?php
                                $volume = $data;
                                ?>
                                <table class="table table-bordered table-hover table-checkable" id="kt_datatable">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th>Current Volume</th>
                                            <th>Previous Volume</th>
                                            <th>% Change</th>
                                            <th>Coupons</th>
                                            <th>Given Away</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $key => $val)
                                            <tr>
                                                <td>{{$key}}</td>
                                                <td>{{$val['label']}}</td>
                                                <td>${{number_format($val['current'], 2)}}</td>
                                                <td>${{number_format($week[$key], 2)}}</td>
                                                <?php 
                                                    $rate = $week[$key] ==0 ?0:$val['current'] / $week[$key] * 100;
                                                ?>
                                                <td>{{number_format($rate, 2)}} %</td>
                                                <td>${{number_format($val['coupon'], 2)}}</td>
                                                <?php 
                                                    $coupon_rate = $val['current'] ==0 ?0:$val['coupon'] / $val['current'] * 100;
                                                ?>
                                                <td style="background-color:{{$coupon_rate>10?'red':'white'}};color:{{$coupon_rate>10?'white':'black'}}">{{number_format($coupon_rate, 2)}} %</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Client -->
                    <div class="col-lg-4 mt-8">
                        <div class="card card-custom gutter-b">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">
                                        Total Clients - Client Retention Rate
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="chart_clients" class="d-flex justify-content-center"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-8">
                        <div class="card card-custom gutter-b">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">
                                        Clients with campaigns
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="chart_campaigns" class="d-flex justify-content-center"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-8">
                        <div class="card card-custom gutter-b">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">
                                        Retention Rate
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="chart_rate" class="d-flex justify-content-center"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-8">
                        <div class="card card-custom gutter-b">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">
                                        System Average Total Clients
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="chart_atotal" class="d-flex justify-content-center"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-8">
                        <div class="card card-custom gutter-b">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">
                                        System Average Clients / Campaigns
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="chart_acamp" class="d-flex justify-content-center"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-8">
                        <div class="card card-custom gutter-b">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">
                                        System Average Retention Rate
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="chart_arate" class="d-flex justify-content-center"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mt-8">
						<div class="card card-custom" data-card="true" id="kt_card_1">
							<div class="card-header card-header-tabs-line">
								<div class="card-title">
									<h3 class="card-label">Client Retention Rate</h3>
								</div>
                                <div class="card-toolbar">
                                    Today's Date : <?php echo date("m/d/Y")?>
                                </div>
							</div>
							<div class="card-body">
                                <!-- Today, 4 weeks, 8 weeks and 12 weeks -->
                                <?php
                                $data = [];
                                $total_data = [];
                                ?>
                                @foreach($campaigns as $key => $val)
                                    <?php
                                        $your_date = strtotime($val->created_at);
                                        $datediff = $now - $your_date;

                                        $diff = round($datediff / (60 * 60 * 24));
                                        if($diff == 0){
                                            $data[0]["label"] = "Today";
                                            $data[0]['camp'] = isset($data[0]['camp'])?$data[0]['camp']+1:1;
                                        }
                                        if($diff > 0 && $diff < 28){
                                            $data[1]["label"] = "4 Weeks Ago";
                                            $data[1]['camp'] = isset($data[1]['camp'])?$data[1]['camp']+1:1;
                                        }
                                        if($diff > 28 && $diff < 56){
                                            $data[2]["label"] = "8 Weeks Ago";
                                            $data[2]['camp'] = isset($data[2]['camp'])?$data[2]['camp']+1:1;
                                        }
                                        if($diff > 56 && $diff < 84){
                                            $data[3]["label"] = "12 Weeks Ago";
                                            $data[3]['camp'] = isset($data[3]['camp'])?$data[3]['camp']+1:1;
                                        }
                                    ?>
                                @endforeach
                                @foreach($users as $key => $val)
                                    <?php
                                        $your_date = strtotime($val->created_at);
                                        $datediff = $now - $your_date;

                                        $diff = round($datediff / (60 * 60 * 24));
                                        if($diff == 0){
                                            $data[0]["label"] = "Today";
                                            $data[0]['user'] = isset($data[0]['user'])?$data[0]['user']+1:1;
                                        }
                                        if($diff > 0 && $diff < 28){
                                            $data[1]["label"] = "4 Weeks Ago";
                                            $data[1]['user'] = isset($data[1]['user'])?$data[1]['user']+1:1;
                                        }
                                        if($diff > 28 && $diff < 56){
                                            $data[2]["label"] = "8 Weeks Ago";
                                            $data[2]['user'] = isset($data[2]['user'])?$data[2]['user']+1:1;
                                        }
                                        if($diff > 56 && $diff < 84){
                                            $data[3]["label"] = "12 Weeks Ago";
                                            $data[3]['user'] = isset($data[3]['user'])?$data[3]['user']+1:1;
                                        }
                                    ?>
                                @endforeach
                                <!-- Total Data -->
                                @foreach($total_camps as $key => $val)
                                    <?php
                                        $your_date = strtotime($val->created_at);
                                        $datediff = $now - $your_date;

                                        $diff = round($datediff / (60 * 60 * 24));
                                        if($diff == 0){
                                            $total_data[0]["label"] = "Today";
                                            $total_data[0]['camp'] = isset($total_data[0]['camp'])?$total_data[0]['camp']+1:1;
                                        }
                                        if($diff > 0 && $diff < 28){
                                            $total_data[1]["label"] = "4 Weeks Ago";
                                            $total_data[1]['camp'] = isset($total_data[1]['camp'])?$total_data[1]['camp']+1:1;
                                        }
                                        if($diff > 28 && $diff < 56){
                                            $total_data[2]["label"] = "8 Weeks Ago";
                                            $total_data[2]['camp'] = isset($total_data[2]['camp'])?$total_data[2]['camp']+1:1;
                                        }
                                        if($diff > 56 && $diff < 84){
                                            $total_data[3]["label"] = "12 Weeks Ago";
                                            $total_data[3]['camp'] = isset($total_data[3]['camp'])?$total_data[3]['camp']+1:1;
                                        }
                                    ?>
                                @endforeach
                                @foreach($total_users as $key => $val)
                                    <?php
                                        $your_date = strtotime($val->created_at);
                                        $datediff = $now - $your_date;

                                        $diff = round($datediff / (60 * 60 * 24));
                                        if($diff == 0){
                                            $total_data[0]["label"] = "Today";
                                            $total_data[0]['user'] = isset($total_data[0]['user'])?$total_data[0]['user']+1:1;
                                        }
                                        if($diff > 0 && $diff < 28){
                                            $total_data[1]["label"] = "4 Weeks Ago";
                                            $total_data[1]['user'] = isset($total_data[1]['user'])?$total_data[1]['user']+1:1;
                                        }
                                        if($diff > 28 && $diff < 56){
                                            $total_data[2]["label"] = "8 Weeks Ago";
                                            $total_data[2]['user'] = isset($total_data[2]['user'])?$total_data[2]['user']+1:1;
                                        }
                                        if($diff > 56 && $diff < 84){
                                            $total_data[3]["label"] = "12 Weeks Ago";
                                            $total_data[3]['user'] = isset($total_data[3]['user'])?$total_data[3]['user']+1:1;
                                        }
                                    ?>
                                @endforeach
                                <table class="table table-bordered table-hover table-checkable" id="kt_datatable_2">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th>Total Clients</th>
                                            <th>Clients with campaigns</th>
                                            <th>Retention Rate</th>
                                            <th>System Average Total Clients</th>
                                            <th>System Average Clients / Campaigns</th>
                                            <th>System Average Retention Rate</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        ?>
                                        @foreach($data as $key => $val)
                                            <tr>
                                                <td>{{$key}}</td>
                                                <td>{{$val['label']}}</td>
                                                <?php
                                                $user_num = isset($val['user'])?$val['user']:0;
                                                $camp_num = isset($val['camp'])?$val['camp']:0;
                                                $user_num_total = isset($total_data[$key]['user'])?$total_data[$key]['user']:0;
                                                $camp_num_total = isset($total_data[$key]['camp'])?$total_data[$key]['camp']:0;
                                                ?>
                                                <td>{{$user_num}}</td>
                                                <td>{{$camp_num}}</td>
                                                <?php
                                                    $rate = $camp_num==0?0:$user_num/$camp_num;
                                                    $rate_total = $camp_num_total==0?0:$user_num_total/$camp_num_total;
                                                    $data[$key]['rate'] = number_format($rate * 100, 2);
                                                    $data[$key]['atotal'] = $user_num_total;
                                                    $data[$key]['acamp'] = $camp_num_total;
                                                    $data[$key]['rate_total'] = number_format($rate_total * 100, 2);
                                                ?>
                                                <td>
                                                    {{number_format($rate * 100, 2)}} %
                                                </td>
                                                <td>{{$user_num_total}}</td>
                                                <td>{{$camp_num_total}}</td>
                                                <td>{{number_format($rate_total * 100, 2)}} %</td>
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
	<script src="/assets/js/sales.js"></script>
	<script>
        const primary = '#6993FF';
        const success = '#1BC5BD';
        const info = '#8950FC';
        const warning = '#FFA800';
        const danger = '#F64E60';
        var KTApexChartsDemo = function () {
            var _demo1 = function () {
                const apexChart = "#chart_current";
                var options = {
                    series: [{
                        name: 'Current Volume',
                        data: [
                            <?php echo isset($volume[0]) ? number_format($volume[0]['current'],2) : 0?>, 
                            <?php echo isset($volume[1]) ? number_format($volume[1]['current'],2) : 0?>,
                            <?php echo isset($volume[2]) ? number_format($volume[2]['current'],2) : 0?>
                        ]
                    }],
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: ['Last 7 Days', 'Last 4 Weeks', 'Last 12 Weeks'],
                    },
                    yaxis: {
                        title: {
                            text: '$'
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return "$ " + val
                            }
                        }
                    },
                    colors: [primary, success, warning]
                };

                var chart = new ApexCharts(document.querySelector(apexChart), options);
                chart.render();
            }
            var _demo2 = function () {
                const apexChart = "#chart_previous";
                var options = {
                    series: [{
                        name: 'Previous Volume',
                        data: [
                            <?php echo isset($week[0]) ? $week[0] : 0?>, 
                            <?php echo isset($week[1]) ? $week[1] : 0?>,
                            <?php echo isset($week[2]) ? $week[2] : 0?>
                        ]
                    }],
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: ['Last 7 Days', 'Last 4 Weeks', 'Last 12 Weeks'],
                    },
                    yaxis: {
                        title: {
                            text: '$'
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return "$ " + val
                            }
                        }
                    },
                    colors: [success, primary, warning]
                };

                var chart = new ApexCharts(document.querySelector(apexChart), options);
                chart.render();
            }
            var _demo3 = function () {
                const apexChart = "#chart_change";
                var options = {
                    series: [{
                        name: 'Previous Volume',
                        data: [
                            <?php echo $week[0] == 0 || !isset($volume[0]) ? 0 : number_format($volume[0]['current'] / $week[0] * 100, 2)?>, 
                            <?php echo $week[1] == 0 || !isset($volume[1]) ? 0 : number_format($volume[1]['current'] / $week[1] * 100, 2)?>,
                            <?php echo $week[2] == 0 || !isset($volume[2]) ? 0 : number_format($volume[2]['current'] / $week[2] * 100, 2)?>
                        ]
                    }],
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: ['Last 7 Days', 'Last 4 Weeks', 'Last 12 Weeks'],
                    },
                    yaxis: {
                        title: {
                            text: '%'
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return val + " %"
                            }
                        }
                    },
                    colors: [danger, primary, warning]
                };

                var chart = new ApexCharts(document.querySelector(apexChart), options);
                chart.render();
            }
            var _demo4 = function () {
                const apexChart = "#chart_clients";
                var options = {
                    series: [{
                        name: 'Total Clients',
                        data: [
                            <?php echo isset($data[0]['user'])?$data[0]['user']:0?>, 
                            <?php echo isset($data[1]['user'])?$data[1]['user']:0?>, 
                            <?php echo isset($data[2]['user'])?$data[2]['user']:0?>, 
                            <?php echo isset($data[3]['user'])?$data[3]['user']:0?>
                        ]
                    }],
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: ['Today', '4 Weeks Ago', '8 Weeks Ago', '12 Weeks Ago'],
                    },
                    yaxis: {
                        title: {
                            text: ''
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return val
                            }
                        }
                    },
                    colors: [primary, danger, warning]
                };

                var chart = new ApexCharts(document.querySelector(apexChart), options);
                chart.render();
            }
            var _demo5 = function () {
                const apexChart = "#chart_campaigns";
                var options = {
                    series: [{
                        name: 'Clients with campaigns',
                        data: [
                            <?php echo isset($data[0]['camp'])?$data[0]['camp']:0?>, 
                            <?php echo isset($data[1]['camp'])?$data[1]['camp']:0?>, 
                            <?php echo isset($data[2]['camp'])?$data[2]['camp']:0?>, 
                            <?php echo isset($data[3]['camp'])?$data[3]['camp']:0?>
                        ]
                    }],
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: ['Today', '4 Weeks Ago', '8 Weeks Ago', '12 Weeks Ago'],
                    },
                    yaxis: {
                        title: {
                            text: ''
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return val
                            }
                        }
                    },
                    colors: [success, danger, warning]
                };

                var chart = new ApexCharts(document.querySelector(apexChart), options);
                chart.render();
            }
            var _demo6 = function () {
                const apexChart = "#chart_rate";
                var options = {
                    series: [{
                        name: 'Clients with campaigns',
                        data: [
                            <?php echo isset($data[0]['rate'])?$data[0]['rate']:0?>, 
                            <?php echo isset($data[1]['rate'])?$data[1]['rate']:0?>, 
                            <?php echo isset($data[2]['rate'])?$data[2]['rate']:0?>, 
                            <?php echo isset($data[3]['rate'])?$data[3]['rate']:0?>
                        ]
                    }],
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: ['Today', '4 Weeks Ago', '8 Weeks Ago', '12 Weeks Ago'],
                    },
                    yaxis: {
                        title: {
                            text: '%'
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return val + "%"
                            }
                        }
                    },
                    colors: [danger, primary, warning]
                };

                var chart = new ApexCharts(document.querySelector(apexChart), options);
                chart.render();
            }
            var _demo7 = function () {
                const apexChart = "#chart_atotal";
                var options = {
                    series: [{
                        name: 'System Average Total Clients',
                        data: [
                            <?php echo isset($data[0]['atotal'])?$data[0]['atotal']:0?>, 
                            <?php echo isset($data[1]['atotal'])?$data[1]['atotal']:0?>, 
                            <?php echo isset($data[2]['atotal'])?$data[2]['atotal']:0?>, 
                            <?php echo isset($data[3]['atotal'])?$data[3]['atotal']:0?>
                        ]
                    }],
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: ['Today', '4 Weeks Ago', '8 Weeks Ago', '12 Weeks Ago'],
                    },
                    yaxis: {
                        title: {
                            text: ''
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return val
                            }
                        }
                    },
                    colors: [primary, danger, warning]
                };

                var chart = new ApexCharts(document.querySelector(apexChart), options);
                chart.render();
            }
            var _demo8 = function () {
                const apexChart = "#chart_acamp";
                var options = {
                    series: [{
                        name: 'System Average Clients / Campaigns',
                        data: [
                            <?php echo isset($data[0]['acamp'])?$data[0]['acamp']:0?>, 
                            <?php echo isset($data[1]['acamp'])?$data[1]['acamp']:0?>, 
                            <?php echo isset($data[2]['acamp'])?$data[2]['acamp']:0?>, 
                            <?php echo isset($data[3]['acamp'])?$data[3]['acamp']:0?>
                        ]
                    }],
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: ['Today', '4 Weeks Ago', '8 Weeks Ago', '12 Weeks Ago'],
                    },
                    yaxis: {
                        title: {
                            text: ''
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return val
                            }
                        }
                    },
                    colors: [success, danger, warning]
                };

                var chart = new ApexCharts(document.querySelector(apexChart), options);
                chart.render();
            }
            var _demo9 = function () {
                const apexChart = "#chart_arate";
                var options = {
                    series: [{
                        name: 'System Average Retention Rate',
                        data: [
                            <?php echo isset($data[0]['rate_total'])?$data[0]['rate_total']:0?>, 
                            <?php echo isset($data[1]['rate_total'])?$data[1]['rate_total']:0?>, 
                            <?php echo isset($data[2]['rate_total'])?$data[2]['rate_total']:0?>, 
                            <?php echo isset($data[3]['rate_total'])?$data[3]['rate_total']:0?>
                        ]
                    }],
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: ['Today', '4 Weeks Ago', '8 Weeks Ago', '12 Weeks Ago'],
                    },
                    yaxis: {
                        title: {
                            text: '%'
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return val + "%"
                            }
                        }
                    },
                    colors: [danger, primary, warning]
                };

                var chart = new ApexCharts(document.querySelector(apexChart), options);
                chart.render();
            }
            return {
                // public functions
                init: function () {
                    _demo1()
                    _demo2()
                    _demo3()
                    _demo4()
                    _demo5()
                    _demo6()
                    _demo7()
                    _demo8()
                    _demo9()
                }
            }
        }()
		$(document).ready(function(){
            KTApexChartsDemo.init();
		})
	</script>
		