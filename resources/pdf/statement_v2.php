<?php

declare(strict_types=1);

return function (array $data): string {
    $accountName = $data['account_name'];
    $accountNumber = $data['account_number'];
    $openingBalance = $data['opening_balance'];
    $withdrawals = $data['withdrawals'];
    $bonus = $data['bonus'];
    $sumDividends = $data['total_dividends'];
    $referralPayments = $data['referral_payments'];
    $closingBalance = $data['closing_balance'];
    $qrCode = $data['qr_code'];

    $rowsTransactionsDates = '';
    $rowsTransactionsMessages = '';
    foreach ($data['payments'] as $row) {
        $rowsTransactionsDates .= '
                <tr>
                    <td align="left"
                        style="font-size:0px;padding:0;padding-bottom:8px;word-break:break-word;">
                        <div
                            style="font-family:DM Sans, sans-serif;font-size:10px;font-weight:700;line-height:1;text-align:left;color:#3F424E;">
                            '.$row['date'].'
                        </div>
                    </td>
                </tr>
            ';

        $rowsTransactionsMessages .= '
            <tr>
                <td align="left"
                    style="font-size:0px;padding:0;padding-bottom:16px;word-break:break-word;">
                    <div
                        style="font-family:DM Sans, sans-serif;font-size:10px;font-weight:500;line-height:1;text-align:left;color:#3F424E;">
                        '.$row['message'].'
                    </div>
                </td>
            </tr>
        ';
    }

    return <<<HTML
        <!doctype html>
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <title></title>
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <style type="text/css">
                #outlook a {
                    padding: 0;
                }

                body {
                    margin: 0;
                    padding: 0;
                    -webkit-text-size-adjust: 100%;
                    -ms-text-size-adjust: 100%;
                }

                table, td {
                    border-collapse: collapse;
                    mso-table-lspace: 0pt;
                    mso-table-rspace: 0pt;
                }

                img {
                    border: 0;
                    height: auto;
                    line-height: 100%;
                    outline: none;
                    text-decoration: none;
                    -ms-interpolation-mode: bicubic;
                }

                p {
                    display: block;
                    margin: 13px 0;
                }
            </style>
            <style type="text/css"> @media only screen and (min-width: 480px) {
                    .mj-column-px-190 {
                        width: 190px !important;
                        max-width: 190px;
                    }

                    .mj-column-px-228 {
                        width: 228px !important;
                        max-width: 228px;
                    }

                    .mj-column-px-113 {
                        width: 113px !important;
                        max-width: 113px;
                    }

                    .mj-column-per-100 {
                        width: 100% !important;
                        max-width: 100%;
                    }

                    .mj-column-px-125 {
                        width: 125px !important;
                        max-width: 125px;
                    }

                    .mj-column-px-100 {
                        width: 100px !important;
                        max-width: 100px;
                    }

                    .mj-column-per-50 {
                        width: 50% !important;
                        max-width: 50%;
                    }
                }</style>
            <style media="screen and (min-width:480px)"> .moz-text-html .mj-column-px-190 {
                    width: 190px !important;
                    max-width: 190px;
                }

                .moz-text-html .mj-column-px-228 {
                    width: 228px !important;
                    max-width: 228px;
                }

                .moz-text-html .mj-column-px-113 {
                    width: 113px !important;
                    max-width: 113px;
                }

                .moz-text-html .mj-column-per-100 {
                    width: 100% !important;
                    max-width: 100%;
                }

                .moz-text-html .mj-column-px-125 {
                    width: 125px !important;
                    max-width: 125px;
                }

                .moz-text-html .mj-column-px-100 {
                    width: 100px !important;
                    max-width: 100px;
                }

                .moz-text-html .mj-column-per-50 {
                    width: 50% !important;
                    max-width: 50%;
                }</style>
            <style type="text/css"> @media only screen and (max-width: 480px) {
                    table.mj-full-width-mobile {
                        width: 100% !important;
                    }

                    td.mj-full-width-mobile {
                        width: auto !important;
                    }
                }</style>
            <style
                type="text/css"> @import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,500;9..40,700&display=swap');

                .body {
                    font-family: 'DM Sans', sans-serif;
                }</style>
        </head>
        <body style="word-spacing:normal;">
        <div style="">
            <div style="margin:0px auto;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                    <tbody>
                    <tr>
                        <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:24px;padding-left:32px;padding-right:32px;padding-top:40px;">
                            <div class="mj-column-px-190 mj-outlook-group-fix"
                                 style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                       style="vertical-align:top;" width="100%">
                                    <tbody>
                                    <tr>
                                        <td align="left"
                                            style="font-size:0px;padding:0;padding-bottom:24px;word-break:break-word;">
                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                                   style="border-collapse:collapse;border-spacing:0px;">
                                                <tbody>
                                                <tr>
                                                    <td style="width:139px;">
                                                    <img height="auto" src="data:image/png;base64,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"
                                                                                  style="border:0;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="139"/>
                                                  </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left"
                                            style="font-size:0px;padding:0;padding-bottom:4px;word-break:break-word;">
                                            <div
                                                style="font-family:DM Sans, sans-serif;font-size:14px;font-weight:700;line-height:1;text-align:left;color:#22242B;">
                                                Current Account Statement
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left"
                                            style="font-size:0px;padding:0;padding-bottom:4px;word-break:break-word;">
                                            <div
                                                style="font-family:DM Sans, sans-serif;font-size:12px;font-weight:500;line-height:1;text-align:left;color:#3F424E;">
                                                <a style="color:#3F424E;" href="/">https://bitcoinetf.org/</a></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left"
                                            style="font-size:0px;padding:0;padding-bottom:16px;word-break:break-word;">
                                            <div
                                                style="font-family:DM Sans, sans-serif;font-size:12px;font-weight:500;line-height:1;text-align:left;color:#000000;">
                                                <a style="color:#3F424E;" href="mailto:contact@bitcoinetf.org"
                                                   style="color:#000;" href="/">contact@bitcoinetf.org</a></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left"
                                            style="font-size:0px;padding:0;padding-bottom:4px;word-break:break-word;">
                                            <div
                                                style="font-family:DM Sans, sans-serif;font-size:12px;font-weight:700;line-height:1;text-align:left;color:#22242B;">
                                                $accountName
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left"
                                            style="font-size:0px;padding:0;padding-bottom:2px;word-break:break-word;">
                                            <div
                                                style="font-family:DM Sans, sans-serif;font-size:10px;font-weight:500;line-height:1;text-align:left;color:#3F424E;">
                                                Moscow, Russia
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" style="font-size:0px;padding:0;word-break:break-word;">
                                            <div
                                                style="font-family:DM Sans, sans-serif;font-size:10px;font-weight:500;line-height:1;text-align:left;color:#3F424E;">
                                                ivan@ivanoff.com
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:325px;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
                                    <tbody>

                                    </tbody>
                                </table>

                            </div>
                            <div class="mj-column-px-113 mj-outlook-group-fix"
                                 style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                       style="vertical-align:top;" width="100%">
                                    <tbody>
                                    <tr>
                                        <td align="center"
                                            style="font-size:0px;padding:0;padding-bottom:8px;word-break:break-word;">
                                            <div
                                                style="font-family:DM Sans, sans-serif;font-size:12px;font-weight:700;line-height:1;text-align:center;color:#22242B;">
                                                31/12/2023
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center"
                                            style="font-size:0px;padding:0;padding-bottom:8px;word-break:break-word;">
                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                                   style="border-collapse:collapse;border-spacing:0px;">
                                                <tbody>
                                                <tr>
                                                    <td style="width:113px;">
                                                        <img height="auto"
                                                            src="$qrCode"
                                                            style="border:0;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;"
                                                            width="113"/>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" style="font-size:0px;padding:0;word-break:break-word;">
                                            <div
                                                style="font-family:DM Sans, sans-serif;font-size:8px;font-weight:500;line-height:1;text-align:left;color:#3F424E;">
                                                To verify authenticity of this statement please scan the qr code
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!--[if mso | IE]></td></tr></table>
            <table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;"
                   width="600">
                <tr>
                    <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
            <div style="margin:0px auto;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                    <tbody>
                    <tr>
                        <td style="direction:ltr;font-size:0px;padding:0;text-align:center;"><!--[if mso | IE]>
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="" style="vertical-align:top;width:600px;"><![endif]-->
                            <div class="mj-column-per-100 mj-outlook-group-fix"
                                 style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                    <tbody>
                                    <tr>
                                        <td style="vertical-align:top;padding:0;">
                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style=""
                                                   width="100%">
                                                <tbody>
                                                <tr>
                                                    <td align="center" style="font-size:0px;padding:0;word-break:break-word;"><p
                                                            style="border-top:solid 1px #F1F2F4;font-size:1px;margin:0px auto;width:100%;"></p>
                                                        <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" style="border-top:solid 1px #F1F2F4;font-size:1px;margin:0px auto;width:100%;" role="presentation" width="531px" ><tr><td style="height:0;line-height:0;"> &nbsp; </td></tr></table><![endif]-->
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!--[if mso | IE]></td></tr></table>
            <table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;"
                   width="600">
                <tr>
                    <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
            <div style="margin:0px auto;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                    <tbody>
                    <tr>
                        <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:16px;padding-left:32px;padding-right:32px;padding-top:24px;text-align:center;">
                            <!--[if mso | IE]>
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="" style="vertical-align:top;width:536px;"><![endif]-->
                            <div class="mj-column-per-100 mj-outlook-group-fix"
                                 style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                       style="vertical-align:top;" width="100%">
                                    <tbody>
                                    <tr>
                                        <td align="left" style="font-size:0px;padding:0;word-break:break-word;">
                                            <div
                                                style="font-family:DM Sans, sans-serif;font-size:14px;font-weight:700;line-height:1;text-align:left;color:#22242B;">
                                                Account details
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!--[if mso | IE]></td></tr></table>
            <table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;"
                   width="600">
                <tr>
                    <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
            <div style="margin:0px auto;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                    <tbody>
                    <tr>
                        <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:24px;padding-left:32px;padding-right:32px;padding-top:0;text-align:start;">
                            <!--[if mso | IE]>
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="" style="vertical-align:top;width:125px;"><![endif]-->
                            <div class="mj-column-px-125 mj-outlook-group-fix"
                                 style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                    <tbody>
                                    <tr>
                                        <td style="vertical-align:top;padding:0;padding-right:32px;">
                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style=""
                                                   width="100%">
                                                <tbody>
                                                <tr>
                                                    <td align="left"
                                                        style="font-size:0px;padding:0;padding-bottom:4px;word-break:break-word;">
                                                        <div
                                                            style="font-family:DM Sans, sans-serif;font-size:12px;font-weight:700;line-height:1;text-align:left;color:#22242B;">
                                                            Account Name
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left"
                                                        style="font-size:0px;padding:0;padding-bottom:16px;word-break:break-word;">
                                                        <div
                                                            style="font-family:DM Sans, sans-serif;font-size:10px;font-weight:500;line-height:1;text-align:left;color:#3F424E;">
                                                            $accountName
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left"
                                                        style="font-size:0px;padding:0;padding-bottom:4px;word-break:break-word;">
                                                        <div
                                                            style="font-family:DM Sans, sans-serif;font-size:12px;font-weight:700;line-height:1;text-align:left;color:#22242B;">
                                                            Opening Balance
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left"
                                                        style="font-size:0px;padding:0;padding-bottom:16px;word-break:break-word;">
                                                        <div
                                                            style="font-family:DM Sans, sans-serif;font-size:10px;font-weight:500;line-height:1;text-align:left;color:#3F424E;">
                                                            $openingBalance
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left"
                                                        style="font-size:0px;padding:0;padding-bottom:4px;word-break:break-word;">
                                                        <div
                                                            style="font-family:DM Sans, sans-serif;font-size:12px;font-weight:700;line-height:1;text-align:left;color:#22242B;">
                                                            Bonus
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" style="font-size:0px;padding:0;word-break:break-word;">
                                                        <div
                                                            style="font-family:DM Sans, sans-serif;font-size:10px;font-weight:500;line-height:1;text-align:left;color:#3F424E;">
                                                            $bonus
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!--[if mso | IE]></td>
                            <td class="" style="vertical-align:top;width:125px;"><![endif]-->
                            <div class="mj-column-px-125 mj-outlook-group-fix"
                                 style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                    <tbody>
                                    <tr>
                                        <td style="vertical-align:top;padding:0;padding-right:32px;">
                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style=""
                                                   width="100%">
                                                <tbody>
                                                <tr>
                                                    <td align="left"
                                                        style="font-size:0px;padding:0;padding-bottom:4px;word-break:break-word;">
                                                        <div
                                                            style="font-family:DM Sans, sans-serif;font-size:12px;font-weight:700;line-height:1;text-align:left;color:#22242B;">
                                                            Account Type
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left"
                                                        style="font-size:0px;padding:0;padding-bottom:16px;word-break:break-word;">
                                                        <div
                                                            style="font-family:DM Sans, sans-serif;font-size:10px;font-weight:500;line-height:1;text-align:left;color:#3F424E;">
                                                            DAILY INTEREST
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left"
                                                        style="font-size:0px;padding:0;padding-bottom:4px;word-break:break-word;">
                                                        <div
                                                            style="font-family:DM Sans, sans-serif;font-size:12px;font-weight:700;line-height:1;text-align:left;color:#22242B;">
                                                            Dividends
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left"
                                                        style="font-size:0px;padding:0;padding-bottom:16px;word-break:break-word;">
                                                        <div
                                                            style="font-family:DM Sans, sans-serif;font-size:10px;font-weight:500;line-height:1;text-align:left;color:#3F424E;">
                                                            $sumDividends
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left"
                                                        style="font-size:0px;padding:0;padding-bottom:4px;word-break:break-word;">
                                                        <div
                                                            style="font-family:DM Sans, sans-serif;font-size:12px;font-weight:700;line-height:1;text-align:left;color:#3F424E;">
                                                            Referral payments
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" style="font-size:0px;padding:0;word-break:break-word;">
                                                        <div
                                                            style="font-family:DM Sans, sans-serif;font-size:10px;font-weight:500;line-height:1;text-align:left;color:#3F424E;">
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
                            </div>
                            <!--[if mso | IE]></td>
                            <td class="" style="vertical-align:top;width:125px;"><![endif]-->
                            <div class="mj-column-px-125 mj-outlook-group-fix"
                                 style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                    <tbody>
                                    <tr>
                                        <td style="vertical-align:top;padding:0;">
                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style=""
                                                   width="100%">
                                                <tbody>
                                                <tr>
                                                    <td align="left"
                                                        style="font-size:0px;padding:0;padding-bottom:4px;word-break:break-word;">
                                                        <div
                                                            style="font-family:DM Sans, sans-serif;font-size:12px;font-weight:700;line-height:1;text-align:left;color:#22242B;">
                                                            Account number
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left"
                                                        style="font-size:0px;padding:0;padding-bottom:16px;word-break:break-word;">
                                                        <div
                                                            style="font-family:DM Sans, sans-serif;font-size:10px;font-weight:500;line-height:1;text-align:left;color:#3F424E;">
                                                            $accountNumber
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left"
                                                        style="font-size:0px;padding:0;padding-bottom:4px;word-break:break-word;">
                                                        <div
                                                            style="font-family:DM Sans, sans-serif;font-size:12px;font-weight:700;line-height:1;text-align:left;color:#22242B;">
                                                            Withdrawals
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" style="font-size:0px;padding:0;word-break:break-word;">
                                                        <div
                                                            style="font-family:DM Sans, sans-serif;font-size:10px;font-weight:500;line-height:1;text-align:left;color:#3F424E;">
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
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!--[if mso | IE]></td></tr></table>
            <table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;"
                   width="600">
                <tr>
                    <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
            <div style="margin:0px auto;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                    <tbody>
                    <tr>
                        <td style="direction:ltr;font-size:0px;padding:0;text-align:center;"><!--[if mso | IE]>
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="" style="vertical-align:top;width:600px;"><![endif]-->
                            <div class="mj-column-per-100 mj-outlook-group-fix"
                                 style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                    <tbody>
                                    <tr>
                                        <td style="vertical-align:top;padding:0;">
                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style=""
                                                   width="100%">
                                                <tbody>
                                                <tr>
                                                    <td align="center" style="font-size:0px;padding:0;word-break:break-word;"><p
                                                            style="border-top:solid 1px #F1F2F4;font-size:1px;margin:0px auto;width:100%;"></p>
                                                        <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" style="border-top:solid 1px #F1F2F4;font-size:1px;margin:0px auto;width:100%;" role="presentation" width="531px" ><tr><td style="height:0;line-height:0;"> &nbsp; </td></tr></table><![endif]-->
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!--[if mso | IE]></td></tr></table>
            <table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;"
                   width="600">
                <tr>
                    <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
            <div style="margin:0px auto;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                    <tbody>
                    <tr>
                        <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:16px;padding-left:32px;padding-right:32px;padding-top:24px;text-align:center;">
                            <!--[if mso | IE]>
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="" style="vertical-align:top;width:536px;"><![endif]-->
                            <div class="mj-column-per-100 mj-outlook-group-fix"
                                 style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                       style="vertical-align:top;" width="100%">
                                    <tbody>
                                    <tr>
                                        <td align="left" style="font-size:0px;padding:0;word-break:break-word;">
                                            <div
                                                style="font-family:DM Sans, sans-serif;font-size:14px;font-weight:700;line-height:1;text-align:left;color:#22242B;">
                                                Transactions
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!--[if mso | IE]></td></tr></table>
            <table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;"
                   width="600">
                <tr>
                    <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
            <div style="margin:0px auto;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                    <tbody>
                    <tr>
                        <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:24px;padding-left:32px;padding-right:32px;padding-top:0;text-align:start;">
                            <!--[if mso | IE]>
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="" style="vertical-align:top;width:100px;"><![endif]-->
                            <div class="mj-column-px-100 mj-outlook-group-fix"
                                 style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                    <tbody>
                                    <tr>
                                        <td style="vertical-align:top;padding:0;padding-right:16px;">
                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style=""
                                                   width="100%">
                                                <tbody>
                                                $rowsTransactionsDates
                                                <tr>
                                                    <td align="left" style="font-size:0px;padding:0;word-break:break-word;">
                                                        <div
                                                            style="font-family:DM Sans, sans-serif;font-size:10px;font-weight:700;line-height:1;text-align:left;color:#3F424E;">
                                                            Closing balance
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!--[if mso | IE]></td>
                            <td class="" style="vertical-align:top;width:268px;"><![endif]-->
                            <div class="mj-column-per-50 mj-outlook-group-fix"
                                 style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                    <tbody>
                                    <tr>
                                        <td style="vertical-align:top;padding:0;">
                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style=""
                                                   width="100%">
                                                <tbody>
                                                $rowsTransactionsMessages
                                                <tr>
                                                    <td align="left" style="font-size:0px;padding:0;word-break:break-word;">
                                                        <div
                                                            style="font-family:DM Sans, sans-serif;font-size:10px;font-weight:700;line-height:1;text-align:left;color:#22242B;">
                                                            $closingBalance
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!--[if mso | IE]></td></tr></table>
            <table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;"
                   width="600">
                <tr>
                    <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
            <div style="margin:0px auto;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                    <tbody>
                    <tr>
                        <td style="direction:ltr;font-size:0px;padding:0;text-align:center;"><!--[if mso | IE]>
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="" style="vertical-align:top;width:600px;"><![endif]-->
                            <div class="mj-column-per-100 mj-outlook-group-fix"
                                 style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                    <tbody>
                                    <tr>
                                        <td style="vertical-align:top;padding:0;">
                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style=""
                                                   width="100%">
                                                <tbody>
                                                <tr>
                                                    <td align="center" style="font-size:0px;padding:0;word-break:break-word;"><p
                                                            style="border-top:solid 1px #F1F2F4;font-size:1px;margin:0px auto;width:100%;"></p>
                                                        <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" style="border-top:solid 1px #F1F2F4;font-size:1px;margin:0px auto;width:100%;" role="presentation" width="531px" ><tr><td style="height:0;line-height:0;"> &nbsp; </td></tr></table><![endif]-->
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        </body>
        </html>
    HTML;
};
