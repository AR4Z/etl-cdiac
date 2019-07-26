<?php


namespace App\Repositories\Administrator;

use App\Entities\Administrator\AlertFlood;
use App\Repositories\AppBaseRepository;
use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;

class AlertFloodRepository extends AppBaseRepository implements RepositoriesContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(AlertFlood::class)->setRepositoryId('rinvex.repository.uniqueid');
    }
}