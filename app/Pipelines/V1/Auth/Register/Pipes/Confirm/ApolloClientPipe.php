<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\Confirm;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmPipelineDto;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\EmailService;
use App\Services\Api\V1\Users\ProfileService;
use App\Services\Api\V3\Apollopayment\ApollopaymentClientsService;
use App\Services\Api\V3\Apollopayment\ApollopaymentService;
use Closure;
use Exception;

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

    public function handle(ConfirmPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $email = $this->emailService->get(['email' => $dto->getEmail()->getEmail()]);
        $profile = $this->profileService->get(['account_uuid' => $email->getAccountUuid()]);
        $apollopaymentClient = $this->apollopaymentClient->get(['account_uuid' => $email->getAccountUuid()]);
        try {
            $this->apollopaymentService->createUser(
                $email->getAccountUuid(),
                $dto->getEmail()->getEmail(),
                $profile->getFullName(),
                $apollopaymentClient
            );
        } catch (Exception $e) {
        }

        return $next($dto);
    }
}
