<?php

declare(strict_types=1);


namespace XDevApi\Repository;


use mysql_xdevapi\Collection;
use mysql_xdevapi\Result;
use mysql_xdevapi\Schema;
use XDevApi\Entity\DocumentEntityInterface;

final class CollectionRepository implements CollectionDocumentInterface
{
    /**
     * @var Collection
     */
    private $collection;

    /**
     * @var Schema
     */
    private $schema;
    /**
     * @param Schema $schema
     * @param string $table
     */
    public function __construct(Schema $schema, string $table)
    {
        $this->schema       = $schema;
        $this->collection   = $schema->getCollection($table);
    }

    /**
     * Get collection from the database.
     * @return Collection
     */
    public function getCollection(): Collection
    {
        return $this->collection;
    }

    /**
     * Counts all records in database
     * @return int
     */
    public function count(): int
    {
        return $this->getCollection()->count();
    }

    /**
     * Simple find all documents in collection for pagination
     * $offset and $limit are mandatory.
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function findAll(int $offset, int $limit): array
    {
        $result = $this->getCollection()
            ->find('true')
            ->offset($offset)
            ->limit($limit)
            ->execute()
            ->fetchAll();
        return $result;
    }

    /**
     * Save document entity to database either creates a new document or
     * replaces an existing one.
     * @param DocumentEntityInterface $entity
     * @return Result
     */
    public function save(DocumentEntityInterface $entity): Result
    {
        return $this->getCollection()
            ->addOrReplaceOne(
                $entity->getId(),
                json_encode($entity)
            );
    }

    /**
     * Deletes document entity from database
     * @param DocumentEntityInterface $entity
     * @return Result
     */
    public function delete(DocumentEntityInterface $entity): Result
    {
        return $this->getCollection()
            ->removeOne($entity->getId());
    }
}
