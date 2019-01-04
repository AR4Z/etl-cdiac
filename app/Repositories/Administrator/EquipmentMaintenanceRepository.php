<?php


namespace App\Repositories\Administrator;

use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Administrator\EquipmentMaintenance;
use App\Repositories\AppGeneralRepositoryBaseTrait;

class EquipmentMaintenanceRepository extends EloquentRepository implements RepositoriesContract
{
    use AppGeneralRepositoryBaseTrait;

    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(EquipmentMaintenance::class)->setRepositoryId('rinvex.repository.uniqueid');
    }
}