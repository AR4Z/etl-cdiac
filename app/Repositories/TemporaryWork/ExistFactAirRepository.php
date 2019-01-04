<?php

namespace App\Repositories\TemporaryWork;

use App\Repositories\AppGeneralRepositoryBaseTrait;
use Illuminate\Container\Container;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\TemporaryWork\ExistFactAir;

class ExistFactAirRepository extends EloquentRepository implements ExistRepositoryContract
{
    use AppGeneralRepositoryBaseTrait;

    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(ExistFactAir::class)->setRepositoryId('rinvex.repository.uniqueid');
    }
}