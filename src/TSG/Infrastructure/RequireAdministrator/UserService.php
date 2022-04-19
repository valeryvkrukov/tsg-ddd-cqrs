<?php

namespace TSG\Infrastructure\RequireAdministrator;


use Ecotone\Messaging\Attribute\Parameter\Header;
use Ecotone\Messaging\Attribute\Interceptor\Before;

class UserService
{
    #[Before(precedence: 1, pointcut: RequireAdministrator::class)]
    public function isAdmin(#[Header('userId')] ?string $userId): void
    {
        if ($userId != 1) {
            throw new \InvalidArgumentException('You need to be administrator to perform this action');
        }
    }
}