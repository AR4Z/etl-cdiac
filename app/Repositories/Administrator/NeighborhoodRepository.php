<?php


namespace App\Repositories\Administrator;

use App\Entities\Administrator\Neighborhood;
use App\Repositories\AppBaseRepository;
use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;

class NeighborhoodRepository extends AppBaseRepository implements RepositoriesContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(Neighborhood::class)->setRepositoryId('rinvex.repository.uniqueid');
    }
}