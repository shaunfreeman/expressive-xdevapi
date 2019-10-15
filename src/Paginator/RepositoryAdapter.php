<?php

declare(strict_types=1);

namespace XDevApi\Paginator;

use XDevApi\Repository\CollectionDocumentInterface;
use XDevApi\Repository\RepositoryInterface;
use Zend\Paginator\Adapter\AdapterInterface;

final class RepositoryAdapter implements AdapterInterface
{
    /**
     * @var CollectionDocumentInterface
     */
    private $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns a collection of items for a page.
     *
     * @param int $offset Page offset
     * @param int $itemCountPerPage Number of items per page
     * @return array
     */
    public function getItems($offset, $itemCountPerPage): array
    {
        return $this->repository->findAll($offset, $itemCountPerPage);
    }

    /**
     * Count elements of an object
     * @return int The count as an integer.
     */
    public function count(): int
    {
        return $this->repository->count();
    }
}
