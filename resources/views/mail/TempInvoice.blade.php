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
													<tr>
                                                        <td class="title-20 pb-10" style="font-size:20px; line-height:24px; color:#282828; font-family:'PT Sans', Arial, sans-serif; text-align:center; min-width:auto !important; padding-bottom: 10px;">
															<strong>Hello, {{$user->business_name}}</strong>
														</td>
													</tr>
                                                    @if(isset($campaign->free_plan) && $campaign->free_plan == 3))
														<tr>
															<td class="text-16 lh-26 a-center pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
																Dear {{$user->bill_name}},<br><br>
																Per the request of your Account Manager, we had temporarily set your advertising campaign to run as scheduled even though we have not received your payment.  This temporary override lasted for seven days.<br><br>
																Since we have not received payment, the campaign automatically is suspended.    Please understand this temporary week of advertising was not free.  <br><br>
																We have attached a copy of your planned campaign invoice.  Please remit payment immediately.  Once we receive payment, your campaign will automatically restart.    If you do not plan to restart your campaign, please notify your Account Manager or email us at sales@inex.net.   We will revise your invoice to cover the week of advertising we provided.<br><br>
															</td>
														</tr>
														<tr>
															<td align="center">
																<table border="0" cellspacing="0" cellpadding="0" style="min-width: 200px;">
																	<tr>
																		<td class="btn-16 c-white l-white" bgcolor="#004289" style="font-size:16px; line-height:20px; mso-padding-alt:15px 35px; font-family:'PT Sans', Arial, sans-serif; text-align:center; font-weight:bold; text-transform:uppercase; border-radius:25px; min-width:auto !important; color:#ffffff;">
																			<a href="https://www.inex.net/pay-invoice/{{base64_encode($campaign->id)}}" target="_blank" class="link c-white" style="display: block; padding: 15px 35px; text-decoration:none; color:#ffffff;">
																				<span class="link c-white" style="text-decoration:none; color:#ffffff;">Pay by Credit Card</span>
																			</a>
																		</td>
																	</tr>
																</table>
															</td>
														</tr>
														<tr>
															<td class="text-16 lh-26 a-center pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
																<br>If you need more help, please don’t hesitate to call on us.<br><br>
																Thank you again for using INEX and our innovative advertising approach.<br><br>
																@include('mail.contact-info')
															</td>
														</tr>
                                                    @else
														<tr>
															<td class="text-16 lh-26 a-center pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
																Dear {{$user->bill_name}},<br><br>
																Per the request of your Account Manager, we have temporarily set your advertising campaign to run as scheduled even though we have not received your payment.  This temporary override will last for seven days.  If we have no payment by then, the campaign automatically is suspended.    Please understand this temporary week of advertising is not free.<br><br>
																We realize the multiple reasons why this event might have occurred.  The important point is we will adjust our system to ensure your advertising campaign continues as scheduled to cover this little delay.<br><br>
																We have attached a copy of your invoice.  Please remit payment.<br>
																If you wish to pay immediately online:  <br>
															</td>
														</tr>
														<tr>
															<td align="center">
																<table border="0" cellspacing="0" cellpadding="0" style="min-width: 200px;">
																	<tr>
																		<td class="btn-16 c-white l-white" bgcolor="#004289" style="font-size:16px; line-height:20px; mso-padding-alt:15px 35px; font-family:'PT Sans', Arial, sans-serif; text-align:center; font-weight:bold; text-transform:uppercase; border-radius:25px; min-width:auto !important; color:#ffffff;">
																			@if(isset($campaign->id))
																				<a href="https://www.inex.net/pay-invoice/{{base64_encode($campaign->id)}}" target="_blank" class="link c-white" style="display: block; padding: 15px 35px; text-decoration:none; color:#ffffff;">
																					<span class="link c-white" style="text-decoration:none; color:#ffffff;">Pay by Credit Card</span>
																				</a>
																			@else
																				<a href="https://www.inex.net/pay-invoice-ach/{{base64_encode($invoice->id)}}" target="_blank" class="link c-white" style="display: block; padding: 15px 35px; text-decoration:none; color:#ffffff;">
																					<span class="link c-white" style="text-decoration:none; color:#ffffff;">Pay by Credit Card</span>
																				</a>
																			@endif
																		</td>
																	</tr>
																</table>
															</td>
														</tr>
														<tr>
															<td class="text-16 lh-26 a-center pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
																<br>
																If our system caused this issue, we apologize.  If you need more help, please don’t hesitate to call on us.<br><br>
																Thank you again for using INEX and our innovative advertising approach.<br><br>
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
