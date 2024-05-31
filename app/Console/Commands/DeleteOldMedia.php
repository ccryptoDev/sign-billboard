<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Logs;
use App\UserCampaign;
use App\Mail\DeleteMedia;
use Illuminate\Support\Facades\Mail;
use App\CheckoutModel;

class DeleteOldMedia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:medias-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Expired Medias From CM';

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
        // DB::table('tbl_ad')
        //     ->where('media_id', null)
        //     ->update([
        //         'delivery' => 0
        //     ]);
        $today = date("Y-m-d");
        $number = date('N', strtotime($today));
        if($number == 0){
            $number = 6;
        }
        else{
            $number = $number - 1;
        }
        $ads = DB::table('tbl_ad')
            ->where('media_id', "!=", null)
            ->orderBy('business_name')
            ->get();
        $controller = app()->make('App\Http\Controllers\MainController');
        $apiToken = app()->call([$controller, 'get_token']);
        foreach($ads as $key){
            // Unchecked Medias
            $business_name = $key->business_name;
            $campaigns = UserCampaign::leftjoin('tbl_user', 'tbl_user.id', 'tbl_user_campaign.user_id')
                ->leftjoin('tbl_invoice', 'tbl_invoice.campaign_id', 'tbl_user_campaign.id')
                ->select('tbl_user_campaign.*', 'tbl_user.business_name', 'tbl_invoice.invoice_date', 'tbl_invoice.status')
                ->where('tbl_user.business_name', $business_name)
                ->get();
            $ava_locations = [];
            $remove_locations_name = [];
            $exist_day = true;
            if(!str_contains($key->days, $number)){
                $exist_day = false;
            }
            $exist_campaign = false;
            // Get Delete Locations
            foreach($campaigns as $campaign){
                if(($campaign->end_date < $today && ($campaign->status ==1 || ($campaign->invoice_date > $today && $campaign->status == 0))) || $exist_day == false || $campaign->free_plan != 3){            
                    $ava_locations = explode(",", $campaign->locations);
                    foreach($ava_locations as $loc){
                        $location = DB::table('tbl_locations')
                            ->where('id', $loc)->first();
                        $remove_locations_name[] = $location->name;
                    }
                }
            }
            // Remove Locations if they have avaiable campaign
            foreach($campaigns as $campaign){
                if($campaign->start_date <= $today && $campaign->end_date >= $today && ( $campaign->free_plan == 3 || $campaign->status ==1 || ($campaign->invoice_date > $today && $campaign->status == 0))){
                    $ava_locations = explode(",", $campaign->locations);
                    foreach($ava_locations as $loc){
                        $location = DB::table('tbl_locations')
                            ->where('id', $loc)->first();
                        foreach (array_keys($remove_locations_name, $location->name) as $temp) {
                            unset($remove_locations_name[$temp]);
                        }
                    }
                }
            }
            $location = [];
            foreach(explode(",",$key->location) as $loc){
                if(in_array($loc, $remove_locations_name)){
                    $location[] = $loc;
                }
            }
            if($exist_day == false || $key->playlist == 0 || (count($location) != 0 && (!isset($campaign->id) || ($campaign->start_date > $today || $campaign->end_date < $today)))){
                $media_id = $key->media_id;

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
                // Calculate Duration
                $location_array =  $key->location;
                $location = explode(",",$location_array);
                $sublist_array = [];
                $subname_array = [];
                $controller = app()->make('App\Http\Controllers\MainController');
                for($i = 0; $i < count($location)-1; $i++){
                    $avaliable_playlist = app()->call([$controller, 'get_playlist_id_from_delete'], [
                        "name" => "Sub-".$key->business_name,
                    ]);
                    if(!in_array($avaliable_playlist,$sublist_array)){
                        array_push($sublist_array,$avaliable_playlist);
                        array_push($subname_array,$location[$i]);
                    }
                    // O : Approve, 1 : Update, 2 : Delete, 3 : Publish To Social, 4: Created 
                    $log = new Logs;
                    $log->status = 2;
                    $log->ad_id = $key->id;
                    $log->user_id = 0;
                    $log->extra = "Deleted By Cron";
                    $log->company_name = $key->business_name;
                    $log->save();
                }
                foreach($sublist_array as $item){
                    $avaliable_playlist = app()->call([$controller, 'update_calculation'], [
                        "id" => $item,
                    ]);
                }
                DB::table('tbl_ad')
                    ->where('id', $key->id)
                    ->update([
                        'media_id' => null,
                        'delivery' => 0,
                    ]);
            }
                
        }
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
}
