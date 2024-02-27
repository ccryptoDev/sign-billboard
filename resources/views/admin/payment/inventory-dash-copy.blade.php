@include('admin.include.admin-header')
<link href="/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>                    
	<style>
		@media(max-width:768px){
			#f_comp{
				margin-top:0px !important;
			}
		}
        .action i{
            cursor : pointer;
        }
	</style>
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader min-h-lg-175px pt-5 pb-7 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <div class="d-flex flex-column">
                        <h2 class="text-white font-weight-bold my-2 mr-5">{{$page_name}}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    <?php 
                        // print_r($locations);
                        $location_name = array();
                        $real_name = array();
                        $cur_ads = array();
                        $max_ad = 12;
                        $private_locations = [];
                        foreach($location_type as $key => $val){
                            if($val->type == 1){
                                $private_locations[] = $val->location_id;
                            }
                        }
                        foreach($locations as $temp_location){
                            if(!in_array($temp_location['id'], $private_locations)){
                            array_push($location_name,$temp_location['nickname']);
                                array_push($real_name,$temp_location['name']);
                                $temp_location['itemCount'] = $temp_location['itemCount'] > 12 ? 12 : $temp_location['itemCount'];
                                array_push($cur_ads,$temp_location['itemCount']);
                                // if($max_ad < $temp_location['itemCount']){
                                //     $max_ad = $temp_location['itemCount'];
                                // }
                            }
                        }

                        $sales = $dashboard['sales'];
                        $sales_name = array();
                        $sales_num = array();
                        $max_sales = 0;
                        foreach($sales as $sales_temp){
                            array_push($sales_name,$sales_temp->sales_name);
                            array_push($sales_num,$sales_temp->sales_num);
                            if($sales_temp->sales_num > $max_sales){
                                $max_sales = $sales_temp->sales_num;
                            }
                        }
                    ?>
                    <div class="col-xl-12 col-lg-12">
                        <div class="card card-custom gutter-b card-stretch">
                            <div class="card-header">
                                <div class="card-title">
                                    <div class="card-label">
                                        <div class="font-weight-bolder">Current Weekly Inventory</div>
                                        <div class="font-size-sm text-muted mt-2"></div>
                                    </div>
                                </div>
                                <div class="card-toolbar">
                                    <div>
                                        <span class="label label-xl label-dot label-success"></span> Paid
                                        <span class="label label-xl label-dot label-danger"></span> Free
                                    </div>
                                </div>
                            </div>
                            <div class="card-body d-flex flex-column px-0">
                                <?php
                                    // Today's paid and contract
                                    $paid = [];
                                    $free = [];
                                    foreach($inventory as $val){
                                        if($val->free_plan == 1){
                                            $location_free = explode(",", $val->locations);
                                            $slot_free = explode(",", $val->slots);
                                            foreach($location_free as $key => $item){
                                                if(!isset($free[$item])){
                                                    $free[$item] = intval($slot_free[$key]);
                                                }
                                                else{
                                                    $free[$item] = intval($free[$item]) + intval($slot_free[$key]);
                                                }
                                            }
                                        }
                                        if($val->free_plan == 2 || $val->inv_status == 1){
                                            $location_free = explode(",", $val->locations);
                                            $slot_free = explode(",", $val->slots);
                                            foreach($location_free as $key => $item){
                                                if(!isset($paid[$item])){
                                                    $paid[$item] = intval($slot_free[$key]);
                                                }
                                                else{
                                                    $paid[$item] = intval($paid[$item]) + intval($slot_free[$key]);
                                                }
                                            }
                                        }
                                    }
                                ?>
                                <?php
                                $total = 0;
                                ?>
                                @foreach($locations as $key => $val)
                                    @if(!in_array($val['id'], $private_locations))
                                        @if(in_array($val['id'], array_keys($free)) || in_array($val['id'], array_keys($paid)))
                                            <?php
                                                $free_num = isset($free[$val['id']])?intval($free[$val['id']]):0;
                                                $paid_num = isset($paid[$val['id']])?intval($paid[$val['id']]):0;
                                                $temp_total = $free_num + $paid_num;
                                                if($total < $temp_total){
                                                    $total = $temp_total;
                                                }
                                            ?>
                                        @endif
                                    @endif
                                @endforeach
                                @foreach($locations as $key => $val)
                                    @if(!in_array($val['id'], $private_locations))
                                        <div class="row pl-10 pr-10 mt-5">
                                            <div class="col-md-3">
                                                <span style="font-size:16px">{{$val['nickname']}}</span>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="progress" style="height: 40px;">
                                                    @if(in_array($val['id'], array_keys($paid)))
                                                        <div class="progress-bar bg-success" role="progressbar" 
                                                            style="width: {{$paid[$val['id']] / $total *100}}%; font-weight:1000;font-size : 20px"
                                                            aria-valuenow="{{$paid[$val['id']]}}" aria-valuemin="0" aria-valuemax="100"
                                                            title="{{$val['nickname']}}"
                                                        >
                                                            {{$paid[$val['id']]}}
                                                        </div>
                                                    @endif
                                                    @if(in_array($val['id'], array_keys($free)))
                                                        <div class="progress-bar bg-danger" role="progressbar" 
                                                            style="width: {{$free[$val['id']] / $total *100}}%; font-weight:1000;font-size : 20px"
                                                            aria-valuenow="{{$free[$val['id']]}}" aria-valuemin="0" aria-valuemax="100"
                                                            title="{{$val['nickname']}}"
                                                        >
                                                            {{$free[$val['id']]}}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <!--  -->
                                <!-- @foreach($location_name as $key => $val)
                                <div class="row pl-10 pr-10 mt-5">
                                    <div class="col-md-3">
                                        <span style="font-size:16px">{{$val}}</span>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="progress" style="height: 40px;">
                                            <div class="progress-bar bg-success" role="progressbar" 
                                                style="width: {{$cur_ads[$key]==0?0:intval($cur_ads[$key] / $max_ad  * 100)}}%; font-weight:1000;font-size : 20px"
                                                aria-valuenow="{{$cur_ads[$key]==0?0:intval($cur_ads[$key] / $max_ad * 100)}}" aria-valuemin="0" aria-valuemax="100"
                                                title="{{$cur_ads[$key]}}"
                                            >
                                                {{$cur_ads[$key]}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach -->
                                <div class="flex-grow-1 card-spacer-x">
                                    <?php
                                        $tops = $dashboard['tops'];
                                    ?>
                                </div>                                
                                <!-- <div id="kt_temp" data-color="danger"></div> -->
                            </div>                            
                        </div>
                    </div>
                </div>
                <?php
                    $col_code = [
                        "warning","success","danger","primary","info","warning","success","danger","primary","info"
                    ];
                ?>
            </div>
        </div>
	</div>
    @if(session('level') == 2)
    <div class="modal fade" id="updatesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Updates</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form id="frmSuggest">
                    <div class="modal-body">
                        <div class="form-group">
                            <textarea class="form-control" id="kt_autosize_1" name="content" rows="3"></textarea>
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
    <button class='btn btn-danger btn-u' data-toggle="modal" data-target="#updatesUModal" style="display:none">New Updates</button>
    <div class="modal fade" id="updatesUModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form id="frmUpdateSuggest">
                    <div class="modal-body">
                        <div class="form-group">
                            <input class="form-control" type="hidden" id="u_id" name="id"></input>
                            <textarea class="form-control" id="kt_autosize_2" name="content" rows="3"></textarea>
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
    @endif
        @include("admin.include.admin-footer")

		<script>var HOST_URL = "https://keenthemes.com/metronic/tools/preview";</script>
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
		<script src="/assets/plugins/global/plugins.bundle.js"></script>
		<script src="/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
		<script src="/js/suggest.js"></script>
		<script src="/assets/js/scripts.bundle.js"></script>
        <script src="/assets/js/pages/widgets.js"></script>
        <script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>
        <script src="/js/dashboard.js"></script>
        <?php 
            $c_user = array($dashboard['active_user'],$dashboard['inactive_user'],$dashboard['primay_user'],$dashboard['secondary_user'],$dashboard['admins']);
            $total_user = array($dashboard['total_user'],$dashboard['total_user'],$dashboard['total_user'],$dashboard['total_user'],$dashboard['total_user']);
            $temp_used = array();
            $temp_names = array();
            foreach($tops as $val => $top_temp){
                if($val < 10){
                    array_push($temp_names,$top_temp->template_name);
                    array_push($temp_used,$top_temp->total_uses);
                }
            }
        ?>
        <script>
        "use strict";

        // Class definition
        var sub_chart = "";
        var KTWidgets_cus = function() {
            var init_temp = function() {
                var element = document.getElementById("kt_temp");

                if (!element) {
                    return;
                }

                var options = {
                    series: [{
                        name: "Paid + Contract",
                        data: <?php echo json_encode($cur_ads)?>
                    },
                    {
                        name: "Free",
                        data: <?php echo json_encode($cur_ads)?>
                    },
                    ],
                    chart: {
                        type: 'bar',
                        height: 350,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: ['30%'],
                            endingShape: 'rounded'
                        },
                    },
                    legend: {
                        show: false
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
                        categories: <?php echo json_encode($location_name)?>,
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            style: {
                                colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                                fontSize: '12px',
                                fontFamily: KTApp.getSettings()['font-family']
                            },
                            // formatter: function(val) {
                            //     // return;
                            //     return "" + val.substr(0, 5) + " " +  val.substr(-10);
                            // }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                                fontSize: '12px',
                                fontFamily: KTApp.getSettings()['font-family']
                            }
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    states: {
                        normal: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: false,
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        }
                    },
                    tooltip: {
                        style: {
                            fontSize: '12px',
                            fontFamily: KTApp.getSettings()['font-family']
                        },
                        y: {
                            formatter: function(val) {
                                return "" + val + ""
                            }
                        }
                    },
                    colors: [KTApp.getSettings()['colors']['theme']['base']['success'], KTApp.getSettings()['colors']['theme']['base']['warning']],
                    grid: {
                        borderColor: KTApp.getSettings()['colors']['gray']['gray-200'],
                        strokeDashArray: 4,
                        yaxis: {
                            lines: {
                                show: true
                            }
                        }
                    }
                };

                var chart = new ApexCharts(element, options);
                chart.render();
            }
            var inti_user = function() {
                var element = document.getElementById("kt_users");

                if (!element) {
                    return;
                }

                var options = {
                    series: [{
                        name: "",
                        data: <?php echo json_encode($c_user)?>
                    }, {
                        name: 'Total Users',
                        data: <?php echo json_encode($total_user)?>
                    }],
                    chart: {
                        type: 'bar',
                        height: 350,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: ['30%'],
                            endingShape: 'rounded'
                        },
                    },
                    legend: {
                        show: false
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
                        categories: ['Active', 'Inactive', 'Primary', 'Secondary', 'Admin'],
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            style: {
                                colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                                fontSize: '12px',
                                fontFamily: KTApp.getSettings()['font-family']
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                                fontSize: '12px',
                                fontFamily: KTApp.getSettings()['font-family']
                            }
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    states: {
                        normal: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: false,
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        }
                    },
                    tooltip: {
                        style: {
                            fontSize: '12px',
                            fontFamily: KTApp.getSettings()['font-family']
                        },
                        y: {
                            formatter: function(val) {
                                return "" + val + ""
                            }
                        }
                    },
                    colors: [KTApp.getSettings()['colors']['theme']['base']['success'], KTApp.getSettings()['colors']['gray']['gray-300']],
                    grid: {
                        borderColor: KTApp.getSettings()['colors']['gray']['gray-200'],
                        strokeDashArray: 4,
                        yaxis: {
                            lines: {
                                show: true
                            }
                        }
                    }
                };

                var chart = new ApexCharts(element, options);
                chart.render();
            }
            var init_sales = function() {
                var element = document.getElementById("kt_sales");

                if (!element) {
                    return;
                }

                var options = {
                    series: [{
                        name: "",
                        data : <?php echo json_encode($sales_num);?>
                    }],
                    chart: {
                        type: 'bar',
                        height: 350,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: ['30%'],
                            endingShape: 'rounded'
                        },
                    },
                    legend: {
                        show: false
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
                        categories: <?php echo json_encode($sales_name);?>,
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            style: {
                                colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                                fontSize: '12px',
                                fontFamily: KTApp.getSettings()['font-family']
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                                fontSize: '12px',
                                fontFamily: KTApp.getSettings()['font-family']
                            }
                        },
                    },
                    fill: {
                        opacity: 1
                    },
                    states: {
                        normal: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: false,
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        }
                    },
                    tooltip: {
                        style: {
                            fontSize: '12px',
                            fontFamily: KTApp.getSettings()['font-family']
                        },
                        y: {
                            formatter: function(val) {
                                return "" + val + ""
                            }
                        }
                    },
                    colors: [KTApp.getSettings()['colors']['theme']['base']['danger'], KTApp.getSettings()['colors']['gray']['gray-300']],
                    grid: {
                        borderColor: KTApp.getSettings()['colors']['gray']['gray-200'],
                        strokeDashArray: 4,
                        yaxis: {
                            lines: {
                                show: true
                            }
                        }
                    }
                };

                var chart = new ApexCharts(element, options);
                chart.render();
            }
            var inti_sub = function() {
                var element = document.getElementById("kt_sub");

                if (!element) {
                    return;
                }

                var options = {
                    series: [{
                        name: "2 Days",
                        data: [0,0,0,0,0,0,0]
                    }],
                    chart: {
                        type: 'bar',
                        height: 350,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: ['30%'],
                            endingShape: 'rounded'
                        },
                    },
                    legend: {
                        show: false
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
                        categories: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            style: {
                                colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                                fontSize: '12px',
                                fontFamily: KTApp.getSettings()['font-family']
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                                fontSize: '12px',
                                fontFamily: KTApp.getSettings()['font-family']
                            }
                        },
                        min : 0,
                        max : 14,
                    },
                    fill: {
                        opacity: 1
                    },
                    states: {
                        normal: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: false,
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        }
                    },
                    tooltip: {
                        style: {
                            fontSize: '12px',
                            fontFamily: KTApp.getSettings()['font-family']
                        },
                        y: {
                            formatter: function(val) {
                                return "" + val + ""
                            }
                        }
                    },
                    colors: [KTApp.getSettings()['colors']['theme']['base']['success'], KTApp.getSettings()['colors']['gray']['gray-300']],
                    grid: {
                        borderColor: KTApp.getSettings()['colors']['gray']['gray-200'],
                        strokeDashArray: 4,
                        yaxis: {
                            lines: {
                                show: true
                            }
                        }
                    }
                };

                sub_chart = new ApexCharts(element, options);
                sub_chart.render();
                // update_chart($(this).attr('loc_name'));
                var sub_name = $(".sub_name").text().trim();
                update_chart(sub_name);
                $(".loc_name").click(function(){
                    $(".nic_name").text($(this).text());
                    update_chart($(this).attr('loc_name'));
                })
            }
            return {
                init: function() {
                    inti_user();
                    init_temp();
                    init_sales();
                    inti_sub();
                }
            }
        }();
        jQuery(document).ready(function() {
            KTWidgets_cus.init();
        });
        function update_chart(name){
            KTApp.block('#kt_sub', {
                overlayColor: '#000000',
                state: 'danger',
                message: 'Please wait...'
            });
            $.ajax({
                url : 'get_sub',
                type : 'post',
                data : {
                    name : name
                },
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success : function(res){
                    KTApp.unblock('#kt_sub');
                    sub_chart.updateSeries([{
                        name: 'Sales',
                        data: res
                    }])
                }
            })
        }
        </script>
	</body>
</html>
		