<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Referrals;

use App\Dto\Core\PaginationFilterDto;
use App\Dto\Models\Referrals\CodeDto;
use App\Enums\Referrals\Code\StatusEnum;
use App\Helpers\CodeHelper;
use App\Repositories\Referrals\Code\CodeRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class CodeService
{
    public function __construct(
        private readonly CodeRepositoryInterface $repository,
    ) {
    }

    public function create(CodeDto $dto): CodeDto
    {
        $dto->setCode($dto->getCode() ?? $this->generateNewCode());
        $dto->setStatus(StatusEnum::Enabled->value);

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

    public function allByFilters(PaginationFilterDto $dto): LengthAwarePaginator
    {
        $dto->setPage($dto->getPage() ?? config('app.pagination.page'));
        $dto->setPerPage($dto->getPerPage() ?? config('app.pagination.per_page'));

        return $this->repository->allByFilters($dto);
    }

    public function generateNewCode(): string
    {
        $code = CodeHelper::generatePromoCode();

        if ($this->repository->get(['code' => $code])) {
            $code = $this->generateNewCode();
        }

        return $code;
    }
}
