<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Response;

use App\Admin;
use App\Business;
use App\FreeLocations;
use App\LogLists;
use App\UserCampaign;
use App\PaymentMethod;
use App\PublicLocations;
use App\DocModel;
use App\DocCat;
use App\PageA;
use App\Banks;
use App\NewsModel;
use App\NewsStatus;
use App\ManageSEO;
use App\SubMails;
use App\GalleryModel;

use File;

use App\Mail\RegisterAdmin;
use App\Mail\NewBusiness;
use App\Mail\SendMailable;
use App\Mail\NotifyAccount;
use App\Mail\ActivateMail;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function admin_login(Request $request){
        if(session('level') == 2){
            return redirect()->route('dashboard');
        }
        else if(session('level') == 3 || session('level') == 4){
            return redirect()->route('manage-admin');
        }
        return view('admin.admin-login');
    }
    public function login(Request $request){
        $user = Admin::where("email",$request['email'])
            ->where("password",$request["password"])
            ->where('level', '>=', 2)
            ->first();
        if(isset($user->email)){
            if($user->status == 1){
                return "Your account is Inactivated";
            }
            else{
                session(['email' => $user->email]);
                session(['user_name' => $user->user_name]);
                session(['user_id' => $user->id]);
                session(['business_name' => $user->business_name]);
                session(['level' => $user->level]);
                if($user->level == 2){
                    $level = 2;
                    $link = 'dashboard';
                }
                else if($user->level > 2){
                    $link = 'manage-user';
                }
                $result = [];
                $result['success'] = 'true';
                $result['link'] = $link;
                return $result;
            }
        }
        else{
            return "fail";
        }
    }
    public function get_admin(Request $request){
        $user_level = session('level');
        if($user_level == 2){
            $users = Admin::where('level', '>=' ,2)
                ->orderby('business_name')
                ->orderby('level')
                ->get();
        }
        else if($user_level == 3){
            $user_id = session('user_id');
            $users = Admin::where('extra', $user_id)
                ->where('level', '!=', 0)
                ->get();
        }
        $data = array();
        foreach($users as $key => $val){
            $temp = [];
            $temp = $val;
            unset($temp['password']);
            if($val['level'] == 4){
                $supervisor = Admin::where('id', $val['extra'])->first();
                if(isset($supervisor->id)){
                    $temp['supervisor'] = $supervisor->user_name;
                    $temp['sup_id'] = $supervisor->id;
                }
            }
            else if($val['level'] == 5){
                $supers = json_decode($val['extra'], true);
                $super_name = "";
                foreach($supers as $super){
                    $supervisor = Admin::where('id', $super)->first();
                    $super_name .= $supervisor->user_name.",";
                }
                $temp['supervisor'] = $super_name;
                $temp['sup_id'] = $val['extra'];
            }
            $data[] = $temp;
        }
        return $data;
    }
    public function get_business(Request $request){
        $business = Admin::groupBy('business_name')
            ->where('level', '>=', 2)
            ->get();
        foreach($business as $key => $val){            
            unset($business[$key]['password']);
        }
        return $business;
    }
    public function get_business_ta(Request $request){
        if(session('level') == 2){
            $business = Admin::groupBy('business_name')
                ->get();
        }
        else if(session('level') == 3){
            $business = DB::table('tbl_user')
                ->leftJoin('tbl_business', 'tbl_business.primary_id', '=', 'tbl_user.id')
                ->select('tbl_user.*', 'tbl_business.address', 'tbl_business.city', 'tbl_business.state', 'tbl_business.zip', 'tbl_business.sales', 'tbl_business.created_at as c_date')
                ->orderBy('tbl_user.business_name')
                ->where('tbl_business.super', session('user_id'))
                ->where('tbl_user.level', 1)
                ->get();
        }
        else if(session('level') == 4){
            $business = DB::table('tbl_user')
                ->leftJoin('tbl_business', 'tbl_business.primary_id', '=', 'tbl_user.id')
                ->select('tbl_user.*', 'tbl_business.address', 'tbl_business.city', 'tbl_business.state', 'tbl_business.zip', 'tbl_business.sales', 'tbl_business.created_at as c_date')
                ->orderBy('tbl_user.business_name')
                ->where('tbl_business.sales', session('user_id'))
                ->where('tbl_user.level', 1)
                ->get();
        }
        else{
            $business = DB::table('tbl_user')
                ->leftJoin('tbl_business', 'tbl_business.primary_id', '=', 'tbl_user.id')
                ->select('tbl_user.*', 'tbl_business.address', 'tbl_business.city', 'tbl_business.state', 'tbl_business.zip', 'tbl_business.sales', 'tbl_business.created_at as c_date')
                ->orderBy('tbl_user.business_name')
                ->where('tbl_business.graphic', session('user_id'))
                ->where('tbl_user.level', 1)
                ->get();
        }
        foreach($business as $key => $val){            
            unset($business[$key]['password']);
        }
        return $business;
    }
    public function get_sales(Request $request){
        if($request['id'] != ""){
            $sales = Admin::where('extra', $request['id'])
                ->where('level', 4)
                ->where('user_lock', 0)
                ->get();
            foreach($sales as $key => $val){            
                unset($sales[$key]['password']);
            }
            return $sales;
        }
        return "";
    }
    public function get_graphic(Request $request){
        if($request['id'] == ""){
            return "";
        }
        $users = Admin::get();
        $data = [];
        foreach($users as $key => $val){
            $extra = [];
            $extra = json_decode($val->extra, true);
            if(is_array($extra) && in_array($request['id'], $extra)){
                $data[] = $val;
            }
        }
        return $data;
    }
    public function get_super(Request $request){
        $super = Admin::where('level', 3)
            ->where('user_lock', 0)
            ->get();
        foreach($super as $key => $val){            
            unset($super[$key]['password']);
        }
        return $super;
    }
    public function new_admin(Request $request){
        $exist = Admin::where('level', '>=', 2)->get();
        if($request['manual'] == 1 && $request['business_name'] == ""){
            return "Please input business name";
        }
        else if($request['manual'] == 0 && $request['business'] == ""){
            return "Please input business name";
        }
        if($request['manual'] == 1){
            $business = $request['business_name'];
        }
        else if($request['manual'] == 0){
            $business = $request['business'];
        }
        foreach($exist as $key => $val){
            if($val->email == $request['email']){
                return "Please input another email";
            }
        }
        if($request['level'] == 4 && !isset($request['super'][0])){
            return "Please select Franchise";
        }
        if($request['level'] == 5 && !isset($request['super'])){
            return "Please select at least one Franchise";
        }
        $admin = new Admin;
        $admin->business_name = $business;
        $admin->user_name = $request['name'];
        $admin->email = $request['email'];
        $admin->level = $request['level'];
        if($request['level'] == 4){
            $admin->extra = $request['super'][0];
        }
        else if($request['level'] == 5){
            $admin->extra = json_encode($request['super']);
        }
        // if(isset($request['super']) && $request['super'] != ""){
        //     $admin->extra = $request['super'];
        // }
        $admin->save();
        $account = Admin::where('id', $admin->id)->first();
        Mail::to($request['email'])->send(new RegisterAdmin($account));
        return 'success';
    }
    public function update_admin(Request $request){
        $exist = Admin::where('id', '!=', $request['id'])
            ->where('level', '>=', 2)
            ->get();
        if($request['manual'] == 1 && $request['business_name'] == ""){
            return "Please input business name";
        }
        else if($request['manual'] == 0 && $request['business'] == ""){
            return "Please input business name";
        }
        if($request['manual'] == 1){
            $business = $request['business_name'];
        }
        else if($request['manual'] == 0){
            $business = $request['business'];
        }
        foreach($exist as $key => $val){
            if($val->email == $request['email']){
                return "Please input another email";
            }
        }
        if($request['level'] == 4 && !isset($request['super'][0])){
            return "Please select Franchise";
        }
        if($request['level'] == 5 && !isset($request['super'])){
            return "Please select at least one Franchise";
        }
        if($request['level'] != 4 && $request['level'] != 5){
            $user = Admin::where('id', $request['id'])
                ->update([
                    'business_name' => $business,
                    'user_name' => $request['name'],
                    'email' => $request['email'],
                    'level' => $request['level']
                ]);
        }
        else{
            $super = $request['level']==4?$request['super'][0]:json_encode($request['super']);
            $user = Admin::where('id', $request['id'])
                ->update([
                    'business_name' => $business,
                    'user_name' => $request['name'],
                    'email' => $request['email'],
                    'level' => $request['level'],
                    'extra' => $super,
                ]);
        }
        return 'success';
    }
    public function delete_admin(Request $request){
        Admin::where('id', $request['id'])
            ->delete();
        return 'success';
    }
    public function lock_user(Request $request){
        $user = Admin::where('id', $request['id'])
            ->first();
        $status = 0;
        if($user->user_lock == 0){
            $status = 1;
        }
        else{

        }
        Admin::where('id', $request['id'])
            ->update([
                'user_lock' => $status
            ]);
        return "success";
    }
    // Manage Business Account
    public function view_business(Request $request){
        if(Session::has('user_id') && (session('level') >= 2 && session('level') <5)){
            $data = array();
            $data['page_name'] = "Manage Business Account";
            $data["check_multi"] = \App::call("App\Http\Controllers\MainController@check_multi");
            return view('admin.business.list', $data);
        }
        else{
            return redirect()->route('login');
        }
    }
    public function business(Request $request){
        if(Session::has('user_id') && (session('level') == 2 || session('level') == 3)){
            $data = array();
            $data["check_multi"] = \App::call("App\Http\Controllers\MainController@check_multi");
            $data['page_name'] = "Create Business Account";
            $sic = DB::table('tbl_sic')->get();
            $data['sic'] = $sic;
            // Supervisor
            if(session('level') == 2){
                $super = DB::table('tbl_user')
                    ->where('level', 3)
                    ->get();
                $data['super'] = $super;
            }
            $data['locations'] = DB::table("tbl_locations")->get();
            return view('admin.business.create', $data);
        }
        else{
            return redirect()->route('login');
        }
    }
    public function create_business(Request $request){
        if(!Session::has('user_id')){
            return redirect()->route('login');
        }
        $trust = DB::table('tbl_user')
            ->where('email', $request['email'])
            ->first();
        if(isset($trust->id)){
            return "Please input another email address";
            // return back()->withErrors(['msg' => "Please input another email address"])->withInput();
        }
        // Add to trust
        $init_date = date_create($request['init_date']);
        if(!$init_date){
            return 'Please input valid initial date';
            return back()->withErrors(['msg' => "Please input valid initial date"])->withInput();
        }
        $super = $request['super'];
        if(session('level') == 3){
            $super = session('user_id');
        }
        $business_name = $request['ad_company'];
        $init_date = date_format($init_date, 'Y-m-d H:i:s');
        $primary_id = DB::table('tbl_user')
            ->insertGetId([
                'user_name' => $request['name'],
                'level' => 1,
                'email' => $request['email'],
                'phone' => $request['phone'],
                'business_name' => $business_name,
                'created_at' => $init_date,
                'user_lock' => 1,
                // 'day_plan' => $request['day_plan'],
            ]);
        $user_id = session('user_id');
        $business = new Business;
        $business->user_id = $user_id;
        $business->primary_id = $primary_id;
        $business->company_name = $business_name;
        $business->address = $request['street'];
        $business->name = $request['name'];
        $business->email = $request['email'];
        $business->suite = $request['suite'];
        $business->phone = $request['phone'];
        // $business->sub_address = $request['city'];
        $business->city = $request['city'];
        $business->state = $request['state'];
        $business->zip = $request['zip'];
        $business->bill_name = $request['bill_name'];
        $business->bill_email = $request['bill_email'];
        $business->bill_phone = $request['bill_phone'];
        $business->category = $request['category'];
        $business->super = $super;
        $business->sales = $request['sales'];
        $business->graphic = $request['graphic'];
        $business->save();
        $business_id = $business->id;
        // Free Location
        if(session('level') == 2){
            FreeLocations::where('business_name', $business_name)->delete();
            if(isset($request['free_location'])){
                foreach($request['free_location'] as $key => $val){
                    $free_location = new FreeLocations;
                    $free_location->business_name = $business_name;
                    $free_location->location_id = $val;
                    $free_location->save();
                }
            }
        }
        // Payment Method
        $controller = app()->make('App\Http\Controllers\InvoiceController');
        app()->call([$controller, 'default_payment_method'], ["business_name" => $business_name]);
        
        $user = DB::table('tbl_user')
            ->leftJoin('tbl_business', 'tbl_user.id', 'tbl_business.primary_id')
            ->where('tbl_business.id', $primary_id)
            ->select('tbl_user.*', 'tbl_business.address', 'tbl_business.zip', 'tbl_business.city', 'tbl_business.state')
            ->first();
        $sales = DB::table('tbl_user')
            ->where('id', $request['sales'])
            ->first();
        // Set Locations
        $public_locations = PublicLocations::where('type', 0)->get();
        DB::table('tbl_location_by_name')->where('business_name', $business_name)->delete();
        foreach($public_locations as $key => $val){
            DB::table("tbl_location_by_name")
                ->INSERT([
                    "location_id" => $val->location_id,
                    "business_name" => $business_name
                ]);
        }
        if(isset($sales->id)){
            Mail::to($sales->email)->send(new NewBusiness($user,$sale, 1)); // 0 : User, 1 : Super
            Mail::to('billing@inex.net')->send(new NewBusiness($user,$sale, 1)); // 0 : User, 1 : Super
            // Notify to sales
            $business = Business::where('primary_id', $business_id)->first();
            try{
                Mail::to($sales->email)->send(new NotifyAccount($business, $sales));
            }
            catch (\Exception $e) {
            }
        }
        return "success";
        return redirect()->route('business-account');
    }
    public function get_business_account(Request $request){
        if(!Session::has('user_id') || session('level') < 2){
            return redirect()->route('login');
        }
        if(session('level') == 2){
            $business = DB::table('tbl_user')
                ->leftJoin('tbl_business', 'tbl_business.primary_id', '=', 'tbl_user.id')
                ->select('tbl_user.*', 'tbl_business.address', 'tbl_business.city', 'tbl_business.state', 'tbl_business.zip', 'tbl_business.sales', 'tbl_business.created_at as c_date')
                ->where('tbl_user.level', 1)
                ->orderBy('tbl_user.business_name')
                ->get();
        }
        else if(session('level') == 3){
            $business = DB::table('tbl_user')
                ->leftJoin('tbl_business', 'tbl_business.primary_id', '=', 'tbl_user.id')
                ->select('tbl_user.*', 'tbl_business.address', 'tbl_business.city', 'tbl_business.state', 'tbl_business.zip', 'tbl_business.sales', 'tbl_business.created_at as c_date')
                ->orderBy('tbl_user.business_name')
                ->where('tbl_business.super', session('user_id'))
                ->where('tbl_user.level', 1)
                ->get();
        }
        else if(session('level') == 4){
            $business = DB::table('tbl_user')
                ->leftJoin('tbl_business', 'tbl_business.primary_id', '=', 'tbl_user.id')
                ->select('tbl_user.*', 'tbl_business.address', 'tbl_business.city', 'tbl_business.state', 'tbl_business.zip', 'tbl_business.sales', 'tbl_business.created_at as c_date')
                ->orderBy('tbl_user.business_name')
                ->where('tbl_business.sales', session('user_id'))
                ->where('tbl_user.level', 1)
                ->get();
        }
        else{
            $business = DB::table('tbl_user')
                ->leftJoin('tbl_business', 'tbl_business.primary_id', '=', 'tbl_user.id')
                ->select('tbl_user.*', 'tbl_business.address', 'tbl_business.city', 'tbl_business.state', 'tbl_business.zip', 'tbl_business.sales', 'tbl_business.created_at as c_date')
                ->orderBy('tbl_user.business_name')
                ->where('tbl_business.graphic', session('user_id'))
                ->where('tbl_user.level', 1)
                ->get();
        }
        $result = [];
        $campaigns = UserCampaign::leftjoin('tbl_user', 'tbl_user.id', 'tbl_user_campaign.user_id')
            ->leftjoin('tbl_invoice', 'tbl_invoice.campaign_id', 'tbl_user_campaign.id')
            ->select('tbl_user.business_name', 'tbl_invoice.*', 'tbl_user_campaign.end_date')
            ->get();
        $today = date("Y-m-d");
        $avaiable_name = [];
        foreach($campaigns as $key => $val){
            if($val->status == 1 && $val->end_date > $today){
                in_array($val->business_name, $avaiable_name)?"":$avaiable_name[] = $val->business_name;
            }
            if($val->status == 0 && $val->invoice_date > $today){
                in_array($val->business_name, $avaiable_name)?"":$avaiable_name[] = $val->business_name ;
            }
        }
        $list_name = [];
        foreach($business as $key => $val){
            if(!in_array($val->business_name, $list_name) && $val->level == 1){
                array_push($list_name, $val->business_name);
                // Change date format
                $originalDate = $val->c_date;
                $val->c_date = date("m-d-Y g:i a", strtotime($originalDate));
                $val->camp_status=in_array($val->business_name, $avaiable_name)?1:0;
                // Sales Man (Account Manager)
                $account = DB::table('tbl_user')->where('id', $val->sales)->first();
                $val->sales_name = isset($account->id)?$account->user_name:"";
                $result[] = $val;
            }
        }
        $data['data'] = $result;
        return $data;
    }
    public function edit_business(Request $request){
        if(Session::has('user_id') && ((session('level') >= 2) || (session('level') == 1 && $request['id'] == base64_encode(session('user_id'))))){
            $data = array();
            $data["check_multi"] = \App::call("App\Http\Controllers\MainController@check_multi");
            if(session('level') >= 2){
                $data['page_name'] = "Update Business Account";
            }
            else{
                $data['page_name'] = "Our Business Information";
            }
            $sic = DB::table('tbl_sic')->get();
            $data['sic'] = $sic;
            $user_id = base64_decode($request['id']);
            // Supervisor
            if(session('level') == 2){
                $super = DB::table('tbl_user')
                    ->where('level', 3)
                    ->where('user_lock', 0)
                    ->get();
                $data['super'] = $super;
            }
            $trust = DB::table('tbl_user')
                ->where('id', $user_id)
                ->first();
            if(!isset($trust->business_name)){
                return back()->withErrors(['msg' => "Invalid URL"])->withInput();
            }
            $business_name = $trust->business_name;
            $data['init_date'] = $trust->created_at;
            // Locations
            $data['locations'] = DB::table("tbl_locations")
                ->orderby('name')
                ->get();
            // Free Locations
            $data['free_locations'] = FreeLocations::where('business_name', $business_name)->get();
            $locations = DB::table('tbl_location_by_name')
                ->where("business_name", $business_name)
                ->get();
            $data['temp_location'] = $locations;
            $user = DB::table('tbl_business')
                ->where('primary_id', $user_id)
                ->first();
            $data['trust'] = $trust;
            $data['user'] = $user;
            $data['user_id'] = $user_id;
            return view('admin.business.update', $data);
        }
        else{
            return redirect()->route('login');
        }
    }
    public function update_business(Request $request){
        if(!Session::has('user_id')){
            return redirect()->route('login');
        }
        // $messages = [
        //     "ad_company.required" => "Advertising Company is required",
        //     "street.required" => "Street Address is required",
        //     "name.required" => "Contact Name is required",
        //     "phone.required" => "Contact Phone is required",
        //     "city.required" => "Address is required",
        //     "email.required" => "Please input validate Contact Email",
        //     "bill_name.required" => "Billing Contact is required",
        //     "bill_email.required" => "Please input validate Billing Contact Email",
        //     "category.required" => "Category is required",
        //     "bill_phone.required" => "Billing Contact Phone is required",
        // ];
        // $validator = Validator::make($request->all(), [
        //     'ad_company' => 'required',
        //     'street' => 'required',
        //     'name' => 'required',
        //     'phone' => 'required',
        //     'city' => 'required',
        //     'email' => 'required|email',
        //     'bill_name' => 'required',
        //     'bill_email' => 'required|email',
        //     'category' => 'required',
        //     'bill_phone' => 'required',
        // ], $messages);
        // if ($validator->fails()) {
        //     return back()->withErrors($validator)->withInput();
        // }
        $current = DB::table('tbl_user')
            ->where('id', $request['id'])
            ->first();
        $trust = DB::table('tbl_user')
            ->where('email', $request['email'])
            ->where('password', '!=', null)
            ->where('id','!=', $request['id'])
            ->first();
        if(isset($trust->id)){
            return "Please input another email address";
            return back()->withErrors(['msg' => "Please input another email address"])->withInput();
        }
        // Update trust
        $init_date = date_create($request['init_date']);
        if(!$init_date){
            return "Please input valid initial date";
            return back()->withErrors(['msg' => "Please input valid initial date"])->withInput();
        }
        $init_date = date_format($init_date, 'Y-m-d H:i:s');
        if(isset($current->id) && $current->email != $request['email']){
            Mail::to($request->email)->send(new SendMailable($current->id, $current));
        }
        DB::table('tbl_user')
            ->where('id', $request['id'])
            ->update([
                'user_name' => $request['name'],
                'level' => 1,
                'email' => $request['email'],
                'phone' => $request['phone'],
                'business_name' => $request['ad_company'],
                'created_at' => $init_date,
                // 'day_plan' => $request['day_plan'],
            ]);
        $user_id = session('user_id');
        $exist = Business::where('primary_id', $request['id'])->first();
        $super = $request['super'];
        // Free Location
        if(session('level') == 2){
            FreeLocations::where('business_name', $request['ad_company'])->delete();
            if(isset($request['free_location'])){
                foreach($request['free_location'] as $key => $val){
                    $free_location = new FreeLocations;
                    $free_location->business_name = $request['ad_company'];
                    $free_location->location_id = $val;
                    $free_location->save();
                }
            }
        }
        // $location_list = explode(',', $request['location_list']);
        // DB::table('tbl_location_by_name')
        //     ->where("business_name",$request['ad_company'])
        //     ->delete();
        // foreach($location_list as $temp){
        //     if($temp != "" && $temp != 0){
        //         DB::table('tbl_location_by_name')
        //             ->INSERT([
        //                 "business_name" => $request['ad_company'],
        //                 "location_id" => $temp
        //             ]);
        //     }
        // }
        if(session('level') == 3){
            $super = session('user_id');
        }
        if(isset($exist->id)){
            if(session('level') < 2){
                Business::where('primary_id', $request['id'])
                    ->update([
                        'company_name' => $request['ad_company'],
                        'address' => $request['street'],
                        'name' => $request['name'],
                        'email' => $request['email'],
                        'suite' => $request['suite'],
                        'phone' => $request['phone'],
                        'city' => $request['city'],
                        'state' => $request['state'],
                        'zip' => $request['zip'],
                        'bill_name' => $request['bill_name'],
                        'bill_email' => $request['bill_email'],
                        'bill_phone' => $request['bill_phone'],
                        'category' => $request['category'],
                    ]);
            }
            else{
                Business::where('primary_id', $request['id'])
                    ->update([
                        'company_name' => $request['ad_company'],
                        'address' => $request['street'],
                        'name' => $request['name'],
                        'email' => $request['email'],
                        'suite' => $request['suite'],
                        'phone' => $request['phone'],
                        'city' => $request['city'],
                        'state' => $request['state'],
                        'zip' => $request['zip'],
                        'bill_name' => $request['bill_name'],
                        'bill_email' => $request['bill_email'],
                        'bill_phone' => $request['bill_phone'],
                        'category' => $request['category'],
                        'super' => $super,
                        'sales' => $request['sales'],
                        'graphic' => $request['graphic'],
                    ]);
            }
            $business_id = $request['id'];
        }
        else{
            $business = new Business;
            $business->user_id = $user_id;
            $business->primary_id = $request['id'];
            $business->company_name = $request['ad_company'];
            $business->address = $request['street'];
            $business->name = $request['name'];
            $business->email = $request['email'];
            $business->suite = $request['suite'];
            $business->phone = $request['phone'];
            $business->city = $request['city'];
            $business->state = $request['state'];
            $business->zip = $request['zip'];
            $business->bill_name = $request['bill_name'];
            $business->bill_email = $request['bill_email'];
            $business->bill_phone = $request['bill_phone'];
            $business->category = $request['category'];
            if(session('level') >= 2){
                $business->super = $super;
                $business->sales = $request['sales'];
                $business->graphic = $request['graphic'];
            }
            $business->save();
            $business_id = $business->id;
        }
        if($request['sales'] != ''){
            $sale = DB::table('tbl_user')->where('id', $request['sales'])->first();
            $business = Business::where('primary_id', $business_id)->first();
            try{
                if(isset($sale->id)){
                    // Mail::to($sale->email)->send(new NotifyAccount($business, $sale));
                }
            }
            catch (\Exception $e) {
            }
        }
        return 'success';
        return redirect()->route('business-account');
    }
    // Create Blank Template
    public function create_blank_template($business_name){
        $exist = DB::table('tbl_template')
            ->where('template_name', $business_name." - Full Screen")
            ->first();
        $locations = DB::table('tbl_locations')->get();
        $location_name = [];
        foreach($locations as $key => $val){
            $location_name[] = $val->name;
        }
        if(!isset($exist->id)){
            $temp_id = DB::table("tbl_template")
                ->insertGetId([
                    "business_name" => $business_name,
                    "template_name" => $business_name." - Full Screen",
                    "location" => json_encode($location_name),
                    "bg_img" => 'blank_Template.png',
                    "over_w" => 576,
                    "over_h" => 384,
                    "over_l" => 0,
                    "over_t" => 0,
                    "font_s" => 12,
                    "font_c" => "#000000",
                    "font_w" => 400,
                    "font_t" => 0,
                    "font_l" => 0,
                    "font_r" => 1,
                    "align" => 'Left',
                    "t_limit" => 45,
                    "primary" => 0,
                    "dis_text" => 1,
                    "over_img" => 'blank_Template.png'
            ]);
            return "Success";
        }
        return "Already Exist";
    }
    public function update_status(Request $request){
        $status = 0;
        $user_id = $request['id'];
        $user = DB::table('tbl_user')
            ->leftJoin('tbl_business', 'tbl_user.id', 'tbl_business.primary_id')
            ->where('tbl_business.primary_id', $user_id)
            ->select('tbl_user.*', 'tbl_business.address', 'tbl_business.zip', 'tbl_business.city', 'tbl_business.state')
            ->first();
        if($request['status'] == 0){
            $status = 1;
        }
        else{
            if(isset($user->id)){
                $business_name = $user->business_name;
                $this->create_blank_template($business_name);
            }
            // Send to Client
            $business = Business::where('primary_id', $user->id)->first();
            if($business->sales != null){
                $account_manager = DB::table('tbl_user', $business->sales)->first();
                Mail::to($user->email)->send(new NewBusiness($user,$account_manager, 0)); // 0 : User, 1 : Super
            }
            // Notify to Account Manager
            if(isset($business->id)){
                $account_manager = DB::table('tbl_user')
                    ->where('id', $business->sales)
                    ->first();
                if(isset($account_manager->id)){
                    Mail::to($user->email)->send(new ActivateMail($user, $account_manager));
                }
                try{
                    Mail::to($account_manager->email)->send(new NewBusiness($user, $account_manager, 1));
                }
                catch (\Exception $e) {
                }
            }
        }
        DB::table('tbl_user')
            ->where('id', $user_id)
            ->update([
                'user_lock' => $status
            ]);
        return "success";
    }
    public function delete_business(Request $request){
        $user_id = $request['id'];
        // $exist = DB::table('tbl_user')
        //     ->where('id', $request['id'])
        //     ->first();
        DB::table('tbl_user')
            ->where('id', $request['id'])
            ->delete();
        DB::table('tbl_business')
            ->where('primary_id', $request['id'])
            ->delete();
        return "success";
    }
    public function active_business(Request $request){
        $user_id = $request['id'];
        DB::table('tbl_user')
            ->where('id', $user_id)
            ->update([
                'user_lock' => 0
            ]);
        $user = DB::table('tbl_user')
            ->leftJoin('tbl_business', 'tbl_user.id', 'tbl_business.primary_id')
            ->where('tbl_business.id', $user_id)
            ->select('tbl_user.*', 'tbl_business.address', 'tbl_business.zip', 'tbl_business.city', 'tbl_business.state')
            ->first();
        if(isset($user->id)){
            $business_name = $user->business_name;
            $this->create_blank_template($business_name);
            $business = Business::where('primary_id', $user->id)->first();
            $account_manager = "";
            if($business->sales != null){
                $account_manager = DB::table('tbl_user', $business->sales)->first();
            }
            Mail::to($user->email)->send(new NewBusiness($user,$account_manager, 0)); // 0 : User, 1 : Super
        }
        return redirect()->back()->withSuccess("Success");
    }
    // Location
    public function update_location(Request $request){
        if(Session::has('user_id') && (session('level') >= 2)){
            // $id = base64_decode($request['id']);
            $id = $request['id'];
            $exist = DB::table('tbl_business')
                ->where('primary_id', $id)
                ->first();
            if(isset($exist->id)){
                DB::table('tbl_business')
                    ->where('primary_id', $request['id'])
                    ->update([
                        'address' => $request['address'],
                        'city' => $request['city'],
                        'state' => $request['state'],
                        'zip' => $request['zip'],
                    ]);
                return 'success';
            }
            else{
                // return redirect()->back()->withErrors([
                //     'message' => 'Please add the account information before update the location',
                // ]);
                return "Please add the account information before update the location";
            }
        }
        else{
            return redirect()->route('login');
        }
    }
    // Welcome
    public function welcome(Request $request){
        if(Session::has('user_id') && session('level') == 1){
            $data = [];
            $data['page_name'] = "Welcome";
            $sic = DB::table('tbl_sic')->get();
            $data["social"] = \App::call("App\Http\Controllers\MainController@get_social");
            $data['s_avalialbe'] = \App::call("App\Http\Controllers\MainController@get_social_avail");
            $data["user"] = \App::call("App\Http\Controllers\MainController@get_account");
            $data['business'] = Business::where('primary_id', session('user_id'))->first();
            $data['sic'] = $sic;
            $today = date("Y-m-d");
            $data['logs'] = LogLists::where('user_id', session('user_id'))
                ->whereDate('created_at', $today)
                ->get();
            return view('auth.welcome', $data);
        }
        else{
            return redirect()->route('login');
        }
    }
    public function get_primary_info(Request $request){
        if(!Session::has('user_id')){
            return "Please login first";
        }
        $data = [];
        $business = Business::where('primary_id', session('user_id'))->first();
        if(isset($business->id)){
            $data['name'] = $business->name;
            $data['email'] = $business->email;
            $data['phone'] = $business->phone;
            return $data;
        }
        else{
            $user = DB::table('tbl_user')
                ->where('id', session('user_id'))->first();
            $data['name'] = $user->user_name;
            $data['email'] = $user->email;
            $data['phone'] = $user->phone;
            return $data;
        }
    }
    public function save_welcome(Request $request){
        if(!Session::has('user_id')){
            return "Please login first";
        }
        Business::where('primary_id', session('user_id'))
            ->update([
                'bill_name' => $request['bill_name'],
                'bill_email' => $request['bill_email'],
                'bill_phone' => $request['bill_phone'],
                'category' => $request['category'],
            ]);
        if($request['user_name'] != "" && $request['email'] != ""){
            DB::table('tbl_user')
                ->insert([
                    'business_name' => session('business_name'),
                    'user_name' => $request['user_name'],
                    'email' => $request['email'],
                    'level' => 0
                ]);
        }
        $data = [];
        $data['success'] = true;
        LogLists::where('user_id', session('user_id'))
            ->update([
                'welcome' => 1
            ]);
        $data['redirect'] = "/graphic-design";
        return $data;
    }
    // New Accounts
    public function view_new_accounts(Request $request){
        if(!Session::has('user_id') || session('level') != 2){
            return back()->withErrors(['msg' => "You can't access to this page"])->withInput();
        }
        $data = array();
        $data['page_name'] = "New Accounts";
        $data['accounts'] = DB::table('tbl_user')
            ->leftjoin('tbl_business', 'tbl_business.primary_id', 'tbl_user.id')
            ->select('tbl_user.*', 'tbl_business.address', 'tbl_business.city','tbl_business.sales', 'tbl_business.created_at as reg_date')
            // ->where('tbl_user.level', 1)
            ->where('tbl_user.user_lock', 1)
            ->where('tbl_business.sales', null)
            ->orderby('tbl_user.id', 'desc')
            ->get();
        $data['manager'] = DB::table('tbl_user')
            ->where('level', 4)->get();
        return view('admin.business.new-accounts', $data);
    }
    public function assign_account(Request $request){
        Business::where('primary_id', $request->user_id)
            ->update([
                'sales' => $request['account_id']
            ]);
        $business = Business::where('primary_id', $request['user_id'])->first();
        $sales = DB::table('tbl_user')->where('id', $request['account_id'])->first();
        try{
            if(isset($sales->id)){
                Mail::to($sales->email)->send(new NotifyAccount($business, $sales));
            }
        }
        catch (\Exception $e) {
        }
        return "success";
    }
    // Training
    public function training_view(Request $request){
        if(!Session::has('user_id')){
            return back()->withErrors(['msg' => "You can't access to this page"])->withInput();
        }
        $data = array();
        $data['cate'] = DocCat::get();
        $data['docs'] = DocModel::leftjoin('tbl_doc_cat', 'tbl_doc.cate', 'tbl_doc_cat.id')
            ->select("tbl_doc.*", "tbl_doc_cat.name as cate_name", "tbl_doc_cat.id as cat_id")
            ->where('tbl_doc.cate', $request['id'])
            ->get();
        $data['business_name'] = \App::call("App\Http\Controllers\MainController@get_business_name_by_session");
        if(session('level') < 2){
            $data['docs'] = DocModel::leftjoin('tbl_doc_cat', 'tbl_doc.cate', 'tbl_doc_cat.id')
                ->select("tbl_doc.*", "tbl_doc_cat.name as cate_name", "tbl_doc_cat.id as cat_id")
                ->where('tbl_doc.private', 1)
                ->where('tbl_doc.cate', $request['id'])
                ->get();
        }
        $data['page_name'] = "Advertising Tools";
        return view('admin.resource.training', $data);
    }
    public function manage_resource(Request $request){
        if(!Session::has('user_id') || Session('level') != 2){
            return back()->withErrors(['msg' => "You can't access to this page"])->withInput();
        }
        $data = array();
        $data['cate'] = DocCat::get();
        $data['docs'] = DocModel::leftjoin('tbl_doc_cat', 'tbl_doc.cate', 'tbl_doc_cat.id')
            ->select("tbl_doc.*", "tbl_doc_cat.name as cate_name", "tbl_doc_cat.id as cat_id")
            ->get();
        $data['business_name'] = \App::call("App\Http\Controllers\MainController@get_business_name_by_session");
        if(session('level') < 2){
            $data['docs'] = DocModel::leftjoin('tbl_doc_cat', 'tbl_doc.cate', 'tbl_doc_cat.id')
                ->select("tbl_doc.*", "tbl_doc_cat.name as cate_name", "tbl_doc_cat.id as cat_id")
                ->where('private', 1)
                ->get();
        }
        $data['page_name'] = "Manage Documents";
        return view('admin.resource.manage-training', $data);
    }
    public function get_docs(Request $request){
        $docs = DocModel::leftjoin('tbl_doc_cat', 'tbl_doc.cate', 'tbl_doc_cat.id')
            ->select("tbl_doc.*", "tbl_doc_cat.name as cate_name", "tbl_doc_cat.id as cat_id")
            ->get();
        return $docs;
    }
    public function detail_doc(Request $request){
        if(!Session::has('user_id') || Session('level') != 2){
            return "You can't access to this page";
        }
        $doc = DocModel::where('id', $request['id'])->first();
        $result = [];
        if(isset($doc->id)){
            $result['success'] = true;
            $result['data'] = $doc;
            return $result;
        }
        $result['success'] = false;
        return $result;
    }
    public function new_doc(Request $request){
        $file_name = "";
        if($request->file('file') != null){
            $file_name = uniqid();
            $extension = $request->file('file')->extension();
            Storage::putFileAs('upload', $request->file('file'), $file_name.".".$extension);
            $request->file('file')->move(public_path('doc'), $file_name.".".$extension);
            $file_name = $file_name.".".$extension;
        }
        $img_name = "";
        if($request->file('img') != null){
            $img_name = uniqid();
            $extension = $request->file('img')->extension();
            Storage::putFileAs('upload', $request->file('img'), $img_name.".".$extension);
            $request->file('img')->move(public_path('doc'), $img_name.".".$extension);
            $img_name = $img_name.".".$extension;
        }
        // Category
        $cate_type = $request['cate_type'];
        // Categroy
        if($cate_type == 0){
            $cate_id = $request['cate'];
        }
        else{
            $cate = DocCat::where('name', $request['cate_name'])->first();
            if(isset($cate->id)){
                $cate_id = $cate->id;
            }
            else{
                $category = new DocCat;
                $category->name = $request['cate_name'];
                $category->save();
                $cate_id = $category->id;
            }
        }
        $doc = new DocModel;
        $doc->name = $request['name'];
        $doc->cate = $cate_id;
        $doc->extra = $request['extra'];
        $doc->private = $request['private'];
        $doc->file_name = $file_name;
        $doc->img = $img_name;
        $doc->save();
        return "success";
    }
    public function update_doc(Request $request){
        $file_name = "";
        if($request->file('file') != null){
            $file_name = uniqid();
            $extension = $request->file('file')->extension();
            Storage::putFileAs('upload', $request->file('file'), $file_name.".".$extension);
            $request->file('file')->move(public_path('doc'), $file_name.".".$extension);
            $file_name = $file_name.".".$extension;
        }
        $img_name = "";
        if($request->file('img') != null){
            $img_name = uniqid();
            $extension = $request->file('img')->extension();
            Storage::putFileAs('upload', $request->file('img'), $img_name.".".$extension);
            $request->file('img')->move(public_path('doc'), $img_name.".".$extension);
            $img_name = $img_name.".".$extension;
        }
        // Category
        $cate_type = $request['cate_type'];
        // Categroy
        if($cate_type == 0){
            $cate_id = $request['cate'];
        }
        else{
            $cate = DocCat::where('name', $request['cate_name'])->first();
            if(isset($cate->id)){
                $cate_id = $cate->id;
            }
            else{
                $category = new DocCat;
                $category->name = $request['cate_name'];
                $category->save();
                $cate_id = $category->id;
            }
        }
        if($file_name != ""){
            DocModel::where('id', $request['id'])
                ->update([
                    'file_name' => $file_name
                ]);
        }
        if($img_name != ""){
            DocModel::where('id', $request['id'])
                ->update([
                    'img' => $img_name
                ]);
        }
        DocModel::where('id', $request['id'])
            ->update([
                'name' => $request['name'],
                "cate" => $cate_id,
                "extra" => $request['extra'],
                "private" => $request['private'],
            ]);
        return "success";
    }
    public function delete_doc(Request $request){
        DocModel::where('id', $request['id'])->delete();
        return "success";
    }
    public function share_doc(Request $request){
        try{
            $mailData = $request;
            $mailData['mail'] = 'sales@inex.net';

            $contactContent = array('contactusbody' =>  $request['body']);
            $doc = DocModel::where('id', $request['id'])->first();
            $mailData['attach'] = $doc->file_name;
            $users = DB::table('tbl_user')
                ->where('business_name', $request['business_name'])
                ->whereIn('level', [0, 1])
                ->get();
            foreach($users as $item){
                $mailData['user_email'] = $item->email;

                Mail::send( ['html' => 'mail.ShareEmail'] ,$contactContent,
                function($message) use ($mailData)
                {
                    if($mailData['attach'] != ""){
                        $message
                            ->from($mailData['mail'])
                            ->to($mailData['user_email'])
                            ->replyTo($mailData['mail'])
                            ->attach("doc/".$mailData['attach'])
                            ->subject($mailData['subject']);
                    }
                    else{
                        $message
                            ->from($mailData['mail'])
                            ->to($mailData['user_email'])
                            ->replyTo($mailData['mail'])
                            ->attach("doc/".$mailData['attach'])
                            ->subject($mailData['subject']);
                    }
                });
            }
            return "success";
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function doc_view(Request $request){
        $id = base64_decode($request['name']);
        $doc = DocModel::where('id', $id)
            ->first();
        if(!isset($doc->id)){
            return redirect()->back()->withErrors("Invalid document url.");
        }
        $file_name = $doc->file_name;
        // $file_name = $request['name'];
        $file = public_path().'/doc/'.$file_name;
        $doc = DocModel::where('file_name', $file_name)
            ->first();
        if($doc->private == 0 && session('level') < 2){
            return redirect()->back()->withErrors("You don't have permission to view this documents");
        }
        try{
            $file = File::get($file);
            $response = Response::make($file,200);
            $response->header('Content-Type', 'application/pdf');
            return $response;
        }
        catch (\Exception $e) {
            return redirect()->back()->withErrors("Invalid URL");
        }
    }
    // Manage PA
    public function manage_pa(Request $request){
        if(!Session::has('user_id') || session('level') != 2){
            return back()->withErrors(['msg' => "You can't access to this page"])->withInput();
        }
        $data = array();
        $data['page_name'] = "Manage Page Announcements";
        $data['pa'] = PageA::get();
        return view('admin.pa.manage', $data);
    }
    public function new_pa(Request $request){
        $exist = PageA::where('page_id', $request['page_id'])->first();
        if(isset($exist->id)){
            return "You already set up the Page Announcement about this page. Please don't creat and update existing items.";
        }
        $file_name = "";
        if($request->file('file') != null){
            $file_name = uniqid();
            $extension = $request->file('file')->extension();
            Storage::putFileAs('upload', $request->file('file'), $file_name.".".$extension);
            $request->file('file')->move(public_path('pdf'), $file_name.".".$extension);
            $file_name = $file_name.".".$extension;
        }
        $pa = new PageA;
        $pa->page_id = $request['page_id'];
        if($file_name != ""){
            $pa->attachment = $file_name;
        }
        $pa->save();
        return "success";
    }
    public function update_pa(Request $request){
        PageA::where('id', $request['id'])
            ->update([
                'page_id' => $request['page_id']
            ]);
        $file_name = "";
        if($request->file('file') != null){
            $file_name = uniqid();
            $extension = $request->file('file')->extension();
            Storage::putFileAs('upload', $request->file('file'), $file_name.".".$extension);
            $request->file('file')->move(public_path('pdf'), $file_name.".".$extension);
            $file_name = $file_name.".".$extension;
            PageA::where('id', $request['id'])
                ->update([
                    'attachment' => $file_name
                ]);
        }
        return "success";
    }
    public function get_pa(Request $request){
        $id = $request['id'];
        $page = PageA::where('id', $id)->first();
        if(isset($page->id)){
            $res = array();
            $res['success'] = true;
            $res['data'] = $page;
            return $res;
        }
        else{
            return "Invalid PA";
        }
    }
    public function delete_pa(Request $request){
        if(!Session::has('user_id') || session('level') != 2){
            return redirect('login');
        }
        PageA::where('id', $request['id'])->delete();
        return "success";
    }
    public function list_pa(Request $request){
        $pages = PageA::get();
        return $pages;
    }
    // Add Bank
    public function add_bank(Request $request){
        if(!Session::has('user_id') || session('level') < 2){
            return redirect('login');
        }
        $user_id = session('user_id');
        $data = [];
        $data['page_name'] = "Account Administration";
        $bank = Banks::where('user_id', $user_id)->first();
        $stripe = new \Stripe\StripeClient(
            config('app.st_sec')
        );
        $account = '';
        try{
            if(isset($bank->id)){
                $account = $stripe->accounts->retrieve(
                    $bank->extra,
                    []
                );
            }
        }
        catch(\Stripe\Exception\CardException $e) {}
        catch (\Stripe\Exception\RateLimitException $e) {} 
        catch (\Stripe\Exception\InvalidRequestException $e) {} 
        catch (\Stripe\Exception\AuthenticationException $e) {} 
        catch (\Stripe\Exception\ApiConnectionException $e) {} 
        catch (\Stripe\Exception\ApiErrorException $e) {} 
        catch (Exception $e) {}
        $data['bank'] = $bank;
        $data['account'] = $account;
        return view('admin.bank.add-bank', $data);
    }
    public function save_bank(Request $request){
        $user_id = session('user_id');
        $exist = Banks::where('user_id', $user_id)->first();
        // Add Bank in stripe
        $phone = str_replace("(", "", $request['phone']);
        $phone = str_replace(" ", "", $phone);
        $phone = str_replace("-", "", $phone);
        $phone = str_replace(")", "", $phone);
        $account_id = "";

        $stripe = new \Stripe\StripeClient(
            config('app.st_sec')
        );
        $time=strtotime($request['birth']);
        $month=date("m",$time);
        $year=date("Y",$time);
        $date=date("d",$time);
        // Upload Document for Front end and Back End
        $file_name_front = "";
        $file_name_back = "";
        if($request->file('frontDocument') != null){
            $file_name = uniqid();
            $extension = $request->file('frontDocument')->extension();
            Storage::putFileAs('upload', $request->file('frontDocument'), $file_name.".".$extension);
            $request->file('frontDocument')->move(public_path('document'), $file_name.".".$extension);
            $file_name_front = $file_name.".".$extension;
        }
        if($request->file('backDocument') != null){
            $file_name = uniqid();
            $extension = $request->file('backDocument')->extension();
            Storage::putFileAs('upload', $request->file('backDocument'), $file_name.".".$extension);
            $request->file('backDocument')->move(public_path('document'), $file_name.".".$extension);
            // $file_name_back = $file_name.".".$extension;
            $file_name_back = $file_name.".".$extension;
        }
        $fp = fopen(base_path().'/public/document/'.$file_name_front, 'r');
        $file_1 = $stripe->files->create([
            'purpose' => 'identity_document',
            'file' => $fp
        ]);
        $fp_2 = fopen(base_path().'/public/document/'.$file_name_back, 'r');
        $file_2 = $stripe->files->create([
            'purpose' => 'identity_document',
            'file' => $fp_2
        ]);
        // Exist
        $exist_flag = false;
        if(isset($exist->extra) && $exist->extra != null){
            try{
                $exist_stripe = $stripe->accounts->retrieve(
                    $exist->extra,
                    []
                );
                if(isset($exist_stripe->id)){
                    $exist_flag = true;
                    $account_id = $exist->extra;
                    try{
                        $stripe->accounts->update(
                            $exist->extra,
                            [
                                // 'business_type' => $request['business_type']
                            'email' => $request['email'],
                            'business_type' => 'individual',
                                "individual" => [
                                    "first_name" => $request['first_name'],
                                    "last_name" => $request['last_name'],
                                    "phone"=> "+1".$phone,
                                    'email' => $request['email'],
                                    "address" => [
                                        "city"=> $request['city'],
                                        "country"=> "US",
                                        "line1"=> $request['address'],
                                        "postal_code"=> $request['zip'],
                                        "state"=> "OK"
                                    ],
                                    "dob" => [
                                        "day" => $date,
                                        "month" => $month,
                                        "year" => $year
                                    ],
                                    // "id_number" => 123131185,
                                    "ssn_last_4" => $request['ssn'],
                                    // "verification" => [
                                    //     "document" => [
                                    //         "front" => $file_1->id,
                                    //         "back" => $file_2->id,
                                    //     ]
                                    // ],
                                ],
                                "business_profile"=> [
                                    'mcc' => '7311',
                                    "url"=> "https://inex.net"
                                ],
                                "external_account" => [
                                    "account_holder_name" => $request['first_name'] ." ".$request['last_name'],
                                    "object" => "bank_account",
                                    "country" => "US",
                                    "currency" => "usd",
                                    "routing_number" => $request['route_number'],
                                    "account_number" => $request['account_number'],
                                ],
                                'capabilities' => [
                                    'card_payments' => ['requested' => true],
                                    'transfers' => ['requested' => true],
                                    'bancontact_payments' => ['requested' => true] 
                                ],
                            ]
                        );
                    }
                    catch(\Stripe\Exception\CardException $e) {
                        return $e->getError()->message;
                    }
                    catch (\Stripe\Exception\RateLimitException $e) {
                        return $e->getError()->message;
                    } catch (\Stripe\Exception\InvalidRequestException $e) {
                        return $e->getError()->message;
                    } catch (\Stripe\Exception\AuthenticationException $e) {
                        return $e->getError()->message;
                    } catch (\Stripe\Exception\ApiConnectionException $e) {
                        return $e->getError()->message;
                    } catch (\Stripe\Exception\ApiErrorException $e) {
                        return $e->getError()->message;
                    } catch (Exception $e) {
                        return $e->getError()->message;
                    }
                }
            }
            catch(\Stripe\Exception\CardException $e) {
                return $e->getError()->message;
            }
            catch (\Stripe\Exception\RateLimitException $e) {
                return $e->getError()->message;
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                return $e->getError()->message;
            } catch (\Stripe\Exception\AuthenticationException $e) {
                return $e->getError()->message;
            } catch (\Stripe\Exception\ApiConnectionException $e) {
                return $e->getError()->message;
            } catch (\Stripe\Exception\ApiErrorException $e) {
                return $e->getError()->message;
            } catch (Exception $e) {
                return $e->getError()->message;
            }
        }
        if( $exist_flag == false){
            try{
                // $stripe_data = [];
                // if($request['business_type'] == 'individual'){
                //     $strupe_data['business_type'] = $request['business_type'];
                //     $individual['first_name'] = $request['first_name'];
                //     $individual['last_name'] = $request['last_name'];
                //     $individual['phone'] = "+1".$phone;
                //     $individual['email'] = $request['email'];
                //     $individual_address = [
                //         "city"=> $request['city'],
                //         "country"=> "US",
                //         "postal_code"=> $request['zip'],
                //         "state"=>  $request['state']
                //     ];
                // }
                $account = $stripe->accounts->create([
                    'type' => 'custom',
                    'country' => 'US',
                    'email' => $request['email'],
                    'business_type' => 'individual',
                    "individual" => [
                        "first_name" => $request['first_name'],
                        "last_name" => $request['last_name'],
                        "phone"=> "+1".$phone,
                        'email' => $request['email'],
                        "dob" => [
                            "day" => $date,
                            "month" => $month,
                            "year" => $year
                        ],
                        "address" => [
                            "city"=> $request['city'],
                            "country"=> "US",
                            "line1"=> $request['address'],
                            "postal_code"=> $request['zip'],
                            "state"=> "OK"
                        ],
                        // "id_number" => 123131185,
                        "ssn_last_4" => $request['ssn'],
                        "verification" => [
                            "document" => [
                                "front" => $file_1->id,
                                "back" => $file_2->id,
                            ]
                        ],
                    ],
                    "business_profile"=> [
                        'mcc' => '7311',
                        "url"=> "https://inex.net"
                    ],
                    // "business_profile"=> [
                    //     'mcc' => '7311',
                    //     "support_address"=> [
                    //     "country"=> "US",
                    //     "state"=> "CA"
                    //     ],
                    //     "support_email"=> $request['email'],
                    //     "support_phone"=> "+1".$phone,
                    //     "url"=> "https://inex.net"
                    // ],
                    'capabilities' => [
                        'card_payments' => ['requested' => true],
                        'transfers' => ['requested' => true],
                        'bancontact_payments' => ['requested' => true] 
                    ],
                    "documents" => [
                        "bank_account_ownership_verification" =>  [
                            "files" => [$file_1->id]
                        ]
                    ],
                    "external_account" => [
                        "account_holder_name" => $request['first_name'] ." ".$request['last_name'],
                        "object" => "bank_account",
                        "country" => "US",
                        "currency" => "usd",
                        "routing_number" => $request['route_number'],
                        "account_number" => $request['account_number'],
                    ]
                ]);
                $account_id = $account->id;
                $account = $stripe->accounts->update(
                    $account->id,
                    ['tos_acceptance' => ['date' => 1609798905, 'ip' => '8.8.8.8']]
                );
            }
            catch(\Stripe\Exception\CardException $e) {
                return $e->getError()->message;
            }
            catch (\Stripe\Exception\RateLimitException $e) {
                return $e->getError()->message;
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                return $e->getError()->message;
            } catch (\Stripe\Exception\AuthenticationException $e) {
                return $e->getError()->message;
            } catch (\Stripe\Exception\ApiConnectionException $e) {
                return $e->getError()->message;
            } catch (\Stripe\Exception\ApiErrorException $e) {
                return $e->getError()->message;
            } catch (Exception $e) {
                return $e->getError()->message;
            }
        }
        if(isset($exist->id)){
            Banks::where('id', $exist->id)
                ->update([
                    'business_type' => $request['business_type'],
                    'company_type' => $request['company_type'],
                    'company_name' => $request['company_name'],
                    'address' => $request['address'],
                    'birth' => $request['birth'],
                    'city' => $request['city'],
                    'state' => $request['state'],
                    'zip' => $request['zip'],
                    'phone' => $request['phone'],
                    'ein' => $request['ein'],
                    'ssn' => $request['ssn'],
                    'account_number' => $request['account_number'],
                    'route_number' => $request['route_number'],
                    'first_name' => $request['first_name'],
                    'last_name' => $request['last_name'],
                    'email' => $request['email'],
                    'extra' => $account_id,
                ]);
            if($request->file('frontDocument') != null){
                Banks::where('id', $exist->id)
                    ->update([
                        'front' => $file_name_front
                    ]);
            }
            if($request->file('backDocument') != null){
                Banks::where('id', $exist->id)
                    ->update([
                        'back' => $file_name_back
                    ]);
            }

            return "success";
        }
        $bank = new Banks;
        $bank->user_id = $user_id;
        $bank->business_type = $request['business_type'];
        $bank->company_type = $request['company_type'];
        $bank->company_name = $request['company_name'];
        $bank->address = $request['address'];
        $bank->city = $request['city'];
        $bank->state = $request['state'];
        $bank->zip = $request['zip'];
        $bank->phone = $request['phone'];
        $bank->birth = $request['birth'];
        $bank->ein = $request['ein'];
        $bank->ssn = $request['ssn'];
        $bank->account_number = $request['account_number'];
        $bank->route_number = $request['route_number'];
        $bank->first_name = $request['first_name'];
        $bank->last_name = $request['last_name'];
        $bank->email = $request['email'];
        $bank->extra = $account_id;
        if($request->file('frontDocument') != null){
            $bank->front = $file_name_front;
        }
        if($request->file('backDocument') != null){
            $bank->back = $file_name_back;
        }
        $bank->save();
        return "success";
    }
    // Newsletter
    public function news_view(Request $request){
        if(!Session::has('user_id')){
            return redirect('login');
        }
        $user_id = session('user_id');
        $data = [];
        $data['page_name'] = "Manage Newsletter";
        if(session('level') < 2 ){
            // return redirect()->back()->withErrors("You don't have permission to access this page");
            $data['news'] = NewsModel::get(); 
            return view('admin.news.newsletter-client', $data);
        }
        else if(session('level') == 2){
            $data['news'] = NewsModel::get();    
        }
        else{
            $data['news'] = NewsModel::where('user_id', $user_id)->get();
        }
        return view('admin.news.newsletter', $data);
    }
    public function add_news(Request $request){
        if(!Session::has('user_id') || session('level') < 2){
            return "You don't have permission to access this page";
        }
        $news = new NewsModel;
        $news->user_id = session('user_id');
        $news->title = $request['title'];
        $news->date = $request['date'];
        $news->auth_name = session('user_name');
        $news->content = $request['content'];
        $file_name = "";
        if($request->file('file') != null){
            $file_name = uniqid();
            $extension = $request->file('file')->extension();
            Storage::putFileAs('upload', $request->file('file'), $file_name.".".$extension);
            $request->file('file')->move(public_path('news'), $file_name.".".$extension);
            $file_name = $file_name.".".$extension;
            $news->attachment = $file_name;
        }
        if(session('level') == 2){
            $news->flag = 1;
        }
        $news->save();
        return "success";
    }
    public function update_news(Request $request){
        if(!Session::has('user_id') || session('level') < 2){
            return "You don't have permission to access this page";
        }
        if(session('level') != 2){
            $exist = NewsModel::where('id', $request['id'])
                ->where('user_id', session('user_id'))
                ->first();
            if(!isset($exist->id)){
                return "You don't have permission";
            }
        }
        NewsModel::where('id', $request['id'])
            ->update([
                'title' => $request['title'],
                'date' => $request['date'],
                'content' => $request['content']
            ]);
        $file_name = "";
        if($request->file('file') != null){
            $file_name = uniqid();
            $extension = $request->file('file')->extension();
            Storage::putFileAs('upload', $request->file('file'), $file_name.".".$extension);
            $request->file('file')->move(public_path('news'), $file_name.".".$extension);
            $file_name = $file_name.".".$extension;
            NewsModel::where('id', $request['id'])
                ->update([
                    'attachment' => $file_name
                ]);
        }
        return "success";
    }
    public function delete_news(Request $request){
        if(!Session::has('user_id') || session('level') < 2){
            return "You don't have permission to access this page";
        }
        if(session('level') != 2){
            $exist = NewsModel::where('id', $request['id'])
                ->where('user_id', session('user_id'))
                ->first();
            if(!isset($exist->id)){
                return "You don't have permission";
            }
        }
        NewsModel::where('id', $request['id'])->delete();
        return 'success';
    }
    public function test_newsletter(Request $request){
        $id = $request->id;
        $data = NewsModel::where('id', $id)->first();
        if(!isset($data->id)){
            return 'Invalid Newsletter';
        }
        try{
            $mailData = $request;
            $mailData['mail'] = 'support@inex.net';
            $mailData['user_email'] = session('email');
            $mailData['subject'] = 'Testing Newsletter - '.$data->title;
            $mailData['attachment'] = $data->attachment;

            $contactContent = array('title' =>  $data->title, 'auth_name' =>  $data->auth_name, 'content' => $data->content, 'attachment' => $data->attachment);

            Mail::send( ['html' => 'mail.newsletter'] ,$contactContent,
            function($message) use ($mailData)
            {
                $message
                    ->from($mailData['mail'], "INEX Digital Billboard Advertising")
                    ->to($mailData['user_email'])
                    ->replyTo($mailData['mail'])
                    ->subject($mailData['subject']);
                if($mailData->attachment != null){
                    $message->attach("news/".$mailData['attachment']);
                }
            });
            return 'success';
        }
        catch (\Exception $e) {
            return $e->getMessage();
            return 'Invalid Email Address';
        }
        return 'success';
    }
    public function get_news(Request $request){
        if(!Session::has('user_id')){
            return "You don't have premissino to get the news";
        }
        $news = NewsModel::where('flag', 1)->get();
        $data = [];
        // $data['data'] = $news;
        $data['all'] = "";
        $data['read'] = "";
        $data['unread'] = "";
        foreach($news as $key => $val){
            $temp = '<div class="d-flex align-items-center mb-6 news-container">
                <div class="d-flex flex-column font-weight-bold">
                    <a href="/view-news/'.$val['id'].'" class="text-dark text-hover-primary mb-1 font-size-lg">'.$val['title'].'</a>
                    <span class="text-muted">'.$val['auth_name'].'</span>
                </div>
                <div class="symbol symbol-40 symbol-light-primary mr-5">';
                    if($val->attachment != null){
                        $temp .= '<a href="/view-news/'.$val['id'].'" title="Read"><i class="fas fa-download text-success mr-5"></i></a>';
                    }
                    $temp .= '<a href="/view-news/'.$val['id'].'" title="Read"><i class="fas fa-eye text-danger"></i></a>
                </div>
            </div>';
            $data['all'] .= $temp;
            $status = NewsStatus::where('user_id', session('user_id'))
                ->where('news_id', $val->id)
                ->first();
            if(!isset($status->id)){
                $data['unread'] .= $temp;
            }
            else{
                $data['read'] .= $temp;
            }
        }
        $data['success'] = true;
        return $data;
    }
    public function view_news(Request $request){
        if(!Session::has('user_id')){
            return redirect()->route("login");
        }
        $data['page_name'] = "Newletter";
        $news = NewsModel::where('id', $request['id'])->first();
        if(!isset($news->id)){
            return redirect()->back()->withErrors("Invalid Url");
        }
        // Update Status
        $status = NewsStatus::where('user_id', session('user_id'))
            ->where('news_id', $request['id'])
            ->first();
        if(!isset($status->id)){
            $status = new NewsStatus;
            $status->user_id = session('user_id');
            $status->news_id = $request['id'];
            $status->save();
        }
        $data['news'] = $news;
        return view('admin.news.view-news', $data);
    }
    public function create_news(Request $request){
        if(!Session::has('user_id')){
            return redirect('login');
        }
        if(session('level') < 2 ){
            return redirect()->back()->withErrors("You don't have permission to access this page");
        }
        $user_id = session('user_id');
        $data = [];
        $data['page_name'] = "Create Newsletter";
        return view('admin.news.create-news', $data);
    }
    public function update_news_view(Request $request){
        if(!Session::has('user_id')){
            return redirect('login');
        }
        if(session('level') < 2 ){
            return redirect()->back()->withErrors("You don't have permission to access this page");
        }
        $data = [];
        $data['page_name'] = "Update Newsletter";
        $user_id = session('user_id');
        $id = $request['id'];
        $news = NewsModel::where('id', $id)->first();
        if(!isset($news->id)){
            return redirect()->back()->withErrors("Invalid News ID");
        }
        $data['news'] = $news;
        return view('admin.news.update-news', $data);
    }
    public function change_news(Request $request){
        if(!Session::has('user_id') || session('level') != 2){
            return "You don't have permission to access this page";
        }
        $flag = $request['status']==0?1:0;
        NewsModel::where('id', $request['id'])
            ->update([
                'flag' => $flag
            ]);
        return "success";
    }
    // End of news
    // Document Category
    public function manage_resource_cate(Request $request){
        if(!Session::has('user_id') || Session('level') != 2){
            return back()->withErrors(['msg' => "You can't access to this page"])->withInput();
        }
        $data['page_name'] = "Manage Document Categories";
        $data['cate'] = DocCat::get();
        return view('admin.resource.manage-training-types', $data);
    }
    public function create_cate(Request $request){
        if(!Session::has('user_id') || Session('level') != 2){
            return "You can't access to this page";
        }
        $cate = new DocCat;
        $cate->name = $request['title'];
        $cate->extra = $request['extra'];
        $cate->private = $request['private'];
        $cate->save();
        return 'success';
    }
    public function update_cate(Request $request){
        if(!Session::has('user_id') || Session('level') != 2){
            return "You can't access to this page";
        }
        DocCat::where('id', $request['id'])
            ->update([
                'name' => $request['title'],
                'extra' => $request['extra'],
                'private' => $request['private'],
            ]);
        return 'success';
    }
    public function delete_cate(Request $request){
        if(!Session::has('user_id') || Session('level') != 2){
            return "You can't access to this page";
        }
        DocCat::where('id', $request['id'])
            ->delete();
        return 'success';
    }
    // End of document category
    public function seo_operation(Request $request){
        if(!Session::has('user_id') || Session('level') != 2){
            return "You can't access to this page";
        }
        $data['page_name'] = "Manage SEO Operation";
        $data['seos'] = ManageSEO::get();
        return view('admin.seo.manage', $data);
    }
    public function detail_seo(Request $request){
        $seo = ManageSEO::where('id', $request['id'])->first();
        if(isset($seo->id)){
            $result = [];
            $result['success'] = true;
            $result['data'] = $seo;
            return $result;
        }
        return 'Invalid SEO';
    }
    public function new_seo(Request $request){
        if(!Session::has('user_id') || session('level') < 2){
            return "You don't have permission to access this page";
        }
        $seo = new ManageSEO;
        $seo->title = $request['title'];
        $seo->extra = $request['extra'];
        $seo->tags = $request['tags'];
        $seo->umt = $request['umt'];
        $seo->page_name = $request['page_name'];
        $file_name = "";
        if($request->file('file') != null){
            $file_name = uniqid();
            $extension = $request->file('file')->extension();
            Storage::putFileAs('upload', $request->file('file'), $file_name.".".$extension);
            $request->file('file')->move(public_path('news'), $file_name.".".$extension);
            $file_name = $file_name.".".$extension;
            $seo->file = $file_name;
        }
        $seo->save();
        return 'success';
    }
    public function update_seo(Request $request){
        if(!Session::has('user_id') || session('level') < 2){
            return "You don't have permission to access this page";
        }
        ManageSEO::where('id', $request['id'])
            ->update([
                'title' => $request['title'],
                'extra' => $request['extra'],
                'tags' => $request['tags'],
                'umt' => $request['umt'],
                'page_name' => $request['page_name'],
            ]);
        $file_name = "";
        if($request->file('file') != null){
            $file_name = uniqid();
            $extension = $request->file('file')->extension();
            Storage::putFileAs('upload', $request->file('file'), $file_name.".".$extension);
            $request->file('file')->move(public_path('news'), $file_name.".".$extension);
            $file_name = $file_name.".".$extension;
            ManageSEO::where('id', $request['id'])
                ->update([
                    'attachment' => $file_name
                ]);
        }
        return 'success';
    }
    // End of seo
    // Subscriber
    public function manage_subscribers(Request $request){
        if(!Session::has('user_id') || session('level') != 2){
            return "You don't have permission to access this page";
        }
        $data = [];
        // $data['subs'] = SubMails::groupby('email')->get();
        if($request->status == 'duplicated'){
            $duplicates = SubMails::groupby('email')
                ->select('tbl_submails.*', DB::raw('count(id) as num'))
                ->get();
            $result = [];
            foreach($duplicates as $key => $val){
                if($val->num > 1){
                    $test = SubMails::where('email', $val['email'])->get();
                    foreach($test as $item) {
                        $result[] = $item;
                    }
                    // $result[] = $val;
                }
            }
            $data['subs'] = $result;
        } else {
            $data['subs'] = SubMails::get();
        }
        $data['page_name'] = 'Manage Subscribers';
        $data['status'] = $request->status;
        return view('admin.subscribers.manage', $data);
    }
    public function get_subscriber(Request $request){
        $id = $request->id;
        $exist = SubMails::where('id', $id)->first();
        if(isset($exist->id)){
            $data = [];
            $data['success'] = true;
            $data['data'] = $exist;
            return $data;
        }
        return "Invalid Subscriber";
    }
    public function add_subscriber(Request $request){
        $id = $request->id;
        $new = new SubMails;
        $new->firstName = $request['firstName'];
        $new->lastName = $request['lastName'];
        $new->email = $request['email'];
        if(isset($request->status) && $request->status == true){
            $new->status = 0;
        } else {
            $new->status = 1;
        }
        $new->save();
        return 'success';
    }
    public function update_subscriber(Request $request){
        $id = $request->id;
        $exist = SubMails::where('id', $id)->first();
        if(isset($exist->id)){
            SubMails::where('id', $id)
                ->update([
                    'firstName' => $request['firstName'],
                    'lastName' => $request['lastName'],
                    'email' => $request['email'],
                ]);
            if(isset($request->status) && $request->status == true){
                SubMails::where('id', $request['id'])
                    ->update([
                        'status' => 0
                    ]);
            } else {
                SubMails::where('id', $request['id'])
                    ->update([
                        'status' => 1
                    ]);
            }
            return 'success';
        }
        return "Invalid Subscriber";
    }
    public function delete_subscriber(Request $request){
        $id = $request->id;
        $exist = SubMails::where('id', $id)->first();
        if(isset($exist->id)){
            SubMails::where('email', $exist['email'])->delete();
            return 'success';
        }
        return "Invalid Subscriber";
    }
    public function import_csv(Request $request){
        $file_name = uniqid();
        $extension = $request->file('file')->extension();
        Storage::putFileAs('csv', $request->file('file'), $file_name.".".$extension);
        $request->file('file')->move(public_path('csv'), $file_name.".".$extension);
        $path = Storage::path("csv/".$file_name.".".$extension);
        $csv = array_map('str_getcsv', file($path));
        if(count($csv) > 1){
            foreach($csv as $key => $val){
                if($key != 0 && (isset($val[$request['firstName']]) && isset($val[$request['lastName']]) && isset($val[$request['email']]))){
                    $exist = SubMails::where('email', $val[$request['email']])->first();
                    if(!isset($exist->id)){
                        $sub = new SubMails;
                        $sub->firstName = $val[$request['firstName']];
                        $sub->lastName = $val[$request['lastName']];
                        $sub->email = $val[$request['email']];
                        if(isset($request->status) && $request->status == true){
                            $sub->status = 0;
                        } else {
                            $sub->status = 1;
                        }
                        $sub->save();
                    }
                }
            }
        }
        return 'success';
    }
    public function delete_duplocation(Request $request){
        $duplicates = SubMails::GroupBy('email')
            ->select('tbl_submails.*', DB::raw('count(id) as num'))
            ->get();
        $result = [];
        $temp = '';
        foreach($duplicates as $key => $val){
            if($val->num > 1){
                $temp = $val['email'];
                $test = SubMails::where('email', $val['email'])->get();
                foreach($test as $item) {
                    if($temp == $item['email']){
                        SubMails::where('id', $item['id'])->delete();
                    }
                }
            }
        }
        return 'success';
    }
    // End of subscribers
    // Manage Gallery
    public function manage_gallery(Request $request){
      if(!Session::has('user_id') || session('level') != 2){
        return redirect()->back()->withErrors("You don't have permission to access this page");
      }
      $data = [];
      $data['page_name'] = "Manage Gallery";
      $data['gallery'] = GalleryModel::get();
      return view('admin.resource.gallery', $data);
    }
    public function get_gallery(Request $request){
      $data = GalleryModel::get();
      $gallery = [];
      foreach($data as $key => $val){
        $temp = $val;
        $created = date_create($val->created_at);
        $temp['date'] = date_format($created, "m-d-Y H:i");
        $gallery[] = $temp;
      }
      $data['data'] = $gallery;
      $data['length'] = count($data['data']);
      $data['recordsFiltered'] = count($data['data']);
      $data['recordsTotal'] = count($data['data']);
      return $data;
    }
    public function upload_gallery(Request $request){
      if($request->file('file') != null){
        $file_name = uniqid();
        $extension = $request->file('file')->extension();
        Storage::putFileAs('upload', $request->file('file'), $file_name.".".$extension);
        $request->file('file')->move(public_path('gallery'), $file_name.".".$extension);
        $full_name = $file_name.".".$extension;
        
        $gallery = new GalleryModel;
        $gallery->url = $full_name;
        $gallery->name = $request['text'];
        $gallery->save();
      }
      return 'success';
    }
    public function update_gallery(Request $request) {
      if($request->file('file') != null){
        $file_name = uniqid();
        $extension = $request->file('file')->extension();
        Storage::putFileAs('upload', $request->file('file'), $file_name.".".$extension);
        $request->file('file')->move(public_path('gallery'), $file_name.".".$extension);
        $full_name = $file_name.".".$extension;
        GalleryModel::where('id', $request['id'])
          ->update([
            'url' => $full_name,
            'name' => $request['text'],
          ]);
      } else {
        GalleryModel::where('id', $request['id'])
          ->update([
            'name' => $request['text'],
          ]);
      }
      return 'success';
    }
    public function delete_gallery(Request $request) {
      $gallery = GalleryModel::where('id', $request['id'])->first();
      if(isset($gallery->id)){
        if (File::exists(base_path('/public/gallery/' .$gallery->url))) {
          File::delete(base_path('/public/gallery/' .$gallery->url));
        }
      }
      GalleryModel::where('id', $request['id'])->delete();
      return 'success';
      // return 'success';
    }
    // End of manage gallery
}
