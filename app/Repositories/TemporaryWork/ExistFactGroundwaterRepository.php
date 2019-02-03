<?php

namespace App\Repositories\TemporaryWork;

use Illuminate\Container\Container;
use App\Entities\TemporaryWork\ExistFactGroundwater;

class ExistFactGroundwaterRepository extends ExistFactBaseRepository implements ExistRepositoryContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(ExistFactGroundwater::class)->setRepositoryId('rinvex.repository.uniqueid');
    }
}