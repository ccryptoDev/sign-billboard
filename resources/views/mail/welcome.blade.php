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
									<a href="https://www.inexsigns.net/" target="_blank"><img src="https://www.inexsigns.net/logo.png" width="150" height="50" border="0" alt="" /></a>
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
													<tr>
														<td class="title-16 a-center pb-15" style="font-size:16px; line-height:40px; color:#282828; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; text-align:center; padding-bottom: 15px;">
															<strong>{{$user->business_name}}</strong>
														</td>
													</tr>
													<tr>
														<td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
                                                            Dear {{$user->user_name}},<br><br>
															We truly appreciate you registering to join our growing network of advertisers.<br><br>
                                                            INEX has a Trusted Agent Program.  A Trusted Agent may upload and display its advertisements without any oversight by INEX.   Given that, please understand that INEX cannot afford to have individuals upload unsuitable material for the public to see.   So please bear with us as we establish that you are a bona fide business.  It will not take long.<br><br>
                                                            This approach is very different than other outdoor advertising agencies.  Once you have been established as a Trusted Agent, you have absolute control over your advertising.<br><br>
															Once we have established you as a great business, you will receive two emails:<br>
															<ul>
																<li>Activation Notification – Basically states that your account is approved.   It will outline what is your next step.</li>
																<li>Initial Password Setup – The second email allows you to setup your password.  It will also inform you who is your Account Manager and provide their contact information. They should be talking with you shortly.</li>
															</ul>
                                                            In the meantime, you can always use our demo account to see how this all works.  Just go to <a href="https://www.inexsigns.net">www.inexsigns.net</a>. Click Login and enter demo@inex.net and ‘demo’ as the password.<br><br>
                                                            <ul>
																<li>Remember that your Trusted Agent account is free. </li>
																<li>You are never required to purchase any advertising slots at any time.</li>
																<li>We will walk you through what exactly to do next. </li>
                                                            We are here to help make sure you get the results you expect from your advertising, so don’t hesitate to reach out with questions. We’d love to hear from you.<br><br>
															If you need support, you can reply to this email or give us a call at <a href="tel:405415-3002">(405) 415-3002</a>.  We can talk you through the details and information you need to get started on the right foot.<br><br>
                                                            Looking forward to hearing from you,<br><br>
                                                            @include('mail.contact-info')
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
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
