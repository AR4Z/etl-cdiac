<?php

namespace App\Repositories\Administrator;

use App\Repositories\AppBaseRepository;
use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use App\Entities\Administrator\Activity;

class ActivityRepository extends AppBaseRepository implements RepositoriesContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(Activity::class)->setRepositoryId('rinvex.repository.uniqueid');
    }
}