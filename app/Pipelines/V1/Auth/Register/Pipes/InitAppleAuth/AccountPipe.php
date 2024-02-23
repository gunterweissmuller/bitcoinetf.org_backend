<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\InitAppleAuth;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitApplePipelineDto;
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

    public function handle(InitApplePipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if (!$dto->getIsExists()) {
            $faker = Faker::create();

            $account = $dto->getAccount();
            $account->setType(TypeEnum::Client->value);
            $account->setStatus(StatusEnum::AwaitConfirm->value);
            $account->setUsername(strtolower($faker->userName().rand(10000, 100000)));

            $account = $this->accountService->create($account);

            $dto->setAccount($account);
        } else {
            $appleAccount = $dto->getAppleAccount();
            $dto->setAccount($this->accountService->get(['uuid' => $appleAccount->getAccountUuid()]));
        }

        return $next($dto);
    }
}
