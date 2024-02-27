<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Resource;
use App\ResourceCate;
use App\DocCat;
use App\DocModel;
use App\SubMails;
use App\GalleryModel;

use App\Mail\ContactUs;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class FrontController extends Controller
{
    // Home Page
    public function front_view(Request $request){
        $data = array();
        $data['page_name'] = "Homepage";
        return view('/front/home',$data);
    }
    public function front_view_test(Request $request) {
        $data = array();
        $data['page_name'] = "Homepage";
        return view('/front/home2',$data);
    }
    // Contact us
    public function contact_us(Request $request){
        $data = array();
        $data['page_name'] = "Contact Us";
        $data['type'] = $request['type'];
        return view('front.contact',$data);
    }

    public function contact(Request $request){
        $messages = [
            "name.required" => "Name is required",
            "email.required" => "Email is required",
            "message.required" => "Message is required",
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'message' => 'required',
            'email' => 'required|email',
        ], $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('secret' => config('app.re_secret'),'response' => $request['g-recaptcha-response']),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $res = json_decode($response, true);
        if($res['success'] == false){
            return back()->withErrors("Please verify you are a human")->withInput();
        }
        Mail::to('sales@inex.net')->send(new ContactUs($request));
        return back()->withInput()->withSuccess('Thanks for contacting us.');
    }
    // About Us
    public function about_us(Request $request){
        $data = array();
        $data['page_name'] = "About Us";
        return view('front.about',$data);
    }
    // Financing
    public function financing_view(Request $request){
        $data = array();
        $data['page_name'] = "100% Financing";
        return view('front.prices.financing',$data);
    }
    public function inex_packages(Request $request){
        $data = array();
        $data['page_name'] = "INEX PACKAGES";
        return view('front.prices.packages',$data);
    }
    // Case Studies
    public function all_cases(Request $request){
        $data = array();
        $data['page_name'] = "Case Studies";
        $cate_title = $request['title'];
        if($cate_title == ''){
            $data['docs'] = DocModel::leftjoin('tbl_doc_cat', 'tbl_doc.cate', 'tbl_doc_cat.id')
                ->select("tbl_doc.*", "tbl_doc_cat.name as cate_name", "tbl_doc_cat.id as cat_id", "tbl_doc_cat.private as cate_pri")
                ->get();
            $data['page_name'] = "Case Studies";
        } else {
            $data['docs'] = DocModel::leftjoin('tbl_doc_cat', 'tbl_doc.cate', 'tbl_doc_cat.id')
                ->select("tbl_doc.*", "tbl_doc_cat.name as cate_name", "tbl_doc_cat.id as cat_id", "tbl_doc_cat.private as cate_pri")
                ->where('tbl_doc_cat.name', $request->title)
                ->get();
            $data['page_name'] = $cate_title;
        }
        $data['doc_cates'] = DocModel::leftjoin('tbl_doc_cat', 'tbl_doc.cate', 'tbl_doc_cat.id')
            ->select("tbl_doc_cat.name as cate_name", 'tbl_doc_cat.private', DB::raw('count(tbl_doc_cat.id) as num'))
            ->groupBy('tbl_doc_cat.id')
            ->get();
        $data['title'] = $cate_title;
        return view('front.cases',$data);
    }
    public function case_detail(Request $request){
        $data = array();
        $data['page_name'] = "Case Studies";
        $id = base64_decode($request->id);
        $data = DocModel::where('id', $id)->first();
        if(isset($data->id)){
            $result = [];
            $result['img'] = $data->img;
            $result['name'] = $data->name;
            if(Session::has('verified') || session::has('user_id')){
                $result['file'] = '/doc/'.$data->file_name;
            }
            return $result;
        }
        return 'fail';
    }
    public function subscribe_view(Request $request){
        $id = base64_decode($request->id);
        $data = DocModel::where('id', $id)->first();
        $result = [];
        if(isset($data->id)){
            $result['img'] = $data->img;
            $result['name'] = $data->name;
            $result['extra'] = $data->extra;
            $result['id'] = $request->id;
        }
        return view('front.subscribe', $result);
    }
    public function subscribe_email(Request $request){
        $sub = new SubMails;
        $sub->email = $request['email'];
        $sub->save();
        return redirect()->back()->withSuccess('Success');
    }
    public function subscribe_event(Request $request){
        $id = base64_decode($request->id);
        $host= gethostname();
        $ip_address = gethostbyname($host);
        $url = $this->generateRandomString(20);
        $sub = new SubMails;
        $sub->firstName = $request['firstName'];
        $sub->lastName = $request['lastName'];
        $sub->email = $request['email'];
        $sub->document_id = $id;
        $sub->extra = $url;
        $sub->ip = $ip_address;
        $sub->save();
        $data = DocModel::where('id', $id)->first();
        if(!isset($data->id)){
            return 'fail';
        }
        try{
            $name = $data->name;
            $mailData = $request;
            $mailData['mail'] = 'support@inex.net';
            $mailData['user_email'] = $request['email'];
            $mailData['subject'] = 'Download '.$name;

            $contactContent = array('firstName' =>  $request->firstName, 'lastName' => $request->lastName, 'url' => $url, 'fileName' => $data->name);

            Mail::send( ['html' => 'mail.DownloadDocument'] ,$contactContent,
            function($message) use ($mailData)
            {
                $message
                    ->from($mailData['mail'], "INEX Digital Billboard Advertising")
                    ->to($mailData['user_email'])
                    ->replyTo($mailData['mail'])
                    ->subject($mailData['subject']);
            });
            return 'success';
        }
        catch (\Exception $e) {
            return 'Invalid Email Address';
        }
        return 'success';
    }
    public function donwload_case(Request $request){
        $extra = $request->id;
        $doc = SubMails::where('extra', $extra)->first();
        if(isset($doc->id)){
            $id = $doc->document_id;
            $data = DocModel::where('id', $id)->first();
            if(!isset($data->id)){
                return back()->withInput()->withErrors([
                    'email' => 'Invalid URL',
                ]);
            }
            try{
                $file = public_path().'/doc/'.$data->file_name;
                $file = File::get($file);
                $response = Response::make($file,200);
                $response->header('Content-Type', 'application/pdf');
                session(['verified' => $doc->email]);
                return $response;
            } catch (\Exception $e) {
                return back()->withInput()->withErrors([
                    'email' => 'Invalid URL',
                ]);
            }
        }
        return back()->withInput()->withErrors([
            'email' => 'Invalid URL',
        ]);
    }
    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    // Pricing
    public function pricing_view(Request $request){
        $data = array();
        $data['page_name'] = "All Pricing";
        return view('front.prices.pricing',$data);
    }
    public function cost_view(Request $request){
        $data = array();
        $data['page_name'] = "Billboard Calculator";
        $data['locations'] = \App::call("App\Http\Controllers\MainController@get_locations");
        return view('front.price-calculator',$data);
    }
    // Locations
    public function locations(Request $request){
        $data = array();
        $data['page_name'] = "Locations";
        return view('front.locations',$data);
    }
    // Why use INEX
    public function why_use_inex(Request $request){
        $data = array();
        $data['page_name'] = "Why Use INEX Outdoor Digital Advertising?";
        return view('front.why',$data);
    }
    // Why use Digital Signs
    public function why_use_digital(Request $request){
        $data = array();
        $data['page_name'] = "Why Use Digital Signs over Static Signs?";
        return view('front.why-use-digital',$data);
    }
    // Geofencing
    public function geo_view(Request $request){
        $data = array();
        $data['page_name'] = "Geofencing Explained";
        return view('front.geo-fencing',$data);
    }
    // Mobile Advertising
    public function mobile_view(Request $request){
        $data = array();
        $data['page_name'] = "Geofencing Explained";
        return view('front.mobile',$data);
    }
    // Team - Trusted Partners
    public function team_view(Request $request){
        $data = array();
        $data['page_name'] = "Trusted Partners";
        $data['title'] = "Trusted Partners";
        $data['doc_cates'] = DocModel::leftjoin('tbl_doc_cat', 'tbl_doc.cate', 'tbl_doc_cat.id')
            ->select("tbl_doc_cat.name as cate_name", 'tbl_doc_cat.private', DB::raw('count(tbl_doc_cat.id) as num'))
            ->groupBy('tbl_doc_cat.id')
            ->get();
        
        $data['types'] = ResourceCate::get();
        $data['resource'] = Resource::leftjoin('tbl_resource_category', 'tbl_resource.cate_id',  'tbl_resource_category.id')
            ->select('tbl_resource_category.title', 'tbl_resource_category.extra as extra_cate', 'tbl_resource_category.file as type_file', 'tbl_resource.*')
            ->orderBy('tbl_resource_category.id')
            ->get();
        return view('front.team',$data);
    }
    public function view_gallery(Request $request){
      $data = array();
      $data['page_name'] = "Gallery";
      $data['gallery'] = GalleryModel::get();
      return view('front.gallery',$data);
    }
}
