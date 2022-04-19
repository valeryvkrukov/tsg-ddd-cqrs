<?php

namespace TSG\Domain\Label\Aggregate;


use Ecotone\Modelling\Attribute\Aggregate;
use Ecotone\Modelling\Attribute\AggregateIdentifier;
use Ecotone\Modelling\Attribute\CommandHandler;
use Ecotone\Modelling\Attribute\QueryHandler;
use Ecotone\Modelling\WithAggregateEvents;
use Ecotone\Messaging\Attribute\Parameter\Payload;
use Ecotone\Messaging\Attribute\Parameter\Headers;
use Ecotone\Messaging\Attribute\Parameter\Reference;
use TSG\Domain\Label\Command\RegisterLabelCommand;
use TSG\Domain\Label\Command\ChangeLabelCommand;
use TSG\Domain\Label\Query\GetLabelQuery;
use TSG\Domain\Label\Event\LabelWasRegisteredEvent;
use TSG\Domain\Label\ValueObject\LabelShortName;
use TSG\Infrastructure\RequireAdministrator\RequireAdministrator;
use TSG\Infrastructure\AddUserId\AddUserId;

#[Aggregate]
#[AddUserId]
class Label
{
    use WithAggregateEvents;

    #[AggregateIdentifier]
    private int $labelId;
    private LabelShortName $shortName;
    private ?string $reportName;
    private int $userId;

    private function __construct(int $labelId, LabelShortName $shortName, string $reportName = null, int $userId)
    {
        $this->labelId = $labelId;
        $this->shortName = $shortName;
        $this->reportName = $reportName;
        $this->userId = $userId;

        $this->recordThat(new LabelWasRegisteredEvent($labelId));
    }

    #[CommandHandler('label.register')]
    #[RequireAdministrator]
    public static function register(RegisterLabelCommand $command, array $metadata): self
    {
        return new self($command->getLabelId(), $command->getShortName(), null, $metadata['userId']);
    }

    #[CommandHandler('label.changeLabelShortName')]
    #[RequireAdministrator]
    public function changeLabelShortName(ChangeLabelCommand $command, array $metadata): void
    {
        $this->shortName = $command->getLabelShortName();
    }

    #[QueryHandler('label.getLabelShortName')]
    public function getLabelShortName(GetLabelQuery $query): LabelShortName
    {
        return $this->shortName;
    }
}