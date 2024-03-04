@include('admin.include.admin-header')
<link type="text/css" rel="stylesheet" href="/assets/css/tips.css" /> 
<style>
    .price {
        color : red;
    }
    .hide {
        display: none !important;
    }
    .sub-text{
        display: none;
    }
    @media (max-width: 992px) {
        .table-view{
            overflow-x: scroll;
        }
        #pre_img{
            height: 300px;
        }
    }
    @media (max-width: 768px) {
        .sub-text{
            display: block;
        }
        /* Wizard */
        .row.justify-content-center.my-10.px-8.my-lg-15.px-lg-10{
            margin-top: 1rem !important;
            margin-bottom: 1rem !important;
        }
        .d-flex.justify-content-between.border-top.mt-5.pt-10{
            margin-top: 1rem !important;
            padding-top: 1rem !important;
        }
        form#kt_form div.pb-5{
            padding-bottom: 0rem !important;
        }
        form#kt_form .mb-5, form#kt_form .form-group{
            margin-bottom: 0.3rem !important;
        }
        .separator.separator-dashed{
            margin-bottom: 0.5rem !important;
            margin-top: 0.5rem !important;
        }
    }
    #kt_datatable{
        min-width: 600px;
    }
</style>
<link href="/assets/css/pages/wizard/wizard-1.css" rel="stylesheet" type="text/css"/>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader min-h-lg-15px pt-5 pb-7 subheader-transparent" id="kt_subheader">
    </div>
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="alert alert-custom alert-white alert-shadow fade show gutter-b tip-container" role="alert">
                <div class="alert-text">
                    @if(session('level') >= 2)
                        @if(session('level') == 4)
						<ul class="tip">
							<li><h4>This screen only seen by an Account Manager.</h4></li>
							<li><h4>Begin to type the client’s Business Name to shorten your list.</h4></li>
						</ul>
					    @else
                        <ul class="tip">
                            <a type="button" class="btn btn-text-white btn-success font-weight-bold btn-spec" data-toggle="modal" data-target="#preFirstModal">Instructions</a>
                        </ul>
                        @endif
                    @endif
                    <ul class="tip {{session('level') >= 2?'hide':''}}">
                        <a type="button" class="btn btn-text-white btn-success font-weight-bold btn-spec" data-toggle="modal" data-target="#specModal">Instructions</a>
					</ul>
                    <ul class="tip hide">
						<a type="button" class="btn btn-text-white btn-success font-weight-bold btn-spec" data-toggle="modal" data-target="#specDateModal">Instructions</a>
					</ul>
					<ul class="tip hide">
						<a type="button" class="btn btn-text-white btn-success font-weight-bold btn-spec" data-toggle="modal" data-target="#specModalDate">Instructions</a>
					</ul>
                    <ul class="tip hide">
						<a type="button" class="btn btn-text-white btn-success font-weight-bold btn-spec" data-toggle="modal" data-target="#specSignModal">Instructions</a>
					</ul>
                    <ul class="tip hide">
						<a type="button" class="btn btn-text-white btn-success font-weight-bold btn-spec" data-toggle="modal" data-target="#specPaymentModal">Instructions</a>
					</ul>
                    <ul class="tip hide">
                        <a type="button" class="btn btn-text-white btn-success font-weight-bold btn-spec" data-toggle="modal" data-target="#previewModal">Instructions</a>
                    </ul>
                </div>
                <div class="alert-icon d-block text-right tips">
					<a data-toggle="modal" data-target="#FaqModal" class="btn btn-text-white btn-success font-weight-bold">What is a Campaign?</a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom" data-card="true" id="kt_card_1">
                        <div class="card-body p-0">
                            <div class="wizard wizard-1" id="kt_wizard_v1" data-wizard-state="step-first" data-wizard-clickable="false">
                                <div class="wizard-nav border-bottom">
                                    <div class="wizard-steps p-8 p-lg-10">
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
                                        <div class="wizard-step" data-wizard-type="step" data-wizard-state="{{session('level') >= 2?'':'current'}}">
                                            <div class="wizard-label">
                                                <i class="wizard-icon flaticon2-sort-alphabetically"></i>
                                                <h3 class="wizard-title">Campaign Name</h3>
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
                                                <h3 class="wizard-title">Campaign Dates</h3>
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
                                                <i class="wizard-icon flaticon-calendar"></i>
                                                <h3 class="wizard-title">Days of the Week</h3>
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
                                                <h3 class="wizard-title">Select Signs</h3>
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
                                                <i class="wizard-icon flaticon-price-tag"></i>
                                                <h3 class="wizard-title">Payment Method</h3>
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
                                                <i class="wizard-icon flaticon-list-3"></i>
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
                                                <h3 class="mb-5 font-weight-bold text-dark">Select Business Name</h3>
                                                <div class="form-group">
                                                    <select class="form-control select2 business_name" name="business_name" id="business_name">
                                                        <option value="">Select Business Name</option>
                                                        @foreach($business_name as $key => $val)
                                                        <option value="{{$val->business_name}}">{{$val->business_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="pb-5" data-wizard-type="step-content" data-wizard-state="{{session('level') >= 2?'':'current'}}">
                                                <h3 class="mb-5 font-weight-bold text-dark">Campaign Name</h3>
                                                <div class="form-group">
                                                    <input class="form-control form-control-lg form-control-solid" type="text" value="{{old('name')?old('name'):''}}" name="camp_name" id="camp_name" placeholder="Campaign Name" required/>
                                                </div>
                                            </div>
                                            <div class="pb-5" data-wizard-type="step-content">
                                                <div class="row">
                                                    <div class="col-sm-4 col-md-4 col-lg-4">
                                                        <h3 class="mb-5 font-weight-bold text-dark">Campaign Start Date</h3>
                                                        <div class="form-group">
                                                            <input class="form-control form-control-sm mb-5 form-control-solid camp_start" type="date" min="{{date('Y-m-d')}}" value="{{old('camp_start')?old('camp_start'):date('Y-m-d')}}" name="camp_start" required/>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-md-4 col-lg-4">
                                                        <h3 class="mb-5 font-weight-bold text-dark">Number of Weeks</h3>
                                                        <div class="form-group">
                                                            <input class="form-control form-control-sm mb-5 form-control-solid num_weeks" name="num_weeks" type="number" min="0" max="52" value="{{old('num_weeks')?old('num_weeks'):12}}" required/>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-md-4 col-lg-4">
                                                        <h3 class="mb-5 font-weight-bold text-dark">Calculated End Date</h3>
                                                        <div class="form-group">
                                                            <input class="form-control form-control-sm form-control-solid camp_end" disabled name="camp_end" type="date" min='{{date("Y-m-d", strtotime("+6 days"))}}' value='{{old("camp_end")?old("camp_end"):date("Y-m-d", strtotime("+83 days"))}}' name="camp_end" required/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pb-5" data-wizard-type="step-content">
                                                <h3 class="mb-5 font-weight-bold text-dark">Days of the Week</h3>
                                                <div class="checkbox-inline" id="days">
                                                    <label class="checkbox checkbox-primary">
                                                        <input type="checkbox" checked="checked" class="days" value="Mon"> M
                                                        <span></span>
                                                    </label>
                                                    <label class="checkbox checkbox-primary">
                                                        <input type="checkbox" checked="checked" class="days" value="Tue"> T
                                                        <span></span>
                                                    </label>
                                                    <label class="checkbox checkbox-primary">
                                                        <input type="checkbox" checked="checked" class="days" value="Wed"> W
                                                        <span></span>
                                                    </label>
                                                    <label class="checkbox checkbox-primary">
                                                        <input type="checkbox" checked="checked" class="days" value="Thu"> T
                                                        <span></span>
                                                    </label>
                                                    <label class="checkbox checkbox-primary">
                                                        <input type="checkbox" checked="checked" class="days" value="Fri"> F
                                                        <span></span>
                                                    </label>
                                                    <label class="checkbox checkbox-primary">
                                                        <input type="checkbox" checked="checked" class="days" value="Sat"> S
                                                        <span></span>
                                                    </label>
                                                    <label class="checkbox checkbox-primary">
                                                        <input type="checkbox" checked="checked" class="days" value="Sun"> S
                                                        <span></span>
                                                    </label>
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" id="selected_days" name="selected_days" type="hidden">
                                                </div>
                                            </div>
                                            <div class="pb-5" data-wizard-type="step-content">
                                                <h3 class="mb-5 font-weight-bold text-dark">Select Signs</h3>
                                                <span class="sub-text">Scroll left and right to see entire screen</span>
                                                <div class="form-group">
                                                    <input class="form-control" id="selected_signs" name="selected_signs" type="hidden">
                                                </div>
                                                <div class="table-view">
                                                    <table class="table table-bordered table-hover table-checkable" id="kt_datatable">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>
                                                                    Sign Name
                                                                </th>
                                                                <th data-toggle="popover" title="Available Slots" data-placement="bottom"
                                                                    data-content="You may purchase as many slots as are available.   Normally you select just one unless you want to ‘take over’ a sign for a specific time frame.">Slots
                                                                    <i class="far fa-question-circle text-danger"></i>
                                                                </th>
                                                                <th>
                                                                    Weekly Fee
                                                                </th>
                                                                <!-- <th data-toggle="popover" title="Standard Weekly Cost" data-placement="bottom"
                                                                    data-content="This price reflects the standard rate for that sign for the number of days in a week that you selected.">
                                                                    Weekly Fee
                                                                    <i class="far fa-question-circle text-danger"></i>
                                                                </th> -->
                                                                <th class="hide" data-toggle="popover" title="Discounted Cost" data-placement="bottom"
                                                                    data-content="When you use more than one slot (regardless of its location), you get a discount.  The price displayed is the real price you will be charged.">Discounted Cost
                                                                    <i class="far fa-question-circle text-danger"></i>
                                                                </th>
                                                                <th data-toggle="popover" title="Location" data-placement="bottom"
                                                                    data-content="Displays the sign’s location and the direction from where it can be viewed">Location
                                                                    <i class="far fa-question-circle text-danger"></i>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="sign_div">
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="form-group row mt-5 dis_payments">
                                                    <div class="col-md-7">
                                                    </div>
                                                    <div class="col-md-5">
                                                        <table class="w-100">
                                                            <tr>
                                                                <td><strong>Weeks</strong></td>
                                                                <td>
                                                                    <input id="dis_week" class="form-control text-right" value="12" disabled>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Standard Weekly Charges</strong></td>
                                                                <td>
                                                                    <input id="dis_sub" class="form-control input-mask" data-inputmask-alias="currency" disabled>
                                                                </td>
                                                            </tr>
                                                            <tr class="hide">
                                                                <td><strong>Discounts</strong></td>
                                                                <td>
                                                                    <input id="dis_dis" class="form-control input-mask" data-inputmask-alias="currency" disabled/>
                                                                </td>
                                                            </tr>
                                                            <tr class="coupon" style="display:none">
                                                                <td><strong class="coupon-label">Coupon</strong></td>
                                                                <td>
                                                                    <input class="form-control text-right coupon_number input-mask" value=""  data-inputmask-alias="currency" disabled/>
                                                                    <input type="hidden" class="coupon_num" value="0">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Weekly Total</strong></td>
                                                                <td>
                                                                    <input id="dis_total" class="form-control input-mask" data-inputmask-alias="currency" disabled>
                                                                    <input id="total_amount" type="hidden">
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pb-5" data-wizard-type="step-content">
                                                <h3 class="mb-5 font-weight-bold text-dark">Select Payment Method</h3>
                                                <div class="radio-inline mb-5 p-method">
                                                    <label class="radio">
                                                        <input type="radio" checked name="method" value="0"/>
                                                        <span></span>
                                                        Credit Card
                                                    </label>
                                                    <label class="radio">
                                                        <input type="radio" name="method" value="1"/>
                                                        <span></span>
                                                        Send Invoice - Please remember payment will be due prior to Campaign starts.
                                                    </label>
                                                </div>
                                                <h3 class="mb-5 font-weight-bold text-dark">Payment Schedule</h3>
                                                <div class="form-group mt-5 sch">
                                                    <div class="radio-inline">
                                                        <label class="radio">
                                                            <input type="radio" name="pay_sch" value="0"/>
                                                            <span></span>
                                                            In Full
                                                        </label>
                                                        <label class="radio">
                                                            <input type="radio" checked name="pay_sch" value="3"/>
                                                            <span></span>
                                                            12 weeks
                                                        </label>
                                                        <label class="radio">
                                                            <input type="radio" checked name="pay_sch" value="2"/>
                                                            <span></span>
                                                            4 weeks
                                                        </label>
                                                        <label class="radio">
                                                            <input type="radio" name="pay_sch" value="1"/>
                                                            <span></span>
                                                            every week
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group row mt-5 dis_payments">
                                                    <div class="col-md-7">
                                                    </div>
                                                    <div class="col-md-5">
                                                        <table class="w-100">
                                                            <tr>
                                                                <td><strong>Each Payment</strong></td>
                                                                <td>
                                                                    <input class="form-control input-mask amount text-left" id="part_amount" placeholder="Amount" data-inputmask-alias="currency" disabled>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pb-5" data-wizard-type="step-content">
                                                <h3 class="mb-5 font-weight-bold text-dark">Review your Choices</h3>
                                                <span class='text-dark-75'>These choices cannot be changed once you have paid for the campaign.  All you can do is shorten the campaign.</span>
                                                @if(session('level') >= 2)
                                                    <h6 class="font-weight-bolder mb-3">
                                                        Business Name <a class="btn_edit" data-id="1" data-container="body" data-toggle="tooltip" data-placement="right" title="Edit"><i class="icon-xl la la-edit text-danger"></i></a>
                                                    </h6>
                                                @endif
                                                <div class="text-dark-50 line-height-lg">
                                                    <div id="selected_business"></div>
                                                </div>
                                                <div class="separator separator-dashed my-5"></div>
                                                <h6 class="font-weight-bolder mb-3">
                                                    Campaign Name <a class="btn_edit" data-id="{{session('level') >= 2 ? 2 : 1}}" data-container="body" data-toggle="tooltip" data-placement="right" title="Edit"><i class="icon-xl la la-edit text-danger"></i></a>
                                                </h6>
                                                <div class="text-dark-50 line-height-lg">
                                                    <div id="selected_camp_name"></div>
                                                </div>
                                                <div class="separator separator-dashed my-5"></div>
                                                <h6 class="font-weight-bolder mb-3">
                                                    Campaign Start Date <a class="btn_edit" data-id="{{session('level') >= 2 ? 3 : 2}}" data-container="body" data-toggle="tooltip" data-placement="right" title="Edit"><i class="icon-xl la la-edit text-danger"></i></a>
                                                </h6>
                                                <div class="text-dark-50 line-height-lg">
                                                    <div id="selected_camp_start"></div>
                                                </div>
                                                <div class="separator separator-dashed my-5"></div>
                                                <h6 class="font-weight-bolder mb-3">
                                                    Number of weeks <a class="btn_edit" data-id="{{session('level') >= 2 ? 3 : 2}}" data-container="body" data-toggle="tooltip" data-placement="right" title="Edit"><i class="icon-xl la la-edit text-danger"></i></a>
                                                </h6>
                                                <div class="text-dark-50 line-height-lg">
                                                    <div id="selected_number_weeks"></div>
                                                </div>
                                                <div class="separator separator-dashed my-5"></div>
                                                <h6 class="font-weight-bolder mb-3">
                                                    Campaign End Date <a class="btn_edit" data-id="{{session('level') >= 2 ? 3 : 2}}" data-container="body" data-toggle="tooltip" data-placement="right" title="Edit"><i class="icon-xl la la-edit text-danger"></i></a>
                                                </h6>
                                                <div class="text-dark-50 line-height-lg">
                                                    <div id="selected_camp_end"></div>
                                                </div>
                                                <div class="separator separator-dashed my-5"></div>
                                                <h6 class="font-weight-bolder mb-3">
                                                    Days of the Week <a class="btn_edit" data-id="{{session('level') >= 2 ? 4 : 3}}" data-container="body" data-toggle="tooltip" data-placement="right" title="Edit"><i class="icon-xl la la-edit text-danger"></i></a>
                                                </h6>
                                                <div class="text-dark-50 line-height-lg">
                                                    <div id="selected_weeks"></div>
                                                </div>
                                                <div class="separator separator-dashed my-5"></div>
                                                <h6 class="font-weight-bolder mb-3">
                                                    Selected Signs <a class="btn_edit" data-id="{{session('level') >= 2 ? 5 : 4}}" data-container="body" data-toggle="tooltip" data-placement="right" title="Edit"><i class="icon-xl la la-edit text-danger"></i></a>
                                                </h6>
                                                <div class="text-dark-50 line-height-lg">
                                                    <div id="selected_sign_name"></div>
                                                </div>
                                                <div class="separator separator-dashed my-5"></div>
                                                <h6 class="font-weight-bolder mb-3">
                                                    Payment Method <a class="btn_edit" data-id="{{session('level') >= 2 ? 6 : 5}}" data-container="body" data-toggle="tooltip" data-placement="right" title="Edit"><i class="icon-xl la la-edit text-danger"></i></a>
                                                </h6>
                                                <div class="text-dark-50 line-height-lg">
                                                    <div id="selected_method"></div>
                                                </div>
                                                <div class="separator separator-dashed my-5"></div>
                                                <h6 class="font-weight-bolder mb-3">
                                                    Payment Schedule <a class="btn_edit" data-id="{{session('level') >= 2 ? 6 : 5}}" data-container="body" data-toggle="tooltip" data-placement="right" title="Edit"><i class="icon-xl la la-edit text-danger"></i></a>
                                                </h6>
                                                <div class="text-dark-50 line-height-lg">
                                                    <div id="selected_schedule"></div>
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
                                                    Checkout
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
    </div>
</div>
<button type="button" class="btn btn-primary btn-preview" data-toggle="modal" data-target="#preModal" style="display:none">
    Launch modal
</button>
<div class="modal fade" id="preFirstModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="specModalLabel">Instructions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
				<ul>
                    <li>You must have a Campaign for your Ad Playlist to be delivered to a billboard.</li>
                    <li>The minimum length is one week (we highly advise your plan on a 12-week minimum to gain advertising traction.</li>
                    <li>You only get charged for the weeks you advertise.</li>
                    <li>You can start and stop your advertising campaigns.</li>
				</ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="introModal" tabindex="-1" role="dialog" aria-labelledby="specModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="specModalLabel">Instructions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
				<ul>
                    <li>You MUST have a Campaign for your Ad Playlist to be delivered to a billboard.</li>
                    <li>You only get charged for the weeks you advertise.</li>
                    <li>Campaign Names are for your personal use.</li>
                    <li>If you create multiple campaigns, each name must be unique.</li>
                    <li>Stating the objective of this campaign is a great naming convention.</li>
				</ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="specModal" tabindex="-1" role="dialog" aria-labelledby="specModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="specModalLabel">Instructions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
				<ul>
                    <li>You MUST have a Campaign for your Ad Playlist to be delivered to a billboard.</li>
                    <li>You only get charged for the weeks you advertise.</li>
                    <li>Campaign Names are for your personal use.</li>
                    <li>If you create multiple campaigns, each name must be unique.</li>
                    <li>Stating the objective of this campaign is a great naming convention.</li>
				</ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="specDateModal" tabindex="-1" role="dialog" aria-labelledby="specModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="specModalLabel">Instructions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
				<ul>
                    <li>Make sure you have your Ads (sometimes called Creatives) ready by the start date you enter.</li>
                    <li>Make the Number of Weeks fairly large since you can always cut a campaign short.  Frankly, three months is what we consider a minimum to gain any traction in your advertising.</li>
				</ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="specModalDate" tabindex="-1" role="dialog" aria-labelledby="specModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="specModalLabel">Instructions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
				<ul>
                    <li>Normally Ads are displayed 24/7 every day.</li>
                    <li>Since Campaigns are Weekly events, by deselecting certain Days of the Week, you limit the days any of your Ads are seen.</li>
				</ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="specSignModal" tabindex="-1" role="dialog" aria-labelledby="specModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="specModalLabel">Instructions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
				<ul>
                    <li>Changing the number of Available Slots will increase your visibility on a sign.</li>
                    <li>If you have an event on a particular date and want to increase your visibility during that last week, create a separate campaign for that week.  Use as many slots as you desire.</li>
				</ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="specPaymentModal" tabindex="-1" role="dialog" aria-labelledby="specModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="specModalLabel">Instructions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
				<ul>
                    <li>Choosing to pay by credit card allows you to pay weekly.</li>
                    <li>If you choose to be Invoiced, we require the payment to arrive prior to start date.</li>
				</ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="specModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="specModalLabel">Instructions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
				<ul>
                    <li>These choices cannot be changed once you have paid for the campaign.</li>
                    <li> Exception: You can stop the campaign at any time and not get charged again. (the campaign will be displayed until end of currently paid payment period).</li>
				</ul>
            </div>
            <div class="modal-footer">
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
@if(session('level') >= 2)
<script src="/js/wizards/campaign.js"></script>
@else
<script src="/js/wizards/campaign_client.js"></script>
@endif
<script src="/js/suggest.js"></script>
<script src="/js/inputmask.js"></script>
<script src="/assets/js/scripts.bundle.js"></script>
<script src="/assets/js/campaign.js"></script>
<script>
    var p_meth = '';
    function display_total(){
        var def = 0;
        var sub = 0;
        var coupon = change_format($(".coupon_number").val());
        $("#sign_div").find('tr').each(function(){
            if($(this).find('.signs').prop('checked') == true){
                $(this).find('.price').each(function(){
                    var temp = change_format($(this).text())
                    def += parseFloat(temp);
                })
                $(this).find('.sub_total').each(function(){
                    var temp = change_format($(this).text())
                    sub += parseFloat(temp);
                })
            }
        })
        $("#dis_sub").val("$ " + def );
        $("#dis_dis").val("$ -" + (def - sub));
        $("#dis_total").val("$ " + (sub - coupon).toFixed(2) )
        // Copy
        // $("#copy_dis_week").val($("#dis_week").val());
        // $("#copy_dis_sub").val("$ " + def);
        // $("#copy_dis_total").val("$ " + (sub - coupon).toFixed(2) )
        var total = ((sub - coupon) * $(".num_weeks").val()).toFixed(2);
        $("#total_amount").val(total);
        get_payment_method();
    }
    $('.select2').select2({
        placeholder: "Pick a Client"
    });
    function change_format(data){
        var data = data.replace(/\$/g, '');
        data = data.replace(/\ /g, '');
        data = data.replace(/\,/g, '');
        return data;
    }
    function get_payment_method(){
        var total_amount = $("#total_amount").val().replace(/\,/g, '');
        total_amount = total_amount.replace(/\$/g, '');
        total_amount = total_amount.replace(/\ /g, '');
        var weeks = $("#dis_week").val();
        var cur_sch = 0;
        var total = 0;
        $(".sch").find('input').each(function(){
            if($(this).prop('checked') == true){
                cur_sch = $(this).val();
            }
        })
        if(cur_sch == 0){
            total = total_amount;
        }
        else if(cur_sch == 1){
            total = parseFloat(total_amount / weeks).toFixed(2);
        }
        else if(cur_sch == 2){
            var period = parseInt(weeks / 4);
            if(weeks % 4  == 0){
                total = parseFloat(total_amount / period).toFixed(2)
            }
            else{
                total = parseFloat(total_amount / (period + 1)).toFixed(2);
            } 
        }
        else{
            var period = parseInt(weeks / 12);
            if(weeks % 12  == 0){
                total = parseFloat(total_amount / period).toFixed(2)
            }
            else{
                total = parseFloat(total_amount / (period + 1)).toFixed(2);
            } 
        }
        $(".amount").val(total);
        $(".total").val();
    }
    $(".sch").find('input').on('change', function(){
        get_payment_method();
    })
    <?php 
    if(session('level') >= 2){
    ?>
    // Send Link to Client
    function send_link(id){
        KTApp.blockPage();
        $.ajax({
            url : "/send-link/"+id,
            type : "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : function(res){
                KTApp.unblockPage();
                if(res == "success"){
                    location.href="/manage-campaign";
                }
                else{
                    toastr.error(res);
                }
            },
            error : function(res){
                KTApp.unblockPage();
                toastr.error("Please refresh your browser");
            }
        })
    }
    <?php }?>
    function update_days(){
        var days = '';
        $("#days").find('input').each(function(){
            if($(this).prop('checked') == true){
                days += $(this).val() + ", ";
            }
            $("#selected_days").val(days);
        })
    }
    function update_signs(){
        var selected_signs = '';
        $("#sign_div").find('.signs').each(function(){
            if($(this).prop('checked') == true){
                selected_signs += $(this).parent().parent().parent().find('.sign_name').text().trim() + ", ";
            }
            $("#selected_signs").val(selected_signs);
            $("#selected_sign_name").text(selected_signs);
        })
    }
    var coupon_num = "";
    $(document).ready(function(){
        // Days
        update_days()
        $("#days").find('input').each(function(){
            $(this).change(function(){
                update_days();
            })
        })
        // Get Location
        <?php
        if(session('level') >= 2){
        ?>
            $(".business_name").on('change', function(event){
                event.preventDefault();
                $('.top-business').text($(this).val());
                get_locations($(this).val())
            })
        <?php
        }
        else{
        ?>
            get_locations("<?php echo session('business_name')?>");
        <?php }?>
        // Get Location By Name
        function get_locations(location){
            if(location == ""){
                return;
            }
            KTApp.blockPage();
            $.ajax({
                url : '/getLocationBusiness',
                type : "POST",
                data : {
                    name : location
                },
                headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
                success : function(res){
                    KTApp.unblockPage();
                    if(res['success'] == true){
                        $("#sign_div")[0].innerHTML = "";
                        $("#sign_div").append(res['locations']);
                        $('[data-toggle="tooltip"]').tooltip()
                        // Footer Button
                        // $(".footer-button")[0].innerHTML = "";
                        // $(".footer-button").append(res['footer']);
                        // Payment method
                        $(".p-method .radio").each(function(){
                            $($(".p-method .radio")[0]).find('input').click();
                            $(this).css('display', "inline-block");
                        })
                        var p_method = res['p_method'];
                        p_meth = res['p_method'];
                        if($.inArray("2", p_method) === -1){  // No Credit
                            $($(".p-method .radio")[0]).css('display', 'none');
                            $($(".p-method .radio")[1]).find('input').click();
                        }
                        if($.inArray("1", p_method) === -1){  // No Invoice
                            $($(".p-method .radio")[1]).css('display', 'none');
                            $($(".p-method .radio")[0]).find('input').click();
                        }
                        // Preview 
                        $(".pre_img").each(function(){
                            $(this).click(function(){
                                $("#pre_img").attr("src", $(this).data('img'));
                                $(".btn-preview").click();
                            })
                        })
                        get_price();
                        $(".signs, .days, .slot, .num_weeks").on("change", function(){
                            get_price();
                        })
                        $(".save-draft").on('click', function(){
                            save_camp(3);
                        })
                        $(".set_contract").on("click", function(){
                            save_camp(4);
                        })
                        // Coupon
                        if(res['coupon_num'] != ''){
                            $(".coupon-label").text("#" + res['coupon_dis'] + " Coupon");
                            $(".coupon_number").val(0);
                            $(".coupon").css('display', "table-row");
                            $(".coupon_num").val(res['coupon_num']);
                        }
                        else{
                            $(".coupon_num").val("");
                            $(".coupon-label").text("Coupon");
                            $(".coupon_number").val(0);
                            $(".coupon").css('display', "none");
                        }
                        change_sch();
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
        }
        display_total();
        change_sch();
        $(".input-mask").inputmask({reverse: true});
        $(".num_weeks").on('change', function(){
            $("#dis_week").val($(this).val());
            change_sch();
            display_total();
        })
        // Submit
        $("#kt_form").submit(function(event){
            event.preventDefault();
            save_camp(0);
        })
        $("#btn_save").on('click', function(){
            save_camp(0);
        })
        $(".set_contract").on("click", function(){
            save_camp(4);
        })
        $("#btn_submit").on('click', function(){
            save_camp(0);
        })
        function save_camp(flag){
            // event.preventDefault();
            var fs = new FormData(document.getElementById("kt_form"));
            fs.append('camp_end',$(".camp_end").val());
            // Days
            var days = [];
            $("#days").find('input').each(function(){
                if($(this).prop('checked') == true){
                    days.push($(this).val());
                }
            })
            if(days.length == 0){
                toastr.error("Please select at least one day");
                return;
            }
            fs.append('days', days);
            // end of days
            // payment Method
            var pay_method = 0;
            $(".p-method input").each(function(){
                pay_method = $(this).prop('checked')==true?$(this).val():'';
                $(this).prop('checked')==true?fs.append('pay_method', $(this).val()):''
            })
            $(".sch input").each(function(){
                $(this).prop('checked')==true?fs.append('sch', $(this).val()):''
            })
            fs.append('part_amount', $("#part_amount").val());
            // Signs
            var locations = [];
            var slots = [];
            var price = [];
            var sub_total = [];
            $("#sign_div").find("tr").each(function(){
                $(this).find('.signs').each(function(){
                    if($(this).prop('checked') == true){
                        locations.push($(this).parent().parent().parent().find('.sign_name').data('id'))
                        slots.push($(this).parent().parent().parent().find('.slot').val())
                        price.push($(this).parent().parent().parent().find('.price').text())
                        sub_total.push($(this).parent().parent().parent().find('.sub_total').text())
                    }
                })
            })
            if(locations.length == 0){
                toastr.error("Please select at least one sign");
                return;
            }
            fs.append('locations', locations);
            fs.append('slots', slots);
            fs.append('price', price);
            fs.append('sub_total', sub_total);
            fs.append('total', $("#total_amount").val());
            fs.append('business_name', $("#business_name").val());
            // Coupon
            fs.append('coupon', $(".coupon_num").val());
            fs.append('coupon_amount', $(".coupon_number").val());
            <?php
            if(session('level')<2){
            ?>
                fs.append('business_name', "<?php echo session('business_name')?>");
            <?php }?>
            // end of signs
            fs.append('status', flag)

            KTApp.blockPage();
            $.ajax({
                url : '/save-user-camp',
                type : "POST",
                data : fs,
                headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
                processData : false,
                contentType : false,
                success : function(response){
                    KTApp.unblockPage();
                    if (typeof response !== 'object' && response.startsWith('0')) {
                        response = response.substring(1);
                    }
                    
                    let res;
                    typeof response === 'object' ? res = JSON.parse(response) : res = response;

                    if (res['success'] == true) {
                        <?php
                            if(session('level') >= 2){
                        ?>
                        if (pay_method == 0) {
                            Swal.fire({
                                title: "Send Payment Link to Client?",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonText: "Yes, send it!"
                            }).then(function(result) {
                                if (result.value) {
                                    send_link(res['id']);
                                }
                                else {
                                    location.href = "/invoice-campaign/"+res['id'];
                                }
                            });
                        }
                        else {
                            location.href = "/invoice-campaign/"+res['id'];
                        }
                        <?php }
                        else {
                        ?>
                        if (pay_method == 0) {
                            location.href = "/invoice-campaign/"+res['id']+'?payment=true';
                        }
                        else {
                            location.href = "/invoice-campaign/"+res['id'];
                        }
                        <?php }?>
                    }
                    else {
                        toastr.error(res);
                    }
                },
                error : function(err){
                    KTApp.unblockPage();
                    toastr.error('Please refesh your browser');
                }
            })
        }
        // $("#no_end").on('change', function(){
        //     $(this).prop('checked') == true? $("#no_end_div").css('display', "none") : $("#no_end_div").css('display', "flex");
        // })
        $('[data-toggle="popover"]').popover();
        function clear_price(){
            $(".price, .sub_total").each(function(){
                $(this).text("$ 0");
            })
            $("#dis_sub").val("$ 0");
            $("#dis_dis").val("$ 0");
            $("#dis_total").val("$ 0");
        }
        function get_price(){
            var days = [];
            var signs = [];
            var slots = [];
            update_signs();
            $("#days").find('input').each(function(){
                if($(this).prop('checked') == true){
                    days.push($(this).val());
                }
            })
            // if(days.length == 0){
            //     clear_price();
            //     toastr.error("Please select at least one day");
            //     return;
            // }
            $(".signs").each(function(){
                if($(this).prop('checked') == true){
                    signs.push($(this).parent().parent().parent().find('.sign_name').data('id'));
                    slots.push($(this).parent().parent().parent().find('.slot').val());
                }
            })
            // if(signs.length == 0){
            //     clear_price();
            //     toastr.error("Please select at least one sign");
            //     return;
            // }
            <?php
            if(session('level') < 2){
            ?>
            var business_name = "<?php echo session('business_name')?>";
            <?php }
            else{
            ?>
            var business_name = $("#business_name").val();
            <?php }?>
            KTApp.blockPage();
            $.ajax({
                url : "/get_price",
                type : "POST",
                data : {
                    days : days,
                    signs : signs,
                    slots : slots,
                    weeks : $(".num_weeks").val(),
                    business_name : business_name,
                    coupon_num : $(".coupon_num").val(),
                },
                success : function(result){
                    KTApp.unblockPage();
                    if(result['status'] == 'success'){
                        res = result['sub_total'];
                        var def = result['default'];
                        var i = 0;
                        $("#sign_div").find('tr').each(function(){
                            if($(this).find('.signs').prop('checked') == false){
                                $(this).find('.price').text("$ 0");
                                $(this).find('.sub_total').text("$ 0");
                            }
                            else{
                                $(this).find('.price').text("$ "+def[i]);
                                $(this).find('.sub_total').text("$ "+res[i]);
                                i++;
                            }
                        })
                        // Sub Av
                        for(var i = 0; i < result['sub'].length; i++){
                            var s_id = result['sub'][i]['id']
                            var s_num = result['sub'][i]['num']
                            $(".slot").each(function(){
                                if($(this).data('id')==s_id){
                                    var length = $(this).find('option').length;
                                    var cur_len = $(this).data('init');
                                    if(length >= cur_len + s_num)
                                        return false;
                                    var html = "";
                                    for(var i = 0; i < s_num; i++ ){
                                        var temp = cur_len + i + 1;
                                        html += "<option value='"+temp+"'>"+temp+"</option>";
                                    }
                                    $(this).append(html)
                                }
                            })
                        }
                        $(".coupon_number").val(result['coupon']);
                        display_total();
                    }
                    // else{
                    //     toastr.error(result);
                    // }
                },
                error :  function(err){
                    KTApp.unblockPage();
                    toastr.error("Please refresh your browser");
                }
            })
        }
        // Get End Date by Number of weeks
        $(".num_weeks, .camp_start").on('change', function(){
            var start = $(".camp_start").val();
            var num_weeks = $(".num_weeks").val();
            $.ajax({
                url : '/get_end',
                type : "POST",
                data : {
                    start : start,
                    weeks : num_weeks,
                },
                success : function(res){
                    $(".camp_end").val(res);
                },
                error : function(err){

                }
            })
        })
    })
</script>
