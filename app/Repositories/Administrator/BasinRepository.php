<?php


namespace App\Repositories\Administrator;

use Illuminate\Container\Container;
use App\Repositories\RepositoriesContract;
use App\Repositories\AppBaseRepository;
use App\Entities\Administrator\Basin;

class BasinRepository extends AppBaseRepository implements RepositoriesContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(Basin::class)->setRepositoryId('rinvex.repository.uniqueid');
    }
}