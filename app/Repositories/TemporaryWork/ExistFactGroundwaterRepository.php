<?php

namespace App\Repositories\TemporaryWork;

use App\Repositories\AppGeneralRepositoryBaseTrait;
use Illuminate\Container\Container;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\TemporaryWork\ExistFactGroundwater;

class ExistFactGroundwaterRepository extends EloquentRepository implements ExistRepositoryContract
{
    use AppGeneralRepositoryBaseTrait;

    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(ExistFactGroundwater::class)->setRepositoryId('rinvex.repository.uniqueid');
    }
}