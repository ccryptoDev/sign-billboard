@include('admin.include.admin-header')
                    
	<style>
		@media(max-width:768px){
			#f_comp{
				margin-top:0px !important;
			}
		}
	</style>
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader min-h-lg-15px pt-5 pb-7 subheader-transparent" id="kt_subheader">
		</div>
		<div class="d-flex flex-column-fluid">
			<div class="container">
                <div class="alert alert-custom alert-white alert-shadow fade show gutter-b" role="alert">
                    <div class="alert-icon">
                        <span class="svg-icon svg-icon-primary svg-icon-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <path d="M7.07744993,12.3040451 C7.72444571,13.0716094 8.54044565,13.6920474 9.46808594,14.1079953 L5,23 L4.5,18 L7.07744993,12.3040451 Z M14.5865511,14.2597864 C15.5319561,13.9019016 16.375416,13.3366121 17.0614026,12.6194459 L19.5,18 L19,23 L14.5865511,14.2597864 Z M12,3.55271368e-14 C12.8284271,3.53749572e-14 13.5,0.671572875 13.5,1.5 L13.5,4 L10.5,4 L10.5,1.5 C10.5,0.671572875 11.1715729,3.56793164e-14 12,3.55271368e-14 Z" fill="#000000" opacity="0.3"/>
                                    <path d="M12,10 C13.1045695,10 14,9.1045695 14,8 C14,6.8954305 13.1045695,6 12,6 C10.8954305,6 10,6.8954305 10,8 C10,9.1045695 10.8954305,10 12,10 Z M12,13 C9.23857625,13 7,10.7614237 7,8 C7,5.23857625 9.23857625,3 12,3 C14.7614237,3 17,5.23857625 17,8 C17,10.7614237 14.7614237,13 12,13 Z" fill="#000000" fill-rule="nonzero"/>
                                </g>
                            </svg>
                        </span>
                    </div>
                    <div class="alert-text">
                        <ul>
                            <li><h4>Click on each social media account you own to set connection.</h4></li>
                            <li><h4>Uncheck any social media you do not own.</h4></li>
                            <li><h4>After Publishing your Playlist, you can deliver the new Ad to your social media accounts.</h4></li>
                        </ul>
                    </div>
                </div>
				<div class="row">
					<div class="col-lg-12">
						<div class="card card-custom" data-card="true" id="kt_card_1">
							<div class="card-header">
								<div class="card-title">
									<h3 class="card-label">{{$page_name}} - {{session("business_name")}}</h3>
								</div>
							</div>
							<div class="card-body">
								<form id="user_reg">
									<div class="row">
										<div class="col-xl-2"></div>
										<div class="col-xl-7 my-2">
                                            <div class="form-group row">
                                                <span>Link your INEX account to your social media account(s). After Publishing your Playlist to the digital sign(s), you can deliver the new Ad to your social media accounts, accompanied by any text you wish to include. In addition, the ads also go to ALL of our other clients.</span>
                                            </div>
											<div class="form-group row mb-3">
												<label class="col-form-label col-3 text-lg-right text-left">FaceBook Login</label>
												<div class="col-9">
													<!-- <fb:login-button scope="public_profile,email" data-size="large" onlogin="checkLoginState();"></fb:login-button> -->
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
													<!-- <a href="https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=78x70swk6qchrs&redirect_uri=https://inex.net/linkedIn&scope=r_emailaddress,r_liteprofile,w_member_social&state={{$state}}">LOINKEDIN</a> -->
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
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<!--end::Row-->
			</div>
			<!--end::Container-->
		</div>
		<!--end::Entry-->
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
	</body>
</html>
		