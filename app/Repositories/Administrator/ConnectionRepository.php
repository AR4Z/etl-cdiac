<?php

namespace App\Repositories\Administrator;

use App\Repositories\AppBaseRepository;
use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use App\Entities\Administrator\Connection;

class ConnectionRepository extends AppBaseRepository implements RepositoriesContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(Connection::class)->setRepositoryId('rinvex.repository.uniqueid');
    }

    /**
     * @param array $variables
     * @return Collection
     */
    public function getStationsNotIn(array $variables) : Collection
    {
        return $this->select('*')->whereNotIn('id',$variables)->get();
    }

    /**
     * @return Collection
     */
    public function searchEtlActive() : Collection
    {
        return $this->select('*')->where('etl_active',true)->get();
    }
}