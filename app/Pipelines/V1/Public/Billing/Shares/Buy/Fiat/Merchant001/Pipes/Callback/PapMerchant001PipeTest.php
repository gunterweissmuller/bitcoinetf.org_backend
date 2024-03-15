<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Shares\Buy\Fiat\Merchant001\Pipes\Callback;

use App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\Blockchain\Tron\CallbackPipelineDto;
use App\Enums\Billing\Replenishment\StatusEnum as ReplenishmentStatusEnum;
use App\Enums\Pap\Asset\AssetEnum;
use App\Services\Api\V1\Pap\TrackingService;
use Closure;
use PHPUnit\Framework\TestCase;

final class PapMerchant001PipeTest extends TestCase
{
    public function testHandleShouldCreateSaleWhenReplenishmentStatusIsSuccess(): void
    {
        // Arrange
        $accountUuid = 'account-uuid';
        $realAmount = 100.0;
        $trackingService = $this->createMock(TrackingService::class);
        $dto = $this->createMock(CallbackPipelineDto::class);
        $dto->method('getAccount')->willReturn($this->createMock(DtoInterface::class));
        $dto->method('getReplenishment')->willReturn($this->createMock(DtoInterface::class));
        $dto->getAccount()->method('getUuid')->willReturn($accountUuid);
        $dto->getReplenishment()->method('getStatus')->willReturn(ReplenishmentStatusEnum::SUCCESS->value);
        $dto->getReplenishment()->method('getRealAmount')->willReturn($realAmount);
        $trackingService->expects($this->once())
            ->method('createSale')
            ->with($accountUuid, $realAmount, AssetEnum::FiatMerchant001->value);

        $pipe = new PapMerchant001Pipe($trackingService);

        // Act
        $result = $pipe->handle($dto, function ($dto) {
            return $dto;
        });

        // Assert
        $this->assertSame($dto, $result);
    }
}
