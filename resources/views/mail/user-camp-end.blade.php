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
															@if($user->business_name)
                                                                <strong>{{$user->business_name}}</strong>
                                                            @endif
														</td>
													</tr>
                                                    <tr>
                                                        <td class="title-16 a-center pb-15" style="font-size:16px; line-height:40px; color:#282828; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; text-align:center; padding-bottom: 15px;">
															@if($user->business_name)
                                                                <strong>{{$user->business_name}}</strong>
                                                            @endif
														</td>
													</tr>
													<tr>
                                                        <?php
                                                        $today = date("Y-m-d");
                                                        $end = date_create($campaign->end_date);
                                                        ?>
                                                        @if($today == $campaign->end_date)
                                                        <td class="text-16 lh-26 a-left c-black" style="font-size:16px; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left;  color:#282828;">
                                                            Your Campaign's ended.
                                                            Keep bringing customers to your business by creating another campaign. <a href="https://www.inex.net/login">Login now</a> to set it up.
                                                        </td>
                                                        @else
                                                        <td class="text-16 lh-26 a-left c-black" style="font-size:16px; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; color:#282828;">
                                                            Your Campaign is ending on {{date_format($end, "m-d-Y")}}.<br>
                                                            Keep bringing customers to your business by creating another campaign. <a href="https://www.inex.net/login">Login now</a> to set it up.
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
