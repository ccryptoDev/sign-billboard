<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

use XeroPHP\Remote;
use XeroPHP\Models\Accounting\Organisation;
use XeroPHP\Models\Accounting;

use App\Admin;
use App\RestrictLocation;
use App\CMToken;
use App\PublicLocations;
use App\SuggestionModel;
use App\UpateHistory;
use App\Business;
// Mail
use App\Mail\SendMailable;
use App\Mail\SendRegister;
use App\Mail\SendReject;
use App\Mail\SendRequest;
use App\Mail\NewCampaign;
use App\Mail\InexUpdateMail;
use App\Mail\TextSuggest;
use Illuminate\Support\Facades\Mail;


use Illuminate\Support\Facades\Storage;
// use Illuminate\Http\File;
use Illuminate\Support\Facades\File;


// FaceBook
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
// END OF FACEBOOK
// Twitter
use Socialite;
use App\Services\SocialTwitterAccountService;
use TwitterAPIExchange;

use Illuminate\Support\Facades\URL;
use App\Logs;
use App\LogLists;
// END OF Twitter

class MainController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function login(Request $request){
        $user = DB::table("tbl_user")
            ->where("email",$request['email'])
            ->where("password",$request["password"])
            ->first();
        if(isset($user->email)){
            if($user->user_lock == 1 && $user->level != 2){
                return "Your account is Inactivated";
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
                if($user->level == 2){
                    return "dashboard";
                }
                else{
                    if($user->level == 1 && !isset($exist_log->id)){
                        return "welcome";
                    }
                    return "update_ad";
                }
                return "success";
            }
        }
        else{
            return "fail";
        }
    }
    public function register(Request $request){
        $user = DB::table("tbl_user")
            ->where("email",$request['email'])->get()->first();
        if(isset($user->email)){
            return "fail";
        }
        else{
            DB::table("tbl_user")
                ->insert([
                    "email" => $request['email'],
                    "user_name" => $request['username'],
                    "password" => $request['password'],
                ]);
            return "success";
        }
    }

    public function login_by_id($id){
        $user = DB::table('tbl_user')
            ->where('id', $id)
            ->first();
        if(isset($user->id)){
            if($user->user_lock == 1 && $user->level != 2){
                return 'fail';
            }
            session(['email' => $user->email]);
            session(['user_name' => $user->user_name]);
            session(['user_id' => $user->id]);
            session(['business_name' => $user->business_name]);
            session(['level' => $user->level]);
            return "success";
        }
        return 'fail';
    }

    public function get_sic_sales(Request $request){
        $data = array();
        $sic = DB::table("tbl_sic_list")
            ->leftJoin('tbl_sic','tbl_sic.id','tbl_sic_list.sic_id')
            ->where('business_name',session('business_name'))
            ->get()->first();
        $data['sic'] = $sic;
        $sales = DB::table("tbl_sales_list")
            ->leftJoin('tbl_sales','tbl_sales.id','tbl_sales_list.sales_id')
            ->where('business_name',session('business_name'))
            ->get()->first();
        $data['sales'] = $sales;
        return $data;
    }
    
    public function update_account(Request $request){
        $notification = 0;
        if(!isset($request['notification'])){
            $notification = 1;
        }
        DB::table("tbl_user")
            ->where("id",session('user_id'))
            ->update([
                "user_name" => $request["user_name"],
                "phone" => $request["phone"],
                "address" => $request["address"],
                "real_name" => $request["real_name"],
                "notification" => $notification,
            ]);
        if($request["new_pass"] != ""){
            if($request['new_pass'] != $request['con_pass']){
                return "Please input same password and confirm password";
            }
            DB::table("tbl_user")
                ->where("id", session("user_id"))
                ->update([
                    "password" => $request["new_pass"]
                ]);
        }
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
                ->where('id', session('user_id'))
                ->update([
                    'carrier' => $request['carrier']
                ]);
        }
        return "success";
    }
    public function f_token(Request $request){
        $social = DB::table("tbl_social")
            ->get()->first();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://graph.facebook.com/oauth/access_token?grant_type=fb_exchange_token&client_id=".$social->f_id."&client_secret=".$social->f_sec."&fb_exchange_token=".$request->short_live,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $res = json_decode($response);
        if(isset($res->access_token)){
            DB::table("tbl_user")
                ->where("id",$request['user_id'])
                ->update([
                    "f_token" => $res->access_token
                ]);
            
            return "success";
        }
        else{
            return "fail";
        }
    }
    public function get_account(){
        $user = DB::table("tbl_user")
            ->where("id",session("user_id"))->get()->first();
        if(isset($user->id) && $user->extra != null){
            $fran = DB::table('tbl_user')
                ->where('id', $user->extra)->first();
            $user->fran = isset($fran->id)?$fran->user_name:"";
        }
        return $user;
    }
    public function get_social_avail(){
        $data = array();
        $user = DB::table("tbl_user")
            ->where("id",session("user_id"))
            ->get()->first();
        $data['facebook'] = $this->get_facbook_av($user->f_token);
        $data['linkedin'] = $this->get_linkedin_av($user->l_token);
        $data['twitter'] = $user->t_token;
        return $data;
    }
    public function get_twitter_av($token){

    }
    public function get_linkedin_av($token){
        $curl = curl_init();

        curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.linkedin.com/v2/me",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                        "Content-Type: application/x-www-form-urlencoded",
                        "Connection: Keep-Alive",
                        "Authorization: Bearer ".$token
                ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $res = json_decode($response,true);
        if(isset($res['id'])){
            return "true";
        }
        else{
            return "false";
        }
    }
    public function get_facbook_av($token){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://graph.facebook.com/v6.0/me/accounts?access_token=".$token,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $res = json_decode($response, true);
        if(isset($res['data'][0]['access_token'])){
            return "true";
        }
        else{
            return "false";
        }
    }
    public function get_primary(){
        if(session("level") != 2){
            $data = DB::table("tbl_user")
                ->where("business_name",session('business_name'))
                ->where("level","1")
                ->get()->first();
            if(isset($data->user_name)){
                $primary = $data->user_name;
                return $primary;
            }
        }
    }
    public function get_social(){
        $social = DB::table("tbl_social")->get()->first();
        return $social;
    }
    public function get_trust(Request $request){
        $controller = app()->make('App\Http\Controllers\MainController');       
        $business = app()->call([$controller, 'get_business_name_by_session'], []);
        $business_name = [];
        foreach($business as $key => $val){
            $business_name[] = $val->business_name;
        }
        $users = DB::table("tbl_user")
            ->leftJoin('tbl_sales_list','tbl_sales_list.business_name','=','tbl_user.business_name')
            ->leftJoin('tbl_sales','tbl_sales_list.sales_id','=','tbl_sales.id')
            ->leftJoin('tbl_sic_list','tbl_sic_list.business_name','=','tbl_user.business_name')
            ->leftJoin('tbl_sic','tbl_sic_list.sic_id','=','tbl_sic.id')
            ->whereIn('tbl_user.business_name', $business_name)
            ->whereIn('tbl_user.level', [0, 1])
            ->select('tbl_user.*','tbl_user.id as com_name','tbl_user.m_id as multi_id','tbl_sales.sales_name','tbl_sales.id as sales_id','tbl_sic.sic_name','tbl_sic.id as sic_id')
                // ->union($multi)
                ->get();
        foreach($users as $key => $val){
            if(date_create($val->s_date)){
                $s_date = date_create($val->s_date);
                $users[$key]->s_date = date_format($s_date,"m-d-Y");
            }
            if(date_create($val->e_date)){
                $e_date = date_create($val->e_date);
                $users[$key]->e_date = date_format($e_date,"m-d-Y");
            }
        }
        return $users;
        if(session("level") == "2"){
            if($request['search_name'] != ""){
                // $multi = DB::table('tbl_multi')
                //     ->leftJoin('tbl_user','tbl_user.id','=','tbl_multi.user_id')
                //     ->leftJoin('tbl_sales_list','tbl_sales_list.business_name','=','tbl_user.business_name')
                //     ->leftJoin('tbl_sales','tbl_sales_list.sales_id','=','tbl_sales.id')
                //     ->leftJoin('tbl_sic_list','tbl_sic_list.business_name','=','tbl_user.business_name')
                //     ->leftJoin('tbl_sic','tbl_sic_list.sic_id','=','tbl_sic.id')
                //     ->where("user_name","like",'%'.$request["search_name"].'%')
                //     ->orwhere("tbl_user.business_name","like",'%'.$request["search_name"].'%')
                //     ->select('tbl_user.*','tbl_multi.com_name','tbl_multi.id as multi_id','tbl_sales.sales_name','tbl_sales.id as sales_id','tbl_sic.sic_name','tbl_sic.id as sic_id');
                $users = DB::table("tbl_user")
                    ->leftJoin('tbl_sales_list','tbl_sales_list.business_name','=','tbl_user.business_name')
                    ->leftJoin('tbl_sales','tbl_sales_list.sales_id','=','tbl_sales.id')
                    ->leftJoin('tbl_sic_list','tbl_sic_list.business_name','=','tbl_user.business_name')
                    ->leftJoin('tbl_sic','tbl_sic_list.sic_id','=','tbl_sic.id')
                    ->where("user_name","like",'%'.$request["search_name"].'%')
                    ->orWhere('tbl_user.level', '=', 0)
                    ->orWhere('tbl_user.level', '=', 1)
                    ->orwhere("tbl_user.business_name","like",'%'.$request["search_name"].'%')
                    ->select('tbl_user.*','tbl_user.id as com_name','tbl_user.m_id as multi_id','tbl_sales.sales_name','tbl_sales.id as sales_id','tbl_sic.sic_name','tbl_sic.id as sic_id')
                        // ->union($multi)
                        ->get();
            }
            else{
                // $multi = DB::table('tbl_multi')
                //     ->leftJoin('tbl_user','tbl_user.id','=','tbl_multi.user_id')
                //     ->leftJoin('tbl_sales_list','tbl_sales_list.business_name','=','tbl_user.business_name')
                //     ->leftJoin('tbl_sales','tbl_sales_list.sales_id','=','tbl_sales.id')
                //     ->leftJoin('tbl_sic_list','tbl_sic_list.business_name','=','tbl_user.business_name')
                //     ->leftJoin('tbl_sic','tbl_sic_list.sic_id','=','tbl_sic.id')
                //     ->select('tbl_user.*','tbl_multi.com_name','tbl_multi.id as multi_id','tbl_sales.sales_name','tbl_sales.id as sales_id','tbl_sic.sic_name','tbl_sic.id as sic_id');
                $users = DB::table("tbl_user")
                    ->leftJoin('tbl_sales_list','tbl_sales_list.business_name','tbl_user.business_name')
                    ->leftJoin('tbl_sales','tbl_sales_list.sales_id','tbl_sales.id')
                    ->leftJoin('tbl_sic_list','tbl_sic_list.business_name','=','tbl_user.business_name')
                    ->leftJoin('tbl_sic','tbl_sic_list.sic_id','=','tbl_sic.id')
                    ->orWhere('tbl_user.level', '=', 0)
                    ->orWhere('tbl_user.level', '=', 1)
                    ->select('tbl_user.*','tbl_user.id as com_name','tbl_user.m_id as multi_id','tbl_sales.sales_name','tbl_sales.id as sales_id','tbl_sic.sic_name','tbl_sic.id as sic_id')
                        // ->union($multi)
                        ->get();
            }
        }
        else{
            if($request['search_name'] != ""){

                // $multi = DB::table('tbl_multi')
                //     ->leftJoin('tbl_user','tbl_user.id','=','tbl_multi.user_id')
                //     ->leftJoin('tbl_sales_list','tbl_sales_list.business_name','=','tbl_user.business_name')
                //     ->leftJoin('tbl_sales','tbl_sales_list.sales_id','=','tbl_sales.id')
                //     ->leftJoin('tbl_sic_list','tbl_sic_list.business_name','=','tbl_user.business_name')
                //     ->leftJoin('tbl_sic','tbl_sic_list.sic_id','=','tbl_sic.id')
                //     ->select('tbl_user.*','tbl_multi.com_name','tbl_multi.id as multi_id','tbl_sales.sales_name','tbl_sales.id as sales_id','tbl_sic.sic_name','tbl_sic.id as sic_id')
                //     ->where("tbl_multi.user_id",session("user_id"))
                //     ->where("user_name","like",'%'.$request["search_name"].'%')
                //     ->orwhere("business_name","like",'%'.$request["search_name"].'%');
                $users = DB::table("tbl_user")
                    ->leftJoin('tbl_sales_list','tbl_sales_list.business_name','=','tbl_user.business_name')
                    ->leftJoin('tbl_sales','tbl_sales_list.sales_id','=','tbl_sales.id')
                    ->leftJoin('tbl_sic_list','tbl_sic_list.business_name','=','tbl_user.business_name')
                    ->leftJoin('tbl_sic','tbl_sic_list.sic_id','=','tbl_sic.id')
                    ->select('tbl_user.*','tbl_user.id as com_name','tbl_user.m_id as multi_id','tbl_sales.sales_name','tbl_sales.id as sales_id','tbl_sic.sic_name','tbl_sic.id as sic_id')
                    ->where("user_name","like",'%'.$request["search_name"].'%')
                    ->orwhere("business_name","like",'%'.$request["search_name"].'%')
                    // ->union($multi)
                    ->where("tbl_user.business_name",session("business_name"))
                    ->orWhere('tbl_user.level', '=', 0)
                    ->orWhere('tbl_user.level', '=', 1)
                    ->get();
            }
            else{
                // $multi = DB::table('tbl_multi')
                //     ->leftJoin('tbl_user','tbl_user.id','=','tbl_multi.user_id')
                //     ->leftJoin('tbl_sales_list','tbl_sales_list.business_name','=','tbl_user.business_name')
                //     ->leftJoin('tbl_sales','tbl_sales_list.sales_id','=','tbl_sales.id')
                //     ->leftJoin('tbl_sic_list','tbl_sic_list.business_name','=','tbl_user.business_name')
                //     ->leftJoin('tbl_sic','tbl_sic_list.sic_id','=','tbl_sic.id')
                //     ->select('tbl_user.*','tbl_multi.com_name','tbl_multi.id as multi_id','tbl_sales.sales_name','tbl_sales.id as sales_id','tbl_sic.sic_name','tbl_sic.id as sic_id')
                //     ->where("tbl_multi.user_id",session("user_id"));
                $users = DB::table("tbl_user")
                    ->leftJoin('tbl_sales_list','tbl_sales_list.business_name','=','tbl_user.business_name')
                    ->leftJoin('tbl_sales','tbl_sales_list.sales_id','=','tbl_sales.id')
                    ->leftJoin('tbl_sic_list','tbl_sic_list.business_name','=','tbl_user.business_name')
                    ->leftJoin('tbl_sic','tbl_sic_list.sic_id','=','tbl_sic.id')
                    ->select('tbl_user.*','tbl_user.id as com_name','tbl_user.m_id as multi_id','tbl_sales.sales_name','tbl_sales.id as sales_id','tbl_sic.sic_name','tbl_sic.id as sic_id')
                    // ->union($multi)
                    ->where("tbl_user.business_name",session("business_name"))
                    ->orWhere('tbl_user.level', '=', 0)
                    ->orWhere('tbl_user.level', '=', 1)
                    ->get();
            }
        }
        foreach($users as $key => $val){
            if(date_create($val->s_date)){
                $s_date = date_create($val->s_date);
                $users[$key]->s_date = date_format($s_date,"m-d-Y");
            }
            if(date_create($val->e_date)){
                $e_date = date_create($val->e_date);
                $users[$key]->e_date = date_format($e_date,"m-d-Y");
            }
        }
        return $users;
    }
    // Trusted Agent List
    public function add_trust(Request $request){
        if($request['manual'] == 1 && $request['business_name'] == ""){
            return "Please input business name";
        }
        else if($request['manual'] == 0 && $request['business'] == ""){
            return "Please input business name";
        }
        $user = DB::table("tbl_user")->where("email",$request["email"])->get()->first();
        if(isset($user->email)){
            return "Please input another email address";
            // return "Already Exist,".$user->id;
        }
        else{
            if($request['manual'] == 1){
                $business_name = $request['business_name'];
            }
            else if($request['manual'] == 0){
                $business_name = $request['business'];
            }
            // $business_name = $request['business_name'];
            if(session("level") != "2"){
                $business_name = session("business_name");
            }
            
            if($request["user_level"] == "1"){
                $playlist_id = "";
                $user_id = DB::table("tbl_user")
                    ->insertGetId([
                        "business_name" => $business_name,
                        "user_name" => $request["user_name"],
                        "email" => $request["email"],
                        "password" => $request["password"],
                        "level" => $request["user_level"],
                        "playlist_id" => $playlist_id
                    ]);
                DB::table('tbl_sic_list')
                    ->where('business_name', $business_name)
                    ->delete();
                // DB::table('tbl_sic_list')
                //     ->INSERT([
                //         'sic_id' => $request['sic'],
                //         'business_name' => $business_name
                //     ]);
                // DB::table('tbl_sales_list')
                //     ->where('business_name', $business_name)
                //     ->delete();
                // DB::table('tbl_sales_list')
                //     ->INSERT([
                //         'sales_id' => $request['sales'],
                //         'business_name' => $business_name
                //     ]);
            }
            if($request["user_level"] == "0"){
                $user_id = DB::table("tbl_user")
                    ->insertGetId([
                        "business_name" => $business_name,
                        "user_name" => $request["user_name"],
                        "email" => $request["email"],
                        "password" => $request["password"],
                        "level" => $request["user_level"],
                    ]);
            }
            if($request["user_level"] == "2"){
                $user_id = DB::table("tbl_user")
                    ->insertGetId([
                        "business_name" => $business_name,
                        "user_name" => $request["user_name"],
                        "email" => $request["email"],
                        "password" => $request["password"],
                        "level" => $request["user_level"],
                    ]);
            }
            $user = DB::table('tbl_user')
                ->where('id', $user_id)
                ->first();
            if(isset($user->id)){
                if($user->level == 0){
                    $primary = DB::table('tbl_user')
                        ->where('business_name', $user->business_name)
                        ->where('level', 1)
                        ->first();
                    $business = Business::where('primary_id', $primary->id)->first();
                    $account_manager = "";
                    if(isset($business->id) && $business->sales){
                        $account_manager = DB::table('tbl_user')->where('id', $business->sales)->first();
                    }
                    if(isset($primary->id)){
                        Mail::to($primary->email)->send(new SendRegister($user, $primary, $account_manager, 0)); // Secondary TA
                        Mail::to($primary->email)->send(new SendRegister($user, $primary, "",1)); // Primary TA
                    }
                }
            }            
            return "success";
        }
    }
    public function save_multi(Request $request){
        $business_name = "";
        if(session("level") != "2"){
            $business_name = session("business_name");
        }
        else{
            $business_name = $request['business_name'];
        }
        DB::table('tbl_multi')
            ->INSERT([
                "user_id" => $request['user_id'],
                "level" => $request['user_level'],
                "com_name" => $business_name
            ]);
        return "success";
    }
    public function update_trust(Request $request){
        // if($request['manual'] == 1 && $request['business_name'] == ""){
        //     return "Please input business name";
        // }
        // else if($request['manual'] == 0 && $request['business'] == ""){
        //     return "Please input business name";
        // }
        $user = DB::table("tbl_user")
            ->where("email",$request["email"])
            ->where("id","!=",$request["tbl_id"])
            ->get()->first();
        if(isset($user->email)){
            return "Please input another email address";
            // return "Please Input Another Email!";
        }
        else{
            if($request['manual'] == 1){
                $business_name = $request['business_name'];
            }
            else if($request['manual'] == 0){
                $business_name = $request['business'];
            }
            // $business_name = $request['business_name'];
            if(session("level") == "1"){
                $business_name = session("business_name");
            }
            // Check the data and remove ads from the CM
            $today = date("m/d/Y");
            if($today < $request['e_date'] && $request['user_level'] ==1 ){
                DB::table("tbl_ad")
                    ->where("business_name", $business_name)
                    ->update([
                        "playlist" => 0
                    ]);
                $medias = DB::table("tbl_ad")
                    ->where("business_name", $business_name)
                    ->get();
                foreach($medias as $media_temp){
                    $loca_name = explode(",",$media_temp->location);
                    foreach($loca_name as $loc_temp){
                        $sub_name = "Sub-".$business_name.$loc_temp;
                        $sub_id = $this->get_playlist_id_byname($sub_name);
                        if($sub_id != "false"){
                            $master_id = $this->get_mplaylist_id($loc_temp);
                            $this->delete_subplay_main($master_id,$sub_id);
                            $this->update_calculation($sub_id);
                            $this->update_calculation($master_id);
                        }
                    }    
                }                
            }
            $cur = DB::table('tbl_user')
                ->where('id', $request['tbl_id'])
                ->get()->first();
            if($cur->business_name != $business_name){
                $this->update_business_name($cur->business_name, $business_name);
            }
            // END OF THE Check the date
            DB::table("tbl_user")
                ->where("id",$request["tbl_id"])
                ->update([
                    "business_name" => $business_name,
                    "user_name" => $request["user_name"],
                    "email" => $request["email"],
                    "level" => $request["user_level"],
                ]);
            if($request['user_level'] == 1){
                // DB::table('tbl_sic_list')
                //     ->where('business_name', $business_name)
                //     ->delete();
                // DB::table('tbl_sic_list')
                //     ->INSERT([
                //         'sic_id' => $request['sic'],
                //         'business_name' => $business_name
                //     ]);
                // DB::table('tbl_sales_list')
                //     ->where('business_name', $business_name)
                //     ->delete();
                // DB::table('tbl_sales_list')
                //     ->INSERT([
                //         'sales_id' => $request['sales'],
                //         'business_name' => $business_name
                //     ]);
            }
            return "success";
        }
    }
    public function update_business_name($old_name,$new_name){
        DB::table('tbl_ad')
            ->where('business_name', $old_name)
            ->update([
                'business_name' => $new_name
            ]);
        DB::table('tbl_sales_list')
            ->where('business_name', $old_name)
            ->update([
                'business_name' => $new_name
            ]);
        DB::table('tbl_sic_list')
            ->where('business_name', $old_name)
            ->update([
                'business_name' => $new_name
            ]);
    }
    public function update_lock(Request $request){
        if($request['locked'] == 1){
            $location = $this->get_locations();
            foreach($location as $loc_temp){
                $sub_name = "Sub-".$request['business_name'].$loc_temp['name'];
                $sub_id = $this->get_playlist_id_byname($sub_name);
                if($sub_id != "false"){
                    $master_id = $this->get_mplaylist_id($loc_temp['name']);
                    $this->delete_subplay_main($master_id,$sub_id);
                    $this->update_calculation($sub_id);
                    $this->update_calculation($master_id);
                }
            }
        }
        DB::table('tbl_user')
            ->where('business_name',$request['business_name'])
            ->update([
                'user_lock' => $request['locked']
            ]);
        return "success";
    }
    public function get_playlist_id_byname($name){
        $urlname = str_replace(" ", "%20", $name);
        
        $apiToken =$this->get_token();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/findByName/".$urlname,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "apiToken: ".$apiToken
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $exist_flag = 'false';
        $playlist_id = 0;
        $res = json_decode($response, true);
        if(isset($res['id'])){
            return $res['id'];
        }
        else{
            return "false";
        }
    }
    public function delete_trust(Request $request){
        // if($request['multi_id'] != ""){
        //     DB::table("tbl_multi")
        //         ->where('id', $request['multi_id'])
        //         ->delete();
        //     return "success";
        // }
        // $multi_exit = DB::table("tbl_multi")->where('user_id', $request['id'])->count();
        // if($multi_exit > 0){
        //     return "Multi";
        // }
        $playlist = DB::table("tbl_user")
            ->where("id",$request["id"])
            ->get()->first();
        $playlist_id = $playlist->playlist_id;
        $sub_playlist = $playlist->sub_playlist;
        $this->delete_paylist($playlist_id);
        $this->delete_paylist($sub_playlist);
        DB::table("tbl_user")->where("id",$request["id"])->delete();
        return "success";
    }
    public function delete_paylist($id){
        $apiToken = $this->get_token();
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/".$id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "DELETE",
        CURLOPT_HTTPHEADER => array(
            "apiToken: ".$apiToken
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
    // END OF TRUST AGENT LIST
    // Mange PlayList
    public function get_mainplay(Request $request){
        $playlist = DB::table("tbl_user")
            ->where("playlist_id","!=",null)
            ->where("level","1")
            ->get();
        return $playlist;
    }
    public function create_master(Request $request){
        $apiToken = $this->get_token();
        $curl = curl_init();

        curl_setopt_array($curl, array(
                CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS =>"{\n \"name\":\"".$request['name']."\",\n \"description\":\"MASTER PLAYLIST ".$request['name']."\" ,\n \"playlistType\":\"MEDIA_PLAYLIST\" ,\n \"healthy\":\"true\" ,\n \"enableSmartPlaylist\":\"false\" ,\n \"sortOrder\" : \"0\"\n }",
                CURLOPT_HTTPHEADER => array(
                        "Content-Type: application/json",
                        "apiToken: ".$apiToken
                ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $res = json_decode($response, true);
        if(isset($res['id'])){
            return 'success';
        }
        else{
            return 'fail';
        }
    }
    // END OF PLAYLIST
    // manage location by bisiness name
    public function get_location_by_busiess(Request $request){
        // $business_name = $this->get_business_name();
        if($request['status'] == ""){
            $business_name = DB::table("tbl_user")
                ->where("business_name" ,"!=", null)
                ->where("business_name" ,"!=", "")
                ->groupBy('business_name')
                ->get();
        }
        else{
            $business_name = DB::table("tbl_user")
                ->where("business_name" ,"!=", null)
                ->where("business_name" ,"!=", "")
                ->where('user_lock',$request['status'])
                ->groupBy('business_name')
                ->get();
        }

        $location = DB::table('tbl_location_by_name')
            ->leftJoin('tbl_locations','tbl_location_by_name.location_id','tbl_locations.id')
            ->select('tbl_locations.name as location_name','tbl_location_by_name.*')
            ->orderBy('tbl_location_by_name.business_name')
            ->get();
        $result = array();
        foreach($business_name as $bus_temp){
            $data = array();
            $data['business_name'] = $bus_temp->business_name;
            $data['day_plan'] = $bus_temp->day_plan;
            $data['user_level'] = $bus_temp->level;
            $data['user_lock'] = $bus_temp->user_lock;
            $data['location_id'] = [];
            $data['location_name'] = [];
            array_push($result,$data);
        }
        foreach($location as $loc_temp){
            foreach($result as $val => $res){
                if($res['business_name'] == $loc_temp->business_name){
                    array_push($result[$val]['location_id'],$loc_temp->location_id);
                    array_push($result[$val]['location_name'],$loc_temp->location_name);
                }
            }
        }
        return $result;
    }
    // Day Plan
    public function update_day_plan(Request $request){
        DB::table("tbl_user")
            ->where('business_name' , $request['business_name'])
            ->update([
                'day_plan' => $request['day_plan']
            ]);
        return "success";
    }
    public function get_day_plan(Request $request){
        $day_plan = DB::table('tbl_user')
            ->where('business_name' , $request['business_name'])
            ->get()->first();
        return $day_plan->day_plan;
    }
    // End of day plan

    public function update_location(Request $request){
        $location_list = explode(',', $request['location_list']);
        DB::table('tbl_location_by_name')
            ->where("business_name",$request['business_name'])
            ->delete();
        foreach($location_list as $temp){
            DB::table('tbl_location_by_name')
                ->INSERT([
                    "business_name" => $request['business_name'],
                    "location_id" => $temp
                ]);
        }
        return "success";
    }
    // end of manage location by bisiness name
    // Manage Template
    public function get_business_name(){
        $business_name = DB::table("tbl_user")
            ->where("business_name" ,"!=", null)
            ->where("business_name" ,"!=", "")
            ->where("user_lock", "!=", 1)
            ->groupBy('business_name')
            ->get();
        return $business_name;
    }

    public function get_business_name_by_session(){
        if(session('level') == 0){
            $business_name = DB::table("tbl_user")
                ->where('id', session('user_id'))
                ->whereIn('tbl_user.level', [0, 1])
                ->groupBy('business_name')
                ->get();
        }
        else if(session('level') == 1){
            $business_name = DB::table("tbl_user")
                ->where('business_name', session('business_name'))
                ->whereIn('tbl_user.level', [0, 1])
                ->groupBy('business_name')
                ->get();
        }
        else if(session('level') == 2){
            $business_name = DB::table("tbl_user")
                ->where("business_name" ,"!=", null)
                ->where("business_name" ,"!=", "")
                ->whereIn('tbl_user.level', [0, 1])
                ->groupBy('business_name')
                ->get();
        }
        else if(session('level') == 3){
            $business_name = DB::table("tbl_user")
                ->leftJoin('tbl_business', 'tbl_business.primary_id', 'tbl_user.id')
                ->where("business_name" ,"!=", null)
                ->where("business_name" ,"!=", "")
                ->where('tbl_business.super', session('user_id'))
                ->where("user_lock", "!=", 1)
                ->whereIn('tbl_user.level', [0, 1])
                ->groupBy('business_name')
                ->get();
        }
        else if(session('level') == 4){
            $business_name = DB::table("tbl_user")
                ->leftJoin('tbl_business', 'tbl_business.primary_id', 'tbl_user.id')
                ->where("business_name" ,"!=", null)
                ->where("business_name" ,"!=", "")
                ->where("user_lock", "!=", 1)
                ->where('tbl_business.sales', session('user_id'))
                ->whereIn('tbl_user.level', [0, 1])
                ->groupBy('business_name')
                ->get();
        }
        else{
            $business_name = DB::table("tbl_user")
                ->leftJoin('tbl_business', 'tbl_business.primary_id', 'tbl_user.id')
                ->where("business_name" ,"!=", null)
                ->where("business_name" ,"!=", "")
                ->where("user_lock", "!=", 1)
                ->where('tbl_business.graphic', session('user_id'))
                ->whereIn('tbl_user.level', [0, 1])
                ->groupBy('business_name')
                ->get();
        }
        return $business_name;
    }
    
    public function get_business_customer_name_by_session(){
        if(session('level') == 0){
            $business_name = DB::table("tbl_user")
                ->where('id', session('user_id'))
                ->whereIn('level', [0,1])
                ->groupBy('business_name')
                ->get();
        }
        else if(session('level') == 1){
            $business_name = DB::table("tbl_user")
                ->where('business_name', session('business_name'))
                ->whereIn('level', [0,1])
                ->groupBy('business_name')
                ->get();
        }
        else if(session('level') == 2){
            $business_name = DB::table("tbl_user")
                ->where("business_name" ,"!=", null)
                ->where("business_name" ,"!=", "")
                ->whereIn('level', [0,1])
                ->groupBy('business_name')
                ->get();
        }
        else if(session('level') == 3){
            $business_name = DB::table("tbl_user")
                ->leftJoin('tbl_business', 'tbl_business.primary_id', 'tbl_user.id')
                ->where("business_name" ,"!=", null)
                ->where("business_name" ,"!=", "")
                ->where('tbl_business.super', session('user_id'))
                ->where("user_lock", "!=", 1)
                ->whereIn('level', [0,1])
                ->groupBy('business_name')
                ->get();
        }
        else if(session('level') == 4){
            $business_name = DB::table("tbl_user")
                ->leftJoin('tbl_business', 'tbl_business.primary_id', 'tbl_user.id')
                ->where("business_name" ,"!=", null)
                ->where("business_name" ,"!=", "")
                ->where("user_lock", "!=", 1)
                ->where('tbl_business.sales', session('user_id'))
                ->whereIn('level', [0,1])
                ->groupBy('business_name')
                ->get();
        }
        else{
            $business_name = DB::table("tbl_user")
                ->leftJoin('tbl_business', 'tbl_business.primary_id', 'tbl_user.id')
                ->where("business_name" ,"!=", null)
                ->where("business_name" ,"!=", "")
                ->where("user_lock", "!=", 1)
                ->where('tbl_business.graphic', session('user_id'))
                ->whereIn('level', [0,1])
                ->groupBy('business_name')
                ->get();
        }
        return $business_name;
    }
    public function get_multi(){
        // $multi = DB::table("tbl_multi")
        //     ->LEFTJOIN("tbl_user","tbl_user.id","tbl_multi.id")
        //     ->select("tbl_user.*")
        //     ->where('user_id',session("user_id"))
        //     ->get();
        // return $multi;
        $multi = DB::table('tbl_multi')
            ->leftJoin('tbl_user','tbl_user.id','=','tbl_multi.user_id')
            // ->leftJoin('tbl_user','tbl_user.business_name','=','tbl_multi.com_name')
            ->select('tbl_user.*','tbl_multi.com_name','tbl_multi.id as multi_id')
            ->where("tbl_multi.user_id",session("user_id"))
            ->where('tbl_multi.com_name' , '!=', null)
            ->where("tbl_user.user_lock", "!=", 1);
        $users = DB::table("tbl_user")
            ->select('tbl_user.*','tbl_user.id as com_name','tbl_user.m_id as multi_id')
            ->union($multi)
            ->where("tbl_user.id",session("user_id"))
            ->where("tbl_user.user_lock", "!=", 1)
            ->where('tbl_user.business_name' , '!=', null)
            ->get();
        
        return $users;
    }
    public function check_multi(){
        $multi = DB::table('tbl_multi')
            ->where('user_id',session("user_id"))
            ->get()->count();
        return $multi;
    }
    public function get_social_status(Request $request){
        $user = DB::table('tbl_user')
            ->where('id',$request['id'])
            ->select('f_token','l_token','t_token','f_account','l_account','t_account')
            ->get()->first();
        return json_encode($user);
    }
    public function get_temp(Request $request){
        $temp = DB::table("tbl_template")->get();
        return $temp;
    }
    public function get_temp_manage(Request $request){
        if($request['business_name'] != ""){
            $temp = DB::table("tbl_template")
                ->where("business_name",$request['business_name'])
                ->get();
            return $temp;
        }
        
    }
    public function delete_template(Request $request){
        DB::table("tbl_template")->where("id",$request["id"])->delete();
        return "success";
    }
    public function doCurl($URL, $data, $type = "POST"){
        $baseURL = 'http://avacms10.scala.com/ContentManager/api';//The base URL for the API
        if(!function_exists('curl_init')){//Check if cURL is available
            print_r('Sorry cURL is not installed!'); exit();
        }
        $ch = curl_init();  
        //Set the header information
        $apiToken = $this->get_token();
        $header_info = array('Accept: application/json', 
                            'Accept-Encoding: gzip, deflate, compress',
                            'Content-Type: application/json; charset=utf-8',
                            'apiToken: '.$apiToken); //Read from cookie or however, depending on your logic    
        if($type === "POST"){
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }else if($type === "PUT"){
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  //The file content
            //Adding more information to the header
            array_push($header_info, "Content-Length: XX"); //Eg: filesize($_FILES[0]['tmp_name']); 
            array_push($header_info, "Content-Disposition: attachment; filename = 'XXX.XXX'");     
        }//You could add GET and DELETE here
        
        curl_setopt($ch, CURLOPT_URL, $baseURL.$URL);    
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header_info);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
    public function create_temp(Request $request){
        $dis_text = 1;
        if(isset($request['dis_text'])){
            $dis_text = 0;
        }
        $file = $request->file("bg_img");

        if(isset($file)){
            $file_name = str_replace(" ","-",$file->getClientOriginalName());
            $cre_date = date("Y-m-dH-i-s");
            $file->move("upload/",$cre_date.$file_name);
            $primary = "0";
            $temp_id = DB::table("tbl_template")
                ->insertGetId([
                    "business_name" => $request['business_name'],
                    "template_name" => $request['temp_name'],
                    "location" => $request['location'],
                    "bg_img" => $cre_date.$file_name,
                    "over_w" => $request['over_w'],
                    "over_h" => $request['over_h'],
                    "over_l" => $request['over_l'],
                    "over_t" => $request['over_t'],
                    "font_s" => $request['font_s'],
                    "font_c" => $request['font_c'],
                    "font_w" => $request['font_w'],
                    "font_t" => $request['font_t'],
                    "font_l" => $request['font_l'],
                    "font_r" => $request['font_r'],
                    "align" => $request['font_align'],
                    "t_limit" => $request['t_limit'],
                    "primary" => $primary,
                    "dis_text" => $dis_text
            ]);
            // Overlay Image
            $over_file = $request->file('overlay_img');
            if(isset($over_file)){
                $cre_date = date("Y-m-dH-i-s");
                $o_file_name = $cre_date.str_replace(" ","-",$over_file->getClientOriginalName());
                $over_file->move("upload/",$o_file_name);
                DB::table('tbl_template')
                    ->where('id', $temp_id)
                    ->update([
                        "over_img" => $o_file_name
                    ]);
            }
            return "success";
        }
        else{
            return "fail";
        }
    }
    public function update_temp(Request $request){
        // return $request;
        $dis_text = 1;
        if(isset($request['dis_text'])){
            $dis_text = 0;
        }
        $file = $request->file("bg_img");
        $primary = "0";
        if(isset($file)){
            $file_name = str_replace(" ","-",$file->getClientOriginalName());
            $cre_date = date("Y-m-dH-i-s");
            $file->move("upload/",$cre_date.$file_name);
            DB::table("tbl_template")
                ->where("id",$request['update_id'])
                ->UPDATE([
                    "business_name" => $request['business_name'],
                    "template_name" => $request['temp_name'],
                    "location" => $request['location'],
                    "bg_img" => $cre_date.$file_name,
                    "over_w" => $request['over_w'],
                    "over_h" => $request['over_h'],
                    "over_l" => $request['over_l'],
                    "over_t" => $request['over_t'],
                    "font_s" => $request['font_s'],
                    "font_c" => $request['font_c'],
                    "font_w" => $request['font_w'],
                    "font_t" => $request['font_t'],
                    "font_l" => $request['font_l'],
                    "font_r" => $request['font_r'],
                    "align" => $request['font_align'],
                    "t_limit" => $request['t_limit'],
                    "primary" => $primary,
                    "dis_text" => $dis_text,
            ]);
            // Overlay Image
            $over_file = $request->file('overlay_img');
            if(isset($over_file)){
                $cre_date = date("Y-m-dH-i-s");
                $o_file_name = $cre_date.str_replace(" ","-",$over_file->getClientOriginalName());
                $over_file->move("upload/",$o_file_name);
                DB::table('tbl_template')
                    ->where('id', $request['update_id'])
                    ->update([
                        "over_img" => $o_file_name
                    ]);
            }
            return "success";
        }
        else{
            DB::table("tbl_template")
                ->where("id",$request['update_id'])
                ->UPDATE([
                    "business_name" => $request['business_name'],
                    "template_name" => $request['temp_name'],
                    "location" => $request['location'],
                    "over_w" => $request['over_w'],
                    "over_h" => $request['over_h'],
                    "over_l" => $request['over_l'],
                    "over_t" => $request['over_t'],
                    "font_s" => $request['font_s'],
                    "font_c" => $request['font_c'],
                    "font_w" => $request['font_w'],
                    "font_t" => $request['font_t'],
                    "font_l" => $request['font_l'],
                    "font_r" => $request['font_r'],
                    "align" => $request['font_align'],
                    "t_limit" => $request['t_limit'],
                    "primary" => $primary,
                    "dis_text" => $dis_text,
            ]);
            // Overlay Image
            $over_file = $request->file('overlay_img');
            if(isset($over_file)){
                $cre_date = date("Y-m-dH-i-s");
                $o_file_name = $cre_date.str_replace(" ","-",$over_file->getClientOriginalName());
                $over_file->move("upload/",$o_file_name);
                DB::table('tbl_template')
                    ->where('id', $request['update_id'])
                    ->update([
                        "over_img" => $o_file_name
                    ]);
            }
            return "success";
        }
    }
    public function get_locations_by_name(Request $request){
        $location = "";
        $business_name = $request['business_name'];
        $location_list = DB::table("tbl_location_by_name")
            ->where('business_name' , $business_name)
            ->leftJoin("tbl_locations","tbl_locations.id","tbl_location_by_name.location_id")
            ->select("tbl_locations.name","tbl_location_by_name.*")
            ->get();
        $restrict = RestrictLocation::where('business_name', $business_name)->get();
        foreach($location_list as $temp_loca){
            $exist = 0;
            foreach($restrict as $key => $val){
                if($val->location_id == $temp_loca->location_id){
                    $exist = 1;
                }
            }
            if($exist == 0){
                $location .= $temp_loca->name.",";
            }
        }
        return $location;
    }
    public function get_locations_by_business_name(Request $request){
        $location = [];
        $business_name = $request['business_name'];
        $location_list = DB::table("tbl_location_by_name")
            ->where('business_name' , $business_name)
            ->leftJoin("tbl_locations","tbl_locations.id","tbl_location_by_name.location_id")
            ->select("tbl_locations.name","tbl_location_by_name.*","tbl_locations.id as location_id")
            ->get();
        // $restrict = RestrictLocation::where('business_name', $business_name)->get();
        // foreach($location_list as $temp_loca){
        //     $exist = 0;
        //     foreach($restrict as $key => $val){
        //         if($val->location_id == $temp_loca->location_id){
        //             $exist = 1;
        //         }
        //     }
        //     if($exist == 0){
        //         $temp = [];
        //         $temp['name'] = $temp_loca->name;
        //         $temp['id'] = $temp_loca->location_id;
        //         array_push($location, $temp);
        //     }
        // }
        $result = [];
        $result['success'] = true;
        $result['locations'] = $location;
        $result['locations'] = $location_list;
        return $result;
    }
    public function get_template_byid(Request $request){
        $temp = DB::table("tbl_template")
            ->where("id",$request["id"])
            ->get();
        $size = DB::table("tbl_locations")->get();

        $location_list = DB::table("tbl_location_by_name")
            ->leftJoin("tbl_locations","tbl_location_by_name.location_id","tbl_locations.id")
            ->select("tbl_locations.*")
            ->get();
        $temp_width = 0;
        $temp_height = 0;
        $ratio = 0;
        
        foreach($location_list as $location){
            if($location->width!=0 && $location->height != 0){
                $ratio = $location->width/$location->height;
                if($ratio == $location->width/$location->height && $temp_width < $location->width){
                    $temp_width = $location->width;
                    $temp_height = $location->height;
                }
            }
        }
        $temp[0]->temp_width = $temp_width;
        $temp[0]->temp_height = $temp_height;
        return $temp;
        // $temp_loc =explode(",",$temp[0]->location);
        // $ratio = 0;
        // $temp_width = 0;
        // $temp_height = 0;
        // foreach($temp_loc as $temp1){
        //     foreach($size as $size_temp){
        //         if($size_temp->name == $temp1){
        //             $ratio = $size_temp->width/$size_temp->height;
        //         }
        //         if($ratio == $size_temp->width/$size_temp->height && $temp_width < $size_temp->width){
        //             $temp_width = $size_temp->width;
        //             $temp_height = $size_temp->height;
        //         }
        //     }
        // }
        // $temp[0]->temp_width = $temp_width;
        // $temp[0]->temp_height = $temp_height;
        // return $temp;
    }
    // END OF MANAGE TEMPLATE
    // Manage AD
    public function convert_img(Request $request){
        $file_types = ['image/png', 'image/jpg', 'image/jpeg'];
        define('UPLOAD_DIR', 'upload/');
        $image_parts = explode(";base64,", $request['image']);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        $extension = $request['file'];
        if(!in_array($extension, $file_types)){
            $result = [];
            $result['success'] = false;
            $result['message'] = 'Please upload *.png, *.jpg, *.jpeg files';
            return $result;
        }

        // $image_base64 = base64_decode($image_parts[1]);
        $file_name = 'image_' . time() . '.png';
        $file = UPLOAD_DIR . $file_name;
        // file_put_contents($file, $image_base64);
        $image_base64 = base64_decode(str_replace('data:image/png;base64,','', $request['image']));
        file_put_contents($file, $image_base64);
        // $this->correctImageOrientation($file);
        $result = [];
        $result['success'] = true;
        $result['file_name'] = $file_name;
        return $result;
    }

    function correctImageOrientation($filename) {
        if (function_exists('exif_read_data')) {
            $exif = exif_read_data('/upload/'.$filename);
            if($exif && isset($exif['Orientation'])) {
                $orientation = $exif['Orientation'];
                if($orientation != 1){
                    $img = imagecreatefromjpeg($filename);
                    $deg = 0;
                    switch ($orientation) {
                        case 3:
                        $deg = 180;
                        break;
                        case 6:
                        $deg = 270;
                        break;
                        case 8:
                        $deg = 90;
                        break;
                    }
                    if ($deg) {
                        $img = imagerotate($img, $deg, 0);        
                    }
                    // then rewrite the rotated image back to the disk as $filename 
                    imagejpeg($img, $filename, 95);
                } // if there is some rotation necessary
            } // if have the exif orientation info
        } // if function exists      
    }
    public function get_token(){
        $token = CMToken::first();
        return $token->token;
    }
    public function create_ad1(Request $request){
        $cre_date = date("Y-m-dH-i-s");
        $contents = File::get(base_path().'/public/upload/'.$request['img_url']);
        // $contents = str_replace('(url)',$request['img_url'],$contents);
        // File::put(base_path().'/public/result_html/'.$cre_date.'.html', $contents);
        $dis_name = session("business_name").$cre_date;
        $img_path =base_path().'/public/upload/'.$request['img_url'];
        if($request["temp_id"] != "" || $request["temp_id"] != null){
            $primary_temp = DB::table("tbl_template")
                ->where("id",$request['temp_id'])
                ->get()->first();
            $primary = "0";
            $playlist = "0";
            if($primary_temp->primary == "1"){
                $primary  = "1";
                $playlist = "1";
                DB::table("tbl_ad")
                    ->where("business_name",$request["business_name"])
                    ->where("primary","1")
                    ->delete();
            }
            // Init CM
            $apiToken = $this->get_token();

            $curl = curl_init();

            curl_setopt_array($curl, array(
                    CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/fileupload/init",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS =>"{\n\t\"filename\": \"".$dis_name.".png\",\n\t\"filepath\": \"/0000-RL\",\n\t\"uploadType\": \"media_item\"\n}",
                    CURLOPT_HTTPHEADER => array(
                            "Content-Type: application/json",
                            "apiToken: ".$apiToken
                    ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $init_res = json_decode($response,true);
            $uuid = $init_res['uuid'];
            $media_id = $init_res['mediaId'];
            if($request["radio"] == "ime"){
                $curl = curl_init();
                curl_setopt_array($curl, array(
                        CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/fileupload/part/".$uuid."/0",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => array('file'=> new \CURLFILE($img_path),'apiToken' => $apiToken),
                        CURLOPT_HTTPHEADER => array(
                                "Content-Type: multipart/form-data",
                                "apiToken: ".$apiToken,
                                "Accept-Encoding: application/gzip"
                        ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                DB::table("tbl_ad")
                    ->insert([
                        "user_id" => session("user_id"),
                        "business_name" => $request["business_name"],
                        "temp_id" => $request['temp_id'],
                        "location" => $request['location'],
                        "img_url" => $request['img_url'],
                        "schedule" => $request["radio"],
                        "s_date" => date("Y-m-d"),
                        "s_time" => "12 AM",
                        "e_time" => "12 AM",
                        "e_date" => "No End date",
                        "cre_date" => $cre_date,
                        "media_id" => $media_id,
                        "days" => "0,1,2,3,4,5,6,",
                        "primary" =>$primary ,
                        "playlist" =>$playlist 
                    ]);
                
                return "success";
            }
            else{
                $end_date = "No End date";
                // $media_id = "";
                if($request["no_end"] != "on"){
                    $end_date = $request['e_date'];
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                            CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/fileupload/part/".$uuid."/0",
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "POST",
                            CURLOPT_POSTFIELDS => array('file'=> new \CURLFILE($img_path),'apiToken' => $apiToken),
                            CURLOPT_HTTPHEADER => array(
                                    "Content-Type: multipart/form-data",
                                    "apiToken: ".$apiToken,
                                    "Accept-Encoding: application/gzip"
                            ),
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);
                }
                else{
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                            CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/fileupload/part/".$uuid."/0",
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "POST",
                            CURLOPT_POSTFIELDS => array('file'=> new \CURLFILE($img_path),'apiToken' => $apiToken),
                            CURLOPT_HTTPHEADER => array(
                                    "Content-Type: multipart/form-data",
                                    "apiToken: ".$apiToken,
                                    "Accept-Encoding: application/gzip"
                            ),
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);
                }
                DB::table("tbl_ad")
                    ->insert([
                        "user_id" => session("user_id"),
                        "business_name" => $request["business_name"],
                        "temp_id" => $request['temp_id'],
                        "location" => $request['location'],
                        "img_url" => $request['img_url'],
                        "schedule" => $request["radio"],
                        "s_date" => $request["s_date"],
                        "s_time" => $request["s_time"],
                        "e_time" => $request["e_time"],
                        "e_date" => $end_date,
                        "cre_date" => $cre_date,
                        "media_id" => $media_id,
                        "days" => $request["days"],
                        "primary" =>$primary ,
                        "playlist" =>$playlist 
                    ]);
                
                return "success";
            }
        }
        else{
            return "temp_id";
        }
    }

    public function create_ad(Request $request){
        if(session('level') == 2){
            $business_name = $request['business_name'];
        }
        else{
            if(isset($request['multiple'])){
                $business_name = $request['business_name'];
            }
            else{
                $business_name = session('business_name');
            }
        }
        $cre_date = date("Y-m-dH-i-s");
        $contents = File::get(base_path().'/public/upload/'.$request['img_url']);
        $restrict = 0;
        if(isset($request['restrict']) && $request['restrict'] == 1){
            $restrict = 1;
        }
        // $contents = str_replace('(url)',$request['img_url'],$contents);
        // File::put(base_path().'/public/result_html/'.$cre_date.'.html', $contents);
        $dis_name = $business_name.$cre_date;
        $img_path =base_path().'/public/upload/'.$request['img_url'];
        if($request["temp_id"] != "" || $request["temp_id"] != null){
            $primary_temp = DB::table("tbl_template")
                ->where("id",$request['temp_id'])
                ->get()->first();
            $primary = "0";
            $playlist = "0";
            if($primary_temp->primary == "1"){
                $primary  = "1";
                $playlist = "1";
                DB::table("tbl_ad")
                    ->where("business_name",$business_name)
                    ->where("primary","1")
                    ->delete();
            }
            if($request["radio"] == "ime"){
                $ad_id = DB::table("tbl_ad")
                    ->insertGetId([
                        "user_id" => session("user_id"),
                        "business_name" => $business_name,
                        "temp_id" => $request['temp_id'],
                        "location" => $request['location'],
                        "img_url" => $request['img_url'],
                        "schedule" => $request["radio"],
                        "rest" => $restrict,
                        "s_date" => date("Y-m-d"),
                        "s_time" => "12 AM",
                        "e_time" => "12 AM",
                        "e_date" => "No End date",
                        "cre_date" => $cre_date,
                        // "media_id" => $media_id,
                        "days" => "0,1,2,3,4,5,6,",
                        "primary" =>$primary ,
                        "playlist" =>$playlist 
                    ]);
                // History
                $this->add_history('4', $ad_id, $business_name, "Created");
                return "success";
            }
            else{
                if($request['no_end'] == "0"){
                    $end_date = $request['e_date'];
                }
                else{
                    $end_date = "No End date";
                }
                $ad_id = DB::table("tbl_ad")
                    ->insertGetId([
                        "user_id" => session("user_id"),
                        "business_name" => $business_name,
                        "temp_id" => $request['temp_id'],
                        "location" => $request['location'],
                        "rest" => $restrict,
                        "img_url" => $request['img_url'],
                        "schedule" => $request["radio"],
                        "s_date" => $request["s_date"],
                        "s_time" => $request["s_time"],
                        "e_time" => $request["e_time"],
                        "e_date" => $end_date,
                        "cre_date" => $cre_date,
                        // "media_id" => $media_id,
                        "days" => $request["days"],
                        "primary" =>$primary ,
                        "playlist" =>$playlist 
                    ]);
                // History
                $this->add_history('4', $ad_id, $business_name, "Created");
                // Update the schedule in the case of 2 days option
                $business_status = DB::table("tbl_user")
                        ->where("business_name",$business_name)
                        ->get()->first();
                $day_plan = $business_status->day_plan;
                if($day_plan == 1){
                    DB::table("tbl_ad")
                        ->where('business_name',$business_name)
                        ->update([
                            "days" => $request['days'],
                            "schedule" => "frame"
                        ]);
                }
                // End of the update the shedule
                return "success";
            }
        }
        else{
            return "temp_id";
        }
    }

    public function get_ad(){
        if(session('level') == 2){
            $ad = DB::table("tbl_ad")
                ->leftJoin("tbl_template","tbl_template.id","tbl_ad.temp_id")
                ->select("tbl_ad.*","tbl_template.template_name")
                ->get();
        }
        else{
            $ad = DB::table("tbl_ad")
                ->leftJoin("tbl_template","tbl_template.id","tbl_ad.temp_id")
                ->where('tbl_ad.business_name',session("business_name"))
                ->select("tbl_ad.*","tbl_template.template_name")
                ->get();
        }
        return $ad;
    }
    public function get_all_ad(){
        $ad = DB::table("tbl_ad")->where("playlist",'1')->get();
        return $ad;
    }
    public function get_ad_byid(Request $request){
        if($request['business_name'] != ""){
            $ad = DB::table("tbl_ad")
                ->leftJoin("tbl_template","tbl_template.id","tbl_ad.temp_id")
                ->leftJoin("tbl_user","tbl_user.business_name","tbl_ad.business_name")
                ->where("tbl_ad.business_name",$request["business_name"])
                ->select("tbl_ad.*","tbl_template.template_name",'tbl_user.day_plan')
                ->groupby('tbl_ad.id')
                ->get();
            // $location_list = DB::table("tbl_location_by_name")
            //     ->leftJoin("tbl_location","tbl_location.id","tbl_location_by_name.location_id")
            //     ->select("tbl_location.*")
            //     ->get();
            // $location = "";
            // foreach($location_list as $temp_location){
            //     $location = $temp_location->name.",";
            // }
            // foreach($ad as $val=> $temp_ad){
            //     $ad[$val]['location']
            // }
            foreach($ad as $key => $val){
                $s_date = date_create($val->s_date);
                $ad[$key]->s_date = date_format($s_date,"m-d-Y");
                if($val->e_date != "No End date"){
                    $e_date = date_create($val->e_date);
                    $ad[$key]->e_date = date_format($e_date,"m-d-Y");
                }
            }
            
            return $ad;
        }
    }
    public function get_active_ad(Request $request){
        $active_ad = DB::table("tbl_ad")
            ->where("business_name", $request["business_name"])
            ->where("playlist","1")
            ->get();
        return $active_ad;
    }
    public function delete_ad(Request $request){
        $media = DB::table("tbl_ad")->where("id",$request["id"])->get()->first();
        // History
        $this->add_history('2', $request['id'], $media->business_name, "Deleted");
        $media_id = $media->media_id;
        $location = explode(",",$media->location);
        $business_name = $media->business_name;
        for($i=0; $i < count($location)-1;$i++){
            $sub_id = $this->get_playlist_id("Sub-".$business_name.$location[$i]);
            $this->delete_media_from_subplaylist($sub_id,$media_id);
            $this->delete_media_cm($media_id);
            $this->update_calculation($sub_id);
        }
        DB::table("tbl_ad")
            ->where("id",$request["id"])
            ->delete();
        if (File::exists(base_path('/public/upload/' .$media->img_url))) {
          File::delete(base_path('/public/upload/' .$media->img_url));
        }
        return "success";
    }
    public function delete_media_cm($media_id){
        $apiToken = $this->get_token();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/media/".$media_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_POSTFIELDS =>"",
            CURLOPT_HTTPHEADER => array(
                    "apiToken: ".$apiToken,
                    "Content-Type: application/json"
                ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
    }
    // Delete Media From subplaylist
    public function delete_media_from_subplaylist($sub_id,$media_id){
        $apiToken = $this->get_token();
        $curl = curl_init();

        curl_setopt_array($curl, array(
                CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/".$sub_id."?fields=playlistItems",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "apiToken: ".$apiToken
                ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;
        $item_id = 0;
        $res = json_decode($response,true);
        if(isset($res['playlistItems'])){
            $playlistItems = $res['playlistItems'];
            foreach($playlistItems as $temp){
                if($temp['media']['id'] == $media_id){
                    $item_id = $temp['id'];
                }
            }
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/".$sub_id."/playlistItems/".$item_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_POSTFIELDS =>"{\n\t\"playlistItemType\" : \"SUB_PLAYLIST\"\n}",
            CURLOPT_HTTPHEADER => array(
                    "apiToken: ".$apiToken,
                    "Content-Type: application/json"
                ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
    }
    // 
    public function update_ad_list(Request $request){
        $media = DB::table("tbl_ad")->where("id",$request["id"])->get()->first();
        DB::table("tbl_ad")
            ->where("id",$request["id"])
            ->update([
                "id" => $request["id"],
                "playlist" => $request["playlist"]
            ]);
        $ads = DB::table('tbl_ad')
            ->where('id', $request['id'])
            ->first();
        $extra = "Checked Boxes";
        if($request['playlist'] == 0){
            $extra = "Unchecked Boxes";
        }
        return "success";
    }
    // END OF MANAGE AD
    // Suggest
    public function save_suggest(Request $request){
        $type = 0;
        if(isset($request['type'])){
            $type = 1;
        }
        $suggest = new SuggestionModel;
        $suggest->user_id = session('user_id');
        $suggest->content = $request['content'];
        $suggest->business_name = session('business_name');
        $suggest->type = $type;
        $suggest->save();
        $suggest_id = $suggest->id;
        // DB::table("tbl_suggest")
        //     ->insert([
        //         "user_id" => session("user_id"),
        //         "content" => $request['content'],
        //         "business_name" => session("business_name"),
        //         "type" => $type,
        //     ]);
        $result = array();
        $result['success'] = true;
        $result['id'] = $suggest_id;
        $this->text_suggest($suggest_id);
        return $result;
        return "success";
    }
    public function update_suggest(Request $request){
        DB::table('tbl_suggest')
            ->where('id', $request['id'])
            ->update([
                'content' => $request['content'],
                'hour' => $request['hour'],
            ]);
        return "success";
    }
    public function get_suggestion(Request $request){
        $suggest = DB::table("tbl_suggest")
            ->leftjoin('tbl_user', 'tbl_user.id', 'tbl_suggest.user_id')
            ->select('tbl_suggest.*', 'tbl_user.user_name')
            ->where("tbl_suggest.type", 0)
            ->orderby('content')
            ->get();
        foreach($suggest as $key => $val){
            $cre_date = date_create($val->cre_date);
            $suggest[$key]->cre_date = date_format($cre_date,"m-d-Y");
        }
        return $suggest;
    }
    public function text_suggest($id){
        $suggest_id = $id;
        $suggest = DB::table('tbl_suggest')
            ->where('id', $suggest_id)
            ->first();
        Mail::to('4054147120@tmomail.net')->send(new TextSuggest($suggest));
        Mail::to('4054940599@tmomail.net')->send(new TextSuggest($suggest));
        return "success";
    }
    // End of suggestion
    public function get_suggestion_dashboard(Request $request){
        $suggest = DB::table("tbl_suggest")
            ->leftjoin('tbl_user', 'tbl_user.id', 'tbl_suggest.user_id')
            ->select('tbl_suggest.*', 'tbl_user.user_name')
            ->where("tbl_suggest.type", 1)
            ->orderby('content')
            ->get();
        foreach($suggest as $key => $val){
            $cre_date = date_create($val->cre_date);
            $suggest[$key]->cre_date = date_format($cre_date,"m-d-Y");
        }
        return $suggest;
    }
    public function delete_suggestion(Request $request){
        $suggest = DB::table("tbl_suggest")->where('id',$request['id'])->delete();
        return 'success';
    }
    public function update_fixed(Request $request){
        SuggestionModel::where('id', $request['id'])
            ->update([
                'fixed' => $request['fixed']
            ]);
        // Update History of View
        if($request['fixed'] == 1){
            $history = new UpateHistory;
            $history->user_id = session('user_id');
            $history->suggestion_id = $request['id'];
            $history->save();
        }
        return "succes";
    }
    public function view_history(Request $request){
        if(Session::has('user_id') && session('level') == 2){
            $data = array();
            $data['page_name'] = "History of INEX updates";
            $data['history'] = UpateHistory::leftjoin('tbl_user', 'tbl_user.id', 'tbl_update_views.user_id')
                ->select("tbl_user.*", 'tbl_update_views.created_at')
                ->get();
            return view('admin.users.update-history-view', $data);
        }
        else{
            return redirect()->route('login');
        }
    }
    public function send_update(Request $request){
        $accounts = DB::table('tbl_user')
            ->where('level',4)->get();
        $suggestion = DB::table('tbl_suggest')->where('id', $request['id'])->first();
        foreach($accounts as $key => $val){
            if($val->notification == 0){
                Mail::to($val->email)->send(new InexUpdateMail($val,$suggestion));
            }
        }
        return redirect()->back()->withSuccess("Success");
    }
    // END OF SUGGEST
    // FOGET PASSOWRD
    public function forget(Request $request){
        $user = DB::table("tbl_user")->where("email",$request['email'])->get()->first();
        if(isset($user->email)){
            Mail::to($user->email)->send(new SendMailable($user->id, $user));
            return "success";
        }
        else{
            return "fail";
        }
    }
    public function reset(Request $request){        
        Validator::make($request->all(), [
            'password' => 'required|confirmed|min:6',
        ])->validate();
        $id = base64_decode($request["id"]);
        if(request()->route()->getName() == 'admin-pass'){
            Admin::where('id', $id)
                ->update([
                    // 'password' => Hash::make($request['password'])
                    'password' => $request['password']
                ]);
            $user = Admin::where('id', $id)->first();
            if (isset($user->id) && $user->user_lock == 0) {
                session(['email' => $user->email]);
                session(['user_name' => $user->name]);
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
                if($user->level == 1 && !isset($exist_log->id)){
                    return redirect()->route('welcome');
                }
                return redirect('dashboard');
            }
            return back()->withInput()->withErrors([
                'email' => 'Your account is inactived. Please contact us.',
            ]);
        }
        DB::table("tbl_user")
            ->where("id",$id)
            ->update([
                "password" => $request['password']
            ]);
        $user = DB::table('tbl_user')
                ->where('id', $id)
                ->first();
        if(!isset($user->id)){
          return back()->withInput()->withErrors([
            'email' => 'Invalid URL',
          ]);
        }
        if($user->user_lock == 1 && $user->level != 2){
          return back()->withInput()->withErrors([
            'email' => 'Your account is Inactivated',
          ]);
        }
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
        if($user->level == 2){
            return redirect()->route("manage_temp");
        }
        else{
            if($user->level == 1 && !isset($exist_log->id)){
                return redirect()->route('welcome');
            }
            return redirect()->route("dashboard");
        }
        return "success";
    }

    // Locations
    public function get_loca(){
        $location = DB::table("tbl_locations")
            ->orderby('name', 'asc')
            ->get();
        return $location;
    }
    public function get_locations(){
        $data = array();
        $location = DB::table("tbl_locations")
            ->leftJoin('tbl_public_locations', 'tbl_public_locations.location_id', 'tbl_locations.id')
            ->select('tbl_locations.*', 'tbl_public_locations.type')
            ->orderby('name', 'asc')
            ->get();
        foreach($location as $val => $size){
            // $main_id = $this->get_mplaylist_info($size->name);
            $data[$val]['id'] = $size->id;
            $data[$val]['price'] = $size->price;
            $data[$val]['discount'] = $size->discount;
            $data[$val]['cur_sub'] = $size->cur_sub;
            $data[$val]['itemCount'] = $size->cur_sub;
            $data[$val]['name'] = $size->name;
            $data[$val]['nickname'] = $size->nickname;
            $data[$val]['width'] = $size->width;

            $data[$val]['height'] = $size->height;
            $data[$val]['max'] = $size->max;
            $data[$val]['ratio'] = $size->width / $size->height;
            $data[$val]['type'] = $size->type;
        }
        return $data;
    }
    // public function get_locations(){
    //     $apiToken = $this->get_token();
    //     $curl = curl_init();

    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/channels?limit=10&offset=0&sort=name",
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => "",
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 0,
    //         CURLOPT_FOLLOWLOCATION => true,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => "GET",
    //         CURLOPT_HTTPHEADER => array(
    //             "apiToken: ".$apiToken
    //         ),
    //     ));

    //     $response = curl_exec($curl);

    //     curl_close($curl);
    //     $res = json_decode($response,true)['list'];
        
    //     $location = DB::table("tbl_locations")->get();
    //     foreach($res as $val => $loc_temp){
    //         foreach($location as $size){
    //             if($loc_temp['name'] == $size->name){
    //                 $res[$val]['width'] = $size->width;
    //                 $res[$val]['height'] = $size->height;
    //                 $res[$val]['max'] = $size->max;
    //                 $res[$val]['ratio'] = $size->width / $size->height;
    //                 $main_id = $this->get_mplaylist_info($loc_temp['name']);
    //                 // die(print_r($main_id));
    //                 $res[$val]['itemCount'] = $main_id;
    //             }
    //         }
    //     }
    //     return $res;
    // }
    public function get_mplaylist_info($name){
        $apiToken =$this->get_token();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/all/?limit=1000",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "apiToken: ".$apiToken
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $itemCount = 0;
        $res = json_decode($response, true);
        if(isset($res['list'])){
            $res = json_decode($response, true)['list'];
            foreach($res as $playlist){
                if($playlist['name'] == $name){
                    if(isset($playlist['playlistItems'])){
                        $playlistItems = $playlist['playlistItems'];
                        foreach($playlistItems as $temp){
                            if(isset($temp['subplaylist'])){
                                $itemCount ++;
                            }
                        }
                    }
                }
            }
        }
        return $itemCount;
    }
    public function delete_master(Request $request){
        $apiToken = $this->get_token();
        $curl = curl_init();

        curl_setopt_array($curl, array(
                CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/".$request['id'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "DELETE",
                CURLOPT_HTTPHEADER => array(
                        "apiToken: ".$apiToken
                ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo "success";

    }
    public function insert_location(Request $request){
        $location = DB::table("tbl_locations")
            ->where("name",$request['name'])
            ->get();
        if(isset($location->name)){
            return "fail";
        }
        else{
            DB::table("tbl_locations")
                ->Insert([
                    "name"  => $request["name"],
                    "nickname"  => $request["nickname"]
                ]);
            return "success";
        }
    }
    public function delete_locations(Request $request){
        DB::table("tbl_locations")->where("id",$request["id"])->delete();
        return "success";
    }
    public function update_locations(Request $request){
        $exist = DB::table("tbl_locations")->where("name",$request["name"])->get()->first();
        if(isset($exist->name)){
            DB::table("tbl_locations")->where("name",$request['name'])->update([
                'width' => $request['width'],
                'nickname' => $request['nickname'],
                'height' => $request['height'],
                'max' => $request['max'],
            ]);
            return "success";
        }
        else{
            DB::table("tbl_locations")->insert([
                'name' => $request['name'],
                'nickname' => $request['nickname'],
                'width' => $request['width'],
                'height' => $request['height'],
                'max' => $request['max'],
            ]);
            return "success";
        }
        // DB::table("tbl_locations")->where("id",$request["id"])->update([
        //     "name" => $request['name']
        // ]);
        return "success";
    }
    public function public_location(Request $request){
        if(Session::has('user_id') && session('level') == 2){
            $data['page_name'] = "Public / Private Locations";
            $data['locations'] = DB::table('tbl_locations')->get();
            $data['p_locations'] = PublicLocations::get();
            return view('admin.locations.public_location', $data);
        }
        else{
            return redirect()->back()->withErrors("You don't have permission to access this page");
        }
    }
    public function location_type(){
        $data = PublicLocations::get();
        return $data;
    }
    public function save_public_location(Request $request){
        if(isset($request['public'])){
            $public_list = $request['public'];
            $public_list = explode(",", $public_list);
            foreach($public_list as $key => $val){
                $exist = PublicLocations::where('location_id', $val)->first();
                if(isset($exist->id)){
                    PublicLocations::where('id',$exist->id)
                        ->update([
                            'type' => 0
                        ]);
                }
                else{
                    $public_location = new PublicLocations;
                    $public_location->type = 0;
                    $public_location->location_id = $val;
                    $public_location->save();
                }
            }
        }
        if(isset($request['private'])){
            $public_list = $request['private'];
            $public_list = explode(",", $public_list);
            foreach($public_list as $key => $val){
                $exist = PublicLocations::where('location_id', $val)->first();
                if(isset($exist->id)){
                    PublicLocations::where('id',$exist->id)
                        ->update([
                            'type' => 1
                        ]);
                }
                else{
                    $private_location = new PublicLocations;
                    $private_location->type = 1;
                    $private_location->location_id = $val;
                    $private_location->save();
                }
            }
        }
        return "success";
    }
    // END OF LOCATIONS
    // PlayList

    public function upload_media_to_cm($tbl_id,$dis_name,$img_path,$status,$media_id){
        // Init CM
        $apiToken = $this->get_token();
        if($status == 1){
            $cre_date = date("Y-m-dH-i-s");
            $dis_name = $dis_name.$tbl_id;
            $dis_name = str_replace(" ", "", $dis_name);
            $exist_flag = false;
            // List Media
            // $curl = curl_init();

            // curl_setopt_array($curl, array(
            //     CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/media",
            //     CURLOPT_RETURNTRANSFER => true,
            //     CURLOPT_ENCODING => "",
            //     CURLOPT_MAXREDIRS => 10,
            //     CURLOPT_TIMEOUT => 0,
            //     CURLOPT_FOLLOWLOCATION => true,
            //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //     CURLOPT_CUSTOMREQUEST => "GET",
            //     CURLOPT_HTTPHEADER => array(
            //         "apiToken: ".$apiToken
            //     ),
            // ));

            // $response = curl_exec($curl);

            // curl_close($curl);
            // $lists = json_decode($response,true);
            
            // foreach($lists as $key => $val){
            //     if(isset($val['name']) && $val['name'] == $dis_name.".png"){
            //         $exist_flag = true;
            //     }
            // }
            // // End of list media
            // if($exist_flag  == true){
            //     return false;
            // }

            $rand = rand(10,1000);
            $rand = md5($rand);
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/fileupload/init",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS =>"{\n\t\"filename\": \"".$dis_name.$rand.".png\",\n\t\"filepath\": \"/0000-RL\",\n\t\"uploadType\": \"media_item\"\n}",
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "apiToken: ".$apiToken
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $init_res = json_decode($response,true);
            $uuid = $init_res['uuid'];
            $media_id = $init_res['mediaId'];


            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/fileupload/part/".$uuid."/0",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => array('file'=> new \CURLFILE($img_path),'apiToken' => $apiToken),
                CURLOPT_HTTPHEADER => array(
                        "Content-Type: multipart/form-data",
                        "apiToken: ".$apiToken,
                        "Accept-Encoding: application/gzip"
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            DB::table("tbl_ad")
                ->where("id",$tbl_id)
                ->update([
                    "media_id" => $media_id
                ]);
            return $media_id;
        }
        else{
            $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/media/".$media_id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "DELETE",
                CURLOPT_HTTPHEADER => array(
                    "apiToken: ".$apiToken,
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
        }
        return "success";
    }
    public function publish_cm(Request $request){
        $today = date("Y-m-d");
        $avaliable = DB::table("tbl_user")
            ->where("business_name",$request['business_name'])
            ->where("level","1")
            ->whereOr("level","2")
            ->get()->first();
        $users = DB::table("tbl_user")->get();
        $playlist_id = "";
        $main_id = DB::table("tbl_user")
            ->where("level","1")
            ->where("business_name",$request['business_name'])
            ->get()->first();
        $sub_playlist = "";
        $apiToken = $this->get_token();
        // Publish
        DB::table("tbl_ad")
            ->where('playlist', "1")
            ->where('business_name', $request['business_name'])
            ->update([
                'publish' => 1
            ]);
        DB::table("tbl_ad")
            ->where('playlist', "0")
            ->where('business_name', $request['business_name'])
            ->update([
                'publish' => 0
            ]);
        return 'success';
    }
    public function publish_cm1(Request $request){
        $today = date("Y-m-d");
        $avaliable = DB::table("tbl_user")
            ->where("Business_name",$request['business_name'])
            ->where("level","1")
            ->whereOr("level","2")
            ->get()->first();
        // if(!isset($avaliable->e_date)){
        //     return "You don't have any Primary TA";
        // }
        // if($today >= $avaliable->e_date){
        //     return "Your account has been expired";
        // }
        $users = DB::table("tbl_user")->get();
        $playlist_id = "";
        $main_id = DB::table("tbl_user")
            ->where("level","1")
            ->where("Business_name",$request['business_name'])
            ->get()->first();
        // if(!isset($main_id->playlist_id) || $main_id->playlist_id == "" || $main_id->playlist_id == null){
        //     return "Fail";
        // }
        // if($main_id->playlist_id != ""){
            $sub_playlist = "";
            $apiToken = $this->get_token();
                    
            $medias = DB::table('tbl_ad')
                // ->where("playlist","1")
                ->where("business_name",$request["business_name"])
                ->get();
            $sublist_array = array();
            $subname_array = array();
            foreach($medias as $media_temp){
                // History
                $this->add_history('0', $media_temp->id, $request['business_name'], "Published To CM");
                $media_id = $this->upload_media_to_cm($media_temp->id,$request['business_name'],base_path().'/public/upload/'.$media_temp->img_url,$media_temp->playlist,$media_temp->id); // Publish Media to CM
                $this->update_media_cm($media_id,$media_temp->s_date,$media_temp->e_date);//Update Media
                $location_array =  $media_temp->location;
                $location = explode(",",$location_array);
                for($i = 0; $i < count($location)-1; $i++){
                    $avaliable_playlist = $this->get_playlist_id("Sub-".$request['business_name'].$location[$i]);
                    if(!in_array($avaliable_playlist,$sublist_array)){
                        array_push($sublist_array,$avaliable_playlist);
                        array_push($subname_array,$location[$i]);
                    }
                    $this->add_media_playlist($avaliable_playlist,$media_id);
                }
                $days = $media_temp->days;
                if($media_temp->schedule == 'ime'){
                   $days = '0,1,2,3,4,5,6,' ;
                }
                DB::table('tbl_sub')
                    ->where('ad_id',$media_temp->id)
                    ->delete();
                if($media_temp->playlist == 1){
                    foreach($sublist_array as $val => $temp){
                        if(isset($location[$val])){
                            if($location[$val] != ""){
                                DB::table('tbl_sub')
                                    ->insert([
                                        'ad_id' => $media_temp->id,
                                        'sub_id' => $temp,
                                        'location' => $location[$val],
                                        'days' => $days,
                                        'schedule' => $media_temp->schedule,
                                        'start_date' => $media_temp->s_date,
                                        'end_date' => $media_temp->e_date,
                                    ]);
                            }
                        }
                    }
                }
                for($i =0; $i < count($location)-1;$i++){
                    $master_id = $this->get_mplaylist_id($location[$i]);
                    foreach($subname_array as $val => $sub_name){
                        if($location[$i] == $sub_name){
                            $this->get_number_of_subplay($master_id,$sub_name);
                        }
                    }
                }
            }
            for($i =0; $i < count($location)-1;$i++){
                // $this->delete_subplay_main($location);
                $master_id = $this->get_mplaylist_id($location[$i]);
                foreach($subname_array as $val => $sub_name){
                    if($location[$i] == $sub_name){
                        $this->delete_subplay_main($master_id,$sublist_array[$val]);
                        $this->add_subplay_main($master_id,$sublist_array[$val]);
                        // $this->get_number_of_subplay($master_id,$sub_name);
                    }
                }
            }
        // }
        return 'success';
    }
    public function get_master(Request $request){
        $data = DB::table('tbl_sub')
            // ->groupby('sub_id')
            ->groupby('location')
            ->select(DB::raw('count(id) as num'),'location')
            ->get();
        return $data;
    }

    public function get_number_of_subplay($master_id,$location_name){
        $apiToken = $this->get_token();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/".$master_id."/items?fields=subplaylist",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "apiToken: ".$apiToken,
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $res = json_decode($response, true);
        if(isset($res['count'])){
            $cur_sub = $res['count'];
            DB::table('tbl_locations')
                ->where('name',$location_name)
                ->update([
                    'cur_sub' => $cur_sub
                ]);
        }
    }


    public function save_list(Request $request){
        if($request['post_id'] == "" && $request['social'] != null){
            return "You don't have any avaliable AD";
        }
        $today = date("Y-m-d");
        $avaliable = DB::table("tbl_user")
            ->where("level","1")
            ->where("Business_name",$request['business_name'])
            ->get()->first();
        if($today <= $avaliable->s_date && $today >= $avaliable->e_date){
            return "Your account has been expired";
        }

        $social = DB::table("tbl_social")
            ->get()->first();
        $social_name = explode(",",$request["social"]);
        // $users = DB::table("tbl_user")->where("id",session("user_id"))->get();
        $users = DB::table("tbl_user")->get();
        // $users = DB::table("tbl_user")->where("id",session("user_id"))->get();
        $post_media_id = explode(",",$request["post_id"]);
        $post_text = $request['post_text'];
        for($i = 0; $i < count($social_name)-1;$i++){
            foreach($users as $user_temp){
                if($social_name[$i] == "link"  && ($user_temp->l_token != "" || $user_temp->l_token != null)){
                    // LinkedIn user id
                    $l_post_text = $post_text." FROM https://inex.net";
                    $l_user_id = $this->linkedIn_me($user_temp->l_token);
                    if($l_user_id != "fail"){
                        for($p = 0; $p < count($post_media_id)-1; $p++){
                            $img = DB::table("tbl_ad")->where("id",$post_media_id[$p])->get()->first();
                            $curl = curl_init();

                            curl_setopt_array($curl, array(
                                CURLOPT_URL => "https://api.linkedin.com/v2/shares/",
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => "",
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => "POST",
                                CURLOPT_POSTFIELDS =>"{\n    \"content\": {\n        \"contentEntities\": [\n            {\n                \"entityLocation\": \"https://inex.net\",\n                \"thumbnails\": [\n                    {\n                        \"resolvedUrl\": \"https://inex.net/upload/".$img->img_url."\"\n                    }\n                ]\n            }\n        ],\n        \"title\": \"".$l_post_text."\"\n    },\n    \"distribution\": {\n        \"linkedInDistributionTarget\": {}\n    },\n    \"owner\": \"urn:li:person:".$l_user_id."\",\n    \"subject\": \"Test Share Subject\",\n    \"text\": {\n        \"text\": \"\"\n    }\n}",
                                CURLOPT_HTTPHEADER => array(
                                        "Content-Type: application/json",
                                        "x-li-format: json",
                                        "Authorization: Bearer ".$user_temp->l_token
                                ),
                            ));

                            $response = curl_exec($curl);

                            curl_close($curl);
                        }
                    }
                }
                if($social_name[$i] == 'twi' && ($user_temp->t_token != "" || $user_temp->t_token != null)){
                    $settings = array(
                        'oauth_access_token' => $user_temp->t_token,
                        'oauth_access_token_secret' => $user_temp->t_sec,
                        'consumer_key' => "i2Jds105lHB0papfTXuaUGZ0p",
                        'consumer_secret' => "NKJJiZCAGfWoUCmrMe5o57MEbWbkUJGW3Yc5epjMfQCGsryRft"
                    );
                    for($p = 0; $p < count($post_media_id)-1; $p++){
                        $img = DB::table("tbl_ad")->where("id",$post_media_id[$p])->get()->first();
                        
                        
                        $twitter = new TwitterAPIExchange($settings);
                        $file = file_get_contents(base_path().'/public/upload/'.$img->img_url);
                        $data = base64_encode($file);
                        // Upload image to twitter
                        $url = "https://upload.twitter.com/1.1/media/upload.json";
                        $method = "POST";
                        $params = array(
                            "media_data" => $data
                        );
                        $json = $twitter
                                    ->setPostfields($params)
                                    ->buildOauth($url, $method)
                                    ->performRequest();
                        
                        $res = json_decode($json,true);
                        if(isset($res['media_id'])){
                            $media_id = $res['media_id_string'];
                            // twitter api endpoint
                            $url = 'https://api.twitter.com/1.1/statuses/update.json';
                                
                            // twitter api endpoint request type
                            $requestMethod = 'POST';
                             
                            // twitter api endpoint data
                            $apiData = array(
                                'status' => $post_text."\nFROM https://inex.net",
                                'media_ids' => $media_id
                            );
                             
                            // create new twitter for api communication
                            $twitter = new TwitterAPIExchange( $settings );
                             
                            // make our api call to twiiter
                            $twitter->buildOauth( $url, $requestMethod );
                            $twitter->setPostfields( $apiData );
                            $response = $twitter->performRequest( true, array( CURLOPT_SSL_VERIFYHOST => 0, CURLOPT_SSL_VERIFYPEER => 0 ) ); 
                            $t_res = json_decode($response,true);
                            if(isset($t_res['created_at'])){
                                // echo $response;
                            }
                        }
                    }
                }
                if($social_name[$i] == "face"){
                    // Page Token and id of facebook
                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://graph.facebook.com/v6.0/me/accounts?access_token=".$user_temp->f_token,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "GET",
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);
                    if(isset(json_decode($response,true)['data'])){
                        $access_token_list =json_decode($response,true)['data'];
                        foreach($access_token_list as $page_token_temp){
                            $page_token =  $page_token_temp["access_token"];
                            $page_id =  $page_token_temp["id"];
                            for($p = 0; $p < count($post_media_id)-1; $p++){
                                $img = DB::table("tbl_ad")->where("id",$post_media_id[$p])->get()->first();
                                $param = array(
                                    'url' => 'https://inex.net/upload/'.$img->img_url,
                                    'access_token' => $page_token,
                                    'message' => $post_text."\nFROM https://inex.net"
                                );
                
                                $ch = curl_init();
                                $url = "https://graph.facebook.com/".$page_id."/photos";
                                curl_setopt($ch, CURLOPT_URL, $url);
                                curl_setopt($ch, CURLOPT_HEADER, false);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLOPT_POST, true);
                                curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
                                $response = curl_exec($ch);
                                $err = curl_error($ch);
                                curl_close($ch);
                            }
                        }
                    }

                    // End of page token id of facebook
                }
            }
        }
        return "success";
        $playlist_id = "";
        $main_id = DB::table("tbl_user")
            ->where("level","1")
            ->where("Business_name",$request['business_name'])
            ->get()->first();
        if(!isset($main_id->playlist_id) || $main_id->playlist_id == "" || $main_id->playlist_id == null){
            return "Fail";
        }
        if($main_id->playlist_id != ""){
            $sub_playlist = "";
            $apiToken = $this->get_token();
            // 
            $medias = DB::table('tbl_ad')
                ->where("playlist","1")
                ->where("business_name",$request["business_name"])
                ->get();
            $sublist_array = array();
            $subname_array = array();
            foreach($medias as $media_temp){
                $this->update_media_cm($media_temp->media_id,$media_temp->s_date,$media_temp->e_date);//Update Media
                $location_array =  $media_temp->location;
                $location = explode(",",$location_array);
                for($i = 0; $i < count($location)-1; $i++){
                    $avaliable_playlist = $this->get_playlist_id("Sub-".$request['business_name'].$location[$i]);
                    if(!in_array($avaliable_playlist,$sublist_array)){
                        array_push($sublist_array,$avaliable_playlist);
                        array_push($subname_array,$location[$i]);
                    }
                    $this->add_media_playlist($avaliable_playlist,$media_temp->media_id);
                }
            }
            for($i =0; $i < count($location)-1;$i++){
                // $this->delete_subplay_main($location);
                // foreach(sub)
                $master_id = $this->get_mplaylist_id($location[$i]);
                foreach($subname_array as $val => $sub_name){
                    if($location[$i] == $sub_name){
                        $this->delete_subplay_main($master_id,$sublist_array[$val]);
                        $this->add_subplay_main($master_id,$sublist_array[$val]);
                    }
                }
            }
        }
        return 'success';
    }
    public function update_sch(Request $request){
      $ad = DB::table("tbl_ad")->where('id', $request['u_id'])->first();
      if(!isset($ad->id)) {
        return 'Invalid Ad';
      }
      $business_name = $ad->business_name;
      $request['business_name'] = $business_name;
      $default_location = $this->get_locations_by_business_name($request);
      $des = '';
      if($default_location['success'] == true) {
        foreach($default_location['locations'] as $temp){
          $des .= $temp->name;
        }
      }
        if($request['no_end'] == 0){
            $end_date = $request['e_date'];
        }
        else{
            $end_date = "No End date";
        }
        $locations = $request['locations'];
        if($locations == ''){
          DB::table("tbl_ad")
            ->where('id',$request['u_id'])
            ->update([
              'rest' => 1,
              'location' => $des
            ]);
        } else {
          DB::table("tbl_ad")
            ->where('id',$request['u_id'])
            ->update([
              'rest' => 0,
              'location' => $locations
            ]);
        }
        DB::table("tbl_ad")
            ->where('id',$request['u_id'])
            ->update([
                "schedule" => $request['radio'],
                "days" => $request['days'],
                "s_date" => $request['s_date'],
                "e_date" => $end_date,
                "s_time" => $request['s_time'],
                "e_time" => $request['e_time'],
            ]);
        return "success";
    }
    // Update MEDIA
    public function update_media_cm($id,$s_date,$e_date){
        if($e_date == "No End date"){
            $e_date = "";
        }
        $apiToken = $this->get_token();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/workgroups?limit=10&offset=0&sort=name",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "apiToken: ".$apiToken
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $res = json_decode($response, true);
        if(isset($res['list'])){
            $work_res = json_decode($response, true)['list'];
            $w_id = $work_res[0]['id'];
            $w_name = $work_res[0]['name'];
    
            $curl = curl_init();
    
            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/media/".$id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "PUT",
                CURLOPT_POSTFIELDS =>"{\n\t\"startValidDate\": \"".$s_date."\",\n\t\"endValidDate\" : \"".$e_date."\",\n\t\"workgroups\" :{\n\t\t\"name\" : \"".$w_name."\",\n\t\t\"id\" : ".$w_id.",\n\t\t\"parentId\" : ".$w_id.",\n\t\t\"owner\" : true\n\t}\n}",
                CURLOPT_HTTPHEADER => array(
                    "apiToken: ".$apiToken,
                    "Content-Type: application/json"
                ),
            ));
    
            $response = curl_exec($curl);
    
            curl_close($curl);
        }
    }
    // Get Master ID
    public function get_mplaylist_id($name){
        $location = DB::table('tbl_locations')
            ->where('name', $name)
            ->first();
        if(isset($location->id) && $location->master_id != null){
            return $location->master_id;
        }
        return 'fail';
        return $location;
        $urlname = str_replace(" ", "%20", $name);

        $apiToken =$this->get_token();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/findByName/".$urlname,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "apiToken: ".$apiToken
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $res = json_decode($response, true);
        $main_id = 0;
        if(isset($res['id'])){
            $main_id = $res['id'];
        }
        return $main_id;
    }
    // Delete SubPlayList From Manster
    public function delete_subplay_main($master_id,$sub_id){
        $apiToken = $this->get_token();
        $curl = curl_init();

        curl_setopt_array($curl, array(
                CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/".$master_id."/items",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                        "apiToken: ".$apiToken
                ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        if(isset(json_decode($response, true)['list'])){
            $res = json_decode($response, true)['list'];
            // print_r($res);
            $sub_item_id = 0;
            foreach($res as $value => $master){
                if($master['playlistItemType'] == 'SUB_PLAYLIST'){
                    if($master['subplaylist']['id'] == $sub_id){
                        $sub_item_id = $master['id'];
                        $curl = curl_init();

                        curl_setopt_array($curl, array(
                            CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/".$master_id."/playlistItems/".$sub_item_id,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "DELETE",
                            CURLOPT_POSTFIELDS =>"{\n\t\"playlistItemType\" : \"SUB_PLAYLIST\"\n}",
                            CURLOPT_HTTPHEADER => array(
                                    "apiToken: ".$apiToken,
                                    "Content-Type: application/json"
                                ),
                        ));

                        $response = curl_exec($curl);

                        curl_close($curl);
                    }
                }
            }
        }        
    }
    public function update_calculation($id){
        $apiToken = $this->get_token();
        $curl = curl_init();

        curl_setopt_array($curl, array(
                CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/".$id."/calculateDuration",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "PUT",
                CURLOPT_HTTPHEADER => array(
                        "apiToken: ".$apiToken
                ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
    }
    // Add Sub to Master
    public function update_subplay($sub_id){
        $apiToken = $this->get_token();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/".$sub_id."",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "apiToken: ".$apiToken
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $fix = str_replace('"duration":0','"duration":8',$response);
        $fix = str_replace('"durationHoursSeconds":"00:00:00"','"durationHoursSeconds":"00:00:08"',$fix);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/".$sub_id."",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            // CURLOPT_POSTFIELDS =>"{\n\t\"minDuration\": ".$duration.",\n\t\"maxDuration\": ".$duration.",\n\t\"imageDuration\": 8,\n\t\"workgroups\" :{\n\t\t\"name\" : \"".$w_name."\",\n\t\t\"id\" : ".$w_id.",\n\t\t\"parentId\" : ".$w_id.",\n\t\t\"owner\" : true\n\t}\n}",
            CURLOPT_POSTFIELDS =>$fix,
            CURLOPT_HTTPHEADER => array(
                "apiToken: ".$apiToken,
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        // return $fix;
        // $medias = json_decode($response, true)['count'];
        // $duration = $medias * 800;

        // // WorkGroup
        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/workgroups?limit=10&offset=0&sort=name",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "GET",
        //     CURLOPT_HTTPHEADER => array(
        //         "apiToken: ".$apiToken
        //     ),
        // ));

        // $response = curl_exec($curl);

        // curl_close($curl);
        // $work_res = json_decode($response, true)['list'];
        // $w_id = $work_res[0]['id'];
        // $w_name = $work_res[0]['name'];
        // // END OF WORK GROUP
        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/".$sub_id."/partial",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "PUT",
        //     // CURLOPT_POSTFIELDS =>"{\n\t\"minDuration\": ".$duration.",\n\t\"maxDuration\": ".$duration.",\n\t\"imageDuration\": 8,\n\t\"workgroups\" :{\n\t\t\"name\" : \"".$w_name."\",\n\t\t\"id\" : ".$w_id.",\n\t\t\"parentId\" : ".$w_id.",\n\t\t\"owner\" : true\n\t}\n}",
        //     CURLOPT_POSTFIELDS =>"{\n\t\"minDuration\": ".$duration.",\n\t\"maxDuration\": ".$duration.",\n\t\"imageDuration\": 8,\n\t\"workgroups\" :{\n\t\t\"name\" : \"".$w_name."\",\n\t\t\"id\" : ".$w_id.",\n\t\t\"parentId\" : ".$w_id.",\n\t\t\"owner\" : true\n\t}\n}",
        //     CURLOPT_HTTPHEADER => array(
        //         "apiToken: ".$apiToken,
        //         "Content-Type: application/json"
        //     ),
        // ));

        // $response = curl_exec($curl);
        // curl_close($curl);
    }
    public function add_subplay_main($master_id,$sub){
        $this->update_subplay($sub);
        $this->update_calculation($sub);
        $this->update_calculation($master_id);
        $apiToken = $this->get_token();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/".$master_id."/playlistItems",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>"{\n  \"playlistItemType\": \"SUB_PLAYLIST\",\n  \"subPlaylistPickPolicy\": \"1\",\n  \"subplaylist\": {\n  \t\"id\":".$sub.",\n  \t\"htmlDuration\" : 2,\n  \t\"imageDuration\" : 20\n  },\n  \"timeSchedules\" : {\n  \t\"startTime\" : \"00:00\",\n  \t\"endTime\" : \"23:59\",\n  \t\"days\" : [\"MONDAY\",\"TUESDAY\",\"WEDNESDAY\",\"THURSDAY\",\"FRIDAY\",\"SATURDAY\",\"SUNDAY\" ]\n  },\n  \"media\" : {\n  \t\"name\" : \"rsa\",\n\t  \"uri\" : \"http://revision.inex.net/upload/123.png\",\n\t  \"mediaType\" : \"IMAGE\",\n\t  \"startValidDate\" : \"2020-06-01\",\n\t  \"endValidDate\" : \"2020-12-29\"\n  },\n  \"startValidDate\" : \"2020-05-22\",\n  \"endValidDate\" : \"2020-12-29\"\n}",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "apiToken: ".$apiToken
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
    }
    public function get_playlist_id($name){
        $urlname = str_replace(" ", "%20", $name);
        $apiToken =$this->get_token();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/findByName/".$urlname,
            // CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists?limit=1000",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "apiToken: ".$apiToken
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $res = json_decode($response, true);
        if(isset($res['id'])){
            return $res['id'];
        }
        else{
            return $this->create_playlist($name);
        }
    }
    public function get_playlist_id_from_delete($name){
        $urlname = str_replace(" ", "%20", $name);

        $apiToken =$this->get_token();        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/findByName/".$urlname,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "apiToken: ".$apiToken
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $res = json_decode($response, true);
        if(isset($res['id'])){
            return $res['id'];
        }
        else{
            return "";
        }
    }
    public function create_playlist($name){
        $apiToken = $this->get_token();
        $curl = curl_init();

        curl_setopt_array($curl, array(
                CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS =>"{\n \"name\":\"".$name."\",\n \"description\":\"".$name."\" ,\n \"playlistType\":\"MEDIA_PLAYLIST\" ,\n \"healthy\":\"true\" ,\n \"enableSmartPlaylist\":\"false\" ,\n \"sortOrder\" : \"0\"\n }",
                CURLOPT_HTTPHEADER => array(
                        "Content-Type: application/json",
                        "apiToken: ".$apiToken
                ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $res = json_decode($response, true);
        if(isset($res['id'])){
            return $res['id'];
        }
        else{
            return "Fail To Create SubPlayList";
        }
    }
    public function add_media_playlist($playlist_id,$media_id){
        $apiToken = $this->get_token();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/".$playlist_id."/playlistItems/".$media_id."?playlistItemType=MEDIA_ITEM",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "apiToken: ".$apiToken
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $res = json_decode($response, true);
        if(isset($res['count'])){
            if($res['count']== 0 ){
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/".$playlist_id."/playlistItems/".$media_id,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "PUT",
                    CURLOPT_HTTPHEADER => array(
                        "apiToken: ".$apiToken
                    ),
                ));

                $response = curl_exec($curl);
                $res = json_decode($response,true);
                curl_close($curl);


                $this->update_calculation($playlist_id);
            }

        }
        else{
        }
    }
    public function delete_subplay($id,$tbl_id){
        $apiToken = $this->get_token();
        DB::table("tbl_user")
            ->where("id",$tbl_id)
            ->update([
                'sub_playlist'=>""
            ]);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/".$id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_HTTPHEADER => array(
            "apiToken: ".$apiToken
            ),
        ));
        
        $response = curl_exec($curl);
        
        $res = json_decode($response,true);

        curl_close($curl);
        if(isset($res['httpErrorCode'])){
            return $res['description'];
        }
        else{
            echo $response;
        }
    }
    public function add_sub_main($sub_id,$main_id){
        $apiToken = $this->get_token();
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/".$main_id."/playlistItems",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        // CURLOPT_POSTFIELDS =>"{\n  \"playlistItemType\": \"SUB_PLAYLIST\",\n  \"subplaylist\": {\"id\":".$sub_id.",\n  \t\"htmlDuration\" : 8},\n  \"timeSchedules\" : {\n  \t\"startTime\" : \"05:22\",\n  \t\"endTime\" : \"12:29\",\n  \t\"days\" : \"MONDAY\"\n  }\n}",
        CURLOPT_POSTFIELDS =>"{\n  \"playlistItemType\": \"SUB_PLAYLIST\",\n  \"subplaylist\": {\n  \t\"id\":".$sub_id.",\n  \t\"htmlDuration\" : 2,\n  \t\"imageDuration\" : 00:00:10\n  },\n  \"timeSchedules\" : {\n  \t\"startTime\" : \"05:22\",\n  \t\"endTime\" : \"12:29\",\n  \t\"days\" : [\"MONDAY\",\"TUESDAY\" ]\n  }}",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "apiToken: ".$apiToken
        ),
        ));

        $response = curl_exec($curl);

        $res = json_decode($response,true);

        curl_close($curl);
        if(isset($res['httpErrorCode'])){
            return $res['description'];
        }
        else{
            return "success";
        }
    }
    // END OF PLAYLIST
    // Facebook
    public function facebook(Request $request){
        return $request;
    }
    public function get_userid(){
        $user = DB::table("tbl_user")->get();
        foreach($user as $t_user){
            // Get_user_id
            $page_id = $this->get_page_id_f($t_user->f_long_live);
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://graph.facebook.com/".$page_id."?fields=access_token&access_token=".$t_user->f_long_live,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $p_token = json_decode($response,true);
            if(isset($p_token['access_token'])){
                $page_token = $p_token['access_token'];
                echo $page_token;
            }
        }
    }
    // END of Facebook
    // Twitter
    public function redirect()
    {
        return Socialite::driver('twitter')->redirect();
    }
    public function redirect_multi(){
        return Socialite::driver('twitter_multi')->redirect();
    }
    
    public function twitter(Request $request)
    {
        if(isset($request['oauth_token'])){
            $t_token = $request['oauth_token'];
            $t_ver = $request['oauth_verifier'];
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.twitter.com/oauth/access_token?oauth_token=".$t_token."&oauth_verifier=".$t_ver,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_HTTPHEADER => array(
                    "Accept-Encoding: application/gzip"
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $oauth_token = "";
            $oauth_token_secret = "";
            if($response != ""){
                $res = explode("&",$response);
                for($i =0; $i < count($res)-1; $i++){
                    $temp = explode("=",$res[$i]);
                    if($temp[0] == "oauth_token"){
                        $oauth_token = $temp[1];
                    }
                    if($temp[0] == "oauth_token_secret"){
                        $oauth_token_secret = $temp[1];
                    }
                }
                if(session('social_session') != ''){
                    DB::table("tbl_user")
                        ->where('id',session('social_session'))
                        ->update([
                            't_token' => $oauth_token,
                            't_sec' => $oauth_token_secret
                        ]);
                    return redirect()->route('manage_social');
                }
                else{
                    DB::table("tbl_user")
                        ->where('id',session('user_id'))
                        ->update([
                            't_token' => $oauth_token,
                            't_sec' => $oauth_token_secret
                        ]);
                    return redirect()->route('socials');
                }
                return "success";
            }
            // echo $response['oauth_token'];
            // echo $response;
            
        }
        return "fail";
        // return $request;
        // DB::table("tbl_user")
            
        // $user = $service->createOrGetUser(Socialite::driver('twitter')->user());
        // auth()->login($user);
        // return redirect()->to('/home');
    }
    public function twitter_multi(Request $request){
        if(isset($request['oauth_token'])){
            $t_token = $request['oauth_token'];
            $t_ver = $request['oauth_verifier'];
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.twitter.com/oauth/access_token?oauth_token=".$t_token."&oauth_verifier=".$t_ver,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_HTTPHEADER => array(
                    "Accept-Encoding: application/gzip"
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $oauth_token = "";
            $oauth_token_secret = "";
            if($response != ""){
                $res = explode("&",$response);
                for($i =0; $i < count($res)-1; $i++){
                    $temp = explode("=",$res[$i]);
                    if($temp[0] == "oauth_token"){
                        $oauth_token = $temp[1];
                    }
                    if($temp[0] == "oauth_token_secret"){
                        $oauth_token_secret = $temp[1];
                    }
                }
                DB::table("tbl_user")
                    ->where('id',session('social_session'))
                    ->update([
                        't_token' => $oauth_token,
                        't_sec' => $oauth_token_secret
                    ]);
                return redirect()->route('manage_social');
                return "success";
            }
            // echo $response['oauth_token'];
            // echo $response;
            
        }
        return "fail";
    }
    // END OF Twitter
    // LINKED IN
    public function linkedIn_auth(){
        return Socialite::driver('linkedin')->redirect();
    }
    public function linkedIn(Request $request){
        if(isset($request['code'])){
            $code = $request['code'];
            // $image = 'https://inex.net/upload/123.png';
            // $text = 'https://inex.net/upload/123.png';
            // LinkedinShare::shareImage($code, $image, $text);
            // Access Token
            $curl = curl_init();

            curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://www.linkedin.com/oauth/v2/accessToken?grant_type=authorization_code&code=".$code."&redirect_uri=".config('app.url')."/linkedIn&client_id=78x70swk6qchrs&client_secret=640Dq0tvJQpBQztY&SCOPES=r_emailaddress,r_liteprofile,w_member_social,mgm_w_media,w_organization_social",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_HTTPHEADER => array(
                        "Content-Type: application/x-www-form-urlencoded",
                        'Content-Length: 0'
                    ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $res = json_decode($response,true);
            if(isset($res['access_token'])){
                $l_token = $res['access_token'];
                DB::table('tbl_user')
                    ->where("id",session('user_id'))
                    ->update([
                        "l_token" => $l_token
                    ]);
            }
            // END OF ACCESS TOken
            return redirect()->route('socials');
        }
        else{
            return "fail";
        }
        return $code;
    }
    public function linkedIn_me($token){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.linkedin.com/v2/me",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/x-www-form-urlencoded",
                    "Connection: Keep-Alive",
                    "Authorization: Bearer ".$token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $res = json_decode($response,true);
        if(isset($res['id'])){
            $user_id = $res['id'];
            return $user_id;
        }
        else{
            return "fail";
        }
    }
    public function linkedIn_multi(Request $request){
        if(isset($request['code'])){
            $code = $request['code'];
            // $image = 'https://inex.net/upload/123.png';
            // $text = 'https://inex.net/upload/123.png';
            // LinkedinShare::shareImage($code, $image, $text);
            // Access Token
            $curl = curl_init();

            curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://www.linkedin.com/oauth/v2/accessToken?grant_type=authorization_code&code=".$code."&redirect_uri=".config('app.url')."/linkedIn_multi&client_id=78x70swk6qchrs&client_secret=640Dq0tvJQpBQztY&scope=r_emailaddress,r_liteprofile,w_member_social,mgm_w_media,w_organization_social,r_1st_connections,r_compliance,r_network",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_HTTPHEADER => array(
                        "Content-Type: application/x-www-form-urlencoded",
                        'Content-Length: 0'
                    ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $res = json_decode($response,true);
            if(isset($res['access_token'])){
                $l_token = $res['access_token'];
                DB::table('tbl_user')
                    ->where("id",session('social_session'))
                    ->update([
                        "l_token" => $l_token
                    ]);
            }
            // END OF ACCESS TOken
            return redirect()->route('manage_social');
        }
        else{
            return "fail";
        }
        return $code;
    }

    public function update_social_session(Request $request){
        session([
            'social_session' => $request['user_id']
        ]);
        return "success";
    }
    // END OF LINKEDIN


    // get users for social account
    public function get_users(Request $request){
        if(session("level") == 2){
            $users = DB::table("tbl_user")
                ->orderBy('business_name')
                ->get();
            return $users;
        }
        else{
            $users = DB::table("tbl_user")
                ->orderBy('business_name')
                ->get();
            return $users;
        }
    }
    // end

    // Dashboard
    public function get_dashboard(Request $request){
        $data = array();
        $users = DB::table("tbl_user")
            // ->where("level","!=",2)
            ->get();
        $total_user = 0;
        $active_user = 0;
        $inactive_user = 0;
        $admins = 0;
        $primay_user = 0;
        $secondary_user = 0;
        foreach($users as $val => $user_temp){
            $total_user = $val+1;
            if($user_temp->level == 2){
                $admins++;
            }
            if($user_temp->level == 0){
                $primay_user++;
            }
            if($user_temp->level == 1){
                $secondary_user++;
            }
            if($user_temp->user_lock == 0){
                $active_user++;
            }
            if($user_temp->user_lock == 1){
                $inactive_user++;
            }
        }  

        $data['total_user'] = $total_user;
        $data['active_user'] = $active_user;
        $data['inactive_user'] = $inactive_user;
        $data['admins'] = $admins;
        $data['primay_user'] = $primay_user;
        $data['secondary_user'] = $secondary_user;
        // Template
        $total_temp = 0;
        $primary_temp = 0;

        $template = DB::table('tbl_template')
            ->get();
        foreach($template as $val => $temp_temp){
            $total_temp = $val+1;
            if($temp_temp->primary == 1){
                $primary_temp++;
            }
        }
        $data['total_temp'] = $total_temp;
        $data['primary_temp'] = $primary_temp;

        // Ads
        $total_ads = 0;
        $playlist = 0;

        $ads = DB::table('tbl_ad')
            ->get();
        foreach($ads as $val => $temp_ads){
            $total_ads = $val+1;
            if($temp_ads->playlist == 1){
                $playlist++;
            }
        }
        $data['total_ads'] = $total_ads;
        $data['playlist'] = $playlist;

        // 
        $tops = DB::table('tbl_ad')
            ->leftJoin("tbl_template","tbl_template.id","tbl_ad.temp_id")
            ->groupBy("temp_id")
            ->select("tbl_template.template_name","tbl_template.bg_img","tbl_ad.business_name",DB::raw('count(tbl_ad.id) as total_uses'))
            ->orderBy("total_uses",'desc')
            ->get();
        $data['tops'] = $tops;
        // Busines
        $total_business = DB::table("tbl_user")
            ->groupBy("business_name")->get()->count();
        $data['total_business'] = $total_business;

        $business_list = DB::table("tbl_ad")
            ->groupBy("business_name")
            ->leftJoin('tbl_user', function ($leftJoin) {
                $leftJoin->on('tbl_user.business_name', '=', 'tbl_ad.business_name')
                    ->groupBy("tbl_user.business_name");
            })
            ->select("tbl_ad.business_name",DB::raw('count(tbl_ad.id) as total_uses'))
            ->where("tbl_user.user_lock",0)
            ->orderBy("total_uses","desc")
            ->get();
        $data['business_list'] = $business_list;
        // End of busines
        // Locations
        $total_location = DB::table("tbl_locations")->get()->count();
        $data['total_location'] = $total_location;

        $location_list = DB::table("tbl_location_by_name")
            ->leftJoin("tbl_locations","tbl_locations.id","tbl_location_by_name.location_id")
            ->groupBy("location_id")
            ->select("tbl_locations.name",DB::raw('count(tbl_locations.id) as total_uses'))
            ->orderBy("total_uses","desc")
            ->get();
        $data['location_list'] = $location_list;
        // ENd of location

        // Todays' Ads
        $today_ads = DB::table("tbl_ad")
            ->whereRaw('Date(tbl_ad.cre_date) = CURDATE()')
            ->get()->count();
        $data['today_ads'] = $today_ads;
        $year = date("Y");
        $m_cur = date("m");
        $month_ads = DB::table("tbl_ad")
            ->whereYear("tbl_ad.cre_date",$year)
            ->whereMonth("tbl_ad.cre_date",$m_cur)
            ->get()->count();
        $data['month_ads'] = $month_ads;


        $year_ads = DB::table("tbl_ad")
            ->whereYear("tbl_ad.cre_date",$year)
            ->get()->count();
        $data['year_ads'] = $year_ads;
        // ENd of Todays

        // Sales
        // $sales = DB::table("tbl_user")
        //     ->leftJoin(DB::raw('(select count(id) as sales_num,sales_id,business_name 
        //             FROM tbl_sales_list group by sales_id) as tbl_sales_list'),function($leftjoin){
        //         $leftjoin->on('tbl_sales_list.sales_id','tbl_user.id');
        //     })
        //     ->select('tbl_user.*','tbl_sales_list.*')
        //     ->where('sales_num', '!=', 0)
        //     ->where('tbl_user.level', '=', 4)
        //     ->get();
        $sales = DB::table("tbl_sales")
            ->leftJoin(DB::raw('(select count(id) as sales_num,sales_id,business_name 
                    FROM tbl_sales_list group by sales_id) as tbl_sales_list'),function($leftjoin){
                $leftjoin->on('tbl_sales_list.sales_id','tbl_sales.id');
            })
            ->select('tbl_sales.*','tbl_sales_list.*')
            ->where('sales_num', '!=', 0)
            ->get();
        $data['sales'] = $sales;
        // End of sales
        return $data;
 
    }
    public function get_sub(Request $request){
        $today = date("Y-m-d");
        $firstday = date('Y-m-d', strtotime("this week"));
        $sub = DB::table('tbl_sub')
            ->where('location',$request['name'])
            ->where('start_date', ">=", $firstday)
            ->orderby('location')
            ->orderby('sub_id')
            ->get();
        $sub_array = array();
        $result = array(0,0,0,0,0,0,0);
        foreach($sub as $temp){
            if(!in_array($temp->sub_id,$sub_array)){
                array_push($sub_array,$temp->sub_id);
                $days = explode(",",$temp->days);
                // if($temp->schedule == "frame"){
                //     // if($temp->)
                // }
                // else{
                //     // if($)
                // }
                for($i = 0; $i < count($days)-1; $i++){
                    // Max is 14
                    if($result[$i] < 14){
                        $result[$i]++;
                    }
                }
            }
        }
        return $result;
        return $sub_array;
    }
    // End of dashboard
    // Manage SIC
    public function get_sic(Request $request){
        $sic = DB::table("tbl_sic")
            ->orderBy('sic_name','asc')
            ->get();
        return $sic;
    }
    public function new_sic(Request $request){
        DB::table('tbl_sic')
            ->INSERT([
                'sic_name' => $request['sic_name']
            ]);
        return "success";
    }
    public function update_sic(Request $request){
        DB::table('tbl_sic')
            ->where('id',$request['tbl_id'])
            ->Update([
                'sic_name' => $request['sic_name']
            ]);
        return "success";
    }
    public function delete_sic(Request $request){
        DB::table('tbl_sic')
            ->where('id',$request['tbl_id'])
            ->delete();
        return "success";
    }
    // END OF SIC
    // Sales
    public function get_sales(Request $request){
        $sales = DB::table('tbl_sales')
            ->orderBy('sales_name','asc')
            ->get();
        return $sales;
    }
    public function new_sales(Request $request){
        DB::table('tbl_sales')
            ->INSERT([
                'sales_name' => $request['sales_name']
            ]);
        return "success";
    }
    public function update_sales(Request $request){
        DB::table('tbl_sales')
            ->where('id',$request['tbl_id'])
            ->Update([
                'sales_name' => $request['sales_name']
            ]);
        return "success";
    }
    public function delete_sales(Request $request){
        DB::table('tbl_sales')
            ->where('id',$request['tbl_id'])
            ->delete();
        return "success";
    }
    // End of sales
    // Update social checked
    public function update_social(Request $request){
        $status = 0;
        if($request['status'] == "false"){
            $status = 1;
        }
        DB::table("tbl_user")
            ->where('id',$request['user_id'])
            ->update([
                $request['field'] => $status
            ]);
        return "success";
    }
    // END OF SOCIAL checked
    // Campaign History
    public function add_history($status, $ad_id, $business_name, $extra){
        $user_id = session('user_id');
        $log = new Logs;
        $log->status = $status;
        $log->ad_id = $ad_id;
        $log->user_id = $user_id;
        $log->extra = $extra;
        $log->company_name = $business_name;
        $log->save();
        return 'success';
    }
    public function campaign_history(Request $request){
        if(!Session::has('user_id') || Session('level') == 0){
            return redirect()->route('login');
        }
        else{
            $data['page_name'] = "Campaign History";
            $user_id = $request['id'];
            $user = DB::table('tbl_user')
                ->where('id', $user_id)
                ->first();
            $data['user'] = $user;
            $data['user_id'] = $user_id;
            // $data['users'] = DB::table('tbl_user')->get();
            // $data['logs'] = Logs::where('company_name', $user->business_name)->get();
            $data['logs'] = DB::table("tbl_logs")
                ->where('company_name', $user->business_name)
                ->leftJoin('tbl_ad', 'tbl_ad.id', 'tbl_logs.ad_id')
                ->leftJoin('tbl_user', 'tbl_user.id', 'tbl_logs.user_id')
                ->select('tbl_logs.*', 'tbl_ad.img_url', 'tbl_user.user_name')
                ->orderBy('tbl_logs.id', 'desc')
                ->take(50)
                ->get();
            // $data['ads'] = DB::table('tbl_ad')->get();
            // $data['logs'] = Logs::get();
            return view('admin.business.history', $data);
        }
    }
    public function create_campaign(Request $request){
        if(!Session::has('user_id') || Session('level') == 0){
            return 'fail';
        }
        if($request['start_date'] > $request['end_date']){
            return "Please input valid end date";
        }
        $creator = session('user_id');
        $user = DB::table('tbl_user')
            ->where('id', $request['id'])
            ->first();
        $campaign = new Logs;
        $campaign->user_id = $creator;
        $campaign->status = 1;
        $campaign->company_name = $user->business_name;
        $campaign->campaign = 1;
        $campaign->start_date = $request['start_date'];
        $campaign->end_date = $request['end_date'];
        $campaign->save();
        $campaign_id = $campaign->id;
        // Send Email to Sales man and Primary TA
        $users = DB::table('tbl_user')
            ->where('business_name', $user->business_name)
            // ->orWhere('level', '1')
            ->orWhere('level', '2')
            // ->orWhere('level', '4')
            ->get();
        $camp = Logs::where('id', $campaign_id)->first();
        // foreach($users as $key => $val){
        //     Mail::to('billing@inex.net')->send(new NewCampaign($user,$camp));
        //     Mail::to($val->email)->send(new NewCampaign($user,$camp));
        // }
        return 'success';
    }
    public function update_campaign(Request $request){
        if(!Session::has('user_id') || Session('level') == 0){
            return 'fail';
        }
        if($request['start_date'] > $request['end_date']){
            return "Please input valid end date";
        }
        $creator = session('user_id');
        Logs::where('id', $request['id'])
            ->update([
                'start_date' => $request['start_date'],
                'end_date' => $request['end_date']
            ]);
        return "success";
    }
    public function delete_campaign(Request $request){
        $today = date("Y-m-d");
        $campaign = Logs::where('id', $request['id'])->first();
        if($today > $campaign->start_date || $today > $campaign->end_date){
            return "You can't delete this campaign";
        }
        Logs::where('id', $request['id'])->delete();
        return "success";
    }
    public function delivery(Request $request){
        $user_id = $request->user_id;
        $user_id = base64_decode($user_id, true);
        $ids = explode(",", $request->id);
        $ads = DB::table('tbl_ad')->get();
        $temp = [];
        foreach($ads as $item){
            if(in_array(base64_encode($item->id), $ids)){
                array_push($temp, $item);
            }
        }
        $login = $this->login_by_id($user_id);
        if($login == 'fail'){
            $data['error'] = "You don't have permission to access this page";
            return view('error', $data);
        }
        $users = DB::table('tbl_user')->get();
        $data = array();
        $data["page_name"] = "New Ads";
        $data['ads'] = $temp;
        $data['users'] = $users;
        return view('admin.delivery', $data);
    }
    // Restrict Locations
    public function get_restriction(Request $request){
        $locations = DB::table('tbl_locations')
            ->orderby('name')
            ->orderby('nickname')
            ->get();
        $restrict = RestrictLocation::where('business_name', $request['business_name'])->get();
        $res = [];
        foreach($restrict as $key => $val){
            $res[] = $val->location_id;
        }
        $data = [];
        foreach($locations as $key => $val){
            $data[] = $val;
            $data[$key]->restrict = in_array($val->id, $res)?1:0;
        }
        return $data;
    }
    public function update_restrict(Request $request){
        if($request['business_name'] == ''){
            return "Please select valid business name";
        }
        $locations = $request['locations'];
        if($locations == ""){
            RestrictLocation::where('business_name', $request['business_name'])->delete();
        }
        else{
            RestrictLocation::where('business_name', $request['business_name'])->delete();
            foreach($locations as $key => $val){
                $restrict = new RestrictLocation;
                $restrict->business_name = $request['business_name'];
                $restrict->location_id = $val;
                $restrict->save();
            }
        }
        return "success";
    }
    // Docusign - Temp
    public function doc_token(Request $request){
        return $request;
    }
    // unsubscribe
    public function unsubscribe(Request $request){
        if(!session::has('user_id')){
            return redirect()->route('login');
        }
        $data = [];
        $data['page_name'] = "Unsubscribe Notification";
        $data['user'] = DB::table('tbl_user')
            ->where('id', session('user_id'))
            ->first();
        return view('admin.notification.unsubscribe',  $data);
    }
    public function update_notification(Request $request){
        if(!session::has('user_id')){
            return "Please sign in to unsubscribe";
        }
        $user_id = session('user_id');
        $notification = $request['notification']=='true'?0:1;
        DB::table('tbl_user')
            ->where('id', $user_id)
            ->update([
                'notification' => $notification,
            ]);
        return 'success';
    }
    public function notifications(Request $request){
        if(!Session::has('user_id') || session('level') == 0){
            return redirect()->route('login');
        }
        return $request;
    }
}