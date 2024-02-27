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
															Dear {{$user->bill_name}},<br><br>
															Thank you for using INEX’s Patent Pending, unique approach to digital billboard advertising.<br><br>
                                                            We delivered your advertisements on our billboard(s) as requested.   <br><br>
                                                            It has now been 60 days since the start date of your advertising campaign.  Your invoice is attached.<br><br>
                                                            It is due immediately.<br><br>
                                                            We thank you for your continued support of our business – which is designed to increase your brand awareness, drive people to your web site or store front, or let your customers know about any sales or promotions you are running.<br><br>
															Remember that only Billboard advertising reaches a broad spectrum of people.  Compare that comprehensive approach to the narrow market reach of social media, cable television, focused radio markets.   We can’t be blocked.   Everyone sees your Ads.<br><br>
                                                            Thank you again for your business.<br><br>
                                                            
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
