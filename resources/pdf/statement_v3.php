<?php

declare(strict_types=1);

return function (array $data): string {
    $accountName = $data['account_name'];
    $accountType = $data['account_type'];
    $accountNumber = $data['account_number'];
    $accountEmail = $data['account_email'];
    $date = $data['date'];
    $openingBalance = $data['opening_balance'];
    $withdrawals = $data['withdrawals'];
    $sumDividends = $data['total_dividends'];
    $referralPayments = $data['referral_payments'];
    $closingBalance = $data['closing_balance'];
    $qrCode = $data['qr_code'];
    $address = $data['address'];

    $rowsTransactions = '';
    foreach ($data['payments'] as $row) {
        $rowsTransactions .= '
            <tr>
                <td style="padding:0;font-family:DM Sans,sans-serif;font-size:10px;font-weight:700;color:#3f424e;width:100px">
                    '.$row['date'].'
                </td>
                <td style="padding:0;font-family:DM Sans,sans-serif;font-size:10px;font-weight:500;color:#3f424e">
                    '.$row['message'].'
                </td>
            </tr>';
    }

    return <<<HTML
            <!doctype html>
            <html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
                  xmlns:o="urn:schemas-microsoft-com:office:office">
            <head><title></title><!--[if !mso]><!-->
                <meta http-equiv="X-UA-Compatible" content="IE=edge"><!--<![endif]-->
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                <meta name="viewport" content="width=device-width,initial-scale=1">
                <style type="text/css">#outlook a {
                    padding: 0
                }

                body {
                    margin: 0;
                    padding: 0;
                    -webkit-text-size-adjust: 100%;
                    -ms-text-size-adjust: 100%
                }

                table, td {
                    border-collapse: collapse;
                    mso-table-lspace: 0;
                    mso-table-rspace: 0
                }

                img {
                    border: 0;
                    height: auto;
                    line-height: 100%;
                    outline: 0;
                    text-decoration: none;
                    -ms-interpolation-mode: bicubic
                }

                p {
                    display: block;
                    margin: 13px 0
                }</style>
                <!--[if mso]><noscript><xml><o:officedocumentsettings><o:allowpng><o:pixelsperinch>96</o:pixelsperinch></o:officedocumentsettings></xml></noscript><![endif]-->
                <!--[if lte mso 11]><style type="text/css">.mj-outlook-group-fix{width:100%!important}</style><![endif]-->
                <!--[if !mso]><!-->
                <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet" type="text/css">
                <style type="text/css">@import url(https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700);</style>
                <!--<![endif]-->
                <style type="text/css">
                    .mj-column-px-190 {
                        width: 190px !important;
                        width: 190px
                    }

                    .mj-column-px-228 {
                        width: 228px !important;
                        width: 228px
                    }

                    .mj-column-px-113 {
                        width: 113px !important;
                        width: 113px
                    }

                    .mj-column-per-100 {
                        width: 100% !important;
                        width: 100%
                    }

                    .mj-column-px-125 {
                        width: 125px !important;
                        width: 125px

                }</style>
                <style>.moz-text-html .mj-column-px-190 {
                    width: 190px !important;
                    width: 190px
                }

                .moz-text-html .mj-column-px-228 {
                    width: 228px !important;
                    width: 228px
                }

                .moz-text-html .mj-column-px-113 {
                    width: 113px !important;
                    width: 113px
                }

                .moz-text-html .mj-column-per-100 {
                    width: 100% !important;
                    width: 100%
                }

                .moz-text-html .mj-column-px-125 {
                    width: 125px !important;
                    width: 125px
                }</style>
            <!--    <style type="text/css">@media only screen and (max-width: 480px) {-->
            <!--        table.mj-full-width-mobile {-->
            <!--            width: 100% !important-->
            <!--        }-->

            <!--        td.mj-full-width-mobile {-->
            <!--            width: auto !important-->
            <!--        }-->
            <!--    }</style>-->
                <style type="text/css">@import url(https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,500;9..40,700&display=swap);

                .body {
                    font-family: 'DM Sans', sans-serif
                }</style>
            </head>
            <body style="word-spacing:normal">
            <div style="">
                <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px" width="600"><tr><td style="line-height:0;font-size:0;mso-line-height-rule:exactly"><![endif]-->
                <div style="margin:0 auto;width:600px">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%">
                        <tbody>
                        <tr>
                            <td style="direction:ltr;font-size:0;padding:20px 0;padding-bottom:24px;padding-left:32px;padding-right:32px;padding-top:40px;text-align:center">
                                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:190px"><![endif]-->
                                <div class="mj-column-px-190 mj-outlook-group-fix"
                                     style="font-size:0;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%">
                                    <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top"
                                           width="100%">
                                        <tbody>
                                        <tr>
                                            <td align="left"
                                                style="font-size:0;padding:0;padding-bottom:24px;word-break:break-word">
                                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                                       style="border-collapse:collapse;border-spacing:0">
                                                    <tbody>
                                                    <tr>
                                                        <td style="width:139px"><img height="auto"
                                                                                     src="data:image/png;base64,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"
                                                                                     style="border:0;display:block;outline:0;text-decoration:none;height:auto;width:100%;font-size:13px"
                                                                                     width="139"></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" style="font-size:0;padding:0;padding-bottom:4px;word-break:break-word">
                                                <div style="font-family:DM Sans,sans-serif;font-size:14px;font-weight:700;line-height:1;text-align:left;color:#22242b">
                                                    Current Account Statement
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" style="font-size:0;padding:0;padding-bottom:4px;word-break:break-word">
                                                <div style="font-family:DM Sans,sans-serif;font-size:12px;font-weight:500;line-height:1;text-align:left;color:#3f424e">
                                                    <a style="color:#3f424e" href="/">https://bitcoinetf.org/</a></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left"
                                                style="font-size:0;padding:0;padding-bottom:16px;word-break:break-word">
                                                <div style="font-family:DM Sans,sans-serif;font-size:12px;font-weight:500;line-height:1;text-align:left;color:#000">
                                                    <a style="color:#3f424e" href="mailto:contact@bitcoinetf.org" style="color:#000"
                                                       href="/">contact@bitcoinetf.org</a></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" style="font-size:0;padding:0;padding-bottom:4px;word-break:break-word">
                                                <div style="font-family:DM Sans,sans-serif;font-size:12px;font-weight:700;line-height:1;text-align:left;color:#22242b">
                                                    $accountName
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" style="font-size:0;padding:0;padding-bottom:2px;word-break:break-word">
                                                <div style="font-family:DM Sans,sans-serif;font-size:10px;font-weight:500;line-height:1;text-align:left;color:#3f424e">
                                                    $address
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" style="font-size:0;padding:0;word-break:break-word">
                                                <div style="font-family:DM Sans,sans-serif;font-size:10px;font-weight:500;line-height:1;text-align:left;color:#3f424e">
                                                    $accountEmail
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div><!--[if mso | IE]><td class="" style="vertical-align:top;width:228px"><![endif]-->
                                <div class="mj-column-px-228 mj-outlook-group-fix"
                                     style="font-size:0;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%">
                                    <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top"
                                           width="100%">
                                        <tbody></tbody>
                                    </table>
                                </div><!--[if mso | IE]><td class="" style="vertical-align:top;width:113px"><![endif]-->
                                <div class="mj-column-px-113 mj-outlook-group-fix"
                                     style="font-size:0;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%">
                                    <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top"
                                           width="100%">
                                        <tbody>
                                        <tr>
                                            <td align="center"
                                                style="font-size:0;padding:0;padding-bottom:8px;word-break:break-word">
                                                <div style="font-family:DM Sans,sans-serif;font-size:12px;font-weight:700;line-height:1;text-align:center;color:#22242b">
                                                    $date
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center"
                                                style="font-size:0;padding:0;padding-bottom:8px;word-break:break-word">
                                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                                       style="border-collapse:collapse;border-spacing:0">
                                                    <tbody>
                                                    <tr>
                                                        <td style="width:113px">
                                                        <img height="auto"
                                                             src="$qrCode"
                                                             style="border:0;display:block;outline:0;text-decoration:none;height:auto;width:100%;font-size:13px"
                                                             width="113">
                                                         </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" style="font-size:0;padding:0;word-break:break-word">
                                                <div style="font-family:DM Sans,sans-serif;font-size:8px;font-weight:500;line-height:1;text-align:left;color:#3f424e">
                                                    To verify authenticity of this statement please scan the qr code
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div><!--[if mso | IE]><![endif]--></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px" width="600"><tr><td style="line-height:0;font-size:0;mso-line-height-rule:exactly"><![endif]-->
                <div style="margin:0 auto;width:600px">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%">
                        <tbody>
                        <tr>
                            <td style="direction:ltr;font-size:0;padding:0;text-align:center">
                                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px"><![endif]-->
                                <div class="mj-column-per-100 mj-outlook-group-fix"
                                     style="font-size:0;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%">
                                    <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                        <tbody>
                                        <tr>
                                            <td style="vertical-align:top;padding:0">
                                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style=""
                                                       width="100%">
                                                    <tbody>
                                                    <tr>
                                                        <td align="center" style="font-size:0;padding:0;word-break:break-word"><p
                                                                style="border-top:solid 1px #f1f2f4;font-size:1px;margin:0 auto;width:531px"></p>
                                                            <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" style="border-top:solid 1px #f1f2f4;font-size:1px;margin:0 auto;width:531px" role="presentation" width="531px"><tr><td style="height:0;line-height:0">&nbsp;</td></tr></table><![endif]-->
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div><!--[if mso | IE]><![endif]--></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px" width="600"><tr><td style="line-height:0;font-size:0;mso-line-height-rule:exactly"><![endif]-->
                <div style="margin:0 auto;width:600px">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%">
                        <tbody>
                        <tr>
                            <td style="direction:ltr;font-size:0;padding:20px 0;padding-bottom:16px;padding-left:32px;padding-right:32px;padding-top:24px;text-align:center">
                                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:536px"><![endif]-->
                                <div class="mj-column-per-100 mj-outlook-group-fix"
                                     style="font-size:0;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%">
                                    <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top"
                                           width="100%">
                                        <tbody>
                                        <tr>
                                            <td align="left" style="font-size:0;padding:0;word-break:break-word">
                                                <div style="font-family:DM Sans,sans-serif;font-size:14px;font-weight:700;line-height:1;text-align:left;color:#22242b">
                                                    Account details
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div><!--[if mso | IE]><![endif]--></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px" width="600"><tr><td style="line-height:0;font-size:0;mso-line-height-rule:exactly"><![endif]-->
                <div style="margin:0 auto;width:600px">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%">
                        <tbody>
                        <tr>
                            <td style="direction:ltr;font-size:0;padding:20px 0;padding-bottom:24px;padding-left:32px;padding-right:32px;padding-top:0;text-align:start">
                                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:125px"><![endif]-->
                                <div class="mj-column-px-125 mj-outlook-group-fix"
                                     style="font-size:0;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%">
                                    <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                        <tbody>
                                        <tr>
                                            <td style="vertical-align:top;padding:0;padding-right:32px">
                                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style=""
                                                       width="100%">
                                                    <tbody>
                                                    <tr>
                                                        <td align="left"
                                                            style="font-size:0;padding:0;padding-bottom:4px;word-break:break-word">
                                                            <div style="font-family:DM Sans,sans-serif;font-size:12px;font-weight:700;line-height:1;text-align:left;color:#22242b">
                                                                Account Name
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left"
                                                            style="font-size:0;padding:0;padding-bottom:16px;word-break:break-word">
                                                            <div style="font-family:DM Sans,sans-serif;font-size:10px;font-weight:500;line-height:1;text-align:left;color:#3f424e">
                                                                $accountName
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left"
                                                            style="font-size:0;padding:0;padding-bottom:4px;word-break:break-word">
                                                            <div style="font-family:DM Sans,sans-serif;font-size:12px;font-weight:700;line-height:1;text-align:left;color:#22242b">
                                                                Opening Balance
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left"
                                                            style="font-size:0;padding:0;padding-bottom:16px;word-break:break-word">
                                                            <div style="font-family:DM Sans,sans-serif;font-size:10px;font-weight:500;line-height:1;text-align:left;color:#3f424e">
                                                                $openingBalance
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div><!--[if mso | IE]><td class="" style="vertical-align:top;width:125px"><![endif]-->
                                <div class="mj-column-px-125 mj-outlook-group-fix"
                                     style="font-size:0;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%">
                                    <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                        <tbody>
                                        <tr>
                                            <td style="vertical-align:top;padding:0;padding-right:32px">
                                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style=""
                                                       width="100%">
                                                    <tbody>
                                                    <tr>
                                                        <td align="left"
                                                            style="font-size:0;padding:0;padding-bottom:4px;word-break:break-word">
                                                            <div style="font-family:DM Sans,sans-serif;font-size:12px;font-weight:700;line-height:1;text-align:left;color:#22242b">
                                                                Account Type
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left"
                                                            style="font-size:0;padding:0;padding-bottom:16px;word-break:break-word">
                                                            <div style="font-family:DM Sans,sans-serif;font-size:10px;font-weight:500;line-height:1;text-align:left;color:#3f424e">
                                                                $accountType
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left"
                                                            style="font-size:0;padding:0;padding-bottom:4px;word-break:break-word">
                                                            <div style="font-family:DM Sans,sans-serif;font-size:12px;font-weight:700;line-height:1;text-align:left;color:#22242b">
                                                                Dividends
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left"
                                                            style="font-size:0;padding:0;padding-bottom:16px;word-break:break-word">
                                                            <div style="font-family:DM Sans,sans-serif;font-size:10px;font-weight:500;line-height:1;text-align:left;color:#3f424e">
                                                                $sumDividends
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left"
                                                            style="font-size:0;padding:0;padding-bottom:4px;word-break:break-word">
                                                            <div style="font-family:DM Sans,sans-serif;font-size:12px;font-weight:700;line-height:1;text-align:left;color:#3f424e">
                                                                Referral payments
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left" style="font-size:0;padding:0;word-break:break-word">
                                                            <div style="font-family:DM Sans,sans-serif;font-size:10px;font-weight:500;line-height:1;text-align:left;color:#3f424e">
                                                                $referralPayments
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div><!--[if mso | IE]><td class="" style="vertical-align:top;width:125px"><![endif]-->
                                <div class="mj-column-px-125 mj-outlook-group-fix"
                                     style="font-size:0;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%">
                                    <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                        <tbody>
                                        <tr>
                                            <td style="vertical-align:top;padding:0">
                                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style=""
                                                       width="100%">
                                                    <tbody>
                                                    <tr>
                                                        <td align="left"
                                                            style="font-size:0;padding:0;padding-bottom:4px;word-break:break-word">
                                                            <div style="font-family:DM Sans,sans-serif;font-size:12px;font-weight:700;line-height:1;text-align:left;color:#22242b">
                                                                Account number
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left"
                                                            style="font-size:0;padding:0;padding-bottom:16px;word-break:break-word">
                                                            <div style="font-family:DM Sans,sans-serif;font-size:10px;font-weight:500;line-height:1;text-align:left;color:#3f424e">
                                                                $accountNumber
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left"
                                                            style="font-size:0;padding:0;padding-bottom:4px;word-break:break-word">
                                                            <div style="font-family:DM Sans,sans-serif;font-size:12px;font-weight:700;line-height:1;text-align:left;color:#22242b">
                                                                Withdrawals
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left" style="font-size:0;padding:0;word-break:break-word">
                                                            <div style="font-family:DM Sans,sans-serif;font-size:10px;font-weight:500;line-height:1;text-align:left;color:#3f424e">
                                                                $withdrawals
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div><!--[if mso | IE]><![endif]--></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px" width="600"><tr><td style="line-height:0;font-size:0;mso-line-height-rule:exactly"><![endif]-->
                <div style="margin:0 auto;width:600px">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%">
                        <tbody>
                        <tr>
                            <td style="direction:ltr;font-size:0;padding:0;text-align:center">
                                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px"><![endif]-->
                                <div class="mj-column-per-100 mj-outlook-group-fix"
                                     style="font-size:0;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%">
                                    <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                        <tbody>
                                        <tr>
                                            <td style="vertical-align:top;padding:0">
                                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style=""
                                                       width="100%">
                                                    <tbody>
                                                    <tr>
                                                        <td align="center" style="font-size:0;padding:0;word-break:break-word"><p
                                                                style="border-top:solid 1px #f1f2f4;font-size:1px;margin:0 auto;width:531px"></p>
                                                            <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" style="border-top:solid 1px #f1f2f4;font-size:1px;margin:0 auto;width:531px" role="presentation" width="531px"><tr><td style="height:0;line-height:0">&nbsp;</td></tr></table><![endif]-->
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div><!--[if mso | IE]><![endif]--></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px" width="600"><tr><td style="line-height:0;font-size:0;mso-line-height-rule:exactly"><![endif]-->
                <div style="margin:0 auto;width:600px">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%">
                        <tbody>
                        <tr>
                            <td style="direction:ltr;font-size:0;padding:20px 0;padding-bottom:16px;padding-left:32px;padding-right:32px;padding-top:24px;text-align:center">
                                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:536px"><![endif]-->
                                <div class="mj-column-per-100 mj-outlook-group-fix"
                                     style="font-size:0;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%">
                                    <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top"
                                           width="100%">
                                        <tbody>
                                        <tr>
                                            <td align="left" style="font-size:0;padding:0;word-break:break-word">
                                                <div style="font-family:DM Sans,sans-serif;font-size:14px;font-weight:700;line-height:1;text-align:left;color:#22242b">
                                                    Transactions
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div><!--[if mso | IE]><![endif]--></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px" width="600"><tr><td style="line-height:0;font-size:0;mso-line-height-rule:exactly"><![endif]-->
                <div style="margin:0 auto;width:600px">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%">
                        <tbody>
                        <tr>
                            <td style="direction:ltr;font-size:0;padding:20px 0;padding-bottom:24px;padding-left:32px;padding-right:32px;padding-top:0;text-align:start">
                                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:536px"><![endif]-->
                                <div class="mj-column-per-100 mj-outlook-group-fix"
                                     style="font-size:0;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%">
                                    <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top"
                                           width="100%">
                                        <tbody>
                                        <tr>
                                            <td align="left" style="font-size:0;padding:0;word-break:break-word">
                                                <table cellpadding="0" cellspacing="0" width="100%" border="0"
                                                       style="color:#000;font-family:Ubuntu,Helvetica,Arial,sans-serif;font-size:13px;line-height:22px;table-layout:auto;width:100%;border:none">
                                                    $rowsTransactions
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" style="font-size:0;padding:0;word-break:break-word">
                                                <table cellpadding="0" cellspacing="0" width="100%" border="0"
                                                       style="color:#000;font-family:Ubuntu,Helvetica,Arial,sans-serif;font-size:13px;line-height:22px;table-layout:auto;width:100%;border:none">
                                                    <tr>
                                                        <td style="padding:0;font-family:DM Sans,sans-serif;font-size:10px;font-weight:700;color:#3f424e;width:100px">
                                                            Closing balance
                                                        </td>
                                                        <td style="padding:0;font-family:DM Sans,sans-serif;font-size:10px;font-weight:700;color:#3f424e">
                                                            $closingBalance
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div><!--[if mso | IE]><![endif]--></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px" width="600"><tr><td style="line-height:0;font-size:0;mso-line-height-rule:exactly"><![endif]-->
                <div style="margin:0 auto;width:600px">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%">
                        <tbody>
                        <tr>
                            <td style="direction:ltr;font-size:0;padding:0;text-align:center">
                                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px"><![endif]-->
                                <div class="mj-column-per-100 mj-outlook-group-fix"
                                     style="font-size:0;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%">
                                    <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                        <tbody>
                                        <tr>
                                            <td style="vertical-align:top;padding:0">
                                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style=""
                                                       width="100%">
                                                    <tbody>
                                                    <tr>
                                                        <td align="center" style="font-size:0;padding:0;word-break:break-word"><p
                                                                style="border-top:solid 1px #f1f2f4;font-size:1px;margin:0 auto;width:531px"></p>
                                                            <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" style="border-top:solid 1px #f1f2f4;font-size:1px;margin:0 auto;width:531px" role="presentation" width="531px"><tr><td style="height:0;line-height:0">&nbsp;</td></tr></table><![endif]-->
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div><!--[if mso | IE]><![endif]--></td>
                        </tr>
                        </tbody>
                    </table>
                </div><!--[if mso | IE]><![endif]--></div>
            </body>
            </html>
    HTML;
};
