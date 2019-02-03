<?php

namespace App\Repositories\DataWareHouse;

use App\Repositories\AppBaseRepository;
use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use App\Entities\DataWareHouse\SourceDim;

class SourceDimRepository extends AppBaseRepository implements RepositoriesContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(SourceDim::class)->setRepositoryId('rinvex.repository.uniqueid');
    }
}