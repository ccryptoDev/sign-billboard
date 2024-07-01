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
                                                    <!-- <tr>
                                                        <td class="fluid-img img-center pb-50" style="font-size:0pt; line-height:0pt; text-align:center; padding-bottom: 50px;">
                                                            <img src="https://www.psd2newsletters.com/templates/purple/images/img_intro_4.png" width="368" height="296" border="0" alt="" />
                                                        </td>
                                                    </tr> -->
                                                    <tr>
                                                        <td class="title-16 a-center pb-15" style="font-size:16px; line-height:40px; color:#282828; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; text-align:center; padding-bottom: 15px;">
                                                            <strong>{{$user->name}}</strong>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-16 lh-26 a-center pb-25" style="font-size:16px; color:#6e6e6e; font-family:'PT Sans', Arial, sans-serif; min-width:auto !important; line-height: 26px; text-align:left;  padding-bottom: 25px;">
                                                        We have registered you as a 
                                                        @if($user->level == 2)
                                                            Super Admin
                                                        @elseif($user->level == 3)
                                                            Supervisor
                                                        @elseif($user->level == 4)
                                                            Account Manager
                                                        @else
                                                            Graphics Designer
                                                        @endif
                                                         with Company {{$user->business_name}}. Use this email to set your password
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center">
                                                            <!-- Button -->
                                                            <table border="0" cellspacing="0" cellpadding="0" style="min-width: 200px;">
                                                                <tr>
                                                                    <td class="btn-16 c-white l-white" bgcolor="#004289" style="font-size:16px; line-height:20px; mso-padding-alt:15px 35px; font-family:'PT Sans', Arial, sans-serif; text-align:center; font-weight:bold; text-transform:uppercase; border-radius:25px; min-width:auto !important; color:#ffffff;">
                                                                        <a href="https://www.inexsigns.net/set-password/{{base64_encode($user->id)}}" target="_blank" class="link c-white" style="display: block; padding: 15px 35px; text-decoration:none; color:#ffffff;">
                                                                            <span class="link c-white" style="text-decoration:none; color:#ffffff;">SET PASSWORD</span>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <!-- END Button -->
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
