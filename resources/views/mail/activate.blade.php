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
															Dear {{$user->user_name}}, <br><br>
															INEX has activated your account.  We are so gratified with you joining us.  Thank you.<br><br>
                                                            You have now been designated a Trusted Agent.  This status allows you to upload and display without any oversight by INEX.   Once again, this approach is very different than other outdoor advertising agencies. <br><br>
                                                            <ul>
																<li>You have absolute control over your own advertising.</li>
																<li>Upload any number of Ads.  You can even set individual Ads to be displayed a very specific times and days (such as between 2 PM and 4 PM on Thursdays if your wish).</li>
																<li>Ads will automatically be dropped into your Playlist.</li>
																<li>Choose which Ads will be sent to the Billboard and have them displayed on INEX billboards in minutes.</li>
																<li>Create your Campaign when it starts, how long it lasts, where you want to display it.</li>
																<li>Purchase your Campaign and you are set!</li>
															</ul>
															
															Once again, remember that your account is free.   Even though you are now a Trusted Agent, you are never required to purchase any advertising slots at any time (though of course we hope you do.<br><br><br>
                                                            We are here to help make sure you get the results you expect from your advertising, so don’t hesitate to reach out with questions. Let us know how we can help.<br><br>
															You should receive an email shortly regarding your Password setup and your Account Manager.<br><br>
															If you need support, you can reply to this email or give us a call at <a href="tel:405415-3002">(405) 415-3002</a>.  We can talk you through the details and information you need to get started on the right foot.<br><br>
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
