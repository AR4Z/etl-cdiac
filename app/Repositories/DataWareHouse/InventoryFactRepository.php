<?php

namespace App\Repositories\DataWareHouse;

use App\Repositories\AppBaseRepository;
use Illuminate\Container\Container;
use App\Entities\DataWareHouse\InventoryFact;

class InventoryFactRepository extends AppBaseRepository implements FactRepositoryContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(InventoryFact::class)->setRepositoryId('rinvex.repository.uniqueid');
    }
}