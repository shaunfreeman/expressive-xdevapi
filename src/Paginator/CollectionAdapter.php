<?php

declare(strict_types=1);


namespace XDevApi\Paginator;


use XDevApi\Repository\CollectionDocumentInterface;
use Zend\Paginator\Adapter\AdapterInterface;

final class CollectionAdapter implements AdapterInterface
{
    /**
     * @var CollectionDocumentInterface
     */
    private $collectionDocument;

    public function __construct(CollectionDocumentInterface $collectionDocument)
    {
        $this->collectionDocument = $collectionDocument;
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
        return $this->collectionDocument->findAll($offset, $itemCountPerPage);
    }

    /**
     * Count elements of an object
     * @return int The count as an integer.
     */
    public function count(): int
    {
        return $this->collectionDocument
            ->getCollection()
            ->count();
    }
}
