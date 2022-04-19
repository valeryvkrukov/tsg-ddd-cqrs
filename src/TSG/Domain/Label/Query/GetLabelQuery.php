<?php

namespace TSG\Domain\Label\Query;


class GetLabelQuery
{
    private int $labelId;

    public function getLabelId(): int
    {
        return $this->labelId;
    }
}