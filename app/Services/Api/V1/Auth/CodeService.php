<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Auth;

use App\Dto\Models\Auth\CodeDto;
use App\Enums\Auth\Code\TypeEnum;
use App\Helpers\CodeHelper;
use App\Repositories\Auth\Code\CodeRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

final class CodeService
{
    public function __construct(
        private readonly CodeRepositoryInterface $repository,
    ) {
    }

    public function create(CodeDto $dto): CodeDto
    {
        $expiresTime = Carbon::now()->addMinutes(10)->format('Y-m-d H:i:s');

        if ($dto->getType() == TypeEnum::PasswordRecovery->value) {
            $dto->setCode(CodeHelper::generate(32, CodeHelper::TYPE_WEB3));
        } else {
            $dto->setCode(CodeHelper::generate(6));
        }

        $dto->setExpiresAt($expiresTime);

        return $this->repository->create($dto);
    }

    public function get(array $filters): ?CodeDto
    {
        return $this->repository->get($filters);
    }

    public function update(array $condition, array $data): void
    {
        $this->repository->update($condition, $data);
    }

    public function all(array $filters): ?Collection
    {
        return $this->repository->all($filters);
    }

    public function delete(array $condition): void
    {
        $this->repository->delete($condition);
    }
}
