<?php

namespace App\Repositories\DataWareHouse;

use Illuminate\Container\Container;
use App\Entities\DataWareHouse\GroundwaterFact;

class GroundwaterFactRepository extends BaseFactRepository implements FactRepositoryContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(GroundwaterFact::class)->setRepositoryId('rinvex.repository.uniqueid');
    }
}