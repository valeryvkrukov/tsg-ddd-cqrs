<?php

namespace TSG\Domain\Label\Command;


use TSG\Domain\Label\ValueObject\LabelShortName;

class RegisterLabelCommand
{
    private int $labelId;
    private LabelShortName $shortName;
    private ?string $reportName;

    public function getLabelId(): int
    {
        return $this->labelId;
    }

    public function getShortName(): LabelShortName
    {
        return $this->shortName;
    }

    /*public function getReportName(): string
    {
        return $this->reportName;
    }*/
}