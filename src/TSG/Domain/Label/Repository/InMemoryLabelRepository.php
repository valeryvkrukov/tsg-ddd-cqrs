<?php

namespace TSG\Domain\Label\Repository;


use Ecotone\Modelling\Attribute\Repository;
use Ecotone\Modelling\StandardRepository;
use TSG\Domain\Label\Aggregate\Label;

#[Repository]
class InMemoryLabelRepository implements StandardRepository
{
    private $labels = [];

    public function canHandle(string $aggregateClassName): bool
    {
        return $aggregateClassName === Label::class;
    }

    public function findBy(string $aggregateClassName, array $identifiers): ?object
    {
        if (!array_key_exists($identifiers['labelId'], $this->labels)) {
            return null;
        }

        return $this->labels[$identifiers['labelId']];
    }

    public function save(array $identifiers, object $aggregate, array $metadata, ?int $expectedVersion): void
    {
        $this->labels[$identifiers['labelId']] = $aggregate;
    }
}