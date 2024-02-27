<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\SocialPosts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Twitter
use Socialite;
use App\Services\SocialTwitterAccountService;
use TwitterAPIExchange;

class PostSocial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:social';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Post Ads to the Social';

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
        $posts = SocialPosts::where('post_date', $today)
            ->where('status', 0)
            ->get();
        $controller = app()->make('App\Http\Controllers\SocialController');  
        return;     
        foreach($posts as $key => $post){
            if(isset($post->client_id) && strtolower($post->business_name) != "1 demo"){
                $poster_id = $post->client_id;
                $poster = DB::table('tbl_user')->where('id', $poster_id)->first();
                if($poster->level == 0 || $poster->level == 1){
                    $socials = json_decode($post->socials, true);
                    if(in_array(0, $socials) && $poster->t_account == 1){
                        app()->call([$controller, 'post_twitter'], [
                            'id' => $post->id
                        ]);
                    }
                    if(in_array(1, $socials) && $poster->f_account == 1){
                        app()->call([$controller, 'post_facebook'], [
                            'id' => $post->id
                        ]);
                    }
                    if(in_array(2, $socials) && $poster->l_account == 1){
                        app()->call([$controller, 'post_linkedin'], [
                            'id' => $post->id
                        ]);
                    }
                    SocialPosts::where('id', $post->id)
                        ->update([
                            'status' => 1
                        ]);
                }
                else{
                    $posters = DB::table('tbl_user')
                        ->where('business_name', $post->business_name)->get();
                    foreach($posters as $poster){
                        $socials = json_decode($post->socials, true);
                        if(in_array(0, $socials) && $poster->t_account == 1){
                            app()->call([$controller, 'post_twitter'], [
                                'id' => $post->id
                            ]);
                        }
                        if(in_array(1, $socials) && $poster->f_account == 1){
                            app()->call([$controller, 'post_facebook'], [
                                'id' => $post->id
                            ]);
                        }
                        if(in_array(2, $socials) && $poster->l_account == 1){
                            app()->call([$controller, 'post_linkedin'], [
                                'id' => $post->id
                            ]);
                        }
                        SocialPosts::where('id', $post->id)
                            ->update([
                                'status' => 1
                            ]);
                    }
                }
            }
        }
        if(count($posts) > 0)  {
            echo "Delivery To Social";
        }
        else{
            // echo "Not Delivery To Social";
        }
    }
}
