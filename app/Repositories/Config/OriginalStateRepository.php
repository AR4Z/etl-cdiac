<?php

namespace App\Repositories\Config;

use App\Repositories\AppBaseRepository;
use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use App\Entities\Config\OriginalState;

class OriginalStateRepository extends AppBaseRepository implements RepositoriesContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(OriginalState::class)->setRepositoryId('rinvex.repository.uniqueid');
    }
}
