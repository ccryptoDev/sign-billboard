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
																Per your request, we have sent a Password Reset link to your registered email address.  <br><br>
																This link is valid for 24 hours.  <br>
															</td>
														</tr>
														<tr>
															<td align="center">
																<table border="0" cellspacing="0" cellpadding="0" style="min-width: 200px;">
																	<tr>
																		<td class="btn-16 c-white l-white" bgcolor="#004289" style="font-size:16px; line-height:20px; mso-padding-alt:15px 35px; font-family:'PT Sans', Arial, sans-serif; text-align:center; font-weight:bold; text-transform:uppercase; border-radius:25px; min-width:auto !important; color:#ffffff;">
																			<a href="https://www.inexsigns.net/reset/{{base64_encode($id)}}" target="_blank" class="link c-white" style="display: block; padding: 15px 35px; text-decoration:none; color:#ffffff;">
																				<span class="link c-white" style="text-decoration:none; color:#ffffff;">Set INEX Password</span>
																			</a>
																		</td>
																	</tr>
																</table>
															</td>
														</tr>
														<tr>
															<td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
																<br>
																If you did not request this password reset, please contact us immediately by email at <a href="mailto:support@inex.net">support@inex.net</a> or call us directly at <a href="tel:405-415-3002">405-415-3002.</a><br><br>
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