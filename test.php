<?php
public function checkout(Request $request) {
	$exist_check = CheckoutModel::where('user_id', $user_id)->orderby('id', 'desc')->first();
	$invoice = Invoices::where('id', $request['inv_id'])
            ->where('client_id', $user_id)
            ->first();
    $campaign = UserCampaign::where('id', $invoice->campaign_id)->first();
	$customer_id = '';

  	if (isset($exist_check->id)) {
    	$customer_id = $exist_check->customer_id;
		$stripe = new \Stripe\StripeClient(
			config('app.st_sec')
		);
		$cus = $stripe->customers->retrieve(
			$customer_id,
			[]
		);

		if(!isset($cus->id)) {
			try {
				$customer = $stripe->customers->create([
					'name' => $request['user_name'],
					'email' =>  session('email'),
					'description' => 'Customer - '.$user_id,
				]);
				$customer_id = $customer->id;
			} catch (Exception $e) {
				\Illuminate\Support\Facades\Log::error("stripe unknown exception: line#1008: " . $e->getError()->message);
				return $e->getError()->message;
			}
		} 
	} 
	else {
		try {
			$customer = $stripe->customers->create([
				'name' => $request['user_name'],
				'email' =>  session('email'),
				'description' => 'Customer - '.$user_id,
			]);
			$customer_id = $customer->id;
		} catch (Exception $e) {
			\Illuminate\Support\Facades\Log::error("stripe unknown exception: line#1046: " . $e->getError()->message);
			return $e->getError()->message;
		}
	}

	try {
		$cus = $stripe->customers->createSource(
			$customer_id,
			['source' => $request['token']]
		);
	} catch (Exception $e) {
		\Illuminate\Support\Facades\Log::error("stripe unknown exception: line#1077: " . $e->getError()->message);
		return $e->getError()->message;
	}

	$int = 1;

	// create products in stripe
	try {
		$product = $stripe->products->create([
			'name' => "User Campaign (INEX) - Invoice ID : ".$invoice->id,
		]);

	} catch (Exception $e) {
		\Illuminate\Support\Facades\Log::error("stripe unknown exception: line#1198: " . $e->getError()->message);
		return $e->getError()->message;
	}

	try {
		$price = $stripe->prices->create([
			'unit_amount' => $amount * 100,
			'currency' => 'usd',
			'recurring' => [
				'interval' => 'week',
				'interval_count' => $int,
			],
			'product' => $product->id,
		]);
	} catch (Exception $e) {
		\Illuminate\Support\Facades\Log::error("stripe unknown exception: line#1234: " . $e->getError()->message);
		return $e->getError()->message;
	}

	$invoice_date = strtotime($now);

	$cancel_date = strtotime($campaign->end_date);
	$current = date('Y-m-d');
	$current = strtotime($current);
	try {
		if ($invoice_date <= $current){
			$subscription = $stripe->subscriptions->create([
				'customer' => $cus->customer,
				'items' => [
					['price' => $price->id],
				],
				'cancel_at' => $cancel_date,
			]);
		}
		else {
			$subscription = $stripe->subscriptions->create([
				'customer' => $cus->customer,
				'items' => [
					['price' => $price->id],
				],
				'cancel_at' => $cancel_date,
				'trial_end' => $invoice_date
			]);
		}

		$checkout = new CheckoutModel;
		$checkout->user_id = $user_id;
		$checkout->campaign_id = $invoice->campaign_id;
		$checkout->customer_id = $customer_id;
		$checkout->amount = $amount;
		$checkout->invoice_id = $request['inv_id'];
		$checkout->ch_id = $subscription->id;
		$checkout->extra = $invoice->sch;
		$checkout->save();

		$this->update_remain_camp($invoice->id, $int);

		\Illuminate\Support\Facades\Log::info("Seding email after subscription success: " . $user->email);

		return "success";
	} catch (Exception $e) {
		\Illuminate\Support\Facades\Log::error("stripe unknown exception: line#1354: " . $e->getError()->message);
		return $e->getError()->message;
	}
}



$int = 4;
if($invoice->sch == 1){
	$int = 1;
}
if($invoice->sch == 2){
	$int = 4;
}
if($invoice->sch == 3){
	$int = 12;
}

// create products in stripe
try {
	$product = $stripe->products->create([
		'name' => "User Campaign (INEX) - Invoice ID : ".$invoice->id,
	]);

	\Illuminate\Support\Facades\Log::info("stripe log (products create) - line#1207: " . $invoice->id . " - " . $product->id);

}
catch(\Stripe\Exception\CardException $e) {
	\Illuminate\Support\Facades\Log::error("stripe card exception: line#1179: " . $e->getError()->message);
	return $e->getError()->message;
}
catch (\Stripe\Exception\RateLimitException $e) {
	\Illuminate\Support\Facades\Log::error("stripe RateLimitException: line#1183: " . $e->getError()->message);
	return $e->getError()->message;
} catch (\Stripe\Exception\InvalidRequestException $e) {
	\Illuminate\Support\Facades\Log::error("stripe InvalidRequestException: line#1186: " . $e->getError()->message);
	return $e->getError()->message;
} catch (\Stripe\Exception\AuthenticationException $e) {
	\Illuminate\Support\Facades\Log::error("stripe AuthenticationException: line#1189: " . $e->getError()->message);
	return $e->getError()->message;
} catch (\Stripe\Exception\ApiConnectionException $e) {
	\Illuminate\Support\Facades\Log::error("stripe ApiConnectionException: line#1192: " . $e->getError()->message);
	return $e->getError()->message;
} catch (\Stripe\Exception\ApiErrorException $e) {
	\Illuminate\Support\Facades\Log::error("stripe ApiErrorException: line#1195: " . $e->getError()->message);
	return $e->getError()->message;
} catch (Exception $e) {
	\Illuminate\Support\Facades\Log::error("stripe unknown exception: line#1198: " . $e->getError()->message);
	return $e->getError()->message;
}

try {
	$price = $stripe->prices->create([
		'unit_amount' => $amount * 100,
		'currency' => 'usd',
		'recurring' => [
			'interval' => 'week',
			'interval_count' => $int,
		],
		'product' => $product->id,
	]);

	\Illuminate\Support\Facades\Log::info("stripe log (price create) - line#1248: " . $product->id);
}
catch(\Stripe\Exception\CardException $e) {
	\Illuminate\Support\Facades\Log::error("stripe card exception: line#1215: " . $e->getError()->message);
	return $e->getError()->message;
}
catch (\Stripe\Exception\RateLimitException $e) {
	\Illuminate\Support\Facades\Log::error("stripe RateLimitException: line#1219: " . $e->getError()->message);
	return $e->getError()->message;
} catch (\Stripe\Exception\InvalidRequestException $e) {
	\Illuminate\Support\Facades\Log::error("stripe InvalidRequestException: line#1222: " . $e->getError()->message);
	return $e->getError()->message;
} catch (\Stripe\Exception\AuthenticationException $e) {
	\Illuminate\Support\Facades\Log::error("stripe AuthenticationException: line#1225: " . $e->getError()->message);
	return $e->getError()->message;
} catch (\Stripe\Exception\ApiConnectionException $e) {
	\Illuminate\Support\Facades\Log::error("stripe ApiConnectionException: line#1228: " . $e->getError()->message);
	return $e->getError()->message;
} catch (\Stripe\Exception\ApiErrorException $e) {
	\Illuminate\Support\Facades\Log::error("stripe ApiErrorException: line#1231: " . $e->getError()->message);
	return $e->getError()->message;
} catch (Exception $e) {
	\Illuminate\Support\Facades\Log::error("stripe unknown exception: line#1234: " . $e->getError()->message);
	return $e->getError()->message;
}

$now = date($campaign->start_date);
$invoice_date = strtotime($now);

$cancel_date = strtotime($campaign->end_date);
$current = date('Y-m-d');
$current = strtotime($current);
try {
	if ($invoice_date <= $current){
		$subscription = $stripe->subscriptions->create([
			'customer' => $cus->customer,
			'items' => [
				['price' => $price->id],
			],
			'cancel_at' => $cancel_date,
		]);

		\Illuminate\Support\Facades\Log::info("stripe log (subscription created) - line#1295: " . $subscription->id . " - " . $price->id . " - " . $current . " - " . $cancel_date);
	}
	else {
		$subscription = $stripe->subscriptions->create([
			'customer' => $cus->customer,
			'items' => [
				['price' => $price->id],
			],
			// 'cancel_at_period_end' => true,
			'cancel_at' => $cancel_date,
			'trial_end' => $invoice_date
		]);

		\Illuminate\Support\Facades\Log::info("stripe log (subscription created - trial_end) - line#1295: " . $subscription->id . " - " . $price->id . " - " . $current . " - " . $cancel_date);
	}

	$checkout = new CheckoutModel;
	$checkout->user_id = $user_id;
	$checkout->campaign_id = $invoice->campaign_id;
	$checkout->customer_id = $customer_id;
	$checkout->amount = $amount;
	$checkout->invoice_id = $request['inv_id'];
	$checkout->ch_id = $subscription->id;
	$checkout->extra = $invoice->sch;
	$checkout->save();

	\Illuminate\Support\Facades\Log::info("inserting into checkout table after subscription success: " . $user_id . " - " . $invoice->campaign_id . " - " . $amount);

	$this->update_remain_camp($invoice->id, $int);

	// Send Mail
	$locations = DB::table('tbl_locations')->get();
	$user = DB::table('tbl_user')->where('id', $user_id)->first();
	Mail::to($user->email)->send(new UserCampaignMail($user, $campaign, 1, $locations));

	\Illuminate\Support\Facades\Log::info("Seding email after subscription success: " . $user->email);

	return "success";
}
catch(\Stripe\Exception\CardException $e) {
	\Illuminate\Support\Facades\Log::error("stripe card exception: line#1335: " . $e->getError()->message);
	return $e->getError()->message;
}
catch (\Stripe\Exception\RateLimitException $e) {
	\Illuminate\Support\Facades\Log::error("stripe RateLimitException: line#1339: " . $e->getError()->message);
	return $e->getError()->message;
} catch (\Stripe\Exception\InvalidRequestException $e) {
	\Illuminate\Support\Facades\Log::error("stripe InvalidRequestException: line#1342: " . $e->getError()->message);
	return $e->getError()->message;
} catch (\Stripe\Exception\AuthenticationException $e) {
	\Illuminate\Support\Facades\Log::error("stripe AuthenticationException: line#1345: " . $e->getError()->message);
	return $e->getError()->message;
} catch (\Stripe\Exception\ApiConnectionException $e) {
	\Illuminate\Support\Facades\Log::error("stripe ApiConnectionException: line#1348: " . $e->getError()->message);
	return $e->getError()->message;
} catch (\Stripe\Exception\ApiErrorException $e) {
	\Illuminate\Support\Facades\Log::error("stripe ApiErrorException: line#1351: " . $e->getError()->message);
	return $e->getError()->message;
} catch (Exception $e) {
	\Illuminate\Support\Facades\Log::error("stripe unknown exception: line#1354: " . $e->getError()->message);
	return $e->getError()->message;
}