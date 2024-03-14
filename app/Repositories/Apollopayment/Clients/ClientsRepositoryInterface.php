<?php

declare(strict_types=1);

namespace App\Repositories\Apollopayment\Clients;

use App\Dto\Models\Apollopayment\ClientsDto;

interface ClientsRepositoryInterface
{
    public function create(ClientsDto $dto): ClientsDto;

    public function get(array $filters): ?ClientsDto;

    public function update(array $condition, array $data): void;

    public function delete(array $condition): void;
}