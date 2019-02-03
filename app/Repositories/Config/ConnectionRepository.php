<?php

namespace App\Repositories\Config;

use App\Repositories\AppBaseRepository;
use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use App\Entities\Config\Connection;

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
     * @param string $connectionName
     * @return mixed
     */
    public function getName(string $connectionName)
    {
        return $this->where('name', $connectionName)->first();
    }
}
