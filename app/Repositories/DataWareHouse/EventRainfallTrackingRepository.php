<?php

namespace App\Repositories\DataWareHouse;

use App\Repositories\AppBaseRepository;
use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use App\Entities\DataWareHouse\EventRainfallTracking;

class EventRainfallTrackingRepository extends AppBaseRepository implements RepositoriesContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(EventRainfallTracking::class)->setRepositoryId('rinvex.repository.uniqueid');
    }
}