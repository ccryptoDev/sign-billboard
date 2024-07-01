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
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td class="px-50 mpx-15" style="padding-left: 50px; padding-right: 50px;">
									<!-- Section - Intro -->
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td class="pb-50" style="padding-bottom: 50px;">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
                                                        <td class="title-20 pb-10" style="font-size:20px; line-height:24px; color:#282828; font-family:'PT Sans', Arial, sans-serif; text-align:center; min-width:auto !important; padding-bottom: 10px;">
															<strong>{{$user->business_name}}</strong>
														</td>
													</tr>
													<tr>
														<td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
															Dear {{isset($business->bill_name)?$business->bill_name:$user->user_name}},<br><br>
                                                            Thank you for your payment.<br>
                                                            We thank you for your business.<br><br>
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
