@include('admin.include.admin-header')
<link href="/assets/css/pages/wizard/wizard-1.css" rel="stylesheet" type="text/css"/>
<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css" />
<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css" />      
<link href="/assets/plugins/custom/cropper/cropper.bundle.css" rel="stylesheet" type="text/css"/>      
<link type="text/css" rel="stylesheet" href="/assets/css/tips.css" />
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
        #temp_body, #preview-container{
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
		#preview_img{
			width: 270px !important;
			height: 180px !important;
		}
    }
    .hide-container{
        display : none !important;
    }
</style>

<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader py-2 pt-12 pb-5 subheader-transparent " id="kt_subheader">
        <div class=" container ">
            <div class="alert alert-custom alert-white alert-shadow fade show gutter-b tip-container" role="alert">
                <div class="alert-text">
					@if(session('level') >= 2)
						@if(session('level') == 4)
							<h1>Account Managers</h1>
							<ul class="tip">
								<li><h4>Only Account Managers see this page. Your clients never see this page.</h4></li>
								<li><h4>Begin typing their business name in field. It shortens the list.</h4></li>
								<li><h4>You can do everything for a client except pay for their Ads.</h4></li>
							</ul>
						@else
							<ul class="tip">
								<li><h4>Upload as many Ads as you wish.</h4></li>
								<li><h4>Each Ad will be seen in rotation.</h4></li>
								<li><h4>Have a specific objective for each Ad (brand marking, sale, come to store, visit web site, sale). </h4></li>
							</ul>
						@endif
					@endif
					<!-- Next Tips -->
					<ul class="tip {{session('level') >= 2 ? 'hide-container' : '' }}">
						<a type="button" class="btn btn-text-white btn-success font-weight-bold btn-spec" data-toggle="modal" data-target="#specModal">Instructions</a>
					</ul>
					<ul class="tip hide-container">
						<a type="button" class="btn btn-text-white btn-success font-weight-bold btn-spec" data-toggle="modal" data-target="#schModal">Instructions</a>
					</ul>
					<ul class="tip hide-container">
						<a type="button" class="btn btn-text-white btn-success font-weight-bold btn-spec" data-toggle="modal" data-target="#restrictModal">Instructions</a>
					</ul>
					<ul class="tip hide-container">
						<a type="button" class="btn btn-text-white btn-success font-weight-bold btn-spec" data-toggle="modal" data-target="#previewModal">Instructions</a>
					</ul>
                </div>
				<div class="alert-icon d-block text-right {{session('level') >= 2 ? 'hide-container' : '' }} tips">
					<a type="button" class="d-block btn btn-text-white btn-success font-weight-bold mb-3" data-toggle="modal" data-target="#basicModal">Basic Ad Design Rules</a>
					<a type="button" class="d-block btn btn-text-white btn-success font-weight-bold mb-3" data-toggle="modal" data-target="#createAdsModal">Creating Your Ads</a>
                </div>
				<div class="alert-icon d-block text-right hide-container tips">
					<a type="button" class="d-block btn btn-text-white btn-success font-weight-bold mb-3" data-toggle="modal" data-target="#basicModal">Basic Ad Design Rules</a>
					<a type="button" class="d-block btn btn-text-white btn-success font-weight-bold mb-3" data-toggle="modal" data-target="#createAdsModal">Creating Your Ads</a>
					<!-- <a href='/guide/CreatingYourAds.pdf' target='_blank' class="d-block text-left btn btn-text-white btn-success font-weight-bold">Using Day Parting</a> -->
                </div>
				<div class="alert-icon d-block text-right hide-container tips">
					<a type="button" class="d-block btn btn-text-white btn-success font-weight-bold mb-3" data-toggle="modal" data-target="#basicModal">Basic Ad Design Rules</a>
                </div>
				<div class="alert-icon d-block text-right hide-container tips">
					<a type="button" class="d-block btn btn-text-white btn-success font-weight-bold mb-3" data-toggle="modal" data-target="#basicModal">Basic Ad Design Rules</a>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex flex-column-fluid">
        <div class=" container ">
            <div class="card card-custom">
                <div class="card-body p-0">
                    <div class="wizard wizard-1" id="kt_wizard_v1" data-wizard-state="step-first" data-wizard-clickable="false">
                        <div class="wizard-nav border-bottom">
                            <div class="wizard-steps p-8 p-lg-10">
                                <?php
                                    $get_temp = false;
                                ?>
								@if(session('level') >= 2)
                                <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                                    <div class="wizard-label">
                                        <i class="wizard-icon flaticon-business"></i>
                                        <h3 class="wizard-title">Select Business Name</h3>
                                    </div>
                                    <span class="svg-icon svg-icon-xl wizard-arrow">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"/>
                                                <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000) " x="11" y="5" width="2" height="14" rx="1"/>
                                                <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997) "/>
                                            </g>
                                        </svg>
                                    </span>
                                </div>
								@endif
                                <div class="wizard-step" data-wizard-type="step" data-wizard-state="{{session('level') >= 2 ? '':'current'}}">
                                    <div class="wizard-label">
                                        <i class="wizard-icon flaticon2-image-file"></i>
                                        <h3 class="wizard-title">Upload Your Ad</h3>
                                    </div>
                                    <span class="svg-icon svg-icon-xl wizard-arrow">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"/>
                                                <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000) " x="11" y="5" width="2" height="14" rx="1"/>
                                                <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997) "/>
                                            </g>
                                        </svg>
                                    </span>
                                </div>
                                <div class="wizard-step" data-wizard-type="step">
                                    <div class="wizard-label">
                                        <i class="wizard-icon flaticon-clock-2"></i>
                                        <h3 class="wizard-title">Set Ad Schedule</h3>
                                    </div>
                                    <span class="svg-icon svg-icon-xl wizard-arrow">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"/>
                                                <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000) " x="11" y="5" width="2" height="14" rx="1"/>
                                                <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997) "/>
                                            </g>
                                        </svg>
                                    </span>
                                </div>
                                <div class="wizard-step" data-wizard-type="step">
                                    <div class="wizard-label">
                                        <i class="wizard-icon flaticon2-location"></i>
                                        <h3 class="wizard-title">Restrict Location</h3>
                                    </div>
                                    <span class="svg-icon svg-icon-xl wizard-arrow">                                        
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"/>
                                                <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000) " x="11" y="5" width="2" height="14" rx="1"/>
                                                <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997) "/>
                                            </g>
                                        </svg>                                        
                                    </span>
                                </div>
                                <div class="wizard-step" data-wizard-type="step">
                                    <div class="wizard-label">
                                        <i class="wizard-icon flaticon-eye"></i>
                                        <h3 class="wizard-title">Preview</h3>
                                    </div>
                                    <span class="svg-icon svg-icon-xl wizard-arrow last">
                                        
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"/>
                                                <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000) " x="11" y="5" width="2" height="14" rx="1"/>
                                                <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997) "/>
                                            </g>
                                        </svg>
                                        
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center my-10 px-8 my-lg-15 px-lg-10">
                            <div class="col-xl-12 col-xxl-7">
                                <form class="form" id="kt_form">
									@if(session('level') >= 2)
                                    <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                                        <h3 class="mb-3 font-weight-bold text-dark">Select Business Name</h3>
                                        <?php if(session('level') >= 2){
                                            $get_temp = true;
                                        ?>
                                        <div class="card-toolbar" style="margin:0 auto">
                                            <div class="form-group" style="margin-bottom:0px;margin:0 auto;min-width:150px" id="t_bus_name_b">
                                                <select class="form-control selectpicker" id="t_bus_name" name="business_name" title="Business Name"  data-live-search="true" data-size="5">
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
                                                <select class="form-control selectpicker" id="t_bus_name" name="business_name" title="Business Name" data-live-search="true" data-size="5">
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
									@endif
                                    <div class="pb-5" data-wizard-type="step-content" data-wizard-state="{{session('level') >= 2 ? '' : 'current'}}">
                                        <h4 class="mb-3 font-weight-bold text-dark {{session('level')<2 && count($temp) == 1 ? 'hide-container' : ''}}">Select Template</h4>
                                        <div class="form-group" style="margin-bottom:0px;margin:0 auto;min-width:150px" id="t_bus_name_c">
                                            <select class="form-control selectpicker {{session('level')<2 && count($temp) == 1 ? 'hide-container' : ''}}" id="t_temp_name" name="template_name" title="Select Template Name">
													
                                            </select>
                                        </div>
                                        <h4 class="mt-5 mb-3 font-weight-bold text-dark">Insert your image into Template below</h4>
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
                                        <h4 class="mt-5 mb-3 font-weight-bold text-dfark" id="hid_text">Enter your Text into Template below</h4>
                                        <div class="form-group">
                                            <textarea class="form-control" id="over_text" rows="3" placeholder="Enter text you wish displayed. You are limited to XX characters including spaces. Strongly suggest limit to 6-7 words"></textarea>
                                        </div>
                                        <div class="form-group" style="display: none">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="overlay_img" name="overlay_img" accept=".jpg, .png, .jpeg">
                                                <label class="custom-file-label" for="overlay_img">Overlay Image</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pb-5" data-wizard-type="step-content">
                                        <h4 class="mb-3 font-weight-bold text-dark">Set Your Ad’s Individual Schedule</h4>
                                        <div class="form-group row" style="margin:0">
                                            <div class="col-md-12">
                                                <div class="radio-list radio_sch" id="schedule">
                                                    <label class="radio radio-danger">
                                                        <input type="radio" name="radio" checked value="ime"> Display Ad Continuously 24/7 (Recommended)
                                                        <span></span>
                                                    </label>
                                                    <span class="form-text text-muted">When activated, Ad will be displayed until you manually de-activate it.The Ad will be shown 24 hours a day.</span>
                                                    <label class="radio radio-danger" style="margin-top:10px">
                                                        <input type="radio" name="radio" value="frame">Display Ad on specific Dates and/or Times
                                                        <span></span>
                                                    </label>
                                                    <span class="form-text text-muted">Set Start Date and End Date, or Start time and End Time, or specific days of week end time to control when you want this Ad to show.</span>
                                                </div>
                                            </div>
                                            <div class="col-md-12" id="dis_sch" style="display:none">
                                                <div class="form-group row">
													<label for="example-date-input" class="col-form-label">If you set a specific End Date for THIS Ad, it will stop being displayed at midnight of the date entered.  All the rest of you ads will continue to be displayed according to their individual schedule or the Campaign Schedule.</label>
                                                    <label for="example-date-input" class="col-form-label">Start Date: Displays it the morning of that day.</label>
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
                                                    <label class="col-form-label">Days of the Week: The Ad will be displayed only on Checked Days.</label>
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
                                                    <div class="col-12">
                                                        <label class="col-form-label">Option 1</label>
                                                        <div class="form-group">
                                                            <div class="radio-list radio_sch" id="no_end">
                                                                <label class="radio">
                                                                    <input type="radio" checked="checked" name="no_end" value="1"/>
                                                                    <span></span>
                                                                    No End Date
                                                                </label>
                                                                <label class="radio">
                                                                    <input type="radio" name="no_end" value="0"/>
                                                                    <span></span>
                                                                    Set End Date
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 div_end" style="display:none">
                                                        <label class="col-form-label">Option 2 (Set End Date)</label>
                                                        <div class="form-group row">
                                                            <input class="form-control" type="date" value="{{date('Y-m-d')}}" min="{{date('Y-m-d')}}" id="end_date" name="e_date" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pb-5" data-wizard-type="step-content">
                                        <h4 class="mb-3 font-weight-bold text-dark">Do you want to restrict this Ad to a particular location?</h4>
                                        <div class="form-group" id="restrict">
                                            <div class="res-radio" style="display:grid">
                                                <label class="radio">
                                                    <input type="radio" checked name="restrict" value="1"/>
                                                    <span></span>
                                                    No.(Highly Recommended) Let my campaign direct where my Ad is displayed.
                                                </label>
                                                <label class="radio">
                                                    <input type="radio" name="restrict" value="0"/>
                                                    <span></span>
                                                    Yes.(Not Recommended. Campaign Manager cannot move/display this particular Ad anywhere else but selected side I designated on billboard.)
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group res-div" style="display:none">
											<label>ONLY use this function if your Ad does not make sense if moved to the other side of the billboard or on another location.</label>
                                            <div class="checkbox-list mb-5 ml-5" id="location_list"></div>
                                            <button class="btn btn-success save_rest" type="button">Store Selected Restricted Location</button>
                                        </div>
                                    </div>
                                    <div class="pb-5" data-wizard-type="step-content">
                                        <h4 class="mb-3 font-weight-bold text-dark">Preview your Ad and Save</h4>
										@if(session('level') >= 2)
										<h6 class="font-weight-bolder mb-3">
											Business Name
										</h6>
										@endif
										<div class="text-dark-50 line-height-lg">
											<div id="selected_business"></div>
										</div>
										<div class="separator separator-dashed my-5"></div>
										<h6 class="font-weight-bolder mb-3">
											Preview
										</h6>
										<div class="form-group" id="preview-container">
											<img src="" id="preview_img">
										</div>
										<input id="img_name" type="hidden"/>
										<div class="separator separator-dashed my-5"></div>
										<h6 class="font-weight-bolder mb-3">
											Schedule
										</h6>
										<div class="text-dark-50 line-height-lg">
											<div id="selected_schedule"></div>
										</div>
										<div class="separator separator-dashed my-5"></div>
										<h6 class="font-weight-bolder mb-3">
											Restrict Location
										</h6>
										<div class="text-dark-50 line-height-lg">
											<div id="selected_location"></div>
										</div>
                                    </div>
                                    <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                        <div class="mr-2">
                                            <button type="button" class="btn btn-light-primary font-weight-bold text-uppercase px-9 py-4" data-wizard-type="action-prev">
                                            Previous
                                            </button>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-success font-weight-bold text-uppercase px-9 py-4" id="btn_submit" data-wizard-type="action-submit">
                                            Save Ad to Playlist
                                            </button>
                                            <button type="button" class="btn btn-primary font-weight-bold text-uppercase px-9 py-4" id="btn-next" data-wizard-type="action-next">
                                            Next
                                            </button>
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
</div>
<div class="modal fade" id="specModal" tabindex="-1" role="dialog" aria-labelledby="specModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="specModalLabel">Instructions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
				<ul>
					<li>The image must be a PNG (recommended) or JPG or JPEG.</li>
					<li>Do NOT use a PDF.</li>
					<li>The aspect ratio must be 1.5 to 1.</li>
					<li>Minimum image size is 600 pixels x 400 pixels. We will automatically resize files.</li>
					<li>You may add unlimited Ads at no additional cost.</li>
					<li>Adding more Ads does NOT mean they are automatically delivered to the billboard.   Use your Playlist to "turn them on or off'.  Your Playlist determines if some or all your Ads get displayed.</li>
					<li>The height of your font needs to be at least 1/10th the height of your total image. Why? This makes it readable at a proper distance.</li>
				</ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="schModal" tabindex="-1" role="dialog" aria-labelledby="specModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="specModalLabel">Instructions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
				<ul>
					<li>Recommended:  The default setting is Display Ad Continuously 24/7.</li>
					<li>Unless you want to limit the Ad to a specific date, day, or time, we recommend you leave it at the default setting.</li>
					<li>Restricting this Ad’s particular schedule does not affect any other Ad.</li>
					<li>You may change this schedule later at any time.</li>
				</ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="restrictModal" tabindex="-1" role="dialog" aria-labelledby="specModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="specModalLabel">Instructions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
				<ul>
					<li>Recommended:  The default setting is to allow this Ad to be seen at any sign locations you select in your Campaign (not selected here).</li>
					<li>If you are advertising on multiple sign locations, you may lock a particular Ad to a specific location.   This means it will NOT be seen at any other location except the one(s) you designate.</li>
				</ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Preview -->
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="specModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="specModalLabel">Instructions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
				<ul>
					<li>You cannot modify the image after you have saved it.</li>
					<li>You can modify the Schedule and Location at any time after you have saved it.</li>
					<li>Save this Ad means it will be added to your Playlist.</li>
					<li>Saving this Ad does not mean it automatically is displayed on the billboards.  Manage Playlist controls that function.</li>
				</ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="specModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="specModalLabel">Basic Ad Design Rules 
					<a href='/guide/FAQs.pdf' target='_blank'><i class="fas fa-file-download text-danger"></i></a>
				</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
				<h3 class="mb-3 font-weight-bold text-dark">1. Seven words max.</h3>
				<span>People only spend 3 seconds reading your billboard ad. Even if the sign is near a stop light, people still will not spend more time when if you have more copy than this. This is the most important rule you can learn.</span>
				<h3 class="mb-3 mt-3 font-weight-bold text-dark">2. Use relevant images.</h3>
				<span>Only use images that help set a tone or illustrate your benefit to your client. Unless your face gives people a reason to show up at your business, you don’t need to be on a billboard. Use images that reinforce the concept of the Benefit to them. </span>
				<h3 class="mb-3 mt-3 font-weight-bold text-dark">3. Limit the bright and crazy colors.</h3>
				<span>Ads get attention because they’re based on a solid strategy and welldesigned, not because you use bright colors. Relying on obnoxious colors can damage your image. </span>
				<h3 class="mb-3 mt-3 font-weight-bold text-dark">4. List only one point of contact.</h3>
				<span>The best one? Your company name that Google uses to find you. Why? people use search engines by using your company name. Second best? Your web site address. </span>
				<h3 class="mb-3 mt-3 font-weight-bold text-dark">5. The Font Type is important.</h3>
				<span>Stop using Arial, Impact and Times. We suggest Gotham (this page uses a Gotham font). Gotham works well with digital signage. Narrow fonts and italics display poorly on digital signage </span>
				<h3 class="mb-3 mt-3 font-weight-bold text-dark">6. The Font Size is more important.</h3>
				<span>The height of your font needs to be at least 1/10th the height of your total image. Why? This makes it readable at a proper distance.</span>
				<h3 class="mb-3 mt-3 font-weight-bold text-dark">7. Do not use a white background.</h3>
				<span>White is tough to dim at night. It will irritate your potential clients. Keep the use of white to less than 30% of the image. </span>
            </div>
            <div class="modal-footer">
				<a href='/guide/FAQs.pdf' target='_blank' class="d-block text-left btn btn-text-danger btn-light-danger btn-hover-danger font-weight-bold">Download</a>
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="createAdsModal" tabindex="-1" role="dialog" aria-labelledby="specModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
				<div>
					<h5 class="modal-title" id="specModalLabel">
						<a href='/guide/CreatingYourAds.pdf' target='_blank'><i class="fas fa-file-download text-danger"></i></a>
					</h5>
				</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
				<h3 class="mb-3 mt-3 font-weight-bold text-dark text-center">Creating Your Ads </h3>
				<span><strong>First Rule: </strong>Before you create a set of Ads, look hard at who your customers are. This determines the images you use and the words you use. Meaning? If your customers are younger, use pictures with the appropriate age. If you have multiple age groups, create several ads aimed at each group. People respond more when they identify with the picture. Know their gender, ages, income level, and most of all, their needs. </span><br><br>
				<span><strong>Second Rule: </strong>Make the Ad about the Benefit to the customer. Make the benefit obvious. No one cares you are #1 in this or that. Declaring you are the best is not necessarily the objective here. They care about what is in it for them. Do they get it faster? Better quality over your competitors? Is it cheaper? Do you provide better support after the sale? You are not a giant company with a great brand mark, so get to their needs, not yours</span><br><br>
				<span><strong>Third Rule: </strong>Have a specific objective for each Ad you create. A general Ad aimed at everyone gets no one to call you. Tell your graphic designer what your objective is for each Ad, let them create the image. There are five objectives. Not all objectives are appropriate for you (example: store location ad if you are a home-based business). </span><br><br>
				<span>The Objectives: </span><br><br>
				<div class="d-flex">
					<div class="symbol symbol-40 mr-5">
						<span class="symbol-label bg-transparent">
							<img src="/img/image001.jpg" class="h-75 align-self-end" alt="">
						</span>
					</div>
					<div class="d-flex flex-column">
						<span><strong>Brand Marking:</strong> Have one of these Ads. Your logo and company name are important for their muscle memory. Make sure they are easily readable. Its JOB? The public get to know and remember you exist. A simple catchy phrase helps them remember you. </span><br>
					</div>
				</div>
				<div class="d-flex">
					<div class="symbol symbol-40 symbol-light-primary mr-5">
						<span class="symbol-label bg-transparent">
							<img src="/img/image003.png" class="h-75 align-self-end" alt="">
						</span>
					</div>
					<div class="d-flex flex-column">
						<span><strong>Drive them to your web site:</strong>  If you have a site that sells online or allows them to make appointments, or allows clients to login to perform some function, this approach is great. If your web site is just another advertisement, why use a billboard Ad to send them to another Ad? Don’t put phone numbers or physical addresses on this one. </span><br>
					</div>
				</div>
				<div class="d-flex">
					<div class="symbol symbol-40 symbol-light-primary mr-5">
						<span class="symbol-label bg-transparent">
							<img src="/img/image005.png" class="h-75 align-self-end" alt="">
						</span>
					</div>
					<div class="d-flex flex-column">
						<span><strong>Drive them to your location:</strong> Are you nearby? Make it easy to find your store. Do not include your phone number or your web site address. Maybe use a simplified map or the proximity to a very recognizable landmark. The point is getting them in the door. </span><br>
					</div>
				</div>
				<div class="d-flex">
					<div class="symbol symbol-40 symbol-light-primary mr-5">
						<span class="symbol-label bg-transparent">
							<img src="/img/image007.png" class="h-75 align-self-end" alt="">
						</span>
					</div>
					<div class="d-flex flex-column">
						<span><strong>Education:</strong> Make a customer smart about picking the right product. Help them use your services or products correctly. Example: we have a plumber who tells people about the right way to ‘drip’ the faucet when it is forecast to be well below freezing. In the process, you become the Subject Matter Expert (SME). People remember this help. </span><br>
					</div>
				</div>
				<div class="d-flex">
					<div class="symbol symbol-40 symbol-light-primary mr-5">
						<span class="symbol-label bg-transparent">
							<img src="/img/image009.png" class="h-75 align-self-end" alt="">
						</span>
					</div>
					<div class="d-flex flex-column">
						<span><strong>Sales/Promotions:</strong> The biggest advantage to digital billboards: creating Ads for a specific date and time (example: Use one Ad to promote the sale next day. Use the next Ad to reinforce the point the Ad is today). Use a Sale on specific item to draw people into the store, then add your upsell on your higher margin products. </span><br>
					</div>
				</div>
				
				<span><strong>Fourth Rule: </strong> Use a professional graphic designer. Our system provides you the technology at an economical price but it is just a delivery system. Remember “Content is King”? The effectiveness of your ads hinge on how well thought out they are. You focus on the message, let the graphic designer focus on using images to reinforce your message. ….AND never forget to make the Ad about solving their pain. Show them the obvious BENEFIT to them. </span><br><br>
				<span><strong>Fifth Rule:</strong> Tinker with your Ads. About once a month or two, revisit your Ads. Change a word or two, Add a new set of Ads (ads are relatively cheap to create – about $50 per ad. </span><br><br>
				<span><strong>Bottom Line: </strong> These are not your father’s billboards – they can do just-in-time advertising. You can easily use them for setting up impulse buying in mere minutes (try that with TV Ads, radio spots).</span><br><br>
				<span>People spend nearly 1/5th of their waking hours in a car – meaning they see signs, lots of signs. Which ones stick out? Digital signs get remembered the most. Most people make purchase decisions on the way home. </span>
				<h3 class="mb-3 mt-3 font-weight-bold text-danger text-center">Never forget – Make it about the BENEFIT to the Customer</h3>
            </div>
            <div class="modal-footer">
				<a href='/guide/CreatingYourAds.pdf' target='_blank' class="d-block text-left btn btn-text-danger btn-light-danger btn-hover-danger font-weight-bold">Download</a>
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@include('admin.include.admin-footer')
<script>
var HOST_URL = "https://keenthemes.com/metronic/tools/preview";
</script>
<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
<script src="/assets/plugins/global/plugins.bundle.js"></script>
<script src="/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
@if(session('level')>=2)
<script src="/js/wizards/update_ad.js"></script>
@else
<script src="/js/wizards/update_ad_client.js"></script>
@endif
<script src="/js/suggest.js"></script>
<script src="/assets/js/scripts.bundle.js"></script>
<!-- <script src="/assets/js/pages/custom/wizard/wizard-1.js"></script> -->
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
	$("#kt_form").submit(function(event){
		event.preventDefault();
		processImage();			
	})
	$("#btn_submit").on('click', function(event){
		completeRequest()
	})
	function completeRequest() {
		var fs = new FormData(document.getElementById("kt_form"));
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
		fs.append("location",location_list);
		fs.append("days",days);
		fs.append("img_url",$("#img_name").val());
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
						cancelButtonText: "Create another Ad",
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
	$("#schedule").find("input").each(function(){
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
		$('.top-business').text($(this).val());
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
					$("#schedule").find("input").each(function(){
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
					$("#schedule").find("input").each(function(){
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

				$("#dis_overimg, #preview_img").css('display', "block");
				$("#dis_overimg, #preview_img").css("marginLeft",res[0]['over_l']);
				$("#dis_overimg, #preview_img").css("marginTop",res[0]['over_t']);
				$("#dis_overimg, #preview_img").width(res[0]['over_w']);
				$("#dis_overimg, #preview_img").height(res[0]['over_h']);

				if(res[0]['over_img'] != null){
					$("#dis_overimg, #preview_img").attr("src",'/upload/'+res[0]['over_img']);
				}
				else{
					$("#dis_overimg, #preview_img").attr("src",'/blank_overlay.png');
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