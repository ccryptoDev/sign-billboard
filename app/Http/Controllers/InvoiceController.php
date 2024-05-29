<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use App\Invoices;
use App\UserCampaign;
use App\CheckoutModel;
use App\PaymentMethod;
use App\Coupon;
use App\Business;
use App\Revenue;
use App\SubInvoices;
use App\Banks;
use App\TranferHistory;
use App\Admin;
use App\FreeLocations;
use App\StripeHook;

use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;
use App\Mail\RecurMail;
use App\Mail\TempInvoiceEmail;
use App\Mail\EmailCoupon;
use App\Mail\PaymentLinkManual;
use App\Mail\CheckoutManual;
use App\Mail\UserCampaignMail;

use Dompdf\Dompdf;
use Dompdf\Options;

class InvoiceController extends Controller
{
    public function manage_invoice(Request $request){
        if(!Session::has('user_id') || session('level') != 2){
            return redirect('login');
        }
        $data = array();
        $data['page_name'] = "Invoice Management";
        $users = DB::table('tbl_user')->get();
        $data['users'] = $users;
        $data['invoices'] = Invoices::leftjoin('tbl_business', 'tbl_business.primary_id', 'tbl_invoice.client_id')
            ->leftjoin('tbl_user_campaign', 'tbl_user_campaign.id', 'tbl_invoice.campaign_id')
            ->leftjoin('tbl_sub_invoices', 'tbl_sub_invoices.invoice_id', 'tbl_invoice.id')
            ->select('tbl_invoice.*', 'tbl_business.bill_name', 'tbl_business.bill_phone', 'tbl_business.bill_email', 'tbl_business.company_name',
                'tbl_user_campaign.id as ca_id', 'tbl_sub_invoices.invoice_date as inv_date', 'tbl_sub_invoices.id as sub_inv_id',
                'tbl_sub_invoices.paid_at',
                'tbl_sub_invoices.created_at as pay_date', 'tbl_sub_invoices.status as sub_status')
            ->where("tbl_user_campaign.id", "!=", null)
            ->orWhere("tbl_invoice.campaign_id", 0)
            ->get();
        $data['checkout'] = CheckoutModel::get();
        $data['campaigns'] = UserCampaign::get();
        return view('admin/invoice/manage', $data);
    }
    public function list_invoice(Request $request){
        if(!Session::has('user_id')){
            return redirect('login');
        }
        $user_level = session('level');
        $user_id = session('user_id');
        $campaign_id = $request['id'];
        $data = array();
        $data['page_name'] = "Invoice Management";
        $users = DB::table('tbl_user')->get();
        $data['users'] = $users;
        if($user_level < 2){
            $data['invoices'] = Invoices::leftjoin('tbl_business', 'tbl_business.primary_id', 'tbl_invoice.client_id')
                ->leftjoin('tbl_user_campaign', 'tbl_user_campaign.id', 'tbl_invoice.campaign_id')
                ->leftjoin('tbl_sub_invoices', 'tbl_sub_invoices.invoice_id', 'tbl_invoice.id')
                ->select('tbl_invoice.*', 'tbl_business.bill_name', 'tbl_business.bill_phone', 'tbl_business.bill_email', 
                    'tbl_user_campaign.id as ca_id', 'tbl_sub_invoices.invoice_date as inv_date', 'tbl_sub_invoices.id as sub_inv_id', 
                    'tbl_sub_invoices.created_at as pay_date', 'tbl_sub_invoices.status as sub_status')
                ->where('tbl_invoice.client_id', $user_id)
                ->where("tbl_user_campaign.id", $campaign_id)
                ->get();
            $data['checkout'] = CheckoutModel::get();
            $data['campaigns'] = UserCampaign::get();
            return view('admin/invoice/invoice-list', $data);
        }
        else{
            $data['invoices'] = Invoices::leftjoin('tbl_business', 'tbl_business.primary_id', 'tbl_invoice.client_id')
                ->leftjoin('tbl_user_campaign', 'tbl_user_campaign.id', 'tbl_invoice.campaign_id')
                ->leftjoin('tbl_sub_invoices', 'tbl_sub_invoices.invoice_id', 'tbl_invoice.id')
                ->select('tbl_invoice.*', 'tbl_business.bill_name', 'tbl_business.bill_phone', 'tbl_business.bill_email', 
                    'tbl_user_campaign.id as ca_id', 'tbl_sub_invoices.invoice_date as inv_date', 'tbl_sub_invoices.id as sub_inv_id',
                    'tbl_sub_invoices.created_at as pay_date', 'tbl_sub_invoices.status as sub_status')
                ->where("tbl_user_campaign.id", $campaign_id)
                ->get();
            $data['checkout'] = CheckoutModel::get();
            $data['campaigns'] = UserCampaign::get();
            return view('admin/invoice/invoice-list', $data);
        }
    }
    public function create_invoice(Request $request){
        if(!Session::has('user_id') && Session('level') != 2){
            return redirect()->route('login');
        }
        $data = array();
        $data['page_name'] = "Create Invoice";
        // $user = DB::table('tbl_user')->get();
        // $data['users'] = $user;
        $user = \App::call("App\Http\Controllers\MainController@get_business_name_by_session");
        $data['users'] =  \App::call("App\Http\Controllers\MainController@get_business_name_by_session");
        $locations = DB::table('tbl_locations')
            ->get();
        if(count($user) > 0){
            $locations = DB::table("tbl_location_by_name")
                ->where('business_name' , $user[0]->business_name)
                ->leftJoin("tbl_locations","tbl_locations.id","tbl_location_by_name.location_id")
                ->select("tbl_locations.name","tbl_location_by_name.*")
                ->get();
        }
        $data['invoice'] = Invoices::latest()->first();

        $data['locations'] = $locations;
        return view('admin.invoice.create', $data);
    }
    public function create_manu_invoice(Request $request){
        if(!isset($request['user']) || $request['user'] == null){
            return "Please select business name";
        }
        if(!isset($request['date'])){
            return "Please add one more items";
        }
        $terms = $request['terms'] == 0?"Due upon receipt":"30 Days Net";
        $description = [
            "due" => $request['due_date'],
            "terms" => $terms,
            "sales" => $request['sales_rep'],
            "account_number" => $request['account_number'],
        ];
        $invoice_body = [];
        $total = 0;
        foreach ($request['date'] as $key => $value) {
            $temp['due'] = $request['date'][$key];
            $temp['quantity'] = $request['quantity'][$key];
            $temp['item'] = $request['item'][$key];
            $temp['price'] = $this->change_format($request['price'][$key]);
            $temp['sub_total'] = $request['quantity'][$key] * $temp['price'];
            $total += $temp['sub_total'];
            $invoice_body[] = $temp;
        }
        $tax = $this->change_format($request['tax']);
        $total = ($tax + 100) * $total / 100;
        $invoice = new Invoices;
        $invoice->user_id = session('user_id');
        $invoice->client_id = $request['user'];
        $invoice->invoice_date = $request['due_date'];
        $invoice->status = 0;
        $invoice->description = json_encode($description);
        $invoice->campaign_id = 0; // 0 : Manual Invoice
        $invoice->data = json_encode($invoice_body);
        $invoice->part_amount = $total;
        $invoice->extra = $tax;
        $invoice->save();
        
        $result = [];
        $result['success'] = true;
        return $result;
    }
    public function get_single_manu_invoice(Request $request){
        $inv_id = $request['id'];
        $invoice = Invoices::where('id', $inv_id)->first();
        if(!isset($invoice->id) || $invoice->campaign_id != 0){
            return "You don't have permission to get this invoice";
        }
        $user = DB::table('tbl_user')
            ->where('id', $invoice->client_id)
            ->first();
        if(!isset($user->id)){
            return "Invalid User";
        }
        $checkout = CheckoutModel::where('invoice_id', $inv_id)->first();
        $extra = json_decode($invoice->description, true);
        $temp['business_name'] = $user->business_name;
        $temp['invoice_id'] = $inv_id;
        $temp['amount_due'] = $invoice->part_amount;
        $temp['tax'] = $invoice->extra;
        $temp['extra'] = $extra;
        $temp['date_paid'] = isset($checkout->id)?$checkout->created_at:'';
        $data['amount_paid'] = isset($checkout->id)?$checkout->amount:0;
        $data['success'] = true;
        $data['data'] = $temp;
        return $data;
    }
    public function change_manu_inv(Request $request){
        $inv_id = $request['id'];
        $invoice = Invoices::where('id', $inv_id)->first();
        if(!isset($invoice->id)){
            return "Invalid Invoice";
        }
        if(!isset($request['business_check']) || $request['business_check'] == ""){
            return "Please input business check";
        }
        $checkout = CheckoutModel::where('invoice_id', $inv_id)->first();
        if(isset($checkout->id) && $request['amount_paid'] == ""){
            return "Please input valid amount paid";
        }
        $desc = json_decode($invoice->description, true);
        if(isset($desc['sales']) && isset($desc['account_number'])){
            $desc['sales'] = $request['business_check'];
            $desc['business_check'] = $request['business_check'];
        }
        Invoices::where('id', $inv_id)
            ->update([
                'description' => json_encode($desc)
            ]);
        if($invoice->status == 1 && isset($checkout->id)){
            $paid = date('Y-m-d', strtotime($request->date_paid));
            CheckoutModel::where('id', $checkout->id)
                ->update([
                    'amount' => number_format($request['amount_paid'], 2),
                    'updated_at' => $paid
                ]);
        }
        return "success";
    }
    public function change_inv_type(Request $request){
        if(!Session::has('user_id') && Session('level') != 2){
            return "You don't have permission.";
        }
        $inv_id = $request['inv_id'];
        Invoices::where('id', $inv_id)
            ->update([
                'ach' => $request['status']
            ]);
        return "success";
    }
    public function get_location(Request $request){
        if(!Session::has('user_id') && Session('level') != 2){
            return "You don't have permission.";
        }
        $user_id = $request['id'];
        $user = DB::table('tbl_user')
            ->where('id', $user_id)
            ->first();
        if(!isset($user->id)){
            return "Invalid User";
        }
        $business = Business::where('primary_id', $user_id)->first();
        if(!isset($business->id)){
            $business = Business::where('company_name', $user->business_name)->first();
        }
        $user_html = "";
        $account_manager = '';
        if(isset($business->id)){
            $user_html .= '<span>'.$business->company_name.'</span><br>';
            $user_html .= '<span>ATTN: '.$business->bill_name.'</span><br>';
            $user_html .= '<span>'.$business->address.'</span><br>';
            $user_html .= '<span>'.$business->city.', '.$business->state.', '.$business->zip.'</span><br>';
            if($business->sales != null){
                $sales = DB::table('tbl_user')
                    ->where('id', $business->sales)
                    ->first();
                $account_manager = $sales->user_name;
            }
        }
        else{
            $user_html .= $user->business_name;
        }
        $locations = DB::table("tbl_location_by_name")
            ->where('business_name' , $user->business_name)
            ->leftJoin("tbl_locations","tbl_locations.id","tbl_location_by_name.location_id")
            ->select("tbl_locations.name","tbl_location_by_name.*")
            ->get();
        $result = array();
        $result['success'] = true;
        // $result['user'] = $user;
        $result['user'] = $user_html;
        $result['locations'] = $locations;
        $result['account_manager'] = $account_manager;
        return $result;
        return $locations;
    }
    public function create_invoice_by_id(Request $request){
        if(!Session::has('user_id')){
            return redirect('login');
        }
        $data = array();
        $data['page_name'] = "Create Invoice";
        $data["check_multi"] = \App::call("App\Http\Controllers\MainController@check_multi");
        $user = DB::table('tbl_user')
            ->where('id', $request['id'])
            ->first();
        $data['user'] = $user;
        // Location by Business Name
        $location = "";
        $location_list = DB::table("tbl_location_by_name")
            ->where('business_name' , $user->business_name)
            ->leftJoin("tbl_locations","tbl_locations.id","tbl_location_by_name.location_id")
            ->select("tbl_locations.name","tbl_location_by_name.*")
            ->get();
        foreach($location_list as $temp_loca){
            $location .= $temp_loca->name.",";
        }
        $data['location'] = $location;
        // Invoice Number
        // $invoice = Invoices::get()->orderBy('id');
        // Get Ads
        $ads = DB::table('tbl_ad')
            ->where('business_name', $user->business_name)
            ->get();
        $data['ads'] = $ads;
        return view('admin.invoice.create', $data);
    }

    // Manage Payment Method in Admin Panel
    public function manage_payment(Request $request){
        if(!Session::has('user_id') || (session('level') < 2 && session('level') > 5)){
            return redirect()->route('login');
        }
        else{
            $data = array();
            $data['page_name'] = "Client Pay Options";
            $data['users'] =  \App::call("App\Http\Controllers\MainController@get_business_name_by_session");
            $data['method'] = PaymentMethod::get();
            return view('admin.payment.manage-view', $data);
        }
    }

    public function change_payment_method(Request $request){
        if(!Session::has('user_id') || session('level') < 2){
            return "You don't have permission to update this";
        }
        $exist = PaymentMethod::where('business_name', $request['business_name'])->first();
        if(isset($exist->id)){
            PaymentMethod::where('id', $exist->id)
                ->update([
                    'payment_method' => json_encode($request['method']),
                ]);
            return 'success';
        }
        $payment = new PaymentMethod;
        $payment->business_name = $request['business_name'];
        $payment->payment_method = json_encode($request['method']);
        $payment->save();
        return "success";   
    }
    public function change_payment_date(Request $request){
        if(!Session::has('user_id') || session('level') < 2){
            return "You don't have permission to update this";
        }
        $exist = PaymentMethod::where('business_name', $request['business_name'])->first();
        if(isset($exist->id)){
            PaymentMethod::where('id', $exist->id)
                ->update([
                    'start_date' => $request['start_date'],
                    'end_date' => $request['end_date'],
                    'payment_method' => json_encode($request['method']),
                ]);
            return "success";
        }
        $payment = new PaymentMethod;
        $payment->business_name = $request['business_name'];
        $payment->start_date = $request['start_date'];
        $payment->end_date = $request['end_date'];
        $payment->payment_method = json_encode($request['method']);
        $payment->save();
        return "success";
    }
    public function default_payment_method($business_name){
        PaymentMethod::where('business_name', $business_name)->delete();
        $payment = new PaymentMethod;
        $payment->business_name = $business_name;
        // $payment->payment_method = json_encode(["1", "2"]);
        $payment->payment_method = json_encode(["2"]);
        $payment->save();
        return "success";
    }
    // End of Manage Payment Method

    // View Invoince in client Side
    public function client_invoice_view(Request $request){
        if(!Session::has('user_id')){
            return redirect('login');
        }
        $campaign_id = $request['id'];
        $data = array();
        $data['page_name'] = "Invoice";
        $data["check_multi"] = \App::call("App\Http\Controllers\MainController@check_multi");
        if(session('level') < 2){
            $avaiable = UserCampaign::where('id', $campaign_id)
                ->where('user_id', session('user_id'))
                ->first();
        }
        else{
            $avaiable = UserCampaign::where('id', $campaign_id)
                ->first();   
        }
        if(!isset($avaiable->id)){
            return redirect()->back()->withErrors("Invalid Campaign");
        }
        $exist = Invoices::where('client_id', session('user_id'))
            ->where('campaign_id', $campaign_id)
            ->first();
        if(session('level') >= 2){
            $exist = Invoices::where('campaign_id', $campaign_id)->first();
        }
        if(!isset($exist->id)){
            $invoice = $this->generate_invoice_by_camp($campaign_id);
            if(!isset($invoice['invoice_id'])){
                return back()->withErrors("Invalid Invoice. Please contact us");
            }
            $data['invoice'] = Invoices::where('tbl_invoice.id', $invoice['invoice_id'])
                ->leftjoin('tbl_user_campaign', 'tbl_user_campaign.id', 'tbl_invoice.campaign_id')
                ->select('tbl_invoice.*', 'tbl_user_campaign.free_plan')
                ->first();
        }
        else{
            $data['invoice'] = Invoices::where('tbl_invoice.campaign_id', $campaign_id)
                ->leftjoin('tbl_user_campaign', 'tbl_user_campaign.id', 'tbl_invoice.campaign_id')
                ->select('tbl_invoice.*', 'tbl_user_campaign.free_plan')
                ->first();
        }
        if(session('level') < 2){
            $data['p_method'] = PaymentMethod::where('business_name', session('business_name'))->first();
        }
        // Business Information
        $data['business'] = Business::where('primary_id', $avaiable->user_id)->first();
        $data['checkout'] = CheckoutModel::where('campaign_id', $campaign_id)->get();
        $data['campaign'] = $avaiable;
        $data['user'] = DB::table('tbl_user')->where('id', session('user_id'))->first();
        return view('admin.invoice.client-invoice', $data);
    }
    // Pay From Link
    public function purchase(Request $request){
        if(!Session::has('user_id')){
            return redirect('login');
        }
        $campaign_id = base64_decode($request['id']);
        return $campaign_id;
    }
    public function generate_invoice_by_camp($id){
        // $date = date("Y-m-d");
        $campaign = UserCampaign::where('id', $id)->first();
        $date = $campaign->start_date;
        $user = DB::table('tbl_user')
            ->where('id', $campaign->user_id)
            ->first();
        $account_number = date("mdY").$user->id;
        if(isset($user->id) && $user->created_at!= null){
            $init_date = date_create($user->created_at);
            $account_number = date_format($init_date, "mdY").$user->id;
        }
        // Description
        $business = Business::where("primary_id", $campaign->user_id)->first();
        $account_manager = "";
        if(isset($business->id) && $business->sales != null){
            $sales = DB::table('tbl_user')
                ->where('id', $business->sales)->first();
            if(isset($sales->id)){
                $account_manager = $sales->user_name;
            }
        }
        $description = [
            "due" => $date,
            "terms" => "Due upon receipt",
            "sales" => $account_manager,
            "account_number" => $account_number
        ];
        // Invoice Body
        $invoice_body = [];
        $locations = explode(",",$campaign->locations);
        $slots = explode(",", $campaign->slots);
        $price = explode(",", $campaign->price);
        $sub_total = explode(",", $campaign->sub_total);
        $discount = 0;
        foreach($locations as $key => $val){ 
            $temp = [];
            $discount += $this->change_format($sub_total[$key]) * $campaign->weeks;
            $temp['location_id'] = $val;
            $location = DB::table('tbl_locations')->where('id', $val)->first();
            $temp['location_name'] = $location->name;
            $temp['due'] = $date;
            $temp['quantity'] = $slots[$key];
            $temp['price'] = $this->change_format($price[$key]);
            $temp['sub_total'] = $this->change_format($sub_total[$key]);
            $invoice_body[] = $temp;
        }
        // 
        $invoice = New Invoices;
        $invoice->user_id = session('user_id');
        $invoice->client_id = $campaign->user_id;
        $invoice->campaign_id = $campaign->id;
        $invoice->status = $campaign->status;
        $invoice->invoice_date = $date;
        $invoice->description = json_encode($description);
        $invoice->data = json_encode($invoice_body);
        $invoice->discount = $discount;
        $invoice->amount = $this->change_format($campaign->total);
        $invoice->sch = $campaign->sch;
        $invoice->pay_method = $campaign->pay_method;
        $invoice->part_amount = $this->change_format($campaign->part_amount);
        $invoice->save();
        $invoice_id = $invoice->id;
        $result['status'] = "success";
        $result['invoice_id'] = $invoice_id;
        return $result;
    }
    public function change_format($amount){
        $data = str_replace("$", "", $amount);
        $data = str_replace(" ", "", $data);
        $data = str_replace(",", "", $data);
        $data = str_replace("%", "", $data);
        return $data;
    }
    // View Invoice in admin side
    public function view_invoice(Request $request){
        if(!Session::has('user_id')){
            return redirect('login');
        }
        $data = array();
        $data['page_name'] = "Invoice";
        $data["check_multi"] = \App::call("App\Http\Controllers\MainController@check_multi");
        $invoice_id = $request['id'];
        $invoice = Invoices::where('tbl_invoice.id', $invoice_id)
            ->leftjoin('tbl_user_campaign', 'tbl_user_campaign.id', 'tbl_invoice.campaign_id')
            ->select('tbl_invoice.*', 'tbl_user_campaign.free_plan')
            ->first();
        if(!isset($invoice->id) && $invoice->campaign_id != 0){
            return redirect()->back()->withErrors("Invalid Invoice");
        }
        $campaign_id = $invoice->campaign_id;

        $data['invoice'] = $invoice;
        $avaiable = UserCampaign::where('id', $campaign_id)->first();
        if(!isset($avaiable->id) && $campaign_id != 0){
            return redirect()->back()->withErrors("Invalid Campaign");
        }
        $data['checkout'] = CheckoutModel::where('campaign_id', $request['id'])->get();
        $data['campaign'] = $avaiable;
        if($campaign_id == 0){
            $user = DB::table('tbl_user')
                ->where('id', $invoice->client_id)->first();
        }
        else{
            $user = DB::table('tbl_user')
                ->where('id', $avaiable->user_id)->first();
        }
        if(isset($user->id)){
            $business = Business::where('company_name', $user->business_name)->first();
            $data['business'] = $business;
        }
        else{
            $business = "";
            $data['business'] = $business;
        }
        // Sub Invoice
        $subId = $request['subId'];
        $sub_invoice = SubInvoices::where('id', $subId)->first();
        $data['subInvoice'] = $sub_invoice;
        $data['user'] = $user;
        if($campaign_id == 0){
            return view('admin.invoice.manual-invoice', $data);
        }
        return view('admin.invoice.client-invoice', $data);
    }

    public function pay_invoice_manual(Request $request){
        if(!Session::has('user_id')){
            return redirect('login');
        }
        $data = array();
        $data['page_name'] = "Invoice";
        $data["check_multi"] = \App::call("App\Http\Controllers\MainController@check_multi");
        $invoice_id = base64_decode($request['id'], true);
        $invoice = Invoices::where('tbl_invoice.id', $invoice_id)
            ->leftjoin('tbl_user_campaign', 'tbl_user_campaign.id', 'tbl_invoice.campaign_id')
            ->select('tbl_invoice.*', 'tbl_user_campaign.free_plan')
            ->first();
        if(!isset($invoice->id) && $invoice->campaign_id != 0){
            return redirect()->back()->withErrors("Invalid Invoice");
        }
        $campaign_id = $invoice->campaign_id;
        $data['invoice'] = $invoice;
        $avaiable = UserCampaign::where('id', $campaign_id)->first();
        if(!isset($avaiable->id) && $campaign_id != 0){
            return redirect()->back()->withErrors("Invalid Campaign");
        }
        $data['checkout'] = CheckoutModel::where('campaign_id', $request['id'])->get();
        $data['campaign'] = $avaiable;
        if($campaign_id == 0){
            $user = DB::table('tbl_user', $invoice->client_id)->first();
        }
        else{
            $user = DB::table('tbl_user', $avaiable->user_id)->first();
        }
        $business = "";
        if(isset($user->id)){
            $business = Business::where('company_name', $user->id)->first();
        }
        $data['business'] = $business;
        $data['user'] = $user;
        if($campaign_id == 0){
            return view('admin.invoice.manual-invoice', $data);
        }
        return redirect()->back()->withErrors("Invalid Invoice");
    }

    public function change_inv_status(Request $request){
        if(!Session::has('user_id')){
            return "Please login";
        }
        $status = $request['status'];
        $invoice = Invoices::where('id', $request['inv_id'])->first();
        $free_plan = 0;
        if($status == 3){
            $free_plan = 1;
        }
        if($status == 4){
            $free_plan = 2;
        }
        if($status == 5){
            $free_plan = 3;
        }
        $inv_status = 0;
        if($request['status'] == ''){
            $inv_status = 0;
        }
        else {
            $inv_status = $request['status'];
        }
        if($status == 3 || $status == 4){
            UserCampaign::where('id', $invoice->campaign_id)
                ->update([
                    'free_plan' => $free_plan
                ]);
            $inv_status = 1;
        }
        else if($status == 5){ // Temp Campaign
            $temp_end_date = date("Y-m-d", strtotime("+1 week"));
            UserCampaign::where('id', $invoice->campaign_id)
                ->update([
                    'free_plan' => $free_plan,
                    'temp_end_date' => $temp_end_date
                ]);
            $inv_status = 0;
        }
        else{
            UserCampaign::where('id', $invoice->campaign_id)
                ->update([
                    'free_plan' => 0
                ]);
        }
        // Update Status of sub invoice
        if(isset($request['sub_id']) && $request['sub_id'] != null){
            SubInvoices::where('id', $request['sub_id'])
                ->update([
                    'status' => $inv_status,
                ]);
            Invoices::where('id', $request['inv_id'])
                ->update([
                    'status' => $inv_status,
                    'user_id' => session('user_id')
                ]);
        }
        else{
            Invoices::where('id', $request['inv_id'])
                ->update([
                    'status' => $inv_status,
                    'user_id' => session('user_id')
                ]);
        }
        $campaign = UserCampaign::where('id', $invoice->campaign_id)->first();
        $locations = DB::table('tbl_locations')->get();
        if(isset($invoice->id)){
            // $user = DB::table('tbl_user')
            //     ->leftjoin('tbl_business', 'tbl_user.id', 'tbl_business.primary_id')
            //     ->where('tbl_user.id', $invoice->client_id)
            //     ->select('tbl_user.*', 'tbl_business.bill_name')
            //     ->first();
            // Mail::to('jing@inex.net')->send(new TempInvoiceEmail($user, $campaign, $invoice, $locations, $user, 1));
            return "success";
        }
        return "Invalid Invoice";
    }

    public function send_invoice(Request $request){
        $inv_id = $request['id'];
        $sub_id = $request['sub_id'];
        $invoice = Invoices::where('id', $inv_id)->first();
        $locations = DB::table('tbl_locations')->get();
        $subInvoice = SubInvoices::where('id', $sub_id)->first();
        if(isset($invoice->id)){
            $campaign = UserCampaign::where('id', $invoice->campaign_id)->first();
            if(isset($campaign->id)){
                $user = DB::table('tbl_user')
                    ->leftjoin('tbl_business', 'tbl_user.id', 'tbl_business.primary_id')
                    ->where('tbl_user.id', $invoice->client_id)
                    ->select('tbl_user.*', 'tbl_business.bill_name', 'tbl_business.sales')
                    ->first();
                if($campaign->free_plan == 3){ // Temp Campaign
                    // PDF
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
                            // $res = $dompdf->stream();
                            $file_name = time().".pdf";
                            if (!defined('UPLOAD_DIR')) define('UPLOAD_DIR', 'pdf/');
                            $file = UPLOAD_DIR . $file_name;
                            if ($stream) {
                                $pdf_string = $dompdf->output();
                                file_put_contents($file, $pdf_string ); 
                            }
                        }
                    }
                    // End of PDF
                    try{
                        $mailData = $request;
                        $mailData['mail'] = 'support@inex.net';
                        $mailData['user_email'] = $user->email;
                        $mailData['subject'] = 'Temporary Advertising Campaign Extension';

                        $contactContent = array('user' =>  $user, 'campaign' => $campaign, 'invoice' => $invoice);
                        $mailData['attach'] = $file_name;

                        Mail::send( ['html' => 'mail.TempInvoice'] ,$contactContent,
                        function($message) use ($mailData)
                        {
                            $message
                                ->from($mailData['mail'], "INEX Digital Billboard Advertising")
                                ->to($mailData['user_email'])
                                ->replyTo($mailData['mail'])
                                ->attach("pdf/".$mailData['attach'])
                                ->subject($mailData['subject']);
                        });
                    }
                    catch (\Exception $e) {
                        return $e->getMessage();
                    }
                    return "success";
                    // Mail::to('jing@inex.net')->send(new TempInvoiceEmail($user, $campaign, $invoice, 0, $file_name));
                    // Mail::to($user->email)->send(new TempInvoiceEmail($user, $campaign, $invoice, 0, $file_name));
                    // Account Manager
                    // if($user->sales != ""){
                    //     $account_manager = DB::table('tbl_user')
                    //         ->where('id', $user->sales)
                    //         ->first();
                    //     if(isset($account_manager->id)){
                    //         Mail::to($account_manager->email)->send(new TempInvoiceEmail($user, $campaign, $invoice, 0, $file_name));     
                    //     }
                    // }
                }
                else{
                    $file_name = "";
                    // Mail::to($user->email)->send(new RecurMail($user, $campaign, $file_name, $subInvoice));
                    Mail::to('jing@inex.net')->send(new RecurMail($user, $campaign, $file_name, $subInvoice));
                    // Mail::to($user->email)->send(new InvoiceMail($user, $campaign, $invoice, $locations, $user, 0));
                    // $admins = DB::table('tbl_user')->where('level', 2)->get();
                    // foreach($admins as $admin){
                    //     Mail::to($admin->email)->send(new InvoiceMail($user, $campaign, $invoice, $locations, $user, 1));
                    // }
                }
                return "success";
            }
            elseif($invoice->campaign_id == 0){
                if(isset($invoice->id)){
                    $user = DB::table('tbl_user')
                        ->leftjoin('tbl_business', 'tbl_user.id', 'tbl_business.primary_id')
                        ->where('tbl_user.id', $invoice->client_id)
                        ->select('tbl_user.*', 'tbl_business.bill_name', 'tbl_business.sales')
                        ->first();
                    $controller = app()->make('App\Http\Controllers\CampaignController');
                    $business = app()->call([$controller, 'get_business_information'], ['business_name' => $user->business_name]);
                    // PDF
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
                        $data['checkout'] = CheckoutModel::where('invoice_id', $invoice->id)->get();
                        $data['campaign'] = '';
                        $view = view('admin.invoice.invoice-view', $data);
                        $dompdf->loadHtml($view);
                        $dompdf->setPaper('A4', 'landscape');
                        $dompdf->render();
                        $stream = TRUE;
                        // $res = $dompdf->stream();
                        $file_name = time().".pdf";
                        if (!defined('UPLOAD_DIR')) define('UPLOAD_DIR', 'pdf/');
                        $file = UPLOAD_DIR . $file_name;
                        if ($stream) {
                            $pdf_string = $dompdf->output();
                            file_put_contents($file, $pdf_string ); 
                        }
                    }
                    // End of PDF
                    if(isset($user->id)){
                        try{
                            $mailData = $request;
                            $mailData['mail'] = 'support@inex.net';
                            // $mailData['user_email'] = 'jing@inex.net';
                            $mailData['user_email'] = $user->email;
                            $mailData['subject'] = 'Temporary Advertising Campaign Extension';
    
                            $contactContent = array('user' =>  $user, 'campaign' => '', 'invoice' => $invoice);
                            $mailData['attach'] = $file_name;
    
                            Mail::send( ['html' => 'mail.TempInvoice'] ,$contactContent,
                            function($message) use ($mailData)
                            {
                                $message
                                    ->from($mailData['mail'], "INEX Digital Billboard Advertising")
                                    ->to($mailData['user_email'])
                                    ->replyTo($mailData['mail'])
                                    ->attach("pdf/".$mailData['attach'])
                                    ->subject($mailData['subject']);
                            });
                        }
                        catch (\Exception $e) {
                            return $e->getMessage();
                        }
                        // Mail::to($user->email)->send(new PaymentLinkManual($user, $business, $invoice, $file_name));
                        return "success";
                    }
                }
            }
            return "Invalid Campaign";            
        }
        return "Invalid Invoice";
    }

    public function checkout_invoice(Request $request){
        if(!Session::has('user_id')){
            return "Your session has been expired. Please refresh your browser and try again.";
        }
        $stripe = new \Stripe\StripeClient(
            config('app.st_sec')
        );
        $user_id = session('user_id');
        $exist_check = CheckoutModel::where('user_id', $user_id)->orderby('id', 'desc')->first();
        $invoice = Invoices::where('id', $request['inv_id'])
            ->where('client_id', $user_id)
            ->first();
        $campaign = UserCampaign::where('id', $invoice->campaign_id)->first();
        if(isset($invoice->id) && $invoice->status == 1){
            return "You already paid this invoice";
        }
        if(!isset($campaign->id)){
            return "You campaign has been removed. Please contact to us.";
        }
        if(isset($exist_check->id)){
            $customer_id = $exist_check->customer_id;
        }
        else{
            $customer = $stripe->customers->create([
                'name' => $request['user_name'],
                'email' =>  session('email'),
                'description' => 'Customer - '.$user_id,
            ]);
            $customer_id = $customer->id;
        }
        // Payment Method
        $cus = $stripe->customers->createSource(
            $customer_id,
            ['source' => $request['token']]
        );
        $charge = $stripe->charges->create([
            'amount' => $request['amount'] * 100,
            'currency' => 'usd',
            'customer' => $cus->customer,
            'description' => 'INEX - Campaign'.$invoice->campaign_id,
            // 'capture' => false,
        ]);
        if($charge->status == "succeeded"){
            $checkout = new CheckoutModel;
            $checkout->user_id = $user_id;
            $checkout->campaign_id = $invoice->campaign_id;
            $checkout->customer_id = $customer_id;
            $checkout->amount = $request['amount'];
            $checkout->invoice_id = $request['inv_id'];
            $checkout->ch_id = $charge->id;
            $checkout->save();
            // Check remaining weeks
            $campaign = UserCampaign::where('id', $invoice->campaign_id)->first();
            if($invoice->sch == 0){
                Invoices::where('id', $invoice->id)
                    ->update([
                        'status' => 1
                    ]);
            }
            else if($invoice->sch == 1){
                $int = 1;
                $this->update_remain_camp($invoice->id, $int);
            }
            else if($invoice->sch == 2){
                $int = 4;
                $this->update_remain_camp($invoice->id, $int);
            }
            else{
                $int = 12;
                $this->update_remain_camp($invoice->id, $int);
            }
            return "success";
        }
    }

    public function checkout(Request $request){
        if(!Session::has('user_id')){
            return "Your session has been expired. Please refresh your browser and try again.";
        }
        $stripe = new \Stripe\StripeClient(
            config('app.st_sec')
        );

        // log for a test
        \Illuminate\Support\Facades\Log::info("The current st_key is " . config('app.st_sec'));

        $user_id = session('user_id');
        $exist_check = CheckoutModel::where('user_id', $user_id)->orderby('id', 'desc')->first();
        $invoice = Invoices::where('id', $request['inv_id'])
            ->where('client_id', $user_id)
            ->first();
        $campaign = UserCampaign::where('id', $invoice->campaign_id)->first();
        if(!isset($request['user_name']) || $request['user_name'] == ""){
            return "Please input User Name";
        }
        if(!isset($request['zip']) || $request['zip'] == ""){
            return "Please input Zip code";
        }
        if(isset($invoice->id) && $invoice->status == 1){
            return "You already paid this invoice";
        }
        if(!isset($campaign->id)){
            return "You campaign has been removed. Please contact to us.";
        }
        $check = DB::table('tbl_checkout')
            ->where('campaign_id', $campaign->id)
            ->first();
        if(isset($check->id) && $campaign->sch == 1){
            return "You already paid this campaign";
        }
        DB::table('tbl_user')
            ->where('id', $user_id)
            ->update([
                'zip' => $request['zip']
            ]);
        $amount = $this->format_amount($request['amount']);
        $created = date_create($campaign->start_date);
        $customer_id = '';
        
        // in case of customer has paid
        if (isset($exist_check->id)) {
            $customer_id = $exist_check->customer_id;
            $stripe = new \Stripe\StripeClient(
                config('app.st_sec')
            );
            $cus = $stripe->customers->retrieve(
                $customer_id,
                []
            );

            \Illuminate\Support\Facades\Log::info("stripe log - line#979");

            // if customer doesn't exist (new user in stripe)
            if(!isset($cus->id)) {
                try {
                    $customer = $stripe->customers->create([
                        'name' => $request['user_name'],
                        'email' =>  session('email'),
                        'description' => 'Customer - '.$user_id,
                    ]);
                    $customer_id = $customer->id;

                    \Illuminate\Support\Facades\Log::info("stripe log (create) - line#991: " . $user_id . " - " . $customer_id);

                }
                catch(\Stripe\Exception\CardException $e) {
                    \Illuminate\Support\Facades\Log::error("stripe card exception: line#985: " . $e->getError()->message);
                    return $e->getError()->message;
                }
                catch(\Stripe\Exception\CardException $e) {
                    \Illuminate\Support\Facades\Log::error("stripe card exception: line#989: " . $e->getError()->message);
                    return $e->getError()->message;
                }
                catch (\Stripe\Exception\RateLimitException $e) {
                    \Illuminate\Support\Facades\Log::error("stripe RateLimitException: line#993: " . $e->getError()->message);
                    return $e->getError()->message;
                } catch (\Stripe\Exception\InvalidRequestException $e) {
                    \Illuminate\Support\Facades\Log::error("stripe InvalidRequestException: line#996: " . $e->getError()->message);
                    return $e->getError()->message;
                } catch (\Stripe\Exception\AuthenticationException $e) {
                    \Illuminate\Support\Facades\Log::error("stripe AuthenticationException: line#999: " . $e->getError()->message);
                    return $e->getError()->message;
                } catch (\Stripe\Exception\ApiConnectionException $e) {
                    \Illuminate\Support\Facades\Log::error("stripe ApiConnectionException: line#1002: " . $e->getError()->message);
                    return $e->getError()->message;
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    \Illuminate\Support\Facades\Log::error("stripe ApiErrorException: line#1005: " . $e->getError()->message);
                    return $e->getError()->message;
                } catch (Exception $e) {
                    \Illuminate\Support\Facades\Log::error("stripe unknown exception: line#1008: " . $e->getError()->message);
                    return $e->getError()->message;
                }
            }
        } 
        else { // in case of customer has never paid
            // first, create customer in stripe
            try {
                $customer = $stripe->customers->create([
                    'name' => $request['user_name'],
                    'email' =>  session('email'),
                    'description' => 'Customer - '.$user_id,
                ]);
                $customer_id = $customer->id;

                \Illuminate\Support\Facades\Log::info("stripe log (create) - line#1033: " . $user_id . " - " . $customer_id);
            }
            catch(\Stripe\Exception\CardException $e) {
                \Illuminate\Support\Facades\Log::error("stripe card exception: line#1023: " . $e->getError()->message);
                return $e->getError()->message;
            }
            catch(\Stripe\Exception\CardException $e) {
                \Illuminate\Support\Facades\Log::error("stripe card exception: line#1027: " . $e->getError()->message);
                return $e->getError()->message;
            }
            catch (\Stripe\Exception\RateLimitException $e) {
                \Illuminate\Support\Facades\Log::error("stripe RateLimitException: line#1031: " . $e->getError()->message);
                return $e->getError()->message;
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                \Illuminate\Support\Facades\Log::error("stripe InvalidRequestException: line#1034: " . $e->getError()->message);
                return $e->getError()->message;
            } catch (\Stripe\Exception\AuthenticationException $e) {
                \Illuminate\Support\Facades\Log::error("stripe AuthenticationException: line#1037: " . $e->getError()->message);
                return $e->getError()->message;
            } catch (\Stripe\Exception\ApiConnectionException $e) {
                \Illuminate\Support\Facades\Log::error("stripe ApiConnectionException: line#1040: " . $e->getError()->message);
                return $e->getError()->message;
            } catch (\Stripe\Exception\ApiErrorException $e) {
                \Illuminate\Support\Facades\Log::error("stripe ApiErrorException: line#1043: " . $e->getError()->message);
                return $e->getError()->message;
            } catch (Exception $e) {
                \Illuminate\Support\Facades\Log::error("stripe unknown exception: line#1046: " . $e->getError()->message);
                return $e->getError()->message;
            }
        }

        // Payment Method
        try {
            $cus = $stripe->customers->createSource(
                $customer_id,
                ['source' => $request['token']]
            );

            \Illuminate\Support\Facades\Log::info("stripe log (createSource) - line#1071: " . $customer_id);

            // update after creating a card with token
            $stripe->customers->update(
                $customer_id,
                ['invoice_settings' => ['default_payment_method' => $cus->id]]
            );
        }
        catch(\Stripe\Exception\CardException $e) {
            \Illuminate\Support\Facades\Log::error("stripe card exception: line#1058: " . $e->getError()->message);
            return $e->getError()->message;
        }
        catch (\Stripe\Exception\RateLimitException $e) {
            \Illuminate\Support\Facades\Log::error("stripe RateLimitException: line#1062: " . $e->getError()->message);
            return $e->getError()->message;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            \Illuminate\Support\Facades\Log::error("stripe InvalidRequestException: line#1065: " . $e->getError()->message);
            return $e->getError()->message;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            \Illuminate\Support\Facades\Log::error("stripe AuthenticationException: line#1068: " . $e->getError()->message);
            return $e->getError()->message;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            \Illuminate\Support\Facades\Log::error("stripe ApiConnectionException: line#1071: " . $e->getError()->message);
            return $e->getError()->message;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            \Illuminate\Support\Facades\Log::error("stripe ApiErrorException: line#1074: " . $e->getError()->message);
            return $e->getError()->message;
        } catch (Exception $e) {
            \Illuminate\Support\Facades\Log::error("stripe unknown exception: line#1077: " . $e->getError()->message);
            return $e->getError()->message;
        }

        // if(isset($cus['id']) && $cus['cvc_check'] != 'pass'){
        //     return "Please input valid CVC Number";
        // }

        // sch == 0: credit card, 1: invoice
        if ($invoice->sch == 0 || ($invoice->sch == 1 && $invoice->sch == 0)) { // credit card
            try {
                $charge = $stripe->charges->create([
                    'amount' => $amount * 100,
                    'currency' => 'usd',
                    'customer' => $cus->customer,
                    'description' => 'INEX - Campaign' . $invoice->campaign_id,
                    // 'capture' => false,
                ]);

                \Illuminate\Support\Facades\Log::info("stripe log (create) - line#1112: " . $charge->status);

                if ($charge->status == "succeeded") {
                    $checkout = new CheckoutModel;
                    $checkout->user_id = $user_id;
                    $checkout->campaign_id = $invoice->campaign_id;
                    $checkout->customer_id = $customer_id;
                    $checkout->amount = $amount;
                    $checkout->invoice_id = $request['inv_id'];
                    $checkout->ch_id = $charge->id;
                    $checkout->save();

                    \Illuminate\Support\Facades\Log::info("New checkout is done - line#1124");

                    // Generate sub invoice
                    // $this->generate_sub_invoice($request['inv_id'], $user_id);
                    // Check remaining weeks
                    $campaign = UserCampaign::where('id', $invoice->campaign_id)->first();
                    Invoices::where('id', $invoice->id)
                        ->update([
                            'status' => 1
                        ]);

                    // Send Mail
                    $locations = DB::table('tbl_locations')->get();
                    $user = DB::table('tbl_user')->where('id', $user_id)->first();
                    Mail::to($user->email)->send(new UserCampaignMail($user, $campaign, 1, $locations));

                    \Illuminate\Support\Facades\Log::info("The customer paid for invoice - line#1140");
                    
                    // return result
                    $result = [];
                    $result['success'] = true;
                    $result['data'] = '<h2 class="text-center font-weight-bolder mb-5 text-success">Success</h2>
                        <div class="col-md-12 d-flex align-items-center justify-content-between flex-grow-1 mb-5">
                            <span>Credit Card Name: </span>
                            <span>'.$request['user_name'].'</span>
                        </div>
                        <div class="col-md-12 d-flex align-items-center justify-content-between flex-grow-1 mb-5">
                            <span>Amount Charged: </span>
                            <span>$ '.number_format($amount, 2).'</span>
                        </div>
                        <div class="col-md-12 d-flex align-items-center justify-content-between flex-grow-1 mb-5">
                            <span>Transaction ID: </span>
                            <span>'.$charge->id.'</span>
                        </div>
                        <div class="col-md-12 d-flex align-items-center justify-content-between flex-grow-1 mb-5">
                            <span>Date: </span>
                            <span>'.date_format($created, "m-d-Y").'</span>
                        </div>';
                    return $result;
                    return "success";
                }
            }
            catch(\Stripe\Exception\CardException $e) {
                \Illuminate\Support\Facades\Log::error("stripe card exception: line#1138: " . $e->getError()->message);
                return $e->getError()->message;
            }
            catch (\Stripe\Exception\RateLimitException $e) {
                \Illuminate\Support\Facades\Log::error("stripe RateLimitException: line#1142: " . $e->getError()->message);
                return $e->getError()->message;
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                \Illuminate\Support\Facades\Log::error("stripe InvalidRequestException: line#1145: " . $e->getError()->message);
                return $e->getError()->message;
            } catch (\Stripe\Exception\AuthenticationException $e) {
                \Illuminate\Support\Facades\Log::error("stripe AuthenticationException: line#1148: " . $e->getError()->message);
                return $e->getError()->message;
            } catch (\Stripe\Exception\ApiConnectionException $e) {
                \Illuminate\Support\Facades\Log::error("stripe ApiConnectionException: line#1151: " . $e->getError()->message);
                return $e->getError()->message;
            } catch (\Stripe\Exception\ApiErrorException $e) {
                \Illuminate\Support\Facades\Log::error("stripe ApiErrorException: line#1154: " . $e->getError()->message);
                return $e->getError()->message;
            } catch (Exception $e) {
                \Illuminate\Support\Facades\Log::error("stripe unknown exception: line#1158: " . $e->getError()->message);
                return $e->getError()->message;
            }
        }
        // Create Price - Only 1 for Every week and will be 2 for 4 Weeks
        else { // creates product, price and subscription
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
                // $amount = $request['amount'];
                // $amount = $amount / $int;
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
            // $now = date($invoice->invoice_date);
            // $invoice_date = strtotime($now);
            $now = date($campaign->start_date);
            $invoice_date = strtotime($now);
            // if($invoice->invoice_date == date("Y-m-d")){
            // if($campaign->start_date == date("Y-m-d")){
            //     $invoice_date = "now";
            // }
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
                // $subscription = $stripe->subscriptionSchedules->create([
                //     'customer' => $cus->customer,
                //     'start_date' => $invoice_date,
                //     'end_behavior' => 'release',
                //     'phases' => [
                //         [
                //         'items' => [
                //             [
                //                 'price' => $price->id,
                //                 'quantity' => 1,
                //             ],
                //         ],
                //         'iterations' => $campaign->weeks,
                //     ],
                //     ],
                // ]);

                if ($subscription->status === 'active') {

                    \Illuminate\Support\Facades\Log::info("stripe log - subscription success!!!");

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
                    // Generate sub invoice
                    // $this->generate_sub_invoice($request['inv_id'], $user_id);
                    // $sub = $stripe->subscriptionSchedules->release(
                    //     $subscription->id,
                    //     []
                    // );
                    $this->update_remain_camp($invoice->id, $int);

                    // Send Mail
                    $locations = DB::table('tbl_locations')->get();
                    $user = DB::table('tbl_user')->where('id', $user_id)->first();
                    Mail::to($user->email)->send(new UserCampaignMail($user, $campaign, 1, $locations));

                    \Illuminate\Support\Facades\Log::info("Seding email after subscription success: " . $user->email);

                    // return result
                    $result = [];
                    $result['success'] = true;
                    $result['data'] = '<h2 class="text-center font-weight-bolder mb-5 text-success">Success</h2>
                        <div class="col-md-12 d-flex align-items-center justify-content-between flex-grow-1 mb-5">
                            <span>Credit Card Name: </span>
                            <span>'.$request['user_name'].'</span>
                        </div>
                        <div class="col-md-12 d-flex align-items-center justify-content-between flex-grow-1 mb-5">
                            <span>Amount Charged: </span>
                            <span>$ '.number_format($amount, 2).'</span>
                        </div>
                        <div class="col-md-12 d-flex align-items-center justify-content-between flex-grow-1 mb-5">
                            <span>Transaction ID: </span>
                            <span>'.$subscription->id.'</span>
                        </div>
                        <div class="col-md-12 d-flex align-items-center justify-content-between flex-grow-1 mb-5">
                            <span>Date: </span>
                            <span>'.date_format($created, "m-d-Y").'</span>
                        </div>';
                    return $result;
                    return "success";
                }
                else {
                    \Illuminate\Support\Facades\Log::info("stripe log - subscription failed!!!");
                    return "Fail to charge from your account. Please check your balance of your card or contact us.";
                }
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
        }
        return "Invalid Card Information";
    }

    public function format_amount($data){
        $data = str_replace("(", "", $data);
        $data = str_replace(",", "", $data);
        $data = str_replace(")", "", $data);
        $data = str_replace("-", "", $data);
        $data = str_replace("$", "", $data);
        $data = str_replace("%", "", $data);
        $data = str_replace(" ", "", $data);
        return $data;
    }

    public function checkout_manual(Request $request){
        if(!Session::has('user_id')){
            return "Your session has been expired. Please refresh your browser and try again.";
        }
        $stripe = new \Stripe\StripeClient(
            config('app.st_sec')
        );
        $user_id = session('user_id');
        $user = DB::table('tbl_user')
            ->where('id', $user_id)
            ->first();
        if(!isset($user->id)){
            return "Invalid User";
        }
        $business = Business::where('company_name', $user->business_name)->first();
        $exist_check = CheckoutModel::where('user_id', $user_id)->orderby('id', 'desc')->first();
        $customer_id = "";
        $invoice = Invoices::where('id', $request['inv_id'])->first();
        $amount = $this->format_amount($request['amount']);
        if(isset($exist_check->id)){
            $customer_id = $exist_check->customer_id;
            $cus = $stripe->customers->retrieve(
                $customer_id,
                []
            );
            if(!isset($cus->id) || $cus->deleted == 1){
                try {
                    $customer = $stripe->customers->create([
                        'name' => $request['user_name'],
                        'email' =>  session('email'),
                        'description' => 'Customer - '.$user_id,
                    ]);
                    $customer_id = $customer->id;
                }
                catch(\Stripe\Exception\CardException $e) {
                    return $e->getError()->message;
                }
                catch (\Stripe\Exception\RateLimitException $e) {
                    return $e->getError()->message;
                } catch (\Stripe\Exception\InvalidRequestException $e) {
                    return $e->getError()->message;
                } catch (\Stripe\Exception\AuthenticationException $e) {
                    return $e->getError()->message;
                } catch (\Stripe\Exception\ApiConnectionException $e) {
                    return $e->getError()->message;
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    return $e->getError()->message;
                } catch (Exception $e) {
                    return $e->getError()->message;
                }
            }
        }
        else{
            $customer = $stripe->customers->create([
                'name' => $request['user_name'],
                'email' =>  session('email'),
                'description' => 'Customer - '.$user_id,
            ]);
            $customer_id = $customer->id;
        }
        // Payment Method
        $cus = $stripe->customers->createSource(
            $customer_id,
            ['source' => $request['token']]
        );
        $charge = $stripe->charges->create([
            'amount' => $amount * 100,
            'currency' => 'usd',
            'customer' => $cus->customer,
            'description' => 'INEX - Campaign'.$invoice->campaign_id,
            // 'capture' => false,
        ]);
        if($charge->status == "succeeded"){
            $checkout = new CheckoutModel;
            $checkout->user_id = $user_id;
            $checkout->campaign_id = 0;
            $checkout->customer_id = $customer_id;
            $checkout->invoice_id = $request['inv_id'];
            $checkout->ch_id = $charge->id;
            $checkout->amount = $amount;
            $checkout->save();
            // Generate sub invoice
            // $this->generate_sub_invoice($request['inv_id'], $user_id);
            // Update Invoice 
            Invoices::where('id', $request['inv_id'])
                ->update([
                    'status' => 1
                ]);
            Mail::to($user->email)->send(new CheckoutManual($user, $business));
            return "success";
        }
        return "fail";

    }

    public function generate_sub_invoice($invoice_id, $user_id){
        $invoice = Invoices::where('id',$invoice_id)->first();
        if(isset($invoice->id)){
            $new_sub = new SubInvoices;
            $new_sub->invoice_id = $invoice_id;
            $new_sub->user_id = $user_id;
            $new_sub->invoice_date = $invoice->invoice_date;
            $new_sub->save();
            $new_id = $new_sub->id;
            $result = [];
            $result['success'] = true;
            $result['id'] = $new_id;
            return $result;
            return "success";
        }
        return "fail";
    }

    public function checkout_demo(Request $request){
        Invoices::where('id', $request['inv_id'])
            ->update([
                'status' => 1
            ]);
        return "success";
    }

    public function update_remain_camp($invoice_id, $intval){
        $invoice = Invoices::where('id', $invoice_id)->first();
        $campaign = UserCampaign::where('id', $invoice->campaign_id)->first();
        $weeks = $campaign->weeks;
        $paid = $invoice->paid + $intval;
        if($paid >= $weeks){
            if($paid > $weeks){
                $weeks = $campaign->weeks;
            }
            Invoices::where('id', $invoice->id)
                ->update([
                    'paid' => $weeks,
                    'status' => 1
                ]);
        }
        else{
            $due_date = date('Y-m-d',strtotime($intval." week"));
            Invoices::where('id', $invoice->id)
                ->update([
                    'invoice_date' => $due_date,
                    'paid' => $paid,
                ]);
        }
        return "success";
    }

    public function no_charge(Request $request){
        if(!Session::has('user_id')){
            return "Your session has been expired. Please refresh your browser and try again.";
        }
        $invoice_id = $request['id'];
        $invoice = Invoices::where('id', $invoice_id)->first();
        if(isset($invoice->id)){
            if($invoice->status == 1){
                return "You already paid this invoice";
            }
            $campaign = UserCampaign::where('id', $invoice->campaign_id)->first();
            if(isset($campaign->id)){
                $user = DB::table("tbl_user", $campaign->user_id)->first();
                $payment_method = PaymentMethod::where('business_name', $user->business_name)->first();
                if(isset($payment_method->id)){
                    $method = explode(",",$payment_method->payment_method);
                    if(in_array(0, $method)){
                        Invoices::where('id', $invoice_id)
                            ->update([
                                'status' => 1
                            ]);
                        $checkout = new CheckoutModel;
                        $checkout->user_id = $user->id;
                        $checkout->campaign_id = $campaign->id;
                        $checkout->customer_id = 'free';
                        $checkout->amount = $campaign->total;
                        $checkout->ch_id = 'free';
                        $checkout->save();
                        return "success";
                    }
                    return "You don't have permission to pay free";
                }
                return "You don't have permission to pay free";
            }
            return "Invaid campaign";
            return $invoice;
        }
        return "Invaild URL";
    }

    public function payinvoice(Request $request){
        if(!Session::has('user_id')){
            return redirect('login');
        }
        $data = array();
        $data['page_name'] = "Invoice";
        $data["check_multi"] = \App::call("App\Http\Controllers\MainController@check_multi");

        $campaign_id = base64_decode($request['id']);
        $campaign = UserCampaign::where('id', $campaign_id)
            ->where('user_id', session('user_id'))
            ->first();
        if(!isset($campaign->id)){
            $data['error'] = "Invalid URL";
            return view('error', $data);
            return redirect()->back()->withErrors("Invalid URL");
        }
        $invoice = Invoices::where('campaign_id', $campaign_id)->first();
        if(!isset($invoice->id)){
            $data['error'] = "Invalid Invoice";
            return view('error', $data);
            return redirect()->back()->withErrors("Invalid Invoice");
        }
        $data['invoice'] = $invoice;
        $avaiable = UserCampaign::where('id', $invoice->campaign_id)->first();
        if(!isset($avaiable->id)){
            $data['error'] = "You don't have permission to access this page";
            return view('error', $data);
            return redirect()->back()->withErrors("Invalid Campaign");
        }
        // Business Information
        $user = DB::table('tbl_user', $avaiable->user_id)->first();
        $business = "";
        if(isset($user->id)){
            $business = Business::where('company_name', $user->id)->first();
        }

        $data['campaign'] = $avaiable;
        $data['checkout'] = CheckoutModel::where('campaign_id', $campaign_id)->get();
        // return view('admin.invoice.client-invoice', $data);
        $data['user'] = DB::table('tbl_user')->where('id', session('user_id'))->first();
        return view('admin.invoice.payinvoice', $data);
    }
    public function payinvoice_ach(Request $request){
        if(!Session::has('user_id')){
            return redirect('login');
        }
        $data = array();
        $data['page_name'] = "Invoice";
        $data["check_multi"] = \App::call("App\Http\Controllers\MainController@check_multi");

        $inv_id = base64_decode($request['id']);
        $invoice = Invoices::where('id', $inv_id)
            // ->where('client_id', session('user_id'))
            ->first();
        if(!isset($invoice->id)){
            $data['error'] = "Invalid Invoice";
            return view('error', $data);
            return redirect()->back()->withErrors("Invalid Invoice");
        }
        $data['invoice'] = $invoice;
        // Business Information
        $user = DB::table('tbl_user', $invoice->client_id)->first();
        $business = "";
        if(isset($user->id)){
            $business = Business::where('company_name', $user->id)->first();
        }

        $data['campaign'] = [];
        $data['checkout'] = CheckoutModel::where('invoice_id', $inv_id)->get();
        // return view('admin.invoice.client-invoice', $data);
        $data['user'] = DB::table('tbl_user')->where('id', session('user_id'))->first();
        return view('admin.invoice.payinvoice', $data);
    }
    // Delete Invoice
    public function delete_invoice(Request $request){
        if(!Session::has('user_id')){
            return "Your session has been expired. Please refresh your browser and try again.";
        }
        if(session('level') != 2){
            return "You don't have permission to delete the invoice";
        }
        $sub_flag = $request['sub_flag'];
        $inv_id = $request['id'];
        $invoice_id = 0;
        if($sub_flag == 1){
            $sub_invoice = SubInvoices::where('id', $inv_id)->first();
            $invoice_id = $sub_invoice->invoice_id;
            SubInvoices::where('id', $inv_id)->delete();
        }
        else{
            $invoice_id = $inv_id;
            Invoices::where('id', $inv_id)->delete();
        }
        // Cancel Subscription in Stripe
        $this->cancel_sub_stripe($invoice_id);
        return 'success';
    }
    // Cancel Subscription in Stripe
    public function cancel_sub_stripe($invoice_id){
        $checkout = CheckoutModel::where('invoice_id', $invoice_id)->get();
        $stripe = new \Stripe\StripeClient(
            config('app.st_sec')
        );
        foreach($checkout as $key => $val){
            try{
                $stripe->subscriptionSchedules->cancel(
                    $val->ch_id,
                    []
                );
            }
            catch(\Stripe\Exception\CardException $e) {}
            catch (\Stripe\Exception\RateLimitException $e) {} 
            catch (\Stripe\Exception\InvalidRequestException $e) {} 
            catch (\Stripe\Exception\AuthenticationException $e) {} 
            catch (\Stripe\Exception\ApiConnectionException $e) {} 
            catch (\Stripe\Exception\ApiErrorException $e) {} 
            catch (Exception $e) {}
        }
    }
    // Coupon
    public function manage_coupon(Request $request){
        if(Session::has('user_id') && session('level') >= 2){
            $data = [];
            $data['page_name'] = "Coupon Manager";
            $controller = app()->make('App\Http\Controllers\MainController');
            $data['business_name'] = app()->call([$controller, 'get_business_name_by_session'], []);
            $business_name = [];
            foreach($data['business_name'] as $key => $val){
                $business_name[] = $val->business_name;
            }
            $data['coupon'] = Coupon::whereIn('business_name', $business_name)->get();
            $data['campaigns'] = UserCampaign::get();
            return view('admin.payment.coupon', $data);
        }
        else{
            return redirect()->route('login');
        }
    }
    public function save_coupon(Request $request){
        if(!Session::has('user_id') || session('level') < 2){
            return "You don't have permission.";
        }
        if($request->amount <= 0 && $request->type != 0){
            return "Please input valid amount";
        }
        foreach($request['business_name'] as $key => $val){
            $coupon = new Coupon;
            $coupon->business_name = $val;
            $coupon->type = $request['type'];
            $coupon->amount = $request['amount'];
            $coupon->weeks = $request['weeks'];
            $coupon->start_date = $request['start_date'];
            $coupon->end_date = $request['end_date'];
            $coupon->save();
        }
        return "success";
    }
    public function update_coupon(Request $request){
        Coupon::where('id', $request['id'])
            ->update([
                'business_name' => $request['business_name'],
                'type' => $request['type'],
                'amount' => $request['amount'],
                'weeks' => $request['weeks'],
                'start_date' => $request['start_date'],
                'end_date' => $request['end_date'],
            ]);
        return 'success';
    }
    public function delete_coupon(Request $request){
        Coupon::where('id', $request['id'])->delete();
        return "success";
    }
    public function email_coupon(Request $request){
        $business_name = $request['business_name'];
        $users = DB::table('tbl_user')
            ->where('business_name', $business_name)
            ->get();
        $coupon = Coupon::where('business_name', $business_name)->first();
        if(isset($coupon->id)){
            foreach($users as $key => $val){
                $business = Business::where('primary_id', $val->id)->first();
                if(isset($business->id)){
                    $accounter = DB::table('tbl_user')
                        ->where('id', $business->sales)
                        ->first();
                    if(isset($accounter->id)){
                        Mail::to($val->email)->send(new EmailCoupon($val, $accounter, $coupon, 0));
                    }
                }
            }
            return "success";
        }
        return "Invalid Business Name";
    }
    public function refer_coupon(Request $request){
        $business_name = $request['business_name'];
        $users = DB::table('tbl_user')
            ->where('business_name', $business_name)
            ->get();
        $coupon = Coupon::where('business_name', $business_name)->first();
        if(isset($coupon->id)){
            foreach($users as $key => $val){
                $business = Business::where('primary_id', $val->id)->first();
                if(isset($business->id)){
                    $accounter = DB::table('tbl_user')
                        ->where('id', $business->sales)
                        ->first();
                    if(isset($accounter->id)){
                        Mail::to($val->email)->send(new EmailCoupon($val, $accounter, $coupon, 1));
                    }
                }
            }
            return "success";
        }
        return "Invalid Business Name";
    }
    // Revenue
    public function revenue_dist(Request $request){
        if(Session::has('user_id') && session('level') == 2){
            $data = [];
            $data['page_name'] = "Revenue Distribution Settings";
            $data['revenue'] = Revenue::first();
            return view('admin.payment.revenue_dist', $data);
        }
        else{
            return redirect()->back()->withErrors("You don't have permission to access this page");
        }
    }
    public function update_revenue(Request $request){
        $account = $this->change_format($request['account']);
        $franch = $this->change_format($request['franch']);
        $inex = $this->change_format($request['inex']);
        $exist = Revenue::first();
        if(isset($exist->id)){
            Revenue::where('id', $exist->id)
                ->update([
                'account' => $account,
                'franch' => $franch,
                'inex' => $inex,
            ]);
        }
        else{
            $revenue = new Revenue;
            $revenue->account = $account;
            $revenue->franch = $franch;
            $revenue->inex = $inex;
            $revenue->save();
        }
        return redirect()->back()->withSuccess("Success");
    }
    // View Income
    public function view_income(Request $request){
        if(!Session::has('user_id') || session('level') != 2){
            return redirect()->back()->withErrors("You don't have permission to access this page");
        }
        $data = [];
        $data['page_name'] = "Income";
        $data['business_name'] = \App::call("App\Http\Controllers\MainController@get_business_name_by_session");
        $list_business_name = [];
        foreach($data['business_name'] as $key => $val){
            $list_business_name[] = $val->business_name;
        }
        $invoices = Invoices::leftjoin('tbl_user', 'tbl_user.id', 'tbl_invoice.client_id')
            ->whereIn('tbl_user.business_name', $list_business_name)
            ->select("tbl_invoice.*",'tbl_user.business_name')
            ->get();
        $data['invoices'] = $invoices;
        return view('admin.payment.view-income', $data);
    }
    // End of Income
    // Transaction
    public function transaction(Request $request){
        if(!Session::has('user_id')){
            return redirect('login');
        }
        if(session('level') != 2){
            return redirect()->back()->withErrors("You don't have permission to access this page");
        }
        $data = [];
        $data['page_name'] = "Transaction";
        $checkout = CheckoutModel::get();
        $stripe = new \Stripe\StripeClient(
            config('app.st_sec')
        );
        $transaction = [];
        $transactions = $stripe->charges->all(['limit' => 100]);
        if(isset($transactions->data)){
            $transaction = $transactions;
        }
        $data['transactions'] = $transactions;
        return view('admin.transaction.transaction-view', $data);
    }

    public function records_view(Request $request){
        if(!Session::has('user_id')){
            return redirect()->back()->withErrors("You don't have permission to access this page");
        }
        if(session('level') < 2){
            return redirect()->back()->withErrors("You don't have permission to access this page");
        }
        $data = [];
        $data['page_name'] = 'System Transaction Records';
        if(session('level') == 2){
            // $invoices = Invoices::leftjoin('tbl_user', 'tbl_user.id', 'tbl_invoice.client_id')
            //     ->leftjoin('tbl_user_campaign', 'tbl_user_campaign.id', 'tbl_invoice.campaign_id')
            //     ->select('tbl_invoice.*', 'tbl_user.business_name', 'tbl_user_campaign.start_date', 'tbl_user_campaign.end_date', 'tbl_user_campaign.weeks', 'tbl_user_campaign.coupon_amount')
            //     ->where('tbl_user_campaign.id', "!=", null)
            //     ->orWhere('tbl_invoice.campaign_id', 0)
            //     ->get();
            $invoices = Invoices::
                // leftjoin('tbl_business', 'tbl_business.primary_id', 'tbl_invoice.client_id')
                leftjoin('tbl_user', 'tbl_user.id', 'tbl_invoice.client_id')
                ->leftjoin('tbl_user_campaign', 'tbl_user_campaign.id', 'tbl_invoice.campaign_id')
                ->leftjoin('tbl_sub_invoices', 'tbl_sub_invoices.invoice_id', 'tbl_invoice.id')
                ->select('tbl_invoice.*', 'tbl_user.business_name', 'tbl_user_campaign.start_date', 'tbl_user_campaign.end_date', 
                    'tbl_user.id as user_id',
                    'tbl_user_campaign.weeks', 'tbl_user_campaign.coupon_amount', 
                    'tbl_sub_invoices.id as sub_id', 'tbl_sub_invoices.transfer','tbl_sub_invoices.transfer_inex' ,'tbl_sub_invoices.transfer_fr',
                    'tbl_sub_invoices.created_at as sub_date')
                ->where("tbl_user_campaign.id", "!=", null)
                ->where('tbl_user_campaign.free_plan', 0)
                ->orWhere("tbl_invoice.campaign_id", 0)
                // ->groupBy('tbl_invoice.id')
                ->get();
            foreach($invoices as $key => $val){
                $business_name = $val->business_name;
                $business = Business::where('company_name', $business_name)
                    ->where('sales', "!=", null)
                    ->first();
                $user_id = $val->user_id;
                if(isset($business->id)){
                    $am_id = $business->sales;
                    $am = DB::table('tbl_user')
                        ->where('id', $am_id)
                        ->first();
                    if(isset($am->id)){
                        $invoices[$key]['am'] = $am->user_name;
                    }
                }
            }
            $data['invoices'] = $invoices;
            $data['revenue'] = Revenue::first();
            $data['checkout'] = CheckoutModel::get();
            return view('admin.transaction.records', $data);
        }
        else{
            // $invoices = Invoices::leftjoin('tbl_user', 'tbl_user.id', 'tbl_invoice.client_id')
            //     ->leftjoin('tbl_user_campaign', 'tbl_user_campaign.id', 'tbl_invoice.campaign_id')
            //     ->select('tbl_invoice.*', 'tbl_user.business_name', 'tbl_user_campaign.start_date', 'tbl_user_campaign.end_date', 'tbl_user_campaign.weeks', 'tbl_user_campaign.coupon_amount')
            //     ->where('tbl_user_campaign.id', "!=", null)
            //     ->orWhere('tbl_invoice.campaign_id', 0)
            //     ->get();
            $invoices = Invoices::leftjoin('tbl_user', 'tbl_user.id', 'tbl_invoice.client_id')
                ->leftjoin('tbl_user_campaign', 'tbl_user_campaign.id', 'tbl_invoice.campaign_id')
                ->leftjoin('tbl_sub_invoices', 'tbl_sub_invoices.invoice_id', 'tbl_invoice.id')
                ->select('tbl_invoice.*', 'tbl_user.business_name', 'tbl_user_campaign.start_date', 'tbl_user_campaign.end_date', 
                    'tbl_user_campaign.weeks', 'tbl_user_campaign.coupon_amount',
                    'tbl_sub_invoices.id as sub_id', 'tbl_sub_invoices.transfer', 
                    'tbl_sub_invoices.created_at as sub_date')
                ->where("tbl_user_campaign.id", "!=", null)
                ->where('tbl_user_campaign.free_plan', 0)
                ->orWhere("tbl_invoice.campaign_id", 0)
                ->groupBy('tbl_invoice.id')
                ->get();
            foreach($invoices as $key => $val){
                $business_name = $val->business_name;
                $business = Business::where('company_name', $business_name)
                    ->where('sales', "!=", null)
                    ->first();
                if(isset($business->id) && ($business->sales == session('user_id') || $business->super == session('user_id'))){
                    $am_id = $business->sales;
                    $am = DB::table('tbl_user')
                        ->where('id', $am_id)
                        ->first();
                    if(isset($am->id)){
                        $invoices[$key]['am'] = $am->user_name;
                    }
                }
                else{
                    unset($invoices[$key]);
                }
            }
            $data['invoices'] = $invoices;
            $data['revenue'] = Revenue::first();
            $data['checkout'] = CheckoutModel::get();
            return view('admin.transaction.records-am', $data);
        }
    }

    // Change Paid Flag Manually about Sub Invoices
    public function change_sub_status(Request $request){
        $id = $request['id'];
        $type = $request['type'];
        if($id === null){
            return "You can only change the status about sub invoices";
        }
        $sub = SubInvoices::where('id', $id)->first();
        if(!isset($sub->id)){
            return "Invalid Invoice";
        }
        if($type == 0){
            $status = $sub->transfer_inex;
            SubInvoices::where('id', $id)
                ->update([
                    'transfer_inex' => $status == 1 ? 0 : 1,
                ]);
        }
        else if($type == 1){
            $status = $sub->transfer_fr;
            SubInvoices::where('id', $id)
                ->update([
                    'transfer_fr' => $status == 1 ? 0 : 1,
                ]);
        }
        else{
            $status = $sub->transfer;
            SubInvoices::where('id', $id)
                ->update([
                    'transfer' => $status == 1 ? 0 : 1,
                ]);
        }
        return "success";
        return $request;
    }

    public function current_revenue(Request $request){
        if(!Session::has('user_id')){
            return redirect('login');
        }
        if(session('level') < 2){
            return redirect()->back()->withErrors("You don't have permission to access this page");
        }
        $data = [];
        $data['page_name'] = "Current Revenue";
        $user_id = session('user_id');
        if(isset($request['id'])){
            if(session('level') != 2){
                return redirect()->back()->withErrors("You don't have permission to access this page");
            }
            $user_id = $request['id'];
            $exist = Admin::where('id', $user_id)->first();
            if(!isset($exist->id)){
                return redirect()->back()->withErrors("Invalid User");
            }
        }
        // Get Available
        $ava = $this->get_available_funds($user_id);
        // $invoices = Invoices::leftjoin('tbl_user', 'tbl_user.id', 'tbl_invoice.client_id')
        //     ->leftjoin('tbl_user_campaign', 'tbl_user_campaign.id', 'tbl_invoice.campaign_id')
        //     ->select('tbl_invoice.*', 'tbl_user.business_name', 'tbl_user_campaign.start_date', 'tbl_user_campaign.end_date', 'tbl_user_campaign.weeks', 'tbl_user_campaign.coupon_amount')
        //     ->where('tbl_user_campaign.id', "!=", null)
        //     ->orWhere('tbl_invoice.campaign_id', 0)
        //     ->get();
        
        $data['invoices'] = isset($ava['invoices']) ? $ava['invoices'] : [];
        $data['total'] = isset($ava['total']) ? $ava['total'] : 0;
        $data['total_hold'] = isset($ava['total_hold']) ? $ava['total_hold'] : 0;
        $data['revenue'] = Revenue::first();
        $data['checkout'] = CheckoutModel::get();
        // Transfers
        $transfers = TranferHistory::where('user_id', $user_id)
            ->orderBy('id', 'desc')
            ->get();
        $data['transfers'] = $transfers;
        // Users for Admin
        $users = Admin::whereIn('level', [3, 4])
            ->orderBy('level')
            ->orderBy('user_name')
            ->get();
        $user = Admin::where('id', $user_id)->first();
        $data['user'] = $user;
        $data['users'] = $users;
        // Bank
        $bank = Banks::where('user_id', $user_id)->first();
        $stripe = new \Stripe\StripeClient(
            config('app.st_sec')
        );

        $account = '';
        try {
            if(isset($bank->id)){
                $account = $stripe->accounts->retrieve(
                    $bank->extra,
                    []
                );
            }

            // Retrieve customers
            $customers = $stripe->customers->all(['limit' => 10]);

            // foreach ($customers->data as $customer) {
            //     if ($customer->id == $account->id) {
            //         try {
            //             $subscriptions = $stripe->subscriptions->all([
            //                 'customer' => $customer->id,
            //                 'limit' => 1,
            //                 'order' => ['created' => 'desc']
            //             ]);

            //             if (!empty($subscriptions->data)) {
            //                 $latestSubscription = $subscriptions->data[0];

            //                 $invoices = $stripe->invoices->all([
            //                     'subscription' => $latestSubscription->id,
            //                     'limit' => 1,
            //                     'order' => ['created' => 'desc']
            //                 ]);

            //                 if (!empty($invoices->data)) {
            //                     $latestInvoice = $invoices->data[0];
            //                     $lastPaymentDate = date('Y-m-d H:i:s', $latestInvoice->created);
            //                     $amountPaid = $latestInvoice->amount_paid / 100;

            //                     echo "Customer ID: {$customer->id}\n";
            //                     echo "Last Payment Date: {$lastPaymentDate}\n";
            //                     echo "Amount Paid: \${$amountPaid}\n";
            //                 }
            //             }
            //         } catch (\Stripe\Exception\ApiErrorException $e) {
            //             echo 'Error retrieving subscriptions or invoices for customer ' . $customer->id . ': ' . $e->getMessage();
            //         }
            //     }
            // }
        }
        catch(\Stripe\Exception\CardException $e) {}
        catch (\Stripe\Exception\RateLimitException $e) {} 
        catch (\Stripe\Exception\InvalidRequestException $e) {} 
        catch (\Stripe\Exception\AuthenticationException $e) {} 
        catch (\Stripe\Exception\ApiConnectionException $e) {} 
        catch (\Stripe\Exception\ApiErrorException $e) {} 
        catch (Exception $e) {}

        $data['bank'] = $bank;
        $data['account'] = $account;
        return view('admin.transaction.current-revenue', $data);
    }

    public function get_available_funds($user_id) {
        $today = date("Y-m-d");
        $user = Admin::where('id', $user_id)->first();
        $user_level = isset($user->id)?$user->level:session('level');
        $user_name = $user->user_name;
        // Available Funds
        $invoices = Invoices::leftjoin('tbl_business', 'tbl_business.primary_id', 'tbl_invoice.client_id')
            ->leftjoin('tbl_user', 'tbl_user.id', 'tbl_invoice.client_id')
            ->leftjoin('tbl_user_campaign', 'tbl_user_campaign.id', 'tbl_invoice.campaign_id')
            ->leftjoin('tbl_sub_invoices', 'tbl_sub_invoices.invoice_id', 'tbl_invoice.id')
            ->select('tbl_invoice.*', 'tbl_user.business_name', 'tbl_user_campaign.start_date', 
                'tbl_user.id as user_id',
                // 'tbl_user_campaign.end_date', 
                'tbl_sub_invoices.invoice_date as end_date',
                'tbl_user_campaign.locations as camp_location', 'tbl_user_campaign.sub_total as camp_total',
                'tbl_user_campaign.weeks', 'tbl_user_campaign.coupon_amount', 'tbl_user_campaign.free_plan',
                'tbl_sub_invoices.id as sub_id', 'tbl_sub_invoices.transfer', 'tbl_sub_invoices.transfer_inex', 'tbl_sub_invoices.transfer_fr',
                'tbl_sub_invoices.created_at as sub_date')
            ->where("tbl_user_campaign.id", "!=", null)
            ->where('tbl_user_campaign.free_plan', 0)
            ->orWhere("tbl_invoice.campaign_id", 0)
            ->get();

        foreach($invoices as $key => $val) {
            // if($user_name == 'INEX Sales'){
            //     $user_inv = Admin::where('id', $val->user_id)->first();
            //     if(isset($user_inv->id)){
            //       $business_name = $user_inv->business_name;
            //     }
            // }
            // else{
                $business_name = $val->business_name;
            // }
            if($business_name != '' || $business_name != null) {
                $business = Business::where('company_name', $business_name)
                    ->where('sales', "!=", null)
                    ->first();
                // Check Assigned Locations about Franchise
                if($user_level == 3) {
                    $free_locations = FreeLocations::where('business_name', $user_name)->get();
                    $free_locations_name = [];
                    foreach($free_locations as $temp){
                        $location = DB::table('tbl_locations')
                            ->where('id', $temp['location_id'])
                            ->first();
                        $free_locations_name[] = $location->name;
                    }
                    $data = json_decode($val->data, true);
                    $locations = [];
                    $exist = false;
                    foreach($data as $temp){
                        if(isset($temp['location_name']) && in_array($temp['location_name'], $free_locations_name)){
                            $exist = true;
                        }
                    }
                //   if($user_name == 'INEX Sales'){
                //       if($exist == true){
                //           unset($invoices[$key]);
                //       }
                //   }
                //   else{
                    if($exist == false || !isset($business->id)){
                        unset($invoices[$key]);
                    }
                //   }
                }
                else {
                        if(($user_level != 2 && isset($business->id) && ($business->sales == $user_id || $business->super == $user_id)) 
                            || ($user_level == 2 && isset($business->id))
                        ){
                            $am_id = $business->sales;
                            $am = DB::table('tbl_user')
                                ->where('id', $am_id)
                                ->first();
                            if(isset($am->id)){
                                $invoices[$key]['am'] = $am->user_name;
                            }
                        }
                        else{
                            unset($invoices[$key]);
                        }
                }
            }
        }
        $total = 0;
        $total_hold = 0;
        $revenue = Revenue::first();
        $com_rate = 0;
        if($user_level == 2 && isset($revenue->inex)){
            $com_rate = $revenue->inex;
        }
        if($user_level == 3 && isset($revenue->franch)){
            $com_rate = $revenue->franch;
        }
        if($user_level == 4 && isset($revenue->account)){
            $com_rate = $revenue->account;
        }
        $checkout = CheckoutModel::get();
        $plan_nums = [0, 1, 4, 12];

        foreach($invoices as $key => $val) {
            if ($val->id == 446) {
                $test = 100;
            }
            $invoices[$key]['ava'] = 0;
            $start_date = date_create($val->start_date);
            $end_date = date_create($val->end_date);
            if($val->campaign_id == 0){
                $extra = json_decode($val->description, true);
                $start_date = date_create($extra['due']);
                $end_date = date_create($extra['due']);
            }
            $start_date = "";
            $end_date = "";
            $dis_end_date = "";
            foreach($checkout as $check){
                if($check->invoice_id == $val->id){
                    if($start_date == ""){
                        $start_date = $check->created_at;
                        $start_date = date_format($start_date, "m-d-Y");
                        $end_date = date_create($val->invoice_date);
                        $dis_end_date = date_format($end_date, "Y-m-d");
                        $end_date = date_format($end_date, "Y-m-d");
                    }
                }
            }
            if($val->sub_id){
                $start_date = date_create($val->sub_date);
                $start_date = date_format($start_date, "m-d-Y");
                if($val->sch != 0){
                    $diff_days = $plan_nums[$val->sch] * 7 - 1;
                    $dis_end_date = date('Y-m-d', strtotime('+'.$diff_days.' days', strtotime($val->sub_date)));
                    $end_date = date('Y-m-d', strtotime('+'.$diff_days.' days', strtotime($val->sub_date)));
                } else {
                  $diff_days = $val->weeks * 7 - 1;
                  $end_date = date('Y-m-d', strtotime('+'.$diff_days.' days', strtotime($val->sub_date)));  
                  $dis_end_date = $end_date;
                }
            }
            if( (($val->status == 0 && $val->paid != 0 ) || $val->status == 1) && $val->sub_id != null && $dis_end_date < $today ) {
                if($user_level == 2 && $val->transfer_inex == 0){
                  $total += $val->part_amount * $com_rate / 100;
                  $invoices[$key]['ava'] = 1;
                }
                if($user_level == 3 && $val->transfer_fr == 0){
                  // Get Amount By Location about Franchise
                  // $cam_locations = json_decode($val->camp_location);
                  // $camp_total = json_decode($val->camp_total);
                  // End of Franshise
                  $total += $val->part_amount * $com_rate / 100;
                  $invoices[$key]['ava'] = 1;
                }
                if($user_level == 4 && $val->transfer == 0){
                  $invoices[$key]['ava'] = 1;
                  $total += $val->part_amount * $com_rate / 100;
                }
            }

            // in case of subscription is cancened or there is an error in subscription
            if ( ($val->sub_id == null || !isset($val->sub_id)) && $val->status == 0 && $val->paid != 0 && $dis_end_date < $today ) {
                $total += $val->part_amount * $com_rate / 100;
                $invoices[$key]['ava'] = 1;
            }

            if($val->status == 0 && $end_date >= $today){
                $total_hold += $val->part_amount * $com_rate / 100;
            }
        }
        $result = [];
        $result['invoices'] = $invoices;
        $result['total'] = $total;
        $result['total_hold'] = $total_hold;
        return $result;
        return $total;
    }
    public function transfer_funds(Request $request){
        if(!Session::has('user_id') || session('level') <2){
            return "You don't have permission.";
        }
        $user_id = session('user_id');
        return $this->transfer_action($user_id);
    }
    public function transfer_users(Request $request){
        if(session('level') != 2){
            return "You don't have permission.";
        }
        $user_id = $request['user_id'];
        return $this->transfer_action($user_id);
    }
    public function transfer_action($user_id){
        $user = Admin::where('id', $user_id)->first();
        $user_level = $user->level;
        $bank = Banks::where('user_id', $user_id)->first();

        $stripe = new \Stripe\StripeClient(
            config('app.st_sec')
        );
        if(isset($bank->id) && $bank->extra != null){
            try{
                $account = $stripe->accounts->retrieve(
                    $bank->extra,
                    []
                );
                if(isset($account->id)){
                    if($account->payouts_enabled != true){
                        return "Your account is pending review";
                    }
                }
            }
            catch(\Stripe\Exception\CardException $e) {}
            catch (\Stripe\Exception\RateLimitException $e) {} 
            catch (\Stripe\Exception\InvalidRequestException $e) {} 
            catch (\Stripe\Exception\AuthenticationException $e) {} 
            catch (\Stripe\Exception\ApiConnectionException $e) {} 
            catch (\Stripe\Exception\ApiErrorException $e) {} 
            catch (Exception $e) {}
            try{
                $ava = $this->get_available_funds($user_id);
                if(!isset($ava['total']) || $ava['total'] == 0){
                    return "There are no funds to transfer.";
                }
                if(!isset($ava['invoices']) || count($ava['invoices']) == 0){
                    return "There are no invoices to transfer.";
                }
                $ids = [];
                foreach($ava['invoices'] as $key => $val){
                  if($val->ava == 1){
                    $ids[] = $val->sub_id;
                  }
                }
                $amount = $this->change_format($ava['total']);
                $amount = round($amount, 2);
                $response = $stripe->transfers->create([
                    'amount' => $amount * 100,
                    'currency' => 'usd',
                    'destination' => $bank->extra,
                ]);
                $url = '';
                if(isset($response->id)){
                    $tranfer = new TranferHistory;
                    $tranfer->user_id = $user_id;
                    $tranfer->amount = $amount;
                    $tranfer->transfer_id = $response->id;
                    $tranfer->response = $response;
                    $tranfer->save();
                    $tranfer_id = $tranfer->id;
                    if(isset($ava['invoices'])){
                      foreach($ids as $key => $val){
                            if($user_level == 2){
                                SubInvoices::where('id', $val)
                                    ->update([
                                        'transfer_inex' => 1,
                                        'transfer_inex_date' => now(),
                                        'transfer_inex_id' => $tranfer_id
                                    ]);
                            }
                            else if($user_level == 3){
                                SubInvoices::where('id', $val)
                                    ->update([
                                        'transfer_fr' => 1,
                                        'transfer_fr_date' => now(),
                                        'transfer_fr_id' => $tranfer_id
                                    ]);
                            }
                            else{
                                SubInvoices::where('id', $val)
                                    ->update([
                                        'transfer' => 1,
                                        'transfer_date' => now(),
                                        'transfer_id' => $tranfer_id
                                    ]);
                            }
                        }
                        // $invoices = $ava['invoices'];
                        // foreach($invoices as $key => $val){
                        //     if($user_level == 2){
                        //         SubInvoices::where('id', $val->sub_id)
                        //             ->update([
                        //                 'transfer_inex' => 1,
                        //                 'transfer_inex_date' => now(),
                        //                 'transfer_inex_id' => $tranfer_id
                        //             ]);
                        //     }
                        //     else if($user_level == 3){
                        //         SubInvoices::where('id', $val->sub_id)
                        //             ->update([
                        //                 'transfer_fr' => 1,
                        //                 'transfer_fr_date' => now(),
                        //                 'transfer_fr_id' => $tranfer_id
                        //             ]);
                        //     }
                        //     else{
                        //         SubInvoices::where('id', $val->sub_id)
                        //             ->update([
                        //                 'transfer' => 1,
                        //                 'transfer_date' => now(),
                        //                 'transfer_id' => $tranfer_id
                        //             ]);
                        //     }
                        // }
                    }
                    $url = '/view-transfer' . '/' . $tranfer_id;
                    if(session('level') == 2){
                      if(session('user_id') != $user_id) {
                        $url = '/view-transfer' . '/' . $tranfer_id .'/' . $user_id;
                      }
                    }
                    $result = [];
                    $result['success'] = true;
                    $result['url'] = $url;
                    return $result;
                    return "success";
                }
                else{
                    return "Fail to tranfer funds. Please contact us";
                }
            }
            catch(\Stripe\Exception\CardException $e) {
                return $e->getError()->message;
            }
            catch (\Stripe\Exception\RateLimitException $e) {
                return $e->getError()->message;
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                return $e->getError()->message;
            } catch (\Stripe\Exception\AuthenticationException $e) {
                return $e->getError()->message;
            } catch (\Stripe\Exception\ApiConnectionException $e) {
                return $e->getError()->message;
            } catch (\Stripe\Exception\ApiErrorException $e) {
                return $e->getError()->message;
            } catch (Exception $e) {
                return $e->getError()->message;
            }
        }
        else{
            return "Please add your bank account in Account Administration page";
        }
    }
    public function transfer_view(Request $request){
        if(!Session::has('user_id')){
            return redirect('login');
        }
        if(session('level') < 2){
            return redirect()->back()->withErrors("You don't have permission to access this page");
        }
        $data = [];
        $data['page_name'] = "Transfer History";
        $users = Admin::whereIn('level', [3, 4])
            ->orderBy('level')
            ->orderBy('user_name')
            ->get();
        $data['users'] = $users;
        $data['transfer'] = TranferHistory::where('user_id', session('user_id'))->get();
        if(isset($request['id'])){
            $data['transfer'] = TranferHistory::where('user_id', $request['id'])->get();
        }
        return view('admin.transaction.transfer_view', $data);
    }
    public function detail_transfer(Request $request){
        if(!Session::has('user_id')){
            return redirect('login');
        }
        if(session('level') < 2){
            return redirect()->back()->withErrors("You don't have permission to access this page");
        }
        $data = [];
        $data['page_name'] = "Transfer Detail";
        $id = $request['id'];
        $user_level = session('level');
        $user_id = session('id');
        $transfer = TranferHistory::where('id', $id)->first();
        if(!isset($transfer->id)){
            return redirect()->back()->withErrors("Invalid Transfer Id");
        }
        if($user_level == 2) {
            if(isset($request['subid']) && $request['subid'] != ''){
                $user_id = $request['subid'];
                $user = Admin::where('id', $user_id)->first();
                if(!isset($user->id)){
                    return redirect()->back()->withErrors("Invalid User Id");
                }
                $data['user'] = $user;
                $user_level = $user->level;
            } else {
                $transfers = SubInvoices::where('transfer_inex_id', $id)
                    ->where('transfer_inex', 1)
                    ->get();
            }
        }
        if($user_level == 3) {
            $transfers = SubInvoices::where('transfer_fr_id', $id)
                ->where('transfer_fr', 1)
                ->get();
        } 
        else{
            $transfers = SubInvoices::where('transfer_id', $id)
                ->where('transfer', 1)
                ->get();
        }
        $ids = [];
        foreach($transfers as $key => $val){
            $ids[] = $val->id;
        }
        $data['transfer'] = $transfer;
        $data['revenue'] = Revenue::first();
        // $data['invoices'] = Invoices::leftjoin('tbl_business', 'tbl_business.primary_id', 'tbl_invoice.client_id')
        //     ->leftjoin('tbl_user', 'tbl_user.id', 'tbl_invoice.client_id')
        //     ->leftjoin('tbl_user_campaign', 'tbl_user_campaign.id', 'tbl_invoice.campaign_id')
        //     ->leftjoin('tbl_sub_invoices', 'tbl_sub_invoices.invoice_id', 'tbl_invoice.id')
        //     ->select('tbl_invoice.*', 'tbl_user.business_name', 'tbl_user_campaign.start_date', 
        //         'tbl_user.id as user_id',
        //         // 'tbl_user_campaign.end_date', 
        //         'tbl_sub_invoices.invoice_date as end_date',
        //         'tbl_user_campaign.locations as camp_location', 'tbl_user_campaign.sub_total as camp_total',
        //         'tbl_user_campaign.weeks', 'tbl_user_campaign.coupon_amount', 'tbl_user_campaign.free_plan',
        //         'tbl_sub_invoices.id as sub_id', 'tbl_sub_invoices.transfer', 'tbl_sub_invoices.transfer_inex', 'tbl_sub_invoices.transfer_fr',
        //         'tbl_sub_invoices.created_at as sub_date')
        //     ->whereIn('tbl_invoice.id', $ids)
        //     // Array ( [0] => 340 [1] => 362 [2] => 351 [3] => 327 [4] => 248 [5] => 341 )
        //     // ->where('tbl_sub_invoices.user_id', $user_id)
        //     // ->where("tbl_user_campaign.id", "!=", null)
        //     // ->where('tbl_user_campaign.free_plan', 0)
        //     // ->orWhere("tbl_invoice.campaign_id", 0)
        //     ->get();
        // print_r($ids);
        $data['invoices'] = SubInvoices::leftjoin('tbl_invoice', 'tbl_invoice.id', 'tbl_sub_invoices.invoice_id')
          ->leftjoin('tbl_user', 'tbl_user.id', 'tbl_invoice.client_id')
          ->leftjoin('tbl_user_campaign', 'tbl_user_campaign.id', 'tbl_invoice.campaign_id')
          ->select('tbl_invoice.*', 'tbl_user.business_name', 'tbl_user_campaign.start_date', 
            'tbl_user.id as user_id',
            // 'tbl_user_campaign.end_date', 
            'tbl_sub_invoices.invoice_date as end_date',
            'tbl_user_campaign.locations as camp_location', 'tbl_user_campaign.sub_total as camp_total',
            'tbl_user_campaign.weeks', 'tbl_user_campaign.coupon_amount', 'tbl_user_campaign.free_plan',
            'tbl_sub_invoices.id as sub_id', 'tbl_sub_invoices.transfer', 'tbl_sub_invoices.transfer_inex', 'tbl_sub_invoices.transfer_fr',
            'tbl_sub_invoices.created_at as sub_date')
          ->whereIn('tbl_sub_invoices.id', $ids)
          ->get();
        $data['transfers'] = $transfers;
        $data['checkout'] = CheckoutModel::get();
        return view('admin.transaction.transfer_detail', $data);
    }
    // End of transfer
    public function sales_analysis(Request $request){
        if(!Session::has('user_id')){
            return redirect('login');
        }
        if(session('level') < 2){
            return redirect()->back()->withErrors("You don't have permission to access this page");
        }
        $data = [];
        $data['page_name'] = "Sales Analysis";
        $data['transfer'] = TranferHistory::where('user_id', session('user_id'))->get();

        $invoices = Invoices::leftjoin('tbl_user', 'tbl_user.id', 'tbl_invoice.client_id')
            ->leftjoin('tbl_user_campaign', 'tbl_user_campaign.id', 'tbl_invoice.campaign_id')
            ->select('tbl_invoice.*', 'tbl_user.business_name', 'tbl_user_campaign.start_date', 'tbl_user_campaign.end_date', 'tbl_user_campaign.weeks', 'tbl_user_campaign.coupon_amount')
            ->where('tbl_user_campaign.id', "!=", null)
            ->where('tbl_user_campaign.status', '!=', 1)
            ->orWhere('tbl_invoice.campaign_id', 0)
            ->get();
        foreach($invoices as $key => $val){
            $business_name = $val->business_name;
            $business = Business::where('company_name', $business_name)
                ->where('sales', "!=", null)
                ->first();
            // if(isset($business->id)){
            if(isset($business->id) && ($business->sales == session('user_id') || $business->super == session('user_id'))){
                $am_id = $business->sales;
                $am = DB::table('tbl_user')
                    ->where('id', $am_id)
                    ->first();
                if(isset($am->id)){
                    $invoices[$key]['am'] = $am->user_name;
                }
            }
            else{
                unset($invoices[$key]);
            }
        }
        // Campaigns
        $controller = app()->make('App\Http\Controllers\MainController');
        $business = app()->call([$controller, 'get_business_name_by_session'], []);
        $business_name = [];
        foreach($business as $key => $val){
            $business_name[] = $val->business_name;
        }
        $users = DB::table('tbl_user')
            ->whereIn('business_name', $business_name)
            ->orderBy('id','asc')
            ->get();
        $user_ids = [];
        foreach($users as $key => $val){
            $user_ids[] = $val->id;
        }
        // Total User and Campaigns
        $data['total_users'] = DB::table('tbl_user')->get();
        $data['total_camps'] = UserCampaign::where('status', "!=", 1)->get();
        // End of total
        $data['campaigns'] = UserCampaign::whereIn('user_id', $user_ids)->get();
        $data['users'] = $users;
        $data['invoices'] = $invoices;
        $data['revenue'] = Revenue::first();
        return view('admin.transaction.sales', $data);
    }
    // Connectd Accounts in Sripe
    public function connected_accounts(Request $request){
        if(!Session::has('user_id')){
            return redirect('login');
        }
        if(session('level') != 2){
            return redirect()->back()->withErrors("You don't have permission to access this page");
        }
        $data['page_name'] = 'Connected Accounts';
        $stripe = new \Stripe\StripeClient(
            config('app.st_sec')
        );
        $response = $stripe->accounts->all();
        $accounts = [];
        if(isset($response['data'])){
            $accounts = $response['data'];
            foreach($accounts as $key => $val){
                \Stripe\Stripe::setApiKey(config('app.st_sec'));
                $balance = \Stripe\Balance::retrieve(
                    ['stripe_account' => $accounts[$key]['id']]
                );
                $accounts[$key]['balance'] = $balance;
            }
        }
        $data['accounts'] = $accounts;
        return view('admin.transaction.connected-accounts', $data);
    }
    // Revenue Admin
    public function revenue_view(Request $request){
        if(!Session::has('user_id')){
            return redirect('login');
        }
        if(session('level') != 2){
            return redirect()->back()->withErrors("You don't have permission to access this page");
        }
        $data['page_name'] = 'Revenue By User';
        $users = DB::table('tbl_user')
            ->where('level', '>=', 2)
            ->where('level', '!=', 5)
            ->orderBy('level')
            ->get();
        foreach($users as $key => $val){
            $funds = $this->get_available_funds($val->id);
            $users[$key]->ava = isset($funds['total'])?$funds['total']:0;
            $users[$key]->hold = isset($funds['total_hold'])?$funds['total_hold']:0;
        }
        $data['revenue'] = Revenue::first();
        $data['users'] = $users;
        return view('admin.transaction.revenue-user', $data);
    }
    // Customer view of stripe
    public function customer_view(Request $request) {
        if(!Session::has('user_id')){
            return redirect()->back()->withErrors("You don't have permission to access this page");
        }
        if(session('level') != 2){
            return redirect()->back()->withErrors("You don't have permission to access this page");
        }
        $data = [];
        $data['page_name'] = 'Customers';
        $stripe = new \Stripe\StripeClient(
            config('app.st_sec')
        );
        $data['checkout'] = CheckoutModel::get();
        $data['customers'] = $stripe->customers->all(['limit' => 100]);
        if(session('level') == 2){
            // $invoices = Invoices::leftjoin('tbl_user', 'tbl_user.id', 'tbl_invoice.client_id')
            //     ->leftjoin('tbl_user_campaign', 'tbl_user_campaign.id', 'tbl_invoice.campaign_id')
            //     ->select('tbl_invoice.*', 'tbl_user.business_name', 'tbl_user_campaign.start_date', 'tbl_user_campaign.end_date', 'tbl_user_campaign.weeks', 'tbl_user_campaign.coupon_amount')
            //     ->where('tbl_user_campaign.id', "!=", null)
            //     ->orWhere('tbl_invoice.campaign_id', 0)
            //     ->get();
            $invoices = Invoices::
                // leftjoin('tbl_business', 'tbl_business.primary_id', 'tbl_invoice.client_id')
                leftjoin('tbl_user', 'tbl_user.id', 'tbl_invoice.client_id')
                ->leftjoin('tbl_user_campaign', 'tbl_user_campaign.id', 'tbl_invoice.campaign_id')
                ->leftjoin('tbl_sub_invoices', 'tbl_sub_invoices.invoice_id', 'tbl_invoice.id')
                ->select('tbl_invoice.*', 'tbl_user.business_name', 'tbl_user_campaign.start_date', 'tbl_user_campaign.end_date', 
                    'tbl_user.id as user_id',
                    'tbl_user_campaign.weeks', 'tbl_user_campaign.coupon_amount', 
                    'tbl_sub_invoices.id as sub_id', 'tbl_sub_invoices.transfer','tbl_sub_invoices.transfer_inex' ,'tbl_sub_invoices.transfer_fr',
                    'tbl_sub_invoices.created_at as sub_date')
                ->where("tbl_user_campaign.id", "!=", null)
                ->where('tbl_user_campaign.free_plan', 0)
                ->orWhere("tbl_invoice.campaign_id", 0)
                // ->groupBy('tbl_invoice.id')
                ->get();
            foreach($invoices as $key => $val){
                $business_name = $val->business_name;
                $business = Business::where('company_name', $business_name)
                    ->where('sales', "!=", null)
                    ->first();
                $user_id = $val->user_id;
                if(isset($business->id)){
                    $am_id = $business->sales;
                    $am = DB::table('tbl_user')
                        ->where('id', $am_id)
                        ->first();
                    if(isset($am->id)){
                        $invoices[$key]['am'] = $am->user_name;
                    }
                }
            }
            $data['invoices'] = $invoices;
            $data['revenue'] = Revenue::first();
            $data['checkout'] = CheckoutModel::get();
        }
        else{
            // $invoices = Invoices::leftjoin('tbl_user', 'tbl_user.id', 'tbl_invoice.client_id')
            //     ->leftjoin('tbl_user_campaign', 'tbl_user_campaign.id', 'tbl_invoice.campaign_id')
            //     ->select('tbl_invoice.*', 'tbl_user.business_name', 'tbl_user_campaign.start_date', 'tbl_user_campaign.end_date', 'tbl_user_campaign.weeks', 'tbl_user_campaign.coupon_amount')
            //     ->where('tbl_user_campaign.id', "!=", null)
            //     ->orWhere('tbl_invoice.campaign_id', 0)
            //     ->get();
            $invoices = Invoices::leftjoin('tbl_user', 'tbl_user.id', 'tbl_invoice.client_id')
                ->leftjoin('tbl_user_campaign', 'tbl_user_campaign.id', 'tbl_invoice.campaign_id')
                ->leftjoin('tbl_sub_invoices', 'tbl_sub_invoices.invoice_id', 'tbl_invoice.id')
                ->select('tbl_invoice.*', 'tbl_user.business_name', 'tbl_user_campaign.start_date', 'tbl_user_campaign.end_date', 
                    'tbl_user_campaign.weeks', 'tbl_user_campaign.coupon_amount',
                    'tbl_sub_invoices.id as sub_id', 'tbl_sub_invoices.transfer', 
                    'tbl_sub_invoices.created_at as sub_date')
                ->where("tbl_user_campaign.id", "!=", null)
                ->where('tbl_user_campaign.free_plan', 0)
                ->orWhere("tbl_invoice.campaign_id", 0)
                ->groupBy('tbl_invoice.id')
                ->get();
            foreach($invoices as $key => $val){
                $business_name = $val->business_name;
                $business = Business::where('company_name', $business_name)
                    ->where('sales', "!=", null)
                    ->first();
                if(isset($business->id) && ($business->sales == session('user_id') || $business->super == session('user_id'))){
                    $am_id = $business->sales;
                    $am = DB::table('tbl_user')
                        ->where('id', $am_id)
                        ->first();
                    if(isset($am->id)){
                        $invoices[$key]['am'] = $am->user_name;
                    }
                }
                else{
                    unset($invoices[$key]);
                }
            }
            $data['invoices'] = $invoices;
            $data['revenue'] = Revenue::first();
            $data['checkout'] = CheckoutModel::get();
        }
        return view('admin.transaction.customers-stripe', $data);
    }
}
