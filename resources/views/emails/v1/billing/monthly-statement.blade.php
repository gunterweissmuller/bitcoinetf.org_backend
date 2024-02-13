@extends('layouts.email', [
    'accountUuid' => $accountUuid,
    'username' => $username,
])

@section('top')
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
        <tbody>
        <tr>
            <td align="center">
                <table class="container" align="left" width="375" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                    <tbody>
                    <tr>
                        <td>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt">
                                <tbody>
                                <tr>
                                    <td class="float-sm" width="16">&nbsp;</td>
                                    <td class="float-lg" width="343" align="start" valign="start">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt; background-color: #0066FF; height: 166px; border-radius: 16px">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <p style="Margin:0;font-family:'DM Sans', Arial;font-size:28px;line-height:normal;color:#FFFFFF;font-weight:700;text-align:start; padding-left: 16px">
                                                        Monthly <br> Statement is <br> Ready
                                                    </p>
                                                </td>
                                                <td align="right">
                                                    <img style="padding-right: 16px; width: 120px; height: 120px;"
                                                    alt=""
                                                    src="https://bitcoinetf.org/img/emails/2.png">
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>


                                    </td>
                                    <td class="float-sm" width="16">&nbsp;</td>
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
    <table class="indent" width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
        <tbody>
        <tr>
            <td align="center">
                <table class="container" align="left" width="375" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                    <tbody>
                    <tr>
                        <td>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt">
                                <tbody>
                                <tr>
                                    <td class="float-sm" width="16">&nbsp;</td>
                                    <td class="float-lg" width="343" align="start" valign="start">
                                        <p style="Margin:0;height:24px;line-height:24px">
                                            &nbsp;
                                        </p>
                                    </td>
                                    <td class="float-sm" width="16">&nbsp;</td>
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
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
        <tbody>
        <tr>
            <td align="center">
                <table class="container" align="left" width="375" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                    <tbody>
                    <tr>
                        <td>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt">
                                <tbody>
                                <tr>
                                    <td class="float-sm" width="16">&nbsp;</td>
                                    <td class="float-lg" width="343" align="start" valign="start">
                                        <p style="Margin:0;font-family:'DM Sans', Arial;font-size:24px;line-height:normal;color:#22242B;font-weight:700;text-align:start">
                                            Dear <span style="Margin:0;font-family:'DM Sans', Arial;font-size:24px;line-height:normal;color:#0066FF;font-weight:700;text-align:start;">{{ $firstName }},</span>
                                        </p>
                                    </td>
                                    <td class="float-sm" width="16">&nbsp;</td>
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
    <table class="indent" width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
        <tbody>
        <tr>
            <td align="center">
                <table class="container" align="left" width="375" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                    <tbody>
                    <tr>
                        <td>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt">
                                <tbody>
                                <tr>
                                    <td class="float-sm" width="16">&nbsp;</td>
                                    <td class="float-lg" width="343" align="start" valign="start">
                                        <p style="Margin:0;height:24px;line-height:24px">
                                            &nbsp;
                                        </p>
                                    </td>
                                    <td class="float-sm" width="16">&nbsp;</td>
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
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
        <tbody>
        <tr>
            <td align="center">
                <table class="container" align="left" width="375" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                    <tbody>
                    <tr>
                        <td>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt">
                                <tbody>
                                <tr>
                                    <td class="float-sm" width="16">&nbsp;</td>
                                    <td class="float-lg" width="343" align="start" valign="center">
                                        <p style="Margin:0;font-family:'DM Sans',Arial,sans-serif;font-size:16px;line-height:24px;color:#000; text-align: start">
                                            We are pleased to inform you that your monthly statement for BitcoinETF.org is now available. This document provides a detailed account of your dividend earnings for the past month and serves as a verifiable record of your investment income.
                                            <br>
                                            <br>
                                            Please find your statement attached to this email in PDF format, which you may download, print, and retain for your records. The statement includes a unique QR code for easy verification of its authenticity, should you require it for income confirmation purposes.
                                        </p>
                                    </td>
                                    <td class="float-sm" width="16">&nbsp;</td>
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
    <table class="indent" width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
        <tbody>
        <tr>
            <td align="center">
                <table class="container" align="left" width="375" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                    <tbody>
                    <tr>
                        <td>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt">
                                <tbody>
                                <tr>
                                    <td class="float-sm" width="16">&nbsp;</td>
                                    <td class="float-lg" width="343" align="start" valign="start">
                                        <p style="Margin:0;height:24px;line-height:24px">
                                            &nbsp;
                                        </p>
                                    </td>
                                    <td class="float-sm" width="16">&nbsp;</td>
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
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
        <tbody>
        <tr>
            <td align="center">
                <table class="container" align="center" width="375" cellpadding="0" cellspacing="0" border="0" bgcolor="#FFFFFF" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#fff">
                    <tbody>
                    <tr>
                        <td>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt">
                                <tbody>
                                <tr>
                                    <td class="float-sm" width="16">
                                        &nbsp;
                                    </td>
                                    <td class="float-lg" width="343" align="center" valign="center">
                                        <table width="343" border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;line-height:100%">
                                            <tbody>
                                            <tr>
                                                <td align="center" role="presentation" style="border-radius:8px;cursor:pointer;background:#06F" valign="middle">
                                                    <p style="width: 100%;display:inline-block;color:#fff;font-family:'DM sans',Arial,sans-serif;font-size:16px;font-weight:700;line-height:normal;margin:0;text-decoration:none;text-transform:none;mso-padding-alt:0px;border-radius:200px">
                                                        <a href="{{ $downloadUrl }}" target="_blank" style="display:inline-block;padding:18px 0;width:100%;color:#fff;font-weight:700!important;font-size:16px!important;text-decoration:none"> <span style="color:#fff;text-decoration:none">
                                                                    <font color="#fff">Download Monthly Statement</font>
                                                                    </span></a>
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:0px;word-break:break-word">
                                                    <p style="Margin:0;height:2px;line-height:2px">
                                                        &nbsp;
                                                    </p>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td class="float-sm" width="16">&nbsp;</td>
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
    <table class="indent" width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
        <tbody>
        <tr>
            <td align="center">
                <table class="container" align="left" width="375" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                    <tbody>
                    <tr>
                        <td>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt">
                                <tbody>
                                <tr>
                                    <td class="float-sm" width="16">&nbsp;</td>
                                    <td class="float-lg" width="343" align="start" valign="start">
                                        <p style="Margin:0;height:48px;line-height:48px">
                                            &nbsp;
                                        </p>
                                    </td>
                                    <td class="float-sm" width="16">&nbsp;</td>
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
            <table class="indent" width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                <tbody>
                <tr>
                    <td align="center">
                        <table class="container" align="left" width="375" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                            <tbody>
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt">
                                        <tbody>
                                        <tr>
                                            <td class="float-sm" width="16">&nbsp;</td>
                                            <td class="float-lg" width="343" align="start" valign="start">
                                                <p style="Margin:0;height:48px;line-height:48px">
                                                    &nbsp;
                                                </p>
                                            </td>
                                            <td class="float-sm" width="16">&nbsp;</td>
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
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                <tbody>
                <tr>
                    <td align="center">
                        <table class="container" align="left" width="375" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                            <tbody>
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt">
                                        <tbody>
                                        <tr>
                                            <td class="float-sm" width="16">&nbsp;</td>
                                            <td class="float-lg" width="343" align="start" valign="start">
                                                <p style="Margin:0;font-family:'DM Sans', Arial;font-size:20px;line-height:normal;color:#22242B;font-weight:700;text-align:start">
                                                    Log in for a <span style="Margin:0;font-family:'DM Sans', Arial;font-size:20px;line-height:normal;color:#0066FF;font-weight:700;text-align:start;">comprehensive view</span> of your investment.
                                                </p>
                                            </td>
                                            <td class="float-sm" width="16">&nbsp;</td>
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
            <table class="indent" width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                <tbody>
                <tr>
                    <td align="center">
                        <table class="container" align="left" width="375" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                            <tbody>
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt">
                                        <tbody>
                                        <tr>
                                            <td class="float-sm" width="16">&nbsp;</td>
                                            <td class="float-lg" width="343" align="start" valign="start">
                                                <p style="Margin:0;height:24px;line-height:24px">
                                                    &nbsp;
                                                </p>
                                            </td>
                                            <td class="float-sm" width="16">&nbsp;</td>
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
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                <tbody>
                <tr>
                    <td align="center">
                        <table class="container" align="left" width="375" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                            <tbody>
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt">
                                        <tbody>
                                        <tr>
                                            <td class="float-sm" width="16">&nbsp;</td>
                                            <td class="float-lg" width="343" align="start" valign="center">
                                                <p style="Margin:0;font-family:'DM Sans',Arial,sans-serif;font-size:16px;line-height:24px;color:#000; text-align: start">
                                                    For a comprehensive view of your investment performance and to access real-time updates, we invite you to log into your account on our website.
                                                    <br>
                                                    <br>
                                                    We understand the importance of having accessible and reliable documentation of your financial activities, and we are committed to providing you with all the necessary tools for managing your investment.
                                                </p>
                                            </td>
                                            <td class="float-sm" width="16">&nbsp;</td>
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
            <table class="indent" width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                <tbody>
                <tr>
                    <td align="center">
                        <table class="container" align="left" width="375" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                            <tbody>
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt">
                                        <tbody>
                                        <tr>
                                            <td class="float-sm" width="16">&nbsp;</td>
                                            <td class="float-lg" width="343" align="start" valign="start">
                                                <p style="Margin:0;height:24px;line-height:24px">
                                                    &nbsp;
                                                </p>
                                            </td>
                                            <td class="float-sm" width="16">&nbsp;</td>
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
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px" bgcolor="#F7F7F7">
                <tbody>
                <tr>
                    <td align="center">
                        <table class="container" align="center" width="375" cellpadding="0" cellspacing="0" border="0" bgcolor="#F7F7F7" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                            <tbody>
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt">
                                        <tbody>
                                        <tr>
                                            <td class="float-sm" width="16">
                                                &nbsp;
                                            </td>
                                            <td class="float-lg" width="343" align="center" valign="center">
                                                <table width="343" border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;line-height:100%">
                                                    <tbody>
                                                    <tr>
                                                        <td align="center" role="presentation" style="border-radius:8px;cursor:pointer;background:#06F" valign="middle">
                                                            <p style="width: 100%;display:inline-block;color:#fff;font-family:'DM sans',Arial,sans-serif;font-size:16px;font-weight:700;line-height:normal;margin:0;text-decoration:none;text-transform:none;mso-padding-alt:0px;border-radius:200px">
                                                                <a href="https://bitcoinetf.org/personal/login" target="_blank" style="display:inline-block;padding:18px 0;width:100%;color:#fff;font-weight:700!important;font-size:16px!important;text-decoration:none"> <span style="color:#fff;text-decoration:none">
                                                                    <font color="#fff">Log in</font>
                                                                    </span></a>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size:0px;word-break:break-word">
                                                            <p style="Margin:0;height:2px;line-height:2px">
                                                                &nbsp;
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td class="float-sm" width="16">&nbsp;</td>
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
            <table class="indent" width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                <tbody>
                <tr>
                    <td align="center">
                        <table class="container" align="left" width="375" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                            <tbody>
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt">
                                        <tbody>
                                        <tr>
                                            <td class="float-sm" width="16">&nbsp;</td>
                                            <td class="float-lg" width="343" align="start" valign="start">
                                                <p style="Margin:0;height:48px;line-height:48px">
                                                    &nbsp;
                                                </p>
                                            </td>
                                            <td class="float-sm" width="16">&nbsp;</td>
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
            <table class="indent" width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                <tbody>
                <tr>
                    <td align="center">
                        <table class="container" align="left" width="375" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                            <tbody>
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt">
                                        <tbody>
                                        <tr>
                                            <td class="float-sm" width="16">&nbsp;</td>
                                            <td class="float-lg" width="343" align="start" valign="start">
                                                <p style="Margin:0;height:32px;line-height:32px">
                                                    &nbsp;
                                                </p>
                                            </td>
                                            <td class="float-sm" width="16">&nbsp;</td>
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
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                <tbody>
                <tr>
                    <td align="center">
                        <table class="container" align="left" width="375" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                            <tbody>
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt">
                                        <tbody>
                                        <tr>
                                            <td class="float-sm" width="16">&nbsp;</td>
                                            <td class="float-lg" width="343" align="start" valign="center">
                                                <p style="Margin:0;font-family:'DM Sans',Arial,sans-serif;font-size:16px;line-height:24px;color:#000; text-align: start; font-weight: 400">
                                                    If you have any questions or need further assistance with your statement, please do not hesitate to reach out to our customer support team.
                                                    <br>
                                                    <br>
                                                    Thank you for investing with BitcoinETF.org, where we value the trust and confidence you have placed in us.
                                                    <br>
                                                    <br>
                                                    Warm regards,
                                                    <br>
                                                    <br>
                                                    <span style="Margin:0;font-family:'DM Sans',Arial,sans-serif;font-size:16px;line-height:24px;color:#000; text-align: start; font-weight: 700">The BitcoinETF.org Team
                                                        </span>
                                                </p>
                                            </td>
                                            <td class="float-sm" width="16">&nbsp;</td>
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
            <table class="indent" width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                <tbody>
                <tr>
                    <td align="center">
                        <table class="container" align="left" width="375" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                            <tbody>
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt">
                                        <tbody>
                                        <tr>
                                            <td class="float-sm" width="16">&nbsp;</td>
                                            <td class="float-lg" width="343" align="start" valign="start">
                                                <p style="Margin:0;height:32px;line-height:32px">
                                                    &nbsp;
                                                </p>
                                            </td>
                                            <td class="float-sm" width="16">&nbsp;</td>
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
