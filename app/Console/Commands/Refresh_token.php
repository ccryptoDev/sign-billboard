<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\CMToken;

class Refresh_token extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh New Token of CM';

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
        \Illuminate\Support\Facades\Log::info("artisan command: refresh:token");

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
        
        \Illuminate\Support\Facades\Log::info("artisan command: refresh:token: updated token: " . $apiToken);

        $token = CMToken::first();
        if(isset($token->id)){
            CMToken::where('id', $token->id)
                ->update([
                'token' => $apiToken,
            ]);
        }
        else{
            $token = new CMToken;
            $token->token = $apiToken;
            $token->save();
        }
        // echo "Refresh Token";
        return $apiToken;
    }
}
