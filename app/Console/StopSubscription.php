<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\PaymentMethod;
use App\Invoices;
use App\CheckoutModel;
use App\UserCampaign;
use App\Business;

class StopSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stop:sub';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stop / Cancel Subscription Manually';

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
        $stripe = new \Stripe\StripeClient(
            config('app.st_sec')
        );
        $campaigns = UserCampaign::leftjoin('tbl_checkout', 'tbl_checkout.campaign_id', 'tbl_user_campaign.id')
            ->where('tbl_user_campaign.end_date', '<=', $today)
            ->where('tbl_checkout.ch_id', "!=", '')
            ->select('tbl_user_campaign.*', "tbl_checkout.ch_id")
            ->get();
        foreach($campaigns as $key => $val){
            try{
                $subscription = $stripe->subscriptionSchedules->retrieve(
                    $val->ch_id,
                    []
                );
                if(isset($subscription['id'])){
                    try {
                        if(isset($subscription['released_subscription'])){
                            $stripe->subscriptions->cancel(
                                $subscription['released_subscription'],
                                []
                            );
                            echo "Stoped Campaign in INEX";
                            echo "Campaign Name : " .$val->campaign_name;
                            echo "End Date : ". $val->end_date;
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
                    try {
                        $cancel = $stripe->subscriptionSchedules->cancel(
                            $subscription['id'],
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
                        echo 'Error Subscription - Campaign ID: '.$val->id.",";
                        // echo $e->getError()->message;
                    }
                    catch (Exception $e) {
                        echo $e->getError()->message;
                    }
                } else {
                    $this->cancel_subscription($val->ch_id);
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
        // echo "Stop Sub";
        return;
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
