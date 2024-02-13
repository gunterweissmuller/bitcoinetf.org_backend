<?php

declare(strict_types=1);

return function (array $data): string {
    $accountName = $data['account_name'];
    $accountType = ''; //$data['account_type'];
    $accountNumber = $data['account_number'];
    $openingBalance = $data['opening_balance'];
    $withdrawals = $data['withdrawals'];
    $bonus = $data['bonus'];
    $sumDividends = $data['total_dividends'];
    $referralPayments = $data['referral_payments'];
    $closingBalance = $data['closing_balance'];
    $qrCode = $data['qr_code'];

    $rowsText = '';

    foreach ($data['payments'] as $row) {
        $rowsText .= '
                <tr>
                    <td>'.$row['date'].'</td>
                    <td>'.$row['message'].'</td>
                </tr>
            ';
    }

    return <<<HTML
        <!doctype html>
        <html lang="en">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport"
                content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
          <meta http-equiv="X-UA-Compatible" content="ie=edge">
          <title>Document</title>
          <style>
            body{
                max-width: 750px;
                margin: 0 auto;
                font-size: 12px;
                font-family: Arial,sans-serif;
            }
            p{
              margin: 12px 0;
            }
            ol li{
              margin-bottom: 14px;
            }
            ol li ul {
              margin-top: 12px;
            }
            h1{
              text-align: center;
                font-size: 22px;
            }
          </style>

        </head>
        <body>
        <h1><span> $accountName </span></h1>
        <h1><span> $accountType </span></h1>
        <h1><span> $accountNumber </span></h1>
        <h1><span> $openingBalance </span></h1>
        <h1><span> $withdrawals </span></h1>
        <h1><span> $bonus </span></h1>
        <h1><span> $sumDividends </span></h1>
        <h1><span> $referralPayments </span></h1>
        <table> $rowsText </table>
        <h1><span> $closingBalance </span></h1>
        <p><img src="$qrCode"></p>
        </body>
        </html>
    HTML;
};
