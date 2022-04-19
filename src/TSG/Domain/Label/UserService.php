<?php

namespace TSG\Domain\Label;


class UserService
{
    public function isAdmin(int $userId): bool
    {
        return $userId === 1;
    }
}