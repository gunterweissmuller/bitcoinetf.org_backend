<?php

declare(strict_types=1);

namespace App\Repositories\Kyc\Form;

use App\Dto\Models\Kyc\FormDto;
use Illuminate\Support\Collection;

interface FormRepositoryInterface
{
    public function create(FormDto $dto): FormDto;

    public function get(array $filters): ?FormDto;

    public function update(array $condition, array $data): void;

    public function all(array $filters): ?Collection;

    public function delete(array $condition): void;
}
