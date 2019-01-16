<?php

namespace App\Repositories\DataWareHouse;

use App\Repositories\AppGeneralRepositoryBaseTrait;
use Illuminate\Container\Container;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\DataWareHouse\WeatherFact;

class WeatherFactRepository extends EloquentRepository implements FactRepositoryContract
{
    use AppGeneralRepositoryBaseTrait;

    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(WeatherFact::class)->setRepositoryId('rinvex.repository.uniqueid');
    }
}