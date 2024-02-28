<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\UserCampaign;
use App\Invoices;
use App\Coupon;
use App\PaymentMethod;
use App\FreeLocations;
use App\Business;
use App\CheckoutModel;

use App\Mail\UserCampaignMail;
use App\Mail\SendPaymentLink;
use App\Mail\PaymentLinkManual;
use Illuminate\Support\Facades\Mail;

class CampaignController extends Controller
{
    public function manage_campaign(Request $request){
        if(!Session::has('user_id')){
            return redirect('login');
        }
        $data = array();
        $data['page_name'] = "Campaign Manager";
        return view('admin.campaign.manage', $data);
    }
    public function list_campaign(Request $request){
        if(!Session::has('user_id')){
            return redirect('login');
        }
        $data = array();
        $data['page_name'] = "Campaign Manager";
        $data['users'] = DB::table('tbl_user')->get();
        $data['pa'] = \App::call("App\Http\Controllers\UserController@list_pa");
        if(session('level') >= 2){
            $data['business_name'] = \App::call("App\Http\Controllers\MainController@get_business_name_by_session");
            if(session('level') == 2){
                $data['campaign'] = UserCampaign::orderby('id', 'desc')->get();
            }
            else{
                $business_name = [];
                foreach($data['business_name'] as $val){
                    $business_name[] = $val->business_name;
                }
                $data['campaign'] = UserCampaign::leftJoin('tbl_user', 'tbl_user.id', 'tbl_user_campaign.user_id')
                    ->whereIn('tbl_user.business_name', $business_name)
                    ->select('tbl_user_campaign.*')
                    ->get();
            }
            $data['invoices'] = Invoices::get();
        }
        else{
            // if(session('level') == 1){
            //     $business_name = session('business_name');
            //     $data['campaign'] = UserCampaign::leftJoin('tbl_user', 'tbl_user.id', 'tbl_user_campaign.user_id')
            //         ->whereIn('tbl_user.business_name', $business_name)
            //         ->select('tbl_user_campaign.*')
            //         ->get();
            // }
            // else{
                $user_id = session('user_id');
                $data['campaign'] = UserCampaign::where('user_id', $user_id)->orderby('id', 'desc')->get();
                $data['invoices'] = Invoices::where('client_id', $user_id)->get();
            // }
            // $data["check_multi"] = \App::call("App\Http\Controllers\MainController@check_multi");
        }

        return view('admin.campaign.list', $data);
    }
    public function create_view(Request $request){
        if(!Session::has('user_id')){
            return redirect('login');
        }
        $user_id = session('user_id');
        $data = array();
        $data['page_name'] = "Create Campaign";
        // $data["check_multi"] = \App::call("App\Http\Controllers\MainController@check_multi");
        $data['locations'] = DB::table("tbl_location_by_name")
            ->where('business_name' , session('business_name'))
            ->leftJoin("tbl_locations","tbl_locations.id","tbl_location_by_name.location_id")
            ->select("tbl_locations.name","tbl_location_by_name.*", 'tbl_locations.nickname', 'tbl_locations.price', 'tbl_locations.discount')
            ->orderby('tbl_locations.nickname')
            ->get();
        $total_locations = DB::table('tbl_locations')
            ->select('tbl_locations.*', 'tbl_locations.id as location_id')
            ->get();
        $locations = [];
        foreach($total_locations as $key => $val){
            if(!isset($locations[$val->location_id])){
                $locations[$val->location_id]['name'] = $val->name;
                $locations[$val->location_id]['num'] = 12;
            }
        }
        $campaigns = UserCampaign::where('user_id', $user_id)->get();
        foreach($campaigns as $item){
            $temp_location = explode(",", $item->locations);
            $slots = explode(",", $item->slots);
            foreach ($temp_location as $key => $val) {
                if(isset($locations[$val])){
                    $temp_num = $locations[$val]['num'];
                    $locations[$val]['num'] = $temp_num - $slots[$key];
                }
            }
        }
        $data['ava_locations'] = $locations;
        $business_name = session('business_name');
        if(session('level') < 2){
            $data['p_method'] = PaymentMethod::where('business_name', $business_name)->first();
        }
        $today = date("Y-m-d");
        $coupons = Coupon::where('business_name', $business_name)
            ->get();
        $temp = [];
        foreach($coupons as $key => $val){
            if(strtotime($val->start_date) <= strtotime($today) && strtotime($val->end_date) >= strtotime($today)){
                $temp[] = $val;
            }
        }
        $data['coupons'] = $temp;
        return view('admin.campaign.create', $data);
    }
    // Create campaign User Side
    public function create_view_user_side(Request $request){
        if(!Session::has('user_id')){
            return redirect('login');
        }
        $data['page_name'] = "Create Campaign";
        $controller = app()->make('App\Http\Controllers\MainController');
        $data['business_name'] = app()->call([$controller, 'get_business_name_by_session'], []);
        return view('admin.campaign.createbyuser', $data);
    }
    // Get Switch Locations
    public function switch_location(Request $request){
        $campaign_id = $request['id'];
        $campaign = UserCampaign::where('id', $campaign_id)->first();
        $locations = explode(",", $campaign->locations);
        $switch_locations = [];
        $html = "";
        foreach ($locations as $key => $value) {
            $current = DB::table('tbl_locations')->where('id', $value)->first();
            // Get Compared
            $current_location = explode("-", $current->nickname);
            $compare = [];
            if(isset($current_location[0])){
                $compare = DB::table('tbl_locations')
                    ->where('nickname', 'like', '%'.trim($current_location[0]).'%')
                    ->where('id', '!=', $current->id)
                    ->first();
                if(!isset($compare->name)){
                    $current_location = explode(" ", $current->nickname);
                    if(isset($current_location[0])){
                        $compare = DB::table('tbl_locations')
                            ->where('nickname', 'like', '%'.trim($current_location[0]).'%')
                            ->where('id', '!=', $current->id)
                            ->first();
                    }
                    else{
                        $compare = DB::table('tbl_locations')
                            ->where('price', $current->price)
                            ->where('discount', $current->discount)
                            ->where('id', "!=", $current->id)
                            ->first();
                    }
                }
            }
            else{
                $current_location = explode(" ", $current->nickname);
                if(isset($current_location[0])){
                    $compare = DB::table('tbl_locations')
                        ->where('nickname', 'like', '%'.trim($current_location[0]).'%')
                        ->where('id', '!=', $current->id)
                        ->first();
                }
                else{
                    $compare = DB::table('tbl_locations')
                        ->where('price', $current->price)
                        ->where('discount', $current->discount)
                        ->where('id', "!=", $current->id)
                        ->first();
                }
            }
            $temp = array();
            $temp['current'] = $current;
            $temp['switch'] = $compare;
            $switch_locations[] = $temp;
            if(isset($current->name) && isset($compare->name)){
                $html .= '<div class="form-group row">
                    <label class="col-4 col-form-label">'.$current->name.'</label>
                    <div class="col-3">
                        <span class="switch">
                            <label>
                                <input type="checkbox" name="current[]" value="'.$current->id.', '.$compare->id.'"/>
                                <span></span>
                            </label>
                        </span>
                    </div>
                    <label class="col-4 col-form-label">'.$compare->name.'</label>
                </div>';
            }
        }
        $result = [];
        $result['data'] = $html;
        return $result;
    }
    public function save_switch(Request $request){
        $camp_id = $request['camp_id'];
        $current = $request['current'];
        if(!isset($request['current'])){
            return "Please select location(s) to switch.";
        }
        foreach($current as $temp){
            $campaign = UserCampaign::where('id', $camp_id)->first();
            $locations = explode(",",$campaign->locations);
            // Replace location
            $location_temp = explode(",", $temp);
            $prev = str_replace(" ","",$location_temp[0]);
            $new = str_replace(" ","",$location_temp[1]);
            $new_name = DB::table('tbl_locations')->where('id', $new)->first();
            $pre_name = DB::table('tbl_locations')->where('id', $prev)->first();
            foreach ($locations as $key => $value) {
                if($value == $prev){
                    $locations[$key] = $new;
                }
            }
            $new_locations = implode (",", $locations);
            // Delete Sub Play List FROM CM
            $business = Business::where('primary_id', $campaign->user_id)->first();
            if(isset($business->id)){
                $business_name = $business->company_name;
                $sub_name = "Sub-".$business_name.$pre_name->name;
                $controller = app()->make('App\Http\Controllers\ManageScala');
                $delete_sub_play = app()->call([$controller, 'delete_sub_play'], [
                    "name" => $sub_name,
                ]);
            }
            UserCampaign::where('id', $camp_id)
                ->update([
                    'locations' => $new_locations
                ]);
            // Replace Invoice
            $invoice = Invoices::where('campaign_id', $camp_id)->first();
            $inv_data = json_decode($invoice->data);
            foreach($inv_data as $key => $value){
                if($value->location_id == $prev){
                    $inv_data[$key]->location_id = $new;
                    $inv_data[$key]->location_name = $new_name->name;
                }
            }
            Invoices::where('campaign_id', $camp_id)->update([
                'data' => json_encode($inv_data)
            ]);
        }
        return 'success';
    }
    // End of Switch
    public function getLocationBusiness(Request $request){
        $business_name = $request->name;
        if($business_name == ""){
            $data['success'] = true;
            $data['footer'] = "";
            return $data;
        }
        $data['success'] = true;
        $locations = DB::table("tbl_location_by_name")
            ->where('business_name' , $business_name)
            ->leftJoin("tbl_locations","tbl_locations.id","tbl_location_by_name.location_id")
            ->select("tbl_locations.name","tbl_location_by_name.*", 'tbl_locations.nickname', 'tbl_locations.price', 'tbl_locations.discount')
            ->orderby('tbl_locations.nickname')
            ->get();
        $total_locations = DB::table('tbl_locations')
            ->select('tbl_locations.*', 'tbl_locations.id as location_id')
            ->get();
        $ava_locations = [];
        foreach($total_locations as $key => $val){
            if(!isset($ava_locations[$val->location_id])){
                $ava_locations[$val->location_id]['name'] = $val->name;
                $ava_locations[$val->location_id]['num'] = $val->cur_sub==null?12:$val->max - $val->cur_sub;
            }
        }
        $users = DB::table('tbl_user')
            ->where('business_name', $business_name)
            ->get();
        $user_ids = [];
        foreach($users as $key => $val){
            $user_ids[] = $val->id;
        }
        // $campaigns = UserCampaign::whereIn('user_id', $user_ids)->get();
        // foreach($campaigns as $item){
        //     $temp_location = explode(",", $item->locations);
        //     $slots = explode(",", $item->slots);
        //     foreach ($temp_location as $key => $val) {
        //         if(isset($ava_locations[$val])){
        //             $temp_num = $ava_locations[$val]['num'];
        //             $ava_locations[$val]['num'] = $temp_num - $slots[$key];
        //         }
        //     }
        // }

        $html = "";
        foreach($locations as $key => $val){
            $prices = explode(",", $val->price);
            $price = isset($prices[6])?$prices[6]:0;
            $check_status = isset($ava_locations[$val->location_id])&&$ava_locations[$val->location_id]['num']==0?"":"";
            $disable_status = isset($ava_locations[$val->location_id])&&$ava_locations[$val->location_id]['num']==0?"disabled":"";
            $notification = isset($ava_locations[$val->location_id])&&$ava_locations[$val->location_id]['num']==0?'data-container="body" data-toggle="tooltip" title="There are no available slots on this sign during the time frame of your Campaign.   Try shortening the number of weeks or change the Start Date.  You could also break your Campaign into two parts in order to de-conflict with this scheduling issue."':'';
            if($key == 0){
                $prices = explode(",", $val->price);
                $discount = isset($prices[6])?$prices[6]:0;
            }
            else{
                $discouns = explode(",", $val->discount);
                $discount = isset($discouns[6])?$discouns[6]:0;
            }
            $drop_html = "";
            $p = 0;
            if(isset($ava_locations[$val->location_id])){
                for($i = 0; $i < $ava_locations[$val->location_id]['num']; $i++){
                    $p = $i + 1;
                    $drop_html .= '<option value="'.$p.'">'.$p.'</option>';
                }
            }
            else{
                for($i = 0; $i < 12; $i++){
                    $p = $i + 1;
                    $drop_html .= '<option value="'.$p.'">'.$p.'</option>';
                }
            }
            $html .= '<tr>'.
                '<td>'.
                    '<label class="checkbox">'.
                        '<input type="checkbox" class="signs"' . $check_status. " ". $disable_status." ". $notification .' name="signs"/>'.
                        '<span '. $notification .'></span>'.
                    '</label>'.
                '</td>'.
                '<td class="sign_name" data-id="'.$val->location_id.'">'.$val->nickname.'</td>'.
                '<td>'.
                    '<select class="form-control slot" data-init="'.$p.'" data-id="'.$val->location_id.'">'.$drop_html.'</select>'.
                "</td>".
                '<td class="input-mask price" data-inputmask-alias="currency">'.$price.'</td>'.
                '<td class="input-mask sub_total hide" data-inputmask-alias="currency">'.$discount.'</td>'.
                '<td><a href="javascript:;" class="pre_img" data-img="/map/'.$val->nickname.'.png"><i class="fa fas fa-map-marker-alt text-info"></i></a></td>'.
                // '<td><a href="javascript:;"><i class="fa fa-image text-success"></i></a></td>'.
            "</tr>";
        }
        $data['locations'] = $html;
        // Footer buttons
        $footer = "";
        $payment_method = PaymentMethod::where('business_name', $business_name)->first();
        if(!isset($payment_method->id)){
            // return "Please set up the payment method";
            $new_pay_method = new PaymentMethod;
            $new_pay_method->business_name = $business_name;
            $new_pay_method->payment_method = json_encode(["1", "2"]);
            $new_pay_method->save();
            $new_pay_method_id = $new_pay_method->id;
            $p_method = PaymentMethod::where('id', $new_pay_method_id)->first();
            $payment_method = json_decode($p_method->payment_method, true);
        }
        else{
            $payment_method = json_decode($payment_method->payment_method, true);
        }
        if(in_array('0', $payment_method)){
            // $footer .= '<button class="btn btn-info float-right save-draft ml-3" type="button">Save Campaign for Later</button>';
            $footer .= '<button class="btn btn-danger float-right" type="submit">Save Campaign - No Charge</button>';
        }
        else if(in_array('3', $payment_method)){
            // $footer .= '<button class="btn btn-info float-right save-draft ml-3" type="button">Save Campaign for Later</button>';
            $footer .= '<button class="btn btn-danger set_contract float-right" type="button">Set Contract</button>';
        }
        else{
            // $footer .= '<button class="btn btn-info float-right save-draft ml-3" type="button">Save Campaign for Later</button>';
            $footer .= '<button class="btn btn-primary float-right chose-payment" type="button">Choose Payment Method</button>';
        }
        // Coupon
        $campaign_last = UserCampaign::latest()->first();
        $coupons = Coupon::where('business_name', $business_name)
            ->orWhere("business_name", "like", "%All%")
            ->get();
        $coupon_num = "";
        $today = date("Y-m-d");
        foreach($coupons as $key => $val){
            if(strtotime($val->start_date) <= strtotime($today) && strtotime($val->end_date) >= strtotime($today)){
                $temp[] = $val;
                $coupon_num = $val->id;
            }
        }
        $coupon_dis = $coupon_num;
        // Coupon Used
        $coupon_exist = UserCampaign::where("coupon", $coupon_num)->first();
        if(isset($coupon_exist->id)){
            $coupon_num = "";
        }
        // No Coupon about Free
        if(in_array('0', $payment_method)){
            $coupon_num = "";
        }
        $data['footer'] = $footer;
        $data['p_method'] = $payment_method;
        $data['coupon_num'] = $coupon_num;
        $data['coupon_dis'] = $coupon_dis;
        return $data;
    }
    // End of create campaign user side
    public function edit_campaign(Request $request){
        if(!Session::has('user_id')){
            return redirect('login');
        }
        $data = array();
        $data['page_name'] = "Edit Campaign";
        $route_name =  \Request::route()->getName();
        if($route_name == "purchase"){
            $data['page_name'] = "Purchase Advertising";
            $campaign_id = base64_decode($request['id'], true);
        }
        else{
            $campaign_id = $request['id'];
        }
        if(session('level') < 2){
            $user_id = session('user_id');
            $exist = UserCampaign::where('user_id', $user_id)
                ->where('id', $campaign_id)
                ->first();
            $business_name = session('business_name');
        }
        else{
            $exist = UserCampaign::where('id', $campaign_id)->first();
        }
        if(!isset($exist->id)){
            return redirect()->back()->withErrors("You don't have permission to edit this campaign");
        }
        if(session('level') >= 2){
            $client = DB::table('tbl_user')
                ->where('id', $exist->user_id)
                ->first();
            $user_id = $exist->user_id;
            $business_name = $client->business_name;
        }
        // $data["check_multi"] = \App::call("App\Http\Controllers\MainController@check_multi");
        $data['locations'] = DB::table("tbl_location_by_name")
            ->where('business_name' , $business_name)
            ->leftJoin("tbl_locations","tbl_locations.id","tbl_location_by_name.location_id")
            ->select("tbl_locations.name","tbl_location_by_name.*", 'tbl_locations.nickname', 'tbl_locations.price', 'tbl_locations.discount')
            ->orderby('tbl_locations.nickname')
            ->get();
        $total_locations = DB::table('tbl_locations')
            ->select('tbl_locations.*', 'tbl_locations.id as location_id')
            ->get();
        $locations = [];
        foreach($total_locations as $key => $val){
            if(!isset($locations[$val->location_id])){
                $locations[$val->location_id]['name'] = $val->name;
                // $locations[$val->location_id]['num'] = 12;
                $locations[$val->location_id]['num'] = 12 - $val->cur_sub;
            }
        }
        $data['campaign'] = UserCampaign::where('id', $campaign_id)
            ->where('user_id', $user_id)
            ->first();
        $campaigns = UserCampaign::where('user_id', $user_id)->get();  foreach($campaigns as $item){
            $temp_location = explode(",", $item->locations);
            $slots = explode(",", $item->slots);
            foreach ($temp_location as $key => $val) {
                if(isset($locations[$val]) && $data['campaign']->id != $item->id){
                    $temp_num = $locations[$val]['num'];
                    $locations[$val]['num'] = $temp_num - intval($slots[$key]);
                }
            }
        }
        $data['ava_locations'] = $locations;
        if(session('level') < 2){
            $data['p_method'] = PaymentMethod::where('business_name', session('business_name'))->first();
        }
        else{
            $data['p_method'] = PaymentMethod::where('business_name', $business_name)->first();
        }
        $invoice = Invoices::where('campaign_id', $campaign_id)->first();
        if(!isset($invoice->id)){
            $controller = app()->make('App\Http\Controllers\InvoiceController');
            app()->call([$controller, 'generate_invoice_by_camp'], [
                "id" => $campaign_id,
            ]);
            $invoice = Invoices::where('campaign_id', $campaign_id)->first();
        }
        $data['invoice'] = $invoice;
        $today = date("Y-m-d");
        $coupons = Coupon::where('business_name', $business_name)
            ->get();
        $temp = [];
        foreach($coupons as $key => $val){
            if(strtotime($val->start_date) <= strtotime($today) && strtotime($val->end_date) >= strtotime($today)){
                $temp[] = $val;
            }
        }
        $data['business_name'] = $business_name;
        $data['coupons'] = $temp;
        return view('admin.campaign.edit', $data);
    }
    public function change_name(Request $request){
        UserCampaign::where('id', $request->id)
            ->update([
                'campaign_name' => $request['camp_name']
            ]);
        return "success";
    }
    public function get_price_front(Request $request){
        $locations = $request['locations'];
        $days = count($request['days']) - 1;
        $init_price = [];
        $discount_price = [];
        $ind = 0;
        $total_init = 0;
        $total_dis = 0;
        $total = 0;
        foreach($locations as $key => $val){
            $location = DB::table("tbl_locations")->where('id', $val)->first();
            if($val != null && isset($location->price) && $location->price != null){
                $price_list = explode(",", $location->price);
                $discounts = explode(",", $location->discount);
                if($ind == 0 && isset($price_list[$days]) && isset($discounts[$days])){
                    $init_price[$key] = number_format($price_list[$days], 2);
                    $discount_price[$key] = number_format($price_list[$days], 2);
                }
                else if($ind != 0 && isset($price_list[$days]) && isset($discounts[$days])){
                    $init_price[$key] = number_format($price_list[$days], 2);
                    $discount_price[$key] = number_format($discounts[$days], 2);
                }
                $ind++;
            }
            else{
                $init_price[$key] = 0;
                $discount_price[$key] = 0;
            }
        }
        foreach($init_price as $key => $val){
            $total_init += $val;
            $total += $discount_price[$key];
            $total_dis += ($val - $discount_price[$key]);
        }
        $result['init'] = $init_price;
        $result['discounts'] = $discount_price;
        $result['total'] = [
            number_format($total_init, 2), 
            number_format($total_dis, 2),
            number_format($total, 2)];
        return $result;
        return $request;
    }
    public function get_price(Request $request){
        if(!isset($request['days'])){
            return "Please select at least one day";
        }
        if(!isset($request['signs'])){
            return "Please select at least one sign";
        }
        // Franchise
        $free_signs = [];
        if(isset($request['business_name'])){
            $free_locations = FreeLocations::where('business_name', $request['business_name'])
                ->get();
            foreach($free_locations as $key => $val){
                $free_signs[] = $val->location_id;
            }
        }
        $signs = $request['signs'];
        $slots = $request['slots'];
        $days = count($request['days']) - 1;
        $list_days = $request['days'];
        if(!isset($request['weeks']) || $request['weeks'] == null){
            $weeks = 1;
        }
        else{
            $weeks = $request['weeks'];
        }
        $price = [];
        $init = [];
        // Get Available Signs
        $users = DB::table('tbl_user')
            ->where('business_name', $request['business_name'])
            ->get();
        $user_ids = [];
        foreach($users as $key => $val){
            $user_ids[] = $val->id;
        }
        $campaigns = UserCampaign::whereIn('user_id', $user_ids)->get();
        $sub_ava = [];
        $sub_list = [];
        foreach($campaigns as $key => $val){
            $temp_days = explode(",", $val->days);
            $temp_location = explode(",", $val->locations);
            $temp_slots = explode(",", $val->slots);
            $exist = false;
            foreach($list_days as $item){
                if(in_array($item, $temp_days)){
                    $exist = true;
                }
            }
            if($exist == false){
                foreach($temp_location as $index => $item){
                    if(in_array($item, $signs)){
                        $sub_ava[$item] = isset($sub_ava[$item])
                            ?intval($temp_slots[$index]) + $sub_ava[$item]  
                            :intval($temp_slots[$index]);
                    }
                }
            }
        }
        $i = 0;
        foreach($sub_ava as $key => $val){
            $temp['id'] = $key;
            $temp['num'] = $val;
            $sub_list[] = $temp;
        }
        $total = 0;
        foreach($signs as $key => $val){
            $sign = DB::table('tbl_locations')
                ->where('id', $val)
                ->first();
            if(in_array($sign->id, $free_signs)){
                $init[$key] = 0.00;
                $price[$key] = 0.00;
            }
            else{
                $prices = explode(",", $sign->price);
                $discounts = explode(",", $sign->discount);
                $price_day = isset($prices[$days])?$prices[$days]:0;
                $dis_day = isset($prices[$days])?$prices[$days]:0;
                // $dis_day = isset($discounts[$days])?$discounts[$days]:0;
                if($key == 0){
                    $init[$key] = number_format($price_day * $slots[$key], 2);
                    $price[$key] = number_format($price_day * $slots[$key], 2);
                    // $price[$key] = number_format($price_day * $slots[$key] + $dis_day * ($slots[$key] - 1), 2);
                }
                else{
                    $init[$key] = number_format($price_day * $slots[$key], 2);
                    $price[$key] = number_format($price_day * $slots[$key], 2);
                    // $price[$key] = number_format($dis_day * $slots[$key], 2);
                }
                $total += $this->change_format($price[$key]);
                // $total += floatval($price[$key]);
            }
        }
        // Coupon
        $today = date("Y-m-d");
        $coupon_total = 0;
        if(isset($request['edit_flag']) && isset($request['coupon_num']) && ($request['coupon_num'] != '' || $request['coupon_num'] != 0)){
            $coupon_exist = UserCampaign::where("coupon", $request['coupon_num'])->first();
            if(isset($coupon_exist->id)){
                $coupon = Coupon::where('id', $request['coupon_num'])->first();
                if(isset($coupon->id)){
                    if($coupon->type == 0){
                        if($coupon->weeks >= $weeks){
                            $coupon_total = $total;
                        }
                        else{
                            $coupon_total = $total * $coupon->weeks / $weeks;
                        }
                    }
                    else if($coupon->type == 1){
                        $coupon_total = $coupon->amount / $weeks;
                    }
                    else{
                        $coupon_total = $total * $coupon->amount / 100;
                    }
                }
            }
        }
        else{
            if(isset($request['coupon_num']) && ($request['coupon_num'] != '' || $request['coupon_num'] != 0)){
                $coupon_exist = UserCampaign::where("coupon", $request['coupon_num'])->first();
                if(!isset($coupon_exist->id)){
                    $coupon = Coupon::where('id', $request['coupon_num'])->first();
                    // $coupon_type = 0; // 0 : Week, 1 : Fixed, 2 : percentage
                    if($coupon->start_date <=  strtotime($today) && strtotime($coupon->end_date) >= strtotime($today)){
                        if($coupon->type == 0){
                            if($coupon->weeks >= $weeks){
                                $coupon_total = $total;
                            }
                            else{
                                $coupon_total = $total * $coupon->weeks / $weeks;
                            }
                        }
                        else if($coupon->type == 1){
                            $coupon_total = $coupon->amount / $weeks;
                        }
                        else{
                            $coupon_total = $total * $coupon->amount / 100;
                        }
                    }
                }
            }
        }
        if($coupon_total > $total){
            $coupon_total = $total;
        }
        return [
            'status' => "success",
            'sub_total' => $price,
            'default' => $init,
            'sub' => $sub_list,
            'coupon' => $coupon_total,
        ];
    }
    public function update_price(Request $request){
        $data = $request->all();
        $price = "";
        $discount = "";
        foreach($data as $key => $val){
            if($key != 'id'){
                $data[$key] = $this->change_format($val);
                if(strpos($key, 'day') !== false){
                    $price .= $data[$key] .",";
                }
                else{
                    $discount .= $data[$key].",";
                }
            }
        }
        DB::table("tbl_locations")
            ->where('id', $request['id'])
            ->update([
                'price' => $price,
                'discount' => $discount
            ]);
        return 'success';
        return $data;
        return $request;
    }
    public function get_end(Request $request){
        $start = $request['start'];
        $weeks = $request['weeks'];
        $end = date("Y-m-d",strtotime("+" .$weeks * 7 - 1 ."days", strtotime($start)));
        return $end;
    }
    // Save Camp

    public function save_user_camp(Request $request){
        if(!Session::has('user_id')){
            return redirect()->route('/login');
        }
        if(isset($request['business_name']) && $request['business_name'] == ""){
            return "Please input valid business name";
        }
        $exist_name = UserCampaign::where('campaign_name', $request['camp_name'])->first();
        if(isset($exist_name->id)){
            return "The current campaign name already exists in our system. Please input another name.";
        }
        $user_id = session('user_id');
        $business_name = $request['business_name'];
        if(isset($request['business_name'])){
            $users = DB::table("tbl_user")
                ->where('business_name', $request['business_name'])
                ->where('level', 1)
                ->first();
            if(isset($user->id)){
                $user_id = $user->id;
            }
            else{
                $users = DB::table("tbl_user")
                    ->where('business_name', $request['business_name'])
                    ->first();
                if(isset($users->id)){
                    $user_id = $users->id;
                }
                else{
                    return "There are no Primary or Secondary TA with this business name";
                }
            }
        }
        // Exist
        $camp = UserCampaign::where('user_id', $user_id)
            ->where('campaign_name', $request['camp_name'])
            ->first();
        if(isset($camp->id)){
            return "Please input another campaign name";
        }
        if($request['camp_name'] == ''){
            return "Please input campaign name";
        }
        $total = str_replace("$", "", $request['total']);
        $total = str_replace(" ", "", $total);
        $total = str_replace(",", "", $total);
        $coupon_amount = $this->change_format($request['coupon_amount']);
        $campaign = new UserCampaign;
        $campaign->user_id = $user_id;
        $campaign->campaign_name = $request['camp_name'];
        $campaign->start_date = $request['camp_start'];
        $campaign->days = $request['days'];
        $campaign->end_flag = isset($request->no_end)?1:0;
        $campaign->end_date = isset($request->no_end)?'':$request['camp_end'];
        $campaign->weeks = isset($request->no_end)?'':$request['num_weeks'];
        $campaign->locations = $request['locations'];
        $campaign->slots = $request['slots'];
        $campaign->price = $request['price'];
        $campaign->sub_total = $request['sub_total'];
        $campaign->total = $total;
        // Coupon
        $campaign->coupon = $request['coupon'];
        $campaign->coupon_amount = $coupon_amount;
        // Payment Method
        $campaign->sch = $request['sch'];
        $campaign->pay_method = $request['pay_method'];
        $part_amount = 0;
        if(isset($request['part_amount'])){
            $part_amount = str_replace("$", "",$request['part_amount']);
            $part_amount = str_replace(",", "",$part_amount);
            $part_amount = str_replace(" ", "",$part_amount);
        }
        $status = isset($request['status'])?$request['status']:0;
        // Free User
        $payment_method = PaymentMethod::where('business_name', $business_name)->first();
        $free_plan = 0;
        if(isset($payment_method->id)){
            $payment_method = json_decode($payment_method->payment_method, true);
            if(in_array('0', $payment_method)){
                $status = 1;
                $free_plan = 1;
            }
            if(in_array('3', $payment_method)){
                $status = 1;
                $free_plan = 2;
            }
        }
        // End of Free User
        $campaign->part_amount = $part_amount;
        $campaign->status = $status;
        $campaign->free_plan = $free_plan;
        $campaign->save();
        $camp_id = $campaign->id;
        // Send Email
        $user = DB::table('tbl_user')->where('id', $user_id)->first();
        $user_camp = UserCampaign::where('id', $camp_id)->first();
        $locations = DB::table('tbl_locations')->get();
        $controller = app()->make('App\Http\Controllers\InvoiceController');
        app()->call([$controller, 'generate_invoice_by_camp'], [
            "id" => $camp_id,
        ]);

        try {

            if($status != 3){
                if($free_plan == 2){ //Contract
                    $res = Mail::to($user->email)->send(new UserCampaignMail($user, $user_camp, 3, $locations));
                }
                else{
                    $res = Mail::to($user->email)->send(new UserCampaignMail($user, $user_camp, 0, $locations));
                }
            }

            \Illuminate\Support\Facades\Log::info("Email 'save user compaign' sent successfully");
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Email 'save user compaign' sending failed: ".$e->getMessage());
        }

        $data = array();
        $data['success'] = true;
        $data['id'] = $camp_id;
        return $data;
    }
    // Update Camp
    public function update_user_camp(Request $request){
        if(!Session::has('user_id')){
            return redirect()->route('/login');
        }
        $user_id = session('user_id');
        if(session('level') >= 2){
            $camp = UserCampaign::where('id', $request['id'])->first();
            if(!isset($camp->id)){
                return "Sorry but this campaign has been removed.";
            }
            $user_id = $camp->user_id;
        }
        // Exist
        $camp = UserCampaign::where('user_id', $user_id)
            ->where('id', '!=' ,  $request['id'])
            ->where('campaign_name', $request['camp_name'])
            ->first();
        if(isset($camp->id)){
            return "Please input another campaign name";
        }
        // Check avaialbe from invoice
        $today = date("Y-m-d");
        $camp = UserCampaign::where('id', $request['id'])->first();
        $invoice = Invoices::where('campaign_id', $request['id'])->first();
        if(isset($invoice->id) && $invoice->paid == 1 && $today >= $camp->start_date){
            return "You can't update this campaign because it's started";
        }
        else if(isset($invoice->id) && $invoice->paid == 0 && $invoice->paid > 0 && $today > $invoice->invoice_date){
            return "You can't update this campaign because it's started";
        }
        // End of invoice check
        // $price = str_replace("$", "",$request['price']);
        // $price = str_replace(" ", "", $price);
        // $price = str_replace(",", "", $price);
        // $sub_total = str_replace("$", "", $request['sub_total']);
        // $sub_total = str_replace(" ", "", $sub_total);
        // $sub_total = str_replace(",", "", $sub_total);
        $total = str_replace("$", "", $request['total']);
        $total = str_replace(" ", "", $total);
        $total = str_replace(",", "", $total);
        $part_amount = str_replace("$", "",$request['part_amount']);
        $part_amount = str_replace(" ", "",$part_amount);
        $part_amount = str_replace(",", "",$part_amount);
        UserCampaign::where('id', $request['id'])
            ->where('user_id', $user_id)
            ->update([
                'campaign_name' => $request['camp_name'],
                'start_date' => $request['camp_start'],
                'days' => $request['days'],
                'end_flag' => isset($request->no_end)?1:0,
                'end_date' => isset($request->no_end)?'':$request['camp_end'],
                'weeks' => isset($request->no_end)?'':$request['num_weeks'],
                'locations' => $request['locations'],
                'slots' => $request['slots'],
                'price' => $request['price'],
                'sub_total' => $request['sub_total'],
                'total' => $total,
                'status' => isset($request['status'])?$request['status']:0,
                // Payment Method
                'sch' => $request['sch'],
                'pay_method' => $request['pay_method'],
                'part_amount' => $part_amount,
            ]);
        // Send Email
        $user = DB::table('tbl_user')->where('id', $user_id)->first();
        $user_camp = UserCampaign::where('id', $request['id'])->first();
        $this->update_invoice_by_camp($request['id']);
        // $locations = DB::table('tbl_locations')->get();
        // Mail::to($user->email)->send(new UserCampaignMail($user, $user_camp, 1, $locations));
        return 'success';
    }
    // Stop Camp
    public function stop_campaign(Request $request){
        $invoice = Invoices::where('campaign_id', $request['id'])->first();
        $campaign = UserCampaign::where('id', $request['id'])->first();
        if(!isset($invoice->id) || !isset($campaign->id)){
            return "Invalid campaign. Please contact us";
        }
        $inv_data = $invoice->id;
        if($campaign->end_date == $invoice->invoice_date){
            return "We are unable to shorten the Campaign.  The Campaign must be completed as scheduled.";
        }
        UserCampaign::where('id', $request['id'])->update([
            'end_date' => $invoice->invoice_date
        ]);
        $checkout = CheckoutModel::where('campaign_id', $request['id'])->first();
        if(isset($checkout->id)){
            $sub_id = $checkout->ch_id;
            $stripe = new \Stripe\StripeClient(
                config('app.st_sec')
            );
            try{
                $subscription = $stripe->subscriptionSchedules->retrieve(
                    $sub_id,
                    []
                );
                if(isset($subscription['id'])){
                    try {
                        if(isset($subscription['released_subscription'])){
                            $stripe->subscriptions->cancel(
                                $subscription['released_subscription'],
                                []
                            );
                        }
                    }
                    catch(\Stripe\Exception\CardException $e) {
                        // print_r($e->getError()->message);
                    }
                    catch(\Stripe\Exception\InvalidRequestException $e) {
                        // print_r($e->getError()->message);
                    }
                    $stripe->subscriptionSchedules->cancel(
                        $sub_id,
                        []
                    );
                }
            }
            catch(\Stripe\Exception\CardException $e) {
                // print_r($e->getError()->message);
            }
            catch(\Stripe\Exception\InvalidRequestException $e) {
                // print_r($e->getError()->message);
            }
        }
        return "success";
    }
    // Delete Camp
    public function delete_campaign(Request $request){
        if(!Session::has('user_id')){
            return "Your session has expired. Please refresh your browser";
        }
        $user_id = session('user_id');
        if(session('level') >= 2){
            $exist = UserCampaign::where('id', $request['id'])->first();
            if(!isset($exist->id)){
                "You don't have permission to delete this campaign";
            }
            $user_id = $exist->id;
        }
        else{
            $exist = UserCampaign::where('user_id', $user_id)
                ->where('id', $request['id'])
                ->first();
            if(!isset($exist->id)){
                return "You don't have permission to delete this campaign";
            }
            if(strtotime(date("Y-m-d")) > strtotime($exist->start_date)){
                return "You can't delete this campaign";
            }
        }
        // Campaign Status
        if(session('level') != 2 && ($exist->free_plan == 1 || $exist->free_plan == 2)){
            return "You can't delete Free/Contract/Paid campaigns.";
        }
        $invoice = Invoices::where('campaign_id', $exist->id)->first();
        if(session('level') != 2 && (isset($invoice->id) && $invoice->status == 1)){
            return "You can't delete this campaign.";
        }
        if(isset($invoice->id)){
            // Stop subscription in stripe
            $controller = app()->make('App\Http\Controllers\InvoiceController');
            app()->call([$controller, 'cancel_sub_stripe'], [
                'invoice_id' => $invoice->id,
            ]);
            Invoices::where('campaign_id', $exist->id)->delete();
        }
        UserCampaign::where('id', $request['id'])->delete();
        return "success";
    }
    // Send Payment Link to client
    public function send_link(Request $request){
        if(!Session::has('user_id') || session('level') < 2){
            return redirect('login');
        }
        $camp_id = $request['id'];
        $campaign = UserCampaign::where('id', $camp_id)->first();
        if(isset($campaign->id)){
            $user = DB::table('tbl_user')
                ->where('id', $campaign->user_id)->first();
            $camp_location = explode(",",$campaign->locations);
            $location_name = [];
            foreach($camp_location as $item){
                $location = DB::table('tbl_locations')->where('id', $item)->first();
                if(isset($location->id)){
                    $location_name[] = $location->name;
                }
            }
            $campaign['locations'] = json_encode($location_name);
            if(isset($user->id)){
                Mail::to($user->email)->send(new SendPaymentLink($user, $campaign));
                return "success";
            }
            else{
                return 'Invalid Campaign';
            }
        }
        return 'Invalid Campaign';
    }
    public function send_link_manual(Request $request){
        if(!Session::has('user_id') || session('level') < 2){
            return redirect('login');
        }
        $invoice_id = $request['id'];
        $invoice = Invoices::where('id', $invoice_id)->first();
        if(isset($invoice->id)){
            $user = DB::table('tbl_user')
                ->where('tbl_user.id', $invoice->client_id)
                ->first();
            $business = $this->get_business_information($user->business_name);
            if(isset($user->id)){
                $file_name = "";
                Mail::to($user->email)->send(new PaymentLinkManual($user, $business, $invoice, $file_name));
                return "success";
            }
        }
        return 'Invalid Invoice';
    }
    // Get Business Information
    public function get_business_information($business_name){
        $business = Business::where('company_name', $business_name)
            ->first();
        return $business;
    }
    // generate Invoice by camp
    public function update_invoice_by_camp($id){
        // $date = date("Y-m-d");
        $campaign = UserCampaign::where('id', $id)->first();
        $date = $campaign->start_date;
        
        $business = Business::where("primary_id", $campaign->user_id)->first();
        $account_manager = "";
        if(isset($business->id) && $business->sales != null){
            $sales = DB::table('tbl_user')
                ->where('id', $business->sales)->first();
            if(isset($sales->id)){
                $account_manager = $sales->user_name;
            }
        }
        // Description
        $description = [
            "due" => $date,
            "terms" => "Due upon receipt",
            "sales" => $account_manager,
            "account_number" => "20210020"
        ];
        // Invoice Body
        $invoice_body = [];
        $locations = explode(",",$campaign->locations);
        $slots = explode(",", $campaign->slots);
        $price = explode(",", $campaign->price);
        $sub_total = explode(",", $campaign->sub_total);
        $discount = 0;
        foreach($locations as $key => $val){ 
            $temp = [];
            $discount += $this->change_format($sub_total[$key]) * $campaign->weeks;
            $temp['location_id'] = $val;
            $location = DB::table('tbl_locations')->where('id', $val)->first();
            $temp['location_name'] = $location->name;
            $temp['due'] = $date;
            $temp['quantity'] = $slots[$key];
            $temp['price'] = $this->change_format($price[$key]);
            $temp['sub_total'] = $this->change_format($sub_total[$key]);
            $invoice_body[] = $temp;
        }
        // 
        Invoices::where('campaign_id', $campaign->id)
            ->update([
                'description' => json_encode($description),
                'data' => json_encode($invoice_body),
                'invoice_date' => $date,
                'discount' => $discount,
                'part_amount' => $campaign->part_amount,
                'amount' => $this->change_format($campaign->total),
            ]);
        return "success";
        // $invoice = New Invoices;
        // $invoice->user_id = 0;
        // $invoice->client_id = $campaign->user_id;
        // $invoice->campaign_id = $campaign->id;
        // $invoice->status = 0;
        // $invoice->invoice_date = $date;
        // $invoice->description = json_encode($description);
        // $invoice->data = json_encode($invoice_body);
        // $invoice->discount = $discount;
        // $invoice->amount = $campaign->total;
        // $invoice->save();
        // $invoice_id = $invoice->id;
        // $result['status'] = "success";
        // $result['invoice_id'] = $invoice_id;
        // return $result;
    }
    public function change_format($data){
        $data = str_replace("$", "", $data);
        $data = str_replace(" ", "", $data);
        $data = str_replace(",", "", $data);
        $data = str_replace("%", "", $data);
        return $data;
    }
    public function ads_sold(Request $request){
        if(!Session::has('user_id') || session('level') < 2){
            return redirect()->back()->withErrors("You don't have permission to access this page");
        }
        $today = date("Y-m-d");
        $data = [];
        $data['page_name'] = "Ads Sold";
        $data['business_name'] = \App::call("App\Http\Controllers\MainController@get_business_name_by_session");
        if(session('level') == 2){
            $campaigns = UserCampaign::leftJoin('tbl_invoice', 'tbl_user_campaign.id', 'tbl_invoice.campaign_id')
                ->leftJoin('tbl_user', 'tbl_user.id', 'tbl_user_campaign.user_id')
                ->select('tbl_user_campaign.*', 'tbl_invoice.invoice_date', 'tbl_invoice.status as inv_status', 'tbl_user.business_name')
                ->orderby('id', 'desc')->get();
        }
        else{
            $business_name = [];
            foreach($data['business_name'] as $val){
                $business_name[] = $val->business_name;
            }
            $campaigns = UserCampaign::leftJoin('tbl_user', 'tbl_user.id', 'tbl_user_campaign.user_id')
                ->leftJoin('tbl_invoice', 'tbl_user_campaign.id', 'tbl_invoice.campaign_id')
                // ->leftJoin('tbl_user', 'tbl_user.id', 'tbl_user_campaign.user_id')
                ->whereIn('tbl_user.business_name', $business_name)
                ->select('tbl_user_campaign.*', 'tbl_invoice.invoice_date', 'tbl_invoice.status as inv_status', 'tbl_user.business_name')
                ->get();
        }
        $data['users'] = DB::table('tbl_user')->get();
        $ava_camp = [];
        $ava_business = [];
        $ava_days = [];
        foreach($campaigns as $key => $val){
            if($val->inv_status == 1 && $val->end_date >= $today){
                $ava_camp[] = $val;
                $ava_business[] = $val->business_name;
                $ava_days[] = $val->days;
            }
            else if($val->invoice_date >= $today){
                $ava_camp[] = $val;
                $ava_business[] = $val->business_name;
                $ava_days[] = $val->days;
            }
        }
        // Ads
        $ads = DB::table('tbl_ad')
            ->leftjoin('tbl_user', 'tbl_user.id', 'tbl_ad.user_id')
            // ->where('media_id', '!=', null)
            ->whereIn('tbl_user.business_name', $ava_business)
            ->select('tbl_ad.*', 'tbl_user.user_name')
            ->orderby('tbl_user.business_name')
            ->get();
        $data['ads'] = $ads;
        return view('admin.payment.ads_sold', $data);
    }
    public function get_sold(Request $request){
        $business_name = $request['name'];
        $today = date("Y-m-d");
        if($request['name'] == ""){
            $campaigns = UserCampaign::leftJoin('tbl_user', 'tbl_user.id', 'tbl_user_campaign.user_id')
                ->leftJoin('tbl_invoice', 'tbl_user_campaign.id', 'tbl_invoice.campaign_id')
                ->select('tbl_user_campaign.*', 'tbl_invoice.invoice_date', 'tbl_invoice.status as inv_status', 'tbl_user.business_name')
                ->get();
        }
        else{
            $campaigns = UserCampaign::leftJoin('tbl_user', 'tbl_user.id', 'tbl_user_campaign.user_id')
                ->leftJoin('tbl_invoice', 'tbl_user_campaign.id', 'tbl_invoice.campaign_id')
                ->where('tbl_user.business_name', $business_name)
                ->select('tbl_user_campaign.*', 'tbl_invoice.invoice_date', 'tbl_invoice.status as inv_status', 'tbl_user.business_name')
                ->get();
        }
        $ava_camp = [];
        $ava_business = [];
        $ava_days = [];
        foreach($campaigns as $key => $val){
            if($val->inv_status == 1 && $val->end_date >= $today){
                $ava_camp[] = $val;
                $ava_business[] = $val->business_name;
                $ava_days[] = $val->days;
            }
            else if($val->invoice_date >= $today){
                $ava_camp[] = $val;
                $ava_business[] = $val->business_name;
                $ava_days[] = $val->days;
            }
        }
        $ads = DB::table('tbl_ad')
            ->leftjoin('tbl_user', 'tbl_user.id', 'tbl_ad.user_id')
            // ->where('media_id', '!=', null)
            ->whereIn('tbl_user.business_name', $ava_business)
            ->select('tbl_ad.*', 'tbl_user.user_name')
            ->orderby('tbl_user.business_name')
            ->get();
        $day = date('w');
        $week_start = date('Y-m-d 00:00:00', strtotime('-'.$day.' days'));
        $week_end = date('Y-m-d', strtotime('+'.(6-$day).' days'));
        // print_r($ava_days);
        $mon = date('Y-m-d 00:00:00', strtotime('-'.($day - 1).' days'));
        $tue = date('Y-m-d 00:00:00', strtotime('-'.($day - 2).' days'));
        $wed = date('Y-m-d 00:00:00', strtotime('-'.($day - 3).' days'));
        $thr = date('Y-m-d 00:00:00', strtotime('-'.($day - 4).' days'));
        $fri = date('Y-m-d 00:00:00', strtotime('-'.($day - 5).' days'));
        $sat = date('Y-m-d 00:00:00', strtotime('-'.($day - 6).' days'));
        $sun = date('Y-m-d 00:00:00', strtotime('-'.($day - 7).' days'));
        $day_list = [$week_start, $mon, $tue, $wed, $thr, $fri, $sat, $sun];

        $color_list = ['#6993FF', '#1BC5BD', '#8950FC', '#FFA800', '#F64E60'];
        $series = [];
        $num = 0;
        $total_num = 0;
        $p = 0;
        foreach($ads as $key => $val){
            $total_num = $key;
            $days = explode(",", $val->days);
            for($i = 0; $i < count($days) - 1; $i++){
                if($i > 0 && ($days[$i - 1] == $days[$i] - 1)){
                    $series[$p - 1]['y'][1] = strtotime($day_list[$days[$i] + 1]) * 1000;
                }
                else{
                    $num = $key." ".$i;
                    $temp = [];
                    $temp['x'] = $val->business_name. "-". $p;
                    $temp['fillColor'] = $color_list[$key % 5];
                    $temp['y'] = [
                        strtotime($day_list[$days[$i]]) * 1000, strtotime($day_list[$days[$i] + 1]) * 1000
                    ];
                    array_push($series, $temp);  
                    $p++;
                }  
            }
        }
        $result = [];
        $result['success'] = true;
        $result['series'] = $series;
        $result['total_num'] = $total_num;
        return $result;
    }
    // Weekly Inventory
    public function get_today_inv(Request $request){
        $today = date("Y-m-d");
        $user_camp = UserCampaign::Leftjoin('tbl_invoice', "tbl_invoice.campaign_id", "tbl_user_campaign.id")
            ->where('tbl_user_campaign.status', 1)
            ->where('tbl_user_campaign.start_date', "<=", $today)
            ->where('tbl_user_campaign.end_date', ">=", $today)
            ->orWhere('tbl_user_campaign.free_plan', "!=", 0)
            ->select('tbl_user_campaign.*', "tbl_invoice.status as inv_status")
            ->get();
        return $user_camp;
    }
    public function get_weeks_inventory(Request $request){
        $today = date("Y-m-d");
        $weeks = $request['week'];
        $before = $weeks - 1;
        $start_date = date("Y-m-d", strtotime("+".$before." week"));
        $end_date = date("Y-m-d", strtotime("+".$weeks." week"));
        $user_camp = UserCampaign::leftJoin('tbl_invoice', "tbl_invoice.campaign_id", "tbl_user_campaign.id")
            ->leftJoin('tbl_sub_invoices', 'tbl_sub_invoices.invoice_id', 'tbl_invoice.id')
            ->where('tbl_user_campaign.status', 1)
            ->where('tbl_user_campaign.start_date', "<=", $start_date)
            ->where('tbl_user_campaign.end_date', ">=", $end_date)
            // ->orWhere('tbl_user_campaign.free_plan', "!=", 0)
            ->select('tbl_user_campaign.*', "tbl_invoice.status as inv_status", 'tbl_sub_invoices.invoice_date as sub_inv_date')
            ->get();
        $location_list = \App::call("App\Http\Controllers\MainController@get_locations");
        $camp_locations = [];
        foreach($user_camp as $key => $val){
            // if($start_date <= $val['sub_inv_date'] && $val['sub_inv_date'] < $end_date){
                $locations = explode(",", $val->locations);
                $slots = explode(",", $val->slots);
                foreach($locations as $i => $temp){
                    if($slots[$i] != ''){
                        $camp_locations[$temp]['num'] = isset($camp_locations[$temp])?$camp_locations[$temp]['num'] + $slots[$i]:$slots[$i];
                    }
                }
            // }
        }
        $html = "";
        foreach($location_list as $key => $val){
            $location_list[$key]['num'] = isset($camp_locations[$val['id']])?$camp_locations[$val['id']]['num']:0;
            if($val['type'] === '0'){
                $total = isset($val['max'])&&$val['max']!=null?$val['max']:12;
                $width = $location_list[$key]['num'] / $total *100;
                $width_1 = ($total - $location_list[$key]['num']) / $total *100;
                $available = $total - $location_list[$key]['num'];
                $html .= '<div class="row pl-10 pr-10 mt-5">'.
                    '<div class="col-md-3">'.
                        '<span style="font-size:16px">'.$val['nickname'].'</span>'.
                    '</div>'.
                    '<div class="col-md-9">'.
                        '<div class="progress" style="height: 40px;">'.
                            '<div class="progress-bar bg-success" role="progressbar" '.
                                'style="width: '.$width.'%; font-weight:1000;font-size : 20px"'.
                                'aria-valuenow="'.$location_list[$key]['num'].'" aria-valuemin="0" aria-valuemax="100"'.
                                'title="'.$val['nickname'].'"'.
                            '>'.$location_list[$key]['num'].'</div>'.
                            '<div class="progress-bar bg-danger" role="progressbar" '.
                                'style="width: '.$width_1.'%; font-weight:1000;font-size : 20px"'.
                                'aria-valuenow="'.$available.'" aria-valuemin="0" aria-valuemax="100"'.
                                'title="'.$val['nickname'].'"'.
                            '>'.$available.'</div>'.
                        '</div>'.
                    '</div>'.
                '</div>';
            }
        }
        $result = [];
        $result['success'] = true;
        $result['data'] = $html;
        return $result;
    }
    // Inventory
    public function inventory_view(Request $request){
        if(!Session::has('user_id') || session('level') < 2){
            return redirect()->back()->withErrors("You don't have permission to access this page");
        }
        $today = date("Y-m-d");
        $data = [];
        $data['page_name'] = "Inventory Availability";
        $data['business_name'] = \App::call("App\Http\Controllers\MainController@get_business_name_by_session");
        return view('admin.payment.inventory', $data);
    }
    public function get_inventory(Request $request){
        $business_name = $request['name'];
        $today = date("Y-m-d");
        $campaigns = UserCampaign::leftJoin('tbl_user', 'tbl_user.id', 'tbl_user_campaign.user_id')
            ->leftJoin('tbl_invoice', 'tbl_user_campaign.id', 'tbl_invoice.campaign_id')
            ->where('tbl_user.business_name', $business_name)
            ->select('tbl_user_campaign.*', 'tbl_invoice.invoice_date', 'tbl_invoice.status as inv_status', 'tbl_user.business_name')
            ->get();
        $ava_camp = [];
        $ava_business = [];
        $ava_days = [];
        foreach($campaigns as $key => $val){
            if($val->inv_status == 1 && $val->end_date >= $today){
                $ava_camp[] = $val;
                $ava_business[] = $val->business_name;
                $ava_days[] = $val->days;
            }
            else if($val->invoice_date >= $today){
                $ava_camp[] = $val;
                $ava_business[] = $val->business_name;
                $ava_days[] = $val->days;
            }
        }
        $ads = DB::table('tbl_ad')
            ->leftjoin('tbl_user', 'tbl_user.id', 'tbl_ad.user_id')
            // ->where('media_id', '!=', null)
            ->where('tbl_ad.location', 'like', '%'.$request['location_name'].'%')
            ->whereIn('tbl_user.business_name', $ava_business)
            ->select('tbl_ad.*', 'tbl_user.user_name')
            ->orderby('tbl_user.business_name')
            ->get();
        $day = date('w');
        $week_start = date('Y-m-d 00:00:00', strtotime('-'.$day.' days'));
        $week_end = date('Y-m-d', strtotime('+'.(6-$day).' days'));
        // print_r($ava_days);
        $mon = date('Y-m-d 00:00:00', strtotime('-'.($day - 1).' days'));
        $tue = date('Y-m-d 00:00:00', strtotime('-'.($day - 2).' days'));
        $wed = date('Y-m-d 00:00:00', strtotime('-'.($day - 3).' days'));
        $thr = date('Y-m-d 00:00:00', strtotime('-'.($day - 4).' days'));
        $fri = date('Y-m-d 00:00:00', strtotime('-'.($day - 5).' days'));
        $sat = date('Y-m-d 00:00:00', strtotime('-'.($day - 6).' days'));
        $sun = date('Y-m-d 00:00:00', strtotime('-'.($day - 7).' days'));
        $day_list = [$week_start, $mon, $tue, $wed, $thr, $fri, $sat, $sun];

        $color_list = ['#6993FF', '#1BC5BD', '#8950FC', '#FFA800', '#F64E60'];
        $series = [];
        $num = 0;
        $total_num = 0;
        $p = 0;
        foreach($ads as $key => $val){
            $total_num = $key;
            $days = explode(",", $val->days);
            for($i = 0; $i < count($days) - 1; $i++){
                if($i > 0 && ($days[$i - 1] == $days[$i] - 1)){
                    $series[$p - 1]['y'][1] = strtotime($day_list[$days[$i] + 1]) * 1000;
                }
                else{
                    $num = $key." ".$i;
                    $temp = [];
                    $temp['x'] = $val->business_name. "-". $p;
                    $temp['fillColor'] = $color_list[$key % 5];
                    $temp['y'] = [
                        strtotime($day_list[$days[$i]]) * 1000, strtotime($day_list[$days[$i] + 1]) * 1000
                    ];
                    array_push($series, $temp);  
                    $p++;
                }  
            }
        }
        $result = [];
        $result['success'] = true;
        $result['series'] = $series;
        $result['total_num'] = $total_num;
        return $result;
    }
}
