<?php

namespace App\Repositories\DataWareHouse;

use App\Repositories\AppBaseRepository;
use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use App\Entities\DataWareHouse\EventRainfallFact;

class EventRainfallFactRepository  extends AppBaseRepository implements RepositoriesContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(EventRainfallFact::class)->setRepositoryId('rinvex.repository.uniqueid');
    }
}