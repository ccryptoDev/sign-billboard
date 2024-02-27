<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Logs;
use App\UserCampaign;
use App\PublishList;
use App\RestrictLocation;
use App\Invoices;
use App\CheckoutModel;
use App\Mail\DeleteMedia;
use Illuminate\Support\Facades\Mail;

class DeleteMeidas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:medias';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $today = date("Y-m-d");
        $number = date('N', strtotime($today));
        if($number == 0){
            $number = 6;
        }
        else{
            $number = $number - 1;
        }

        $controller = app()->make('App\Http\Controllers\ManageScala');
        $maincontroller = app()->make('App\Http\Controllers\MainController');
        $apiToken = app()->call([$maincontroller, 'get_token']);
        // Get Available Location and Business name 
        $campaigns = UserCampaign::leftjoin('tbl_user', 'tbl_user.id', 'tbl_user_campaign.user_id')
            ->leftjoin('tbl_invoice', 'tbl_invoice.campaign_id', 'tbl_user_campaign.id')
            ->select('tbl_user_campaign.*', 'tbl_user.business_name', 'tbl_invoice.invoice_date', 'tbl_invoice.status')
            ->get();
        $business_names = [];
        $locations_by_business = [];
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
                    if(!in_array($business_name."-".$location->name, $locations_by_business) && !isset($restrict->id)){
                        for($i = 0; $i < $ava_slots[$k]; $i++){
                            // Already Exists
                            $p = $i + 1;
                            $exist = DB::table('tbl_sub_list')
                                ->where('business_name', $business_name)
                                ->where('location', $location->name)
                                ->where('camp_id', $campaign->id)
                                ->where('slots', $p)
                                ->first();
                            // if(!isset($exist->id)){
                                $sub_name = "Sub-".$business_name."-".$location->name."-".$campaign->id."-".$p;
                                $locations_by_business[] = $sub_name;
                            // }
                        }
                    }
                }
            }
        }
        $playlists = DB::table('tbl_sub_list')
            ->whereNotIn('sub_name', $locations_by_business)
            ->get();
        foreach($playlists as $key => $val){
            $sub_id = app()->call([$controller, 'delete_sub_by_id'], [
                "sub_id" => $val->sub_id,
            ]);
            DB::table('tbl_sub_list')
                ->where('id', $val->id)
                ->delete();
        }
        $campaigns = UserCampaign::leftjoin('tbl_user', 'tbl_user.id', 'tbl_user_campaign.user_id')
            ->leftjoin('tbl_invoice', 'tbl_invoice.campaign_id', 'tbl_user_campaign.id')
            ->select('tbl_user_campaign.*', 'tbl_user.business_name', 'tbl_invoice.invoice_date', 'tbl_invoice.status')
            ->get();
        $business_names = [];
        $locations_by_business = [];
        $exist_day = true;
        foreach ($campaigns as $key => $campaign) {
            $business_name = $campaign->business_name;
            // Get Delete Locations
            if(($campaign->end_date < $today && ($campaign->status ==1 || ($campaign->invoice_date > $today && $campaign->status == 0))) || $exist_day == false || $campaign->free_plan != 3){            
                if(!in_array($business_name, $business_names)){
                    $business_names[] = $business_name;
                }
            }
        }
        foreach ($campaigns as $key => $campaign) {
            if($campaign->start_date <= $today && $campaign->end_date >= $today && ( $campaign->free_plan == 3 || $campaign->status ==1 || ($campaign->invoice_date > $today && $campaign->status == 0))){
                $business_name = $campaign->business_name;
                foreach (array_keys($business_names, $business_name) as $temp) {
                    unset($business_names[$temp]);
                }
            }
        }
        // End of Playlist
        $ads = DB::table('tbl_ad')
            // ->where('playlist', 1)
            ->whereIn('business_name', $business_names)
            // ->where('days', 'like', "%".$number."%")
            ->orderBy('business_name')
            ->get();
        $this->delete_ads($ads);
        $ads = DB::table('tbl_ad')
            ->where('publish', 0)
            ->where('media_id', "!=", null)
            ->orderBy('business_name')
            ->get();
        $this->delete_ads($ads);
        // List Media and Delete if they are not exist in our database
        $ad_ids = [];
        $ads = DB::table('tbl_ad')
            ->get();
        foreach($ads as $key => $val){
            if($val->media_id != null){
                $ad_ids[] = $val->media_id;
            }
        }
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/media?limit=1000",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS =>"",
            CURLOPT_HTTPHEADER => array(
                "apiToken: ".$apiToken,
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $list_medias = json_decode($response, true);
        if(isset($list_medias['list'])){
            $lists = $list_medias['list'];
            foreach($lists as $temp){
                if(!in_array($temp['id'], $ad_ids) && $temp['mediaType'] == "IMAGE"){
                    // Delete Media From CM
                    $curl = curl_init();
            
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/media/".$temp['id'],
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
            }
        }
    }
    public function delete_ads($ads){
        $controller = app()->make('App\Http\Controllers\MainController');
        $apiToken = app()->call([$controller, 'get_token']);
        foreach($ads as $media_temp){
            // Delivery Media To CM
            $exist_flag = false;
            if(isset($media_temp->media_id) && $media_temp->media_id !== null){
                $media_id = $media_temp->media_id;
                // Delete Media From CM
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
            DB::table('tbl_ad')
                ->where('id', $media_temp->id)
                ->update([
                    'media_id' => null,
                    'delivery' => 0,
                ]);
        }
    }
}
