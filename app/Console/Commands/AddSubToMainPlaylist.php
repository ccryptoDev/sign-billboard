<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AddSubToMainPlaylist extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'approve:subplay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add SubPlayList to main';

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
        \Illuminate\Support\Facades\Log::info("artisan command: approve:subplay");
        
        $masters = DB::table('tbl_locations')->get();
        $controller = app()->make('App\Http\Controllers\ManageScala');
        $maincontroller = app()->make('App\Http\Controllers\MainController');
        foreach($masters as $key => $item){
            $master_id = $item->master_id;
            if($master_id != ''){
                $playlist = app()->call([$controller, 'get_playlist_from_id'], [
                    "master_id" => $master_id
                ]);
                $current_subs = [];
                if(isset($playlist['playlistItems'])){
                    $playlistItems = $playlist['playlistItems'];
                    foreach($playlistItems as $play){
                        $current_subs[] = $play['subplaylist']['id'];
                    }
                }

                $subs = DB::table('tbl_sub_list')->where('master_id', $master_id)->get();
                foreach($subs as $temp){
                    if(!in_array($temp->sub_id, $current_subs)){
                        // echo $temp->sub_id.',';
                        // app()->call([$maincontroller, 'add_subplay_main'], [
                        //     "master_id" => $master_id,
                        //     "sub_id" => $temp->sub_id,
                        // ]);
                    }
                }
            }
        }
    }
}
