<?php

declare(strict_types=1);

namespace ShaunFreeman\PhpMysqlXdevapi\Test\Assets;

use ShaunFreeman\PhpMysqlXdevapi\Repository\CollectionRepository;

class RepositoryOverride extends CollectionRepository
{
    /**
     * @var string
     */
    protected $findAllSort = '$.date_created ASC';
}
