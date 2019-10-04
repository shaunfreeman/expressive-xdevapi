<?php

declare(strict_types=1);


namespace XDevApi\Repository;


use mysql_xdevapi\Collection;
use mysql_xdevapi\Result;
use mysql_xdevapi\Schema;

interface CollectionDocumentInterface
{
    public function __construct(Schema $schema);

    public function getCollection(): Collection;

    public function findAll(int $offset, int $limit): array;

    public function save(string $doc): Result;

    public function delete(string $id): Result;
}
