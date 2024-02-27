<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class CMController extends Controller
{
    public function get_sub_list(Request $request){
        $apiToken =$this->get_token();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists?limit=1000",
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
        $res = json_decode($response, true)['list'];
        return $res;
    }
    public function delete_sub_list(Request $request){
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
            CURLOPT_POSTFIELDS =>"",
            CURLOPT_HTTPHEADER => array(
                    "apiToken: ".$apiToken,
                    "Content-Type: application/json"
                ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return "success";
    }
    public function get_token(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/auth/login",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>"{\n  \"username\" : \"taifu\", \n  \"password\" : \"".config('app.cm_pass')."\" \n}",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $apiToken = json_decode($response,true)["apiToken"];
        return $apiToken;
    }
}
