<?php


namespace App\Repositories\Administrator;


use App\Repositories\DataWareHouse\BaseFactRepository;
use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use App\Entities\Administrator\Zone;

class ZoneRepository extends BaseFactRepository implements RepositoriesContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(Zone::class)->setRepositoryId('rinvex.repository.uniqueid');
    }
}