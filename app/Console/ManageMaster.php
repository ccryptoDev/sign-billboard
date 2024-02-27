<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ManageMaster extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:master';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Master Playlist';

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
            CURLOPT_URL => "http://avacms10.scala.com/ContentManager/api/rest/channels/?limit=1000",
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
        // Playlist
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
        $response1 = curl_exec($curl);
        curl_close($curl);
        $res1 = json_decode($response1, true);
        if(isset($res['list'])){
            $list = $res['list'];
            foreach($list as $channel){
                $exist = false;
                if(isset($res1['list'])){
                    $play_lists = $res1['list'];
                    foreach($play_lists as $item){
                        if($item['name'] == $channel['name']){
                            $exist = true;
                            DB::table('tbl_locations')
                                ->where('name', $item['name'])
                                ->update([
                                    'master_id' => $item['id']
                                ]);
                        }
                    }
                    if($exist == false){
                        echo "Create Master Playlist - Name : ".$channel['name'];
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
                            CURLOPT_POSTFIELDS =>"{\n \"name\":\"".$channel['name']."\",\n \"description\":\"".$channel['name']."-Master Playlist\" ,\n \"playlistType\":\"MEDIA_PLAYLIST\" ,\n \"healthy\":\"true\" ,\n \"enableSmartPlaylist\":\"false\" ,\n \"sortOrder\" : \"0\"\n }",
                            CURLOPT_HTTPHEADER => array(
                                "Content-Type: application/json",
                                "apiToken: ".$apiToken
                            ),
                        ));
                        $response2 = curl_exec($curl);
                        curl_close($curl);
                        $exist = DB::table('tbl_locations')
                            ->where('name', $channel['name'])
                            ->first();
                        $res2 = json_decode($response2, true);
                        print_r($res2);
                        if(isset($exist->id)){
                            DB::table('tbl_locations')
                                ->where('name', $channel['name'])
                                ->update([
                                    'master_id' => $res2['id']
                                ]);
                        }
                        else{
                            if(isset($res2['id'])){
                                DB::table('tbl_locations')
                                    ->insert([
                                        'name' => $channel['name'],
                                        'nickname' => $channel['name'],
                                        'max' => 12,
                                        'cur_sub' => 0,
                                        'width' => 576,
                                        'height' => 384,
                                        'master_id' => $res2['id']
                                    ]);
                            }
                        }
                    }                
                }
            }
            // echo "Create Master";          
        }
        // echo $response;
    }
}
