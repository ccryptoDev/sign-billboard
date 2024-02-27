<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    
    // Profile
    public function account_view(Request $request){
        if(Session::has('user_id')){
            $data = array();
            $data["page_name"] = "My Personal Account";
            $data["user"] = \App::call("App\Http\Controllers\MainController@get_account");
            $data["primary"] = \App::call("App\Http\Controllers\MainController@get_primary");
            $data["social"] = \App::call("App\Http\Controllers\MainController@get_social");
            $data['s_avalialbe'] = \App::call("App\Http\Controllers\MainController@get_social_avail");
            $data['users'] = \App::call("App\Http\Controllers\MainController@get_users");
            $data["check_multi"] = \App::call("App\Http\Controllers\MainController@check_multi");

            $data["sic"] = \App::call("App\Http\Controllers\MainController@get_sic");
            $data["sales"] = \App::call("App\Http\Controllers\MainController@get_sales");

            session(['social_session','']);
            return view("admin/accounts/personal",$data);
        }
        else{
            return redirect()->route('login');
        }
    }
    public function security_view(Request $request){
        if(Session::has('user_id')){
            $data = array();
            $data["page_name"] = "My Personal Account";
            $data["user"] = \App::call("App\Http\Controllers\MainController@get_account");
            $data["primary"] = \App::call("App\Http\Controllers\MainController@get_primary");
            $data["social"] = \App::call("App\Http\Controllers\MainController@get_social");
            $data['s_avalialbe'] = \App::call("App\Http\Controllers\MainController@get_social_avail");
            $data['users'] = \App::call("App\Http\Controllers\MainController@get_users");
            $data["check_multi"] = \App::call("App\Http\Controllers\MainController@check_multi");

            $data["sic"] = \App::call("App\Http\Controllers\MainController@get_sic");
            $data["sales"] = \App::call("App\Http\Controllers\MainController@get_sales");

            session(['social_session','']);
            return view("admin/accounts/security",$data);
        }
        else{
            return redirect()->route('login');
        }
    }
    public function update_password(Request $request){
        $messages = [
            "password.required" => "Password is required",
        ];
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed',
        ], $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        else{
            $user_id = session('user_id');
            DB::table('tbl_user')
                ->where('id', $user_id)
                ->update([
                    'password' => $request['password']
                ]);
            return back()->withSuccess('Success');
        }
    }

    public function update_info(Request $request){
        $notification = 0;
        if(!isset($request['notification'])){
            $notification = 1;
        }
        $user_id = session('user_id');
        $exist = DB::table('tbl_user')
            ->where('email', $request['email'])
            ->where('id', '!=', $user_id)
            ->first();
        if(isset($exist->id)){
            return redirect()->back()->withErrors("This email address already exists. Use a different one.");
            return;
        }
        DB::table("tbl_user")
            ->where("id", $user_id)
            ->update([
                "user_name" => $request["user_name"],
                "phone" => $request["phone"],
                "email" => $request["email"],
                "address" => $request["address"],
                "real_name" => $request["real_name"],
                "notification" => $notification,
            ]);
        if(session("level") == "2"){
            DB::table("tbl_social")->delete();
            DB::table("tbl_social")
                ->INSERT([
                    "f_id" => $request['f_id'],
                    "f_sec" => $request['f_sec'],
                    "f_redirect" => $request["f_redirect"],
                ]);
        }
        if(session('level') == 1){
            $business_name = session("business_name");
            DB::table('tbl_sic_list')
                ->where('business_name', $business_name)
                ->delete();
            DB::table('tbl_sic_list')
                ->INSERT([
                    'sic_id' => $request['sic'],
                    'business_name' => $business_name
                ]);
            DB::table('tbl_sales_list')
                ->where('business_name', $business_name)
                ->delete();
            DB::table('tbl_sales_list')
                ->INSERT([
                    'sales_id' => $request['sales'],
                    'business_name' => $business_name
                ]);
        }
        if(isset($request['carrier'])){
            DB::table('tbl_user')
                ->where('id', $user_id)
                ->update([
                    'carrier' => $request['carrier']
                ]);
        }
        return back()->withSuccess('Success');
    }
    // End of Profile
}
