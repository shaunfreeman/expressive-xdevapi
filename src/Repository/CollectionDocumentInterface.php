<?php

declare(strict_types=1);

namespace XDevApi\Repository;

use mysql_xdevapi\Collection;
use mysql_xdevapi\Result;
use XDevApi\Entity\DocumentEntityInterface;

interface CollectionDocumentInterface extends RepositoryInterface
{
    /**
     * Get collection from the database.
     * @return Collection
     */
    public function getCollection(): Collection;

    /**
     * Save entity to database either creates a new document or
     * replaces an existing one.
     * @param DocumentEntityInterface $entity
     * @return Result
     */
    public function save(DocumentEntityInterface $entity): Result;

    /**
     * Deletes entity from database
     * @param DocumentEntityInterface $entity
     * @return Result
     */
    public function delete(DocumentEntityInterface $entity): Result;
}
