<?php

namespace TSG\Domain\Label\Event;


class LabelWasRegisteredEvent
{
    private int $labelId;

    public function __construct(int $labelId)
    {
        $this->labelId = $labelId;
    }

    public function getLabelId(): int
    {
        return $this->labelId;
    }
}