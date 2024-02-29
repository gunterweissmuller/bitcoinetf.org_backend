<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Shares\Buy\Blockchain\Tron\Pipes\Callback;

include app_path() . '/Helpers/PapApiNamespace.class.php';

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\Blockchain\Tron\CallbackPipelineDto;
use App\Pipelines\PipeInterface;
use Closure;
use Qu\Pap\Api\Pap_Api_SaleTracker;
use App\Models\Pap\Tracking;
use App\Enums\Pap\Event\EventEnum;
use App\Enums\Pap\Asset\AssetEnum;

final readonly class PapMerchant001Pipe implements PipeInterface
{
    public function __construct()
    {    
    }

    public function handle(CallbackPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $accountUuid = $dto->getAccount()->getUuid();
        $record = Tracking::where('account_uuid', $accountUuid)->first();
        if ($record !== null) {
            $real_amount = $dto->getReplenishment()->getRealAmount();
            $saleTracker = new Pap_Api_SaleTracker(PAP_SALE_TRACKER_HOST);
            $saleTracker->setAccountId(PAP_ACCOUNT_ID);        
            $sale = $saleTracker->createSale();
            $sale->setTotalCost($real_amount);
            $saleTracker->register();
            $tracking = new Tracking();
            $tracking->account_uuid = $accountUuid;
            $tracking->event_type = EventEnum::Sale->value;
            $tracking->real_amount = $real_amount;
            $tracking->amount_type = AssetEnum::FiatMerchant001->value;
            $tracking->save();
        }
        return $next($dto);
    }
}
