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
                                                        <td class="pb-30" style="padding-bottom: 30px;">
                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                <tbody>
                                                                    <tr>
                                                                        <th class="column-top" valign="top" width="230" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top;">
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
                                                                                            <strong>Name</strong>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
                                                                                            <strong>Email</strong>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
                                                                                            <strong>Type</strong>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
                                                                                            <strong>Message</strong>
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
                                                                                                {{$data->name}}
                                                                                            </span>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
                                                                                            <span>
                                                                                                {{$data->email}}
                                                                                            </span>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
                                                                                            <span>
                                                                                                {{$data->type}}
                                                                                            </span>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="text-16 lh-26 a-left pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left; padding-bottom: 25px;">
                                                                                            <span>
                                                                                                {{$data->message}}
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
