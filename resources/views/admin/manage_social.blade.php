@include('admin.include.admin-header')
                    
	<style>
		@media(max-width:768px){
			#f_comp{
				margin-top:0px !important;
			}
		}
	</style>
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<!--begin::Subheader-->
		<div class="subheader min-h-lg-15px pt-5 pb-7 subheader-transparent" id="kt_subheader">
		</div>
		<div class="d-flex flex-column-fluid">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="card card-custom" data-card="true" id="kt_card_1">
							<div class="card-header">
								<div class="card-title">
									<h3 class="card-label">{{$page_name}}</h3>
								</div>
							</div>
							<div class="card-body">
								<form id="user_reg">
									<div class="row">
										<div class="col-xl-2"></div>
										<div class="col-xl-7 my-2">
											<?php 
											if(session('level') == 2){
											?>
                                            <div class="form-group row">
                                                <span>Link your INEX account to your social media account(s). After Publishing your Playlist to the digital sign(s), you can deliver the new Ad to your social media accounts, accompanied by any text you wish to include. In addition, the ads also go to ALL of our other clients.</span>
                                            </div>
											<div class="form-group row">
												<label class="col-form-label col-3 text-lg-right text-left">Select Users</label>
												<div class="col-9">
													<select class="form-control selectpicker" data-live-search="true" data-size="5" id="social_user">
														<option value="">Please Select Users</option>
                                                        <?php
														foreach($users as $temp_user){
														?>
														<option value="<?php echo $temp_user->id?>">{{$temp_user->user_name}} : {{$temp_user->business_name}}</option>
														<?php }?>
													</select>
												</div>
											</div>
											<?php }?>
                                            <?php 
                                                $get_temp = false;
                                                if(session('level') !=2 && count($multi) > 0){
                                                    $get_temp = true;
                                                ?>
                                                    <div class="form-group row">
                                                        <label class="col-form-label col-3 text-lg-right text-left">Select Users</label>
                                                        <div class="col-9">
                                                            <?php 
                                                                $business_name_list = array();
                                                                foreach($multi as $bus_temp){
                                                                    if($bus_temp->multi_id == null){
                                                                        array_push($business_name_list,$bus_temp->business_name);
                                                                    }
                                                                    else{
                                                                        array_push($business_name_list,$bus_temp->com_name);
                                                                    } 
                                                                }
                                                            ?>
                                                            <select class="form-control selectpicker" data-live-search="true" data-size="5" id="social_user">
                                                                <option value="">Please Select Users</option>
                                                                <?php
                                                                foreach($users as $temp_user){
                                                                    if(in_array($temp_user->business_name,$business_name_list)){
                                                                ?>
                                                                <option value="<?php echo $temp_user->id?>">{{$temp_user->user_name}} : {{$temp_user->business_name}}</option>
                                                                <?php } }?>
                                                            </select>
                                                        </select>
                                                    </div>
                                                </div>
                                                <?php }?>
                                            <div class="form-group">
                                                <span class="col-form-label col-md-3 text-lg-right text-left">Deliver your Ads and any text you wish to add to your social media accounts by setting your links here.</span>
                                            </div>
											<div class="form-group row mb-3">
												<label class="col-form-label col-3 text-lg-right text-left">FaceBook Login</label>
												<div class="col-9">
													<!-- <fb:login-button scope="public_profile,email" data-size="large" onlogin="checkLoginState();"></fb:login-button> -->
													<div class="fb-login-button" scope="pages_manage_posts,public_profile,email" data-size="large" data-button-type="continue_with" data-layout="default" onlogin="checkLoginState();" data-auto-logout-link="false" data-use-continue-as="false" data-width=""></div>
													<a class="btn btn-outline-success" style="display:none;margin-top:-20px" id="f_comp">Completed</a>
												</div>
											</div>
                                            <div class="form-group row mb-0">
                                                <label class="col-form-label col-3 text-lg-right text-left"></label>
                                                <div class="col-9">
                                                    <label class="checkbox checkbox-success">
                                                        <input type="checkbox" value='f_account' id='f_account' name="Checkboxes5"/>
                                                        <span></span>
                                                        I have a FaceBook account
                                                    </label>
                                                </div>
                                            </div>
											<div class="form-group row mb-3">
												<label class="col-form-label col-3 text-lg-right text-left">LinkedIn Login</label>
												<div class="col-9">
												<?php 
													$state = substr(str_shuffle("0123456789abcHGFRlki"), 0, 10);
												?>
													<a id="linkedin-button" href="https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=78x70swk6qchrs&redirect_uri={{config('app.url')}}/linkedIn_multi&scope=r_emailaddress,r_liteprofile,w_member_social&state={{$state}}" class="btn btn-success btn-social btn-linkedin" style="width:247px;font-size:16px;font-weight:1000;color:white">
														<i class="socicon-linkedin"></i> Sign in with LinkedIn
													</a>
													<a class="btn btn-outline-success" style="display:none" id="l_comp">Completed</a>
												</div>
											</div>
                                            <div class="form-group row mb-0">
                                                <label class="col-form-label col-3 text-lg-right text-left"></label>
                                                <div class="col-9">
                                                    <label class="checkbox checkbox-success">
                                                        <input type="checkbox" value='l_account' id='l_account' name="Checkboxes5"/>
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
													<a class="btn btn-outline-success" style="display:none" id="t_comp">Completed</a>
												</div>
											</div>
                                            <div class="form-group row mb-0">
                                                <label class="col-form-label col-3 text-lg-right text-left"></label>
                                                <div class="col-9">
                                                    <label class="checkbox checkbox-success">
                                                        <input type="checkbox" value='t_account' id='t_account' name="Checkboxes5"/>
                                                        <span></span>
                                                        I have a Twitter account
                                                    </label>
                                                </div>
                                            </div>
                                            <span>If you do not have a particular social media account, please uncheck it so that you will not get reminders to sign up.</span>
										</div>
									</div>
								</div>
								<div class="card-footer">
									<!-- <button type="submit" class="btn btn-success mr-2" style="float:right">UPDATE</button> -->
								</div>
							</form>
						</div>
					</div>
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
    <script src="/assets/js/pages/custom/user/edit-user.js?v=7.0.4"></script>
    <script async defer src="https://connect.facebook.net/en_US/sdk.js"></script>
    
    <script>
        var user_id = '';
        $(document).ready(function(){
            // get_social_status();
            var checkbox = document.getElementsByName("Checkboxes5");
            function uncheck(){
                $(checkbox).each(function(){
                    $(this).prop("checked",false);   
                })
            }
            user_id = $("#social_user").val();


            $(checkbox).each(function(){
				$(this).on('change', function(){
                    if(user_id == ""){
                        return;
                    }
					$.ajax({
						url : 'update_social',
						type : 'POST',
						data : {
							user_id : user_id,
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
            get_social_status(user_id);
            function get_social_status(id){
                $.ajax({
                    url : '/get_social_status',
                    type : "post",
                    data : { 
                        id : id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success : function(res){
                        var res = JSON.parse(res);
                        // FB.api('/me', function(response) {
                        //     console.log(response);
                        // });
                        if(id == ''){
                            $("#f_comp").css("display",'none');
                            $("#l_comp").css("display",'none');
                            $("#t_comp").css("display",'none');
                            uncheck();
                        }
                        else{
                            if(res['f_account'] == 1){
                                $("#f_account").prop("checked",false);
                            }
                            else{
                                $("#f_account").prop("checked",true);
                            }
                            if(res['l_account'] == 1){
                                $("#l_account").prop("checked",false);
                            }
                            else{
                                $("#l_account").prop("checked",true);
                            }
                            if(res['t_account'] == 1){
                                $("#t_account").prop("checked",false);
                            }
                            else{
                                $("#t_account").prop("checked",true);
                            }
                            if(res['f_token'] != null && res['f_token'] != ''){
                                $("#f_comp").text('Completed');
                                $("#f_comp")[0].className = "btn btn-outline-success";
                                $("#f_comp").css("display",'inline-block');
                            }
                            else{
                                $("#f_comp").text('Not Linked');
                                $("#f_comp")[0].className = "btn btn-outline-danger";
                                $("#f_comp").css("display",'inline-block');
                            }
                            if(res['l_token'] != null && res['l_token'] != ''){
                                $("#l_comp").text('Completed');
                                $("#l_comp")[0].className = "btn btn-outline-success";
                                $("#l_comp").css("display",'inline-block');
                            }
                            else{
                                $("#l_comp").text('Not Linked');
                                $("#l_comp")[0].className = "btn btn-outline-danger";
                                $("#l_comp").css("display",'inline-block');
                            }
                            if(res['t_token'] != null && res['t_token'] != ''){
                                $("#t_comp").text('Completed');
                                $("#t_comp")[0].className = "btn btn-outline-success";
                                $("#t_comp").css("display",'inline-block');
                            }
                            else{
                                $("#t_comp").text('Not Linked');
                                $("#t_comp")[0].className = "btn btn-outline-danger";
                                $("#t_comp").css("display",'inline-block');
                            }
                        }
                    },
                    error : function(res){
                        location.reload();
                    }
                })
            }
            $("#social_user").on('change',function(){
                user_id = $(this).val();
                get_social_status($(this).val());
                $.ajax({
                    url : "update_social_session",
                    type : "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data : {
                        user_id : user_id
                    },
                    success : function(res){
                    }
                })
            })
        });
        

        function statusChangeCallback(response) {  // Called with the results from FB.getLoginStatus().
            if (response.status === 'connected') {   // Logged into your webpage and Facebook.
            testAPI(response);  
            } else {                                 // Not logged into your webpage or we are unable to tell.
                // document.getElementById('status').innerHTML = 'Please log ' +
                //     'into this webpage.';
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
            var f_user_id = response.authResponse.userID;
            $.ajax({
                url : "/f_token",
                type : "POST",
                data : {
                    short_live : short_live,
                    user_id : user_id
                },
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success : function(res){
                    if(res =='success'){
                    }

                    if(res =='fail'){
                        toastr.error("Fail To Facekbook Login!");
                    }
                }
            })
            FB.api('/me', function(response) {
                console.log(response);
            });
            // FB.api('/me', function(response) {
            //     console.log(response);
            // });
        }

    </script>
	</body>
</html>
		