<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\StripeHook;
use App\CheckoutModel;
use App\UserCampaign;
use App\Invoices;
use App\SubInvoices;

class WebhookController extends Controller
{
    // Webhook
    public function webhook(Request $request){
        $stripe = new \Stripe\StripeClient(
            config('app.st_sec')
        );

        $endpoint_secret = 'whsec_3f28126be371aa7508a60227a8a4acd394c3c14e88df0fa3460af0d1367f79b5';

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
            $hook = new StripeHook;
            $hook->response = json_encode($event);
            $hook->save();
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
        exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }

        // Handle the event
        switch ($event->type) {
            case 'payment_intent.succeeded':
                $response = $event->data->object;
                $hook = new StripeHook;
                $hook->response = json_encode($response);
                $hook->save();
            // ... handle other event types
            case 'invoice.payment_succeeded':
                $response = $event->data->object;
                $hook = new StripeHook;
                $hook->response = json_encode($response);
                $hook->save();
            default:
                echo 'Received unknown event type ' . $event->type;
        }

    }
    
    // Webhook trigger Event
    public function webhook_response(Request $request) {
        $stripe = new \Stripe\StripeClient(
            config('app.st_sec')
        );
        // Test
        // $endpoint_secret = 'whsec_P8aOGLo2jMoHPOn6VgLM3w4jdulxQGJs';
        // Live
        $endpoint_secret = 'whsec_q5cpPABubceWOZnYmWxWfUNb9WTWGMxZ';

        $payload = @file_get_contents('php://input');
        // $payload = $request;
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }

        $response = $event->data->object;
        // Handle the event
        switch ($event->type) {
            case 'charge.succeeded':
                $this->save_events($response);
                return response()->json([
                                        'intentId' => $response->id,
                                        'message' => 'Charge Payment succeded'
                                    ], 200); 
    
            case 'invoice.payment_succeeded':
                $sub_id = $response->subscription;
                $checkout = CheckoutModel::where('ch_id', $sub_id)->first();
                // Save Webhook
                $this->save_events($response);
                if(isset($checkout->id)) {
                    $invoice_id = $checkout->invoice_id;
                    $campaign_id = $checkout->campaign_id;
                    $user_id = $checkout->user_id;
                    $invoice = Invoices::where('id', $invoice_id)->first();
                    // Campaign
                    $campaign = UserCampaign::where('id', $campaign_id)->first();
                    if(!isset($invoice->id) || !isset($campaign->id)) {
                        return response()->json([
                            'intentId' => $response->id,
                            'message' => 'Invalid '. !isset($invoice->id) ? 'Invoice' : 'Campaign' .' ID ' . $event->type
                        ], 400); 
                        return;
                    }

                    if($response->amount_paid == 0) {
                        return response()->json([
                            'intentId' => $response->id,
                            'message' => 'Amount: '.$response->amount_paid
                        ], 400); 
                        return;
                    }

                    $intval = 1;
                    if($invoice->sch == 2){
                        $intval = 4;
                    }
                    if($invoice->sch == 3){
                        $intval = 12;
                    }
                    if($invoice->sch == 0){
                        $intval = $campaign->weeks;
                    }
                    $paid = intval($invoice->paid) + $intval;
                    $status = 0;
                    if($paid >= $campaign->weeks){
                        $status = 0;
                        $paid = $campaign->weeks;
                        $intval = $intval - ($campaign->weeks - $paid);
                    }
                    if($invoice->pay_method != 0){
                        $due_date = date('Y-m-d',strtotime($intval." week"));
                    }
                    else{
                        $due_date = date('Y-m-d',strtotime($intval." week", strtotime($invoice->invoice_date)));
                    }
                    Invoices::where('id', $invoice_id)
                        ->update([
                            'invoice_date' => $due_date,
                            'paid' => $paid,
                            'status' => $status,
                        ]);
                    $amount = $intval * $campaign->part_amount;
                    if($invoice->pay_method != 1){
                        // $checkout = CheckoutModel::where('campaign_id', $campaign->id)->first();
                        CheckoutModel::where('campaign_id', $campaign->id)
                            ->update([
                                'amount' => floatval($amount) + floatval($checkout->amount),
                            ]);
                    }
                    // Generate Sub Invoice
                    $controller = app()->make('App\Http\Controllers\InvoiceController');
                    $data = app()->call([$controller, 'generate_sub_invoice'], [
                        'invoice_id' => $invoice_id,
                        'user_id' => $user_id
                    ]);
                    if( $data['success'] == true) {
                        $sub_inv_id = $data['id'];
                        $status_transitions = $response->status_transitions;
                        $paid_at = $status_transitions->paid_at;
                        SubInvoices::where('id', $sub_inv_id)
                            ->update([
                                'paid_at' => $paid_at
                            ]);
                    } 

                    return response()->json([
                        'intentId' => $response->id,
                        'message' => 'Invoice Payment succeded'
                    ], 200); 
                }
                return response()->json([
                    'intentId' => $response->id,
                    'message' => 'Invalid Campaign or Invoice ID'
                ], 400); 
            // ... handle other event types
            case 'invoice.payment_failed':                
                $this->save_events($response);
            default:
                echo 'Received unknown event type ' . $event->type;
        }
    }

    public function save_events($response) {
        // Save Webhook
        $hook = new StripeHook;
        $hook->response = json_encode($response);
        $hook->save();
    }

    public function view_webhook(Request $request) {
        if(!Session::has('user_id')){
            return "Your session has been expired. Please refresh your browser and try again.";
        }
        if(session('level') != 2){
            return "You don't have permission to delete the invoice";
        }
        $page_name = 'View Webhook';
        $hooks = StripeHook::get();
        $data = [];
        $data['webooks'] = $hooks;
        $data['page_name'] = $page_name;
        return view('admin.webhook.view', $data);
    }
}
