@include('admin.include.admin-nomenu-header')
<link href="/assets/css/pages/wizard/wizard-1.css" rel="stylesheet" type="text/css"/>
<style>
    .btn-skip{
        display : none !important
    }
    .btn-hide{
        display : none !important
    }
    .btn-show{
        display : inline-block !important
    }
</style>
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader min-h-lg-15px pt-5 pb-7 subheader-transparent" id="kt_subheader">
		</div>
		<div class="d-flex flex-column-fluid">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="card card-custom">
                            <div class="card-body p-0">
                                <div class="wizard wizard-1" id="kt_wizard_v1" data-wizard-state="step-first" data-wizard-clickable="false">
                                    <div class="wizard-nav border-bottom">
                                        <div class="wizard-steps p-8 p-lg-10">
                                            <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                                                <div class="wizard-label">
                                                    <i class="wizard-icon la la-credit-card"></i>
                                                    <h3 class="wizard-title">1. Setup Billing</h3>
                                                </div>
                                                <span class="svg-icon svg-icon-xl wizard-arrow">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24"/>
                                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000) " x="11" y="5" width="2" height="14" rx="1"/>
                                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997) "/>
                                                        </g>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="wizard-step" data-wizard-type="step">
                                                <div class="wizard-label">
                                                    <i class="wizard-icon la la-user"></i>
                                                    <h3 class="wizard-title">2. Setup Secondary Trusted Agent (Optional)</h3>
                                                </div>
                                                <!-- <span class="svg-icon svg-icon-xl wizard-arrow">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24"/>
                                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000) " x="11" y="5" width="2" height="14" rx="1"/>
                                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997) "/>
                                                        </g>
                                                    </svg>
                                                </span> -->
                                            </div>
                                            <!-- <div class="wizard-step" data-wizard-type="step">
                                                <div class="wizard-label">
                                                    <i class="wizard-icon la la-twitter"></i>
                                                    <h3 class="wizard-title">3. Setup Social Media</h3>
                                                </div>
                                                <span class="svg-icon svg-icon-xl wizard-arrow">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24"/>
                                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000) " x="11" y="5" width="2" height="14" rx="1"/>
                                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997) "/>
                                                        </g>
                                                    </svg>                                                    
                                                </span>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="row justify-content-center my-10 px-8 my-lg-15 px-lg-10">
                                        <div class="col-xl-12 col-xxl-7">
                                            <form class="form" id="kt_form">
                                                <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                                                    <h3 class="mb-10 font-weight-bold text-dark">Setup Billing</h3>
                                                    <div class="form-group">
                                                        <label class="checkbox">
                                                            <input type="checkbox" class="usePrimary" name="usePrimary"/>
                                                            <span></span>
                                                            Use Primary Contact Information?
                                                        </label>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label>Billing Contact</label>
                                                            <input type="text" class="form-control name" name="bill_name" value="{{isset($business->bill_name)?$business->bill_name:''}}" required placeholder="Billing Contact"/>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Billing Contact Email</label>
                                                            <input type="email" class="form-control email" name="bill_email" value="{{isset($business->bill_email)?$business->bill_email:''}}" required placeholder="Billing Contact Email"/>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label>Industry Category</label>
                                                            <select class="form-control select2" id="kt_select2_1" name="category">
                                                                <option value=""></option>
                                                                @foreach($sic as $key => $val)
                                                                    <option value="{{$val->id}}">{{$val->sic_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Billing Contact Phone</label>
                                                            <input type="text" class="form-control phone"  name="bill_phone" value="{{isset($business->bill_phone)?$business->bill_phone:''}}" required placeholder="Billing Contact Phone"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="pb-5" data-wizard-type="step-content">
                                                    <h4 class="mb-10 font-weight-bold text-dark">Setup Trusted Agent</h4>
                                                    <div class="form-group">
                                                        <label>Real Name</label>
                                                        <input class="form-control" name="user_name" id="u_name" type="text" value="" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Email Address</label>
                                                        <input class="form-control" name="email" type="email" id='u_email' value="" required>
                                                    </div>
                                                </div>
                                                <!-- <div class="pb-5" data-wizard-type="step-content">
                                                    <h4 class="mb-10 font-weight-bold text-dark">Setup Social Media</h4>
                                                    <div class="form-group row mb-3">
                                                        <label class="col-form-label col-3 text-lg-right text-left">FaceBook Login</label>
                                                        <div class="col-9">
                                                            <div class="fb-login-button" scope="pages_manage_posts,public_profile,email" data-size="large" data-button-type="continue_with" data-layout="default" onlogin="checkLoginState();" data-auto-logout-link="false" data-use-continue-as="false" data-width=""></div>
                                                            <a class="btn btn-outline-<?php echo $s_avalialbe['facebook']=='true'?'success':'danger'?>" style="margin-top:-20px" id="f_comp">
                                                                <?php echo $s_avalialbe['facebook']=='true'?'Completed':'Not Linked'?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-form-label col-3 text-lg-right text-left"></label>
                                                        <div class="col-9">
                                                            <label class="checkbox checkbox-success">
                                                                <input type="checkbox" <?php echo $user->f_account==0?'checked':''?> value="f_account" name="Checkboxes5"/>
                                                                <span></span>
                                                                I have a Facebook account
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-3">
                                                        <label class="col-form-label col-3 text-lg-right text-left">LinkedIn Login</label>
                                                        <div class="col-9">
                                                        <?php 
                                                            $state = substr(str_shuffle("0123456789abcHGFRlki"), 0, 10);
                                                        ?>
                                                            <a id="linkedin-button" href="https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=78x70swk6qchrs&redirect_uri=https://inex.net/linkedIn&scope=r_emailaddress,r_liteprofile,w_member_social&state={{$state}}" class="btn btn-success btn-social btn-linkedin" style="width:247px;font-size:16px;font-weight:1000;color:white">
                                                                <i class="socicon-linkedin"></i> Sign in with LinkedIn
                                                            </a>
                                                            <a class="btn btn-outline-<?php echo $s_avalialbe['linkedin']=='true'?'success':'danger'?>" style="" id="l_comp">
                                                                <?php echo $s_avalialbe['linkedin']=='true'?'Completed':'Not Linked'?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-form-label col-3 text-lg-right text-left"></label>
                                                        <div class="col-9">
                                                            <label class="checkbox checkbox-success">
                                                                <input type="checkbox" <?php echo $user->l_account==0?'checked':''?> value='l_account' name="Checkboxes5"/>
                                                                <span></span>
                                                                I have a LinkedIn account
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <script type="IN/Login" data-onAuth="onLinkedInAuth"></script>
                                                    <div class="form-group row mb-3">
                                                        <label class="col-form-label col-3 text-lg-right text-left">Twitter Login</label>
                                                        <div class="col-9">
                                                            <a id="twitter-button" href="/redirect" class="btn btn-danger btn-social btn-twitter" style="width:247px;font-size:16px;font-weight:1000;color:white">
                                                                <i class="socicon-twitter"></i> Sign in with Twitter
                                                            </a>
                                                            <a class="btn btn-outline-<?php echo $s_avalialbe['twitter']!=null?'success':'danger'?>" style="" id="t_comp">
                                                                <?php echo $s_avalialbe['twitter']!=null?'Completed':'Not Linked'?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-form-label col-3 text-lg-right text-left"></label>
                                                        <div class="col-9">
                                                            <label class="checkbox checkbox-success">
                                                                <input type="checkbox" <?php echo $user->t_account==0?'checked':''?> value="t_account" name="Checkboxes5"/>
                                                                <span></span>
                                                                I have a Twitter account
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                                    <div class="mr-2">
                                                        <button type="button" class="btn btn-light-primary font-weight-bold text-uppercase px-9 py-4" data-wizard-type="action-prev">
                                                        Previous
                                                        </button>
                                                    </div>
                                                    <div>
                                                        <button type="submit" class="btn btn-success font-weight-bold text-uppercase px-9 py-4 form-submit" data-wizard-type="action-submit">
                                                        Complete Account Setup
                                                        </button>
                                                        <button type="button" class="btn btn-primary font-weight-bold text-uppercase px-9 py-4" data-wizard-type="action-next">
                                                        Next
                                                        </button>
                                                        <button type="button" class="btn btn-success btn-skip font-weight-bold text-uppercase px-9 py-4" data-wizard-type="action-next">
                                                        Skip
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
    <button type="button" class="btn btn-primary btn-welcome" style="display:none" data-toggle="modal" data-target="#welcomeModal"></button>
    <div class="modal fade" id="welcomeModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="welcomeModal" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fas fa-user-circle icon-10x p-5"></i>
                        <h2 class="p-3">{{session('user_name')}}</h2>
                        <h4 class="pb-5 text-dark-60">{{session('email')}}</h4>
                    </div>
                    <button class="btn btn-success c-con btn-block" data-dismiss="modal">Continue with this user</button>
                    <div class='text-center mt-5'>
                        <a href="/register" class="text-center text-dark">Create account with a new user</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-primary btn-init" style="display:none" data-toggle="modal" data-target="#initModal"></button>
    <div class="modal fade" id="initModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="initModal" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title text-white"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-left">
                        <h4 class="text-white fc-text"></h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @include("admin.include.admin-footer")

    <script>var HOST_URL = "https://keenthemes.com/metronic/tools/preview";</script>
    <script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
    <script src="/assets/plugins/global/plugins.bundle.js"></script>
    <script src="/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
    <script src="/js/suggest.js"></script>
    <script src="/assets/js/scripts.bundle.js"></script>
    <script src="/js/welcome.js"></script>
    <script async defer src="https://connect.facebook.net/en_US/sdk.js"></script>
    <script>
        var checkbox = document.getElementsByName("Checkboxes5");
        $(checkbox).each(function(){
            $(this).on('change', function(){
                $.ajax({
                    url : 'update_social',
                    type : 'POST',
                    data : {
                        user_id : "{{session('user_id')}}",
                        field : $(this).val(),
                        status : $(this).prop('checked')
                    },
                    headers : {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success : function(res){
                        toastr.success("Success!");
                    },
                    error: function(res){
                        location.reload();
                    }
                })
            })
        })
        function statusChangeCallback(response) {  // Called with the results from FB.getLoginStatus().
            if (response.status === 'connected') {   // Logged into your webpage and Facebook.
            testAPI(response);  
            } else {                                 // Not logged into your webpage or we are unable to tell.
                // document.getElementById('status').innerHTML = 'Please log ' +
                // 	'into this webpage.';
                console.log('fail');
            }
        }
        function checkLoginState() { 
            FB.getLoginStatus(function(response) { 
            statusChangeCallback(response);
            });
        }
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '{{isset($social->f_id)?$social->f_id:''}}',
                cookie     : false,
                xfbml      : true,
                version    : 'v7.0'
            });
            FB.getLoginStatus(function(response) {
                statusChangeCallback(response);
            });
        };
        (function(d, s, id) {                      // Load the SDK asynchronously
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        
        function testAPI(response) {
            var short_live = response.authResponse.accessToken;
            var user_id = response.authResponse.userID;
            // console.log(short_live);
            // console.log(user_id);
            // FB.api("/oauth/access_token?grant_type=fb_exchange_token&client_id={{isset($social->f_id)?$social->f_id:''}}&client_secret={{isset($social->f_sec)?$social->f_sec:''}}&fb_exchange_token="+short_live), function(res){
            // 	console.log(res);
            // });
            $.ajax({
                url : "/f_token",
                type : "POST",
                data : {
                    short_live : short_live,
                    user_id : "{{session('user_id')}}"
                },
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success : function(res){
                    if(res == "fail"){
                        toastr.error("Fail To Facekbook Login!");
                    }
                }
            })
            FB.api('/me', function(response) {
                console.log(response);
            });
        }

    </script>
    <script>
        var steps = [];
        fc = [
                "Thank you for joining INEX.   Let's complete your account setup.  This will take very little time.",
                "You are already desigated as the Primary Trusted Agent for your business. You may designate someone else to manage your advertising. They are considered Secondary Trusted Agents.They can post anything to the billboards like you.",
                "You can Post a copy of any one of your Ads plus any text you wish to include simultaneously to all your social media accounts. It also gets posted to our other clients’ social media accounts. Just setup up link once here if you wish to multiply your advertising reach.",
            ]
        sessionStorage.setItem("param1", "Hello");
        function submit_form(){
            var fs = new FormData(document.getElementById("kt_form"));
            KTApp.blockPage();
            $.ajax({
                url : "/save-welcome",
                type : "POST",
                data : fs,
                contentType : false,
                processData : false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success : function(res){
                    KTApp.unblockPage();
                    if(res['success'] == true){
                        location.href = res['redirect'];
                    }
                    else{
                        toastr.error(res)
                    }
                },
                error : function(err){
                    KTApp.unblockPage();
                    toastr.error("Please refresh your browser");
                }
            })
        }
        $(document).ready(function(){
            $(".form-submit").on('click', function(event){
                event.preventDefault();
                submit_form();
            })
            $(".usePrimary").on('change', function(){
                if($(this).prop('checked') == true){
                    $.ajax({
                        url : '/get_primary_info',
                        type : "GET",
                        success : function(res){
                            if(res['name'] != undefined){
                                $(".name").val(res['name'])
                                $(".email").val(res['email'])
                                $(".phone").val(res['phone'])
                            }
                        }
                    })
                }
            })
            if(sessionStorage.getItem("param1") == null){
                $(".btn-welcome").click();
                $(".c-con").click(function(){
                    $(".fc-text").text(fc[0])
                    $(".btn-init").click();
                })
            }
            else{
            $(".fc-text").text(fc[0])
                $(".btn-init").click();
            }
            $('#kt_select2_1').select2({
                placeholder: "Select a category"
            });
            $('.phone').inputmask("mask", {
                "mask": "(999) 999-9999"
            });
        })
    </script>