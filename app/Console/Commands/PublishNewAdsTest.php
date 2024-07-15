<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Logs;
use App\PublishList;
use App\RestrictLocation;

use App\UserCampaign;
use App\Invoices;

use App\Business;

use App\Mail\PublishMail;
use Illuminate\Support\Facades\Mail;

class PublishNewAdsTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'publish:test';

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
        // \Illuminate\Support\Facades\Log::info("artisan command: publish:test (PublishNewAdsTest)");

        $today = date("Y-m-d");
        $number = date('N', strtotime($today));
        if($number == 0){
            $number = 6;
        }
        else{
            $number = $number - 1;
        }
        $campaigns = UserCampaign::leftjoin('tbl_user', 'tbl_user.id', 'tbl_user_campaign.user_id')
            ->leftjoin('tbl_invoice', 'tbl_invoice.campaign_id', 'tbl_user_campaign.id')
            ->select('tbl_user_campaign.*', 'tbl_user.business_name', 'tbl_invoice.invoice_date', 'tbl_invoice.status')
            ->get();
        $business_names = [];
        $locations_by_business = [];
        // Get Upcoming
        $ads = DB::table('tbl_ad')
            ->where('playlist', 1)
            ->where('publish', 1)
            ->where('days', 'like', "%".$number."%")
            ->orderBy('business_name')
            ->get();
        $upcomming = [];
        foreach($ads as $media_temp){
            if($media_temp->playlist == 1){
                $upcomming[] = $media_temp->business_name;
            }
        }
        // End of Upcoming
        foreach ($campaigns as $key => $campaign) {
            $business_name = $campaign->business_name;
            if($business_name != '1 Demo' && $campaign->start_date <= $today && $campaign->end_date >= $today && ( $campaign->free_plan == 3 || $campaign->status ==1 || ($campaign->invoice_date > $today && $campaign->status == 0))){
                $ava_locations = explode(",", $campaign->locations);
                $ava_slots = explode(",", $campaign->slots);
                if(!in_array($business_name, $business_names)){
                    $business_names[] = $business_name;
                }
                foreach($ava_locations as $k => $loc){
                    $location = DB::table('tbl_locations')
                        ->where('id', $loc)->first();
                    // Check if the locatin is restricted
                    $restrict = DB::table("tbl_restrict")
                        ->where('business_name', $business_name)
                        ->where('location_id', $location->id)
                        ->first();
                    if(!in_array($business_name."-".$location->name, $locations_by_business) || isset($restrict->id)){
                    // if(!in_array($business_name."-".$location->name, $locations_by_business) && !isset($restrict->id)){
                        for($i = 0; $i < $ava_slots[$k]; $i++){
                            // Already Exists
                            $p = $i + 1;
                            $exist = DB::table('tbl_sub_list')
                                ->where('business_name', $business_name)
                                ->where('location', $location->name)
                                ->where('camp_id', $campaign->id)
                                ->where('slots', $p)
                                ->first();
                            if(in_array($business_name, $upcomming)){
                                if(!isset($exist->id)){
                                    $sub_name = "Sub-".$business_name."-".$location->name."-".$campaign->id."-".$p;
                                    $locations_by_business[] = $sub_name;
                                    DB::table("tbl_sub_list")
                                        ->insert([
                                            'business_name' => $business_name,
                                            'location' => $location->name,
                                            'camp_id' => $campaign->id,
                                            'start_date' => $campaign->start_date,
                                            'end_date' => $campaign->end_date,
                                            'slots' => $p,
                                            'sub_name' => $sub_name
                                        ]);
                                }
                                if(isset($exist->id) && $exist->sub_id == 0){
                                    $sub_name = "Sub-".$business_name."-".$location->name."-".$campaign->id."-".$p;
                                    $locations_by_business[] = $sub_name;
                                }
                            }
                        }
                    }
                }
            }
        }
        $controller = app()->make('App\Http\Controllers\ManageScala');
        $maincontroller = app()->make('App\Http\Controllers\MainController');
        $sublist_array = [];
        foreach($locations_by_business as $key => $temp){
            $sub = DB::table('tbl_sub_list')
                ->where('sub_name', $temp)
                ->first();
            if(isset($sub->id) && ($sub->sub_id == '' || $sub->sub_id == null)){
                $sub_id = app()->call([$controller, 'get_playlist_id'], [
                    "name" => $temp,
                    "business_name" => $sub->business_name,
                ]);
                $sublist_array[] = $sub_id;
                DB::table('tbl_sub_list')
                    ->where('sub_name', $temp)
                    ->update([
                        'sub_id' => $sub_id
                    ]);
                // Add Sub To Master
                if($sub->master_id == '' || $sub->master_id == null){
                    $master_id = app()->call([$maincontroller, 'get_mplaylist_id'], [
                        "name" => $sub->location,
                    ]);
                    app()->call([$maincontroller, 'add_subplay_main'], [
                        "master_id" => $master_id,
                        "sub_id" => $sub_id,
                    ]);
                    DB::table('tbl_sub_list')
                        ->where('sub_name', $temp)
                        ->update([
                            'master_id' => $master_id
                        ]);
                }
            }
        }
        // End of Playlist
        $ads = DB::table('tbl_ad')
            ->where('playlist', 1)
            ->where('publish', 1)
            // ->where('delivery', 1)
            ->whereIn('business_name', $business_names)
            ->where('days', 'like', "%".$number."%")
            ->orderBy('business_name')
            ->get();
        foreach($ads as $media_temp){
            // Delivery Media To CM
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
                $days = $media_temp->days;
                if($media_temp->schedule == 'ime'){
                    $days = '0,1,2,3,4,5,6,' ;
                }
                if($media_temp->playlist == 1){
                    $playlists = DB::table("tbl_sub_list")
                        ->where('business_name', $media_temp->business_name)
                        ->get();
                    foreach($playlists as $val => $temp){
                        app()->call([$controller, 'add_media_playlist'], [
                            "playlist_id" => $temp->sub_id,
                            "media_id" => $media_id,
                        ]);
                        DB::table('tbl_sub_1')
                            ->insert([
                                'ad_id' => $media_temp->id,
                                'sub_id' => $temp->sub_id,
                                'location' => $temp->location,
                                'days' => $days,
                                'schedule' => $media_temp->schedule,
                                'start_date' => $media_temp->s_date==null?date('Y-m-d'):$media_temp->s_date,
                                'end_date' => $media_temp->e_date==null?date('Y-m-d'):$media_temp->e_date,
                            ]);
                    }
                }
                DB::table('tbl_ad')
                    ->where('id', $media_temp->id)
                    ->update([
                        'delivery' => 1
                    ]);
        }
        // echo "Publish Ads";
        return;

        
        // Update SIC Number
        $controller = app()->make('App\Http\Controllers\ManageScala');
        $apiToken = app()->call([$controller, 'get_token']);

        $exist = DB::table('tbl_sub_list')->get();
        foreach($exist as $key => $val){
            $business_name = $val->business_name;
            $sic = Business::where('company_name', $business_name)->first();
            $sic_num = "";
            if(isset($sic->id)){
                $sic_num = $sic->category;
                $sub_id = $val->sub_id;

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/".$sub_id."/partial",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "PUT",
                    CURLOPT_POSTFIELDS =>"{\n \"description\":\"".$sic_num."\" }",
                    CURLOPT_HTTPHEADER => array(
                        "Content-Type: application/json",
                        "apiToken: ".$apiToken
                    ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);
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
