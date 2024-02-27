@include('mail.header')
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="gradient pt-10" style="border-radius: 10px 10px 0 0; padding-top: 10px;" bgcolor="#004289">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td style="border-radius: 10px 10px 0 0;" bgcolor="#ffffff">
						<!-- Logo -->
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td class="img-center p-30 px-15" style="font-size:0pt; line-height:0pt; text-align:center; padding: 30px; padding-left: 15px; padding-right: 15px;">
									<a href="https://www.inex.net/" target="_blank"><img src="https://www.inex.net/logo.png" width="150" height="50" border="0" alt="" /></a>
								</td>
							</tr>
						</table>
						<!-- Logo -->

						<!-- Main -->
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td class="px-50 mpx-15" style="padding-left: 50px; padding-right: 50px;">
									<!-- Section - Intro -->
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td class="pb-50" style="padding-bottom: 50px;">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													@if($flag == 1)
														<tr>
															<td class="title-16 a-center pb-15" style="font-size:16px; line-height:40px; color:#282828; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; text-align:center; padding-bottom: 15px;">
																<strong>{{$primary->business_name}},</strong>
															</td>
														</tr>
														<tr>
															<td class="text-16 lh-26 a-center pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
																Dear {{$primary->user_name}},<br>
																If you remember, INEX uses a Trusted Agent Program.   Its purpose is to allow you to run your advertising campaigns without constant oversight by us.   Our software and business model is a Patent Pending program.  It truly is a unique business model.<br><br>
																You are your company’s Primary Trusted Agent.  As your account’s Primary Trusted Agent, you always receive an email notification regarding any addition or changes of any Secondary Trusted Agent.<br><br>
																{{$user->user_name}} has been assigned as a Trusted Agent.<br>
																A Secondary Trusted has all the rights for managing your account as you do.   We strongly advise that you create this position instead of ‘lending’ your email and password to access the site.    	Be advised that we track:<br>
																<ul>
																	<li>Every Ad uploaded to your account.</li>
																	<li>Every new Ad Campaigns. </li>
																	<li> The individual who performed these actions and when they did it.</li>
																</ul>
																By the way, We send a copy of all uploaded Ads and any new campaigns to you that they create – just so you know what is going on.<br>
																If you disagree or did not create this position, please contact us immediately.<br>
																@include('mail.contact-info')
															</td>
														</tr>
													@else
														<tr>
															<td class="title-16 a-center pb-15" style="font-size:16px; line-height:40px; color:#282828; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; text-align:center; padding-bottom: 15px;">
																<strong>{{$user->business_name}},</strong>
															</td>
														</tr>
														<tr>
															<td class="text-16 lh-26 a-center pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
																Dear {{$user->user_name}},<br>
																{{$primary->user_name}}  has created an account for you on www.inex.net.  You have now been designated a Trusted Agent. What does this mean?  It means you now can upload Ads, manage your playlist, deliver post to your social media, and create and run advertising campaigns – without oversight by INEX or an Account Manager.  You can do everything {{$primary->user_name}} can do online except create another Trusted Agent.<br>
																Your first step?  Set your password.  Once done, You can access the site and post to the billboards.<br>
																@if(isset($account_manager->id))
																In addition, we have assigned an Account Manager to help you.  Feel free to call on them.<br>
																{{$account_manager->user_name}}<br>
																{{$account_manager->email}}<br>
																{{$account_manager->phone}}<br>
																@endif

																Please use the link below to create your account password.<br>
															</td>
														</tr>
														<tr>
															<td align="center">
																<table border="0" cellspacing="0" cellpadding="0" style="min-width: 200px;">
																	<tr>
																		<td class="btn-16 c-white l-white" bgcolor="#004289" style="font-size:16px; line-height:20px; mso-padding-alt:15px 35px; font-family:'PT Sans', Arial, sans-serif; text-align:center; font-weight:bold; text-transform:uppercase; border-radius:25px; min-width:auto !important; color:#ffffff;">
																			<a href="https://www.inex.net/set/{{base64_encode($user->id)}}" target="_blank" class="link c-white" style="display: block; padding: 15px 35px; text-decoration:none; color:#ffffff;">
																				<span class="link c-white" style="text-decoration:none; color:#ffffff;">Set INEX Password</span>
																			</a>
																		</td>
																	</tr>
																</table>
															</td>
														</tr>
														<tr>
															<td class="text-16 lh-26 a-center pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
																We believe Job One is to help you increase your sales.<br>
																@include('mail.contact-info')
															</td>
														</tr>
													@endif
													
												</table>
											</td>
										</tr>
									</table>
									<!-- END Section - Intro -->
								</td>
							</tr>
						</table>
						<!-- END Main -->
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<!-- END Container -->
@include('mail.footer')
