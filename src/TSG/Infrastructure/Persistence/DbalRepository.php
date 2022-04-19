<?php

namespace TSG\Infrastructure\Persistence;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Ecotone\Messaging\Gateway\Converter\Serializer;
use Ecotone\Modelling\Attribute\Repository;
use Ecotone\Modelling\StandardRepository;

#[Repository]
class DbalRepository implements StandardRepository
{
    const TABLE_NAME = 'aggregate';
    const CONNECTION_DSN = 'sqlite:////tmp/db.sqlite';

    private Connection $connection;
    private Serializer $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->connection = DriverManager::getConnection([
            'url' => self::CONNECTION_DSN,
        ]);
        $this->serializer = $serializer;
    }

    public function canHandle(string $aggregateClassName): bool
    {
        return true;
    }

    public function findBy(string $aggregateClassName, array $identifiers): ?object
    {
        $this->createSharedTableIfNeeded();

        $record = $this->connection->executeQuery(
            'SELECT * FROM aggregate WHERE id = :id AND class = :class',
            [
                'id' => $this->getFirstId($identifiers),
                'class' => $aggregateClassName,
            ]
        )->fetch(\PDO::FETCH_ASSOC);

        if (!$record) {
            return null;
        }

        return $this->serializer->convertToPHP($record['data'], 'application/json', $aggregateClassName);
    }

    public function save(array $identifiers, object $aggregate, array $metadata, ?int $expectedVersion): void
    {
        $this->createSharedTableIfNeeded();

        $aggregateClass = get_class($aggregate);
        $data = $this->serializer->convertFromPHP($aggregate, 'application/json');

        if ($this->findBy($aggregateClass, $identifiers)) {
            $this->connection->update(
                self::TABLE_NAME,
                ['data' => $data],
                [
                    'id' => $this->getFirstId($identifiers),
                    'class' => $aggregateClass,
                ]
            );

            return;
        }

        $this->connection->insert(
            self::TABLE_NAME,
            [
                'id' => $this->getFirstId($identifiers),
                'class' => $aggregateClass,
                'data' => $data,
            ]
        );
    }

    private function createSharedTableIfNeeded(): void
    {
        $hasTable = $this->connection->executeQuery(
            'SELECT name FROM sqlite_master WHERE name=:tableName',
            ['tableName' => self::TABLE_NAME]
        )->fetchColumn();

        if (!$hasTable) {
            $this->connection->executeStatement(
                'CREATE TABLE aggregate (id VARCHAR(255), class VARCHAR(255), data TEXT, PRIMARY KEY (id, class))'
            );
        }
    }

    private function getFirstId(array $identifiers): mixed
    {
        return array_values($identifiers)[0];
    }
}