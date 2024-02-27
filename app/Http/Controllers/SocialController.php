<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

// Model
use App\SocialPosts;
use App\SocialApprove;
// Mail
use App\Mail\ApproveSocials;
use Illuminate\Support\Facades\Mail;
// Twitter
use Socialite;
use App\Services\SocialTwitterAccountService;
use TwitterAPIExchange;

class SocialController extends Controller
{
    public function manage_socials(Request $request){
        if(!Session::has('user_id') || Session('level') != 2){
            return redirect('login');
        }
        $data['page_name'] = "Post Social Media";
        $controller = app()->make('App\Http\Controllers\MainController');       
        $business = app()->call([$controller, 'get_business_name_by_session'], []);
        $business_name = [];
        foreach($business as $key => $val){
            $business_name[] = $val->business_name;
        }
        $controller = app()->make('App\Http\Controllers\MainController');
        $data['business_name'] = app()->call([$controller, 'get_business_name_by_session'], []);
        $data['data'] = SocialPosts::leftJoin('tbl_socials_approve', 'tbl_socials_approve.post_id', 'tbl_socials_posts.id')
            ->leftjoin('tbl_user', 'tbl_user.id', 'tbl_socials_posts.client_id')
            ->whereIn('tbl_socials_posts.business_name', $business_name)
            ->groupby('tbl_socials_posts.id')
            ->orderby('tbl_socials_approve.id', 'desc')
            ->select('tbl_socials_approve.flag','tbl_user.user_name' ,'tbl_socials_posts.*')
            ->get();
        return view('admin.socials.manage', $data);
    }
    public function history_view(Request $request){
        if(!Session::has('user_id')){
            return redirect('login');
        }
        $data['page_name'] = "History of Process Socials";
        $controller = app()->make('App\Http\Controllers\MainController');       
        $business = app()->call([$controller, 'get_business_name_by_session'], []);
        $business_name = [];
        foreach($business as $key => $val){
            $business_name[] = $val->business_name;
        }
        $data['data'] = SocialPosts::leftJoin('tbl_socials_approve', 'tbl_socials_approve.post_id', 'tbl_socials_posts.id')
            ->leftjoin('tbl_user', 'tbl_user.id', 'tbl_socials_posts.client_id')
            ->whereIn('tbl_socials_posts.business_name', $business_name)
            ->groupby('tbl_socials_posts.id')
            ->orderby('tbl_socials_approve.id', 'desc')
            ->select('tbl_socials_approve.flag','tbl_user.user_name' ,'tbl_socials_posts.*')
            ->get();
        // $data['data'] = SocialApprove::leftJoin('tbl_socials_posts', 'tbl_socials_approve.post_id', 'tbl_socials_posts.id')
        //     ->leftJoin('tbl_user', 'tbl_user.id', 'tbl_socials_approve.user_id')
        //     ->whereIn('tbl_socials_posts.business_name', $business_name)
        //     ->where('tbl_socials_approve.flag', '!=', null)
        //     ->orderby('tbl_socials_approve.id', 'desc')
        //     ->select('tbl_socials_approve.flag','tbl_socials_approve.created_at as date','tbl_user.user_name', 'tbl_socials_posts.*')
        //     ->get();
        return view('admin.socials.history', $data);
    }
    public function create_post_view(Request $request){
        if(!Session::has('user_id')){
            return redirect('login');
        }
        $data['page_name'] = "Post Social Media";
        $user_id = session('user_id');
        $data['user'] = DB::table('tbl_user')
            ->where('id',$user_id)
            ->select('f_token','l_token','t_token','f_account','l_account','t_account')
            ->get()->first();
        $controller = app()->make('App\Http\Controllers\MainController');
        $data['business_name'] = app()->call([$controller, 'get_business_name_by_session'], []);
        return view('admin.socials.create', $data);
    }
    public function post_social(Request $request){
        if($request['business_name'] == ""){
            return "Please select business name";
        }
        if(!isset($request->social)){
            return "Please select at least one social(s)";
        }
        if($request['text'] == ''){
            return "Please enter your text";
        }
        if(!isset($request->img)){
            return "Please select at least one ad(s)";
        }
        return 'success';
        $business_name = $request['business_name'];
        $ads = $request->img;
        $imgs = [];
        foreach($ads as $key => $val){
            $ad = DB::table("tbl_ad")->where('id', $val)->first();
            $imgs[] = $ad->img_url;
        }
        $post = new SocialPosts;
        $post->business_name = $request['business_name'];
        $post->client_id = session('user_id');
        $post->ads = json_encode($ads);
        $post->imgs = json_encode($imgs);
        $post->context = $request['text'];
        $post->socials = json_encode($request->social);
        $post->post_date = $request['date'];
        $post->status = 0;
        $post->save();
        $post_id = $post->id;
        // $data = SocialPosts::where('id', $post_id)->first();
        // Mail::to('jing@inex.net')->send(new ApproveSocials($data, base64_encode($post_id)));
        return "success";
    }
    public function delete_post(Request $request){
        $id = $request->id;
        $status = SocialApprove::where('post_id', $id)->first();
        if(isset($status->id) && $status->flag == 1){
            return "Sorry but you can't delete this post";
        }
        SocialPosts::where('id', $id)->delete();
        return "success";
    }
    public function process_post(Request $request){
        return "success";
        $user_id = session('user_id');
        $post_id = $request->id;
        $status = $request['status'];
        $post = SocialPosts::where('id', $post_id)->first();
        if($status == 1){
            if(isset($post->client_id)){
                $poster_id = $post->client_id;
                $poster = DB::table('tbl_user')
                    ->where('id', $poster_id)->first();
                $socials = json_decode($post->socials, true);
                if(in_array(0, $socials) && $poster->t_account == 1){
                    $this->post_twitter($post_id);
                }
                if(in_array(1, $socials) && $poster->f_account == 1){
                    $this->post_facebook($post_id);
                }
                if(in_array(2, $socials) && $poster->l_account == 1){
                    $this->post_linkedin($post_id);
                }
            }
        }
        $approve = new SocialApprove;
        $approve->post_id = $post_id;
        $approve->user_id = $user_id;
        $approve->flag = $status;
        $approve->save();
        return "success";
    }
    public function post_linkedin($id){
        return "success";
        $post = SocialPosts::where('id', $id)->first();
        $user = DB::table('tbl_user')->where('id', $post->client_id)->first();
        $controller = app()->make('App\Http\Controllers\MainController');       
        $l_user_id = app()->call([$controller, 'linkedIn_me'], ['token' => $user->l_token]);
        $l_post_text = $post->context;
        $imgs = json_decode($post->imgs, true);
        $thumbnails = [];
        foreach($imgs as $key => $val){
            $temp['resolvedUrl'] = config('app.url')."/upload/".$val;
            $thumbnails[] = $temp;
        }
        $body = [
            "content" => [
                "contentEntities" => [
                    [
                        "entityLocation" => config('app.url'),
                        "thumbnails"=> $thumbnails,
                    ]
                ],
                "title" => $post->context
            ],
            "owner"=> "urn:li:person:".$l_user_id,
            "subject"=> config('app.name'),
            "text"=> [
                "text"=> ""
            ]
        ];
        // return $body;
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
            CURLOPT_POSTFIELDS => json_encode($body),
            CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "x-li-format: json",
                    "Authorization: Bearer ".$user->l_token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $res = json_decode($response, true);
        return $res;
    }
    public function post_twitter($id){
        return "success";
        $post = SocialPosts::where('id', $id)->first();
        $user = DB::table('tbl_user')->where('id', $post->client_id)->first();
        $imgs = json_decode($post->imgs, true);
        $img_url = "";
        foreach($imgs as $key => $val){
            $img_url = $val;
        }
        $settings = array(
            'oauth_access_token' => $user->t_token,
            'oauth_access_token_secret' => $user->t_sec,
            'consumer_key' => "i2Jds105lHB0papfTXuaUGZ0p",
            'consumer_secret' => "NKJJiZCAGfWoUCmrMe5o57MEbWbkUJGW3Yc5epjMfQCGsryRft"
        );
        $twitter = new TwitterAPIExchange($settings);
        $file = file_get_contents(base_path().'/public/upload/'.$img_url);
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
        echo $json;
        if(isset($res['media_id'])){
            $media_id = $res['media_id_string'];
            // twitter api endpoint
            $url = 'https://api.twitter.com/1.1/statuses/update.json';
            // twitter api endpoint request type
            $requestMethod = 'POST';                
            // twitter api endpoint data
            $apiData = array(
                'status' => $post->context."\nFROM ".config('app.url'),
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
                echo $response;
            }
            echo "fail";
        }
    }
    public function post_facebook($id){
        return "success";
        $post = SocialPosts::where('id', $id)->first();
        $user = DB::table('tbl_user')->where('id', $post->client_id)->first();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://graph.facebook.com/v6.0/me/accounts?access_token=".$user->f_token,
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
                $imgs = json_decode($post->imgs, true);
                $img_url = "";
                foreach($imgs as $key => $val){
                    $img_url = $val;
                }
                $param = array(
                    'url' => config('app.url').'/upload/'.$img_url,
                    'access_token' => $page_token,
                    'message' => $post->context."\nFROM ".config('app.url')
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
                return $response;
            }
        }
    }
}
