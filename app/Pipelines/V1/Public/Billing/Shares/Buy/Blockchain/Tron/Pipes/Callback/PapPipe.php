<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Shares\Buy\Blockchain\Tron\Pipes\Callback;

include app_path() . '/Helpers/PapApiNamespace.class.php';

use App\Dto\DtoInterface;
use App\Dto\Models\Billing\PaymentDto;
use App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\Blockchain\Tron\CallbackPipelineDto;
use App\Enums\Billing\Payment\TypeEnum as PaymentTypeEnum;
use App\Enums\Billing\Replenishment\StatusEnum;
use App\Enums\Billing\Wallet\TypeEnum as WalletTypeEnum;
use App\Enums\Kafka\ProducerEnum;
use App\Jobs\V1\Billing\Buy\UpdateDailyAumJob;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\PaymentService;
use App\Services\Api\V1\Billing\ReplenishmentService;
use App\Services\Api\V1\Billing\WalletService;
use App\Services\Api\V1\Referrals\CodeService;
use App\Services\Api\V1\Referrals\InviteService;
use App\Services\Api\V1\Settings\GlobalService;
use App\Services\Api\V1\Users\AccountService;
use App\Services\Utils\CentrifugalService;
use App\Services\Utils\KafkaProducerService;
use Closure;
use Illuminate\Support\Carbon;
use Qu\Pap\Api\Pap_Api_SaleTracker;

final readonly class PapPipe implements PipeInterface
{
    public function __construct(
        private ReplenishmentService $replenishmentService,
        private PaymentService       $paymentService,
        private GlobalService        $globalService,
        private AccountService       $accountService,
        private InviteService        $inviteService,
        private CodeService          $codeService,
        private WalletService        $walletService,
        private CentrifugalService   $centrifugalService,
    )
    {
    }

    public function handle(CallbackPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $accountUuid = $dto->getAccount()->getUuid();


        $saleTracker = (new Pap_Api_SaleTracker('https://bitcoinetf.postaffiliatepro.com/scripts/sale.php'))->setAccountId('bitcoinetf.postaffiliatepro.com');
        $sale = $saleTracker->createSale();
        $sale->setTotalCost($dto->getReplenishment()->getRealAmount());
        $saleTracker->register();


        return $next($dto);
    }
}
