<?php

namespace TSG;


use Ecotone\Modelling\CommandBus;
use Ecotone\Modelling\QueryBus;
use TSG\Domain\Label\Query\GetLabelQuery;
use TSG\Domain\Label\Command\RegisterLabelCommand;

class EcotoneQuickstart
{
    private CommandBus $commandBus;
    private QueryBus $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    public function run() : void
    {
        $this->commandBus->send(new RegisterLabelCommand(1, 'Test label message'));

        echo $this->queryBus->send(new GetLabelQuery(1));
    }
}