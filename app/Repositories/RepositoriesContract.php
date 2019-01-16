<?php

namespace App\Repositories;

use Illuminate\Container\Container;
use Illuminate\Database\Query\Builder;
use Rinvex\Repository\Contracts\CacheableContract;
use Rinvex\Repository\Contracts\RepositoryContract;

interface RepositoriesContract extends RepositoryContract, CacheableContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container);

    /**
     * @return Builder
     */
    public function queryBuilder() : Builder;
}