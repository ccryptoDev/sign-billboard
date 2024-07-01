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
																<strong>{{isset($user->business_name)?$user->business_name:''}}</strong>
															</td>
														</tr>
														<tr>
															<td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
																Dear {{$user->user_name}},<br><br>
																We truly appreciate your business.   We hope you have found our services superior to other advertising companies.<br><br>
																Even though you know our patent pending program is very unique, we are a small business trying to grow just like you. <br>
                                                                <ul>
                                                                    <li>We started this business in Oklahoma.</li> 
                                                                    <li>We are a family-owned and Veteran business.</li>  
                                                                    <li>We believe we have provided a far superior product over our competitors.   </li> 
                                                                    <li>We know our automation is a radical idea – making it so easy for you, the client, to change your advertising in just minutes.</li> 
                                                                    <li>We know our approach makes advertising well within the budget of almost every business – Billboard advertising is not just for the big companies anymore.</li> 
                                                                    <li>Our unique approach allows you to use digital billboards to drive impulse buying – a capability never used before because no one allowed you to change Ads in minutes.</li> 
                                                                </ul>
                                                                But for us to grow like you, that means INEX needs your review<br>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center">
                                                                <table border="0" cellspacing="0" cellpadding="0" style="min-width: 200px;">
                                                                    <tr>
                                                                        <td class="btn-16 c-white l-white" bgcolor="#004289" style="font-size:16px; line-height:20px; mso-padding-alt:15px 35px; font-family:'PT Sans', Arial, sans-serif; text-align:center; font-weight:bold; text-transform:uppercase; border-radius:25px; min-width:auto !important; color:#ffffff;">
                                                                            <a href="https://g.page/r/CalqxUYJd-yuEA0/review" target="_blank" class="link c-white" style="display: block; padding: 15px 35px; text-decoration:none; color:#ffffff;">
                                                                                <span class="link c-white" style="text-decoration:none; color:#ffffff;">Review INEX on Google</span>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
															<td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
                                                                We offer a chance for $50 off your next campaign for your Google Review.<br>
                                                                If, for some reason, you had any issue with our service, our people, or our execution, please contact Rusty Latenser directly at latenser@inex.net.   He will do his best to address your concerns.  If you have suggestions for what we can add to our product, please let me know that too!<br>
                                                                We look forward to talking with you again…and we hope – soon!<br>
                                                                @include('mail.contact-info')
															</td>
														</tr>
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
@include('mail.footer')