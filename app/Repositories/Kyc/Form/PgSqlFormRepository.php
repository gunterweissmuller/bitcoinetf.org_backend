<?php

declare(strict_types=1);

namespace App\Repositories\Kyc\Form;

use App\Dto\Models\Kyc\FormDto;
use App\Models\Kyc\Form;
use Illuminate\Support\Collection;

final class PgSqlFormRepository implements FormRepositoryInterface
{
    public function __construct(
        private readonly Form $model,
    ) {
    }

    public function create(FormDto $dto): FormDto
    {
        $model = $this->model
            ->newQuery()
            ->create(array_filter($dto->toArray()));

        return FormDto::fromArray($model->toArray());
    }

    public function get(array $filters, array $order = []): ?FormDto
    {
        $model = $this->model
            ->newQuery()
            ->where($filters)
            ->orderBy('created_at', 'desc')
            ->first();

        return $model ? FormDto::fromArray($model->toArray()) : null;
    }

    public function update(array $condition, array $data): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->update($data);
    }

    public function all(array $filters): ?Collection
    {
        $rows = $this->model
            ->newQuery()
            ->where($filters)
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();

        return $rows ? Collection::make($rows)->map(function (array $row) {
            return FormDto::fromArray($row);
        }) : null;
    }

    public function delete(array $condition): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->delete();
    }
}
