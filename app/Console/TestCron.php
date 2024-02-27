<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;
use App\PaymentMethod;
use App\Invoices;
use App\CheckoutModel;
use App\UserCampaign;
use App\Business;

use App\Mail\CampaignEnding;
use App\Mail\CampaignReminder;
use App\Mail\ContractInvoice;
use App\Mail\TempInvoiceEmail;
use App\Mail\DeclineCard;
use App\Mail\RecurMail;
use App\Mail\GoogleReview;
use Illuminate\Support\Facades\Mail;

use Dompdf\Dompdf;
use Dompdf\Options;

class TestCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily or half command for general actions';

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
        // Cancel Subscriptions manually
        $stripe = new \Stripe\StripeClient(
            config('app.st_sec')
        );
        // Payment Method
        $decline_list = [];
        $checkouts = CheckoutModel::where('email_date', null)->get();
        foreach($checkouts as $bill){
            // Retrieve Schedule
            try{
                $subscription = $stripe->subscriptionSchedules->retrieve(
                    $bill->ch_id,
                    []
                );
                if(isset($subscription['id'])){
                    $status = $subscription['status'];
                    if(isset($subscription['phases'][0])){
                        $sub_end_date = $subscription['phases'][0]['end_date'];
                        if(strtotime($today) < $sub_end_date){
                            $campaign_id = $bill->campaign_id;
                            $decline_list[] = $campaign_id;
                            $campaign = UserCampaign::where('id', $campaign_id)->first();
                            $user = DB::table('tbl_user')
                                ->leftjoin('tbl_business', 'tbl_user.id', 'tbl_business.primary_id')
                                ->where('tbl_user.id', $bill->user_id)
                                ->select('tbl_user.*', 'tbl_business.bill_name')
                                ->first();
                            if(isset($user->id)){
                                // Mail::to($user->email)->send(new DeclineCard($user, $campaign));
                                // Mail::to('jing@inex.net')->send(new DeclineCard($user, $campaign));
                                CheckoutModel::where('id', $bill->id)
                                    ->update([
                                        'email_date' => $today
                                    ]);
                            }

                            $business = Business::where('primary_id', $bill->user_id)->first();
                            $accounter = DB::table('tbl_user')
                                ->where('id', $business->sales)
                                ->first();
                            if(isset($accounter->id)){
                                // Mail::to($user->email)->send(new DeclineCard($user, $campaign));
                            }
                        }
                        else{
                            
                        }
                    }
                }
            } catch(\Stripe\Exception\CardException $e) {
                // echo $e->getError()->message;
            } catch (\Stripe\Exception\RateLimitException $e) {
                // echo $e->getError()->message;
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                // echo $e->getError()->message;
            } catch (\Stripe\Exception\AuthenticationException $e) {
                // echo $e->getError()->message;
            } catch (\Stripe\Exception\ApiConnectionException $e) {
                // echo $e->getError()->message;
            } catch (\Stripe\Exception\ApiErrorException $e) {
                // echo $e->getError()->message;
            } catch (\Stripe\Exception\InvalidArgumentException $e) {
                echo 'Error Subscription - Campaign ID: '.$val->id.",";
                // echo $e->getError()->message;
            }
            catch (Exception $e) {
                echo $e->getError()->message;
            }
            // Retrieve a subscription
            try{
                $subscription = $stripe->subscriptions->retrieve(
                    $bill->ch_id,
                    []
                );
                if(isset($subscription['id'])){
                    $status = $subscription['status'];
                    if(isset($subscription['phases'][0])){
                        $sub_end_date = $subscription['phases'][0]['end_date'];
                        if(strtotime($today) < $sub_end_date){
                            $campaign_id = $bill->campaign_id;
                            $decline_list[] = $campaign_id;
                            $campaign = UserCampaign::where('id', $campaign_id)->first();
                            $user = DB::table('tbl_user')
                                ->leftjoin('tbl_business', 'tbl_user.id', 'tbl_business.primary_id')
                                ->where('tbl_user.id', $bill->user_id)
                                ->select('tbl_user.*', 'tbl_business.bill_name')
                                ->first();
                            if(isset($user->id)){
                                // Mail::to($user->email)->send(new DeclineCard($user, $campaign));
                                // Mail::to('jing@inex.net')->send(new DeclineCard($user, $campaign));
                                CheckoutModel::where('id', $bill->id)
                                    ->update([
                                        'email_date' => $today
                                    ]);
                            }

                            $business = Business::where('primary_id', $bill->user_id)->first();
                            $accounter = DB::table('tbl_user')
                                ->where('id', $business->sales)
                                ->first();
                            if(isset($accounter->id)){
                                // Mail::to($user->email)->send(new DeclineCard($user, $campaign));
                            }
                        }
                        else{
                            
                        }
                    }
                }
            } catch(\Stripe\Exception\CardException $e) {
                // echo $e->getError()->message;
            } catch (\Stripe\Exception\RateLimitException $e) {
                // echo $e->getError()->message;
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                // echo $e->getError()->message;
            } catch (\Stripe\Exception\AuthenticationException $e) {
                // echo $e->getError()->message;
            } catch (\Stripe\Exception\ApiConnectionException $e) {
                // echo $e->getError()->message;
            } catch (\Stripe\Exception\ApiErrorException $e) {
                // echo $e->getError()->message;
            } catch (\Stripe\Exception\InvalidArgumentException $e) {
                echo 'Error Subscription - Campaign ID: '.$val->id.",";
                // echo $e->getError()->message;
            }
            catch (Exception $e) {
                echo $e->getError()->message;
            }
        }
        // Update Credit Card Invoice Status and Generate sub invoice for send invoice
        // $invoices = Invoices::get();
        $invoices = Invoices::leftJoin('tbl_user_campaign', 'tbl_user_campaign.id', '=', 'tbl_invoice.campaign_id')
            ->select('tbl_invoice.*', 'tbl_user_campaign.end_date')
            ->get();
        $now = time();
        foreach($invoices as $key => $val){
            $end_date = strtotime($val->invoice_date);
            $datediff = $end_date - $now;
            $datediff = round($datediff / (60 * 60 * 24));
            $campaign_end = strtotime($val->end_date);
            $valid = false;
            if($val->end_date != '' && $campaign_end > $now) {
                $valid = true;
            }
            if($val->campaign_id == 309) {
                echo 'qqqq';
                echo $valid;
            }
            
            if(($val->pay_method == 1 && $datediff == 10) || ($val->pay_method == 0 && $val->paid != 0 && !in_array($val->campaign_id, $decline_list))){
            // if($val->pay_method == 0 && $val->paid != 0 && !in_array($val->campaign_id, $decline_list)){ // Only Send to Credit Card
                if(($val->pay_method == 1 && $datediff == 10) || ($val->pay_method == 0 && $today == $val->invoice_date)){
                    $campaign = UserCampaign::where('id', $val->campaign_id)->first();
                    $intval = 1;
                    if($val->sch == 2){
                        $intval = 4;
                    }
                    if($val->sch == 3){
                        $intval = 12;
                    }
                    if($val->sch == 0){
                        $intval = $campaign->weeks;
                    }
                    $paid = intval($val->paid) + $intval;
                    $status = 0;
                    if($paid >= $campaign->weeks){
                        $status = 0;
                        $paid = $campaign->weeks;
                        $intval = $intval - ($campaign->weeks - $paid);
                    }
                    if($val->pay_method == 0){
                        $due_date = date('Y-m-d',strtotime($intval." week"));
                    }
                    else{
                        $due_date = date('Y-m-d',strtotime($intval." week", strtotime($val->invoice_date)));
                    }
                    $amount = $intval * $campaign->part_amount;
                    $campaign_id = $campaign->id;
                    if($campaign_id == 309) {
                        echo '123123123123';
                    }
                    // Generate sub invoice
                    // $controller = app()->make('App\Http\Controllers\InvoiceController');
                    // app()->call([$controller, 'generate_sub_invoice'], [
                    //     'invoice_id' => $val->id,
                    //     'user_id' => $campaign->user_id
                    // ]);
                }
            }
        }
        echo "Daily Command";
        // Mail::to($val->email)->send(new CampaignEnding($user,$suggestion));
    }
    public function cancel_subscription($id){
        $stripe = new \Stripe\StripeClient(
            config('app.st_sec')
        );
        try {
            $stripe->subscriptions->cancel(
                $id,
                []
            );
        } catch(\Stripe\Exception\CardException $e) {
            // echo $e->getError()->message;
        } catch (\Stripe\Exception\RateLimitException $e) {
            // echo $e->getError()->message;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // echo $e->getError()->message;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            // echo $e->getError()->message;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            // echo $e->getError()->message;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // echo $e->getError()->message;
        } catch (\Stripe\Exception\InvalidArgumentException $e) {
            // echo 'Error Subscription - Campaign ID: '.$val->id.",";
            // echo $e->getError()->message;
        }
        catch (Exception $e) {
            // echo $e->getError()->message;
        }
    }
}
