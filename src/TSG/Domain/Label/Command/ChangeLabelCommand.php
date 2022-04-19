<?php

namespace TSG\Domain\Label\Command;


use TSG\Domain\Label\ValueObject\LabelShortName;

class ChangeLabelCommand
{
    private int $labelId;
    private LabelShortName $shortName;

    public function getLabelId(): int
    {
        return $this->labelId;
    }

    public function getLabelShortName(): LabelShortName
    {
        return $this->shortName;
    }
}