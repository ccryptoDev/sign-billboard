@include('admin.include.admin-header')
<style>
    .price {
        color : red;
    }
</style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader min-h-lg-15px pt-5 pb-7 subheader-transparent" id="kt_subheader">
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
                @include('admin.campaign.header')
            </div>
            <?php
                $inv_status = strtotime($campaign->start_date) <= strtotime(date('Y-m-d'))&&$invoice->paid!=0?1:0;
                $inv_status = strtotime($campaign->start_date) <= strtotime(date('Y-m-d'))&&$invoice->status!=0?1:0;
                $change_inv = 0;
                if($campaign->free_plan != 0){
                    $change_inv = 1;
                }
                // if(strtotime($invoice->invoice_date) >= strtotime(date('Y-m-d'))){
                    // $change_inv = 1;
                // }
            ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom" data-card="true" id="kt_card_1">
                        <div class="card-header ribbon ribbon-top ribbon-ver">
                            <div class="card-title">
                                <h3 class="card-label">{{$inv_status==0&&$change_inv==0?$page_name:"View Campaign"}} - {{$business_name}}</h3>
                            </div>
                        </div>
                        <form id="frmCreate">
                            <div class="card-body">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-1"></div>
                                    <div class="col-xl-9 my-2">
                                        @if (Session::has('success'))
                                            <div class="alert alert-success">
                                                <span>Success</span>
                                            </div>
                                        @endif
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </div>
                                        @endif
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-3 text-lg-right text-left">Campaign Name
                                                <i class="far fa-question-circle text-danger" 
                                                    data-toggle="popover" data-trigger="hover" title="Campaign Name"
                                                    data-content="You can have as many Campaigns as you wish.  Give each Campaign you create a unique name."
                                                ></i>
                                            </label>
                                            <div class="col-md-9">
                                                <input class="form-control form-control-lg form-control-solid" type="text" value="{{$campaign->campaign_name?$campaign->campaign_name:''}}" name="camp_name" required/>
                                                <?php
                                                    $payment_method = json_decode($p_method->payment_method, true);
                                                ?>
                                                @if(in_array('0', $payment_method))
                                                    <input name="pay_method" value="2" type="hidden">
                                                    <input name="sch" value="0" type="hidden">
                                                    <input name="status" value="1" type="hidden">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-3 text-lg-right text-left">Campaign Start Date
                                                <i class="far fa-question-circle text-danger" 
                                                    data-toggle="popover" data-trigger="hover" title="Campaign Start Date"
                                                    data-content="Regardless of when you upload your Ads or Publish them, the Campaign Manager Start Date controls WHEN those ads and playlists get delivered to the signs. You cannot modify the Start Date once a Campaign has started. "
                                                ></i>
                                            </label>
                                            <div class="col-md-3">
                                                <input class="form-control form-control-lg form-control-solid camp_start"
                                                    {{$inv_status==1?'disabled':''}} 
                                                    type="date" min="{{date('Y-m-d')}}" value="{{$campaign->start_date?$campaign->start_date:''}}" name="camp_start" required/>
                                            </div>
                                        </div>
                                        <div class="form-group row" id="no_end_div">
                                            <label class="col-form-label col-md-3 text-lg-right text-left">Number of Weeks
                                                <i class="far fa-question-circle text-danger" 
                                                    data-toggle="popover" data-trigger="hover" title="Number of Weeks"
                                                    data-content="The minimum Campaign length is one week. The maximum campaign length is 52 weeks (1 year)"
                                                ></i>
                                            </label>
                                            <div class="col-md-3 mb-5">
                                                <input class="form-control form-control-lg form-control-solid num_weeks" 
                                                    {{$inv_status==1?'disabled':''}} 
                                                    name="num_weeks" type="number" min="0" max="52" value="{{$campaign->end_flag==0?$campaign->weeks:1}}" required/>
                                            </div>
                                            <label class="col-form-label col-md-3 text-lg-right text-left">Campaign End Date</label>
                                            <div class="col-md-3">
                                                <input class="form-control form-control-lg form-control-solid camp_end" disabled name="camp_end" type="date" min='{{date("Y-m-d", strtotime("+6 days"))}}' value='{{$campaign->end_flag==0?$campaign->end_date:date("Y-m-d",strtotime("+6 days", strtotime($campaign->start_date)))}}' name="camp_end" required/>
                                            </div>
                                        </div>
                                        <?php
                                            $days = explode(",", $campaign->days);
                                            $signs = explode(",", $campaign->locations);
                                            $prices = explode(",", $campaign->price);
                                            $sub = explode(',', $campaign->sub_total);
                                            $slots = explode(',', $campaign->slots);
                                        ?>
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-3 text-lg-right text-left">Days of the Week
                                                <i class="far fa-question-circle text-danger" 
                                                    data-toggle="popover" data-trigger="hover" title="Days of the Week"
                                                    data-content="Normally your ads are displayed seven days a week.  If you want all your Ads only displayed on specific days, deselect the days you do NOT want your ads shown."
                                                ></i>
                                            </label>
                                            <div class="col-md-9">
                                                <div class="checkbox-inline" id="days">
                                                    <label class="checkbox checkbox-primary">
                                                        <input type="checkbox" {{in_array('Mon', $days)?'checked':''}} 
                                                            {{$inv_status==1?'disabled':''}} 
                                                            class="days" value="Mon"> M
                                                        <span></span>
                                                    </label>
                                                    <label class="checkbox checkbox-primary">
                                                        <input type="checkbox" {{in_array('Tue', $days)?'checked':''}} 
                                                            {{$inv_status==1?'disabled':''}} 
                                                            class="days" value="Tue"> T
                                                        <span></span>
                                                    </label>
                                                    <label class="checkbox checkbox-primary">
                                                        <input type="checkbox" 
                                                            {{$inv_status==1?'disabled':''}} 
                                                            {{in_array('Wed', $days)?'checked':''}} class="days" value="Wed"> W
                                                        <span></span>
                                                    </label>
                                                    <label class="checkbox checkbox-primary">
                                                        <input type="checkbox" {{in_array('Thu', $days)?'checked':''}}
                                                            {{$inv_status==1?'disabled':''}} 
                                                            class="days" value="Thu"> T
                                                        <span></span>
                                                    </label>
                                                    <label class="checkbox checkbox-primary">
                                                        <input type="checkbox" {{in_array('Fri', $days)?'checked':''}} 
                                                            {{$inv_status==1?'disabled':''}} 
                                                            class="days" value="Fri"> F
                                                        <span></span>
                                                    </label>
                                                    <label class="checkbox checkbox-primary">
                                                        <input type="checkbox" {{in_array('Sat', $days)?'checked':''}} 
                                                            {{$inv_status==1?'disabled':''}} 
                                                            class="days" value="Sat"> S
                                                        <span></span>
                                                    </label>
                                                    <label class="checkbox checkbox-primary">
                                                        <input type="checkbox" {{in_array('Sun', $days)?'checked':''}} 
                                                            {{$inv_status==1?'disabled':''}} 
                                                            class="days" value="Sun"> S
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="form-group row">
                                            <label class="col-form-label col-md-3 text-lg-right text-left">Select Billboard Signs 
                                                <i class="far fa-question-circle text-danger" 
                                                    data-toggle="popover" data-trigger="hover" title="Billboard Signs"
                                                    data-content="Each billboard has a different pricing schedule based on its size and traffic (the number of people seeing the Ad)."
                                                ></i>
                                            </label>
                                        </div> -->
                                        <div class="form-group row">
                                            <div class="col-12" data-scroll="true" data-wheel-propagation="true">
                                                <table class="table table-bordered table-hover table-checkable" id="kt_datatable">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>
                                                                Sign Name
                                                            </th>
                                                            <th>Available Slots
                                                                <i class="far fa-question-circle text-danger" 
                                                                    data-toggle="popover" data-trigger="hover" title="Available Slots"
                                                                    data-content="The maximum number is dependent on inventory availability during the time period you selected"
                                                                ></i>
                                                            </th>
                                                            <th>
                                                                Standard Weekly Cost
                                                                <i class="far fa-question-circle text-danger" 
                                                                    data-toggle="popover" data-trigger="hover" title="Standard Weekly Cost"
                                                                    data-content="This price reflects the standard rate for that sign for the number of days in a week that you selected."
                                                                ></i>
                                                            </th>
                                                            <th>Discounted Cost
                                                                <i class="far fa-question-circle text-danger" 
                                                                    data-toggle="popover" data-trigger="hover" title="Discounted Cost"
                                                                    data-content="When you use more than one slot (regardless of its location), you get a discount.  The price displayed is the real price you will be charged."
                                                                ></i>
                                                            </th>
                                                            <th>Location
                                                                <i class="far fa-question-circle text-danger" 
                                                                    data-toggle="popover" data-trigger="hover" title="Location"
                                                                    data-content="Displays the sign’s location and the direction from where it can be viewed"
                                                                ></i>
                                                            </th>
                                                            <!-- <th>Picture</th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody id="sign_div">
                                                        @foreach($locations as $key => $val)
                                                            <tr>
                                                                <td>
                                                                    <label class="checkbox">
                                                                        <input type="checkbox" class="signs" 
                                                                            {{$inv_status==1?'disabled':''}} 
                                                                            {{in_array($val->location_id, $signs)?'checked':''}} name="signs"/>
                                                                        <span></span>
                                                                    </label>
                                                                </td>
                                                                <td class="sign_name" data-id="{{$val->location_id}}">{{$val->nickname}}</td>
                                                                @if(isset($ava_locations[$val->location_id]))
                                                                    @for($i = 0; $i < $ava_locations[$val->location_id]['num']; $i++)
                                                                    @endfor
                                                                @else
                                                                    @for($i = 0; $i < 12; $i++)
                                                                    @endfor
                                                                @endif
                                                                <td>
                                                                    <select class="form-control slot" data-init="{{$i}}" data-id="{{$val->location_id}}" autocomplete="off">
                                                                        @if(isset($ava_locations[$val->location_id]))
                                                                            @for($i = 0; $i < $ava_locations[$val->location_id]['num']; $i++)
                                                                                <option value="{{$i+1}}" 
                                                                                    {{$inv_status==1?'disabled':''}} 
                                                                                    {{in_array($val->location_id, $signs)&&$slots[array_search($val->location_id, $signs)]==$i+1?'selected':''}}>{{$i+1}}</option>
                                                                            @endfor
                                                                        @else
                                                                            @for($i = 0; $i < 12; $i++)
                                                                                <option value="{{$i+1}}" 
                                                                                    {{$inv_status==1?'disabled':''}} 
                                                                                    {{in_array($val->location_id, $signs)&&$slots[array_search($val->location_id, $signs)]==$i+1?'selected':''}}>{{$i+1}}</option>
                                                                            @endfor
                                                                        @endif
                                                                    </select>
                                                                </td>
                                                                <td class="input-mask price" data-inputmask-alias="currency">
                                                                    <?php
                                                                        $loc_num = 8;
                                                                        if(in_array($val->location_id, $signs) && isset($prices[array_search($val->location_id, $signs)])){
                                                                            echo "$ ".$prices[array_search($val->location_id, $signs)];
                                                                        }
                                                                        else{
                                                                            $prices = explode(",", $val->price);
                                                                            echo isset($prices[6])?$prices[6]:0;
                                                                        }
                                                                    ?>
                                                                </td>
                                                                <td class="input-mask sub_total" data-inputmask-alias="currency">
                                                                    <?php
                                                                        if(in_array($val->location_id, $signs) && $sub[array_search($val->location_id, $signs)]){
                                                                            echo "$ ".$sub[array_search($val->location_id, $signs)];
                                                                        }
                                                                        else{
                                                                            if($key == 0){
                                                                                $prices = explode(",", $val->price);
                                                                                echo isset($prices[6])?$prices[6]:0;
                                                                            }
                                                                            else{
                                                                                $discouns = explode(",", $val->discount);
                                                                                echo isset($discouns[6])?$discouns[6]:0;
                                                                            }
                                                                        }
                                                                    ?>
                                                                </td>
                                                                <td><a href="javascript:;" class="pre_img" data-img="{{'/map/'.$val->nickname.'.png'}}"><i class="fa fas fa-map-marker-alt text-info"></i></a></td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-7">
                                            </div>
                                            <div class="col-5">
                                                <table class="w-100">
                                                    <tr>
                                                        <td><strong>Weeks</strong></td>
                                                        <td>
                                                            <input id="dis_week" class="form-control text-right" value="{{$campaign->weeks}}" disabled>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Standard Weekly Charges</strong></td>
                                                        <td>
                                                            <input id="dis_sub" class="form-control input-mask" data-inputmask-alias="currency" disabled>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Discounts</strong></td>
                                                        <td>
                                                            <input id="dis_dis" class="form-control input-mask" data-inputmask-alias="currency" disabled/>
                                                        </td>
                                                    </tr>
                                                    <tr class="coupon" style="display:{{$campaign->coupon==null?'none':'table-row'}}">
                                                        <td><strong class="coupon-label"># {{$campaign->coupon}} Coupon</strong></td>
                                                        <td>
                                                            <input class="form-control text-right coupon_number input-mask" value="{{$campaign->coupon_amount}}"  data-inputmask-alias="currency" disabled/>
                                                            <input class="form-control text-right coupon_num" value="{{$campaign->coupon}}" style="display:none"/>
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
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-xl-1"></div>
                                    <div class="col-xl-9">
                                        <a class="btn btn-warning float-right ml-3" href="/manage-campaign">Cancel</a>
                                        <!-- @if($change_inv == 0)
                                        <a class="btn btn-info float-right save-draft ml-3" type="button">Save Campaign for Later</a>
                                        @endif -->
                                        @if(in_array('0', $payment_method))
                                            <button class="btn btn-danger float-right" type="submit">Save Campaign - No Charge</button>
                                        @else
                                            @if($inv_status==1 || $change_inv == 1)
                                            <button class="btn btn-danger float-right" type="button" id="change-name">Change Campaign Name</button>
                                            @else
                                            <button class="btn btn-danger float-right chose-payment" type="button">Choose Payment Method</button>
                                            @endif
                                        @endif
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
<button type="button" class="btn btn-primary btn-preview" data-toggle="modal" data-target="#preModal" style="display:none">
    Launch demo modal
</button>
<div class="modal fade" id="preModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Preview Location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <img src="" id="pre_img" height="500px" style="width:100%;max-width:100%">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<button type="button" class="btn btn-primary btn-payment" data-toggle="modal" data-target="#paymentModal" style="display:none">
    Payment Method Modal
</button>
<!-- Payment Method -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Choose payment method</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <h5>Payment Method Chosen</h5>
                <label class="text-muted">Please remember payment will be due prior to Campaign starts.</label>
                <div class="radio-inline p-method">
                    @if(in_array('2', $payment_method))
                    <label class="radio">
                        <input type="radio" checked name="method" value="0"/>
                        <span></span>
                        Credit Card
                    </label>
                    @endif
                    @if(in_array('1', $payment_method))
                    <label class="radio">
                        <input type="radio" {{in_array("2", $payment_method)?"":'checked'}} name="method" value="1"/>
                        <span></span>
                        Send Invoice
                    </label>
                    @endif
                </div>
                <div class="form-group mt-5 sch">
                    <label>Payment Schedule</label>
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
                <div class="form-group mt-5">
                    <input class="form-control input-mask amount text-left" id="part_amount" placeholder="Amount" data-inputmask-alias="currency" disabled>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger font-weight-bold" id="btn_save">Save campaign</button>
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
<script src="/js/inputmask.js"></script>
<script src="/assets/js/scripts.bundle.js"></script>
<script src="/assets/js/campaign.js"></script>
<script>
    var p_meth = [];
    <?php
    foreach($payment_method as $key => $val){
    ?>
    p_meth.push("<?php echo $val?>");
    <?php }?>
    function display_total(){
        var def = 0;
        var sub = 0;
        var coupon = change_format($(".coupon_number").val());
        $("#sign_div").find('tr').each(function(){
            if($(this).find('.signs').prop('checked') == true){
                $(this).find('.price').each(function(){
                    var temp = $(this).text().replace(/\$/g, '');
                    temp.replace(/\ /g, '');
                    def += parseFloat(temp);
                })
                $(this).find('.sub_total').each(function(){
                    var temp = $(this).text().replace(/\$/g, '');
                    temp.replace(/\ /g, '');
                    sub += parseFloat(temp);
                })
            }
        })
        $("#dis_sub").val("$ " + def);
        $("#dis_dis").val("$ " + (def - sub));
        $("#dis_total").val("$ " + (sub - coupon).toFixed(2) )
        var total = ((sub - coupon) * $(".num_weeks").val()).toFixed(2);
        $("#total_amount").val(total);
        get_payment_method();
    }
    function change_format(data){
        var data = data.replace(/\$/g, '');
        data = data.replace(/\ /g, '');
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
    $(document).ready(function(){
        display_total();
        change_sch()
        $(".chose-payment").on('click', function(){
            $(".btn-payment").click();
        })
        $(".input-mask").inputmask({reverse: true});
        $(".num_weeks").on('change', function(){
            $("#dis_week").val($(this).val());
            change_sch();
            display_total();
        })
        // Submit
        $("#frmCreate").submit(function(event){
            save_camp(0);
        })
        $("#btn_save").on('click', function(){
            save_camp(0);
        })
        $(".save-draft").on('click', function(){
            save_camp(3);
        })
        function save_camp(flag){
            // event.preventDefault();
            var fs = new FormData(document.getElementById("frmCreate"));
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
            // Payment Method
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
            fs.append('id', "<?php echo $campaign->id?>");
            fs.append('locations', locations);
            fs.append('slots', slots);
            fs.append('price', price);
            fs.append('sub_total', sub_total);
            fs.append('total', $("#total_amount").val());
            fs.append('camp_start', $(".camp_start").val());
            // end of signs
            fs.append('status', flag)
            KTApp.blockPage();
            $.ajax({
                url : '/update-user-camp',
                type : "POST",
                data : fs,
                headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
                processData : false,
                contentType : false,
                success : function(res){
                    KTApp.unblockPage();
                    if(res == "success"){
                        <?php
                            if(session('level') >= 2){
                        ?>
                        if(pay_method == 0){
                            Swal.fire({
                                title: "Send Payment Link to Client?",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonText: "Yes, send it!"
                            }).then(function(result) {
                                if (result.value) {
                                    send_link("<?php echo $campaign->id?>");
                                }
                                else{
                                    location.href="/manage-campaign";
                                }
                            });
                        }
                        else{
                            location.href="/manage-campaign";
                        }
                        <?php }
                        else{
                            if(isset($invoice->id) && $invoice->id != 0){
                            ?>
                            location.href="/view-invoice/<?php echo $invoice->id?>";
        
                            <?php }
                            else{
                        ?>
                            location.href="/manage-campaign";
                        <?php } }?>
                    }
                    else{
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
        get_price();
        $(".signs, .days, .slot, .num_weeks").on("change", function(){
            get_price();
        })
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
            $("#days").find('input').each(function(){
                if($(this).prop('checked') == true){
                    days.push($(this).val());
                }
            })
            if(days.length == 0){
                clear_price();
                toastr.error("Please select at least one day");
                return;
            }
            $(".signs").each(function(){
                if($(this).prop('checked') == true){
                    var selectedIndex = $(this).parent().parent().parent().find('.slot').prop('selectedIndex');
                    signs.push($(this).parent().parent().parent().find('.sign_name').data('id'));
                    // slots.push($(this).parent().parent().parent().find('.slot').val());
                    slots.push($($(this).parent().parent().parent().find('.slot').find('option')[selectedIndex]).val());
                }
            })
            if(signs.length == 0){
                clear_price();
                toastr.error("Please select at least one sign");
                return;
            }
            KTApp.blockPage();
            $.ajax({
                url : "/get_price",
                type : "POST",
                data : {
                    days : days,
                    signs : signs,
                    slots : slots,
                    weeks : $(".num_weeks").val(),
                    business_name : "<?php echo $business_name?>",
                    coupon_num : $(".coupon_num").val(),
                    edit_flag : true,
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
                    else{
                        toastr.error(result);
                    }
                },
                error :  function(err){
                    KTApp.unblockPage();
                    toastr.error("Please refresh your browser");
                }
            })
        }
        // Preview 
        $(".pre_img").each(function(){
            $(this).click(function(){
                $("#pre_img").attr("src", $(this).data('img'));
                $(".btn-preview").click();
            })
        })
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
        $("#change-name").click(function(){
            var fs = new FormData(document.getElementById("frmCreate"));
            fs.append('id', "<?php echo $campaign->id?>");
            $.ajax({
                url : "/change-name",
                type : "POST",
                data : fs,
                processData : false,
                contentType : false,
                headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
                success : function(res){
                    if(res == 'success'){
                        location.reload();
                    }
                    else{
                        toastr.error(res);
                    }
                },
                error : function(err){
                    toastr.error("Please refresh your browser");
                }
            })
        })
    })
</script>
