<?php

declare(strict_types=1);

namespace App\Events\V1\Users;

use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\EmailDto;
use App\Events\Event;

class NewUserEvent extends Event
{
    public function __construct(
        private readonly AccountDto $account,
        private readonly EmailDto $email
    ) {
    }

    public function getAccount(): AccountDto
    {
        return $this->account;
    }

    public function getEmail(): EmailDto
    {
        return $this->email;
    }
}
