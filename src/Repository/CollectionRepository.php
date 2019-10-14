<?php

declare(strict_types=1);


namespace XDevApi\Repository;


use Exception;
use mysql_xdevapi\Collection;
use mysql_xdevapi\Result;
use mysql_xdevapi\Schema;
use XDevApi\Entity\DocumentEntity;
use XDevApi\Entity\DocumentEntityInterface;
use XDevApi\Hydrator\DocumentHydrator;

class CollectionRepository implements CollectionDocumentInterface
{
    /**
     * @var string
     */
    protected $findAllString = 'true';

    /**
     * @var string|null
     */
    protected $findAllSort = null;

    /**
     * @var string
     */
    protected $hydrator = DocumentHydrator::class;

    /**
     * @var string
     */
    protected $entity = DocumentEntity::class;

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
     * @throws Exception
     */
    public function findAll(int $offset, int $limit): array
    {
        $query = $this->getCollection()
            ->find($this->findAllString)
            ->offset($offset)
            ->limit($limit);

        if (null !== $this->findAllSort) {
            $query->sort($this->findAllSort);
        }

        $result = $query->execute()
            ->fetchAll();

        if (class_exists($this->hydrator)) {
            $result = $this->hydrate($result);
        }

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

    /**
     * @param array $rows
     * @return array
     * @throws Exception
     */
    private function hydrate(array $rows): array
    {
        /** @var DocumentHydrator $hydrator */
        $hydrator   = new $this->hydrator;
        /** @var DocumentEntity $entity */
        $entity     = new $this->entity;
        $array      = [];

        foreach ($rows as $row) {
            $array[] = $hydrator->hydrate($row, $entity);
        }

        return $array;
    }
}
