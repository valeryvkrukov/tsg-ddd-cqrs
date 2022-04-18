<?php

namespace TSG\Domain\Label\Command;


class RegisterLabelCommand
{
    private int $labelId;
    private string $shortName;
    private ?string $reportName;

    public function __construct(int $labelId, string $shortName, string $reportName = null)
    {
        $this->labelId = $labelId;
        $this->shortName = $shortName;
        $this->reportName = $reportName;
    }

    public function getLabelId(): int
    {
        return $this->labelId;
    }

    public function getShortName(): string
    {
        return $this->shortName;
    }

    public function getReportName(): string
    {
        return $this->reportName;
    }
}