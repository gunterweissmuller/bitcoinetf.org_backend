<?php

declare(strict_types=1);

namespace App\Pipelines\V3\Public\Billing\Shares\Buy\Pipes\Init;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V3\Public\Billing\Shares\Buy\InitPipelineDto;
use App\Exceptions\Pipelines\V1\Billing\ReplenishmentNotAvailableException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V3\Apollopayment\ApollopaymentService;
use Closure;
use Exception;
use App\Services\Api\V1\Users\EmailService;
use App\Services\Api\V1\Users\ProfileService;
use App\Services\Api\V3\Apollopayment\ApollopaymentClientsService;

final readonly class ApolloClientPipe implements PipeInterface
{
    public function __construct(
        private ApollopaymentService $apollopaymentService,
        private EmailService $emailService,
        private ProfileService $profileService,
        private ApollopaymentClientsService $apollopaymentClient,
    )
    {
    }

    public function handle(InitPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $email = $this->emailService->get(['account_uuid' => $dto->getAccount()->getUuid()]);
        $profile = $this->profileService->get(['account_uuid' => $dto->getAccount()->getUuid()]);
        $apollopaymentClient = $this->apollopaymentClient->get(['account_uuid' => $dto->getAccount()->getUuid()]);
        try {
            $this->apollopaymentService->createUser(
                $dto->getAccount()->getUuid(),
                $email->getEmail(),
                $profile->getFullName(),
                $apollopaymentClient
            );
        } catch (Exception $e) {
            throw new ReplenishmentNotAvailableException();
        }

        return $next($dto);
    }
}
