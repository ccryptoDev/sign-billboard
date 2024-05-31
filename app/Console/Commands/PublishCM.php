<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Logs;
use App\PublishList;
use App\RestrictLocation;

use App\UserCampaign;
use App\Invoices;

use App\Mail\PublishMail;
use Illuminate\Support\Facades\Mail;

class PublishCM extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'publish:cm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish Medias to CM';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Avaiable Medias
        $today = date("Y-m-d");
        $number = date('N', strtotime($today));
        if($number == 0){
            $number = 6;
        }
        else{
            $number = $number - 1;
        }
        $ads = DB::table('tbl_ad')
            ->where('playlist', 1)
            ->where('publish', 1)
            ->where('delivery', 1)
            ->where('business_name', '!=', '1 Demo')
            ->where('days', 'like', "%".$number."%")
            ->orderBy('business_name')
            ->get();
        $delivery = [];
        $controller = app()->make('App\Http\Controllers\ManageScala');
        $maincontroller = app()->make('App\Http\Controllers\MainController');
        foreach($ads as $media_temp){
            $business_name = $media_temp->business_name;
            $campaigns = UserCampaign::leftjoin('tbl_user', 'tbl_user.id', 'tbl_user_campaign.user_id')
                ->leftjoin('tbl_invoice', 'tbl_invoice.campaign_id', 'tbl_user_campaign.id')
                ->select('tbl_user_campaign.*', 'tbl_user.business_name', 'tbl_invoice.invoice_date', 'tbl_invoice.status')
                ->where('tbl_user.business_name', $business_name)
                ->get();
            $ava_locations = [];
            $ava_locations_name = [];
            foreach($campaigns as $key => $campaign){
                if($campaign->start_date <= $today && $campaign->end_date >= $today && ( $campaign->free_plan == 3 || $campaign->status ==1 || ($campaign->invoice_date > $today && $campaign->status == 0))){
                    $ava_locations = explode(",", $campaign->locations);
                    foreach($ava_locations as $loc){
                        $location = DB::table('tbl_locations')
                            ->where('id', $loc)->first();
                        $ava_locations_name[] = $location->name;
                    }
                }
            }
            $location = [];
            foreach(explode(",",$media_temp->location) as $loc){
                if(in_array($loc, $ava_locations_name)){
                    $location[] = $loc;
                }
            }
            $sublist_array = []; // Sub Playlist Ids
            $subname_array = []; // Location Name
            if(count($location) != 0){
                for($i = 0; $i < count($location); $i++){
                    $sub_name = "Sub-".$media_temp->business_name.$location[$i];
                    $avaliable_playlist = app()->call([$controller, 'get_playlist_id'], [
                        "name" => $sub_name,
                        "business_name" => $media_temp->business_name,
                    ]);
                    if(!in_array($avaliable_playlist,$sublist_array)){
                        array_push($sublist_array,$avaliable_playlist);
                        array_push($subname_array,$location[$i]);
                    }   
                }
            }
            // Delivery Media To CM
            if(count($sublist_array) > 0){
                $exist_flag = false;
                if(isset($media_temp->media_id)){
                    $exist = $this->exist_media($media_temp->id);
                    if($exist == "success"){
                        $exist_flag = true;
                        $media_id = $media_temp->media_id;
                    }
                    else{
                        $media_id = $this->upload_media_to_cm($media_temp->id);
                    }
                }
                else{
                    $media_id = $this->upload_media_to_cm($media_temp->id);
                }
                // Update Media ID in DB
                DB::table('tbl_ad')->where('id', $media_temp->id)
                    ->update([
                        'media_id' => $media_id
                    ]);
                // Add Media To Playlist
                foreach($sublist_array as $item){
                    app()->call([$controller, 'add_media_playlist'], [
                        "playlist_id" => $item,
                        "media_id" => $media_id,
                    ]);
                }
                // Add Sub To Master
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
                                        'start_date' => $media_temp->s_date==null?date('Y-m-d'):$media_temp->s_date,
                                        'end_date' => $media_temp->e_date==null?date('Y-m-d'):$media_temp->e_date,
                                    ]);
                            }
                        }
                    }
                }
                for($i =0; $i < count($location);$i++){
                    $master_id = app()->call([$maincontroller, 'get_mplaylist_id'], [
                        "name" => $location[$i],
                    ]);
                    foreach($subname_array as $val => $sub_name){
                        if($location[$i] == $sub_name){
                            app()->call([$maincontroller, 'delete_subplay_main'], [
                                "master_id" => $master_id,
                                "sub_id" => $sublist_array[$val],
                            ]);
                            app()->call([$maincontroller, 'add_subplay_main'], [
                                "master_id" => $master_id,
                                "sub_id" => $sublist_array[$val],
                            ]);
                        }
                    }
                    DB::table('tbl_ad')
                        ->where('id', $media_temp->id)
                        ->update([
                            'delivery' => 1
                        ]);
                }
            }
        }
        return;
    }
    // Upload Media To CM
    public function upload_media_to_cm($id){
        $controller = app()->make('App\Http\Controllers\ManageScala');
        $ad = DB::table('tbl_ad')
            ->where('id', $id)->first();
        $media_id = app()->call([$controller, 'upload_media_to_cm'], [
            "tbl_id" => $ad->id,
            "dis_name" => $ad->business_name,
            "img_path" => base_path().'/public/upload/'.$ad->img_url,
            "status" => 1,
            "media_id" => ''
        ]);
        return $media_id;
    }
    public function exist_media($id){
        $ad = DB::table('tbl_ad')
            ->where('id', $id)
            ->first();
        if(isset($ad->id)){
            $controller = app()->make('App\Http\Controllers\ManageScala');
            $apiToken = app()->call([$controller, 'get_token']);
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/media/".$ad->media_id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "apiToken: ".$apiToken
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $res = json_decode($response, true);
            if(isset($res['id'])){
                return "success";
            }
            return 'false';
        }
        return 'false';
    }
    // End of Upload Media
}
