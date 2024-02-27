<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CMController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\WebhookController;

Route::get('/', [FrontController::class, 'front_view'])->name('home');
Route::get('/test', [FrontController::class, 'front_view_test'])->name('home-test');
Route::get('contact/{type?}', [FrontController::class, 'contact_us'])->name('contact-us');
Route::post('contact', [FrontController::class, "contact"]);
Route::get('about_us', [FrontController::class, "about_us"])->name('about-us');
Route::get('cases/{title?}', [FrontController::class, "all_cases"])->name('case-studies');
Route::get('get-case', [FrontController::class, 'case_detail']);
Route::post('subscribe-event', [FrontController::class, 'subscribe_event']);
Route::post('subscribe-email', [FrontController::class, 'subscribe_email']);
Route::get('subscribe/{id}',[FrontController::class, 'subscribe_view'])->name('subscribe');
Route::get('download-document/{id?}', [FrontController::class, "donwload_case"])->name('download-detail');
Route::get('pricing', [FrontController::class, "pricing_view"])->name('pricing');
Route::get('cost-calculator', [FrontController::class, "cost_view"])->name('cost-calculator');
Route::get('locations', [FrontController::class, "locations"])->name('locations');
Route::get('why-use-outdoor', [FrontController::class, "why_use_inex"])->name('why-use-outdoor');
Route::get('why-use-digital-signs', [FrontController::class, "why_use_digital"])->name('digital-signs');
Route::get('geofencing', [FrontController::class, "geo_view"])->name('geofencing');
Route::get('mobile-advertising', [FrontController::class, "mobile_view"])->name('mobile-advertising');
Route::get('financing', [FrontController::class, "financing_view"])->name('financing');
Route::get('inex-packages', [FrontController::class, "inex_packages"])->name('inex-packages');
Route::get('trusted-partners', [FrontController::class, "team_view"])->name('team');

// Route::get('why-use-outdoor', function(){
//     $data = array();
//     $data['ad'] = App::call("App\Http\Controllers\MainController@get_all_ad");
//     $data['pa'] = App::call("App\Http\Controllers\UserController@list_pa");
//     return view('outdoor', $data);
// })->name('why-use-outdoor');
// Route::get('/our_location', function () {
//     $data = array();
//     $data['ad'] = App::call("App\Http\Controllers\MainController@get_all_ad");
//     $data['pa'] = App::call("App\Http\Controllers\UserController@list_pa");
//     $data['locations'] = App::call("App\Http\Controllers\MainController@get_locations");
//     return view('/our_location',$data);
// })->name('our_location');
Route::get('/bill_ad', function () {
    $data = array();
    $data['ad'] = App::call("App\Http\Controllers\MainController@get_all_ad");
    return view('/bost',$data);
});
Route::get('/bost', function () {
    $data = array();
    $data['ad'] = App::call("App\Http\Controllers\MainController@get_all_ad");
    return view('/bost',$data);
});

Route::get('/whatmakeus', function () {
    $data = array();
    $data['ad'] = App::call("App\Http\Controllers\MainController@get_all_ad");
    return view('/whatmakeus',$data);
});
Route::get("/get-price", [CampaignController::class, "get_price_front"]);
Route::get('/digital', function () {
    $data = array();
    $data['ad'] = App::call("App\Http\Controllers\MainController@get_all_ad");
    return view('/digital',$data);
});
Route::get('/educate', function () {
    $data = array();
    $data['ad'] = App::call("App\Http\Controllers\MainController@get_all_ad");
    return view('/educate',$data);
});
Route::get('/sales', function () {
    $data = array();
    $data['ad'] = App::call("App\Http\Controllers\MainController@get_all_ad");
    return view('/sales',$data);
});
Route::get('/install', function () {
    $data = array();
    $data['ad'] = App::call("App\Http\Controllers\MainController@get_all_ad");
    return view('/install',$data);
});
Route::get('/servicedigital', function () {
    $data = array();
    $data['ad'] = App::call("App\Http\Controllers\MainController@get_all_ad");
    return view('/servicedigital',$data);
});
Route::get('/digitalsigncatalog', function () {
    $data = array();
    $data['ad'] = App::call("App\Http\Controllers\MainController@get_all_ad");
    return view('/digitalsigncatalog',$data);
});
// Route::get('/view-gallery', function () {
//     $data = array();
//     $data['ad'] = App::call("App\Http\Controllers\MainController@get_all_ad");
//     return view('/gallery',$data);
// });
Route::get('view-gallery', [FrontController::class, 'view_gallery'])->name('gallery');

Route::get('/bost', function () {
    $data = array();
    $data['ad'] = App::call("App\Http\Controllers\MainController@get_all_ad");
    return view('/bost',$data);
});
Route::get('/sitemap.xml', function () {
    $data = array();
    $data['ad'] = App::call("App\Http\Controllers\MainController@get_all_ad");
    return view('/sitemap/index',$data);
});
Route::get('/sitemap', function () {
    $data = array();
    $data['ad'] = App::call("App\Http\Controllers\MainController@get_all_ad");
    return view('/sitemap/index',$data);
});
Route::get('/service', function () {
    $data = array();
    $data['ad'] = App::call("App\Http\Controllers\MainController@get_all_ad");
    return view('/service',$data);
});
Route::get('stores', function(){
    return redirect('home');
    $data = array();
    $data['ad'] = App::call("App\Http\Controllers\MainController@get_all_ad");
    return view('stories', $data);
});
// Route::get('/login', function () {
//     return view('admin/login');
// })->name("login");
Route::get('login', [AuthController::class, "login_view"])->name('login');
Route::get('demo', [AuthController::class, "login_view"])->name('login-demo');
Route::get('register', [AuthController::class, "register_view"])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::get('forgot', [AuthController::class, "forgot_view"])->name('forgot');
Route::post('forgot', [AuthController::class, 'forgot']);
Route::post("login",[AuthController::class, "login"]);
Route::get('/account-manager', [AuthController::class, "get_account_manager"])->name("get_account_manager");
Route::get('/welcome-registeration', [AuthController::class, 'welcome_registeration'])->name('welcome-registeration');

// Dashbaord
Route::get("dashboard",function(){
    if(Session::has('user_id')){
        $data = array();
        $data["page_name"] = "Dashboard";
        if(session('level') < 2){
            return view('auth/dashboard', $data);
        }
        $data["business_name"] = App::call("App\Http\Controllers\MainController@get_business_name");
        $data['users'] = App::call("App\Http\Controllers\MainController@get_users");
        $data['dashboard'] = App::call("App\Http\Controllers\MainController@get_dashboard");
        $data['locations'] = App::call("App\Http\Controllers\MainController@get_locations");
        $data['master']  = App::call("App\Http\Controllers\MainController@get_master");
        $data['suggestions'] = App::call("App\Http\Controllers\MainController@get_suggestion_dashboard");
        return view("admin/dashboard",$data);
    }
    else{
        return redirect('login');
    }
})->name("dashboard");
Route::get('/weekly-inventory', function(){
    if(Session::has('user_id') && session('level') >= 2){
        $data = array();
        $data["page_name"] = "Today's Inventory";
        $data["business_name"] = App::call("App\Http\Controllers\MainController@get_business_name");
        $data['users'] = App::call("App\Http\Controllers\MainController@get_users");
        $data['dashboard'] = App::call("App\Http\Controllers\MainController@get_dashboard");
        $data['locations'] = App::call("App\Http\Controllers\MainController@get_locations");
        $data['master']  = App::call("App\Http\Controllers\MainController@get_master");
        $data['suggestions'] = App::call("App\Http\Controllers\MainController@get_suggestion_dashboard");
        // Public Or Private
        $data['inventory'] =  App::call("App\Http\Controllers\CampaignController@get_today_inv");
        $data['location_type'] = App::call("App\Http\Controllers\MainController@location_type");
        return view("admin/payment/inventory-dashboard",$data);
    }
    else{
        return redirect('login');
    }
})->name("weekly-inventory");
Route::post("/get-weeks-inventory", [CampaignController::class, "get_weeks_inventory"]);
Route::get('/welcome' ,[UserController::class, "welcome"])->name('welcome');
Route::get('/get_primary_info', [UserController::class, "get_primary_info"]);
Route::post('save-welcome', [UserController::class, "save_welcome"]);
//unsubscribe
Route::get('/unsubscribe', [MainController::class, "unsubscribe"])->name('unsubscribe');
Route::get('/notifications', [MainController::class, "notifications"])->name('notifications');
Route::post('update-notification', [MainController::class, "update_notification"]);
// Graphic Design
Route::get('/graphic-design', [ResourceController::class, "graphic_view"]);


Route::post('get_sub',[MainController::class, "get_sub"]);
// End of Dashbaord
// Managet Social networ
Route::get('/manage_social',function(){    
    if(Session::has('user_id') && session('level') > 1){
        $data = array();
        $data["check_multi"] = App::call("App\Http\Controllers\MainController@check_multi");
        if($data['check_multi'] > 0 || session('level') > 1){
            $data["page_name"] = "Link to Social Media";
            $data["social"] = App::call("App\Http\Controllers\MainController@get_social");
            $data['s_avalialbe'] = App::call("App\Http\Controllers\MainController@get_social_avail");
            $data['users'] = App::call("App\Http\Controllers\UserController@get_business_ta");
            $data["social"] = App::call("App\Http\Controllers\MainController@get_social");
            $data["multi"] = App::call("App\Http\Controllers\MainController@get_multi");
            return view("admin/manage_social",$data);
        }
    }
    else{
        return redirect('login');
    }
})->name('manage_social');
Route::post("get_social_status",[MainController::class, "get_social_status"]);
// End of manage Social New Work


Route::get("manage_temp",function(){
    if(Session::has('user_id') && session('level') == 2){
        $data = array();
        $data["page_name"] = "Manage Templates";
        $data["locations"] = App::call("App\Http\Controllers\MainController@get_loca");
        $data["business_name"] = App::call("App\Http\Controllers\MainController@get_business_name");
        return view("admin/manage_temp",$data);
    }
    else{
        return redirect('login');
    }
})->name("manage_temp");
Route::post("get_locations_by_name",[MainController::class, "get_locations_by_name"]);
Route::get("get_locations_by_business_name", [MainController::class, "get_locations_by_business_name"]);
Route::post("get_business_name",[MainController::class, "get_business_name"]);
Route::post('create_temp',[MainController::class, "create_temp"]);
Route::post('get_temp',[MainController::class, "get_temp"]);
Route::post('get_temp_manage',[MainController::class, "get_temp_manage"]);
Route::post("delete_template",[MainController::class, "delete_template"]);
Route::post("update_temp",[MainController::class, "update_temp"]);
Route::post("get_temp_name",[AdsController::class, "get_temp_name"]);
Route::post("get_template_byid",[MainController::class, "get_template_byid"]);
// Update Restriction
Route::post('get_restriction', [MainController::class, "get_restriction"]);
Route::post('update-restrict', [MainController::class, "update_restrict"]);

// Manage sic
Route::get('manage_sic',function(){
    if(Session::has('user_id') && session('level') == 2){
        $data = array();
        $data["page_name"] = "Manage SIC";
        return view("admin/manage_sic",$data);
    }
    else{
        return redirect('login');
    }
});
Route::post('get_sic',[MainController::class, "get_sic"]);
Route::post('new_sic',[MainController::class, "new_sic"]);
Route::post('update_sic',[MainController::class, "update_sic"]);
Route::post("delete_sic",[MainController::class, "delete_sic"]);
// End of mange Sic
// Manage Sales
Route::get('manage_sales',function(){
    if(Session::has('user_id') && session('level') == 2){
        $data = array();
        $data["page_name"] = "Manage Sales";
        return view("admin/manage_sales",$data);
    }
    else{
        return redirect('login');
    }
});
// Route::post('get_sales',[MainController::class, "get_sales");
Route::post('new_sales',[MainController::class, "new_sales"]);
Route::post('update_sales',[MainController::class, "update_sales"]);
Route::post("delete_sales",[MainController::class, "delete_sales"]);
// End of sales
// ADs
Route::get('update_ad', [AdsController::class, "create_ad_view"])->name('update_ad');
// Route::get("update_ad",function(){
//     if(Session::has('user_id')){
//         $data = array();
//         $data["page_name"] = "Create New Ad";
//         $data["business_name"] = App::call("App\Http\Controllers\MainController@get_business_name_by_session");
//         $data["multi"] = App::call("App\Http\Controllers\MainController@get_multi");
//         $data["check_multi"] = App::call("App\Http\Controllers\MainController@check_multi");
//         $data['s_avalialbe'] = App::call("App\Http\Controllers\MainController@get_social_avail");
//         $data['pa'] = App::call("App\Http\Controllers\UserController@list_pa");
//         // $data['user'] = App::call("App\Http\Controllers\MainController@get_account");
//         return view("admin/update_ad",$data);
//     }
//     else{
//         return redirect('login');
//     }
// })->name("update_ad");
Route::get("update_ad_temp",function(){
    if(Session::has('user_id')){
        $data = array();
        $data["page_name"] = "Create New Ad";
        $data["business_name"] = App::call("App\Http\Controllers\MainController@get_business_name");
        return view("admin/update_ad_temp",$data);
    }
    else{
        return redirect('login');
    }
})->name("update_ad_temp");;
Route::post('get_day_plan',[MainController::class, "get_day_plan"]);
Route::post("convert_img",[MainController::class, "convert_img"]);
Route::post("create_ad",[MainController::class, "create_ad"]);
Route::post("get_ad",[MainController::class, "get_ad"]);
Route::post("delete_ad",[MainController::class, "delete_ad"]);
Route::post("update_ad_list",[MainController::class, "update_ad_list"]);
// Emd of ad
Route::post("get_ad_byid",[MainController::class, "get_ad_byid"]);
Route::post("get_active_ad",[MainController::class, "get_active_ad"]);

// Playlist
Route::get("manage_playlist",function(){
    if(Session::has('user_id')){
        $data = array();
        $data["page_name"] = "Manage Playlist";
        $data["business_name"] = App::call("App\Http\Controllers\MainController@get_business_customer_name_by_session");
        $data["multi"] = App::call("App\Http\Controllers\MainController@get_multi");
        $data["check_multi"] = App::call("App\Http\Controllers\MainController@check_multi");
        $data['pa'] = \App::call("App\Http\Controllers\UserController@list_pa");
        $data['locations'] = \App::call("App\Http\Controllers\MainController@get_locations");
        return view("admin/playlist/playlist",$data);
    }
    else{
        return redirect('login');
    }
});
Route::post('save_list',[MainController::class, "save_list"]);
Route::post("publish_cm",[MainController::class, 'publish_cm']);
Route::post("update_sch",[MainController::class, "update_sch"]);
//  END OF PLAYLIST
// MAIN PLAYLIST
Route::get("add_playlist",function(){
    if(Session::has('user_id') && session('level') == 2){
        $data = array();
        $data["page_name"] = "Manage Master Playlists";
        $data["business_name"] = App::call("App\Http\Controllers\MainController@get_business_name");
        $data['locations'] = App::call("App\Http\Controllers\MainController@get_locations");
        return view("admin/main_play",$data);
    }
    else{
        return redirect('login');
    }
});
Route::post('create_master',[MainController::class, "create_master"]);
Route::post('delete_master',[MainController::class, "delete_master"]);
Route::post('get_mainplay',[MainController::class, "get_mainplay"]);
// END OF MAIN PLAYLIST


// Mange master playlist
Route::get("master_playlist",function(){
    if(Session::has('user_id') && session('level') == 2){
        $data = array();
        $data["page_name"] = "MANAGE MASTER PLAYLIST";
        return view("admin/locations",$data);
    }
    else{
        return redirect('login');
    }
});
// End of manage play;list
Route::get("account", [AccountController::class, "account_view"])->name("account");
Route::get("account-security", [AccountController::class, "security_view"])->name("account-security");
Route::post('update-info', [AccountController::class, "update_info"])->name('account-personal');
Route::post('account-password', [AccountController::class, "update_password"])->name('account-password');
// End of account
Route::post('get_sic_sales',[MainController::class, "get_sic_sales"]);
Route::post('update_account',[MainController::class, "update_account"]);
Route::get("trust",function(){
    if(Session::has('user_id') && session('level') > 0){
        $data = array();
        $data["page_name"] = "My Trusted Agents";
        $data["user"] = App::call("App\Http\Controllers\MainController@get_account");
        // $data["multi"] = App::call("App\Http\Controllers\MainController@get_multi");
        $data["check_multi"] = App::call("App\Http\Controllers\MainController@check_multi");
        $data["sic"] = App::call("App\Http\Controllers\MainController@get_sic");
        $data["sales"] = App::call("App\Http\Controllers\MainController@get_sales");
        $data['trusts'] = App::call("App\Http\Controllers\MainController@get_trust");
        return view("admin/users/trust",$data);
    }
    else{
        return redirect()->back();
    }
})->name('manage-business');
Route::post("get_trust",[MainController::class, "get_trust"]);
Route::post("add_trust",[MainController::class, "add_trust"]);
Route::post("update_trust",[MainController::class, "update_trust"]);
Route::post("delete_trust",[MainController::class, "delete_trust"]);
Route::post("save_multi",[MainController::class, "save_multi"]);
Route::post("update_lock",[MainController::class, "update_lock"]);
// End of trust
// Social 
Route::get('socials',function(){
    // if(Session::has('user_id')){
    //     $data = array();
    //     $data["page_name"] = "Link to Social Media";
    //     $data["social"] = App::call("App\Http\Controllers\MainController@get_social");
    //     $data["user"] = App::call("App\Http\Controllers\MainController@get_account");
    //     $data['s_avalialbe'] = App::call("App\Http\Controllers\MainController@get_social_avail");
    //     $data["check_multi"] = App::call("App\Http\Controllers\MainController@check_multi");

    //     session(['social_session','']);
    //     return view("admin/social",$data);
    // }
    // else{
        return redirect('login');
    // }
})->name('socials');
Route::post("update_social",[MainController::class, "update_social"]);

Route::get('/social-posts', [SocialController::class, "manage_socials"]);
Route::get('/history-posts', [SocialController::class, "history_view"]);
Route::get('/create-post', [SocialController::class, "create_post_view"]);
Route::post('/post-social', [SocialController::class, "post_social"]);
Route::get('/delete-post/{id}', [SocialController::class, "delete_post"]);
Route::get('process-post', [SocialController::class, "process_post"]);
// End of Social
// Manage CM
Route::get('/manage_cm', function(){
    if(Session::has('user_id') && session('level') == 2){
        $data = [];
        $data['page_name'] = "Manage CM";
        return view('admin/cm/manage', $data);
    }
    else{
        return redirect('login');
    }
})->name('manage-cm');
Route::post('/get_sub_list', [CMController::class, 'get_sub_list']);
Route::post('/delete_sub_list', [CMController::class, 'delete_sub_list']);
// Manage locations
Route::get("manage_locations",function(){
    if(Session::has('user_id') && session('level') == 2){
        $data = array();
        $data["page_name"] = "Master Playlist Client Load";
        return view("admin/locations",$data);
    }
    else{
        return redirect('login');
    }
});
Route::post("get_locations",[MainController::class, "get_locations"]);
Route::post("insert_location",[MainController::class, "insert_location"]);
Route::post("update_locations",[MainController::class, "update_locations"]);
Route::post("delete_locations",[MainController::class, "delete_locations"]);
// End of locations
// Price and Discount
Route::post('update-price', [CampaignController::class, "update_price"]);
// Business Locations
Route::get("manage_locations_by",function(){
    if(Session::has('user_id') && session('level') == 2){
        $data = array();
        $data["page_name"] = "Business Locations";
        $data["locations"] = App::call("App\Http\Controllers\MainController@get_loca");
        return view("admin/locations_by_business",$data);
    }
    else{
        return redirect('login');
    }
});
Route::post("update_day_plan",[MainController::class, "update_day_plan"]);
Route::post("get_location_by_busiess",[MainController::class, "get_location_by_busiess"]);
Route::post("update_location",[MainController::class, "update_location"]);
// END of Manage location by business name
Route::get("public_location", [MainController::class, "public_location"])->name('public_location');
Route::post('save-public_location', [MainController::class, "save_public_location"]);
// End of locations
Route::get("contact_us",function(){
    if(Session::has('user_id')){
        $data = array();
        $data["page_name"] = "Contact Us";
        $data['user'] = App::call("App\Http\Controllers\MainController@get_account");
        $data["check_multi"] = App::call("App\Http\Controllers\MainController@check_multi");
        return view("admin/contact_us",$data);
    }
    else{
        return redirect('login');
    }
});
Route::get('manage-user', function(){
    if(Session::has('user_id') && (session('level') == 2)){
        $data = array();
        $data["page_name"] = "Manage User";
        return view("admin/users/manage-user",$data);
    }
    else{
        return redirect('login');
    }
})->name('manage-admin');
Route::post('get_admin', [UserController::class, "get_admin"]);
Route::post('new-admin', [UserController::class, 'new_admin']);
Route::post('update-admin', [UserController::class, 'update_admin']);
Route::post('delete_admin', [UserController::class, 'delete_admin']);
Route::post('lock_user', [UserController::class, 'lock_user']);
Route::post('/get_super', [UserController::class, 'get_super']);
Route::post('/get_business', [UserController::class, 'get_business']);
Route::post('/get_business_ta', [UserController::class, 'get_business_ta']);
// Manage Business Account
Route::get('/manage-business', [UserController::class, 'view_business'])->name('business-account');
Route::get('/create-business', [UserController::class, 'business'])->name('create-business');
Route::get('/edit-business/{id}', [UserController::class, 'edit_business'])->name('edit-business');
Route::post('/delete_business', [UserController::class, 'delete_business']);
Route::get('/active-business/{id}', [UserController::class, 'active_business'])->name('active-business');
// Route::get('/update_location/{id}', [UserController::class, "update_location"])->name('update-location');
Route::post('update_location_business', [UserController::class, "update_location"]);
Route::post('/create-business', [UserController::class, 'create_business']);
Route::post('/update-business', [UserController::class, 'update_business']);
Route::post('/update_status', [UserController::class, 'update_status']);
Route::post('/get_business_account', [UserController::class, 'get_business_account']);
Route::post('/get_sales', [UserController::class, 'get_sales']);
Route::post('/get_graphic', [UserController::class, 'get_graphic']);
// New Accounts
Route::get('new-accounts', [UserController::class, 'view_new_accounts'])->name('new-accounts');
Route::post("get_new_accounts", [UserController::class, "get_new_accounts"]);
Route::get("assign-account", [UserController::class, "assign_account"])->name('assign_account');
// Campaign History
Route::get('/campaign-history/{id}', [MainController::class, "campaign_history"]);
Route::post('/create-campaign', [MainController::class, 'create_campaign']);
Route::post('/update-campaign', [MainController::class, 'update_campaign']);
Route::post('/delete_campaign', [MainController::class, 'delete_campaign']);
// Delivery
Route::get('/delivery/{user_id}/{id}', [MainController::class, 'delivery'])->name('delivery');
// Advertising Tools
Route::get('/training/{id?}', [UserController::class, "training_view"])->name('training');
Route::get('/manage-training', [UserController::class, "manage_resource"])->name('manage-training');
Route::post('/get_docs', [UserController::class, "get_docs"]);
Route::post('detail-doc', [UserController::class, "detail_doc"]);
Route::post("/new_doc", [UserController::class, "new_doc"]);
Route::post("/update_doc", [UserController::class, "update_doc"]);
Route::get('/delete_doc', [UserController::class, "delete_doc"]);
Route::post('share_doc', [UserController::class, "share_doc"]);
Route::get('manage-gallery', [UserController::class, "manage_gallery"])->name('manage-gallery');
Route::post('get-gallery', [UserController::class, 'get_gallery']);
Route::post('upload-gallery', [UserController::class, 'upload_gallery']);
Route::post('update-gallery', [UserController::class, 'update_gallery']);
Route::post('delete-gallery', [UserController::class, 'delete_gallery']);
// Manage Subscriber
Route::get('/manage-subscribers/{status?}', [UserController::class, "manage_subscribers"])->name('manage-subscribers');
Route::post('get-subscriber', [UserController::class, 'get_subscriber']);
Route::post('add-subscriber', [UserController::class, 'add_subscriber']);
Route::post('update-subscriber', [UserController::class, 'update_subscriber']);
Route::post('delete-subscriber', [UserController::class, 'delete_subscriber']);
Route::post('import-csv', [UserController::class, 'import_csv']);
Route::post('delete_duplocation', [UserController::class, 'delete_duplocation']);
// Manage Document Categories
Route::get('/training-category', [UserController::class, "manage_resource_cate"])->name('training-category');
Route::post('delete-cate', [UserController::class, 'delete_cate'])->name('delete-cate');
Route::post('create-cate', [UserController::class, 'create_cate'])->name('create-cate');
Route::post('update-cate', [UserController::class, 'update_cate'])->name('create-cate');
// View Document
Route::get('doc/{name}', [UserController::class, "doc_view"]);
// Seo Operation
Route::get('seo-operation', [UserController::class, 'seo_operation'])->name('seo-operation');
Route::post('detail-seo', [UserController::class, 'detail_seo']);
Route::post('new-seo', [UserController::class, 'new_seo']);
Route::post('update-seo', [UserController::class, 'update_seo']);
Route::get('update-seo', [UserController::class, 'update_seo']);
// Manage Resources
Route::get('manage-resource', [ResourceController::class, "manage_resource"])->name('manage-resource');
Route::post('new_resource', [ResourceController::class, 'new_resource']);
Route::post('update_resource', [ResourceController::class, 'update_resource']);
Route::post('delete_resource', [ResourceController::class, 'delete_resource']);
Route::get('resource-types', [ResourceController::class, "manage_type"])->name('resource-type');
Route::post('new_resource_type', [ResourceController::class, 'new_resource_type']);
Route::post('update_resource_type', [ResourceController::class, 'update_resource_type']);
Route::post('delete_resource_type', [ResourceController::class, 'delete_resource_type']);
// News Letter
Route::get("/newsletter", [UserController::class, "news_view"])->name('newsletter');
Route::post('/test-newsletter', [UserController::class, "test_newsletter"]);
Route::post('add-news', [UserController::class, "add_news"]);
Route::post('update_news', [UserController::class, "update_news"]);
Route::get('delete-news', [UserController::class, "delete_news"]);
Route::get('get-news',[UserController::class, "get_news"]);
Route::get('/view-news/{id}', [UserController::class, "view_news"])->name('view-news');
Route::get('/create-news', [UserController::class, "create_news"])->name('create-news');
Route::get('/update-news/{id}', [UserController::class, "update_news_view"])->name('update-news');
Route::get('change-news', [UserController::class, "change_news"])->name('change-news');
// Admin Login
Route::get('admin', [UserController::class, "admin_login"])->name('admin-login');
Route::post('user-login', [UserController::class, "login"]);

Route::get("suggest",function(){
    if(Session::has('user_id') && session('level') == 2){
        $data = array();
        $data["page_name"] = "Suggestions";
        return view("admin/suggest",$data);
    }
    else{
        return redirect('login');
    }
});
Route::post("save_suggest",[MainController::class, "save_suggest"]);
Route::get("text_suggest", [MainController::class, "text_suggest"]);
Route::post("get_suggestion",[MainController::class, "get_suggestion"]);
Route::post("delete_suggestion",[MainController::class, "delete_suggestion"]);
Route::post("update_fixed",[MainController::class, "update_fixed"]);
Route::post('update_suggest', [MainController::class, 'update_suggest']);
Route::get("view-history/{id}", [MainController::class, "view_history"]);
Route::get("send-update/{id}", [MainController::class, "send_update"])->name("send-update");

// Manage Invoice
Route::get("/manage-invoice", [InvoiceController::class, "manage_invoice"])->name('manage-invoice');
Route::get('/create-invoice', [InvoiceController::class, "create_invoice"])->name('create-invoice');
Route::post("/save-manu-invoice", [InvoiceController::class, "create_manu_invoice"]);
Route::get("get-manual-invoice/{id}", [InvoiceController::class, "get_single_manu_invoice"]);
Route::post('change-manu-inv', [InvoiceController::class, "change_manu_inv"]);
Route::post('change-inv-type', [InvoiceController::class, "change_inv_type"]);

Route::get("/get_location/{id}", [InvoiceController::class, "get_location"])->name('get-location-user');
Route::get('/manage-payment', [InvoiceController::class, 'manage_payment'])->name('manage-payment-method');
Route::post('/change-payment-method', [InvoiceController::class, "change_payment_method"]);
Route::post('change-payment-date', [InvoiceController::class, "change_payment_date"]);
Route::get('/delete-invoice/{id}/{sub_flag}', [InvoiceController::class, "delete_invoice"]);
// Manage Coupon
Route::get('/manage-coupon', [InvoiceController::class, "manage_coupon"])->name('manage-coupon');
Route::post('/save-coupon', [InvoiceController::class, "save_coupon"]);
Route::post('/update-coupon', [InvoiceController::class, "update_coupon"]);
Route::get('/delete-coupon/{id}', [InvoiceController::class, "delete_coupon"]);
Route::get('/email-coupon', [InvoiceController::class, "email_coupon"]);
Route::get('/refer-coupon', [InvoiceController::class, "refer_coupon"]);
// Revenue
Route::get('/revenue-dist', [InvoiceController::class, "revenue_dist"])->name('revenue-dist');
Route::post('/update-revenue', [InvoiceController::class, "update_revenue"]);
// Ads Sold
Route::get('ads-sold', [CampaignController::class, "ads_sold"])->name('ads-sold');
Route::get('get-sold', [CampaignController::class, "get_sold"])->name('get-sold');
// Income
Route::get('income', [InvoiceController::class, "view_income"])->name('view-income');
// Inventory
Route::get('inventory', [CampaignController::class, "inventory_view"])->name("inventory");
Route::get('get-inventory-by-location', [CampaignController::class, "get_inventory"]);
// Manage Campaign - Client
Route::get('manage-campaign', [CampaignController::class, 'manage_campaign'])->name('manage-camp');
Route::get('list-campaign', [CampaignController::class, 'list_campaign'])->name('list-camp');
Route::get('user-campaign', [CampaignController::class, 'create_view_user_side'])->name('client-campaign');
// Route::get('user-campaign', [CampaignController::class, 'create_view'])->name('client-campaign');
// Get Swtich Locations
Route::post("switch_location", [CampaignController::class, 'switch_location']);
Route::post("save-switch", [CampaignController::class, "save_switch"]);
// User Side
Route::get('/user/user-campaign', [CampaignController::class, 'create_view_user_side'])->name('user-campaign');
Route::post('/getLocationBusiness', [CampaignController::class, "getLocationBusiness"]);
// End of User side
Route::post('/get_price', [CampaignController::class, 'get_price']);
Route::post('/get_end', [CampaignController::class, 'get_end']);
Route::post('/save-user-camp', [CampaignController::class, 'save_user_camp']);
Route::post("/update-user-camp", [CampaignController::class, "update_user_camp"]);
Route::get('/delete-campaign/{id}', [CampaignController::class, 'delete_campaign'])->name('delete-user-camp');
Route::post('/stop-campaign', [CampaignController::class, 'stop_campaign'])->name('stop-user-camp');
Route::get('/stop-campaign/{id}', [CampaignController::class, 'stop_campaign'])->name('stop-user-camp');
Route::get('/edit-campaign/{id}', [CampaignController::class, "edit_campaign"])->name('edit-userc-camp');
Route::post('/change-name', [CampaignController::class, "change_name"]);
// Send Payment Link to Client
Route::get("/send-link/{id}", [CampaignController::class, "send_link"])->name("send-link");
Route::get("/send-link-manual/{id}", [CampaignController::class, "send_link_manual"])->name("send-link-manual");
Route::get("purchase/{id}", [CampaignController::class, "edit_campaign"])->name("purchase");
Route::get("purchase-manual/{id}", [InvoiceController::class, "pay_invoice_manual"])->name("purchase-manual");
// Manage Payment - Client
Route::get('/invoice-campaign/{id}', [InvoiceController::class, "client_invoice_view"])->name('campaign-invoice');
Route::post('/checkout', [InvoiceController::class, "checkout"])->name('checkout');
Route::post('/checkout-demo', [InvoiceController::class, "checkout_demo"])->name("checkout-demo");
Route::post('checkout-manual',[InvoiceController::class, "checkout_manual"])->name('checkout-manual');
Route::get('/pay-invoice/{id}', [InvoiceController::class, "payinvoice"])->name('invoice-pay');
Route::get('/pay-invoice-ach/{id}', [InvoiceController::class, "payinvoice_ach"])->name('invoice-pay-ach');
Route::post('/no-charge/{id}', [InvoiceController::class, "no_charge"]);
Route::get('/list-invoice/{id}', [InvoiceController::class, "list_invoice"]);
// Web Hook of stripe
Route::get('webhook', [WebhookController::class, "webhook"]);
Route::post('webhook', [WebhookController::class, "webhook"]);
Route::post('webhook-response', [WebhookController::class, 'webhook_response']);
Route::get('view-webhook', [WebhookController::class, 'view_webhook'])->name('view-webhook');
// View Invoice in Admin Side
Route::get('/view-invoice/{id}/{subId?}', [InvoiceController::class, "view_invoice"])->name('view-invoice-admin');
Route::post('change-inv-status', [InvoiceController::class, "change_inv_status"]);
Route::post("/send-invoice", [InvoiceController::class, "send_invoice"]);

// Transaction
Route::get('transaction-records', [InvoiceController::class, "records_view"])->name("transaction-records");
Route::get('transaction', [InvoiceController::class, "transaction"])->name("transaction");
// Customer on stripe
Route::get('customers', [InvoiceController::class, 'customer_view'])->name('customer-view');
// Change Paid Status Manually
Route::post('change_sub_status', [InvoiceController::class, "change_sub_status"]);
// Current Revenue
Route::get('/current-revenue/{id?}', [InvoiceController::class, "current_revenue"])->name("current-revenue");
// Route::get('/get-revenue', "InvoicController@get_revenue");
Route::post('transfer', [InvoiceController::class, "transfer_funds"]);
Route::post('/transfer_users', [InvoiceController::class, 'transfer_users']);
Route::get('/transfer-history/{id?}', [InvoiceController::class, "transfer_view"]);
Route::get('/view-transfer/{id}/{subid?}', [InvoiceController::class, 'detail_transfer'])->name('view-transfer');
// Connected Stripe Accounts
Route::get('/connected-accounts', [InvoiceController::class, "connected_accounts"])->name('connected-accounts');
// 
Route::get('/revenue', [InvoiceController::class, "revenue_view"])->name('revenue-view');
// Sales Analysis
Route::get('sales-analysis', [InvoiceController::class, "sales_analysis"])->name('sales-analysis');
// Manage PA
Route::get('manage-pa', [UserController::class, "manage_pa"])->name('manage-pa');
Route::get('get_pa/{id}', [UserController::class, "get_pa"])->name('get_pa');
Route::post('new-pa', [UserController::class, "new_pa"]);
Route::post('update-pa', [UserController::class, "update_pa"]);
Route::get('delete_pa/{id}', [UserController::class, "delete_pa"])->name('delete-pa');

// Account Administration
Route::get('add-bank', [UserController::class, "add_bank"])->name('add-bank');
Route::post('save-bank', [UserController::class, "save_bank"]);

Route::get("forget",function(){
    return view("forget");
});
Route::post("forget",[MainController::class, "forget"]);
Route::get("reset/{id}",function($id){
    $data = array();
    $data["user_id"] = $id;
    $data["page_name"] = "Set";
    return view("reset",$data);
});
Route::get("set/{id}",function($id){
    $data = array();
    $data["user_id"] = $id;
    $data["page_name"] = "SET";
    return view("reset",$data);
})->name('set-password');
Route::post("reset",[MainController::class, "reset"])->name('set-pass');
Route::post("user-reset",[MainController::class, "reset"])->name('admin-pass');
Route::get("set-password/{id}",function($id){
    $data = array();
    $data["user_id"] = $id;
    $data["page_name"] = "SET";
    return view("reset",$data);
})->name('setadmin-password');


Route::get("sign_out",function(){
    $redirect = "login";
    // if(session('level') > 2){
    //     $redirect = 'admin-login';
    // }
    Session::flush();
    return redirect()->route($redirect);
});
Route::fallback(function(){
    return view("front.error");
})->name('fallback');


//Fackbook Token
Route::post("f_token",[MainController::class, "f_token"]);
// END OF F_TOKEN


// Social
Route::post("facebook",[MainController::class, "facebook"]);
Route::post("update_f_ua_token",[MainController::class, "update_f_ua_token"]);   //User Access Token
Route::get("get_long_live_f",[MainController::class, "get_long_live_f"]); // Long Live Key
Route::get("get_userid",[MainController::class, "get_userid"]); // user and Page id

// END OF SOCIAL
// Twitter
Route::get("redirect",[MainController::class, "redirect"]);
Route::get("redirect_multi",[MainController::class, "redirect_multi"]);
Route::get("twitter",[MainController::class, "twitter"]);
// END OF Twitter
// Linkedin
Route::get("linkedIn_auth",[MainController::class, "linkedIn_auth"]);
Route::get("linkedIn",[MainController::class, "linkedIn"]);
Route::get("linkedIn_multi",[MainController::class, "linkedIn_multi"]);


Route::post("update_social_session",[MainController::class, "update_social_session"]);

Route::get('inex',function(){
    return redirect("/");
});
Route::get('inex/{id}',function(){
    return redirect("/");
});
Route::get('cropper', function(){
    return view('cropper');
});
// END OF LINKEDIN

Route::get('doc',[MainController::class, "doc_token"]);

