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
        </div>
    </div>
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom" data-card="true" id="kt_card_1">
                        <div class="card-header card-header-tabs-line">
                            <div class="card-title">
                                <h3 class="card-label">{{$page_name}} - {{isset($user['id']) ? $user->user_name : session('user_name')}}</h3>
                            </div>
                            <?php 
                                $date = date_create($transfer->created_at);
                                $created_at = date_format($date, "m-d-Y");
                            ?>
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
                            <h1>{{$created_at}} ${{number_format($transfer->amount, 2)}}</h1>
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
                                    ?>
                                    @if((($val->status == 0 && $val->paid != 0 ) || $val->status == 1) && $val->sub_id != null && $dis_end_date < $today && $avaialbe != 0)
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