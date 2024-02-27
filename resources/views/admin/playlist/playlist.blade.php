@include('admin.include.admin-header')
<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css" />
<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css" />                    
<link type="text/css" rel="stylesheet" href="/assets/css/tips.css" />
<style>
    .jsgrid-header-row{
        height : 60px;
    }
    .jsgrid-filter-row>.jsgrid-cell:first-child, .jsgrid-header-row>.jsgrid-header-cell:first-child, .jsgrid-insert-row>.jsgrid-cell:first-child{
        background : #c1bdb9;
    }
    .jsgrid-grid-body .jsgrid-cell:first-child{
        background : #c1bdb9;
    }
    /* #location_list span{
        display : block;
    } */
</style>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader min-h-lg-15px pt-5 pb-7 subheader-transparent" id="kt_subheader">
    </div>
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="alert alert-custom alert-white alert-shadow fade show gutter-b tip-container" role="alert">
                <div class="alert-text">
                    <ul class="tip">
                        <a type="button" class="btn btn-text-white btn-success font-weight-bold btn-spec" data-toggle="modal" data-target="#specModal">Instructions</a>
                    </ul>
                </div>
                <div class="tips d-block alert-icon">
                    <a data-toggle="modal" data-target="#runningModal" class="d-block btn btn-text-white btn-success font-weight-bold mb-3">Running a Campaign</a>
                    <a data-toggle="modal" data-target="#FaqModal" class="d-block btn btn-text-white btn-success font-weight-bold">Manage Playlist FAQs</a>
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
                                <h3 class="card-label" style="display:block">{{$page_name}} - {{session("business_name")}}</h3>
                            </div>
                            <?php if(session('level') >= 2){?>
                                <div class="card-toolbar" style="margin:0 auto">
                                    <div class="form-group" style="margin-bottom:0px;margin:0 auto;min-width:150px">
                                        <select class="form-control selectpicker" id="t_bus_name" title="Business Name" data-live-search="true" data-size="10">
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
                                <div class="form-group" style="margin-bottom:0px;margin:0 auto;min-width:150px">
                                    <select class="form-control selectpicker" id="t_bus_name" title="Business Name" data-live-search="true" data-size="10">
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
                            <div class="mb-5">
                                <h6 class="mb-5">Control your Playlist by using check boxes, then click 'Publish Playlist'</h6>
                            </div>
                            <div id="basicScenario"></div>
                        </div>
                        <div class="card-footer">
                            <button type="button" style="float:right;display:none" class="btn btn-danger font-size-h3 font-weight-bold" id="show_modal" title="Did you CHECK all the boxes of the Ads you want to deliver to the Billboards?">Publish Playlist</button>
                            <button type="button" class="btn btn-danger font-size-h3 font-weight-bold" id="publish_cm" data-placement="right" data-toggle="tooltip" data-theme="dark" title="Did you CHECK all the boxes of the Ads you want to deliver to the Billboards?">Publish Playlist</button>
                            <button type="button" id="preview" class="btn btn-danger font-weight-bold d-none" data-target="#preview_modal" data-toggle="modal">Preview</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="preview_modal" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">PlayList</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="pub_post">
                <div class="modal-body">
                    <div class="text-center">
                        <img src="/img/image0001.png" width="50%" class="text-center">
                    </div>
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="col">
                                    <img src="/img/image0003.png" width="100%" class="text-center">
                                </th>
                                <th scope="col" style="vertical-align:inherit"><h4>ALL DONE!</h4>
                                    <ul class="font-size-lg pl-12">
                                        <li class="">
                                            <h4>If you have an existing campaign running now, your Ads are being delivered to the billboards right now.</h4>
                                        </li>
                                    </ul>
                                    <div class="text-right">
                                        <button class="btn btn-light-success" data-dismiss="modal">Close</button>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th scope="col">
                                <a href="/manage-campaign"><img src="/img/image0005.png" width="100%" class="text-center"></a>
                                </th>
                                <th scope="col" style="vertical-align:inherit">
                                    <h4>NEXT STEP</h4>
                                    <ul class="font-size-lg pl-12">
                                        <li>
                                            <h4>If you have not created a campaign yet, this playlist will not be delivered to the billboards until you create one.</h4>
                                        </li>
                                    </ul>
                                    <div class="text-right">
                                        <a href="/manage-campaign" class="text-right">Go to Campaign Manager</a>
                                    </div>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- <div class="modal-footer">
                    <button class="btn btn-light-success" data-dismiss="modal">Close</button>
                </div> -->
            </form>
        </div>
    </div>
</div>
<button type="button" class="btn btn-success btn-block" style="display:none" id="pre_ad_modal" data-toggle="modal" data-target="#preview_mod">Preview Ad</button>
<div class="modal fade" id="preview_mod" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="update_sch">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- <img id="pre_img" style="width:100%"> -->
                    <div class="form-group row" style="margin:0">
                        <input type="number" id="u_id" style="display:none" name="u_id">
                        <div class="col-lg-12">
                            <div class="radio-list">
                                <label class="radio radio-danger">
                                    <input type="radio" name="radio" checked value="ime"> Display Continuously
                                    <span></span>
                                </label>
                                <span class="form-text text-muted">When activated, Ad will be displayed until you manually de-activate it.The Ad will be shown 24 hours a day.</span>
                                <label class="radio radio-danger" style="margin-top:10px">
                                    <input type="radio" name="radio" value="frame"> Select Time Frame
                                    <span></span>
                                </label>
                                <span class="form-text text-muted">Set start date, start time , days of week when you want this displated, end date, and end time to controll when you want this Ad to show.</span>
                            </div>
                        </div>
                        <div class="col-lg-12" id="dis_sch" style="display:none">
                            <div class="form-group row" style="margin:0px">
                                <label for="example-date-input" class="col-form-label">Start Date</label>
                                <div class="col-12">
                                    <input class="form-control" type="date" value="{{date('Y-m-d')}}" id="start_date" name="s_date">
                                </div>
                            </div>
                            <div class="row" style="margin:0px">
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
                                <div class="checkbox-inline" id="days" style="margin-left:12.5px">
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
                            <div class="row" style="margin:0px">
                                <div class="col-6">
                                    <label class="col-form-label">Option 1</label>
                                    <!-- <div class="form-group">
                                        <label class="checkbox">
                                            <input type="checkbox" checked="checked" id="no_end" name="no_end"/> No End Date
                                            <span></span>
                                        </label>
                                    </div> -->
                                    <div class="radio-list" id="no_end">
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
                                <div class="col-6">
                                    <label class="col-form-label">Option 2 (End Date)</label>
                                    <div class="form-group row">
                                        <input class="form-control" type="date" value="{{date('Y-m-d')}}" min="{{date('Y-m-d')}}" id="end_date" name="e_date">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 mt-5">
                          <h5>Ad Restricted Locations</h5>
                          <div class="checkbox-list mb-5" id="location_list"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-light-danger font-weight-bold" id="u_sch">Update</button>
                    <button type="button" class="btn btn-light-primary font-weight-bold" id="c_sch" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Instruction Modal -->
<div class="modal fade" id="specModal" tabindex="-1" role="dialog" aria-labelledby="specModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="specModalLabel">Instruction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
				<ul>
                    <li>Control your Playlist by using check boxes, then click 'Publish Playlist'</li>
                    <li>Every Ad you have created is listed on this page.</li>
                    <li>The checkbox on the left determines if an Ad is sent to the billboard(s).</li>
                    <li>After selecting or deselecting a checkbox, click “Publish Playlist”.   The checked Ads are delivered to the billboards.</li>
                    <li>If you have restricted a particular Ad by Schedule or Location AND checked it to be delivered to the billboard(s), it will be seen according to your restrictions (within the limits of your Campaign).</li>
                    <li>You can change your Playlist as often as you wish – meaning you can change what is on the billboards within minutes.</li>
				</ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Running Modal -->
<div class="modal fade" id="runningModal" tabindex="-1" role="dialog" aria-labelledby="specModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="specModalLabel">Running a Campaign
                    <a href='/guide/Running-a-campaign.pdf' target='_blank'> <i class="fas fa-file-download text-danger"></i></a>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <span>Only two components of your business increase sales – salesman and advertising. Word-of-mouth = salesman. It is just one component of your marketing plan. </span>
                <div class="tab-content">
					<div class="accordion accordion-light accordion-light-borderless accordion-svg-toggle" id="faq">
						<div class="card">
							<div class="card-header" id="faqHeading1">
								<a class="card-title text-dark" data-toggle="collapse" href="#faq1" aria-expanded="true" aria-controls="faq1"  role="button">
									<span class="svg-icon svg-icon-primary">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24"/>
												<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"/>
												<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
											</g>
										</svg>
									</span>
									<div class="card-label text-dark pl-4">First – What is an Advertising Campaign?</div>
								</a>
							</div>
							<div id="faq1" class="collapse show" aria-labelledby="faqHeading1" data-parent="#faq">
								<div class="card-body font-size-lg pl-12">
									An advertising campaign is your strategy carried out across different mediums (such as billboards, social media, and geofencing marketing). The objective? Achieve increased brand awareness, increased sales, and improved communication within a specific market. All of this is accomplished through advertising.<br>
                                    Our Campaign Manager specifically controls <br><br>
									<ul>
										<li>when you advertise,</li>
										<li>how long you advertise,</li>
										<li>the days of the week you want to advertise, and</li>
										<li>where you want to advertise.</li>
									</ul>
								</div>
							</div>
						</div>
                        <div class="card border-top-0">
							<div class="card-header" id="faqHeading2">
								<a class="card-title collapsed text-dark" data-toggle="collapse" href="#faq2" aria-expanded="true" aria-controls="faq2"  role="button">
									<span class="svg-icon svg-icon-primary">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24"/>
												<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"/>
												<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
											</g>
										</svg>
									</span>
									<div class="card-label text-dark pl-4">Second – Where to advertise?</div>
								</a>
							</div>
							<div id="faq2" class="collapse" aria-labelledby="faqHeading2" data-parent="#faq">
								<div class="card-body font-size-lg pl-12">
                                    Well, first you must have looked at your target market. You need to know if they are younger or older. Are your customers mostly female or male? Income bracket important? Ethnicity a player? This understanding affects the Ads you make and where they get placed. Example: If your clients are mostly above 45 years of age, you don’t advertise on Instagram, you use Facebook. On billboards, you need to know about the traffic passing by the signs. What about the general income level in the area? Understand that signs are generally good for a 15-mile radius. Use that fact to get an idea of where you advertise.
								</div>
							</div>
						</div>
						<div class="card border-top-0">
							<div class="card-header" id="faqHeading3">
								<a class="card-title collapsed text-dark" data-toggle="collapse" href="#faq3" aria-expanded="true" aria-controls="faq3"  role="button">
									<span class="svg-icon svg-icon-primary">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24"/>
												<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"/>
												<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
											</g>
										</svg>
									</span>
									<div class="card-label text-dark pl-4">Third – How long do I advertise? </div>
								</a>
							</div>
							<div id="faq3" class="collapse" aria-labelledby="faqHeading2" data-parent="#faq">
								<div class="card-body font-size-lg pl-12">
                                    Understand there is long-term and short-term advertising. Long term is key to establishing your brand, making your potential clients know that you even exist, much less increase your sales consistently. Short-term is normally sales, promotions, onetime events. Short-term generally gives rise to a short pop in sales.<br><br>
                                    <strong>Long term advertising:</strong><br>
                                    We recommend a minimum of 12 weeks. Why? It takes a while for the process of establishing your firm as the best solution to their issues or desires.<br><br>
                                    <strong>Short term advertising:</strong><br>
                                    Are you just promoting a one-off event (such as a neighborhood garage sale or a music event)? Four weeks generally gives people enough notice to react and plan.<br><br>
                                    If your objective a sales event (normally a repeated event), understand it should be done within the context of your long-term advertising campaign.<br><br>
                                    As a general rule, creating just a short-term advertising campaign will not get you the results you desire.<br><br>
                                    <strong>One more time: </strong><br>
                                    These are not your father’s billboards – they can do just-in-time advertising. You can easily use them for setting up impulse buying in mere minutes (try that with TV Ads, radio spots). But understand your Campaign should have an overarching objective.
                                </div>
							</div>
						</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href='/guide/Running-a-campaign.pdf' target='_blank' class="d-block text-left btn btn-text-danger btn-light-danger btn-hover-danger font-weight-bold">Download</a>
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@include("admin.include.admin-footer")

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

<script>
    var loc_num = 0;
    var location_list = "";
    var over_change = false;
    var business_name = "";
    var post_id = "";
    var day_plan = 0;
    $("#update_sch").submit(function(event) {
        event.preventDefault();
        var fs = new FormData($("#update_sch")[0]);
        var days = "";
        $("#days").find("input").each(function(){
            if($(this).prop("checked") == true){
                days += $(this).val()+",";
            }
        })
        fs.append("days", days);
        $("#u_sch")[0].className= 'btn btn-outline-danger spinner spinner-darker-danger spinner-left mr-3';
        $("#u_sch").attr('disabled', true);
        var locations = '';
        $("#location_list").find('input').each(function(){
          if($(this).prop('checked') == true) {
            locations += $(this).val() + ',';
          } 
        })
        fs.append("locations", locations);
        $.ajax({
            type : "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData : false,
            contentType : false,
            data : fs,
            url : '/update_sch',
            success : function(res){
                $("#u_sch")[0].className = "btn btn-light-danger font-weight-bold";                        
                $("#u_sch").removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                $("#basicScenario").jsGrid("loadData");
                if(res == 'success'){
                    $("#c_sch").click();
                }
            }
        });
    })
    // Select Business name and template id
    $("#t_bus_name").on("change",function(){
        business_name = $(this).val();
        get_locations(business_name);
        $("#basicScenario").jsGrid("loadData");
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
    $("#no_end").on('change',function(){
        $(this).find("input").each(function(){
            if($(this).prop('checked') == true && $(this).val() == 1){
                $("#end_date").attr('disabled', true);
            }
            else{
                $("#end_date").attr('disabled', false);
            }
        })
    })
    <?php
        if(session('level') != 2 && $get_temp == false){
    ?>
        business_name = "<?php echo session("business_name")?>";
        get_locations(business_name);
    <?php
        }
    ?>
    function processing(){
        KTApp.block('#basicScenario', {
            overlayColor: '#000000',
            state: 'danger',
            message: 'Please wait...'
        });
    }
    // END OF 
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
            }
          }
          $("#location_list").append(loc_html);
          return;
        }
      })
    }
    // $("#save_list").click(function(){
    $("#pub_post").submit(function(event){
        event.preventDefault();
        var fs = new FormData(document.getElementById("pub_post"));
        var social = "";
        $("#social").find("input").each(function(){
            if($(this).prop('checked') == true){
                social += $(this).val()+",";
            }
        })
        if(social == ""){
            toastr.error("Please Check At least On Socials!");
            return;
        }
        if(social != ""){
            if(post_id == ""){
                toastr.error("Please Check At least On Ad!");
                return;
            }
            if($("#post_text").val() == ""){
                toastr.error("Please Input Text!");
                $("#post_text").focus();
                return;
            }
        }
        $("#save_list")[0].className= 'btn btn-outline-danger spinner spinner-darker-danger spinner-left mr-3';
        $("#save_list").attr('disabled', true);

        if(business_name == "1 Demo"){
            Swal.fire("Success!", "You have published your Playlist, It will be viewed on the billboard within a few minutes!", "success");
            $("#c_modal").click();
            return;
        }
        fs.append("social",social);
        fs.append("post_text",$("#post_text").val());
        fs.append("business_name",business_name);
        fs.append("post_id",post_id);
        $.ajax({
            type : "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : fs,
            processData : false,
            contentType : false,
            url : '/save_list',
            success : function(res){
                $("#save_list")[0].className = "btn btn-light-danger font-weight-bold";                        
                $("#save_list").removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                if(res == "success"){
                    Swal.fire("Success!", "You have published your Playlist, It will be viewed on the billboard within a few minutes!", "success");
                    // $("#basicScenario").jsGrid("loadData");
                    $("#c_modal").click();
                }
                else{
                    Swal.fire("Fail!", res, "error");
                }
            },
            error: function(res){
                $("#save_list")[0].className = "btn btn-light-danger font-weight-bold";
                $("#save_list").removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
            }
        });
    })
    $("#publish_cm").click(function(){
        if(business_name == ""){
            toastr.error("Please Select Business Name!");
            return;
        }
        $("#publish_cm")[0].className= 'btn btn-outline-danger spinner spinner-darker-danger spinner-left mr-3';
        $("#publish_cm").attr('disabled', true);
        if(business_name == "1 Demo"){
            KTApp.unblock('#basicScenario');
            $("#publish_cm")[0].className = "btn btn-danger font-size-h3 font-weight-bold";                        
            $("#publish_cm").removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
            $("#show_modal").click();
            return;
        }
        KTApp.block('#basicScenario', {
            overlayColor: '#000000',
            state: 'danger',
            message: 'Please wait...'
        });
        $.ajax({
            type : "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : {
                business_name : business_name
            },
            url : '/publish_cm',
            success : function(res){
                KTApp.unblock('#basicScenario');
                $("#publish_cm")[0].className = "btn btn-danger font-size-h3 font-weight-bold";                        
                $("#publish_cm").removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                if(res == 'success'){
                    $("#show_modal").click();
                }
                else{
                    Swal.fire("Fail!", res, "error");
                }
            },
            error : function(res){
                Swal.fire("Fail!", "Please try again or Contact to support team", "error");
                KTApp.unblock('#basicScenario');
                $("#publish_cm")[0].className = "btn btn-danger font-size-h3 font-weight-bold";                        
                $("#publish_cm").removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                // setTimeout(function(){
                //     location.reload();
                // },5000);
            }
        });
    })
    $("#show_modal").click(function(){
        if(business_name == ""){
            toastr.error("Please Select Business Name!");
            return;
        }
        $.ajax({
            type : "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : {
                business_name : business_name
            },
            url : '/get_active_ad',
            success : function(res){
                var temp = "";
                $("#preview").click();
            }
        });
    })
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
    $("#basicScenario").jsGrid({
        width: "100%",
        // filtering: true,
        editing: false,
        inserting: false,
        sorting: true,
        paging: true,
        autoload: true,
        pageSize: 100,
        selecting: true,

        pageButtonCount: 5,
        deleteConfirm: "Do you really want to delete?",
        rowClick: function(args) { 
            // user_id = args.item.id;
            var playlist_status = 0;
            if($(args.event.target)[0].nodeName == "INPUT"){
                $("#publish_cm")[0].className= 'btn btn-outline-danger spinner spinner-darker-danger spinner-left mr-3';
                $("#publish_cm").attr('disabled', true);
                KTApp.block('#basicScenario', {
                    overlayColor: '#000000',
                    state: 'danger',
                    message: 'Please wait...'
                });
                if($(args.event.target).prop("checked") == true){
                    playlist_status = 1;
                }
                $.ajax({
                    url : 'update_ad_list',
                    type : "POST",
                    data : {
                        id : args.item.id,
                        playlist : playlist_status,
                        business_name : args.item.business_name
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success : function (res){
                        KTApp.unblock('#basicScenario');
                        $("#publish_cm")[0].className= 'btn btn-light-danger font-weight-bold';
                        $("#publish_cm").attr('disabled', false);
                        toastr.success("Success!");
                        // $("#basicScenario").jsGrid("loadData");
                    }
                })
            }
            if($(args.event.target)[0].className == 'fa fa-edit'){
              var locations = args.item.location.split(',');
              $("#location_list").find('input').each(function(){
                $(this).prop('checked', false)
              })
              $("#location_list").find('input').each(function(){
                if(args.item.rest == 0 && jQuery.inArray($(this).val(), locations) !== -1){
                  $(this).prop('checked', true)
                }
              })
                $('#u_id').val(args.item.id);
                $(".radio-list").find("input").each(function(){
                    if($(this).val() == args.item.schedule){
                        $(this).prop("checked",true);
                    }
                    else{
                        $(this).prop("checked",false);
                    }
                    if(args.item.schedule == "ime"){
                        $("#dis_sch").css("display","none");
                    }
                    if(args.item.schedule != "ime"){
                        $("#dis_sch").css("display","block");
                    }
                })
                var d = new Date(args.item.s_date);
                var sDate = d.getFullYear() + "-" + ((d.getMonth() + 1).toString().padStart(2, "0")) + "-" + d.getDate().toString().padStart(2, "0");
                $("#start_date").val(sDate);
                if(args.item.e_date == "No End date"){
                    // $("#no_end").prop("checked",true);
                    $("#no_end").find("input").each(function(){
                        if($(this).val() == 1){
                            $(this).prop('checked', true);
                        }
                    })
                    $("#end_date").attr('disabled', true);
                }
                if(args.item.e_date != "No End date"){
                    // $("#no_end").prop("checked",false);
                    $("#no_end").find("input").each(function(){
                        if($(this).val() == 0){
                            $(this).prop('checked', true);
                        }
                    })
                    $("#end_date").attr('disabled', false);
                }
                if(args.item.e_date != "No End date"){
                    var d = new Date(args.item.e_date);
                    var eDate = d.getFullYear() + "-" + ((d.getMonth() + 1).toString().padStart(2, "0")) + "-" + d.getDate().toString().padStart(2, "0");
                    $("#end_date").val(eDate);
                }
                $("#start_time").val(args.item.s_time);
                $('#start_time').selectpicker('refresh');
                $("#end_time").val(args.item.e_time);
                $('#end_time').selectpicker('refresh');
                var days_temp = args.item.days;
                var days = days_temp.split(",");
                $("#days").find("input").each(function(){
                    $(this).prop("checked",false);
                })
                for(var i = 0; i < days.length; i++){
                    $("#days").find("input").each(function(){
                        if($(this).val() == days[i]){
                            $(this).prop('checked',true);
                            return;
                        }
                    })
                }

                if(args.item.day_plan == 1){
                    day_plan = 1;             
                }
                else{
                    day_plan = 0;
                    $("#days").find("input").each(function(){
                        $(this).prop('checked',true);
                    })
                    
                }

                $("#pre_ad_modal").click();
            }
            if($(args.event.target)[0].className == 'fa fa-trash'){
                Swal.fire({
                    title: "Are you sure?",
                    text: "If it is possible you may use this Ad again, just don't include it in your active Playlist.  If you choose to delete it, it will be permanently removed.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!"
                }).then(function(result) {
                    if (result.value) {
                        processing();
                        $.ajax({
                            type : "POST",
                            url : 'delete_ad',
                            data : {
                                id : args.item.id
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success : function(res){
                                KTApp.unblock('#basicScenario');
                                if(res == "success"){
                                    Swal.fire("Success!", "Your Ad has been permanently deleted.", "success");
                                    $("#basicScenario").jsGrid("loadData");
                                    
                                }
                                else{
                                    Swal.fire("Fail!", "Please try again!", "error");
                                }
                            },
                            error : function(res){
                                Swal.fire("Fail!", "Please try again!", "error");
                                setTimeout(function(){
                                    location.reload();
                                },1000);
                            }
                        });
                    }
                });
                
            }
            // if($(args.event.target)[0].nodeName=="I"){
            // }
        },
        rowDoubleClick : function(args){
            
        },
        controller: {
            loadData : function(filter){
                return $.ajax({
                    type : "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data : {
                        business_name : business_name
                    },
                    url : '/get_ad_byid',
                    success : function(res){
                    }
                });
            },
            deleteItem : function(item)
            {
                return $.ajax({
                    type : "POST",
                    url : 'delete_ad',
                    data : item,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success : function(res){
                        if(res == "success"){
                            Swal.fire("Success!", "Your Ad has been permanently deleted.", "success");
                            // $("#basicScenario").jsGrid("loadData");
                        }
                        else{
                            Swal.fire("Fail!", "Please try again!", "error");
                        }
                    },
                    error : function(res){
                        Swal.fire("Fail!", "Please try again!", "error");
                        setTimeout(function(){
                            location.reload();
                        },1000);
                    }
                });
            },
            updateItem : function(item)
            {
                $.ajax({
                    type : "UPDATE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type : "PUT",
                    url : '/update_status',
                    data : item,
                    success : function(res){
                        $("#basicScenario").jsGrid("loadData");
                    }
                });
            }
        },
        fields: [
            { name : "id" ,visible :false},
            { name : "rest" ,visible :false},
            { name : "schedule" ,visible :false},
            { title: "Template Name", name: "media_id", type: "text", width: "50px",align: "left",visible :false},
            { title: "Template Name", name: "template_name", type: "text", width: "120px",align: "left", visible :false},
            { title : "Checked Boxes are delivered to Billboard", name : "playlist", width:"80px",
                itemTemplate: function(val, item) {
                    if(val == "1"){
                        return ('<label class="checkbox">'+
                            '<input type="checkbox" checked/>'+
                            '<span></span>'+
                        '</label>');
                    }
                    else{
                        return ('<label class="checkbox">'+
                            '<input type="checkbox"/>'+
                            '<span></span>'+
                        '</label>');
                    }
                },
                insertTemplate: function() {
                    var insertControl = this.insertControl = $("<input>").prop("type", "file");
                    return insertControl;
                },
                editoptions : function(){
                    value 
                },
                align: "center"
            },
            { title: "Ad List", name: "img_url", type: "text", width: "200px",
                itemTemplate: function(val, item) {
                    return ("<img src='/upload/"+val+"' width='180' height='120'>");
                },
                insertTemplate: function() {
                    var insertControl = this.insertControl = $("<input>").prop("type", "file");
                    return insertControl;
                },
                editoptions : function(){
                    value 
                },
                insertValue: function() {
                    return this.insertControl[0].files[0]; 
                },
                align: "center"
            },
            { title: "Business Name", name: "business_name", type: "text", width: "120px",align: "left",visible:false},
            { title: "Edit", editButton :false,width : "80px", align: "center",
                itemTemplate: function(val, item) {
                    return ("<span style='cursor:pointer' title='Edit the schedule for this Ad'><i class='fa fa-edit' style='color:#1BC5BD'></i></span>");
                }
            },
            { title: "Start Date", name: "s_date", type: "text", width: "80px",align: "left",
                itemTemplate : function(val, item){
                    // if(item.schedule == "ime"){
                    //     return "01-01-2021";
                    // }
                    // else{
                        return val;
                    // }
                }
            },
            { title: "Start Time", name: "s_time", type: "text", width: "80px",align: "left",
                itemTemplate : function(val, item){
                    if(item.schedule == "ime"){
                        return "12 AM";
                    }
                    else{
                        return val;
                    }
                }
            },
            { title: "End Date", name: "e_date", type: "text", width: "80px",align: "left",
                itemTemplate : function(val, item){
                    if(item.schedule == "ime"){
                        return "No End Date";
                    }
                    else{
                        return val;
                    }
                }
            },
            { title: "End Time", name: "e_time", type: "text", width: "80px",align: "left",
                itemTemplate : function(val, item){
                    if(item.schedule == "ime"){
                        return "12 PM";
                    }
                    else{
                        return val;
                    }
                }
            },
            { title: "Primary", name: "primary", type: "text", width: "80px",align: "left",visible :false},
            { title: "Day Plan", name: "day_plan", type: "text", width: "80px",align: "left",visible :false},
            { title : "Days of week", name : "days", width:"120px",
                itemTemplate: function(val, item) {
                    if(item.schedule == 'ime'){
                        return "Every Day";
                    }
                    var temp_days = val.split(",");
                    var dis_days = "";
                    if(val == "0,1,2,3,4,5,6,"){
                        return ("<span>Every Day</span>");
                    }
                    else{
                        for(var i = 0; i < temp_days.length-1; i++){
                            if(temp_days[i] == 0){
                                dis_days += "Mo,";
                            }
                            if(temp_days[i] == 1){
                                dis_days += "Tu,";
                            }
                            if(temp_days[i] == 2){
                                dis_days += "We,";
                            }
                            if(temp_days[i] == 3){
                                dis_days += "Th,";
                            }
                            if(temp_days[i] == 4){
                                dis_days += "Fr,";
                            }
                            if(temp_days[i] == 5){
                                dis_days += "Sa,";
                            }
                            if(temp_days[i] == 6){
                                dis_days += "Su";
                            }
                        }
                    }
                    return ("<span>"+dis_days+"</span>");
                },
                insertTemplate: function() {
                    var insertControl = this.insertControl = $("<input>").prop("type", "file");
                    return insertControl;
                },
                editoptions : function(){
                    value 
                },
                insertValue: function() {
                    return this.insertControl[0].files[0]; 
                },
                align: "left"
            },
            { type: "control", editButton :false,width : "80px",
                itemTemplate: function(val, item) {
                    // if(item.primary == "1"){
                        
                    // }
                    // else{
                        return ("<span style='cursor:pointer;padding-left:1rem' title='Delete Ad permanently.'><i class='fa fa-trash' style='color: #F64E60'></i></span>");
                    // }
                }
            },
            { title : "Ad Restricted Locations<i class='far fa-question-circle text-danger' title='If there is a Location listed here, then the associated Ad can only be displayed at that location.' style='cursor:pointer'></i>", name : "location", width:"250px",
                itemTemplate: function(val, item) {
                    if(item.rest == 0){
                    var loca = val.split(",");
                        var temp_loca = "";
                        for(var i = 0; i < loca.length-1; i++){
                            temp_loca += "<span style='display:block;text-align:left'><i class='la la-map-marker'></i>"+loca[i]+"</span>";
                        }
                        return (temp_loca);
                    }
                    else{
                        return "";
                    }
                },
                insertTemplate: function() {
                    var insertControl = this.insertControl = $("<input>").prop("type", "file");
                    return insertControl;
                },
                editoptions : function(){
                    value 
                },
                align: "center"
            },
        ]
    });
</script>
	</body>
</html>
		