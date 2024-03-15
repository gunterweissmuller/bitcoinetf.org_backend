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
                                                        Verify Your <br> Email
                                                    </p>
                                                </td>
                                                <td align="right">
                                                    <img style="padding-right: 16px; width: 120px; height: 120px;"
                                                         src="https://bitcoinetf.org/img/emails/3.png">
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
                                            Thank you for your registration with BitcoinETF.org. To proceed
                                            with securing your account and ensuring the confidentiality of
                                            your investments, please verify your email address using the
                                            code provided below:
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
                                        <p style=Margin:0;height:48px;line-height:48px>
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
    <tr>
        <td align="left" bgcolor="#F7F7F7" style="background-color: #F7F7F7">
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
                                                <p style=Margin:0;height:48px;line-height:48px>
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
                                            <td class=float-lg width=343 align=center valign=start>
                                                <p
                                                    style="Margin:0;font-family:'DM Sans', Arial;font-size:24px;line-height:normal;color:#22242B;font-weight:700;text-align:center">
                                                    Verification code
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
                                            <td class=float-lg width=343 align=center valign=start>
                                                <p
                                                    style="Margin:0;font-family:'DM Sans', Arial;font-size:32px;line-height:normal;color:#FFFFFF;font-weight:700;text-align:center; padding: 16px; background-color: #06F; border-radius: 16px; letter-spacing: 10px">
                                                    {{ $code }}
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
                                            <td class=float-lg width=343 align=center valign=start>
                                                <p
                                                    style="Margin:0;font-family:'DM Sans', Arial;font-size:14px;line-height:normal;color:#3F424E;font-weight:500;text-align:center">
                                                    This code is valid for the next 30 minutes and ensures that we maintain the highest standards of security and service integrity for your investment journey.
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
                                                <p style=Margin:0;height:48px;line-height:48px>
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
        </td>
    </tr>
    <tr>
        <td align="left">
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
                                                    Once verified, you will unlock the full suite of features and services available at BitcoinETF.org.
                                                    <br>
                                                    <br>
                                                    Should you encounter any issues or require further assistance, our dedicated support team is ready to assist you.
                                                    <br>
                                                    <br>
                                                    Securely yours,
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
        </td>
    </tr>
@endsection
