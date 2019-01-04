<?php

namespace App\Repositories\Administrator;

use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Administrator\Net;
use App\Repositories\AppGeneralRepositoryBaseTrait;

class NetRepository extends EloquentRepository implements RepositoriesContract
{
    use AppGeneralRepositoryBaseTrait;

    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(Net::class)->setRepositoryId('rinvex.repository.uniqueid');
    }

    /**
     * @return Collection
     */
    public function getNetName() : Collection
    {
        return $this->select('id','name')->where('etl_active',true)->pluck('name','id');
    }
}