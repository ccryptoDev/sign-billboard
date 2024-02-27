<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Business;
use App\CMToken;
use App\CronHistory;

class ManageScala extends Controller
{
    public function get_token(){
        $token = CMToken::first();
        return $token->token;
    }
    // Update Duration by Medias
    public function update_player_duration(){
        $apiToken = $this->get_token();
        $result = $this->get_all_sub_id();
        if(isset($result['success']) && $result['success'] == true){
            foreach($result['data'] as $key => $val){
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/".$val."",
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
                // Update Duration of 
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/".$val,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "PUT",
                    CURLOPT_POSTFIELDS =>$fix,
                    CURLOPT_HTTPHEADER => array(
                        "apiToken: ".$apiToken,
                        "Content-Type: application/json"
                    ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);
            }
        }
        else{
            $history = new CronHistory;
            $history->type = "Update Duration";
            $history->desc = $result['data'];
            $history->save();
        }
        return $result;
    }
    // Update Duration of master
    public function update_master_duration(){
        $apiToken = $this->get_token();
        $masters = DB::table('tbl_locations')->get();
        foreach($masters as $key => $val){
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/calculateDuration/?uuid=".$val->master_id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "PUT",
                CURLOPT_HTTPHEADER => array(
                    "apiToken: ".$apiToken,
                    "Content-Type: application/json"
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            // Update Total Number of master playlist
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/".$val->master_id."?calculateDuration=true",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "apiToken: ".$apiToken,
                    "Content-Type: application/json"
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $res = json_decode($response, true);
            if(isset($res['id'])){
                DB::table('tbl_locations')
                    ->where('id', $val->id)
                    ->update([
                        'cur_sub' => $res['itemCount']
                    ]);
            }
        }
    }
    // Update Duration by ID
    public function update_duruation_by_id($id){
        $apiToken = $this->get_token();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/".$id."",
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
        // Update Duration of 
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/".$id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS =>$fix,
            CURLOPT_HTTPHEADER => array(
                "apiToken: ".$apiToken,
                "Content-Type: application/json"
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
    }
    // List all of Sub Playlist
    public function get_all_sub_id(){
        $apiToken = $this->get_token();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/all?limit=1000",
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
        $result = array();
        $list_ids = [];
        if(isset($res['list'])){
            foreach($res['list'] as $key => $val){
                if(str_contains($val['name'], "Sub")){
                    if($val['itemCount'] != 0){
                        $list_ids[] = $val['id'];
                    }
                }
            }
            $result['success'] = true;
            $result['data'] = $list_ids;
        }
        else{
            $result['success'] = false;
            $result['data'] = $response;
        }
        return $result;
    }
    // Get Sub Playlist By Name
    public function get_playlist_id($name, $business_name){
        // Get SIC 
        $sic = Business::where('company_name', $business_name)->first();
        $sic_num = "";
        if(isset($sic->id)){
            $sic_num = $sic->category;
        }
        // End of SIC
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
            $sub_id = $res['id'];
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
            return $sub_id;
        }
        else{
            return $this->create_playlist($name, $business_name);
        }
    }
    public function create_playlist($name, $business_name){
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
            // Update SIC
            $this->update_SIC($res['id'], $business_name);
            return $res['id'];
        }
        else{
            return "Fail To Create SubPlayList";
        }
    }
    // Update SIC
    public function update_SIC($sub_id, $business_name){
        // Get SIC 
        $sic = Business::where('company_name', $business_name)->first();
        $sic_num = "";
        if(isset($sic->id)){
            $sic_num = $sic->category;
        }
        // End of SIC
        $apiToken =$this->get_token();

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
    // Upload Media to CM
    public function upload_media_to_cm($tbl_id,$dis_name,$img_path,$status,$media_id){
        // Init CM
        $apiToken = $this->get_token();
        if($status == 1){
            $cre_date = date("Y-m-dH-i-s");
            $dis_name = $dis_name.$tbl_id;
            $dis_name = str_replace(" ", "", $dis_name);
            $dis_name = str_replace("/", "", $dis_name);
            $exist_flag = false;
            // List Media

            // $rand = rand(10,100000);
            // $rand = md5($rand);
            $rand = $this->generateRandomString(20);
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
            if(isset($init_res['uuid'])){
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
    // Add Media To PlayList
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
            }
        }
    }
    // Sort Sub playlist By SIC
    public function update_sort(){
        $apiToken = $this->get_token();
        $locations = DB::table('tbl_locations')->get();
        foreach($locations as $key => $val){
            $urlname = str_replace(" ", "%20", $val->name);
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
            $subplaylist = [];
            $new_sub_list = [];
            $list_keys = [];
            if(isset($res['playlistItems'])){
                foreach($res['playlistItems'] as $key => $item){
                    $subplaylist[] = $item;
                    if(isset($item['subplaylist']['description'])){
                        $list_keys[] = intval($item['subplaylist']['description']);
                    }
                    else{
                        $list_keys[] = 100000;
                    }
                }
                $old_list = $list_keys;
                usort($list_keys, function($a, $b) {
                    return $a - $b;
                });

                // foreach($old_list as $i => $temp){
                //     foreach($list_keys as $key => $item){
                //         if($temp == $item){
                //             $new_sub_list[$i] = $subplaylist[$key];
                //             $new_sub_list[$i]['sortOrder'] = $i + 1;
                //         }
                //     }
                // }
                foreach($list_keys as $key => $item){
                    foreach($old_list as $i => $temp){
                        if($temp == $item){
                            $new_sub_list[$key] = $subplaylist[$i];
                            $new_sub_list[$key]['sortOrder'] = $key + 1;
                        }
                    }
                }

                $res['playlistItems'] = $new_sub_list;
                $master_id = $res['id'];
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/".$master_id,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "PUT",
                    CURLOPT_POSTFIELDS =>json_encode($res),
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
    
    // Delete Sub Playlist
    public function delete_sub_play($name){
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
            $sub_id = $res['id'];
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/".$sub_id,
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
        }
    }
    // Delete Sub Playlist By Id
    public function delete_sub_by_id($sub_id){
        $apiToken =$this->get_token();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/".$sub_id,
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
    }
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
