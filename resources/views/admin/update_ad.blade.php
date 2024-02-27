@include('admin.include.admin-header')
<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css" />
<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css" />      
<link href="/assets/plugins/custom/cropper/cropper.bundle.css" rel="stylesheet" type="text/css"/>                       
	<style>
		textarea::placeholder {
			color: #423b3b !important;
		}
		*, *::before, *::after : {
			color : black;
		}
        .jsgrid-header-row{
            height : 60px;
        }
		.custom-file-label::after{
			width : 100%;
		}
		.custom-file-label{
			overflow : hidden;
		}
		.custom-file-input:lang(en) ~ .custom-file-label::after {
			content: "Click to browse for your image"; 
		}
		#pos_div{
			/* position: absolute; */
		}
		.srl_text{
			display : none;
		}
		/* #temp_body{
			overflow-x : scroll !important;
		} */
		@media(max-width:1360px){
			#temp_body{
				overflow-x : scroll !important;
			}
			#dis_font{
				width : 576px;
			}
		}
		@media(max-width:768px){
			.col-md-4{
				margin-top : 1rem;
			}
            #t_bus_name_b{
                margin : 0px !important;
                width : 100% !important;
            }
            #t_bus_name_c{
                margin : 0px !important;
                width : 85% !important;
            }
            .card.card-custom > .card-header .card-toolbar{
                margin : 0.3rem 0px !important;
                width : 100% !important;
            }
			#pos_div{
				position: inherit;
				margin : 0px;
			}
			#pos_div div{
				padding : 0px;
			}
			#temp_body::-webkit-scrollbar{
				/* width : 5px; */
				height : 5px;
			}

			#dis_font{
				width : 100%;
			}
			.srl{
				overflow : scroll;
			}
			.srl::-webkit-scrollbar {
				display: block;
				width: 3px;
			}
			.srl::-webkit-scrollbar-track {
				background: transparent;
			}
				
			.srl::-webkit-scrollbar-thumb {
				background-color: #ddd;
				border-right: none;
				border-left: none;
			}
			.srl_text{
				display : block;
			}
        }
		.hide-container{
			display : none !important;
		}
    </style>
	
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader min-h-lg-15px pt-5 pb-7 subheader-transparent" id="kt_subheader">
		</div>
		<div class="d-flex flex-column-fluid">
			<div class="container">
				<div class="alert alert-custom alert-white alert-shadow fade show gutter-b" role="alert">
					<div class="alert-icon">
						<span class="svg-icon svg-icon-primary svg-icon-xl">
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
								<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									<rect x="0" y="0" width="24" height="24"/>
									<path d="M7.07744993,12.3040451 C7.72444571,13.0716094 8.54044565,13.6920474 9.46808594,14.1079953 L5,23 L4.5,18 L7.07744993,12.3040451 Z M14.5865511,14.2597864 C15.5319561,13.9019016 16.375416,13.3366121 17.0614026,12.6194459 L19.5,18 L19,23 L14.5865511,14.2597864 Z M12,3.55271368e-14 C12.8284271,3.53749572e-14 13.5,0.671572875 13.5,1.5 L13.5,4 L10.5,4 L10.5,1.5 C10.5,0.671572875 11.1715729,3.56793164e-14 12,3.55271368e-14 Z" fill="#000000" opacity="0.3"/>
									<path d="M12,10 C13.1045695,10 14,9.1045695 14,8 C14,6.8954305 13.1045695,6 12,6 C10.8954305,6 10,6.8954305 10,8 C10,9.1045695 10.8954305,10 12,10 Z M12,13 C9.23857625,13 7,10.7614237 7,8 C7,5.23857625 9.23857625,3 12,3 C14.7614237,3 17,5.23857625 17,8 C17,10.7614237 14.7614237,13 12,13 Z" fill="#000000" fill-rule="nonzero"/>
								</g>
							</svg>
						</span>
					</div>
					<div class="alert-text">
						<ul>
							<li><h4>Upload as many Ads as you wish.</h4></li>
							<li><h4>Each Ad will be seen in rotation.</h4></li>
							<li><h4>Have a specific objective for each Ad (brand marking, sale, come to store, visit web site, sale). </h4></li>
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<?php
							$get_temp = false;
						?>
						<div class="card card-custom" data-card="true" id="kt_card_1">
							<div class="card-header">
								<div class="card-title">
									<h3 class="card-label">{{$page_name}} - {{session("business_name")}} </h3>
									<span class="svg-icon svg-icon-primary svg-icon-2x" data-toggle="modal" data-target="#FaqModal" title="FAQs">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24"/>
												<circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
												<path d="M12,16 C12.5522847,16 13,16.4477153 13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 C11,16.4477153 11.4477153,16 12,16 Z M10.591,14.868 L10.591,13.209 L11.851,13.209 C13.447,13.209 14.602,11.991 14.602,10.395 C14.602,8.799 13.447,7.581 11.851,7.581 C10.234,7.581 9.121,8.799 9.121,10.395 L7.336,10.395 C7.336,7.875 9.31,5.922 11.851,5.922 C14.392,5.922 16.387,7.875 16.387,10.395 C16.387,12.915 14.392,14.868 11.851,14.868 L10.591,14.868 Z" fill="#000000"/>
											</g>
										</svg>
									</span>
								</div>
								<?php if(session('level') >= 2){
									$get_temp = true;
								?>
								<div class="card-toolbar" style="margin:0 auto">
									<div class="form-group" style="margin-bottom:0px;margin:0 auto;min-width:150px" id="t_bus_name_b">
										<select class="form-control selectpicker" id="t_bus_name" title="Business Name"  data-live-search="true" data-size="5">
											<?php foreach($business_name as $bus_temp){?>
											<option value="{{$bus_temp->business_name}}">{{$bus_temp->business_name}}</option>
											<?php }?>
										</select>
									</div>
								</div>
								<?php }?>
								<?php 
								if(session('level') !=2 && count($multi) > 1){
									$get_temp = true;
								?>
								<div class="card-toolbar" style="margin:0 auto">
									<div class="form-group" style="margin-bottom:0px;margin:0 auto;min-width:150px" id="t_bus_name_b">
										<select class="form-control selectpicker" id="t_bus_name" title="Business Name" data-live-search="true" data-size="5">
											<?php foreach($multi as $bus_temp){
												if($bus_temp->multi_id == null){
												?>
											<option value="{{$bus_temp->business_name}}">{{$bus_temp->business_name}}</option>
											<?php }
											else{
											?>
											<option value="{{$bus_temp->com_name}}">{{$bus_temp->com_name}}</option>
											<?php } } ?>
										</select>
									</div>
								</div>
								<?php }?>
							</div>
							<div class="card-body">
								<form id="ad_form">
									<div class="row">
										<div class="col-md-8">
											<div class="d-flex align-items-center mb-3 bg-light-success rounded p-5 template-container">
												<span class="svg-icon svg-icon-warning mr-5">
													<i class="text-success fas fa-clipboard-list"></i>
												</span>
												<div class="d-flex flex-column flex-grow-1 mr-2">
													<a class="font-weight-bold text-dark-75 font-size-lg mb-1">Select Template below</a>
												</div>
											</div>
											<div class="form-group" style="margin-bottom:0px;margin:0 auto;min-width:200px" id="t_bus_name_c">
												<select class="form-control selectpicker" id="t_temp_name" title="Select Template Name">
													
												</select>
											</div>
											<div class="d-flex align-items-center mb-5 bg-light-success rounded p-5 mt-5">
												<span class="svg-icon svg-icon-warning mr-5">
													<i class="text-success fas fa-image"></i>
												</span>
												<div class="d-flex flex-column flex-grow-1 mr-2">
													<a class="font-weight-bold text-dark-75 font-size-lg mb-1">Insert your image into Template below</a>
												</div>
											</div>
											<!-- <div class="form-group" style="position:relative;width:576px;margin:auto">
												<a>
													<div class="" style="background-image : url('/blank_Template.png');width:576px;height:384px;margin:0 auto;background-size:100%100%" id="dis_img">
														<img id="dis_overimg" src="/blank_overlay.png" width="60" height="60" style="position:absolute;margin-top:50px"/>
														<div><span style="white-space: break-spaces;position:relative;z-index:1;text-align:center" contenteditable="true" id="dis_font"></span></div>
													</div>
												</a>
											</div> -->
											<div class="row" style="margin:0px">
												<div class="form-group" style="position:relative;width:576px;margin:10px auto;overflow:hidden" id="temp_body">
													<a>
														<div class="" style="background-image : url('/pick_temp.png');width:576px;height:384px;margin:0px;background-size:100%100%;top:0px;left:0px;right:0px;bottom:0px;padding:0px" id="dis_img">
															<img id="dis_overimg" src="/blank_overlay.png" width="60" height="60" style="position:absolute;margin-top:50px;display:none"/>
															<div>
																<span style="white-space: break-spaces;position:absolute;z-index:1;text-align:center;left:0px;right:0px" id="dis_font"></span>
															</div>
														</div>
													</a>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="d-flex align-items-center mb-5 bg-light-success rounded p-5" id="hid_text">
														<span class="svg-icon svg-icon-warning mr-5">
															<i class="text-success fas fa-pencil-alt"></i>
														</span>
														<div class="d-flex flex-column flex-grow-1 mr-2">
															<a class="font-weight-bold text-dark-75 font-size-lg mb-1">Enter your Text into Template below</a>
														</div>
													</div>
													<div class="form-group">
														<textarea class="form-control" id="over_text" rows="3" placeholder="Enter text you wish displayed. You are limited to XX characters including spaces. Strongly suggest limit to 6-7 words"></textarea>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group" style="display: none">
												<div class="custom-file">
													<input type="file" class="custom-file-input" id="overlay_img" name="overlay_img" accept=".jpg, .png, .jpeg">
													<label class="custom-file-label" for="overlay_img">Overlay Image</label>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="row" style="margin:0px">
												<div class="col-md-8 pl-0">
													<div class="d-flex align-items-center mb-5 bg-light-success rounded p-5">
														<span class="svg-icon svg-icon-warning mr-5">
															<i class="text-success far fa-calendar-alt"></i>
														</span>
														<div class="d-flex flex-column flex-grow-1 mr-2">
															<a class="font-weight-bold text-dark-75 font-size-lg mb-1">Set your Schedule below</a>
														</div>
													</div>
													<div class="form-group row" style="margin:0">
														<div class="col-md-12 col-lg-6">
															<div class="radio-list radio_sch">
																<label class="radio radio-danger">
																	<input type="radio" name="radio" checked value="ime"> Display Continuously
																	<span></span>
																</label>
																<span class="form-text text-muted">When activated, Ad will be displayed until you manually de-activate it.The Ad will be shown 24 hours a day.</span>
																<label class="radio radio-danger" style="margin-top:10px">
																	<input type="radio" name="radio" value="frame"> Select specific Dates and Times to display this new Ad
																	<span></span>
																</label>
																<span class="form-text text-muted">Set Start Date and End Date, or Start time and End Time, or specific days of week end time to control when you want this Ad to show.</span>
															</div>
														</div>
														<div class="col-md-12 col-lg-6" id="dis_sch" style="display:none">
															<div class="form-group row">
																<label for="example-date-input" class="col-form-label">Start Date</label>
																<div class="col-12">
																	<input class="form-control" type="date" value="{{date('Y-m-d')}}" min="{{date('Y-m-d')}}" id="start_date" name="s_date">
																</div>
															</div>
															<div class="row">
																<div class="col-6">
																	<div class="form-group row">
																		<label class="col-form-label">Start Time</label>
																		<div class="col-lg-12">
																			<select class="form-control selectpicker" id="start_time" name="s_time">
																				<option>12 AM</option>
																				<option>1 AM</option>
																				<option>2 AM</option>
																				<option>3 AM</option>
																				<option>4 AM</option>
																				<option>5 AM</option>
																				<option>6 AM</option>
																				<option>7 AM</option>
																				<option>8 AM</option>
																				<option>9 AM</option>
																				<option>10 AM</option>
																				<option>11 AM</option>
																				<option>1 PM</option>
																				<option>2 PM</option>
																				<option>3 PM</option>
																				<option>4 PM</option>
																				<option>5 PM</option>
																				<option>6 PM</option>
																				<option>7 PM</option>
																				<option>8 PM</option>
																				<option>9 PM</option>
																				<option>10 PM</option>
																				<option>11 PM</option>
																			</select>
																		</div>
																	</div>
																</div>
																<div class="col-6">
																	<div class="form-group row">
																		<label class="col-form-label">End Time</label>
																		<div class="col-lg-12">
																			<select class="form-control selectpicker" id="end_time" name="e_time">
																				<option>12 AM</option>
																				<option>1 AM</option>
																				<option>2 AM</option>
																				<option>3 AM</option>
																				<option>4 AM</option>
																				<option>5 AM</option>
																				<option>6 AM</option>
																				<option>7 AM</option>
																				<option>8 AM</option>
																				<option>9 AM</option>
																				<option>10 AM</option>
																				<option>11 AM</option>
																				<option>1 PM</option>
																				<option>2 PM</option>
																				<option>3 PM</option>
																				<option>4 PM</option>
																				<option>5 PM</option>
																				<option>6 PM</option>
																				<option>7 PM</option>
																				<option>8 PM</option>
																				<option>9 PM</option>
																				<option>10 PM</option>
																				<option>11 PM</option>
																			</select>
																		</div>
																	</div>
																</div>
															</div>
															<div class="form-group">
																<label class="col-form-label">Days of Week</label>
																<div class="checkbox-inline" id="days">
																	<label class="checkbox checkbox-primary">
																		<input type="checkbox" checked="checked" value="0"> M
																		<span></span>
																	</label>
																	<label class="checkbox checkbox-primary">
																		<input type="checkbox" checked="checked" value="1"> T
																		<span></span>
																	</label>
																	<label class="checkbox checkbox-primary">
																		<input type="checkbox" checked="checked" value="2"> W
																		<span></span>
																	</label>
																	<label class="checkbox checkbox-primary">
																		<input type="checkbox" checked="checked" value="3"> T
																		<span></span>
																	</label>
																	<label class="checkbox checkbox-primary">
																		<input type="checkbox" checked="checked" value="4"> F
																		<span></span>
																	</label>
																	<label class="checkbox checkbox-primary">
																		<input type="checkbox" checked="checked" value="5"> S
																		<span></span>
																	</label>
																	<label class="checkbox checkbox-primary">
																		<input type="checkbox" checked="checked" value="6"> S
																		<span></span>
																	</label>
																</div>
															</div>
															<div class="row">
																<div class="col-6">
																	<label class="col-form-label">Option 1</label>
																	<div class="form-group">
																		<div class="radio-list radio_sch" id="no_end">
																			<label class="radio">
																				<input type="radio" name="no_end" value="0"/>
																				<span></span>
																				End Date
																			</label>
																			<label class="radio">
																				<input type="radio" checked="checked" name="no_end" value="1"/>
																				<span></span>
																				No End Date
																			</label>
																		</div>
																	</div>
																</div>
																<div class="col-6 div_end" style="display:none">
																	<label class="col-form-label">Option 2 (End Date)</label>
																	<div class="form-group row">
																		<input class="form-control" type="date" value="{{date('Y-m-d')}}" min="{{date('Y-m-d')}}" id="end_date" name="e_date" disabled>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="d-flex align-items-center mb-5 bg-light-success rounded p-5 mt-5">
														<span class="svg-icon svg-icon-warning mr-5">
															<i class="text-success fas fa-map-marker-alt"></i>
														</span>
														<div class="d-flex flex-column flex-grow-1 mr-2">
															<a class="font-weight-bold text-dark-75 font-size-lg mb-1">Do you want to restrict this Ad to a particular location?</a>
														</div>
													</div>
													<div class="form-group">
														<!-- <label>Do you want to restrict this Ad to a particular location?</label> -->
														<div class="res-radio" style="display:grid">
															<label class="radio">
																<input type="radio" checked name="restrict" value="1"/>
																<span></span>
																No, allow this Ad to be placed anywhere that I select in my Campaign Manager.
															</label>
															<label class="radio">
																<input type="radio" name="restrict" value="0"/>
																<span></span>
																Yes, I want this Ad to be displayed ONLY at the locations I am about to select.
															</label>
														</div>
													</div>
													<div class="form-group res-div" style="display:none">
														<div class="checkbox-list mb-5 ml-5" id="location_list"></div>
														<button class="btn btn-success save_rest" type="button">Store Selected Restricted Location</button>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group row" style="bottom:0px;width:100%" id="pos_div">
														<div class="col-12">
															<button type="button" class="btn btn-success btn-block" id="pre_ad">Preview Ad</button>
															<button type="button" class="btn btn-success btn-block" style="display:none" id="pre_ad_modal" data-toggle="modal" data-target="#preview_modal">Preview Ad</button>
														</div>
														<div class="col-12 mt-2">
															<button type="submit" class="btn btn-danger btn-block" id="btn_submit">Save Ad and Set Schedule</button>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="preview_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i aria-hidden="true" class="ki ki-close"></i>
					</button>
				</div>
				<div class="modal-body">
					<img id="pre_img" src="" style="width:100%"/>
				</div>
				<div class="modal-footer">
					<button type="button" id="c_modal" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<button type="button" class="btn btn-success btn-block" id="btn_cmodal" style="display:none" data-toggle="modal" data-target="#crop_modal">Crp Modal</button>
	<div class="modal fade" id="crop_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i aria-hidden="true" class="ki ki-close"></i>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class='col-md-2'></div>
						<div class="col-md-8 srl">
							<div class="mb-3" style='width:576px;height:576px'>
								<img id="image" src="/crop-over.png" alt="" style=''/>
								<!-- <img id="image" src="/assets/media/stock-600x600/img-9.jpg" alt="" style=''/> -->
							</div>
							<span class='srl_text'>Scroll left or right</span>
						</div>
						<div class="col-lg-12">
							<strong>
								If you don't like the cropped result, just click on your new image to come back here and try again.
								<br>A close up picture of their face is best. It will look better.
							</strong>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div id="cropper-buttons">
						<div class="btn-group">
							<button type="button" class="btn btn-primary mb-3" data-method="zoom" data-option="0.1" title="Zoom In">
							<span data-toggle="tooltip" title="cropper.zoom(0.1)">
							<span class="text-success fa fa-search-plus"></span>
							</span>
							</button>
							<button type="button" class="btn btn-primary mb-3" data-method="zoom" data-option="-0.1" title="Zoom Out">
							<span title="cropper.zoom(-0.1)">
							<span class="text-success fa fa-search-minus"></span>
							</span>
							</button>
						</div>
						<div class="btn-group btn-group-crop">
							<button type="button" data-toggle="modal" data-target="#getCroppedCanvasModal" class="btn btn-success mb-3" data-method="getCroppedCanvas" data-option="{ &quot;maxWidth&quot;: 1000, &quot;maxHeight&quot;: 1000 }">
								<span data-toggle="tooltip" title="">Done</span>
							</button>
						</div>
						<div class="btn-group">
							<button type="button" id="crp_modal" class="btn btn-primary mb-3" data-dismiss="modal">Cancel</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@include("admin.include.admin-footer")
	<style>
		.btn.btn-outline-success{
			width: 100%;
		}
	</style>
	<script>var HOST_URL = "https://keenthemes.com/metronic/tools/preview";</script>
	<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
	<script src="/assets/plugins/global/plugins.bundle.js"></script>
	<script src="/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
	<!-- <script src="/assets/js/pages/crud/forms/validation/form-controls.js"></script> -->
	<script src="/js/suggest.js"></script>
	<script src="/assets/js/scripts.bundle.js"></script>
	<script src="/assets/js/pages/custom/user/edit-user.js?v=7.0.4"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js"></script>
	<script type="text/javascript" src="/html2canvas-master/dist/html2canvas.js"></script>
	<script src="/js/cropper.bundle.js"></script>
	<script src="/js/cropper.js"></script>
	<script>
		$("#no_end").on('click', function(){
			$(this).find("input").each(function(){
				if($(this).prop('checked') == true && $(this).val() == 1){
					$(".div_end").css('display', 'none');
					$("#end_date").attr('disabled', true);
				}
				else{
					$(".div_end").css('display', 'block');
					$("#end_date").attr('disabled', false);
				}
			})
		})
		$(".res-radio input").on('change', function(){
			$(".res-radio input").each(function(){
				if($(this).prop('checked') == true){
					if($(this).val() == 1){
						$(".res-div").css('display', 'none');
					}
					else{
						$(".res-div").css('display', 'block');
					}
				}
			})
		})
		var oldURL = document.referrer;
		if(oldURL = 'https://inex.net/login'){
			<?php
				foreach($s_avalialbe as $val => $s_temp){
					if($s_temp == false){
			?>
				toastr.error("Please Setup <?php echo $val?>!");
			<?php } }?>
		}
		var rotate_id = 0;
		$("#rotate_img").click(function(){
			rotate_id++;
			$("#dis_overimg").css({'transform': 'rotate(-'+rotate_id * 90+'deg)'});
		})
		$("#dis_img").click(function(){
			$("#overlay_img").click();
		})
		var loc_num = 0;
		var location_list = "";
		var init_locations = "";
		var over_change = false;

		var temp_width =576;
		var temp_height = 384;
		$("#ad_form").submit(function(event){
			event.preventDefault();
			var fs = new FormData(document.getElementById("ad_form"));
			var days = "";
			location_list = "";
			$(".res-radio input").each(function(){
				if($(this).prop('checked') == true && $(this).val() == 1){
					location_list = init_locations;
				}
				if($(this).prop('checked') == true && $(this).val() == 0){
					$("#location_list").find("input").each(function(){
						if($(this).prop('checked') == true){
							location_list += $(this).val()+",";
						}
					})
				}
			})
			if(location_list == ""){
				toastr.error("Please select at least one location(s)!")
				return;
			}
			$("#radio-list").find("input").each(function(){
				if($(this).prop('checked') == true){

				}
			})
			var days = '';
			$("#days").find("input").each(function(){
				if($(this).prop("checked") == true){
					days += $(this).val()+",";
				}
			})
			if(day_plan == 1 && days == ""){
				toastr.error("Please Select Day(s)!");
				return;
			}

			$("#temp_body").css("position", "fixed");
			var innerWidth = window.innerWidth;
			var con_width = $(".content").width();
			if(innerWidth >= 1200){
				$(".content").css('width',1000);
			}
			KTApp.blockPage({
				overlayColor: 'white',
				opacity: 1,
				state: 'danger',
				message: 'Please wait...'
			});

			setTimeout(function() {
				KTApp.unblockPage();
			}, 2000);

			var element = $("#dis_img")[0];
			var rect = element.getBoundingClientRect();
			var canvas = document.createElement("canvas");

			canvas.width = $("#dis_img").width();
			canvas.height = $("#dis_img").height();
			var ctx = canvas.getContext("2d");
			ctx.translate(-rect.left,-rect.top);
			ctx.webkitImageSmoothingEnabled = false;
			ctx.mozImageSmoothingEnabled = false;
			ctx.imageSmoothingEnabled = false;
			html2canvas(element,{
				dpi: 144,
				allowTaint: true,
				removeContainer: true,
				backgroundColor: null,
				imageTimeout: 15000,
				logging: true,
				useCORS: true,
				scale : 2,

				scrollX:0, scrollY: -window.scrollY ,

				canvas:canvas,
				width : $("#dis_img").width(),
				height : $("#dis_img").height()
			}).then(function(canvas) {
				var base64URL = canvas.toDataURL("image/png");
				$.ajax({
					url: '/convert_img',
					type: 'post',
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					tranditional: true,
					data : {
						image : base64URL,
						status : status
					},
					success : function (res) {
						if(innerWidth >= 1200){
							$(".content").css('width', con_width);
						}
						$("#temp_body").css("position", "relative");
						fs.append("location",location_list);
						fs.append("days",days);
						fs.append("img_url",res);
						fs.append("temp_id",$("#t_temp_name").val());
						<?php if(session('level') == 2 || $get_temp == true){
						?>
							fs.append("business_name",$("#t_bus_name").val())
							fs.append("multiple", 'true');
						<?php } 
						else {?>
							fs.append("business_name","{{session('business_name')}}")
						<?php } ?>
						$.ajax({
							url : 'create_ad',
							data : fs,
							contentType : false,
							processData : false,
							type : "POST",
							headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							},
							success : function(res){
								$("#btn_submit")[0].className= 'btn btn-success btn-block';
								$("#btn_submit").attr('disabled', false);
								if(res == "success"){
									// Swal.fire("Success!", "You created template!", "success");
									
									$("#c_modal").click();
									Swal.fire({
										title: "You have successfully created a new Ad",
										text: "",
										icon: "success",
										showCancelButton: true,
										confirmButtonText: "Go to Playlist!",
										cancelButtonText: "Close",
										reverseButtons: true
									}).then(function(result) {
										if (result.value) {
											location.href="/manage_playlist"
										} else if (result.dismiss === "cancel") {
											location.reload();
										}
									});
									update_id = "";
								}
								else if(res == "temp_id"){
									Swal.fire("Fail!", "Please Select Template!", "error");
								}
								else{
									Swal.fire("Fail!", "", "error");
								}
							},
							error : function(res){
								$("#btn_submit").removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
								Swal.fire("Fail!", "Please try again!", "error");
								
								// setTimeout(function(){
								// 	location.reload();
								// },1000);
							}
						})
					}
				})
			})
			
		})
		$("#pre_ad").click(function(){
			var element = $("#dis_img")[0];
			var rect = element.getBoundingClientRect();
			var canvas = document.createElement("canvas");
			
			canvas.width = temp_width;
			canvas.height = temp_height;
			var ctx = canvas.getContext("2d");

			ctx.translate(-rect.left,-rect.top);
			ctx.webkitImageSmoothingEnabled = false;
			ctx.mozImageSmoothingEnabled = false;
			ctx.imageSmoothingEnabled = false;
			html2canvas(element,{
				dpi: 144,
				allowTaint: true,
				removeContainer: true,
				backgroundColor: null,
				imageTimeout: 15000,
				logging: true,
				useCORS: true,
				scale : 2,

				canvas:canvas,
				width : temp_width,
				height : temp_height
			}).then(function(canvas) {
				var base64URL = canvas.toDataURL("image/png");
				$.ajax({
					url: '/convert_img',
					type: 'post',
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					tranditional: true,
					data : {
						image : base64URL
					},
					success : function (res) {
						$("#pre_ad_modal").click();
						$("#pre_img")[0].src = "/upload/"+res;
					}
				})
			})
		})
		$(".radio-list").find("input").each(function(){
			$(this).on("change", function(){
				if($(this).val() == "ime"){
					$("#dis_sch").css("display","none");
				}
				else{
					$("#dis_sch").css("display","block");
				}
			})
		})
		// Select Business name and template id
		$("#t_bus_name").on("change",function(){
			get_locations($(this).val());
			get_restriction($(this).val());
			get_day_plan($(this).val());
			$.ajax({
				url : "get_temp_name",
				type : "POST",
				data : {
					business_name : $(this).val(),
					get_temp : "<?php echo $get_temp?>"						
				},
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success : function(res){
					$("#t_temp_name")[0].innerHTML = "";
					var temp_list = "";
					for(var i =0 ; i < res.length; i++){
						temp_list +="<option value="+res[i]['id']+">"+res[i]['template_name']+"</option>";
					}
					$("#t_temp_name").append(temp_list);
					$('#t_temp_name').selectpicker('refresh');
					$(".template-container").removeClass('hide-container');
					if(res.length == 1){
						$(".template-container").addClass('hide-container');
						get_temp_byid(res[0]['id']);
						$("#t_temp_name").val(res[0]['id']).trigger("change")
					}
				},
				error : function(res){
					location.reload();
				}
			})
		})
		<?php
			if(session('level') < 2){
		?>
			get_locations("<?php echo session("business_name")?>");
			get_day_plan("<?php echo session("business_name")?>");
			get_restriction("<?php echo session("business_name")?>");
			$.ajax({
				url : "get_temp_name",
				type : "POST",
				data : {
					business_name : "<?php echo session("business_name")?>"
				},
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success : function(res){
					$("#t_temp_name")[0].innerHTML = "";
					var temp_list = "";
					for(var i =0 ; i < res.length; i++){
						temp_list +="<option value="+res[i]['id']+">"+res[i]['template_name']+"</option>";
					}
					$("#t_temp_name").append(temp_list);
					$('#t_temp_name').selectpicker('refresh');
					$(".template-container").removeClass('hide-container');
					if(res.length == 1){
						$(".template-container").addClass('hide-container');
						get_temp_byid(res[0]['id']);
						$("#t_temp_name").val(res[0]['id']).trigger("change")
					}
				}
			})
		<?php
			}
		?>
		var day_plan = 0;
		function get_day_plan(business_name){
			$.ajax({
				url : 'get_day_plan',
				type : 'POST',
				data : {
					business_name : business_name
				},
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success : function(res){
					if(res == 1){
						day_plan = 1;
						$("#days").find("input").each(function(){
							$(this).prop('checked',false);
						});
						$(".radio-list").find("input").each(function(){
							if($(this).val() == "frame"){
								$(this).click();
								$(this).prop("checked",true);
							}
							else{
								var hid_tag = $(this).parent();
								$(hid_tag).css('display','none');
								$(hid_tag).next().css('display','none');
							}
						})
					}
					else{
						day_plan = 0;
						$(".radio-list").find("input").each(function(){
							if($(this).val() == "ime"){
								$(this).prop("checked",true);
								var dis_tag = $(this).parent();
								$(dis_tag).css('display','block');
								$(dis_tag).next().css('display','block');
							}
							$("#dis_sch").css('display','none');
						})
						$("#days").find("input").each(function(){
							$(this).prop('checked',true);
						})
					}
				}
			})
		}
		$("#days").find("input").each(function(){
			$(this).on("change",function(){
				var day_check = 0;
				if($(this).prop("checked") == true){
					$("#days").find("input").each(function(){
						if($(this).prop("checked") == true){
							day_check ++;
						}
					})
					if(day_check >2 && day_plan == 1){
						toastr.error("You can only 2 days");
						$(this).prop('checked',false);
						return;
					}
				}
			})
		})
		function get_locations(business_name){
			$.ajax({
				url : "/get_locations_by_business_name",
				type : "GET",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data : {
					business_name : business_name
				},
				success : function(res){
					var loc_list = "";
					$("#location_list")[0].innerHTML = "";
					var loc_html = "";
					if(res['success'] == true){
						for(var i = 0; i < res['locations'].length; i++){
							loc_html += '<label class="checkbox">'+
								'<input type="checkbox" value="'+res['locations'][i]['name']+'" data-id="'+res['locations'][i]['id']+'">'+res['locations'][i]['name']+
								'<span></span>'+
							'</label>';
							init_locations += res['locations'][i]['name']+",";
						}
					}
					$("#location_list").append(loc_html);
					return;
				}
			})
		}
		function get_restriction(business_name){
			if(business_name == ""){
				return;
			}
			$.ajax({
				url : "/get_restriction",
				type : "POST",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data : {
					business_name : business_name
				},
				success : function(res){
					// $(".location-list")[0].innerHTML = "";
					var html = "";
					for(var i = 0; i < res.length; i++){
						if(res[i].restrict == 1){
							html += '<label class="checkbox">'+
								'<input type="checkbox" checked name="locations[]" value="'+res[i]['id']+'">'+res[i]['name']+
								'<span></span>'+
							'</label>';
						}
						else{
							html += '<label class="checkbox">'+
								'<input type="checkbox" name="locations[]" value="'+res[i]['id']+'">'+res[i]['name']+
								'<span></span>'+
							'</label>';
						}
					}
					$(".location-list").append(html);
				}
			})
		}
		$(".save_rest").on('click', function(){
			<?php
			if(session('level') < 2){
			?>
			var business_name = "<?php echo session("business_name")?>";
			<?php }
			else{
			?>
			var business_name = $("#t_bus_name").val();
			<?php }?>
			var res_locations = [];
			$("#location_list input").each(function(){
				if($(this).prop('checked') == true){
					res_locations.push($(this).data('id'))
				}
			})
			if(res_locations.length == 0){
				toastr.error("Please select at least one location");
				return;
			}
			KTApp.blockPage();
			$.ajax({
				url : '/update-restrict',
				type : "POST",
				data : {
					business_name : business_name,
					locations : res_locations
				},
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
		})
		var t_limit = 45;
		$("#t_temp_name").on("change",function(){
			get_temp_byid($(this).val())
		})
		function get_temp_byid(id){
			$.ajax({
				url : "get_template_byid",
				type : "POST",
				data : {
					id : id
				},
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success : function(res){
					update_id = res[0]['id'];
					temp_width = res[0]['temp_width'];
					temp_height = res[0]['temp_height'];
					$("#temp_body").width(temp_width);
					$("#temp_body").height(temp_height);
					$("#dis_img").width(temp_width);
					$("#dis_img").height(temp_height);
					$("#dis_img").css("backgroundImage",'url("/upload/'+res[0]['bg_img']+'")');

					$("#dis_overimg").css('display', "block");
					$("#dis_overimg").css("marginLeft",res[0]['over_l']);
					$("#dis_overimg").css("marginTop",res[0]['over_t']);
					$("#dis_overimg").width(res[0]['over_w']);
					$("#dis_overimg").height(res[0]['over_h']);
					if(res[0]['over_img'] != null){
						$("#dis_overimg").attr("src",'/upload/'+res[0]['over_img']);
					}
					else{
						$("#dis_overimg").attr("src",'/blank_overlay.png');
					}

					$("#dis_font").css("marginLeft",res[0]['font_l']);
					$("#dis_font").css("marginTop",res[0]['font_t']);
					$("#dis_font").css("marginRight",res[0]['font_r']);
					$("#dis_font").css("fontSize",res[0]['font_s']);
					$("#dis_font").css("fontWeight",res[0]['font_w']);
					$("#dis_font").css("color",res[0]['font_c']);
					$("#dis_font").css("textAlign",res[0]['align']);
					t_limit = res[0]['t_limit'];
					var over_text = 'Enter text you wish displayed. You are limited to '+t_limit+' characters including spaces. Strongly suggest limit to 6-7 words';
					$("#over_text").attr('maxlength',t_limit);
					$('#over_text').attr('placeholder',over_text);


					if(res[0]['dis_text'] == 1){
						// $("#hid_text").css('display','none !important');
						$('#hid_text').attr("style", "display: none !important");
						$("#over_text").css('display','none');
					}
					if(res[0]['dis_text'] == 0){
						$("#hid_text").css('display','flex !important');
						$("#over_text").css('display','block');
					}
				}
			})
		}
		$("#dis_font").keydown(function(e){
			if(e.keyCode != 8 && $(this).text().length > t_limit){
				return false;
			}
		})
		// $("#dis_font").on('touchstart',function(e){
		//     if($(this).text().length > t_limit){
		//         return false;
		//     }
		// })
		// END OF SELECT
		$("#overlay_img").on("change",function(){
			var _URL = window.URL;
			var file, img;
			if ((file = this.files[0])) {
				img = new Image();
				img.onload = function () {
					
				};
			}
			over_change = true;
			$("#dis_overimg")[0].src  = _URL.createObjectURL(file);
			// $(".cropper-hide")[0].src = _URL.createObjectURL(file);
			// $("#btn_cmodal").click();
		});
		$("#over_text").on("keyup",function(event){
			$("#dis_font").text($(this).val());
		})
		$("#dis_font").on("keyup",function(event){
			$("#over_text").val($(this).text());
		})
		// $("#dis_overimg").draggable();
	</script>
	</body>
</html>
		