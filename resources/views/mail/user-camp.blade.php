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
                                                        <td class="title-20 pb-10" style="font-size:20px; line-height:24px; color:#282828; font-family:'PT Sans', Arial, sans-serif; text-align:center; min-width:auto !important; padding-bottom: 10px;">
															<strong>{{$user->business_name}}</strong>
														</td>
													</tr>
													<tr>
                                                        @if($flag == 0)
                                                            <td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
                                                                Hello, {{$user->user_name}}<br><br>
                                                                Congratulations.  Your Campaign has been setup according to your instructions. <br><br>
                                                                If you did not create this Campaign, please contact us immediately at <a href="tel:(405)415-3002">(405)415-3002</a>, Ext 0 (Support). If it is correct, you do not have to do anything.<br><br>
                                                                Remember, the Campaign Manager controls where and when your Ads are shown. If you have multiple Ads, your Playlist Manager controls which Ads are sent to the billboard(s). You can always change your Playlist anytime of the day. You can even make Ads that are shown only on a specific day during certain hours of the day.<br><br>
                                                                If you have questions, please contact your Account Manager.<br><br>
                                                            </td>
                                                        @elseif($flag == 1)
                                                            <td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
                                                                Your Campaign's Updated
                                                            </td>
                                                        @elseif($flag == 2)
                                                            As you requested,  we have delivered your personally designed advertising campaign outline.   In addition,  you may click on the link below to complete your transaction and ensure your advertising is executed.   You may pay online with credit card or mail us a check.  The link also allows you to print your invoice.
                                                        @else 
                                                            <td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
                                                                Hello, {{$user->user_name}}<br><br>
                                                                Congratulations.  Your Campaign has been setup according to your instructions. <br><br>
                                                                Remember, the Campaign Manager controls where and when your Ads are shown. If you have multiple Ads, your Playlist Manager controls which Ads are sent to the billboard(s). You can always change your Playlist anytime of the day. You can even make Ads that are shown only on a specific day during certain hours of the day.<br><br>
                                                                If you have questions, please contact your Account Manager.<br><br>
                                                            </td>
                                                        @endif
													</tr>
                                                    <tr>
                                                        <td class="pb-30" style="padding-bottom: 30px;">
                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                <tbody>
                                                                    <tr>
                                                                        <th class="column-top" valign="top" width="230" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top;">
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
                                                                                            <strong>Campaign Name</strong>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
                                                                                            <strong>Start Date</strong>
                                                                                        </td>
                                                                                    </tr>
                                                                                    @if($campaign->end_flag == 0)
                                                                                    <tr>
                                                                                        <td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
                                                                                            <strong>Number of weeks</strong>
                                                                                        </td>
                                                                                    </tr>
                                                                                    @endif
                                                                                    <tr>
                                                                                        <td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
                                                                                            <strong>End Date</strong>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
                                                                                            <strong>Days of the Week</strong>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </th>
                                                                        <th class="column-top mpb-15" valign="top" width="30" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top;"></th>
                                                                        <th class="column-top" valign="top" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top;">
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
                                                                                            <span>
                                                                                                {{$campaign->campaign_name}}
                                                                                            </span>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
                                                                                            <span>
                                                                                                <?php
                                                                                                    $start_date = $campaign->start_date;
                                                                                                    if($start_date != null){
                                                                                                        $created = date_create($start_date);
                                                                                                        echo date_format($created, "m-d-Y");
                                                                                                    }
                                                                                                ?>
                                                                                            </span>
                                                                                        </td>
                                                                                    </tr>
                                                                                    @if($campaign->end_flag == 0)
                                                                                    <tr>
                                                                                        <td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
                                                                                            <span>
                                                                                                {{$campaign->weeks}}
                                                                                            </span>
                                                                                        </td>
                                                                                    </tr>
                                                                                    @endif
                                                                                    <tr>
                                                                                        <td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
                                                                                            <span>
                                                                                                @if($campaign->end_flag == 0)
                                                                                                <?php
                                                                                                    $start_date = $campaign->end_date;
                                                                                                    if($start_date != null){
                                                                                                        $created = date_create($start_date);
                                                                                                        echo date_format($created, "m-d-Y");
                                                                                                    }
                                                                                                ?>
                                                                                                @else
                                                                                                    <?php echo "No End Date"?>
                                                                                                @endif
                                                                                            </span>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
                                                                                            <span>
                                                                                                {{$campaign->days}}
                                                                                            </span>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </th>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                        $signs = explode(",", $campaign->locations);
                                                        $slots = explode(',', $campaign->slots);
                                                        $price = explode(",", $campaign->price);
                                                        $sub = explode(",", $campaign->sub_total);
                                                    ?>
                                                    @foreach($signs as $key => $item)
                                                    <tr>
                                                        <td class="pb-30" style="padding-bottom: 30px;">
                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                    <th class="column-top" valign="top" width="230" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top;">
                                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                            <tr>
                                                                                <td class="text-16 lh-26 c-black" style="font-size:16px; font-family:'PT Sans', Arial, sans-serif; text-align:left; min-width:auto !important; line-height: 26px; color:#282828;">
                                                                                    @foreach($locations as $loc)
                                                                                        @if($item == $loc->id)
                                                                                            {{$loc->nickname}}
                                                                                        @endif
                                                                                    @endforeach
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                        
                                                                    </th>
                                                                    <th class="column-top mpb-15" valign="top" width="30" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top;"></th>
                                                                    <th class="column-top" valign="top" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top;">
                                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                            <tr>
                                                                                <td class="text-16 lh-26 c-black" style="font-size:16px; font-family:'PT Sans', Arial, sans-serif; text-align:left; min-width:auto !important; line-height: 26px; color:#282828;">
                                                                                    Ad Slots: {{$slots[$key]}}
                                                                                    <br />
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </th>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
													@endforeach
                                                    @if($flag == 2)
                                                    <tr>
														<td align="center">
															<table border="0" cellspacing="0" cellpadding="0" style="min-width: 200px;padding-top:50px">
																<tr>
																	<td class="btn-16 c-white l-white" bgcolor="#004289" style="font-size:16px; line-height:20px; mso-padding-alt:15px 35px; font-family:'PT Sans', Arial, sans-serif; text-align:center; font-weight:bold; text-transform:uppercase; border-radius:25px; min-width:auto !important; color:#ffffff;">
																		<a href="https://www.inexsigns.net/pay-invoice/{{base64_encode($campaign->id)}}" target="_blank" class="link c-white" style="display: block; padding: 15px 35px; text-decoration:none; color:#ffffff;">
																			<span class="link c-white" style="text-decoration:none; color:#ffffff;">View Invoice</span>
																		</a>
																	</td>
																</tr>
															</table>
														</td>
													</tr>
                                                    @endif
                                                    @if($flag != 3)
                                                        <tr>
                                                            <td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
                                                                <br>
                                                                * If you paid by credit card, your Invoice already shows PAID.  Depending on the interval you selected for future payments (Weekly, every 4 weeks, etc.), they will automatically be applied to your account.<br><br>
                                                                * If you chose to be invoiced and pay by check, then your Invoice will show UNPAID.   Please remit your payment by mail.  <br><br>
                                                                Particularly important is the delivery of your payment prior to the Start Date of your Campaign.   Our system will automatically suspend your campaign without timely payment.<br><br>
                                                                If you have any issues regarding the start of your campaign, please contact your Account Manager.<br><br>
                                                                We thank you for your business.   Advertising continues to show a positive increase in sales, especially if your Ads are well designed and target individual portions of your target market.  If you wish to learn more about this, please contact your Account Manager.  They will be happy to explain in more detail how to focus your advertising.<br>
                                                                Understand that our patent-pending system allows you to generate just-in-time advertising.  Overstocked?  Put out a promotion.  Have a special?  Use our system to create impulse buying Ads.  Create a few of these Ads in advance.  Then show them to the public whenever you want 24/7.<br>
                                                                Thank you again for using INEX and our innovative advertising approach.<br><br>
                                                                @include('mail.contact-info')
                                                            </td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
                                                                <br>
                                                                In addition:
                                                                <ul>
                                                                    <li>You are under contract.  You will automatically receive billing 60 days after the Start Date of your campaign.</li>
                                                                    <li>If you did not create this Campaign, please contact us immediately at <a href="tel:(405)415-3002">(405)415-3002</a>, Ext 0 (Support). If it is correct, you do not have to do anything.</li>
                                                                </ul>
                                                                We thank you for your business.   Advertising continues to show a positive increase in sales, especially if your Ads are well designed and target individual portions of your target market.  If you wish to learn more about this, please contact your Account Manager.  They will be happy to explain in more detail how to focus your advertising.<br>
                                                                Understand that our patent-pending system allows you to generate just-in-time advertising.  Overstocked?  Put out a promotion.  Have a special?  Use our system to create impulse buying Ads.  Create a few of these Ads in advance.  Then show them to the public whenever you want 24/7.<br>
                                                                Thank you again for using INEX and our innovative advertising approach.<br>
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
