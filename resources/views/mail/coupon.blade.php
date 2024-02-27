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
                                                        <td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
															<strong>{{$user->business_name}},</strong>
														</td>
													</tr>
                                                    <?php
                                                    $created = date_create($coupon->start_date);
                                                    $ended = date_create($coupon->end_date);
													$weeks = $coupon->type==0?$coupon->weeks:'';
													$coupon_text = "";
													if($coupon->type != 0){
														$dates = range(strtotime($coupon->start_date), strtotime($coupon->end_date),604800);
														$weeks = array_map(function($v){return date('W', $v);}, $dates);
													}
													if($coupon->type == 1){
														$coupon_text = "$".number_format($coupon->amount, 2)."";
													}
													else if($coupon->type == 2){
														$coupon_text = "%".$coupon->amount." discount off your next purchase";
													}
													$coupon_num = 10000000 + $coupon->id;
                                                    ?>
													@if($type == 0)
                                                    <tr>
                                                        <td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
															Dear {{$user->user_name}},
															Thank you for your continued interest in INEX’s unique approach to digital billboard advertising.<br>
															Your Account Manager, {{$accounter->user_name}}, has provided you a great discount. This coupon provides you with {{$weeks}} week(s) of free advertising {{$coupon_text}}.   It is valid from {{date_format($created, "m-d-Y")}} to  {{date_format($ended, "m-d-Y")}}.<br><br>
                                                            This Coupon, #{{$coupon_num}} is already in place for your use.  It will be employed automatically the next time you create an advertising Campaign.  You do not need to remember or keep this information.  <br><br>
                                                            We thank you for your continued support of our business – which is designed to increase your brand awareness, drive people to your web site or store, or let your customers know about any sales or promotions you are running.<br><br>
                                                            Remember that only Billboard advertising reaches a broad spectrum of people.  Compare that comprehensive approach to the much narrower market reach of social media, cable television, focused radio markets.   We can’t be blocked.   Everyone sees your Ads.<br><br>
                                                            Just a reminder:   This coupon ends on {{date_format($ended, "m-d-Y")}}.  Make sure you take advantage of this great deal.<br>
                                                            @include('mail.contact-info')
														</td>
													</tr>
													@else
													<tr>
                                                        <td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
															Dear {{$user->user_name}},
															We wanted to say <strong>Thanks!</strong>  We just received a new client via your referral. We appreciate you helping us grow the INEX community.<br><br>
															If your referral becomes at least a four-week paying customer, we will reward you with a $50 coupon. It will automatically be applied to your next Campaign.<br><br>
															We appreciate you vouching for us – it lets us know we’re living up to our mission of growing our customer’s business sales, and we’re glad you want to help us help others do that. We appreciate it.<br><br>
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
