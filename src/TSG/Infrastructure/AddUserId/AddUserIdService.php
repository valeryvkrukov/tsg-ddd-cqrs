<?php

namespace TSG\Infrastructure\AddUserId;


use Ecotone\Messaging\Attribute\Interceptor\Before;

class AddUserIdService
{
    #[Before(precedence: 0, pointcut: AddUserId::class, changeHeaders: true)]
    public function add(): array
    {
        return ['userId' => 1];
    }
}