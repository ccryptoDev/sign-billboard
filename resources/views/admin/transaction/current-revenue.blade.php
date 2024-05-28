@include('admin.include.admin-header')
<link href="/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
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
    <div class="subheader py-2 py-lg-12  subheader-transparent" id="kt_subheader"
        style="padding-bottom : 0px !important">
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
                            <?php
                                if($selected_id == $val->id){
                                    $user_name = $val->user_name;
                                }
                            ?>
                            @if($val->user_lock == 0)
                                <option value="{{$val->id}}" <?php echo $selected_id==$val->id?'selected':''?>>{{$val->user_name}} - {{$val->level==3?"Franchise":"AM"}}</option>
                            @endif
                        @endforeach
                    </select>
                @endif
            </div>
            <?php
                $today = date("Y-m-d");
                // Last payment
                $last_amount = 0;
                $last_date = "";
                $paid_ids = [];
                $com_rate = 0;
                // on hold
                // $total_hold = 0;
                $user_level = session('level');
                if(isset($user['id']) && $selected_id != ''){
                    $user_level = $user->level;
                }
                if($user_level ==2 && isset($revenue->inex)){
                    $com_rate = $revenue->inex;
                }
                if($user_level ==3 && isset($revenue->franch)){
                    $com_rate = $revenue->franch;
                }
                if($user_level ==4 && isset($revenue->account)){
                    $com_rate = $revenue->account;
                }
            ?>
            @foreach($transfers as $key => $val)
                @if($key === 0)
                    <?php
                        $last_amount = $val->amount;
                        $last_date = date_create($val->created_at);
                        $last_date = " (".date_format($last_date, "m-d-Y h:i:s a").")";
                    ?>
                @endif
            @endforeach
            @foreach($checkout as $key => $val)
                <?php
                    $paid_ids[] = $val->invoice_id;
                ?>
            @endforeach
            @foreach($invoices as $key => $val)
                @if($val->status != 1 && $val->end_date >= $today)
                    <?php 
                        // $total_hold += $val->part_amount * $com_rate / 100;
                    ?>
                @endif
            @endforeach
            <?php
                $total_hold = $total_hold;
                $status = 'danger';
                $label = 'Not Verified';
                print_r($account);
                if(isset($account->id)){
                    if($account->payouts_enabled == true){
                        $status = 'success';
                        $label = 'Verified';
                    }
                    else{
                        $status = 'warning';
                        $label = 'Under Review';
                    }
                }
            ?>
            <div class="col-xl-4">
                <div class="card card-custom bg-light-success card-stretch gutter-b">
                    <div class="card-body">
                        <span class="svg-icon svg-icon-2x svg-icon-success">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <rect fill="#000000" opacity="0.3" x="11.5" y="2" width="2" height="4" rx="1" />
                                    <rect fill="#000000" opacity="0.3" x="11.5" y="16" width="2" height="5" rx="1" />
                                    <path
                                        d="M15.493,8.044 C15.2143319,7.68933156 14.8501689,7.40750104 14.4005,7.1985 C13.9508311,6.98949895 13.5170021,6.885 13.099,6.885 C12.8836656,6.885 12.6651678,6.90399981 12.4435,6.942 C12.2218322,6.98000019 12.0223342,7.05283279 11.845,7.1605 C11.6676658,7.2681672 11.5188339,7.40749914 11.3985,7.5785 C11.2781661,7.74950085 11.218,7.96799867 11.218,8.234 C11.218,8.46200114 11.2654995,8.65199924 11.3605,8.804 C11.4555005,8.95600076 11.5948324,9.08899943 11.7785,9.203 C11.9621676,9.31700057 12.1806654,9.42149952 12.434,9.5165 C12.6873346,9.61150047 12.9723317,9.70966616 13.289,9.811 C13.7450023,9.96300076 14.2199975,10.1308324 14.714,10.3145 C15.2080025,10.4981676 15.6576646,10.7419985 16.063,11.046 C16.4683354,11.3500015 16.8039987,11.7268311 17.07,12.1765 C17.3360013,12.6261689 17.469,13.1866633 17.469,13.858 C17.469,14.6306705 17.3265014,15.2988305 17.0415,15.8625 C16.7564986,16.4261695 16.3733357,16.8916648 15.892,17.259 C15.4106643,17.6263352 14.8596698,17.8986658 14.239,18.076 C13.6183302,18.2533342 12.97867,18.342 12.32,18.342 C11.3573285,18.342 10.4263378,18.1741683 9.527,17.8385 C8.62766217,17.5028317 7.88033631,17.0246698 7.285,16.404 L9.413,14.238 C9.74233498,14.6433354 10.176164,14.9821653 10.7145,15.2545 C11.252836,15.5268347 11.7879973,15.663 12.32,15.663 C12.5606679,15.663 12.7949989,15.6376669 13.023,15.587 C13.2510011,15.5363331 13.4504991,15.4540006 13.6215,15.34 C13.7925009,15.2259994 13.9286662,15.0740009 14.03,14.884 C14.1313338,14.693999 14.182,14.4660013 14.182,14.2 C14.182,13.9466654 14.1186673,13.7313342 13.992,13.554 C13.8653327,13.3766658 13.6848345,13.2151674 13.4505,13.0695 C13.2161655,12.9238326 12.9248351,12.7908339 12.5765,12.6705 C12.2281649,12.5501661 11.8323355,12.420334 11.389,12.281 C10.9583312,12.141666 10.5371687,11.9770009 10.1255,11.787 C9.71383127,11.596999 9.34650161,11.3531682 9.0235,11.0555 C8.70049838,10.7578318 8.44083431,10.3968355 8.2445,9.9725 C8.04816568,9.54816454 7.95,9.03200304 7.95,8.424 C7.95,7.67666293 8.10199848,7.03700266 8.406,6.505 C8.71000152,5.97299734 9.10899753,5.53600171 9.603,5.194 C10.0970025,4.85199829 10.6543302,4.60183412 11.275,4.4435 C11.8956698,4.28516587 12.5226635,4.206 13.156,4.206 C13.9160038,4.206 14.6918294,4.34533194 15.4835,4.624 C16.2751706,4.90266806 16.9686637,5.31433061 17.564,5.859 L15.493,8.044 Z"
                                        fill="#000000" />
                                </g>
                            </svg>
                        </span>
                        <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">
                            ${{number_format($last_amount, 2)}} {{$last_date}}
                        </span>
                        <span class="font-weight-bold text-muted  font-size-sm">Last Payment</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card card-custom bg-light-danger card-stretch gutter-b">
                    <div class="card-body">
                        <span class="svg-icon svg-icon-2x svg-icon-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                    <path
                                        d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                        fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                    <path
                                        d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                        fill="#000000" fill-rule="nonzero"></path>
                                </g>
                            </svg>
                        </span>
                        <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">${{number_format($total, 2)}} 
                            @if($selected_id == '')
                                <button class="btn btn-success" style="float:right" id="transfer" <?php echo $status == 'success'?'':'disabled'?> 
                                    title="<?php echo $status != 'success'?'Fund transfer is not available until your account is no longer Under Review (see your status below)':''?>">Transfer Funds to my Bank</button>
                            @endif
                            @if(session('level') == 2 && $selected_id != '')
                                <button class="btn btn-success" style="float:right" id="transfer_users" <?php echo $status == 'success'?'':'disabled'?> 
                                    title="<?php echo $status != 'success'?'Fund transfer is not available until your account is no longer Under Review (see your status below)':''?>">Transfer Funds to my Bank</button>
                            @endif
                        </span>
                        <span class="font-weight-bold text-muted font-size-sm">Total Revenue - Available</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card card-custom bg-light-info card-stretch gutter-b">
                    <div class="card-body">
                        <span class="svg-icon svg-icon-2x svg-icon-info">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"></rect>
                                    <rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5">
                                    </rect>
                                    <rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5"></rect>
                                    <rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5"></rect>
                                    <rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5"></rect>
                                </g>
                            </svg>
                        </span>
                        <span
                            class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">${{number_format($total_hold, 2)}}</span>
                        <span class="font-weight-bold text-muted  font-size-sm">Total Revenue - On Hold</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom" data-card="true" id="kt_card_1">
                        <div class="card-header card-header-tabs-line">
                            <div class="card-title">
                                <h3 class="card-label">{{$page_name}} {{$user_name == '' ? '' : ' - ' .$user_name}}</h3>
                            </div>
                            <div class="card-toolbar">
                                <div class="d-flex align-items-center mr-5">
                                    <span class="bullet bullet-bar bg-{{$status}} align-self-stretch mr-2"></span>
                                    <div class="d-flex flex-column flex-grow-1">
                                        <a class="text-dark-75 text-hover-primary font-weight-bold font-size-lg">
                                            {{$label}}
                                        </a>
                                    </div>
                                </div>
                                <ul class="nav nav-tabs nav-bold nav-tabs-line">
                                    <li class="nav-item">
                                        <a class="nav-link" href="/transaction-records">
                                            <span class="nav-icon"><i class="far fa-chart-bar text-dark"></i></span>
                                            <span class="nav-text text-dark">Transaction Records</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/transfer-history/{{$selected_id}}">
                                            <span class="nav-icon"><i class="far fa-list-alt text-dark"></i></span>
                                            <span class="nav-text text-dark">Transfer History</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-5">
                                @if(session('level') > 2)
                                <div class="col-md-12">
                                    <!-- <button class="btn btn-success" id="transfer">Transfer Funds to my Bank</button> -->
                                </div>
                                @endif
                            </div>
                            <table class="table table-bordered table-hover table-checkable" id="kt_datatable">
                                <thead>
                                    <tr>
                                        <th>Business</th>
                                        <th>Invoice #</th>
                                        <th>Payment Plan</th>
                                        <th>Payment Period Started</th>
                                        <th>Payment Period Ended</th>
                                        <th>Location</th>
                                        <th>Transaction</th>
                                        <th>Coupon Used</th>
                                        <th>Commission</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <?php
                                    $plan = ['In Full', 'Weekly', '4 Weeks', '12 weeks'];
                                    $plan_nums = [0, 1, 4, 12];
                                ?>
                                <tbody>
                                @foreach($invoices as $key => $val)
                                    <?php
                                        $start_date = date_create($val->start_date);
                                        $end_date = date_create($val->end_date);
                                        if($val->campaign_id == 0){
                                            $extra = json_decode($val->description, true);
                                            $start_date = date_create($extra['due']);
                                            $end_date = date_create($extra['due']);
                                        }
                                        $start_date = "";
                                        $end_date = "";
                                        $dis_end_date = "";
                                        foreach($checkout as $check){
                                            if($check->invoice_id == $val->id){
                                                if($start_date == ""){
                                                    $start_date = $check->created_at;
                                                    $start_date = date_format($start_date, "m-d-Y");
                                                    $end_date = date_create($val->invoice_date);
                                                    $dis_end_date = date_format($end_date, "Y-m-d");
                                                    $end_date = date_format($end_date, "m-d-Y");
                                                }
                                            }
                                        }
                                        if($val->sub_id){
                                            $start_date = date_create($val->sub_date);
                                            $start_date = date_format($start_date, "m-d-Y");
                                            if($val->sch != 0){
                                                $diff_days = $plan_nums[$val->sch] * 7 - 1;
                                                $dis_end_date = date('Y-m-d', strtotime('+'.$diff_days.' days', strtotime($val->sub_date)));
                                                $end_date = date('m-d-Y', strtotime('+'.$diff_days.' days', strtotime($val->sub_date)));                                                        
                                            } else {
                                              $diff_days = $val->weeks * 7 - 1;
                                              $dis_end_date = date('Y-m-d', strtotime('+'.$diff_days.' days', strtotime($val->sub_date)));
                                              $end_date = date('m-d-Y', strtotime('+'.$diff_days.' days', strtotime($val->sub_date)));  
                                            }
                                        }
                                    ?>
                                    @if((($val->status == 0 && $val->paid != 0 ) || $val->status == 1) && $val->sub_id != null && $dis_end_date < $today)
                                        <tr>
                                            <td>{{$val->business_name}}</td>
                                            <td>#{{$val->sub_id?11000 + $val->sub_id : $val->id}}</td>
                                            <td>{{isset($plan[$val->sch])?$plan[$val->sch]:''}}</td>
                                            <td>
                                                {{$start_date}}
                                            </td>
                                            <td>
                                                {{$end_date}}
                                            </td>
                                            <?php
                                            $data = json_decode($val->data, true);
                                            $locations = "";
                                            $sub_total = 0;
                                            $coupon_amount = 0;

                                            $weeks = $val['weeks'];
                                            if($val->status != 1){
                                                $weeks = $val['paid'];
                                            }
                                            if($val->sch != 0){
                                                $weeks = $plan_nums[$val->sch];
                                            }
                                            foreach($data as $temp){
                                                $locations .= isset($temp['location_name'])?$temp['location_name'].',':''.',';
                                            }
                                            // if($val->campaign_id == 0){
                                                $sub_total = $val->part_amount;
                                            // }
                                            // else{
                                            //     foreach($data as $temp){
                                            //         $sub_total += $temp['sub_total'] * $weeks;
                                            //     }
                                            // }
                                            // if($val->coupon_amount != null){
                                            //     $coupon_amount = $val->coupon_amount * $weeks;
                                            // }
                                            $sub_total = $sub_total - $coupon_amount;
                                            ?>
                                            <td>{{$locations}}</td>
                                            <td>
                                                ${{number_format($sub_total,2)}}
                                            </td>
                                            <td>
                                                ${{$val->coupon_amount!=null?number_format($val->coupon_amount, 2):0}}
                                            </td>
                                            <td>
                                                ${{number_format($sub_total * $com_rate / 100, 2)}}
                                            </td>
                                            <td>
                                                <?php
                                                    $avaialbe = 0;
                                                    if($user_level == 2){
                                                        $avaialbe = $val->transfer_inex;
                                                    }
                                                    else if($user_level == 3){
                                                        $avaialbe = $val->transfer_fr;
                                                    }
                                                    else{
                                                        $avaialbe = $val->transfer;
                                                    }
                                                    $type = $user_level - 2;
                                                    if(session('level') == 2){
                                                        echo $avaialbe==0?'<span class="label label-xl label-primary label-inline mr-2 status" onclick="change_status(`'.$val->sub_id.'`, `'.$type.'`)">Available</span>':
                                                        '<span class="label label-xl label-danger label-inline mr-2 status" onclick="change_status(`'.$val->sub_id.'`, `'.$type.'`)">Paid</span>';
                                                    }
                                                    else{
                                                        echo $avaialbe==0?'<span class="label label-xl label-primary label-inline mr-2 status">Available</span>':
                                                        '<span class="label label-xl label-danger label-inline mr-2 status">Paid</span>';
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                    @endif
                                    @if( (($val->status == 0 || $val->status == 1) && $dis_end_date >= $today) ||  ($val->sub_id == null && $val->status == 0 && $val->paid != 0 && $dis_end_date < $today) ) 
                                    {{-- @if( ($val->status == 0 || $val->status == 1) && ($dis_end_date >= $today) ) --}}
                                        <tr>
                                            <td>{{$val->business_name}}</td>
                                            <td>#{{$val->sub_id?11000 + $val->sub_id : $val->id}}</td>
                                            <td>{{isset($plan[$val->sch])?$plan[$val->sch]:''}}</td>
                                            <td>
                                                {{$start_date}}
                                            </td>
                                            <td>
                                                {{$end_date}}
                                            </td>
                                            <?php
                                            $data = json_decode($val->data, true);
                                            $locations = "";
                                            $sub_total = 0;
                                            $coupon_amount = 0;

                                            $weeks = $val['weeks'];
                                            if($val->status != 1){
                                                $weeks = $val['paid'];
                                            }
                                            if($val->sch != 0){
                                                $weeks = $plan_nums[$val->sch];
                                            }
                                            foreach($data as $temp){
                                                $locations .= isset($temp['location_name'])?$temp['location_name']:''.',';
                                            }
                                            $sub_total = $val->part_amount;
                                            $sub_total = $sub_total - $coupon_amount;
                                            ?>
                                            <td>{{$locations}}</td>
                                            <td>
                                                ${{number_format($sub_total,2)}}
                                            </td>
                                            <td>
                                                ${{$val->coupon_amount!=null?number_format($val->coupon_amount, 2):0}}
                                            </td>
                                            <td>
                                                ${{number_format($sub_total * $com_rate / 100, 2)}}
                                            </td>
                                            <td>
                                                <?php
                                                    $avaialbe = 0;
                                                    if($user_level == 2){
                                                        $avaialbe = $val->transfer_inex;
                                                    }
                                                    else if($user_level == 3){
                                                        $avaialbe = $val->transfer_fr;
                                                    }
                                                    else{
                                                        $avaialbe = $val->transfer;
                                                    }
                                                    
                                                    if($dis_end_date >= $today) {
                                                        echo '<span class="label label-xl label-warning label-inline mr-2 status">On Hold</span>';
                                                    } 
                                                    else if ($val->sub_id == null && $val->status == 0 && $val->paid != 0 && $dis_end_date < $today) {
                                                        $type = $user_level - 2;
                                                        if(session('level') == 2){
                                                            echo $avaialbe==0?'<span class="label label-xl label-primary label-inline mr-2 status" onclick="change_status(`'.$val->sub_id.'`, `'.$type.'`)">Available</span>':
                                                            '<span class="label label-xl label-danger label-inline mr-2 status" onclick="change_status(`'.$val->sub_id.'`, `'.$type.'`)">Paid</span>';
                                                        }
                                                        else{
                                                            echo $avaialbe==0?'<span class="label label-xl label-primary label-inline mr-2 status">Available</span>':
                                                            '<span class="label label-xl label-danger label-inline mr-2 status">Paid</span>';
                                                        }
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                    @endif
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

<script>
var HOST_URL = "https://keenthemes.com/metronic/tools/preview";
</script>
<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
<script src="/assets/plugins/global/plugins.bundle.js"></script>
<script src="/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
<script src="/js/suggest.js"></script>
<script src="/assets/js/scripts.bundle.js"></script>
<script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="/assets/js/export-table.js"></script>
<script>

    <?php
        if(session('level') == 2){
    ?>
        $("#user").on('change', function(){
            location.href="/current-revenue/"+$("#user").val()
        })
        // Trasnfer Funds of AM/Franchise
        $("#transfer_users").on('click', function(){
            transfer_funds("<?php echo $selected_id?>")
        })
        function transfer_funds(user_id){
            KTApp.blockPage();
            $.ajax({
                url: '/transfer_users',
                type: "POST",
                data: {
                    user_id : user_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    KTApp.unblockPage();
                    if (res['success'] == true) {
                      location.href = res['url'];
                        // location.href="/transaction-records";
                        toastr.success('Success');
                    } else {
                        toastr.error(res);
                    }
                },
                error: function(err) {
                    KTApp.unblockPage();
                    toastr.error("Please refresh your browser");
                }
            })
        }
        function get_revenue(){
            $.ajax({
                url : "/current-revenue",
                type : "GET",
                data : {
                    id : $("#user").val()
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success : function(res){
                    console.log(res)
                }
            })
        }
        function change_status(id, type){
            Swal.fire({
                title: "Are you sure?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, change it!"
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url : "/change_sub_status",
                        type : "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data : {
                            id : id,
                            type : type,
                        },
                        success : function(res){
                            if(res == 'success'){
                                toastr.success("Success");
                                location.reload();
                            }
                            else{
                                toastr.error(res);
                            }
                        }
                    })
                }
            });
        }
    <?php }?>
    $(document).ready(function() {
        $("#transfer").click(function(event) {
            KTApp.blockPage();
            $.ajax({
                url: '/transfer',
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    KTApp.unblockPage();
                    if (res['success'] == true) {
                      location.href = res['url'];
                      toastr.success('Success');
                    } else {
                        toastr.error(res);
                    }
                },
                error: function(err) {
                    KTApp.unblockPage();
                    toastr.error("Please refresh your browser");
                }
            })
        })
    })
</script>