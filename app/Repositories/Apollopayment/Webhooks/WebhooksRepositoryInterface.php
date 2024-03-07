<?php

declare(strict_types=1);

namespace App\Repositories\Apollopayment\Webhooks;

use App\Dto\Models\Apollopayment\WebhooksDto;

interface WebhooksRepositoryInterface
{
    public function create(WebhooksDto $dto): WebhooksDto;

    public function get(array $filters): ?WebhooksDto;

    public function update(array $condition, array $data): void;

    public function delete(array $condition): void;
}