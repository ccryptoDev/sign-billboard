<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Business;
use App\LogLists;
use App\PublicLocations;
use App\Mail\NewBusiness;
use App\Mail\SendMailable;
use App\Mail\WelcomeMail;
use App\Mail\NoAccount;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login_view(Request $request){
        $data= [];
        $data['page_name'] = 'Login';
        if (request()->route()->getName() == 'login-demo'){
            $data['page_name'] = 'Try Our DEMO';
        }
        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        if($route == 'purchase-manual' || $route == "purchase" || $route == 'unsubscribe')
        {
            session(['link' => url()->previous()]);
        }
        else{
            session(['link' => ""]);
        }
        return view('front.login', $data);
    }
    public function login(Request $request){
        $messages = [
            "email.required" => "Email is required",
            "password.required" => "Password is required",
        ];
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $user = DB::table("tbl_user")
            ->where("email",$request['email'])
            ->where("password",$request["password"])
            ->first();
        if(isset($user->email)){
            if($user->user_lock == 1 && $user->level != 2){
                return back()->withErrors("Your account is Locked Out. Please call us 405-415-3002.")->withInput();
            }
            else{
                session(['email' => $user->email]);
                session(['user_name' => $user->user_name]);
                session(['user_id' => $user->id]);
                session(['business_name' => $user->business_name]);
                session(['level' => $user->level]);
                // Login List
                $ip = $request->ip();
                $log_list = new LogLists;
                $log_list->user_id = $user->id;
                $log_list->ip_address = $ip;
                $log_list->save();
                $exist_log = LogLists::where('user_id', $user->id)
                    ->where('welcome', 1)->first();
                // return redirect(session('link'));
                if(session('link') != ""){
                    return redirect(session('link'));
                }
                else{
                    if($user->level == 2){
                        return redirect('dashboard');
                        return "dashboard";
                    }
                    else{
                        if($user->level == 1 && !isset($exist_log->id)){
                            return redirect()->route('welcome');
                        }
                        return redirect('dashboard');
                        return "update_ad";
                    }
                }
                return "success";
            }
        }
        else{
            return back()->withErrors("The provided credentials do not match our records.")->withInput();
        }
    }
    public function register_view(Request $request){
        $data = array();
        $users = DB::table('tbl_user')
            ->where('level', 4)
            ->where('user_lock', 0)
            ->get();
        $accounts = [];
        foreach($users as $key => $val){
            $temp = [];
            $temp['id'] = $val->id;
            $temp['name'] = $val->user_name;
            array_push($accounts, $temp);
        }
        $data['accounts'] = $accounts;
        $data['pa'] = \App::call("App\Http\Controllers\UserController@list_pa");
        return view('front.register', $data);
    }
    
    public function register(Request $request){
        $messages = [
            "business_name.required" => "Advertising Company is required",
            "address.required" => "Street Address is required",
            "name.required" => "Contact Name is required",
            "phone.required" => "Contact Telephone is required",
            "city.required" => "City is required",
            "state.required" => "State Telephone is required",
            "zip.required" => "Zip code Telephone is required",
            "email.required" => "Contact Email is required",
            "hear.required" => "How did you hear about INEX?",
        ];
        $validator = Validator::make($request->all(), [
            'business_name' => 'required',
            'address' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'hear' => 'required',
            'email' => 'required|email',
        ], $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if($request['hear'] == 1 && (!isset($request['account_manager']) || $request['account_manager'] == "")){
            return back()->withErrors("Please select account manager")->withInput();
        }
        if(!isset($request['term'])){
            return back()->withErrors("Please check the Terms of Service")->withInput();
        }
        $trust = DB::table('tbl_user')
            ->where('email', $request['email'])
            ->first();
        if(isset($trust->id)){
            return back()->withErrors(['msg' => "Please input another email address"])->withInput();
        }
        // Add to trust
        $init_date = date("Y-m-d H:i:s");
        $account_manager = '';
        if(isset($request['account_manager'])){
            $account_manager= $request['account_manager'];        
        }
        else {
            $account_manager = 117;
        }
        $primary_id = DB::table('tbl_user')
            ->insertGetId([
                'user_name' => $request['name'],
                'level' => 1,
                'user_lock' => 1,
                'email' => $request['email'],
                'phone' => $request['phone'],
                'business_name' => $request['business_name'],
                'created_at' => $init_date,
                'hear' => $request['hear'],
                'account_manager' => $account_manager,
        ]);
        $business_name = $request['business_name'];
        $business = new Business;
        $business->user_id = 0;
        $business->primary_id = $primary_id;
        $business->company_name = $request['business_name'];
        $business->address = $request['address'];
        $business->name = $request['name'];
        $business->email = $request['email'];
        $business->suite = $request['suite'];
        $business->phone = $request['phone'];
        $business->city = $request['city'];
        $business->state = $request['state'];
        $business->zip = $request['zip'];
        $business->bill_name = "";
        $business->bill_email = "";
        $business->bill_phone = "";
        // Account Manager
        if(isset($request['account_manager'])){
            $business->sales = $request['account_manager'];        
        }
        else {
            $business->sales = 117;
            $request['account_manager'] = 117;
            // Send To Admin to assign AM
            $admins = DB::table('tbl_user')
                ->where('level', 2)
                ->get();
            foreach($admins as $key => $val){
                Mail::to($val['email'])->send(new WelcomeMail($request, $primary_id));
            }
        }
        $business->category = 0;
        $business->save();
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
        // Default Payment Method
        $controller = app()->make('App\Http\Controllers\InvoiceController');
        app()->call([$controller, 'default_payment_method'], ["business_name" => $business_name]);
        
        $user = DB::table('tbl_user')
            ->leftJoin('tbl_business', 'tbl_user.id', 'tbl_business.primary_id')
            ->where('tbl_business.primary_id', $primary_id)
            ->select('tbl_user.*', 'tbl_business.address', 'tbl_business.zip', 'tbl_business.city', 'tbl_business.state')
            ->first();
        Mail::to($request['email'])->send(new WelcomeMail($user));
        // Email To Account Manager
        if(isset($request['account_manager'])){
            $business->sales = $request['account_manager'];
            $account_manager = DB::table('tbl_user')
                ->where('id', $request['account_manager'])->first();
            if(isset($account_manager->id)){
                Mail::to($account_manager->email)->send(new NewBusiness($user,$account_manager,1));
            }
        }
        // Send Email to Admin
        $admin = DB::table('tbl_user')
            ->where('level',2)
            ->get();
        foreach($admin as $key => $val){
            $account_manager = "";
            if(isset($request['account_manager'])){
                $business->sales = $request['account_manager'];
                $account_manager = DB::table('tbl_user')->where('id', $request['account_manager'])->first();
            }
            Mail::to($val->email)->send(new NewBusiness($user,$account_manager,2)); // 0 : User, 1 : Super    
        }
        return redirect()->route('welcome-registeration');
        return back()->withSuccess("Please verify your email address");
    }
    public function forgot_view(Request $request){
        return view('front.forgot');
    }
    public function forgot(Request $request){
        $messages = [
            "email.required" => "Email is required",
        ];
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ], $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $user = DB::table("tbl_user")->where("email",$request['email'])->get()->first();
        if(isset($user->email)){
            Mail::to($user->email)->send(new SendMailable($user->id, $user));
        }
        return back()->withSuccess("We have emailed your password reset link!");
    }
    public function welcome_registeration(Request $request){
        return view('auth.welcome_registeration');
    }
}
