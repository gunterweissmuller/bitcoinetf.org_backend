<?php

declare(strict_types=1);

namespace App\Jobs\V1\Statistic\Report;

use App\Dto\Models\Billing\PaymentDto;
use App\Dto\Models\Statistic\ReportDto;
use App\Dto\Models\Storage\FileDto;
use App\Enums\Billing\Payment\TypeEnum;
use App\Enums\Statistic\Report\TypeEnum as ReportTypeEnum;
use App\Enums\Storage\File\ExtensionEnum;
use App\Enums\Storage\File\StatusEnum;
use App\Enums\Storage\File\TypeEnum as FileTypeEnum;
use App\Enums\Users\Account\OrderTypeEnum;
use App\Jobs\Job;
use App\Jobs\V1\Billing\Report\SendMonthlyDividendStatementMailJob;
use App\Services\Api\V1\Billing\PaymentService;
use App\Services\Api\V1\Billing\WalletService;
use App\Services\Api\V1\Statistic\DailyWalletService;
use App\Services\Api\V1\Statistic\ReportService;
use App\Services\Api\V1\Storage\FileService;
use App\Services\Api\V1\Users\AccountService;
use App\Services\Api\V1\Users\EmailService;
use App\Services\Api\V1\Users\ProfileService;
use App\Services\Utils\DomPdfService;
use chillerlan\QRCode\QRCode;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * @todo обязательно раскидать по pipeline в будущем
 */
final class StatementJob extends Job
{
    use Dispatchable;

    public function __construct(
        private readonly string $accountUuid,
        private readonly string $periodFrom,
        private readonly string $periodTo,
    ) {
        $this->onQueue('statistic.report.monthly_account_report');
        $this->onConnection('database');
    }

    public function handle(
        DomPdfService $domPdfService,
        AccountService $accountService,
        PaymentService $paymentService,
        WalletService $walletService,
        DailyWalletService $dailyWalletService,
        FileService $fileService,
        ReportService $reportService,
        EmailService $emailService,
        ProfileService $profileService,
    ): void {
        $account = $accountService->get(['uuid' => $this->accountUuid]);
        $profile = $profileService->get(['account_uuid' => $this->accountUuid]);

        $walletDividend = $walletService->get([
            'account_uuid' => $account->getUuid(),
            'type' => \App\Enums\Billing\Wallet\TypeEnum::DIVIDENDS->value,
        ]);

        $sumDividends = $paymentService->getSumColumnByPeriod(
            'dividend_amount',
            $this->accountUuid,
            $this->periodFrom,
            $this->periodTo,
        );

        $sumReferral = $paymentService->getSumColumnByPeriod(
            'referral_amount',
            $this->accountUuid,
            $this->periodFrom,
            $this->periodTo,
        );

        $withdrawals = $paymentService->getSumColumnByPeriod(
            'referral_amount',
            $this->accountUuid,
            $this->periodFrom,
            $this->periodTo,
            TypeEnum::WITHDRAWAL->value,
        );

        $startDayTotalBalance = $dailyWalletService->getUserTotalBalance($this->accountUuid, $this->periodFrom);
        $sumPaymentsToFundToStartMonth = $paymentService->getSumPaymentsByPeriod(
            $this->accountUuid,
            $this->periodFrom.' 00:00:00'
        );

        $nowTotalBalance = $walletService->getUserTotalBalance($this->accountUuid);
        $sumPaymentsToFundToEndMonth = $paymentService->getSumPaymentsByPeriod(
            $this->accountUuid,
            $this->periodTo.' 23:59:59',
        );

        if($account->getOrderType() === OrderTypeEnum::USDT->value) {
            $accountType = strtoupper(OrderTypeEnum::USDT->value);
        } else {
            $accountType = strtoupper(OrderTypeEnum::BTC->value);
        }

        $decimalsNumberFormat = $accountType === strtoupper(OrderTypeEnum::USDT->value) ? 6 : 8;

        $payments = $paymentService->all([
            'account_uuid' => $this->accountUuid,
            ['created_at', '>=', $this->periodFrom . ' 00:00:00'],
        ], ['bonus_wallet_uuid'])?->map(function (PaymentDto $payment) use ($decimalsNumberFormat) {
            return [
                'date' => Carbon::createFromDate($payment->getCreatedAt())->format('d M Y'),
                'message' => (function () use ($payment, $decimalsNumberFormat) {
                    return match ($payment->getType()) {
                        TypeEnum::DEBIT_TO_CLIENT->value => 'Daily Interest Payment '.$payment->getTotalAmountBtc().' (BTC) ($'.number_format($payment->getTotalAmount(), $decimalsNumberFormat, '.', '').')',
                        TypeEnum::CREDIT_FROM_CLIENT->value => 'New shares purchased $'.number_format($payment->getTotalAmount()),
                        TypeEnum::WITHDRAWAL->value => 'Withdrawal '.number_format($payment->getTotalAmount()).' $'.number_format($payment->getTotalAmount()),
                    };
                })(),
            ];
        });

        $email = $emailService->get(['account_uuid' => $account->getUuid()]);

        $sumReferral = $sumReferral == 0 ? $sumReferral : number_format($sumReferral, $decimalsNumberFormat, '.', '');

        $openingBalance = $startDayTotalBalance + $sumPaymentsToFundToStartMonth;
        $openingBalance = $openingBalance == 0 ? $openingBalance : number_format($openingBalance, $decimalsNumberFormat, '.', '');

        $closingBalance = $nowTotalBalance + $sumPaymentsToFundToEndMonth;
        $closingBalance = $closingBalance == 0 ? $closingBalance : number_format($closingBalance, $decimalsNumberFormat, '.', '');

        $sumDividends = $sumDividends == 0 ? $sumDividends : number_format($sumDividends, $decimalsNumberFormat, '.', '');

        $withdrawals = $withdrawals == 0 ? $withdrawals : number_format($withdrawals, $decimalsNumberFormat, '.', '');

        $data = [
            'account_name' => strtoupper($account->getUsername()),
            'account_type' => $accountType,
            'account_number' => str_pad((string) $account->getNumber(), 8, '0', STR_PAD_LEFT),
            'account_email' => $email->getEmail(),
            'date' => Carbon::now()->format('d/m/y'),
            'referral_payments' => $sumReferral,
            'withdrawals' => $withdrawals,
            'opening_balance' => $openingBalance,
            'closing_balance' => $closingBalance,
            'payments' => $payments ? $payments->toArray() : [],
            'total_dividends' => $sumDividends,
            'qr_code' => (new QRCode())->render('https://site.ru?email='.$email->getEmail().'&amount='.$sumDividends),
            'address' => $profile?->getCity() ? $profile->getCity() . ', ' . $profile->getCountry() : '',
        ];

        $fileName = hash('sha256', rand(10, 9999).$this->accountUuid).'.pdf';
        Storage::disk('local')->put('pdf/'.$fileName, $domPdfService->create($data));
        $directory = $fileService->getS3DirPath(FileTypeEnum::DividendsReport->value);

        $fileDto = FileDto::fromArray([
            'type' => FileTypeEnum::DividendsReport->value,
            'extension' => ExtensionEnum::PDF->value,
            'status' => StatusEnum::Active->value,
        ]);
        $path = $directory.$fileName;
        Storage::disk('s3')->put($path, Storage::disk('local')->get('pdf/'.$fileName));
        Storage::disk('local')->delete('pdf/'.$fileName);

        $fileDto->setPath($path);
        $fileDto->setRealPath(Storage::disk('s3')->url($path));

        $fileDto = $fileService->create($fileDto);

        $report = $reportService->create(ReportDto::fromArray([
            'account_uuid' => $this->accountUuid,
            'file_uuid' => $fileDto->getUuid(),
            'type' => ReportTypeEnum::MONTHLY_PAYMENTS_REPORT->value,
            'created_at' => Carbon::now()->toDateString(),
        ]));

        dispatch(new SendMonthlyDividendStatementMailJob($report->getAccountUuid(), $email->getEmail(), $report->getUuid()));
    }
}
