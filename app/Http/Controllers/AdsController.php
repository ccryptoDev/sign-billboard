<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class AdsController extends Controller
{
    // Create Ad Page View
    public function create_ad_view(Request $request){
        if(!Session::has('user_id')){
            return redirect()->route('login');
        }
        $data = array();
        $data["page_name"] = "Create New Ad";
        $controller = app()->make('App\Http\Controllers\MainController');
        $data['business_name'] = app()->call([$controller, 'get_business_name_by_session'], []);
        $data['multi'] = app()->call([$controller, 'get_multi'], []);
        $data['check_multi'] = app()->call([$controller, 'check_multi'], []);
        $data['s_avalialbe'] = app()->call([$controller, 'get_social_avail'], []);

        $userController = app()->make('App\Http\Controllers\UserController');
        $data['pa'] = app()->call([$userController, 'list_pa'], []);

        // Users
        if(Session('level') >= 2){
            return view('admin.ads.create-ad-users', $data);
        }
        else{
            $data['temp'] = DB::table("tbl_template")
                ->where("business_name", session('business_name'))
                ->where("primary","!=","1") 
                ->get();
            return view('admin.ads.create-ad-users', $data);
        }
    }
    public function get_temp_name(Request $request){
        if(session('level') == "2" || $request['get_temp'] == true){
            $temp = DB::table("tbl_template")
                ->where("business_name",$request["business_name"])
                ->get();
        }
        else{
            $temp = DB::table("tbl_template")
                ->where("business_name",$request["business_name"])
                ->where("primary","!=","1") 
                ->get();
        }
        return $temp;
    }
}
