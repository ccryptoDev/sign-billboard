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

class DailyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:command';

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
        $campaigns = UserCampaign::where('end_date', '<=', $today)->get();
        foreach ($campaigns as $key => $val) {
            $bill = CheckoutModel::where('campaign_id', $val->id)->first();
            if(isset($bill->ch_id)){
                try{
                    $subscription = $stripe->subscriptionSchedules->retrieve(
                        $bill->ch_id,
                        []
                    );
                    if(isset($subscription['id'])){
                        try {
                            if(isset($subscription['released_subscription'])){
                                $stripe->subscriptionSchedules->cancel(
                                    $bill->ch_id,
                                    []
                                );
                                // $stripe->subscriptions->cancel(
                                //     $subscription['released_subscription'],
                                //     []
                                // );
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
                        // try {
                        //     $stripe->subscriptionSchedules->cancel(
                        //         $subscription['id'],
                        //         []
                        //     );
                        // } catch(\Stripe\Exception\CardException $e) {
                        //     // echo $e->getError()->message;
                        // } catch (\Stripe\Exception\RateLimitException $e) {
                        //     // echo $e->getError()->message;
                        // } catch (\Stripe\Exception\InvalidRequestException $e) {
                        //     // echo $e->getError()->message;
                        // } catch (\Stripe\Exception\AuthenticationException $e) {
                        //     // echo $e->getError()->message;
                        // } catch (\Stripe\Exception\ApiConnectionException $e) {
                        //     // echo $e->getError()->message;
                        // } catch (\Stripe\Exception\ApiErrorException $e) {
                        //     // echo $e->getError()->message;
                        // } catch (\Stripe\Exception\InvalidArgumentException $e) {
                        //     echo 'Error Subscription - Campaign ID: '.$val->id.",";
                        //     // echo $e->getError()->message;
                        // }
                        // catch (Exception $e) {
                        //     echo $e->getError()->message;
                        // }
                    } else {                        
                        // Cancel Subscription
                        $this->cancel_subscription($bill->ch_id);
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
        }
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
        // End of Check out
        // Change Status of Temp Campaign
        $temp_camps = UserCampaign::where('temp_end_date', $today)
            ->where('free_plan', 3)
            ->get();
        foreach($temp_camps as $key => $campaign){
            $user = DB::table('tbl_user')
                ->leftjoin('tbl_business', 'tbl_user.id', 'tbl_business.primary_id')
                ->where('tbl_user.id', $campaign->user_id)
                ->select('tbl_user.*', 'tbl_business.bill_name', 'tbl_business.sales')
                ->first();
            $invoice = Invoices::where('campaign_id', $campaign->id)->first();
            if($invoice->invoice_date <= $today){
                UserCampaign::where('id', $campaign->id)
                    ->update([
                        'free_plan' => 0
                    ]);
                // PDF
                ob_start();
                $options = new Options;
                $options->set('isRemoteEnabled', TRUE);
                $options->set('enable_javascript', TRUE);
                $dompdf = new Dompdf($options);
                $data = array();
                $invoice_pdf = Invoices::where('tbl_invoice.id', $invoice->id)
                    ->leftjoin('tbl_user_campaign', 'tbl_user_campaign.id', 'tbl_invoice.campaign_id')
                    ->select('tbl_invoice.*', 'tbl_user_campaign.free_plan')
                    ->first();
                $file_name = "";
                if(isset($invoice_pdf->id)){
                    $data['invoice'] = $invoice_pdf;
                    $avaiable = UserCampaign::where('id', $invoice_pdf->campaign_id)->first();
                    if(isset($avaiable->id)){
                        $data['checkout'] = CheckoutModel::where('campaign_id', $campaign->id)->get();
                        $data['campaign'] = $avaiable;
                        $view = view('admin.invoice.invoice-view', $data);
                        $dompdf->loadHtml($view);
                        $dompdf->setPaper('A4', 'landscape');
                        $dompdf->render();
                        $stream = TRUE;
                        $dompdf->stream();
                        $file_name = time().".pdf";
                        define('UPLOAD_DIR', 'public/pdf/');
                        $file = UPLOAD_DIR . $file_name;
                        if ($stream) {
                            $pdf_string = $dompdf->output();
                            file_put_contents($file, $pdf_string ); 
                        }
                    }
                }
                // End of PDF
                Mail::to($user->email)->send(new TempInvoiceEmail($user, $campaign, $invoice, 0, $file_name));
                // Account Manager
                if($user->sales != ""){
                    $account_manager = DB::table('tbl_user')
                        ->where('id', $user->sales)
                        ->first();
                    if(isset($account_manager->id)){
                        Mail::to($account_manager->email)->send(new TempInvoiceEmail($user, $campaign, $invoice, 0, $file_name));     
                    }
                }   
            }
        }
        // Update Credit Card Invoice Status and Generate sub invoice for send invoice
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
            
            if(($val->pay_method == 1 && $datediff == 10) || ($val->pay_method == 0 && $val->paid != 0 && !in_array($val->campaign_id, $decline_list)) && $valid == true){
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
                    Invoices::where('id', $val->id)
                        ->update([
                            'invoice_date' => $due_date,
                            'paid' => $paid,
                            'status' => $status,
                        ]);
                    $amount = $intval * $campaign->part_amount;
                    $campaign_id = $campaign->id;
                    if($val->pay_method != 1){
                        $checkout = CheckoutModel::where('campaign_id', $campaign->id)->first();
                        CheckoutModel::where('campaign_id', $campaign->id)
                            ->update([
                                'amount' => floatval($amount) + floatval($checkout->amount),
                            ]);
                    }
                    // Generate sub invoice
                    // $controller = app()->make('App\Http\Controllers\InvoiceController');
                    // app()->call([$controller, 'generate_sub_invoice'], [
                    //     'invoice_id' => $val->id,
                    //     'user_id' => $campaign->user_id
                    // ]);
                    // PDF
                    $options = new Options;
                    $options->set('isRemoteEnabled', TRUE);
                    $options->set('enable_javascript', TRUE);
                    $dompdf = new Dompdf($options);
                    $data = array();
                    $invoice_pdf = Invoices::where('tbl_invoice.id', $val->id)
                        ->leftjoin('tbl_user_campaign', 'tbl_user_campaign.id', 'tbl_invoice.campaign_id')
                        ->select('tbl_invoice.*', 'tbl_user_campaign.free_plan')
                        ->first();
                    $file_name = "";
                    if(isset($invoice_pdf->id)){
                        $data['invoice'] = $invoice_pdf;
                        $avaiable = UserCampaign::where('id', $invoice_pdf->campaign_id)->first();
                        if(isset($avaiable->id)){
                            $data['checkout'] = CheckoutModel::where('campaign_id', $campaign->id)->get();
                            $data['campaign'] = $avaiable;
                            $view = view('admin.invoice.invoice-view', $data);
                            $dompdf->loadHtml($view);
                            $dompdf->setPaper('A4', 'landscape');
                            $dompdf->render();
                            $stream = TRUE;
                            $dompdf->stream();
                            $file_name = time().".pdf";
                            define('UPLOAD_DIR', 'public/pdf/');
                            $file = UPLOAD_DIR . $file_name;
                            if ($stream) {
                                $pdf_string = $dompdf->output();
                                file_put_contents($file, $pdf_string ); 
                            }
                        }
                    }
                    $user = DB::table('tbl_user')
                        ->leftjoin('tbl_business', 'tbl_user.id', 'tbl_business.primary_id')
                        ->where('tbl_user.id', $campaign->user_id)
                        ->select('tbl_user.*', 'tbl_business.bill_name', 'tbl_business.sales')
                        ->first();
                    // End of PDF
                    // Mail::to('jing@inex.net')->send(new RecurMail($user, $campaign, $file_name));
                    // if($user->notification == 0){
                    //     Mail::to($user->email)->send(new RecurMail($user, $campaign, $file_name));
                    // }
                    // // Account Manager
                    // if($user->sales != ""){
                    //     $account_manager = DB::table('tbl_user')
                    //         ->where('id', $user->sales)
                    //         ->first();
                    //     if(isset($account_manager->id) && $account_manager->notification == 0){
                    //         Mail::to($account_manager->email)->send(new RecurMail($user, $campaign, $file_name));     
                    //     }
                    // }  
                }
            }
        }
        echo "Daily Command";
        // End of campaign
        $campaigns = UserCampaign::Leftjoin('tbl_user', "tbl_user.id", "tbl_user_campaign.user_id")
            ->Leftjoin('tbl_business', "tbl_user_campaign.user_id", "tbl_business.primary_id")
            ->select('tbl_business.*', "tbl_user.business_name", "tbl_user.user_name", "tbl_user_campaign.end_date", "tbl_user_campaign.id as camp_id", 
                "tbl_user_campaign.free_plan", "tbl_user_campaign.start_date as camp_start")
            ->get();
        foreach($campaigns as $key => $val){
            $end_date = strtotime($val->end_date);
            $datediff = $end_date - $now;
            $datediff = round($datediff / (60 * 60 * 24));
            // Calc Date Different from Campaign Start for Contract
            $camp_start = strtotime($val->camp_start);
            $datediff_contract = $camp_start - $now;
            $datediff_contract  = round($datediff_contract / (60 * 60 * 24));

            $datediff_end = $now - $end_date;
            $datediff_end = round($datediff_end / (60 * 60 * 24));

            $invoice = Invoices::where('campaign_id', $val->camp_id)->first();
            $paid = false;
            if(isset($invoice->id)){
                $inv_time = strtotime($invoice->invoice_date);
                if($inv_time >= $now){
                    $paid = true;
                }
            }

            $account_manager = DB::table('tbl_user')
                ->where('id', $val->sales)
                ->first();
            // Send Invoice to Clients about Contract
            // if($val->free_plan == 2 && ($datediff_contract % 7 ==0 && $datediff_contract > 60)){
            if($val->free_plan == 2 && $datediff == 10){
                // PDF
                $campaign = $val;
                $options = new Options;
                $options->set('isRemoteEnabled', TRUE);
                $options->set('enable_javascript', TRUE);
                $dompdf = new Dompdf($options);
                $data = array();
                $invoice_pdf = Invoices::where('tbl_invoice.campaign_id', $val->id)
                    ->leftjoin('tbl_user_campaign', 'tbl_user_campaign.id', 'tbl_invoice.campaign_id')
                    ->select('tbl_invoice.*', 'tbl_user_campaign.free_plan')
                    ->first();
                $file_name = "";
                if(isset($invoice_pdf->id)){
                    $data['invoice'] = $invoice_pdf;
                    $avaiable = UserCampaign::where('id', $invoice_pdf->campaign_id)->first();
                    if(isset($avaiable->id)){
                        $data['checkout'] = CheckoutModel::where('campaign_id', $campaign->id)->get();
                        $data['campaign'] = $avaiable;
                        isset($data['invoice']['invoice_date']) ? $data['invoice']['invoice_date'] = date("Y-m-d") : '';
                        $view = view('admin.invoice.invoice-view', $data);
                        $dompdf->loadHtml($view);
                        $dompdf->setPaper('A4', 'landscape');
                        $dompdf->render();
                        $stream = TRUE;
                        $dompdf->stream();
                        $file_name = time().".pdf";
                        define('UPLOAD_DIR', 'public/pdf/');
                        $file = UPLOAD_DIR . $file_name;
                        if ($stream) {
                            $pdf_string = $dompdf->output();
                            file_put_contents($file, $pdf_string ); 
                        }
                    }
                }
                // End of PDF
                Mail::to($val->email)->send(new ContractInvoice($val, 0, $file_name)); // User
            }
            if($val->sales != null && $datediff == 3 && $paid == true){
                if(isset($account_manager->id)){
                    Mail::to($val->email)->send(new CampaignEnding($account_manager,$val, 0)); // User
                    Mail::to($account_manager->email)->send(new CampaignEnding($account_manager,$val, 1)); // Account Manager
                }
                echo "Ending Campaign";
            }
            if($val->sales != null && $datediff == -28){
                $account_manager = DB::table('tbl_user')
                    ->where('id', $val->sales)
                    ->first();
                if(isset($account_manager->id)){
                    Mail::to($account_manager->email)->send(new CampaignReminder($account_manager,$val)); // Account Manager
                }
                echo "Ending Campaign";
            }
            // Google Reivew
            if($datediff_end == 1){
                Mail::to($val->email)->send(new GoogleReview($val)); // User
            }
        }
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
