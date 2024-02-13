<?php

declare(strict_types=1);

namespace App\Events\V1\Auth;

use App\Dto\Models\Users\EmailDto;
use App\Events\Event;

class NewRecoveryEvent extends Event
{
    public function __construct(
        private readonly EmailDto $email
    ) {
    }

    public function getEmail(): EmailDto
    {
        return $this->email;
    }
}
