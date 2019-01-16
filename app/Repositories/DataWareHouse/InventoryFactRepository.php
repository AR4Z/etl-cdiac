<?php

namespace App\Repositories\DataWareHouse;

use App\Repositories\AppGeneralRepositoryBaseTrait;
use Illuminate\Container\Container;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\DataWareHouse\InventoryFact;

class InventoryFactRepository extends EloquentRepository implements FactRepositoryContract
{
    use AppGeneralRepositoryBaseTrait;

    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(InventoryFact::class)->setRepositoryId('rinvex.repository.uniqueid');
    }
}