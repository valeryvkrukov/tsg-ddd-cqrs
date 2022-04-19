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
        $this->commandBus->sendWithRouting('label.register', \json_encode([
            'labelId' => 1,
            'shortName' => 'Test SHORT NAME',
        ]), 'application/json');

        $this->commandBus->sendWithRouting('label.changeLabelShortName', \json_encode([
            'labelId' => 1,
            'shortName' => 'Test SHORT NAME changed',
        ]), 'application/json');

        echo $this->queryBus->sendWithRouting('label.getLabel', \json_encode([
            'labelId' => 1,
        ]), 'application/json');
    }
}