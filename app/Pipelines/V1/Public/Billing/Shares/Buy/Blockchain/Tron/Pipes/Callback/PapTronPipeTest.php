<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Shares\Buy\Blockchain\Tron\Pipes\Callback;

use App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\Blockchain\Tron\CallbackPipelineDto;
use App\Enums\Billing\Replenishment\StatusEnum;
use App\Pipelines\V1\Public\Billing\Shares\Buy\Blockchain\Tron\Pipes\Callback\PapTronPipe;
use App\Services\Api\V1\Pap\TrackingService;
use Closure;
use PHPUnit\Framework\TestCase;

class PapTronPipeTest extends TestCase
{
    public function testHandle(): void
    {
        // Create a mock instance of the dependencies
        $trackingServiceMock = $this->createMock(TrackingService::class);
        $dtoMock = $this->createMock(CallbackPipelineDto::class);
        $nextClosureMock = $this->createMock(Closure::class);

        // Set up the expectations for the mock objects
        $accountUuid = '123456';
        $dtoMock->expects($this->once())
            ->method('getAccount')
            ->willReturn($this->createMock(DtoInterface::class));
        $dtoMock->getAccount()->expects($this->once())
            ->method('getUuid')
            ->willReturn($accountUuid);
        $trackingServiceMock->expects($this->once())
            ->method('get')
            ->with(['account_uuid' => $accountUuid])
            ->willReturn(null);
        $dtoMock->expects($this->once())
            ->method('getReplenishment')
            ->willReturn($this->createMock(DtoInterface::class));
        $dtoMock->getReplenishment()->expects($this->once())
            ->method('getStatus')
            ->willReturn(StatusEnum::SUCCESS->value);
        $dtoMock->getReplenishment()->expects($this->once())
            ->method('getRealAmount')
            ->willReturn(100);
        $trackingServiceMock->expects($this->once())
            ->method('createSale')
            ->with($accountUuid, 100, AssetEnum::Tron->value);

        // Create an instance of the PapTronPipe class
        $pipe = new PapTronPipe($trackingServiceMock);

        // Call the handle method and assert the result
        $result = $pipe->handle($dtoMock, $nextClosureMock);
        $this->assertInstanceOf(DtoInterface::class, $result);
    }
}
