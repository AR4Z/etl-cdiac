<?php

namespace App\Repositories\DataWareHouse;

use Illuminate\Container\Container;
use App\Entities\DataWareHouse\WeatherFact;

class WeatherFactRepository extends BaseFactRepository implements FactRepositoryContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(WeatherFact::class)->setRepositoryId('rinvex.repository.uniqueid');
    }
}