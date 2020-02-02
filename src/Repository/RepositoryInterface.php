<?php

declare(strict_types=1);

namespace ShaunFreeman\PhpMysqlXdevapi\Repository;

use mysql_xdevapi\Schema;

interface RepositoryInterface
{
    /**
     * @param Schema $schema
     * @param string $table
     */
    public function __construct(Schema $schema, string $table);

    /**
     * Counts all records in database
     * @return int
     */
    public function count(): int;

    /**
     * Simple find all records for pagination
     * $offset and $limit are mandatory.
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function findAll(int $offset, int $limit): array;
}
