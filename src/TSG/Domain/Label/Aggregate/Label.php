<?php

namespace TSG\Domain\Label\Aggregate;


use Ecotone\Modelling\Attribute\Aggregate;
use Ecotone\Modelling\Attribute\AggregateIdentifier;
use Ecotone\Modelling\Attribute\CommandHandler;
use Ecotone\Modelling\Attribute\QueryHandler;
use Ecotone\Modelling\WithAggregateEvents;
use TSG\Domain\Label\Command\RegisterLabelCommand;
use TSG\Domain\Label\Query\GetLabelQuery;
use TSG\Domain\Label\Event\LabelWasRegisteredEvent;

#[Aggregate]
class Label
{
    use WithAggregateEvents;

    #[AggregateIdentifier]
    private int $labelId;
    private string $shortName;
    private ?string $reportName;

    private function __construct(int $labelId, string $shortName, string $reportName = null)
    {
        $this->labelId = $labelId;
        $this->shortName = $shortName;
        $this->reportName = $reportName;

        $this->recordThat(new LabelWasRegisteredEvent($labelId));
    }

    #[CommandHandler]
    public static function register(RegisterLabelCommand $command): self
    {
        return new self($command->getLabelId(), $command->getShortName());
    }

    #[QueryHandler]
    public function getLabel(GetLabelQuery $query): string
    {
        return $this->shortName;
    }
}