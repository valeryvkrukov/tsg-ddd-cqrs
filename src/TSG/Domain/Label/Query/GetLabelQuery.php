<?php

namespace TSG\Domain\Label\Query;


class GetLabelQuery
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