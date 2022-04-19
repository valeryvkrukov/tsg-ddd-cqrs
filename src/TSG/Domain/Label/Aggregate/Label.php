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
use TSG\Domain\Label\ValueObject\LabelShortName;

#[Aggregate]
class Label
{
    use WithAggregateEvents;

    #[AggregateIdentifier]
    private int $labelId;
    private LabelShortName $shortName;
    private ?string $reportName;

    private function __construct(int $labelId, LabelShortName $shortName, string $reportName = null)
    {
        $this->labelId = $labelId;
        $this->shortName = $shortName;
        $this->reportName = $reportName;

        $this->recordThat(new LabelWasRegisteredEvent($labelId));
    }

    #[CommandHandler('label.register')]
    public static function register(RegisterLabelCommand $command): self
    {
        return new self($command->getLabelId(), $command->getShortName());
    }

    #[QueryHandler('label.getLabel')]
    public function getLabel(GetLabelQuery $query): LabelShortName
    {
        return $this->shortName;
    }
}