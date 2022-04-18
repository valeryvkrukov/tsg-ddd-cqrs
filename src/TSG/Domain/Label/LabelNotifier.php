<?php

namespace TSG\Domain\Label;


use Ecotone\Modelling\Attribute\EventHandler;
use TSG\Domain\Label\Event\LabelWasRegisteredEvent;

class LabelNotifier
{
    #[EventHandler]
    public function notifyAbout(LabelWasRegisteredEvent $event): void
    {
        echo "Label with id {$event->getLabelId()} was registered!\n";
    }
}