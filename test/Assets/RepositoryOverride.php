<?php

declare(strict_types=1);

namespace XDevApiTest\Assets;

use XDevApi\Repository\CollectionRepository;

class RepositoryOverride extends CollectionRepository
{
    /**
     * @var string
     */
    protected $findAllSort = '$.date_created ASC';
}
