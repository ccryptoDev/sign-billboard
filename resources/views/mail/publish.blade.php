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
														<td class="text-16 lh-26 a-center pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:center; padding-bottom: 25px;">
														    {{$user->user_name}}
														</td>
													</tr>
                                                    <tr>
														<td class="title-16 a-center pb-15" style="font-size:16px; line-height:40px; color:#282828; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; text-align:center; padding-bottom: 15px;">
															<strong>{{$user->business_name}}</strong>
														</td>
													</tr>
													<tr>
														<td class="text-16 lh-26 a-center pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left;  padding-bottom: 25px;">
														    @if($user->level == 0)
                                                                Your ads are deliveried to the billboard.
                                                            @else
                                                                The following Ads have been delivered to the billboard(s).<br>
                                                                If you did not make this change, please contact us immediately.   Otherwise, this email is just a confirmation of your changes.
                                                            @endif
														</td>
													</tr>
                                                    <?php
                                                        $lists = '';
                                                    ?>
                                                    @foreach($ads as $item)
                                                        <?php 
                                                            $lists = base64_encode($item->id).",";
                                                        ?>
                                                        @if($user->level != 0)
                                                            <tr>
                                                                <td class="pb-30" style="padding-bottom: 30px;">
                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                        <tbody><tr>
                                                                            <th class="column-top" valign="top" width="230" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top;">
                                                                                <div class="fluid-img" style="font-size:0pt; line-height:0pt; text-align:left;">
                                                                                    <a href="#" target="_blank">
                                                                                        <img src="https://www.inex.net/upload/{{$item->img_url}}" border="0" width="230" height="160" alt="">
                                                                                    </a>
                                                                                </div>
                                                                            </th>
                                                                            <th class="column-top mpb-15" valign="top" width="30" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top;"></th>
                                                                            <th class="column-top" valign="top" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top;">
                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                    <tbody><tr>
                                                                                        <td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
                                                                                            <strong>{{$item->business_name}}</strong>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <!-- <tr>
                                                                                        <td class="text-16 lh-26 pb-15" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; text-align:left; min-width:auto !important; line-height: 26px; padding-bottom: 15px;">
                                                                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                                                        </td>
                                                                                    </tr> -->
                                                                                </tbody></table>
                                                                            </th>
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        @if($user->level == 0 && $user->business_name == $item->business_name)
                                                        <tr>
                                                            <td class="pb-30" style="padding-bottom: 30px;">
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tbody><tr>
                                                                        <th class="column-top" valign="top" width="230" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top;">
                                                                            <div class="fluid-img" style="font-size:0pt; line-height:0pt; text-align:left;">
                                                                                <a href="#" target="_blank">
                                                                                    <img src="https://www.inex.net/upload/{{$item->img_url}}" border="0" width="230" height="160" alt="">
                                                                                </a>
                                                                            </div>
                                                                        </th>
                                                                        <th class="column-top mpb-15" valign="top" width="30" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top;"></th>
                                                                        <th class="column-top" valign="top" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top;">
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
                                                                                            <strong>{{$item->business_name}}</strong>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </th>
                                                                    </tr>
                                                                </tbody></table>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    @endforeach
													<!-- <tr>
														<td align="center">
															<table border="0" cellspacing="0" cellpadding="0" style="min-width: 200px;">
																<tr>
																	<td class="btn-16 c-white l-white" bgcolor="#004289" style="font-size:16px; line-height:20px; mso-padding-alt:15px 35px; font-family:'PT Sans', Arial, sans-serif; text-align:center; font-weight:bold; text-transform:uppercase; border-radius:25px; min-width:auto !important; color:#ffffff;">
																		<a href="https://www.inex.net/delivery/{{base64_encode($user->id)}}/{{$lists}}" target="_blank" class="link c-white" style="display: block; padding: 15px 35px; text-decoration:none; color:#ffffff;">
																			<span class="link c-white" style="text-decoration:none; color:#ffffff;">Check your Ads</span>
																		</a>
																	</td>
																</tr>
															</table>
														</td>
													</tr> -->
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
