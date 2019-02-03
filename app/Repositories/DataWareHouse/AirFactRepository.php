<?php

namespace App\Repositories\DataWareHouse;

use App\Repositories\BaseFactStructureContract;
use App\Repositories\BaseFactStructureRepository;
use Illuminate\Container\Container;
use App\Entities\DataWareHouse\AirFact;

class AirFactRepository extends BaseFactStructureRepository implements BaseFactStructureContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(AirFact::class)->setRepositoryId('rinvex.repository.uniqueid');
    }
}