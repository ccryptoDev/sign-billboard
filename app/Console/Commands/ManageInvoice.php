<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Mail\UserCampaignMail;
use App\Mail\EndCampNotification;
use Illuminate\Support\Facades\Mail;
use App\UserCampaign;
use App\Invoices;

class ManageInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Prior Invoices by daily';

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
        $three_after = date("Y-m-d", strtotime("+3 day"));
        $end_date = date("Y-m-d", strtotime("+4 day"));
        // Send Invoice Email
        $campaigns = UserCampaign::where('start_date', $today)
            ->orWhere('start_date', $three_after)
            ->where('pay_method', 1)
            ->get();
        $locations = DB::table('tbl_locations')->get();
        foreach($campaigns as $val){
            $invoice = Invoices::where('campaign_id', $val->id)->first();
            if($invoice->status != 1){
                if($invoice->invoice_date == $today || $invoice->invoice_date == $three_after){
                    $user = DB::table('tbl_user')->where('id', $val->user_id)->first();
                    Mail::to('billing@inex.net')->send(new UserCampaignMail($user, $val, 2, $locations));
                    Mail::to($user->email)->send(new UserCampaignMail($user, $val, 2, $locations));
                }
            }
        }
        // Upcoming end
        $campaigns = UserCampaign::where('end_date', $today)
            ->orWhere('end_date', $end_date)
            ->get();
        foreach($campaigns as $val){
            $user = DB::table('tbl_user')->where('id', $val->user_id)->first();
            Mail::to('billing@inex.net')->send(new EndCampNotification($user, $val, 1, $locations));
            Mail::to($user->email)->send(new EndCampNotification($user, $val, 1, $locations));
        }
        echo "Manage Invoice";
        return "success";

        $invoices = DB::table('tbl_invoice')
            // ->where('invoice_date', $today)
            // ->whereOr('invoice_date', $three_after)
            // ->where('pay_method', 1)
            // ->where('status', 0)
            ->get();
        foreach($invoices as $invoice){
            $send_email = InvoiceEmail::where('invoice_id', $invoice->id)
                ->where('invoice_date', $today)
                ->first();
            $sent_flag = false;
            if(isset($send_email->id)){
                $sent_flag = true;
            }
            $campaign = DB::table('tbl_user_campaign')
                ->where('id', '=', $invoice->campaign_id)
                ->get();
            $locations = DB::table('tbl_locations')->get();
            foreach($campaign as $val){
                if(isset($invoice->id)){
                    // $inv_email = InvoiceEmail::where('invoice_id')
                    $user = DB::table('tbl_user')->where('id', $val->user_id)->first();
                    Mail::to('billing@inex.net')->send(new UserCampaignMail($user, $val, 2, $locations));
                }
            }
            // Send Notification before end up
            // $end_ava = date("Y-m-d", strtotime("+1 week"));
            // $campaign = DB::table('tbl_user_campaign')
            //     ->where('end_date', '>', $today)
            //     ->where('end_date', '<=', $end_ava)
            //     ->get();
            foreach($campaign as $val){
                $user = DB::table('tbl_user')->where('id', $val->user_id)->first();
                if($today == $val->end_date){
                    // 1 : Admin or Sales man, 0 : Client
                    Mail::to('ming@inex.net')->send(new EndCampNotification($user, $val, 1, $locations));    
                    // Mail::to('latenser@inex.net')->send(new EndCampNotification($user, $val, 1, $locations));    
                }
                if($val->notification == 0){
                    Mail::to('ming@inex.net')->send(new EndCampNotification($user, $val, 1, $locations));
                    // Mail::to('latenser@inex.net')->send(new EndCampNotification($user, $val, 1, $locations));
                    // DB::table('tbl_user_campaign')
                    //     ->where('id', $val->id)
                    //     ->update([
                    //         'notification' => 1
                    //     ]);
                }
            }
        }
        return "success";
    }
}
