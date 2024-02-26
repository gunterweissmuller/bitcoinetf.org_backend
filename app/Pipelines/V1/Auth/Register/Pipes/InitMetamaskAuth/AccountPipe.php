<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\InitMetamaskAuth;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitMetamaskPipelineDto;
use App\Enums\Users\Account\StatusEnum;
use App\Enums\Users\Account\TypeEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\AccountService;
use Closure;
use Faker\Factory as Faker;

final class AccountPipe implements PipeInterface
{
    public function __construct(
        private readonly AccountService $accountService,
    ) {
    }

    public function handle(InitMetamaskPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if (!$dto->getIsExistsEmail() && !$dto->getIsExistsWallet()) {
            $faker = Faker::create();

            $account = $dto->getAccount();
            $account->setType(TypeEnum::Client->value);
            $account->setStatus(StatusEnum::AwaitConfirm->value);
            $account->setUsername(strtolower($faker->userName().rand(10000, 100000)));

            $account = $this->accountService->create($account);

            $dto->setAccount($account);
        } else {
            if ($dto->getIsExistsEmail()) {
                $accountUuid = $dto->getEmail()->getAccountUuid();
            } else {
                $accountUuid = $dto->getWallet()->getAccountUuid();
            }
            $dto->setAccount($this->accountService->get(['uuid' => $accountUuid]));
        }

        return $next($dto);
    }
}
