<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Pap;

include app_path() . '/Helpers/PapApiNamespace.class.php';

use App\Dto\Models\Pap\TrackingDto;
use App\Repositories\Pap\Tracking\TrackingRepositoryInterface;
use App\Enums\Pap\Event\EventEnum;
use App\Enums\Pap\Asset\AssetEnum;
use Qu\Pap\Api\Pap_Api_SaleTracker;

final class TrackingService
{
    public function __construct(
        private readonly TrackingRepositoryInterface $repository,
    ) {
    }

    public function create(TrackingDto $dto): TrackingDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?TrackingDto
    {
        return $this->repository->get($filters);
    }

    public function update(array $condition, array $data): void
    {
        $this->repository->update($condition, $data);
    }

    public function delete(array $condition): void
    {
        $this->repository->delete($condition);
    }

    public function createSignup(string $account_uuid, string $pap_id, string $utm_label): TrackingDto
    {
        $saleTracker = new Pap_Api_SaleTracker(PAP_SALE_TRACKER_HOST);
        $saleTracker->setAccountId(PAP_ACCOUNT_ID);
        $sale1 = $saleTracker->createAction('signup');
        $saleTracker->register();
        $dto = new TrackingDto(
            null,
            $account_uuid,
            EventEnum::Signup->value,
            $pap_id,
            $utm_label,
            null,
            null,
            null,
            null,
        );
        return $this->repository->create($dto);
    }

    public function createSale(string $account_uuid, float $real_amount, string $amount_type): TrackingDto
    {
        $saleTracker = new Pap_Api_SaleTracker(PAP_SALE_TRACKER_HOST);
        $saleTracker->setAccountId(PAP_ACCOUNT_ID);
        $sale1 = $saleTracker->createSale();
        $sale1->setTotalCost($real_amount);
        $saleTracker->register();
        $dto = new TrackingDto(
            null,
            $account_uuid,
            EventEnum::Sale->value,
            null,
            null,
            $real_amount,
            $amount_type,
            null,
            null,
        );
        return $this->repository->create($dto);
    }
}
