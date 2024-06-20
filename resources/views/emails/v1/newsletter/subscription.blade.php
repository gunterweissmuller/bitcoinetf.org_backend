@extends('layouts.email', [
    'accountUuid' => '',
    'username' => '',
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
                                                        Welcome to<br>the<br>BitcoinETF<br>Newsletter
                                                    </p>
                                                </td>
                                                <td align="right">
                                                    <img style="padding-right: 16px; width: 120px; height: 120px;"
                                                         alt=""
                                                         src="https://bitcoinetf.org/img/emails/5.png">
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
                                            style="Margin:0;font-family:'DM Sans',Arial,sans-serif;font-size:16px;line-height:24px;color:#000; text-align: start">
                                            We are thrilled to welcome you to the Bitcoin ETF community! Thank you for subscribing to our newsletter.
                                            <br> <br>
                                            At <a target="_blank" href="{{env('APP_WEBSITE_URL')}}">BitcoinETF.org</a>, we are committed to keeping you informed and engaged with the latest insights, trends, and updates from the Bitcoin ETF world.
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
                                                <p style="Margin:0;font-family:'DM Sans', Arial;font-size:24px;line-height:normal;color:#22242B;font-weight:700;text-align:start">
                                                    Here’s what you can expect as a valued <span style="Margin:0;font-family:'DM Sans', Arial;font-size:24px;line-height:normal;color:#0066FF;font-weight:700;text-align:start;">subscriber</span>
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
                                                    1. Market Insights: Stay ahead with our in-depth analyses and expert opinions on current Bitcoin market trends and future outlooks.
                                                    <br><br>
                                                    2. Fund Performance Updates: Receive regular reports on the performance of our funds, including detailed breakdowns and commentary from our fund managers.
                                                    <br><br>
                                                    3. Investment Strategies: Learn about our investment strategies and how we are positioning our portfolios to maximize returns and manage risks.
                                                    <br><br>
                                                    4. Exclusive Events: Be the first to know about our upcoming webinars, investor meetings, and exclusive events where you can engage directly with our team.
                                                    <br><br>
                                                    5. Industry News: Get curated news and updates from the financial industry that could impact your investments and the broader market.
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
                                                    We value your trust and are dedicated to providing you with the information you need to make informed investment decisions.
                                                    Thank you once again for joining us. We look forward to sharing our journey with you
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

