<?php

namespace TSG\Domain\Label\ValueObject;


class LabelShortName
{
    const MAX_LENGTH = 100;

    private string $name;

    public function __construct(string $name)
    {
        if (strlen($name) > self::MAX_LENGTH) {
            throw new \InvalidArgumentException(sprintf('Label name should be less than %d', self::MAX_LENGTH));
        }

        $this->name = $name;
    }

    public function getShortName(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return (string)$this->name;
    }
}