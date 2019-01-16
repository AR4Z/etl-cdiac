<?php

namespace App\Repositories\DataWareHouse;

use App\Repositories\AppGeneralRepositoryBaseTrait;
use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\DataWareHouse\EventRainfallTracking;

class EventRainfallTrackingRepository extends EloquentRepository implements RepositoriesContract
{
    use AppGeneralRepositoryBaseTrait;

    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(EventRainfallTracking::class)->setRepositoryId('rinvex.repository.uniqueid');
    }
}