@extends('layouts.email', [
    'accountUuid' => $accountUuid,
    'username' => $username,
])

@section('top')
    <table width=100% cellpadding=0 cellspacing=0 border=0
           style=mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px>
        <tbody>
        <tr>
            <td align=center>
                <table class=container align=left width=375 cellpadding=0 cellspacing=0 border=0
                       style=mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px>
                    <tbody>
                    <tr>
                        <td>
                            <table width=100% cellpadding=0 cellspacing=0 border=0
                                   style=mso-table-lspace:0pt;mso-table-rspace:0pt>
                                <tbody>
                                <tr>
                                    <td class=float-sm width=16>&nbsp;</td>
                                    <td class=float-lg width=343 align=start valign=start>
                                        <table width=100% cellpadding=0 cellspacing=0 border=0
                                               style="mso-table-lspace:0pt;mso-table-rspace:0pt; background-color: #0066FF; height: 166px; border-radius: 16px"

                                        >
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <p
                                                        style="Margin:0;font-family:'DM Sans', Arial;font-size:28px;line-height:normal;color:#FFFFFF;font-weight:700;text-align:start; padding-left: 16px">
                                                        Password <br> Reset
                                                    </p>
                                                </td>
                                                <td align="right">
                                                    <img style="padding-right: 16px; width: 120px; height: 120px;"
                                                         alt=""
                                                         src="https://bitcoinetf.org/img/emails/4.png">
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>


                                    </td>
                                    <td class=float-sm width=16>&nbsp;</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <table class="indent" width=100% cellpadding=0 cellspacing=0 border=0
           style=mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px>
        <tbody>
        <tr>
            <td align=center>
                <table class=container align=left width=375 cellpadding=0 cellspacing=0 border=0
                       style=mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px>
                    <tbody>
                    <tr>
                        <td>
                            <table width=100% cellpadding=0 cellspacing=0 border=0
                                   style=mso-table-lspace:0pt;mso-table-rspace:0pt>
                                <tbody>
                                <tr>
                                    <td class=float-sm width=16>&nbsp;</td>
                                    <td class=float-lg width=343 align=start valign=start>
                                        <p style=Margin:0;height:24px;line-height:24px>
                                            &nbsp;
                                        </p>
                                    </td>
                                    <td class=float-sm width=16>&nbsp;</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <table width=100% cellpadding=0 cellspacing=0 border=0
           style=mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px>
        <tbody>
        <tr>
            <td align=center>
                <table class=container align=left width=375 cellpadding=0 cellspacing=0 border=0
                       style=mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px>
                    <tbody>
                    <tr>
                        <td>
                            <table width=100% cellpadding=0 cellspacing=0 border=0
                                   style=mso-table-lspace:0pt;mso-table-rspace:0pt>
                                <tbody>
                                <tr>
                                    <td class=float-sm width=16>&nbsp;</td>
                                    <td class=float-lg width=343 align=start valign=start>
                                        <p
                                            style="Margin:0;font-family:'DM Sans', Arial;font-size:24px;line-height:normal;color:#22242B;font-weight:700;text-align:start">
                                            Dear <span
                                                style="Margin:0;font-family:'DM Sans', Arial;font-size:24px;line-height:normal;color:#0066FF;font-weight:700;text-align:start;">{{ $firstName }},</span>
                                        </p>
                                    </td>
                                    <td class=float-sm width=16>&nbsp;</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <table class="indent" width=100% cellpadding=0 cellspacing=0 border=0
           style=mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px>
        <tbody>
        <tr>
            <td align=center>
                <table class=container align=left width=375 cellpadding=0 cellspacing=0 border=0
                       style=mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px>
                    <tbody>
                    <tr>
                        <td>
                            <table width=100% cellpadding=0 cellspacing=0 border=0
                                   style=mso-table-lspace:0pt;mso-table-rspace:0pt>
                                <tbody>
                                <tr>
                                    <td class=float-sm width=16>&nbsp;</td>
                                    <td class=float-lg width=343 align=start valign=start>
                                        <p style=Margin:0;height:24px;line-height:24px>
                                            &nbsp;
                                        </p>
                                    </td>
                                    <td class=float-sm width=16>&nbsp;</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <table width=100% cellpadding=0 cellspacing=0 border=0
           style=mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px>
        <tbody>
        <tr>
            <td align=center>
                <table class=container align=left width=375 cellpadding=0 cellspacing=0 border=0
                       style=mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px>
                    <tbody>
                    <tr>
                        <td>
                            <table width=100% cellpadding=0 cellspacing=0 border=0
                                   style=mso-table-lspace:0pt;mso-table-rspace:0pt>
                                <tbody>
                                <tr>
                                    <td class=float-sm width=16>&nbsp;</td>
                                    <td class=float-lg width=343 align=start valign=center>
                                        <p
                                            style="Margin:0;font-family:'DM Sans',Arial,sans-serif;font-size:16px;line-height:24px;color:#000; text-align: start">
                                            We have received a request to reset the password for your
                                            BitcoinETF.org account.
                                            <br>
                                            <br>
                                            If you did not initiate this request, please disregard this
                                            email. No changes have been made to your account.
                                            <br>
                                            <br>
                                            To reset your password, please click the link below:
                                        </p>
                                    </td>
                                    <td class=float-sm width=16>&nbsp;</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <table class="indent" width=100% cellpadding=0 cellspacing=0 border=0
           style=mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px>
        <tbody>
        <tr>
            <td align=center>
                <table class=container align=left width=375 cellpadding=0 cellspacing=0 border=0
                       style=mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px>
                    <tbody>
                    <tr>
                        <td>
                            <table width=100% cellpadding=0 cellspacing=0 border=0
                                   style=mso-table-lspace:0pt;mso-table-rspace:0pt>
                                <tbody>
                                <tr>
                                    <td class=float-sm width=16>&nbsp;</td>
                                    <td class=float-lg width=343 align=start valign=start>
                                        <p style=Margin:0;height:24px;line-height:24px>
                                            &nbsp;
                                        </p>
                                    </td>
                                    <td class=float-sm width=16>&nbsp;</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <table width=100% cellpadding=0 cellspacing=0 border=0
           style=mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px>
        <tbody>
        <tr>
            <td align=center>
                <table class=container align=center width=375 cellpadding=0 cellspacing=0 border=0
                       bgcolor=#FFFFFF
                       style=mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#fff>
                    <tbody>
                    <tr>
                        <td>
                            <table width=100% cellpadding=0 cellspacing=0 border=0
                                   style=mso-table-lspace:0pt;mso-table-rspace:0pt>
                                <tbody>
                                <tr>
                                    <td class=float-sm width=16>
                                        &nbsp;
                                    </td>
                                    <td class=float-lg
                                        width=343 align=center valign=center>
                                        <table width=343 border=0 cellpadding=0 cellspacing=0
                                               role=presentation
                                               style=border-collapse:separate;line-height:100%>
                                            <tbody>
                                            <tr>
                                                <td align=center role=presentation
                                                    style="border-radius:8px;cursor:pointer;background:#06F"
                                                    valign=middle>
                                                    <p
                                                        style="width: 100%;display:inline-block;color:#fff;font-family:'DM sans',Arial,sans-serif;font-size:16px;font-weight:700;line-height:normal;margin:0;text-decoration:none;text-transform:none;mso-padding-alt:0px;border-radius:200px">
                                                        <a href="https://bitcoinetf.org/personal/reset?code={{ $code }}"
                                                           target=_blank
                                                           style="display:inline-block;padding:18px 0;width:100%;color:#fff;font-weight:700!important;font-size:16px!important;text-decoration:none"> <span
                                                                style=color:#fff;text-decoration:none>
                                                                    <font color=#fff>Reset password</font>
                                                                    </span></a>
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style=font-size:0px;word-break:break-word>
                                                    <p style=Margin:0;height:2px;line-height:2px>
                                                        &nbsp;
                                                    </p>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td class=float-sm width=16>&nbsp;</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <table class="indent" width=100% cellpadding=0 cellspacing=0 border=0
           style=mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px>
        <tbody>
        <tr>
            <td align=center>
                <table class=container align=left width=375 cellpadding=0 cellspacing=0 border=0
                       style=mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px>
                    <tbody>
                    <tr>
                        <td>
                            <table width=100% cellpadding=0 cellspacing=0 border=0
                                   style=mso-table-lspace:0pt;mso-table-rspace:0pt>
                                <tbody>
                                <tr>
                                    <td class=float-sm width=16>&nbsp;</td>
                                    <td class=float-lg width=343 align=start valign=start>
                                        <p style=Margin:0;height:24px;line-height:24px>
                                            &nbsp;
                                        </p>
                                    </td>
                                    <td class=float-sm width=16>&nbsp;</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <table width=100% cellpadding=0 cellspacing=0 border=0
           style=mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px>
        <tbody>
        <tr>
            <td align=center>
                <table class=container align=left width=375 cellpadding=0 cellspacing=0 border=0
                       style=mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px>
                    <tbody>
                    <tr>
                        <td>
                            <table width=100% cellpadding=0 cellspacing=0 border=0
                                   style=mso-table-lspace:0pt;mso-table-rspace:0pt>
                                <tbody>
                                <tr>
                                    <td class=float-sm width=16>&nbsp;</td>
                                    <td class=float-lg width=343 align=start valign=center>
                                        <p
                                            style="Margin:0;font-family:'DM Sans',Arial,sans-serif;font-size:16px;line-height:24px;color:#000; text-align: start; font-weight: 400">
                                            This link will remain active for 1 hour. For your protection, the link will expire after this period or once your password has been successfully reset.
                                            <br>
                                            <br>
                                            For assistance or if you encounter any issues, our support team is at your service to ensure a secure and efficient resolution.
                                            <br>
                                            <br>
                                            Thank you for your prompt attention to maintaining the security of your account.
                                            <br>
                                            <br>
                                            Best regards,
                                            <br>
                                            <br>
                                            <span
                                                style="Margin:0;font-family:'DM Sans',Arial,sans-serif;font-size:16px;line-height:24px;color:#000; text-align: start; font-weight: 700">The BitcoinETF.org Team</span>
                                        </p>
                                    </td>
                                    <td class=float-sm width=16>&nbsp;</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <table class="indent" width=100% cellpadding=0 cellspacing=0 border=0
           style=mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px>
        <tbody>
        <tr>
            <td align=center>
                <table class=container align=left width=375 cellpadding=0 cellspacing=0 border=0
                       style=mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px>
                    <tbody>
                    <tr>
                        <td>
                            <table width=100% cellpadding=0 cellspacing=0 border=0
                                   style=mso-table-lspace:0pt;mso-table-rspace:0pt>
                                <tbody>
                                <tr>
                                    <td class=float-sm width=16>&nbsp;</td>
                                    <td class=float-lg width=343 align=start valign=start>
                                        <p style=Margin:0;height:32px;line-height:32px>
                                            &nbsp;
                                        </p>
                                    </td>
                                    <td class=float-sm width=16>&nbsp;</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
@endsection

@section('content')
@endsection
