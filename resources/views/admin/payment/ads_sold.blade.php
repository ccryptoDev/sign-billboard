@include('admin.include.admin-header')
<link href="/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader min-h-lg-15px pt-5 pb-7 subheader-transparent" id="kt_subheader">
		</div>
		<div class="d-flex flex-column-fluid">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="card card-custom" data-card="true" id="kt_card_1">
							<div class="card-header">
								<div class="card-title">
									<h3 class="card-label">{{$page_name}}</h3>
								</div>
							</div>
							<?php
							$day = date('w');
							$week_start = date('m/d/Y', strtotime('-'.$day.' days'));
							$week_end = date('m/d/Y', strtotime('+'.(6-$day).' days'));
							?>
                            <div class='card-body'>
								<div class="row">
									<div class="col-md-12">
                                        <div class="d-flex align-items-center mb-3 bg-light-success rounded p-5">
                                            <span class="svg-icon svg-icon-warning mr-5">
                                                <i class="text-success fas fa-user"></i>
                                            </span>
                                            <div class="d-flex flex-column flex-grow-1 mr-2">
                                                <a class="font-weight-bold text-dark-75 font-size-lg mb-1">Select Business Name Below</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <select class="form-control business-name select2">
											<option value="">All</option>
											@foreach($business_name as $temp)
											<option value="{{$temp->business_name}}">{{$temp->business_name}}</option>
											@endforeach
										</select>
                                    </div>
									<div class="col-md-12">
                                        <div class="d-flex align-items-center mb-3 bg-light-success rounded p-5">
                                            <span class="svg-icon svg-icon-warning mr-5">
                                                <i class="text-success far fa-clock"></i>
                                            </span>
                                            <div class="d-flex flex-column flex-grow-1 mr-2">
                                                <a class="font-weight-bold text-dark-75 font-size-lg mb-1">Select Date below</a>
                                            </div>
                                        </div>
                                    </div>
									<div class="col-md-6">
										<label>Start Date</label>
										<input type="text" class="form-control date" placeholder="Start date" value="{{$week_start}}"/>
									</div>
									<div class="col-md-6">
										<label>End Date</label>
										<input type="text" class="form-control date" placeholder="End date" value="{{$week_end}}"/>
									</div>
									<div class="col-md-12">
										<div id="chart_6"></div>
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
	<script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="/js/inputmask.js"></script>
	<script>
        "use strict";
		var color_list = ['#6993FF', '#1BC5BD', '#8950FC', '#FFA800', '#F64E60'];
		var series = "";
		series = '';

		// Shared Colors Definition
		const primary = '#6993FF';
		const success = '#1BC5BD';
		const info = '#8950FC';
		const warning = '#FFA800';
		const danger = '#F64E60';
		
		var KTApexChartsDemo = function () {
			// Private functions

			var _sold_chart = function () {
				const apexChart = "#chart_6";
				var options = {
					series: [
						{
							data: []
						}
					],
					chart: {
						height: 0,
						type: 'rangeBar'
					},
					plotOptions: {
						bar: {
							horizontal: true,
							distributed: true,
							dataLabels: {
								hideOverflowingLabels: false
							}
						}
					},
					dataLabels: {
						enabled: true,
						formatter: function (val, opts) {
							var label = opts.w.globals.labels[opts.dataPointIndex]
							var a = moment(val[0])
							var b = moment(val[1])
							var diff = b.diff(a, 'days')
							return label + ': ' + diff + (diff > 1 ? ' days' : ' day')
						},
						style: {
							colors: ['#f3f4f5', '#fff']
						}
					},
					xaxis: {
						type: 'datetime'
					},
					yaxis: {
						show: false
					},
					grid: {
						row: {
							colors: ['#f3f4f5', '#fff'],
							opacity: 1
						}
					}
				};

				var chart = new ApexCharts(document.querySelector(apexChart), options);
				chart.render();
				update_chart()
				$(".business-name").on('change', function(){
					KTApp.blockPage();
					update_chart($(this).val())
				})
				function update_chart(name){
					$.ajax({
						url : "/get-sold",
						type : "GET",
						data : {
							name : name
						},
						success : function(res){
							KTApp.unblockPage();
							if(res['success'] == true){
								chart.updateSeries([{
									data : res['series']
								}])
								chart.updateOptions({
									chart: {
										height : 80 * (res['total_num'] + 1)
									}
								})
							}
							else{
								toastr.error(res);
							}
						},
						error : function(err){
							toastr.error("Please refresh your browser");
							KTApp.unblockPage();
						}
					})
				}
			}

			return {
				// public functions
				init: function () {
					_sold_chart();
				}
			};
		}();

		jQuery(document).ready(function () {
			KTApexChartsDemo.init();
			$('.date').datepicker({
				rtl: KTUtil.isRTL(),
				todayHighlight: true,
				orientation: "bottom left",
			});
			$('.select2').select2({
				placeholder: "Select a businss name"
			});
		});
	</script>