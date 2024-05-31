<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearPlaylist extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear Emply Playlist';

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
        $controller = app()->make('App\Http\Controllers\MainController');
        $apiToken = app()->call([$controller, 'get_token']);
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
        $res = json_decode($response, true);
        if(isset($res['list'])){
            $res = json_decode($response, true)['list'];
            foreach($res as $key => $val){
                if($val['itemCount'] == 0 && substr($val['name'], 0,3) == "Sub"){
                    // Delete Playlist From DB
                    DB::table('tbl_sub_list')
                        ->where('sub_name', $val['name'])
                        ->delete();
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/playlists/".$val['id'],
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
                    echo "Delete Empty PlayList";
                }
                else{
                    // Update Number of current slot
                    $locations = DB::table('tbl_locations')->get();
                    foreach($locations as $item){
                        if($val['name'] == $item->name){
                            app()->call([$controller, 'get_number_of_subplay'], [
                                "master_id" => $val['id'],
                                "sub_name" => $item->name,
                            ]);
                        }
                    }
                }
            }
        }
    }
}
