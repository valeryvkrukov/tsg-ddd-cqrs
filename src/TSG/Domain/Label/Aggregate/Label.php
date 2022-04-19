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
use TSG\Domain\Label\UserService;
use TSG\Domain\Label\Command\RegisterLabelCommand;
use TSG\Domain\Label\Command\ChangeLabelCommand;
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
    public static function register(
        #[Payload] RegisterLabelCommand $command, 
        #[Headers] array $metadata, 
        #[Reference('user-service')] UserService $userService
    ): self {
        $userId = $metadata['userId'];
        if (!$userService->isAdmin($userId)) {
            throw new \InvalidArgumentException('You need to be administrator in order to register new label');
        }

        return new self($command->getLabelId(), $command->getShortName(), null, $metadata['userId']);
    }

    #[CommandHandler('label.changeLabelShortName')]
    public function changeLabelShortName(ChangeLabelCommand $command, array $metadata): void
    {
        if ($metadata['userId'] !== $this->userId) {
            throw new \InvalidArgumentException('You are not allowed to change this label');
        }
        
        $this->shortName = $command->getLabelShortName();
    }

    #[QueryHandler('label.getLabel')]
    public function getLabel(GetLabelQuery $query): LabelShortName
    {
        return $this->shortName;
    }
}