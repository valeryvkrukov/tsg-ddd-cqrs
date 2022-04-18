<?php

namespace Bootstrap;


use TSG\EcotoneQuickstart;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EcotoneQuickstartCommand extends Command
{
    private $ecotoneQuickstart;

    public function __construct(EcotoneQuickstart $ecotoneQuickstart)
    {
        parent::__construct('ecotone:quickstart');

        $this->ecotoneQuickstart = $ecotoneQuickstart;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("<comment>Running example...</comment>");
        $this->ecotoneQuickstart->run();
        $output->writeln("\n<info>Good job, scenario ran with success!</info>");

        return 0;
    }
}